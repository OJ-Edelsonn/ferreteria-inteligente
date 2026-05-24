<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Support/helpers.php';
require_once __DIR__ . '/../../Support/auth.php';

$pageTitle = $pageTitle ?? 'Panel administrador';
$activePage = $activePage ?? '';
$admin = currentAdmin();

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <link rel="icon" type="image/png" href="<?= e(BASE_URL) ?>/assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(BASE_URL) ?>/assets/css/styles.css" rel="stylesheet">
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <strong><?= e(BUSINESS_NAME) ?></strong>
            <span><?= e(BUSINESS_LOCATION) ?></span>
        </div>
        <nav class="admin-nav">
            <a class="<?= e(isActive($activePage, 'dashboard')) ?>" href="<?= e(BASE_URL) ?>/admin/index.php">Dashboard</a>
            <a class="<?= e(isActive($activePage, 'productos')) ?>" href="<?= e(BASE_URL) ?>/admin/productos.php">Productos</a>
            <a class="<?= e(isActive($activePage, 'interacciones')) ?>" href="<?= e(BASE_URL) ?>/admin/interacciones.php">Interacciones</a>
            <a href="<?= e(BASE_URL) ?>/index.php" target="_blank">Ver sitio</a>
        </nav>
        <div class="admin-user">
            <span><?= e($admin['nombre'] ?? 'Administrador') ?></span>
            <a href="<?= e(BASE_URL) ?>/admin/logout.php">Cerrar sesión</a>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <span class="eyebrow mb-1">Administrador</span>
                <h1><?= e($pageHeading ?? $pageTitle) ?></h1>
            </div>
        </header>
