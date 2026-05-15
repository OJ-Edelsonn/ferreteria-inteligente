<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Support/auth.php';

logoutAdmin();

header('Location: ' . BASE_URL . '/admin/login.php');
exit;

