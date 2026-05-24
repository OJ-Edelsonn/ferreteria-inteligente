# J&S Ferretería Inteligente

Sistema web full stack para **J&S Ferretería**, ubicada en **Quiparacra - Pasco**, que combina catálogo de productos, administración e interacciones del cliente para análisis.

## Stack

- PHP
- MySQL/MariaDB
- HTML, CSS y Bootstrap
- JavaScript vanilla
- XAMPP para desarrollo local

## Objetivo

Construir un sistema funcional que muestre productos y capture datos de comportamiento como búsquedas y productos vistos.

## Estructura Inicial

```text
ferreteria-inteligente/
├── app/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── config/
├── database/
├── docs/
├── public/
│   └── assets/
│       ├── css/
│       ├── img/
│       └── js/
├── DOCUMENTO_MAESTRO.md
└── README.md
```

## Instalación Local

1. Copiar el proyecto en `C:\xampp\htdocs\ferreteria-inteligente`.
2. Abrir XAMPP.
3. Iniciar Apache y MySQL.
4. Crear una base de datos llamada `ferreteria_inteligente`.
5. Importar `database/schema.sql` desde phpMyAdmin.
6. Importar `database/seed_catalog.sql` para cargar el catálogo completo.
7. Copiar `config/config.example.php` como `config/config.php`.
8. Revisar credenciales locales en `config/config.php`.
9. Abrir `http://localhost/ferreteria-inteligente/public/`.

## URLs Locales

- Inicio: `http://localhost/ferreteria-inteligente/public/`
- Catálogo: `http://localhost/ferreteria-inteligente/public/catalogo.php`
- Servicios: `http://localhost/ferreteria-inteligente/public/servicios.php`
- Cotizador: `http://localhost/ferreteria-inteligente/public/cotizador.php`
- Detalle de producto: `http://localhost/ferreteria-inteligente/public/producto.php?id=1`
- Contacto: `http://localhost/ferreteria-inteligente/public/contacto.php`
- Login admin: `http://localhost/ferreteria-inteligente/public/admin/login.php`
- Dashboard admin: `http://localhost/ferreteria-inteligente/public/admin/index.php`

## Funcionalidades Implementadas

- Home pública conectada a MySQL.
- Home enriquecida con accesos rápidos, flujo de compra, resumen por categorías y productos destacados.
- Productos destacados calculados como cemento + los 5 productos activos de mayor precio.
- Catálogo de productos.
- Catálogo completo migrado desde FerreSystem: 87 productos activos con imagen referencial.
- Búsqueda por nombre, descripción o categoría.
- Filtro por categoría.
- Detalle de producto.
- Cotizador de materiales con cálculo de total estimado y envío por WhatsApp.
- Sección de servicios de obra para contactar al maestro albañil.
- Registro de búsquedas en `interacciones`.
- Registro de vistas de producto en `interacciones`.
- Página de contacto con WhatsApp y mapa embebido de Google Maps.
- Favicon recuperado desde la web anterior.
- Login de administrador con sesión.
- Protección de rutas privadas.
- CRUD de productos desde panel admin.
- Dashboard con métricas y gráficos.
- Panel admin con alertas de stock bajo, demanda por categoría e inventario estimado.
- Vista admin de interacciones capturadas.

## Catálogo Migrado

El archivo `database/seed_catalog.sql` contiene los productos activos de la web anterior. Las imágenes referenciales se encuentran en:

`public/assets/img/productos/`

## Datos Del Negocio

- Nombre: `J&S Ferretería`
- Ubicación: `Quiparacra - Pasco`
- Dirección: `Calle San Cristóbal S/N - Quiparacra - Huachón - Pasco`
- WhatsApp: `900 749 742`
- Horario: `Lunes a sábado: 7:00am - 7:00pm`

## Credenciales Locales Iniciales

- Correo: `admin@ferreteria.test`
- Contraseña: `Admin12345`

Estas credenciales son solo para desarrollo local. En producción deben cambiarse.

## Flujo De Datos

1. El cliente abre el catálogo.
2. El sistema consulta productos activos en MySQL.
3. Si el cliente busca un término, se guarda una interacción de tipo `busqueda`.
4. Si el cliente abre un detalle, se guarda una interacción de tipo `producto_visto`.
5. Estos datos quedan disponibles para el futuro dashboard administrativo.

## Estado

Proyecto funcional en local con catálogo completo, panel administrativo, registro de interacciones, cotizador, servicios de obra, mapa de contacto y mejoras visuales en Inicio. La siguiente etapa es mejorar el panel admin con datos más útiles.
