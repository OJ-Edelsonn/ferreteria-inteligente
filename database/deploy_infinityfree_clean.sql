SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS interacciones;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;



CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('administrador') NOT NULL DEFAULT 'administrador',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nombre, email, password, rol, activo) VALUES
('Administrador', 'admin@ferreteria.test', '$2y$10$1a1gDcNjpUwlZu7Iyc7f9e8yWdX7MR/3lL7/exPX0OL2qzzVAaGD2', 'administrador', 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), rol = VALUES(rol), activo = VALUES(activo);

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255),
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_productos_categorias
        FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS interacciones (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    tipo_interaccion ENUM('busqueda','producto_visto') NOT NULL,
    producto_id INT NULL,
    termino_busqueda VARCHAR(150) NULL,
    resultados INT NULL,
    usuario VARCHAR(120) NULL,
    ip VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_interacciones_productos
        FOREIGN KEY (producto_id) REFERENCES productos(id)
        ON DELETE SET NULL,
    INDEX idx_interacciones_tipo_fecha (tipo_interaccion, fecha),
    INDEX idx_interacciones_producto (producto_id),
    INDEX idx_interacciones_busqueda (termino_busqueda)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO categorias (id, nombre, descripcion, activo) VALUES
(1, 'Herramientas', 'Martillos, destornilladores, llaves, taladros y más', 1),
(2, 'Construcción', 'Cemento, fierro, ladrillos, arena y materiales de obra', 1),
(3, 'Plomería', 'Tuberías, codos, llaves de paso, pegamentos PVC', 1),
(4, 'Electricidad', 'Cables, interruptores, tomacorrientes, focos', 1),
(5, 'Pintura', 'Pinturas, barnices, thinner, brochas y rodillos', 1),
(6, 'Seguridad', 'Candados, chapas, bisagras, aldabas', 1),
(7, 'Fijación', 'Clavos, tornillos, pernos, tuercas, remaches', 1),
(8, 'Acabados', 'Porcelana, fragua, selladores, masilla', 1),
(9, 'Gasfitería', 'Inodoros, lavatorios, llaves de ducha', 1),
(10, 'Otros', 'Artículos varios de ferretería', 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion), activo = VALUES(activo);

INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, stock, imagen, activo) VALUES
(2, 1, 'Martillo de acero', 'Martillo de acero forjado con mango de madera. Ideal para clavar y desclavar.', 18.00, 10, 'martillo-acero.webp', 1),
(3, 1, 'Destornillador estrella', 'Destornillador de punta estrella Ph2. Mango ergonómico antideslizante.', 7.00, 15, 'destornillador-estrella.webp', 1),
(4, 1, 'Destornillador plano', 'Destornillador de punta plana 6mm. Acero templado de alta resistencia.', 7.00, 15, 'destornillador-plano.webp', 1),
(5, 1, 'Alicate universal', 'Alicate multiusos con aislamiento. Corta, dobla y sujeta con precisión.', 14.00, 10, 'alicate-universal.webp', 1),
(6, 1, 'Llave francesa', 'Llave francesa ajustable 10 pulgadas. Acero al cromo vanadio.', 18.00, 8, 'llave-francesa.webp', 1),
(7, 1, 'Cinta métrica 5m', 'Cinta métrica retráctil de 5 metros. Carcasa resistente con freno.', 9.00, 12, 'cinta-metrica.webp', 1),
(8, 1, 'Nivel de burbuja', 'Nivel de aluminio 60cm con 3 burbujas. Precisión para obras y acabados.', 14.00, 8, 'nivel-burbuja.webp', 1),
(9, 1, 'Serrucho', 'Serrucho de 22 pulgadas con dientes endurecidos. Corte fino en madera.', 17.00, 6, 'serrucho.webp', 1),
(10, 1, 'Cincel de acero', 'Cincel de acero templado 1 pulgada. Para picar concreto y mampostería.', 9.00, 10, 'cincel-acero.webp', 1),
(11, 1, 'Comba de 2kg', 'Comba de 2 kilos con mango de madera. Para demolición y trabajo pesado.', 22.00, 6, 'comba-2kg.webp', 1),
(12, 2, 'Cemento Andino 42.5kg', 'Cemento Andino tipo I de 42.5 kg. Alta resistencia para toda obra.', 35.00, 50, 'cemento-portland.webp', 1),
(13, 2, 'Ladrillo King Kong 18 huecos', 'Ladrillo King Kong de 18 huecos. Resistente y liviano para muros portantes.', 1.20, 500, 'ladrillo-king-kong.webp', 1),
(14, 2, 'Ladrillo caravista', 'Ladrillo caravista para acabados exteriores. Color uniforme y superficie lisa.', 1.80, 300, 'ladrillo-caravista.webp', 1),
(15, 2, 'Kinkón de 1/2 pulgada', 'Fierro corrugado de 1/2 pulgada x 9m. Para columnas y vigas de concreto.', 38.00, 30, 'kinkon-1-2.webp', 1),
(16, 2, 'Kinkón de 3/8 pulgada', 'Fierro corrugado de 3/8 pulgada x 9m. Para losas y escaleras.', 26.00, 30, 'kinkon-3-8.webp', 1),
(17, 2, 'Arena gruesa (bolsa)', 'Arena gruesa lavada en bolsa de 40kg. Para mezclas de concreto y mortero.', 12.00, 40, 'arena-gruesa.webp', 1),
(18, 2, 'Piedra chancada (bolsa)', 'Piedra chancada 3/4 en bolsa de 40kg. Para preparación de concreto.', 14.00, 30, 'piedra-chancada.webp', 1),
(19, 2, 'Alambre negro N°16', 'Alambre negro recocido N°16 rollo de 1kg. Para amarrar fierros en obras.', 8.00, 20, 'alambre-negro.webp', 1),
(20, 2, 'Clavos de 2 pulgadas', 'Clavos de acero 2 pulgadas bolsa de 1kg. Para encofrados y carpintería.', 6.50, 20, 'clavos-2-pulgadas.webp', 1),
(21, 2, 'Clavos de 3 pulgadas', 'Clavos de acero 3 pulgadas bolsa de 1kg. Para estructuras de madera.', 6.50, 20, 'clavos-3-pulgadas.webp', 1),
(22, 3, 'Tubo PVC 4 pulgadas x 3m', 'Tubo PVC desagüe 4 pulgadas x 3m. Para instalaciones sanitarias.', 18.00, 15, 'tubo-pvc-4.webp', 1),
(23, 3, 'Tubo PVC 2 pulgadas x 3m', 'Tubo PVC desagüe 2 pulgadas x 3m. Para ramales de desagüe.', 11.00, 15, 'tubo-pvc-2.webp', 1),
(24, 3, 'Codo PVC 4 pulgadas', 'Codo PVC 90° de 4 pulgadas. Para cambios de dirección en desagüe.', 5.50, 20, 'codo-pvc-4.webp', 1),
(25, 3, 'Codo PVC 2 pulgadas', 'Codo PVC 90° de 2 pulgadas. Para instalaciones de desagüe secundario.', 3.50, 20, 'codo-pvc-2.webp', 1),
(26, 3, 'Pegamento PVC 250ml', 'Pegamento para tuberías PVC 250ml. Sello hermético e instantáneo.', 9.00, 12, 'pegamento-pvc.webp', 1),
(27, 3, 'Llave de paso 1/2 pulgada', 'Llave de paso 1/2 pulgada de bronce. Para control de agua fría y caliente.', 13.00, 10, 'llave-paso.webp', 1),
(28, 3, 'Cinta teflón', 'Cinta teflón 1/2 pulgada x 10m. Para sellar roscas en instalaciones.', 2.00, 30, 'cinta-teflon.webp', 1),
(29, 3, 'Reducción PVC 4 a 2 pulgadas', 'Reducción PVC de 4 a 2 pulgadas. Para empalmes de tuberías de distinto diámetro.', 5.00, 15, 'reduccion-pvc.webp', 1),
(30, 3, 'Trampa PVC', 'Trampa PVC tipo botella 2 pulgadas. Para lavatorios y duchas.', 8.00, 10, 'trampa-pvc.webp', 1),
(31, 3, 'Unión PVC 4 pulgadas', 'Unión simple PVC 4 pulgadas. Para empalmar tuberías de desagüe.', 4.00, 20, 'union-pvc.webp', 1),
(32, 4, 'Cable THW 2.5mm (metro)', 'Cable eléctrico THW 2.5mm por metro. Para circuitos de iluminación.', 3.50, 100, 'cable-thw-2-5.webp', 1),
(33, 4, 'Cable THW 4mm (metro)', 'Cable eléctrico THW 4mm por metro. Para circuitos de tomacorrientes.', 5.00, 100, 'cable-thw-4.webp', 1),
(34, 4, 'Interruptor simple', 'Interruptor simple 10A para empotrar. Compatible con placas estándar.', 7.00, 20, 'interruptor-simple.webp', 1),
(35, 4, 'Tomacorriente doble', 'Tomacorriente doble 10A con puesta a tierra. Para empotrar en pared.', 8.00, 20, 'tomacorriente-doble.webp', 1),
(36, 4, 'Foco LED 9W', 'Foco LED 9W luz blanca E27. Ahorro de energía y larga duración.', 7.00, 30, 'foco-led-9w.webp', 1),
(37, 4, 'Foco LED 15W', 'Foco LED 15W luz blanca E27. Alta luminosidad para ambientes grandes.', 10.00, 20, 'foco-led-15w.webp', 1),
(38, 4, 'Cinta aislante', 'Cinta aislante eléctrica 18mm x 10m. Resistente al calor y la humedad.', 2.50, 30, 'cinta-aislante.webp', 1),
(39, 4, 'Tablero eléctrico 4 polos', 'Tablero eléctrico metálico para 4 polos. Con puerta y barra de neutros.', 55.00, 5, 'tablero-electrico.webp', 1),
(40, 4, 'Enchufe macho', 'Enchufe macho 2 patas planas 10A. Para extensiones y artefactos.', 2.50, 25, 'enchufe-macho.webp', 1),
(41, 4, 'Breaker 20A', 'Interruptor termomagnético 20A 1 polo. Protección para circuitos eléctricos.', 14.00, 10, 'breaker-20a.webp', 1),
(42, 5, 'Pintura látex blanco 4L', 'Pintura látex blanco interior/exterior 4 litros. Rendimiento 35m² por galón.', 42.00, 15, 'pintura-latex-blanco.webp', 1),
(43, 5, 'Pintura látex colores 4L', 'Pintura látex colores interior/exterior 4 litros. Disponible en varios colores.', 42.00, 10, 'pintura-latex-color.webp', 1),
(44, 5, 'Barniz brillante 1L', 'Barniz brillante para madera 1 litro. Protege y realza la veta natural.', 19.00, 8, 'barniz-brillante.webp', 1),
(45, 5, 'Thinner acrílico 1L', 'Thinner acrílico 1 litro. Para diluir pinturas y limpiar pinceles.', 8.00, 15, 'thinner-acrilico.webp', 1),
(46, 5, 'Brocha 4 pulgadas', 'Brocha de 4 pulgadas con cerdas naturales. Para pintura en paredes y madera.', 7.00, 20, 'brocha-4.webp', 1),
(47, 5, 'Rodillo de pintura', 'Rodillo de felpa 9 pulgadas con palo extensible. Para pintar paredes grandes.', 12.00, 12, 'rodillo-pintura.webp', 1),
(48, 5, 'Lija de agua N°120', 'Lija de agua N°120 hoja 23x28cm. Para lijar paredes y superficies antes de pintar.', 1.80, 30, 'lija-agua.webp', 1),
(49, 5, 'Masilla para pared 4kg', 'Masilla acrílica para pared 4kg. Para nivelar y preparar superficies.', 19.00, 10, 'masilla-pared.webp', 1),
(50, 5, 'Sellador de paredes 1L', 'Sellador acrílico para paredes 1 litro. Fija el polvo y mejora la adherencia.', 12.00, 10, 'sellador-paredes.webp', 1),
(51, 5, 'Aguarrás 1L', 'Aguarrás mineral 1 litro. Para limpiar pinceles y diluir pinturas al aceite.', 8.00, 12, 'aguarras.webp', 1),
(52, 6, 'Candado 40mm', 'Candado de acero 40mm con llave. Para puertas, portones y candados de almacén.', 14.00, 12, 'candado-40mm.webp', 1),
(53, 6, 'Candado 60mm', 'Candado de acero 60mm con llave. Mayor seguridad para accesos principales.', 22.00, 8, 'candado-60mm.webp', 1),
(54, 6, 'Chapa puerta baño', 'Chapa para puerta de baño con seguro interior. Fácil instalación.', 17.00, 8, 'chapa-bano.webp', 1),
(55, 6, 'Chapa puerta principal', 'Chapa de sobreponer para puerta principal. Con llave y seguro de noche.', 28.00, 6, 'chapa-principal.webp', 1),
(56, 6, 'Bisagra 3 pulgadas', 'Bisagra de acero 3 pulgadas con tornillos. Para puertas de madera y metal.', 4.00, 30, 'bisagra-3.webp', 1),
(57, 6, 'Aldaba mediana', 'Aldaba de acero mediana con pasador. Para portones y puertas de almacén.', 7.00, 15, 'aldaba-mediana.webp', 1),
(58, 6, 'Pasador de puerta', 'Pasador de acero galvanizado 4 pulgadas. Para seguro adicional en puertas.', 5.00, 20, 'pasador-puerta.webp', 1),
(59, 6, 'Cadena galvanizada', 'Cadena galvanizada 6mm por metro. Resistente a la corrosión para uso exterior.', 6.00, 20, 'cadena-galvanizada.webp', 1),
(60, 7, 'Tornillo autorroscante 1\"', 'Tornillo autorroscante 1 pulgada caja 100u. Para fijación en drywall y madera.', 7.00, 15, 'tornillo-autorroscante.webp', 1),
(61, 7, 'Tornillo madera 2\"', 'Tornillo para madera 2 pulgadas caja 100u. Cabeza plana con ranura estrella.', 8.00, 15, 'tornillo-madera.webp', 1),
(62, 7, 'Perno hexagonal 3/8\"', 'Perno hexagonal 3/8 x 2 pulgadas con tuerca. Para estructuras metálicas.', 1.50, 50, 'perno-hexagonal.webp', 1),
(63, 7, 'Tuerca 3/8', 'Tuerca hexagonal 3/8 de acero. Complemento para pernos de estructuras.', 0.60, 80, 'tuerca-3-8.webp', 1),
(64, 7, 'Arandela plana 3/8', 'Arandela plana 3/8 de acero. Para distribuir carga en pernos y tornillos.', 0.50, 80, 'arandela-plana.webp', 1),
(65, 7, 'Taco fisher N°8', 'Taco fisher N°8 bolsa 50 unidades. Para fijación en paredes de concreto.', 5.00, 20, 'taco-fisher.webp', 1),
(66, 7, 'Remache pop 3/16', 'Remache pop 3/16 caja 100u. Para unir láminas metálicas sin soldadura.', 6.50, 12, 'remache-pop.webp', 1),
(67, 7, 'Clavo para concreto 2\"', 'Clavo para concreto 2 pulgadas bolsa 50u. Para fijar madera en pisos y paredes.', 6.00, 15, 'clavo-concreto.webp', 1),
(68, 8, 'Porcelana blanca 1kg', 'Porcelana blanca 1kg para fraguar cerámicos. Resistente a la humedad.', 8.00, 15, 'porcelana-blanca.webp', 1),
(69, 8, 'Fragua gris 1kg', 'Fragua gris 1kg para juntas de cerámico. Secado rápido y alta resistencia.', 8.00, 12, 'fragua-gris.webp', 1),
(70, 8, 'Fragua beige 1kg', 'Fragua beige 1kg para juntas de piso y pared. Color uniforme y duradero.', 8.00, 10, 'fragua-beige.webp', 1),
(71, 8, 'Masilla acrílica 1kg', 'Masilla acrílica 1kg para sellado de grietas. Flexible y pintable.', 9.50, 10, 'masilla-acrilica.webp', 1),
(72, 8, 'Sellador transparente 1L', 'Sellador transparente 1 litro. Para superficies porosas antes del acabado.', 11.00, 8, 'sellador-transparente.webp', 1),
(73, 8, 'Empaste interior 4kg', 'Empaste interior 4kg para paredes. Acabado liso y fácil de lijar.', 16.00, 10, 'empaste-interior.webp', 1),
(74, 8, 'Porcelana color 1kg', 'Porcelana de color 1kg para fraguar cerámicos de colores. Varios tonos.', 9.00, 10, 'porcelana-color.webp', 1),
(75, 9, 'Inodoro blanco', 'Inodoro de loza blanca con tanque incluido. Instalación sencilla.', 180.00, 3, 'inodoro-blanco.webp', 1),
(76, 9, 'Lavatorio de pared', 'Lavatorio de loza blanca para colgar en pared. Con orificio para grifería.', 120.00, 3, 'lavatorio-pared.webp', 1),
(77, 9, 'Llave de ducha', 'Llave de ducha cromada con cabezal incluido. Fácil instalación.', 40.00, 5, 'llave-ducha.webp', 1),
(78, 9, 'Mezcladora de cocina', 'Mezcladora monocomando para cocina. Cromada con manija larga.', 55.00, 4, 'mezcladora-cocina.webp', 1),
(79, 9, 'Válvula de flotador 1/2', 'Válvula de flotador 1/2 pulgada para tanque de agua. Cierre automático.', 10.00, 10, 'valvula-flotador.webp', 1),
(80, 9, 'Flexible de conexión 30cm', 'Flexible de conexión 30cm 1/2 pulgada. Para conectar grifería y sanitarios.', 7.00, 15, 'flexible-conexion.webp', 1),
(81, 9, 'Sellador sanitario', 'Sellador silicona sanitaria transparente 280ml. Para juntas de baño y cocina.', 12.00, 8, 'sellador-sanitario.webp', 1),
(82, 10, 'Escoba', 'Escoba para limpieza de obras y exteriores.', 9.00, 10, 'escoba-paja.webp', 1),
(83, 10, 'Recogedor de plástico', 'Recogedor de plástico resistente con mango largo. Para limpieza general.', 7.00, 10, 'recogedor-plastico.webp', 1),
(84, 10, 'Balde de 12 litros', 'Balde de plástico 12 litros con asa. Para mezclas y transporte de materiales.', 8.00, 12, 'balde-12l.webp', 1),
(85, 10, 'Carretilla construcción', 'Carretilla metálica 80 litros con rueda neumática. Para transporte de materiales en obra.', 120.00, 3, 'carretilla.webp', 1),
(86, 10, 'Guantes de trabajo', 'Guantes de cuero y lona talla única. Protección en trabajos de construcción.', 9.00, 15, 'guantes-trabajo.webp', 1),
(87, 10, 'Mascarilla de polvo', 'Mascarilla desechable contra polvo N95 par. Para trabajos en obra.', 3.50, 20, 'mascarilla-polvo.webp', 1),
(88, 10, 'Casco de seguridad', 'Casco de seguridad blanco con ajuste interno. Protección en obra según norma.', 20.00, 5, 'casco-seguridad.webp', 1)
ON DUPLICATE KEY UPDATE categoria_id = VALUES(categoria_id), nombre = VALUES(nombre), descripcion = VALUES(descripcion), precio = VALUES(precio), stock = VALUES(stock), imagen = VALUES(imagen), activo = 1;

UPDATE productos SET activo = 0 WHERE id NOT IN (2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88);
ALTER TABLE productos AUTO_INCREMENT = 89;
SET FOREIGN_KEY_CHECKS = 1;


DELETE FROM interacciones WHERE usuario = 'demo';

INSERT INTO interacciones
    (tipo_interaccion, producto_id, termino_busqueda, resultados, usuario, ip, user_agent, fecha)
VALUES
('busqueda', NULL, 'cemento', 1, 'demo', '192.0.2.10', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 13 DAY)),
('busqueda', NULL, 'ladrillo', 2, 'demo', '192.0.2.11', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 13 DAY)),
('producto_visto', 12, NULL, NULL, 'demo', '192.0.2.10', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 13 DAY)),
('producto_visto', 13, NULL, NULL, 'demo', '192.0.2.11', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 13 DAY)),

('busqueda', NULL, 'tubo pvc', 2, 'demo', '192.0.2.12', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 12 DAY)),
('busqueda', NULL, 'pegamento pvc', 1, 'demo', '192.0.2.13', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 12 DAY)),
('producto_visto', 22, NULL, NULL, 'demo', '192.0.2.12', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 12 DAY)),
('producto_visto', 26, NULL, NULL, 'demo', '192.0.2.13', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 12 DAY)),

('busqueda', NULL, 'pintura latex', 2, 'demo', '192.0.2.14', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 11 DAY)),
('busqueda', NULL, 'brocha', 1, 'demo', '192.0.2.15', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 11 DAY)),
('producto_visto', 42, NULL, NULL, 'demo', '192.0.2.14', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 11 DAY)),
('producto_visto', 46, NULL, NULL, 'demo', '192.0.2.15', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 11 DAY)),

('busqueda', NULL, 'cable 4mm', 1, 'demo', '192.0.2.16', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 10 DAY)),
('busqueda', NULL, 'tomacorriente', 1, 'demo', '192.0.2.17', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 10 DAY)),
('producto_visto', 33, NULL, NULL, 'demo', '192.0.2.16', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 10 DAY)),
('producto_visto', 35, NULL, NULL, 'demo', '192.0.2.17', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 10 DAY)),

('busqueda', NULL, 'inodoro', 1, 'demo', '192.0.2.18', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 9 DAY)),
('busqueda', NULL, 'lavatorio', 1, 'demo', '192.0.2.19', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 9 DAY)),
('producto_visto', 75, NULL, NULL, 'demo', '192.0.2.18', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 9 DAY)),
('producto_visto', 76, NULL, NULL, 'demo', '192.0.2.19', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 9 DAY)),

('busqueda', NULL, 'calamina', 0, 'demo', '192.0.2.20', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 8 DAY)),
('busqueda', NULL, 'yeso', 0, 'demo', '192.0.2.21', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 8 DAY)),
('busqueda', NULL, 'carretilla', 1, 'demo', '192.0.2.22', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 8 DAY)),
('producto_visto', 85, NULL, NULL, 'demo', '192.0.2.22', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 8 DAY)),

('busqueda', NULL, 'cemento', 1, 'demo', '192.0.2.23', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 7 DAY)),
('busqueda', NULL, 'fierro 1/2', 1, 'demo', '192.0.2.24', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 7 DAY)),
('producto_visto', 12, NULL, NULL, 'demo', '192.0.2.23', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 7 DAY)),
('producto_visto', 15, NULL, NULL, 'demo', '192.0.2.24', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 7 DAY)),

('busqueda', NULL, 'tubo pvc', 2, 'demo', '192.0.2.25', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 6 DAY)),
('busqueda', NULL, 'llave de paso', 1, 'demo', '192.0.2.26', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 6 DAY)),
('producto_visto', 22, NULL, NULL, 'demo', '192.0.2.25', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 6 DAY)),
('producto_visto', 27, NULL, NULL, 'demo', '192.0.2.26', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 6 DAY)),

('busqueda', NULL, 'porcelanato', 0, 'demo', '192.0.2.27', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 5 DAY)),
('busqueda', NULL, 'fragua', 2, 'demo', '192.0.2.28', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 5 DAY)),
('producto_visto', 69, NULL, NULL, 'demo', '192.0.2.28', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 5 DAY)),
('producto_visto', 70, NULL, NULL, 'demo', '192.0.2.28', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 5 DAY)),

('busqueda', NULL, 'candado', 2, 'demo', '192.0.2.29', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('busqueda', NULL, 'chapa puerta', 2, 'demo', '192.0.2.30', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('producto_visto', 52, NULL, NULL, 'demo', '192.0.2.29', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('producto_visto', 55, NULL, NULL, 'demo', '192.0.2.30', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 4 DAY)),

('busqueda', NULL, 'cemento', 1, 'demo', '192.0.2.31', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 3 DAY)),
('busqueda', NULL, 'arena gruesa', 1, 'demo', '192.0.2.32', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 3 DAY)),
('producto_visto', 12, NULL, NULL, 'demo', '192.0.2.31', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 3 DAY)),
('producto_visto', 17, NULL, NULL, 'demo', '192.0.2.32', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 3 DAY)),

('busqueda', NULL, 'alicate', 1, 'demo', '192.0.2.33', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('busqueda', NULL, 'taladro', 0, 'demo', '192.0.2.34', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('producto_visto', 5, NULL, NULL, 'demo', '192.0.2.33', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('producto_visto', 6, NULL, NULL, 'demo', '192.0.2.33', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 2 DAY)),

('busqueda', NULL, 'pintura latex', 2, 'demo', '192.0.2.35', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('busqueda', NULL, 'rodillo', 1, 'demo', '192.0.2.36', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('producto_visto', 42, NULL, NULL, 'demo', '192.0.2.35', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('producto_visto', 47, NULL, NULL, 'demo', '192.0.2.36', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 1 DAY)),

('busqueda', NULL, 'cemento', 1, 'demo', '192.0.2.37', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
('busqueda', NULL, 'calamina', 0, 'demo', '192.0.2.38', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 5 HOUR)),
('busqueda', NULL, 'tubo pvc', 2, 'demo', '192.0.2.39', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 4 HOUR)),
('producto_visto', 12, NULL, NULL, 'demo', '192.0.2.37', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
('producto_visto', 22, NULL, NULL, 'demo', '192.0.2.39', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 2 HOUR)),
('producto_visto', 75, NULL, NULL, 'demo', '192.0.2.40', 'Demo Browser', DATE_SUB(NOW(), INTERVAL 1 HOUR));
