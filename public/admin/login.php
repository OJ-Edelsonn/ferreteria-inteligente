<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Support/helpers.php';
require_once __DIR__ . '/../../app/Support/auth.php';
require_once __DIR__ . '/../../app/Models/AdminUserModel.php';

if (currentAdmin() !== null) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!validateCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'La sesión expiró. Intenta nuevamente.';
    } elseif ($email === '' || $password === '') {
        $error = 'Ingresa correo y contraseña.';
    } else {
        $userModel = new AdminUserModel(getConnection());
        $admin = $userModel->authenticate($email, $password);

        if ($admin === null) {
            $error = 'Credenciales incorrectas.';
        } else {
            loginAdmin($admin);
            header('Location: ' . BASE_URL . '/admin/index.php');
            exit;
        }
    }
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login administrador - <?= e(BUSINESS_NAME) ?></title>
    <link rel="icon" type="image/png" href="<?= e(BASE_URL) ?>/assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(BASE_URL) ?>/assets/css/styles.css" rel="stylesheet">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-info">
            <p class="eyebrow">Panel privado</p>
            <h1>Gestiona <?= e(BUSINESS_NAME) ?> y convierte visitas en datos.</h1>
            <p>Desde aquí se administrará el catálogo de <?= e(BUSINESS_LOCATION) ?> y se revisarán las interacciones capturadas por el sitio.</p>
        </section>

        <section class="login-card">
            <h2>Iniciar sesión</h2>
            <p class="text-secondary">Acceso privado para el administrador del sistema.</p>

            <?php if ($error !== ''): ?>
                <div class="alert alert-danger py-2"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" class="vstack gap-3">
                <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

                <div>
                    <label class="form-label" for="email">Correo</label>
                    <input class="form-control" id="email" name="email" type="email" value="<?= e($email) ?>" required autofocus>
                </div>

                <div>
                    <label class="form-label" for="password">Contraseña</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>

                <button class="btn btn-danger w-100" type="submit">Entrar al panel</button>
                <a class="btn btn-outline-secondary w-100" href="<?= e(BASE_URL) ?>/index.php">Volver al sitio</a>
            </form>
        </section>
    </main>
</body>
</html>
