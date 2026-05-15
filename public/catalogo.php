<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/ProductModel.php';
require_once __DIR__ . '/../app/Models/InteractionModel.php';

$categoryId = isset($_GET['categoria']) && ctype_digit((string) $_GET['categoria'])
    ? (int) $_GET['categoria']
    : null;
$searchTerm = trim((string) ($_GET['buscar'] ?? ''));

$productos = [];
$categorias = [];
$dbOk = true;
$error = null;

try {
    $conn = getConnection();
    $productModel = new ProductModel($conn);
    $interactionModel = new InteractionModel($conn);

    $categorias = $productModel->getCategories();
    $productos = $productModel->search($categoryId, $searchTerm);

    if ($searchTerm !== '') {
        $interactionModel->registerSearch($searchTerm, count($productos));
    }
} catch (Throwable $exception) {
    $dbOk = false;
    $error = $exception->getMessage();
}

$pageTitle = 'Catalogo - ' . BUSINESS_NAME;
$activePage = 'catalogo';
require_once __DIR__ . '/../app/Views/partials/header.php';

?>
    <main>
        <section class="catalog-header">
            <div class="container">
                <p class="eyebrow"><?= e(BUSINESS_NAME) ?> - <?= e(BUSINESS_LOCATION) ?></p>
                <div class="row g-3 align-items-end">
                    <div class="col-lg-7">
                        <h1>Productos disponibles</h1>
                        <p class="lead mb-0">Busca productos y convierte cada consulta en datos utiles para mejorar el catalogo de la ferreteria.</p>
                    </div>
                    <div class="col-lg-5">
                        <form class="search-box" method="get" action="catalogo.php">
                            <?php if ($categoryId !== null): ?>
                                <input type="hidden" name="categoria" value="<?= e($categoryId) ?>">
                            <?php endif; ?>
                            <label class="form-label" for="buscar">Buscar producto</label>
                            <div class="input-group">
                                <input class="form-control" id="buscar" name="buscar" type="search" value="<?= e($searchTerm) ?>" placeholder="Ejemplo: cemento, foco, brocha">
                                <button class="btn btn-danger" type="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4 border-bottom">
            <div class="container">
                <div class="category-strip">
                    <a class="category-chip <?= $categoryId === null ? 'selected' : '' ?>" href="catalogo.php<?= $searchTerm !== '' ? '?buscar=' . urlencode($searchTerm) : '' ?>">Todos</a>
                    <?php foreach ($categorias as $categoria): ?>
                        <?php
                        $categoryUrl = 'catalogo.php?categoria=' . urlencode((string) $categoria['id']);
                        if ($searchTerm !== '') {
                            $categoryUrl .= '&buscar=' . urlencode($searchTerm);
                        }
                        ?>
                        <a class="category-chip <?= $categoryId === (int) $categoria['id'] ? 'selected' : '' ?>" href="<?= e($categoryUrl) ?>">
                            <?= e($categoria['nombre']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <?php if (!$dbOk): ?>
                    <div class="alert alert-warning">
                        No se pudo consultar la base de datos.
                        <br>
                        <small><?= e($error) ?></small>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                    <p class="text-secondary mb-0">
                        <?= e(count($productos)) ?> producto(s) encontrado(s)
                    </p>
                    <?php if ($searchTerm !== '' || $categoryId !== null): ?>
                        <a class="btn btn-sm btn-outline-secondary" href="catalogo.php">Limpiar filtros</a>
                    <?php endif; ?>
                </div>

                <?php if ($dbOk && empty($productos)): ?>
                    <div class="empty-state">
                        <strong>No encontramos productos con ese criterio.</strong>
                        <span>Este dato tambien es valioso: ayuda a saber que busca el cliente y que podria faltar en catalogo.</span>
                    </div>
                <?php endif; ?>

                <div class="row g-3">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="product-card catalog-card">
                                <div class="product-thumb">
                                    <?= e(strtoupper(substr($producto['nombre'], 0, 1))) ?>
                                </div>
                                <span class="badge text-bg-light"><?= e($producto['categoria']) ?></span>
                                <h3><?= e($producto['nombre']) ?></h3>
                                <p><?= e($producto['descripcion'] ?? 'Producto de ferreteria') ?></p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <strong>S/ <?= e(number_format((float) $producto['precio'], 2)) ?></strong>
                                    <small>Stock: <?= e((int) $producto['stock']) ?></small>
                                </div>
                                <a class="btn btn-outline-dark w-100" href="<?= e(BASE_URL) ?>/producto.php?id=<?= e($producto['id']) ?>">Ver detalle</a>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
<?php require_once __DIR__ . '/../app/Views/partials/footer.php'; ?>
