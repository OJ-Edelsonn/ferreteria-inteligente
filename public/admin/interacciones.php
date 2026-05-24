<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Support/auth.php';
require_once __DIR__ . '/../../app/Models/InteractionReportModel.php';

requireAdmin();

$reportModel = new InteractionReportModel(getConnection());

$typeFilter = (string) ($_GET['tipo'] ?? '');
if (!in_array($typeFilter, ['', 'busqueda', 'producto_visto'], true)) {
    $typeFilter = '';
}
$resultFilter = (string) ($_GET['resultado'] ?? '');
if (!in_array($resultFilter, ['', 'sin_resultados', 'con_resultados'], true)) {
    $resultFilter = '';
}
$searchTerm = trim((string) ($_GET['buscar'] ?? ''));
$typeLabels = [
    'busqueda' => 'Búsqueda',
    'producto_visto' => 'Producto visto',
];
$resultLabels = [
    '' => 'Todos los resultados',
    'sin_resultados' => 'Sin resultados',
    'con_resultados' => 'Con resultados',
];

$metrics = [
    'total' => $reportModel->totalInteractions(),
    'busquedas' => $reportModel->totalSearches(),
    'vistas' => $reportModel->totalProductViews(),
    'sin_resultados' => $reportModel->searchesWithoutResults(),
];
$topSearches = $reportModel->topSearches();
$topProducts = $reportModel->topViewedProducts();
$searchSummary = $reportModel->searchesWithResultSummary();
$recent = $reportModel->filteredRecent($typeFilter, $resultFilter, $searchTerm);
$searchGapRate = $metrics['busquedas'] > 0
    ? (int) round(($metrics['sin_resultados'] / $metrics['busquedas']) * 100)
    : 0;

$pageTitle = 'Interacciones - ' . BUSINESS_NAME;
$pageHeading = 'Interacciones';
$activePage = 'interacciones';
require_once __DIR__ . '/../../app/Views/partials/admin-header.php';

?>
        <section class="admin-grid metrics-grid">
            <article class="admin-card metric-card">
                <span>Total interacciones</span>
                <strong><?= e($metrics['total']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Búsquedas</span>
                <strong><?= e($metrics['busquedas']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Productos vistos</span>
                <strong><?= e($metrics['vistas']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Sin resultados</span>
                <strong><?= e($metrics['sin_resultados']) ?></strong>
            </article>
        </section>

        <section class="admin-grid insight-grid mt-4">
            <article class="admin-card insight-card">
                <span>Calidad del catálogo</span>
                <strong><?= e($searchGapRate) ?>%</strong>
                <p>Porcentaje de búsquedas que no encontraron productos. Úsalo para detectar nombres alternativos o productos faltantes.</p>
                <a href="<?= e(BASE_URL) ?>/admin/interacciones.php?tipo=busqueda&resultado=sin_resultados">Ver sin resultados</a>
            </article>
            <article class="admin-card insight-card">
                <span>Interés comercial</span>
                <?php if (!empty($topProducts)): ?>
                    <strong><?= e($topProducts[0]['nombre']) ?></strong>
                    <p>Producto más visto hasta ahora, con <?= e((int) $topProducts[0]['total']) ?> visitas registradas.</p>
                    <a href="<?= e(BASE_URL) ?>/producto.php?id=<?= e($topProducts[0]['id']) ?>" target="_blank" rel="noopener">Abrir producto</a>
                <?php else: ?>
                    <strong>Sin vistas aún</strong>
                    <p>Cuando los clientes abran productos, aquí aparecerá el más consultado.</p>
                    <a href="<?= e(BASE_URL) ?>/admin/productos.php">Revisar productos</a>
                <?php endif; ?>
            </article>
            <article class="admin-card insight-card">
                <span>Seguimiento</span>
                <strong><?= e(count($recent)) ?></strong>
                <p>Interacciones visibles con los filtros actuales. Puedes aislar búsquedas, vistas o términos específicos.</p>
                <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Limpiar filtros</a>
            </article>
        </section>

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card">
                <h2>Top búsquedas</h2>
                <?php if (empty($topSearches)): ?>
                    <p class="text-secondary mb-0">Aún no hay búsquedas.</p>
                <?php else: ?>
                    <div class="admin-list">
                        <?php foreach ($topSearches as $row): ?>
                            <div>
                                <span><?= e($row['termino_busqueda']) ?></span>
                                <strong><?= e((int) $row['total']) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <article class="admin-card">
                <h2>Top productos vistos</h2>
                <?php if (empty($topProducts)): ?>
                    <p class="text-secondary mb-0">Aún no hay productos vistos.</p>
                <?php else: ?>
                    <div class="admin-list">
                        <?php foreach ($topProducts as $row): ?>
                            <div>
                                <span><?= e($row['nombre']) ?></span>
                                <strong><?= e((int) $row['total']) ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        </section>

        <section class="admin-card mt-4">
            <div class="section-heading">
                <h2>Búsquedas para revisar</h2>
                <span>Prioriza términos sin resultado</span>
            </div>
            <?php if (empty($searchSummary)): ?>
                <p class="text-secondary mb-0">Aún no hay búsquedas para analizar.</p>
            <?php else: ?>
                <div class="admin-action-list">
                    <?php foreach ($searchSummary as $row): ?>
                        <div class="admin-action-row">
                            <span>
                                <strong><?= e($row['termino_busqueda']) ?></strong>
                                <small><?= e((int) $row['total']) ?> búsquedas · <?= e((int) $row['sin_resultados']) ?> sin resultados</small>
                            </span>
                            <a class="btn btn-sm btn-outline-dark" href="<?= e(BASE_URL) ?>/catalogo.php?buscar=<?= e(urlencode((string) $row['termino_busqueda'])) ?>" target="_blank" rel="noopener">Probar en catálogo</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="admin-card mt-4">
            <div class="section-heading">
                <h2>Actividad reciente</h2>
                <span><?= e(count($recent)) ?> registros</span>
            </div>

            <form class="admin-filter-bar" method="get">
                <div>
                    <label class="form-label" for="tipo">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="" <?= $typeFilter === '' ? 'selected' : '' ?>>Todos</option>
                        <option value="busqueda" <?= $typeFilter === 'busqueda' ? 'selected' : '' ?>>Búsquedas</option>
                        <option value="producto_visto" <?= $typeFilter === 'producto_visto' ? 'selected' : '' ?>>Productos vistos</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="resultado">Resultado</label>
                    <select class="form-select" id="resultado" name="resultado">
                        <?php foreach ($resultLabels as $value => $label): ?>
                            <option value="<?= e($value) ?>" <?= $resultFilter === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="buscar">Buscar detalle</label>
                    <input class="form-control" id="buscar" name="buscar" value="<?= e($searchTerm) ?>" placeholder="cemento, pintura, tubo...">
                </div>
                <div class="admin-filter-actions">
                    <button class="btn btn-dark" type="submit">Filtrar</button>
                    <a class="btn btn-outline-secondary" href="<?= e(BASE_URL) ?>/admin/interacciones.php">Limpiar</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle admin-table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Detalle</th>
                            <th>Resultados</th>
                            <th>IP</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent)): ?>
                            <tr>
                                <td colspan="5" class="text-secondary">No hay interacciones con los filtros actuales.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent as $row): ?>
                                <?php
                                $isSearch = $row['tipo_interaccion'] === 'busqueda';
                                $hasNoResults = $isSearch && (int) ($row['resultados'] ?? 0) === 0;
                                $detail = $isSearch ? ($row['termino_busqueda'] ?? '-') : ($row['producto'] ?? '-');
                                ?>
                                <tr>
                                    <td>
                                        <span class="interaction-badge <?= $isSearch ? 'is-search' : 'is-view' ?>">
                                            <?= e($typeLabels[$row['tipo_interaccion']] ?? $row['tipo_interaccion']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= e($detail) ?></strong>
                                        <?php if ($isSearch): ?>
                                            <small>Término consultado por el visitante</small>
                                            <?php if ($hasNoResults): ?>
                                                <a class="admin-inline-link" href="<?= e(BASE_URL) ?>/catalogo.php?buscar=<?= e(urlencode((string) $detail)) ?>" target="_blank" rel="noopener">Probar búsqueda</a>
                                            <?php endif; ?>
                                        <?php elseif (!empty($row['producto_id'])): ?>
                                            <small>Producto abierto desde el catálogo</small>
                                            <a class="admin-inline-link" href="<?= e(BASE_URL) ?>/producto.php?id=<?= e($row['producto_id']) ?>" target="_blank" rel="noopener">Ver producto</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($isSearch): ?>
                                            <span class="result-badge <?= $hasNoResults ? 'is-empty' : 'is-found' ?>">
                                                <?= $hasNoResults ? 'Sin resultados' : e((int) $row['resultados'] . ' resultado(s)') ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= e($row['ip'] ?? '-') ?></td>
                                    <td><?= e(date('d/m/Y H:i', strtotime((string) $row['fecha']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
<?php require_once __DIR__ . '/../../app/Views/partials/admin-footer.php'; ?>
