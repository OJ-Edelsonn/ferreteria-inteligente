# Ferreteria Inteligente

Sistema web full stack para una ferreteria que combina catalogo de productos, administracion e interacciones del cliente para analisis.

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
6. Copiar `config/config.example.php` como `config/config.php`.
7. Revisar credenciales locales en `config/config.php`.
8. Abrir `http://localhost/ferreteria-inteligente/public/`.

## URLs Locales

- Inicio: `http://localhost/ferreteria-inteligente/public/`
- Catalogo: `http://localhost/ferreteria-inteligente/public/catalogo.php`
- Detalle de producto: `http://localhost/ferreteria-inteligente/public/producto.php?id=1`

## Funcionalidades Implementadas

- Home publica conectada a MySQL.
- Catalogo de productos.
- Busqueda por nombre, descripcion o categoria.
- Filtro por categoria.
- Detalle de producto.
- Registro de busquedas en `interacciones`.
- Registro de vistas de producto en `interacciones`.

## Flujo De Datos

1. El cliente abre el catalogo.
2. El sistema consulta productos activos en MySQL.
3. Si el cliente busca un termino, se guarda una interaccion de tipo `busqueda`.
4. Si el cliente abre un detalle, se guarda una interaccion de tipo `producto_visto`.
5. Estos datos quedan disponibles para el futuro dashboard administrativo.

## Estado

Proyecto en fase de catalogo publico inteligente. La siguiente etapa es construir el panel de administrador con login y CRUD de productos.
