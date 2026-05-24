<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Support/auth.php';
require_once __DIR__ . '/../../app/Models/ProductModel.php';
require_once __DIR__ . '/../../app/Models/InteractionReportModel.php';

requireAdmin();

$conn = getConnection();
$productModel = new ProductModel($conn);
$reportModel = new InteractionReportModel($conn);

$stockThreshold = 10;
$metrics = [
    'productos' => $productModel->countActive(),
    'stock_bajo' => $productModel->countLowStock($stockThreshold),
    'busquedas' => $reportModel->totalSearches(),
    'vistas' => $reportModel->totalProductViews(),
    'sin_resultados' => $reportModel->searchesWithoutResults(),
];
$topSearches = $reportModel->topSearches(5);
$topProducts = $reportModel->topViewedProducts(5);
$withoutResults = $reportModel->searchesWithoutResultsList(5);
$interactionsByDay = $reportModel->interactionsByDay(14);
$interactionsByType = $reportModel->interactionsByType();
$lowStockProducts = $productModel->lowStockProducts($stockThreshold, 6);
$inventoryByCategory = $productModel->inventoryByCategory(6);
$categoryInterest = $reportModel->categoryInterest(6);
$demandWithLowStock = $reportModel->topViewedLowStockProducts($stockThreshold, 5);

$dailyLabels = array_map(fn(array $row): string => date('d/m', strtotime((string) $row['dia'])), $interactionsByDay);
$dailyData = array_map(fn(array $row): int => (int) $row['total'], $interactionsByDay);
$typeLabels = array_map(fn(array $row): string => (string) $row['tipo_interaccion'], $interactionsByType);
$typeData = array_map(fn(array $row): int => (int) $row['total'], $interactionsByType);
$searchGapRate = $metrics['busquedas'] > 0
    ? (int) round(($metrics['sin_resultados'] / $metrics['busquedas']) * 100)
    : 0;
$topLowStockProduct = $lowStockProducts[0] ?? null;
$topDemandCategory = $categoryInterest[0] ?? null;
$maxCategoryInterest = !empty($categoryInterest)
    ? max(array_map(static fn(array $row): int => (int) $row['total'], $categoryInterest))
    : 0;

$pageTitle = 'Dashboard - ' . BUSINESS_NAME;
$pageHeading = 'Dashboard';
$activePage = 'dashboard';
require_once __DIR__ . '/../../app/Views/partials/admin-header.php';

?>
        <section class="admin-grid metrics-grid">
            <article class="admin-card metric-card">
                <span>Productos activos</span>
                <strong><?= e($metrics['productos']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Stock bajo</span>
                <strong><?= e($metrics['stock_bajo']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Búsquedas</span>
                <strong><?= e($metrics['busquedas']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Productos vistos</span>
                <strong><?= e($metrics['vistas']) ?></strong>
            </article>
        </section>

        <section class="admin-grid insight-grid mt-4">
            <article class="admin-card insight-card">
                <span>Reposición</span>
                <?php if ($topLowStockProduct): ?>
                    <strong><?= e($topLowStockProduct['nombre']) ?></strong>
                    <p>Quedan <?= e((int) $topLowStockProduct['stock']) ?> unidades. Es el producto más urgente dentro del umbral de stock bajo.</p>
                <?php else: ?>
                    <strong>Stock estable</strong>
                    <p>No hay productos activos con stock menor o igual a <?= e($stockThreshold) ?> unidades.</p>
                <?php endif; ?>
                <a href="<?= e(BASE_URL) ?>/admin/productos.php">Revisar productos</a>
            </article>

            <article class="admin-card insight-card">
                <span>Oportunidad de catálogo</span>
                <strong><?= e($searchGapRate) ?>%</strong>
                <p><?= e($metrics['sin_resultados']) ?> búsquedas no tuvieron resultados. Conviene revisar nombres, sinónimos o productos faltantes.</p>
                <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Ver búsquedas</a>
            </article>

            <article class="admin-card insight-card">
                <span>Demanda observada</span>
                <?php if ($topDemandCategory): ?>
                    <strong><?= e($topDemandCategory['categoria']) ?></strong>
                    <p>Es la categoría con más vistas registradas: <?= e((int) $topDemandCategory['total']) ?> interacciones.</p>
                <?php else: ?>
                    <strong>Sin tendencia aún</strong>
                    <p>Cuando los clientes vean productos, aquí aparecerá la categoría con mayor interés.</p>
                <?php endif; ?>
                <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Ver interacciones</a>
            </article>
        </section>

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card chart-card">
                <div class="section-heading">
                    <h2>Actividad reciente</h2>
                    <span>Últimos 14 días</span>
                </div>
                <?php if (empty($dailyLabels)): ?>
                    <p class="text-secondary mb-0">Aún no hay datos suficientes para graficar.</p>
                <?php else: ?>
                    <canvas id="activityChart" height="180"></canvas>
                <?php endif; ?>
            </article>

            <article class="admin-card chart-card">
                <div class="section-heading">
                    <h2>Tipos de interacción</h2>
                    <span>Distribución</span>
                </div>
                <?php if (empty($typeLabels)): ?>
                    <p class="text-secondary mb-0">Aún no hay interacciones registradas.</p>
                <?php else: ?>
                    <canvas id="typeChart" height="180"></canvas>
                <?php endif; ?>
            </article>
        </section>

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card">
                <div class="section-heading">
                    <h2>Stock bajo</h2>
                    <span><?= e($stockThreshold) ?> unidades o menos</span>
                </div>
                <?php if (empty($lowStockProducts)): ?>
                    <p class="text-secondary mb-0">No hay productos dentro del umbral de stock bajo.</p>
                <?php else: ?>
                    <div class="admin-action-list">
                        <?php foreach ($lowStockProducts as $product): ?>
                            <div class="admin-action-row">
                                <span>
                                    <strong><?= e($product['nombre']) ?></strong>
                                    <small><?= e($product['categoria']) ?> · Stock <?= e((int) $product['stock']) ?> · S/ <?= e(number_format((float) $product['precio'], 2)) ?></small>
                                </span>
                                <a class="btn btn-sm btn-outline-dark" href="<?= e(BASE_URL) ?>/admin/productos.php?editar=<?= e($product['id']) ?>">Editar</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <article class="admin-card">
                <div class="section-heading">
                    <h2>Demanda con stock bajo</h2>
                    <span>Prioridad comercial</span>
                </div>
                <?php if (empty($demandWithLowStock)): ?>
                    <p class="text-secondary mb-0">Aún no hay productos vistos que también tengan stock bajo.</p>
                <?php else: ?>
                    <div class="admin-action-list">
                        <?php foreach ($demandWithLowStock as $product): ?>
                            <div class="admin-action-row">
                                <span>
                                    <strong><?= e($product['nombre']) ?></strong>
                                    <small><?= e($product['categoria']) ?> · <?= e((int) $product['total']) ?> vistas · Stock <?= e((int) $product['stock']) ?></small>
                                </span>
                                <a class="btn btn-sm btn-outline-dark" href="<?= e(BASE_URL) ?>/admin/productos.php?editar=<?= e($product['id']) ?>">Editar</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        </section>

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card">
                <div class="section-heading">
                    <h2>Interés por categoría</h2>
                    <span>Según productos vistos</span>
                </div>
                <?php if (empty($categoryInterest)): ?>
                    <p class="text-secondary mb-0">Aún no hay vistas de productos para comparar categorías.</p>
                <?php else: ?>
                    <div class="bar-list">
                        <?php foreach ($categoryInterest as $row): ?>
                            <?php $barWidth = $maxCategoryInterest > 0 ? max(8, (int) round(((int) $row['total'] / $maxCategoryInterest) * 100)) : 0; ?>
                            <div class="bar-row">
                                <div class="bar-label">
                                    <span><?= e($row['categoria']) ?></span>
                                    <strong><?= e((int) $row['total']) ?> vistas</strong>
                                </div>
                                <div class="bar-track">
                                    <span style="width: <?= e($barWidth) ?>%"></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <article class="admin-card">
                <div class="section-heading">
                    <h2>Inventario por categoría</h2>
                    <span>Valor estimado</span>
                </div>
                <?php if (empty($inventoryByCategory)): ?>
                    <p class="text-secondary mb-0">No hay categorías con productos activos.</p>
                <?php else: ?>
                    <div class="admin-action-list">
                        <?php foreach ($inventoryByCategory as $row): ?>
                            <div class="admin-action-row">
                                <span>
                                    <strong><?= e($row['categoria']) ?></strong>
                                    <small><?= e((int) $row['productos']) ?> productos · <?= e((int) $row['unidades']) ?> unidades · <?= e((int) $row['stock_bajo']) ?> con stock bajo</small>
                                </span>
                                <strong>S/ <?= e(number_format((float) $row['valor_estimado'], 2)) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        </section>

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card">
                <div class="section-heading">
                    <h2>Búsquedas frecuentes</h2>
                    <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Ver todo</a>
                </div>
                <?php if (empty($topSearches)): ?>
                    <p class="text-secondary mb-0">Aún no hay búsquedas registradas.</p>
                <?php else: ?>
                    <div class="admin-list">
                        <?php foreach ($topSearches as $row): ?>
                            <div>
                                <span><?= e($row['termino_busqueda']) ?></span>
                                <strong><?= e($row['total']) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <article class="admin-card">
                <div class="section-heading">
                    <h2>Productos más vistos</h2>
                    <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Ver todo</a>
                </div>
                <?php if (empty($topProducts)): ?>
                    <p class="text-secondary mb-0">Aún no hay vistas registradas.</p>
                <?php else: ?>
                    <div class="admin-list">
                        <?php foreach ($topProducts as $row): ?>
                            <div>
                                <span><?= e($row['nombre']) ?></span>
                                <strong><?= e($row['total']) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        </section>

        <section class="admin-card mt-4">
            <div class="section-heading">
                <h2>Búsquedas sin resultados</h2>
                <span>Oportunidades para mejorar el catálogo</span>
            </div>
            <?php if (empty($withoutResults)): ?>
                <p class="text-secondary mb-0">Por ahora no hay búsquedas sin resultados.</p>
            <?php else: ?>
                <div class="admin-list">
                    <?php foreach ($withoutResults as $row): ?>
                        <div>
                            <span><?= e($row['termino_busqueda']) ?></span>
                            <strong><?= e($row['total']) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const dailyLabels = <?= json_encode($dailyLabels, JSON_UNESCAPED_UNICODE) ?>;
            const dailyData = <?= json_encode($dailyData, JSON_UNESCAPED_UNICODE) ?>;
            const typeLabels = <?= json_encode($typeLabels, JSON_UNESCAPED_UNICODE) ?>;
            const typeData = <?= json_encode($typeData, JSON_UNESCAPED_UNICODE) ?>;

            if (document.getElementById('activityChart')) {
                new Chart(document.getElementById('activityChart'), {
                    type: 'line',
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                            label: 'Interacciones',
                            data: dailyData,
                            borderColor: '#c0392b',
                            backgroundColor: 'rgba(192, 57, 43, 0.12)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0 } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            if (document.getElementById('typeChart')) {
                new Chart(document.getElementById('typeChart'), {
                    type: 'doughnut',
                    data: {
                        labels: typeLabels,
                        datasets: [{
                            data: typeData,
                            backgroundColor: ['#172033', '#c0392b', '#185fa5', '#27ae60'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            }
        </script>
<?php require_once __DIR__ . '/../../app/Views/partials/admin-footer.php'; ?>
