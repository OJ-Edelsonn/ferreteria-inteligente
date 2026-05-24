USE ferreteria_inteligente;

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
