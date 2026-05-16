# J&S Ferretería Inteligente

Sistema web full stack para **J&S Ferretería**, ubicada en **Quiparacra - Pasco**, que combina catalogo de productos, administracion e interacciones del cliente para analisis.

## Stack

- PHP
- MySQL/MariaDB
- HTML, CSS y Bootstrap
- JavaScript vanilla
- XAMPP para desarrollo local

## Objetivo

Construir un sistema funcional que muestre productos y capture datos de comportamiento como busquedas y productos vistos.

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

## Instalacion Local

1. Copiar el proyecto en `C:\xampp\htdocs\ferreteria-inteligente`.
2. Abrir XAMPP.
3. Iniciar Apache y MySQL.
4. Crear una base de datos llamada `ferreteria_inteligente`.
5. Importar `database/schema.sql` desde phpMyAdmin.
6. Importar `database/seed_catalog.sql` para cargar el catalogo completo.
7. Copiar `config/config.example.php` como `config/config.php`.
8. Revisar credenciales locales en `config/config.php`.
9. Abrir `http://localhost/ferreteria-inteligente/public/`.

## URLs Locales

- Inicio: `http://localhost/ferreteria-inteligente/public/`
- Catalogo: `http://localhost/ferreteria-inteligente/public/catalogo.php`
- Servicios: `http://localhost/ferreteria-inteligente/public/servicios.php`
- Cotizador: `http://localhost/ferreteria-inteligente/public/cotizador.php`
- Detalle de producto: `http://localhost/ferreteria-inteligente/public/producto.php?id=1`
- Contacto: `http://localhost/ferreteria-inteligente/public/contacto.php`
- Login admin: `http://localhost/ferreteria-inteligente/public/admin/login.php`
- Dashboard admin: `http://localhost/ferreteria-inteligente/public/admin/index.php`

## Funcionalidades Implementadas

- Home publica conectada a MySQL.
- Home enriquecida con accesos rapidos, flujo de compra, resumen por categorias y productos destacados.
- Productos destacados calculados como cemento + los 5 productos activos de mayor precio.
- Catalogo de productos.
- Catalogo completo migrado desde FerreSystem: 87 productos activos con imagen referencial.
- Busqueda por nombre, descripcion o categoria.
- Filtro por categoria.
- Detalle de producto.
- Cotizador de materiales con calculo de total estimado y envio por WhatsApp.
- Seccion de servicios de obra para contactar al maestro albañil.
- Registro de busquedas en `interacciones`.
- Registro de vistas de producto en `interacciones`.
- Pagina de contacto con WhatsApp y mapa embebido de Google Maps.
- Favicon recuperado desde la web anterior.
- Login de administrador con sesion.
- Proteccion de rutas privadas.
- CRUD de productos desde panel admin.
- Dashboard con metricas y graficos.
- Vista admin de interacciones capturadas.

## Catalogo Migrado

El archivo `database/seed_catalog.sql` contiene los productos activos de la web anterior. Las imagenes referenciales se encuentran en:

`public/assets/img/productos/`

## Datos Del Negocio

- Nombre: `J&S Ferretería`
- Ubicacion: `Quiparacra - Pasco`
- Direccion: `Calle San Cristóbal S/N - Quiparacra - Huachón - Pasco`
- WhatsApp: `900 749 742`
- Horario: `Lunes a sábado: 7:00am - 7:00pm`

## Credenciales Locales Iniciales

- Correo: `admin@ferreteria.test`
- Contrasena: `Admin12345`

Estas credenciales son solo para desarrollo local. En produccion deben cambiarse.

## Flujo De Datos

1. El cliente abre el catalogo.
2. El sistema consulta productos activos en MySQL.
3. Si el cliente busca un termino, se guarda una interaccion de tipo `busqueda`.
4. Si el cliente abre un detalle, se guarda una interaccion de tipo `producto_visto`.
5. Estos datos quedan disponibles para el futuro dashboard administrativo.

## Estado

Proyecto funcional en local con catalogo completo, panel administrativo, registro de interacciones, cotizador, servicios de obra, mapa de contacto y mejoras visuales en Inicio. La siguiente etapa es preparar evidencias visuales y checklist de deploy.
