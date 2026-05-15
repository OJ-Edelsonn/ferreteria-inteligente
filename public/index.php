<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$productos = [];
$dbOk = true;
$error = null;

try {
    $conn = getConnection();
    $stmt = $conn->query(
        "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, c.nombre AS categoria
         FROM productos p
         INNER JOIN categorias c ON c.id = p.categoria_id
         WHERE p.activo = 1
         ORDER BY p.nombre ASC
         LIMIT 12"
    );
    $productos = $stmt->fetchAll();
} catch (Throwable $exception) {
    $dbOk = false;
    $error = $exception->getMessage();
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ferreteria Inteligente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Ferreteria Inteligente</a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-dark btn-sm" href="#">Catalogo</a>
                <a class="btn btn-danger btn-sm" href="#">Admin</a>
            </div>
        </div>
    </nav>

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
                    </div>
                    <div class="col-lg-5">
                        <div class="metric-panel">
                            <span>Dato clave</span>
                            <strong>Interacciones</strong>
                            <p>Busquedas y productos vistos se guardaran para entender el comportamiento del cliente.</p>
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
                        <p class="text-secondary mb-0">Vista inicial conectada a MySQL cuando la base este importada.</p>
                    </div>
                </div>

                <?php if (!$dbOk): ?>
                    <div class="alert alert-warning">
                        La aplicacion esta lista, pero falta importar la base de datos o revisar la conexion.
                        <br>
                        <small><?= htmlspecialchars($error ?? '') ?></small>
                    </div>
                <?php endif; ?>

                <div class="row g-3">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-6 col-lg-4">
                            <article class="product-card">
                                <span class="badge text-bg-light"><?= htmlspecialchars($producto['categoria']) ?></span>
                                <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                                <p><?= htmlspecialchars($producto['descripcion'] ?? 'Producto de ferreteria') ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>S/ <?= number_format((float) $producto['precio'], 2) ?></strong>
                                    <small>Stock: <?= (int) $producto['stock'] ?></small>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>

