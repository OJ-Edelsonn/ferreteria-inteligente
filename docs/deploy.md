# Guia De Deploy

## Hosting Recomendado

InfinityFree para una demo gratuita de J&S Ferretería.

## Flujo General

1. Crear cuenta en InfinityFree.
2. Crear un sitio gratuito con subdominio.
3. Crear una base de datos MySQL desde el panel.
4. Importar `database/schema.sql` desde phpMyAdmin del hosting.
5. Importar `database/seed_catalog.sql` para cargar los 87 productos e imagenes referenciales.
6. Crear `config/config.php` con credenciales de produccion.
7. Subir archivos por FileZilla al directorio publico del hosting.
8. Probar URL final.

## Configuracion De Produccion

En el hosting se debe crear `config/config.php` con los datos reales del panel de InfinityFree.

Ejemplo:

```php
<?php

declare(strict_types=1);

const APP_NAME = 'J&S Ferretería Inteligente';
const APP_ENV = 'production';
const BASE_URL = 'https://tu-subdominio.infinityfreeapp.com/public';

const BUSINESS_NAME = 'J&S Ferretería';
const BUSINESS_LOCATION = 'Quiparacra - Pasco';
const BUSINESS_ADDRESS = 'Calle San Cristóbal S/N - Quiparacra - Huachón - Pasco';
const BUSINESS_WHATSAPP = '51900749742';
const BUSINESS_HOURS = 'Lunes a sábado: 7:00am - 7:00pm';
const BUSINESS_DELIVERY_AREA = 'Quiparacra y alrededores';

const DB_HOST = 'sqlXXX.infinityfree.com';
const DB_NAME = 'if0_XXXXXXX_ferreteria_inteligente';
const DB_USER = 'if0_XXXXXXX';
const DB_PASS = 'CONTRASENA_DEL_HOSTING';
const DB_CHARSET = 'utf8mb4';
```

## Subdominio Sugerido

- `jsferreteria.rf.gd`
- `jsferreteria.great-site.net`
- `ferreteriainteligente.rf.gd`

## Nota De Seguridad

No subir credenciales reales a GitHub. El archivo `config/config.php` esta ignorado por Git.
