<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/ProductModel.php';

$productModel = new ProductModel(getConnection());
$products = $productModel->search();
$categories = $productModel->getCategories();
$productsForJs = array_map(static fn(array $product): array => [
    'id' => (int) $product['id'],
    'nombre' => $product['nombre'],
    'categoria' => $product['categoria'],
    'precio' => (float) $product['precio'],
    'stock' => (int) $product['stock'],
    'imagen' => $product['imagen'],
], $products);

$pageTitle = 'Cotizador - ' . BUSINESS_NAME;
$activePage = 'cotizador';
require_once __DIR__ . '/../app/Views/partials/header.php';

?>
    <main>
        <section class="catalog-header">
            <div class="container">
                <p class="eyebrow">Cotizador de materiales</p>
                <div class="row g-4 align-items-end">
                    <div class="col-lg-7">
                        <h1>Arma una cotizacion antes de comprar.</h1>
                        <p class="lead mb-0">Selecciona productos, calcula un total estimado y envia el pedido por WhatsApp para confirmar disponibilidad.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="metric-panel">
                            <span>Catalogo disponible</span>
                            <strong><?= e(count($products)) ?></strong>
                            <p>Productos activos listos para cotizar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="quote-shell">
            <div class="container">
                <div class="quote-layout">
                    <section class="quote-picker">
                        <div class="quote-tools">
                            <div>
                                <label class="form-label" for="quoteSearch">Buscar producto</label>
                                <input class="form-control" id="quoteSearch" type="search" placeholder="Cemento, foco, tubo PVC...">
                            </div>
                            <div>
                                <label class="form-label" for="quoteCategory">Categoria</label>
                                <select class="form-select" id="quoteCategory">
                                    <option value="">Todas</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= e($category['nombre']) ?>"><?= e($category['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="quote-product-list" id="quoteProductList">
                            <?php foreach ($products as $product): ?>
                                <article class="quote-product" data-id="<?= e($product['id']) ?>" data-name="<?= e(strtolower($product['nombre'])) ?>" data-category="<?= e($product['categoria']) ?>">
                                    <?php if (!empty($product['imagen'])): ?>
                                        <img src="<?= e(BASE_URL) ?>/assets/img/productos/<?= e($product['imagen']) ?>" alt="<?= e($product['nombre']) ?>">
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= e($product['nombre']) ?></strong>
                                        <span><?= e($product['categoria']) ?> · Stock <?= e($product['stock']) ?></span>
                                    </div>
                                    <button class="btn btn-sm btn-outline-dark" type="button" data-add="<?= e($product['id']) ?>">Agregar</button>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <aside class="quote-summary">
                        <h2>Tu cotizacion</h2>
                        <div id="quoteItems" class="quote-items">
                            <p class="text-secondary mb-0">Agrega productos para calcular un total estimado.</p>
                        </div>
                        <div class="quote-total">
                            <span>Total estimado</span>
                            <strong>S/ <span id="quoteTotal">0.00</span></strong>
                        </div>

                        <form id="quoteForm" class="quote-form">
                            <div>
                                <label class="form-label" for="clientName">Nombre</label>
                                <input class="form-control" id="clientName" required placeholder="Tu nombre">
                            </div>
                            <div>
                                <label class="form-label" for="clientPhone">Celular</label>
                                <input class="form-control" id="clientPhone" required placeholder="Ej: 987654321">
                            </div>
                            <div>
                                <label class="form-label" for="clientNote">Comentario</label>
                                <textarea class="form-control" id="clientNote" rows="3" placeholder="Lugar de entrega, fecha o detalle adicional"></textarea>
                            </div>
                            <button class="btn btn-danger w-100" type="submit">Enviar por WhatsApp</button>
                        </form>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <script>
        window.quoteProducts = <?= json_encode($productsForJs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        window.quoteWhatsapp = '<?= e(BUSINESS_WHATSAPP) ?>';
        window.preselectedProduct = <?= isset($_GET['producto']) && ctype_digit((string) $_GET['producto']) ? (int) $_GET['producto'] : 'null' ?>;
    </script>
<?php require_once __DIR__ . '/../app/Views/partials/footer.php'; ?>

