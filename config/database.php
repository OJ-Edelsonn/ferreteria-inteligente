<?php

declare(strict_types=1);

$localConfig = __DIR__ . '/config.php';

if (file_exists($localConfig)) {
    require_once $localConfig;
} else {
    require_once __DIR__ . '/config.example.php';
}

function getConnection(): PDO
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

