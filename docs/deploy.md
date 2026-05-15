# Guia De Deploy

## Hosting Recomendado

InfinityFree.

## Flujo General

1. Crear cuenta en InfinityFree.
2. Crear un sitio gratuito con subdominio.
3. Crear una base de datos MySQL desde el panel.
4. Importar `database/schema.sql` desde phpMyAdmin del hosting.
5. Crear `config/config.php` con credenciales de produccion.
6. Subir archivos por FileZilla al directorio publico del hosting.
7. Probar URL final.

## Nota De Seguridad

No subir credenciales reales a GitHub. El archivo `config/config.php` esta ignorado por Git.

