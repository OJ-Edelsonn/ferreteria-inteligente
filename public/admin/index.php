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

$metrics = [
    'productos' => $productModel->countActive(),
    'stock_bajo' => $productModel->countLowStock(),
    'busquedas' => $reportModel->totalSearches(),
    'vistas' => $reportModel->totalProductViews(),
];
$topSearches = $reportModel->topSearches(5);
$topProducts = $reportModel->topViewedProducts(5);
$withoutResults = $reportModel->searchesWithoutResultsList(5);
$interactionsByDay = $reportModel->interactionsByDay(14);
$interactionsByType = $reportModel->interactionsByType();

$dailyLabels = array_map(fn(array $row): string => date('d/m', strtotime((string) $row['dia'])), $interactionsByDay);
$dailyData = array_map(fn(array $row): int => (int) $row['total'], $interactionsByDay);
$typeLabels = array_map(fn(array $row): string => (string) $row['tipo_interaccion'], $interactionsByType);
$typeData = array_map(fn(array $row): int => (int) $row['total'], $interactionsByType);

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
