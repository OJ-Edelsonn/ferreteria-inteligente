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

## Estado

Proyecto en fase inicial de planificacion y estructura base.

