<?php

declare(strict_types=1);

$localConfig = __DIR__ . '/config.php';

if (file_exists($localConfig)) {
    require_once $localConfig;
} else {
    require_once __DIR__ . '/config.example.php';
}

defined('BUSINESS_NAME') || define('BUSINESS_NAME', 'J&S Ferretería');
defined('BUSINESS_LOCATION') || define('BUSINESS_LOCATION', 'Quiparacra - Pasco');
defined('BUSINESS_ADDRESS') || define('BUSINESS_ADDRESS', 'Calle San Cristóbal S/N - Quiparacra - Huachón - Pasco');
defined('BUSINESS_WHATSAPP') || define('BUSINESS_WHATSAPP', '51900749742');
defined('BUSINESS_HOURS') || define('BUSINESS_HOURS', 'Lunes a sábado: 7:00am - 7:00pm');
defined('BUSINESS_DELIVERY_AREA') || define('BUSINESS_DELIVERY_AREA', 'Quiparacra y alrededores');

function getConnection(): PDO
{
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
