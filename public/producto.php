<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/ProductModel.php';
require_once __DIR__ . '/../app/Models/InteractionModel.php';

$productId = isset($_GET['id']) && ctype_digit((string) $_GET['id'])
    ? (int) $_GET['id']
    : 0;

$producto = null;
$dbOk = true;
$error = null;

try {
    $conn = getConnection();
    $productModel = new ProductModel($conn);
    $interactionModel = new InteractionModel($conn);

    if ($productId > 0) {
        $producto = $productModel->find($productId);

        if ($producto !== null) {
            $interactionModel->registerProductView($productId);
        }
    }
} catch (Throwable $exception) {
    $dbOk = false;
    $error = $exception->getMessage();
}

$pageTitle = ($producto['nombre'] ?? 'Producto') . ' - Ferreteria Inteligente';
$activePage = 'catalogo';
require_once __DIR__ . '/../app/Views/partials/header.php';

?>
    <main>
        <section class="py-5">
            <div class="container">
                <a class="btn btn-sm btn-outline-secondary mb-4" href="<?= e(BASE_URL) ?>/catalogo.php">Volver al catalogo</a>

                <?php if (!$dbOk): ?>
                    <div class="alert alert-warning">
                        No se pudo consultar la base de datos.
                        <br>
                        <small><?= e($error) ?></small>
                    </div>
                <?php elseif ($producto === null): ?>
                    <div class="empty-state">
                        <strong>Producto no encontrado.</strong>
                        <span>Puede que el producto no exista o este desactivado.</span>
                    </div>
                <?php else: ?>
                    <div class="row g-4 align-items-start">
                        <div class="col-lg-5">
                            <div class="product-detail-visual">
                                <?= e(strtoupper(substr($producto['nombre'], 0, 1))) ?>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <span class="badge text-bg-light mb-3"><?= e($producto['categoria']) ?></span>
                            <h1 class="detail-title"><?= e($producto['nombre']) ?></h1>
                            <p class="detail-description"><?= e($producto['descripcion'] ?? 'Producto de ferreteria') ?></p>

                            <div class="detail-panel">
                                <div>
                                    <span>Precio</span>
                                    <strong>S/ <?= e(number_format((float) $producto['precio'], 2)) ?></strong>
                                </div>
                                <div>
                                    <span>Stock disponible</span>
                                    <strong><?= e((int) $producto['stock']) ?></strong>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                Esta visita se registro como <strong>producto_visto</strong> en la tabla de interacciones.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
<?php require_once __DIR__ . '/../app/Views/partials/footer.php'; ?>

