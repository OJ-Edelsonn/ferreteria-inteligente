<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/ProductModel.php';

$productos = [];
$totalProductos = 0;
$dbOk = true;
$error = null;

try {
    $productModel = new ProductModel(getConnection());
    $productos = $productModel->getFeatured(6);
    $totalProductos = $productModel->countActive();
} catch (Throwable $exception) {
    $dbOk = false;
    $error = $exception->getMessage();
}

$pageTitle = 'Ferreteria Inteligente';
$activePage = 'inicio';
require_once __DIR__ . '/../app/Views/partials/header.php';

?>
    <main>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <p class="eyebrow">Proyecto 3 - Sistema web full stack</p>
                        <h1>Catalogo que tambien genera datos.</h1>
                        <p class="lead">
                            Una ferreteria digital con productos, busqueda, administracion e interacciones listas para analisis.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="btn btn-danger" href="<?= e(BASE_URL) ?>/catalogo.php">Explorar catalogo</a>
                            <a class="btn btn-outline-dark" href="#datos">Ver enfoque de datos</a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="metric-panel">
                            <span>Productos activos</span>
                            <strong><?= e($totalProductos) ?></strong>
                            <p>La siguiente fase usa cada busqueda y vista de producto como dato para analisis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">Primeros productos</h2>
                        <p class="text-secondary mb-0">Vista inicial conectada a MySQL.</p>
                    </div>
                    <a class="btn btn-sm btn-outline-dark" href="<?= e(BASE_URL) ?>/catalogo.php">Ver todo</a>
                </div>

                <?php if (!$dbOk): ?>
                    <div class="alert alert-warning">
                        La aplicacion esta lista, pero falta importar la base de datos o revisar la conexion.
                        <br>
                        <small><?= e($error) ?></small>
                    </div>
                <?php endif; ?>

                <div class="row g-3">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="product-card">
                                <span class="badge text-bg-light"><?= e($producto['categoria']) ?></span>
                                <h3><?= e($producto['nombre']) ?></h3>
                                <p><?= e($producto['descripcion'] ?? 'Producto de ferreteria') ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>S/ <?= e(number_format((float) $producto['precio'], 2)) ?></strong>
                                    <small>Stock: <?= e((int) $producto['stock']) ?></small>
                                </div>
                                <a class="stretched-link" href="<?= e(BASE_URL) ?>/producto.php?id=<?= e($producto['id']) ?>" aria-label="Ver <?= e($producto['nombre']) ?>"></a>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="data-section" id="datos">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <p class="eyebrow">Diferenciador</p>
                        <h2>El catalogo se convierte en fuente de datos.</h2>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="data-tile">
                                    <strong>Busquedas</strong>
                                    <span>Guardamos el termino buscado y cuantos resultados obtuvo.</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-tile">
                                    <strong>Producto visto</strong>
                                    <span>Registramos cada visita al detalle de un producto.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php require_once __DIR__ . '/../app/Views/partials/footer.php'; ?>

