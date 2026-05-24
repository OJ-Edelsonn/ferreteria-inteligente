# Flujo De Información

Este documento explica cómo se mueve la información dentro de Ferretería Inteligente.

## 1. Catálogo

El usuario entra a `public/catalogo.php`.

El sistema:

- Lee filtros desde la URL.
- Consulta productos activos en MySQL.
- Muestra productos al usuario.

## 2. Búsqueda

Cuando el usuario escribe un término y presiona buscar:

- PHP recibe `buscar` por método GET.
- `ProductModel` consulta productos por nombre, descripción o categoría.
- `InteractionModel` guarda una fila en `interacciones`.

Dato capturado:

- `tipo_interaccion`: `busqueda`
- `termino_busqueda`: texto buscado
- `resultados`: cantidad de productos encontrados
- `ip`: dirección del visitante
- `user_agent`: navegador o dispositivo
- `fecha`: momento de la búsqueda

## 3. Producto Visto

Cuando el usuario abre `public/producto.php?id=...`:

- PHP busca el producto por ID.
- Si existe, se muestra el detalle.
- `InteractionModel` guarda una fila en `interacciones`.

Dato capturado:

- `tipo_interaccion`: `producto_visto`
- `producto_id`: producto visitado
- `ip`: dirección del visitante
- `user_agent`: navegador o dispositivo
- `fecha`: momento de la visita

## 4. Valor Para Análisis

Con estos datos se podrá responder:

- Qué productos se ven más.
- Qué términos se buscan más.
- Qué búsquedas no tienen resultados.
- Qué categorías generan más interés.
- Qué productos del catálogo casi no reciben visitas.

## 5. Panel Administrador

El administrador entra por `public/admin/login.php`.

El sistema:

- Valida correo y contraseña contra la tabla `usuarios`.
- Crea una sesión privada.
- Protege rutas internas con `requireAdmin()`.
- Usa token CSRF para formularios del panel.

Desde el panel se puede:

- Ver métricas generales.
- Crear, editar y desactivar productos.
- Revisar interacciones recientes.
- Identificar búsquedas frecuentes y productos más vistos.
