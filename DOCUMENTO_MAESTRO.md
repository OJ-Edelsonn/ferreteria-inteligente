# Documento Maestro - Ferreteria Inteligente

## 1. Resumen Del Proyecto

**Nombre del proyecto:** J&S Ferretería Inteligente  
**Tipo:** Sistema web full stack  
**Negocio:** J&S Ferretería, ubicada en Quiparacra - Pasco  
**Objetivo principal:** Crear una plataforma web para una ferreteria que permita mostrar productos, administrarlos y capturar datos de comportamiento del cliente para analisis posterior.

El sistema no solo funcionara como catalogo digital. Su valor diferencial sera registrar interacciones como busquedas y productos vistos, convirtiendo la web en una fuente de datos para tomar decisiones comerciales.

## 2. Problema A Resolver

Muchas ferreterias pequenas muestran sus productos de forma manual o por redes sociales, pero no tienen datos sobre:

- Que productos buscan mas los clientes.
- Que productos reciben mas visitas.
- Que categorias generan mayor interes.
- Que productos existen en catalogo pero no despiertan interaccion.

Este proyecto busca resolver ese problema con una web simple, funcional y medible.

## 3. Resultado Esperado

Al finalizar, el proyecto debe entregar:

- Sistema web funcional en PHP y MySQL.
- Catalogo de productos consultable por clientes.
- Buscador de productos.
- Panel de administrador.
- CRUD de productos.
- Registro de interacciones del cliente.
- Base de datos lista para analisis.
- README claro.
- Capturas o video demo.
- Proyecto versionado en GitHub.
- Deploy en hosting gratuito compatible con PHP y MySQL.

## 4. Stack Tecnologico

### Backend

- **PHP:** logica del sistema, controladores, modelos y procesamiento de formularios.
- **PDO:** conexion segura a MySQL usando consultas preparadas.

### Base De Datos

- **MySQL/MariaDB:** almacenamiento de productos, usuarios administradores e interacciones.
- **phpMyAdmin:** administracion local de la base de datos durante el desarrollo con XAMPP.

### Frontend

- **HTML5:** estructura de paginas.
- **CSS3:** estilos personalizados.
- **Bootstrap 5:** diseno responsive y componentes visuales.
- **JavaScript vanilla:** funciones puntuales como filtros, envio de interacciones con `fetch` y mejoras de experiencia.

### Herramientas

- **XAMPP:** entorno local para Apache, PHP y MySQL.
- **Git:** control de versiones.
- **GitHub:** repositorio remoto y portafolio.
- **FileZilla:** subida del proyecto al hosting por FTP.
- **InfinityFree:** hosting gratuito recomendado para deploy con PHP y MySQL.

### Java

No se usara Java inicialmente porque el sistema puede resolverse mejor con PHP, MySQL y JavaScript. Se considerara solo si aparece una necesidad especifica o una exigencia academica.

## 5. Arquitectura Propuesta

Se usara una arquitectura MVC simple:

- **public/**: entrada publica del sistema, assets y paginas accesibles por el navegador.
- **app/Controllers/**: coordinan las peticiones y validaciones.
- **app/Models/**: acceden a la base de datos.
- **app/Views/**: plantillas visuales.
- **config/**: configuracion del sistema y base de datos.
- **database/**: scripts SQL.
- **docs/**: documentacion del proyecto y evidencias.

Flujo general:

1. El usuario entra al catalogo.
2. PHP consulta productos activos en MySQL.
3. El usuario busca o ve un producto.
4. JavaScript/PHP registra la interaccion.
5. El administrador revisa productos e indicadores.
6. Los datos quedan disponibles para analisis.

## 6. Roles Del Sistema

### Cliente Visitante

Puede:

- Ver el catalogo de productos.
- Buscar productos.
- Filtrar productos por categoria.
- Ver detalles de un producto.

No necesita iniciar sesion.

### Administrador

Puede:

- Iniciar sesion.
- Crear productos.
- Editar productos.
- Eliminar o desactivar productos.
- Ver listado de productos.
- Consultar interacciones capturadas.
- Revisar indicadores basicos de comportamiento.

## 7. Datos A Capturar

La tabla clave sera `interacciones`.

Campos propuestos:

- `id`: identificador unico.
- `tipo_interaccion`: tipo de evento, por ejemplo `busqueda` o `producto_visto`.
- `producto_id`: producto asociado, si aplica.
- `termino_busqueda`: texto buscado, si aplica.
- `usuario`: identificador simple del visitante o administrador, si aplica.
- `ip`: direccion IP aproximada del visitante.
- `user_agent`: navegador/dispositivo usado.
- `fecha`: fecha y hora de la interaccion.

### Por Que Capturar Estos Datos

- Para conocer demanda real.
- Para detectar productos populares.
- Para identificar busquedas sin resultados.
- Para mejorar inventario, compras y catalogo.
- Para demostrar que el sistema genera datos para analisis.

## 8. Requerimientos Funcionales

### Catalogo

- RF-01: El sistema debe mostrar productos activos.
- RF-02: El sistema debe permitir buscar productos por nombre.
- RF-03: El sistema debe permitir filtrar productos por categoria.
- RF-04: El sistema debe mostrar detalle basico del producto.
- RF-05: El sistema debe registrar cuando un producto es visto.
- RF-06: El sistema debe registrar cada busqueda realizada.

### Administracion

- RF-07: El administrador debe poder iniciar sesion.
- RF-08: El administrador debe poder crear productos.
- RF-09: El administrador debe poder editar productos.
- RF-10: El administrador debe poder eliminar o desactivar productos.
- RF-11: El administrador debe poder ver productos registrados.
- RF-12: El administrador debe poder consultar interacciones.
- RF-13: El administrador debe poder ver indicadores basicos.

### Base De Datos

- RF-14: El sistema debe guardar productos en MySQL.
- RF-15: El sistema debe guardar categorias.
- RF-16: El sistema debe guardar usuarios administradores.
- RF-17: El sistema debe guardar interacciones.

## 9. Requerimientos No Funcionales

- RNF-01: El sistema debe ser responsive.
- RNF-02: El sistema debe funcionar en XAMPP local.
- RNF-03: El sistema debe poder desplegarse en hosting gratuito con PHP y MySQL.
- RNF-04: Las consultas deben usar PDO y sentencias preparadas.
- RNF-05: Las credenciales no deben exponerse en el repositorio.
- RNF-06: El codigo debe estar organizado por responsabilidades.
- RNF-07: El README debe permitir instalar el proyecto paso a paso.
- RNF-08: El sistema debe ser facil de explicar academicamente.
- RNF-09: El panel admin debe estar protegido por sesion.
- RNF-10: La interfaz debe ser limpia y clara.

## 10. Base De Datos Inicial

Tablas principales:

- `usuarios`
- `categorias`
- `productos`
- `interacciones`

Tablas opcionales para una segunda etapa:

- `ventas`
- `pedidos`
- `pedido_detalle`
- `stock_movimientos`

Para el alcance principal del Proyecto 3, la prioridad sera productos e interacciones.

## 11. Roadmap Del Proyecto

### Fase 1 - Preparacion

- Crear carpeta del proyecto.
- Crear documento maestro.
- Definir stack y arquitectura.
- Inicializar Git.
- Crear repositorio en GitHub.

### Fase 2 - Base Tecnica

- Crear estructura MVC.
- Crear configuracion de base de datos.
- Crear script SQL inicial.
- Crear layout publico base.
- Crear README inicial.

### Fase 3 - Catalogo Publico

- Listar productos.
- Crear buscador.
- Crear filtro por categoria.
- Crear pagina de detalle de producto.
- Registrar busquedas.
- Registrar producto visto.

### Fase 4 - Administracion

- Crear login admin.
- Proteger panel.
- Crear CRUD de productos.
- Validar formularios.
- Manejar imagenes o rutas de imagen.

### Fase 5 - Analitica De Interacciones

- Crear modelo/controlador de interacciones.
- Crear vista admin de interacciones.
- Mostrar productos mas vistos.
- Mostrar busquedas frecuentes.
- Mostrar busquedas sin resultados.

### Fase 6 - QA Y Documentacion

- Probar flujo completo.
- Verificar base de datos.
- Tomar capturas.
- Completar README.
- Documentar arquitectura y flujo de informacion.

### Fase 7 - GitHub Y Deploy

- Subir proyecto a GitHub.
- Crear base de datos en hosting.
- Subir archivos por FileZilla.
- Configurar credenciales de produccion.
- Probar URL publica.
- Guardar capturas de demo.

## 12. Division De Trabajo

### Edelson

- Ejecutar pasos locales en XAMPP cuando sea necesario.
- Revisar y entender cada modulo.
- Probar el sistema en navegador.
- Crear cuenta/proyecto en hosting cuando corresponda.
- Explicar decisiones del proyecto.

### Codex

- Guiar la arquitectura.
- Crear o corregir codigo cuando Edelson lo solicite.
- Revisar errores.
- Proponer mejoras.
- Preparar documentacion.
- Ayudar con Git, GitHub y deploy.

## 13. Criterios De Exito

El proyecto se considerara exitoso si:

- Se puede abrir localmente con XAMPP.
- El catalogo muestra productos desde MySQL.
- El buscador funciona.
- El administrador gestiona productos.
- Las interacciones quedan registradas en MySQL.
- Se puede explicar que datos se capturan y para que sirven.
- El repositorio esta en GitHub.
- Existe una demo local o desplegada.

## 14. Riesgos Y Mitigaciones

- **Riesgo:** credenciales expuestas en GitHub.  
  **Mitigacion:** usar archivo de configuracion ejemplo y excluir configuracion real.

- **Riesgo:** errores al desplegar por rutas absolutas.  
  **Mitigacion:** usar constantes de configuracion y rutas relativas controladas.

- **Riesgo:** codificacion rota en textos.  
  **Mitigacion:** guardar archivos en UTF-8 y definir `charset=utf8mb4`.

- **Riesgo:** alcance demasiado grande.  
  **Mitigacion:** priorizar catalogo, CRUD e interacciones antes de ventas o pedidos.

## 15. Decision Inicial De Deploy

Hosting recomendado:

- **InfinityFree**

Motivos:

- Plan gratuito.
- Soporte para PHP y MySQL.
- FTP compatible con FileZilla.
- Subdominio gratuito.
- Suficiente para proyecto academico.

Dominio inicial sugerido:

- `ferreteria-inteligente.rf.gd`
- `ferreteriainteligente.great-site.net`

## 16. Avance Actual

### Completado

- Carpeta del proyecto creada en XAMPP.
- Repositorio Git inicializado.
- Proyecto subido a GitHub.
- Documento maestro creado.
- README inicial creado.
- Base de datos local creada.
- Tabla `interacciones` creada.
- Home publica conectada a MySQL.
- Catalogo publico creado.
- Busqueda de productos creada.
- Filtro por categoria creado.
- Detalle de producto creado.
- Registro de busquedas implementado.
- Registro de producto visto implementado.
- Login de administrador implementado.
- Sesiones privadas implementadas.
- Proteccion CSRF en formularios admin.
- Dashboard administrador implementado.
- CRUD de productos implementado.
- Vista de interacciones implementada.
- Identidad real de J&S Ferretería integrada.
- Pagina de contacto con WhatsApp implementada.
- Graficos de interacciones agregados al dashboard.

### Siguiente Etapa

Preparar evidencias y despliegue:

- Busquedas sin resultados destacadas.
- Preparacion de capturas para demo.
- Preparacion de deploy.
