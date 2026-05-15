<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Support/helpers.php';

$pageTitle = $pageTitle ?? APP_NAME;
$activePage = $activePage ?? '';

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(BASE_URL) ?>/assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= e(BASE_URL) ?>/index.php">Ferreteria Inteligente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <a class="nav-link <?= e(isActive($activePage, 'inicio')) ?>" href="<?= e(BASE_URL) ?>/index.php">Inicio</a>
                    <a class="btn btn-sm <?= $activePage === 'catalogo' ? 'btn-dark' : 'btn-outline-dark' ?>" href="<?= e(BASE_URL) ?>/catalogo.php">Catalogo</a>
                    <a class="btn btn-danger btn-sm" href="<?= e(BASE_URL) ?>/admin/login.php">Admin</a>
                </div>
            </div>
        </div>
    </nav>
