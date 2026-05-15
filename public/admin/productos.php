<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Support/helpers.php';
require_once __DIR__ . '/../../app/Support/auth.php';
require_once __DIR__ . '/../../app/Models/ProductModel.php';

requireAdmin();

$conn = getConnection();
$productModel = new ProductModel($conn);

$message = '';
$error = '';
$editingProduct = null;

function productFormData(): array
{
    return [
        'categoria_id' => $_POST['categoria_id'] ?? '',
        'nombre' => trim((string) ($_POST['nombre'] ?? '')),
        'descripcion' => trim((string) ($_POST['descripcion'] ?? '')),
        'precio' => $_POST['precio'] ?? '',
        'stock' => $_POST['stock'] ?? '',
        'imagen' => trim((string) ($_POST['imagen'] ?? '')),
    ];
}

function validateProductData(array $data): array
{
    $errors = [];

    if (!ctype_digit((string) $data['categoria_id'])) {
        $errors[] = 'Selecciona una categoria valida.';
    }

    if ($data['nombre'] === '') {
        $errors[] = 'El nombre es obligatorio.';
    }

    if (!is_numeric($data['precio']) || (float) $data['precio'] < 0) {
        $errors[] = 'El precio debe ser un numero mayor o igual a cero.';
    }

    if (!ctype_digit((string) $data['stock'])) {
        $errors[] = 'El stock debe ser un numero entero mayor o igual a cero.';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if (!validateCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'La sesion expiro. Intenta nuevamente.';
    } elseif ($action === 'create' || $action === 'update') {
        $data = productFormData();
        $errors = validateProductData($data);

        if (!empty($errors)) {
            $error = implode(' ', $errors);
        } elseif ($action === 'create') {
            $productModel->create($data);
            $message = 'Producto creado correctamente.';
        } else {
            $productId = ctype_digit((string) ($_POST['producto_id'] ?? '')) ? (int) $_POST['producto_id'] : 0;

            if ($productId <= 0) {
                $error = 'Producto invalido.';
            } else {
                $productModel->update($productId, $data);
                $message = 'Producto actualizado correctamente.';
            }
        }
    } elseif ($action === 'delete') {
        $productId = ctype_digit((string) ($_POST['producto_id'] ?? '')) ? (int) $_POST['producto_id'] : 0;

        if ($productId <= 0) {
            $error = 'Producto invalido.';
        } else {
            $productModel->deactivate($productId);
            $message = 'Producto desactivado correctamente.';
        }
    }
}

if (isset($_GET['editar']) && ctype_digit((string) $_GET['editar'])) {
    $editingProduct = $productModel->find((int) $_GET['editar']);
}

$categoryId = isset($_GET['categoria']) && ctype_digit((string) $_GET['categoria'])
    ? (int) $_GET['categoria']
    : null;
$searchTerm = trim((string) ($_GET['buscar'] ?? ''));
$categories = $productModel->getCategories();
$products = $productModel->search($categoryId, $searchTerm);

$formProduct = [
    'id' => $editingProduct['id'] ?? '',
    'categoria_id' => $editingProduct['categoria_id'] ?? '',
    'nombre' => $editingProduct['nombre'] ?? '',
    'descripcion' => $editingProduct['descripcion'] ?? '',
    'precio' => $editingProduct['precio'] ?? '',
    'stock' => $editingProduct['stock'] ?? '',
    'imagen' => $editingProduct['imagen'] ?? '',
];

$pageTitle = 'Productos - ' . BUSINESS_NAME;
$pageHeading = 'Productos';
$activePage = 'productos';
require_once __DIR__ . '/../../app/Views/partials/admin-header.php';

?>
        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= e($message) ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <section class="admin-grid two-columns align-start">
            <article class="admin-card">
                <h2><?= $editingProduct ? 'Editar producto' : 'Crear producto' ?></h2>
                <form method="post" class="vstack gap-3">
                    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                    <input type="hidden" name="action" value="<?= $editingProduct ? 'update' : 'create' ?>">
                    <?php if ($editingProduct): ?>
                        <input type="hidden" name="producto_id" value="<?= e($formProduct['id']) ?>">
                    <?php endif; ?>

                    <div>
                        <label class="form-label" for="nombre">Nombre</label>
                        <input class="form-control" id="nombre" name="nombre" value="<?= e($formProduct['nombre']) ?>" required>
                    </div>

                    <div>
                        <label class="form-label" for="categoria_id">Categoria</label>
                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= e($category['id']) ?>" <?= (int) $formProduct['categoria_id'] === (int) $category['id'] ? 'selected' : '' ?>>
                                    <?= e($category['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="form-label" for="descripcion">Descripcion</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= e($formProduct['descripcion']) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="precio">Precio</label>
                            <input class="form-control" id="precio" name="precio" type="number" min="0" step="0.01" value="<?= e($formProduct['precio']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="stock">Stock</label>
                            <input class="form-control" id="stock" name="stock" type="number" min="0" step="1" value="<?= e($formProduct['stock']) ?>" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label" for="imagen">Imagen</label>
                        <input class="form-control" id="imagen" name="imagen" value="<?= e($formProduct['imagen']) ?>" placeholder="nombre-archivo.webp">
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-danger" type="submit"><?= $editingProduct ? 'Guardar cambios' : 'Crear producto' ?></button>
                        <?php if ($editingProduct): ?>
                            <a class="btn btn-outline-secondary" href="<?= e(BASE_URL) ?>/admin/productos.php">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </article>

            <article class="admin-card">
                <h2>Filtrar catalogo</h2>
                <form method="get" class="vstack gap-3">
                    <div>
                        <label class="form-label" for="buscar">Buscar</label>
                        <input class="form-control" id="buscar" name="buscar" value="<?= e($searchTerm) ?>" placeholder="Nombre, descripcion o categoria">
                    </div>
                    <div>
                        <label class="form-label" for="categoria">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= e($category['id']) ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>>
                                    <?= e($category['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-dark" type="submit">Filtrar</button>
                        <a class="btn btn-outline-secondary" href="<?= e(BASE_URL) ?>/admin/productos.php">Limpiar</a>
                    </div>
                </form>
            </article>
        </section>

        <section class="admin-card mt-4">
            <div class="section-heading">
                <h2>Productos registrados</h2>
                <span><?= e(count($products)) ?> producto(s)</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle admin-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <strong><?= e($product['nombre']) ?></strong>
                                    <small><?= e($product['descripcion'] ?? '') ?></small>
                                </td>
                                <td><?= e($product['categoria']) ?></td>
                                <td>S/ <?= e(number_format((float) $product['precio'], 2)) ?></td>
                                <td><?= e((int) $product['stock']) ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a class="btn btn-sm btn-outline-dark" href="<?= e(BASE_URL) ?>/admin/productos.php?editar=<?= e($product['id']) ?>">Editar</a>
                                        <form method="post" onsubmit="return confirm('Desactivar este producto?')">
                                            <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="producto_id" value="<?= e($product['id']) ?>">
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Desactivar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
<?php require_once __DIR__ . '/../../app/Views/partials/admin-footer.php'; ?>
