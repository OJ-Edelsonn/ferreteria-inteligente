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

$pageTitle = 'Dashboard administrador';
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
                <span>Busquedas</span>
                <strong><?= e($metrics['busquedas']) ?></strong>
            </article>
            <article class="admin-card metric-card">
                <span>Productos vistos</span>
                <strong><?= e($metrics['vistas']) ?></strong>
            </article>
        </section>

        <section class="admin-grid two-columns mt-4">
            <article class="admin-card">
                <div class="section-heading">
                    <h2>Busquedas frecuentes</h2>
                    <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Ver todo</a>
                </div>
                <?php if (empty($topSearches)): ?>
                    <p class="text-secondary mb-0">Aun no hay busquedas registradas.</p>
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
                    <h2>Productos mas vistos</h2>
                    <a href="<?= e(BASE_URL) ?>/admin/interacciones.php">Ver todo</a>
                </div>
                <?php if (empty($topProducts)): ?>
                    <p class="text-secondary mb-0">Aun no hay vistas registradas.</p>
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
<?php require_once __DIR__ . '/../../app/Views/partials/admin-footer.php'; ?>

