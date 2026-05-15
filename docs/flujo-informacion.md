# Flujo De Informacion

Este documento explica como se mueve la informacion dentro de Ferreteria Inteligente.

## 1. Catalogo

El usuario entra a `public/catalogo.php`.

El sistema:

- Lee filtros desde la URL.
- Consulta productos activos en MySQL.
- Muestra productos al usuario.

## 2. Busqueda

Cuando el usuario escribe un termino y presiona buscar:

- PHP recibe `buscar` por metodo GET.
- `ProductModel` consulta productos por nombre, descripcion o categoria.
- `InteractionModel` guarda una fila en `interacciones`.

Dato capturado:

- `tipo_interaccion`: `busqueda`
- `termino_busqueda`: texto buscado
- `resultados`: cantidad de productos encontrados
- `ip`: direccion del visitante
- `user_agent`: navegador o dispositivo
- `fecha`: momento de la busqueda

## 3. Producto Visto

Cuando el usuario abre `public/producto.php?id=...`:

- PHP busca el producto por ID.
- Si existe, se muestra el detalle.
- `InteractionModel` guarda una fila en `interacciones`.

Dato capturado:

- `tipo_interaccion`: `producto_visto`
- `producto_id`: producto visitado
- `ip`: direccion del visitante
- `user_agent`: navegador o dispositivo
- `fecha`: momento de la visita

## 4. Valor Para Analisis

Con estos datos se podra responder:

- Que productos se ven mas.
- Que terminos se buscan mas.
- Que busquedas no tienen resultados.
- Que categorias generan mas interes.
- Que productos del catalogo casi no reciben visitas.

## 5. Panel Administrador

El administrador entra por `public/admin/login.php`.

El sistema:

- Valida correo y contrasena contra la tabla `usuarios`.
- Crea una sesion privada.
- Protege rutas internas con `requireAdmin()`.
- Usa token CSRF para formularios del panel.

Desde el panel se puede:

- Ver metricas generales.
- Crear, editar y desactivar productos.
- Revisar interacciones recientes.
- Identificar busquedas frecuentes y productos mas vistos.
