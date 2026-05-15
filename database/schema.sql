CREATE DATABASE IF NOT EXISTS ferreteria_inteligente
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE ferreteria_inteligente;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('administrador') NOT NULL DEFAULT 'administrador',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

INSERT INTO categorias (nombre, descripcion) VALUES
('Herramientas', 'Martillos, alicates, destornilladores y llaves'),
('Construccion', 'Cemento, ladrillos, arena y materiales de obra'),
('Electricidad', 'Cables, tomacorrientes, interruptores y focos'),
('Pintura', 'Pinturas, brochas, rodillos y solventes'),
('Gasfiteria', 'Tubos, codos, llaves y accesorios PVC');

INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, imagen) VALUES
(1, 'Martillo de acero', 'Martillo resistente para trabajos generales.', 28.90, 20, NULL),
(1, 'Alicate universal', 'Alicate para corte y sujecion.', 24.50, 15, NULL),
(2, 'Cemento Portland', 'Bolsa de cemento para construccion.', 32.00, 40, NULL),
(3, 'Foco LED 15W', 'Foco LED de bajo consumo.', 9.90, 60, NULL),
(4, 'Brocha 4 pulgadas', 'Brocha para pintura de interiores y exteriores.', 8.50, 35, NULL),
(5, 'Tubo PVC 2 pulgadas', 'Tubo PVC para instalaciones sanitarias.', 16.00, 25, NULL);

