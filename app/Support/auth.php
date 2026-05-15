<?php

declare(strict_types=1);

function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function currentAdmin(): ?array
{
    startSecureSession();

    return $_SESSION['admin'] ?? null;
}

function requireAdmin(): void
{
    if (currentAdmin() !== null) {
        return;
    }

    header('Location: ' . BASE_URL . '/admin/login.php');
    exit;
}

function loginAdmin(array $admin): void
{
    startSecureSession();
    session_regenerate_id(true);
    $_SESSION['admin'] = [
        'id' => (int) $admin['id'],
        'nombre' => $admin['nombre'],
        'email' => $admin['email'],
    ];
}

function logoutAdmin(): void
{
    startSecureSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

function csrfToken(): string
{
    startSecureSession();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validateCsrf(?string $token): bool
{
    startSecureSession();

    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

