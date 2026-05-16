<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/ProductModel.php';

$productos = [];
$categoriasResumen = [];
$totalProductos = 0;
$dbOk = true;
$error = null;

try {
    $productModel = new ProductModel(getConnection());
    $productos = $productModel->getFeatured(6);
    $categoriasResumen = $productModel->getCategorySummary();
    $totalProductos = $productModel->countActive();
} catch (Throwable $exception) {
    $dbOk = false;
    $error = $exception->getMessage();
}

$pageTitle = BUSINESS_NAME . ' - Catalogo inteligente';
$activePage = 'inicio';
require_once __DIR__ . '/../app/Views/partials/header.php';

?>
    <main>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <p class="eyebrow"><?= e(BUSINESS_LOCATION) ?></p>
                        <h1>Materiales, herramientas y apoyo para tu obra en Quiparacra.</h1>
                        <p class="lead">
                            Revisa productos disponibles, arma una cotizacion y contacta por WhatsApp a J&S Ferretería para confirmar precios, stock o servicios de obra.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="btn btn-danger" href="<?= e(BASE_URL) ?>/catalogo.php">Explorar catalogo</a>
                            <a class="btn btn-outline-dark" href="<?= e(BASE_URL) ?>/servicios.php">Servicios de obra</a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="metric-panel">
                            <span>Catalogo disponible</span>
                            <strong><?= e($totalProductos) ?> productos</strong>
                            <p>Materiales de construccion, herramientas, electricidad, pintura, gasfiteria y mas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="quick-actions-section">
            <div class="container">
                <div class="quick-actions-grid">
                    <a class="quick-action" href="<?= e(BASE_URL) ?>/catalogo.php">
                        <strong>Ver catalogo</strong>
                        <span>Explora todos los productos activos con imagen y precio.</span>
                    </a>
                    <a class="quick-action" href="<?= e(BASE_URL) ?>/cotizador.php">
                        <strong>Cotizar materiales</strong>
                        <span>Selecciona productos y envia tu lista por WhatsApp.</span>
                    </a>
                    <a class="quick-action" href="<?= e(BASE_URL) ?>/servicios.php">
                        <strong>Servicios de obra</strong>
                        <span>Consulta por construccion, remodelacion y acabados.</span>
                    </a>
                    <a class="quick-action" href="<?= e(BASE_URL) ?>/contacto.php">
                        <strong>Ubicacion y contacto</strong>
                        <span>Encuentra la ferreteria y escribe directamente.</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="purchase-flow-section">
            <div class="container">
                <div class="section-kicker">
                    <p class="eyebrow">Compra practica</p>
                    <h2>Avanza de la consulta a tu obra con menos vueltas.</h2>
                </div>
                <div class="purchase-flow-grid">
                    <div class="purchase-flow-item">
                        <span>01</span>
                        <strong>Busca por material</strong>
                        <p>Encuentra cemento, tubos, pinturas, herramientas y accesorios desde el catalogo completo.</p>
                    </div>
                    <div class="purchase-flow-item">
                        <span>02</span>
                        <strong>Arma tu cotizacion</strong>
                        <p>Selecciona productos, cantidades y envia tu lista para confirmar precio y disponibilidad.</p>
                    </div>
                    <div class="purchase-flow-item">
                        <span>03</span>
                        <strong>Coordina entrega o servicio</strong>
                        <p>Contacta a J&S Ferreteria para compras locales o apoyo de maestro albañil en tu obra.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">Productos destacados</h2>
                        <p class="text-secondary mb-0">Incluye cemento y productos de mayor precio para compras importantes.</p>
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
                                <?php if (!empty($producto['imagen'])): ?>
                                    <img class="product-card-image" src="<?= e(BASE_URL) ?>/assets/img/productos/<?= e($producto['imagen']) ?>" alt="<?= e($producto['nombre']) ?>">
                                <?php else: ?>
                                    <div class="product-thumb"><?= e(strtoupper(substr($producto['nombre'], 0, 1))) ?></div>
                                <?php endif; ?>
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

        <section class="category-overview-section">
            <div class="container">
                <div class="section-kicker">
                    <p class="eyebrow">Categorias</p>
                    <h2>Encuentra lo que necesitas por tipo de trabajo.</h2>
                </div>
                <div class="category-overview-grid">
                    <?php foreach ($categoriasResumen as $categoria): ?>
                        <a class="category-overview-card" href="<?= e(BASE_URL) ?>/catalogo.php?categoria=<?= e($categoria['id']) ?>">
                            <span><?= e($categoria['productos']) ?> productos</span>
                            <strong><?= e($categoria['nombre']) ?></strong>
                            <p><?= e($categoria['descripcion'] ?? 'Productos disponibles en catalogo') ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="service-preview-section">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7">
                        <p class="eyebrow">Servicio local</p>
                        <h2>Materiales y mano de obra en un solo lugar.</h2>
                        <p>J&S Ferretería tambien conecta al cliente con servicio de maestro albañil para construccion, remodelacion, instalaciones sanitarias, electricidad y acabados.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="service-action-card">
                            <strong>Presupuesto de obra</strong>
                            <span>El cliente puede solicitar una evaluacion por WhatsApp y acceder a precios especiales en materiales.</span>
                            <a class="btn btn-danger mt-3" href="<?= e(BASE_URL) ?>/servicios.php">Ver servicios</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="data-section" id="datos">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <p class="eyebrow">Diferenciador</p>
                        <h2>El catalogo se convierte en fuente de datos.</h2>
                        <p class="data-copy">Ademas de mostrar productos, el sistema registra que buscan y que miran los clientes para mejorar decisiones de inventario.</p>
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
