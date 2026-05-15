<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Support/auth.php';
require_once __DIR__ . '/../../app/Models/InteractionReportModel.php';

requireAdmin();

$reportModel = new InteractionReportModel(getConnection());

$metrics = [
    'total' => $reportModel->totalInteractions(),
    'busquedas' => $reportModel->totalSearches(),
    'vistas' => $reportModel->totalProductViews(),
    'sin_resultados' => $reportModel->searchesWithoutResults(),
];
$topSearches = $reportModel->topSearches();
$topProducts = $reportModel->topViewedProducts();
$recent = $reportModel->recent();

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
                <span>Busquedas</span>
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

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card">
                <h2>Top busquedas</h2>
                <?php if (empty($topSearches)): ?>
                    <p class="text-secondary mb-0">Aun no hay busquedas.</p>
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
                <h2>Top productos vistos</h2>
                <?php if (empty($topProducts)): ?>
                    <p class="text-secondary mb-0">Aun no hay productos vistos.</p>
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
                <h2>Actividad reciente</h2>
                <span>Ultimas <?= e(count($recent)) ?></span>
            </div>

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
                        <?php foreach ($recent as $row): ?>
                            <tr>
                                <td><span class="badge text-bg-light"><?= e($row['tipo_interaccion']) ?></span></td>
                                <td><?= e($row['producto'] ?? $row['termino_busqueda'] ?? '-') ?></td>
                                <td><?= e($row['resultados'] ?? '-') ?></td>
                                <td><?= e($row['ip'] ?? '-') ?></td>
                                <td><?= e($row['fecha']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
<?php require_once __DIR__ . '/../../app/Views/partials/admin-footer.php'; ?>
