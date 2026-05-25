-- Script de permisos y roles para la base de datos marketplace_express
-- Fecha: 25-05-2026

USE `marketplace_express`;

-- Definición de usuarios por rol
DROP USER IF EXISTS
  'gerente'@'localhost',
  'vendedor'@'localhost',
  'contador'@'localhost',
  'auditor'@'localhost';

CREATE USER 'gerente'@'localhost' IDENTIFIED BY 'Gerente2026!';
CREATE USER 'vendedor'@'localhost' IDENTIFIED BY 'clave';
CREATE USER 'contador'@'localhost' IDENTIFIED BY 'Contador2026!';
CREATE USER 'auditor'@'localhost' IDENTIFIED BY 'Auditor2026!';

-- Asegurar que no existan privilegios heredados no autorizados
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'gerente'@'localhost';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'vendedor'@'localhost';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'contador'@'localhost';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'auditor'@'localhost';

FLUSH PRIVILEGES;

-- Crear vistas para limitar columnas visibles por rol
CREATE OR REPLACE VIEW `v_clientes_gerente` AS
  SELECT id_cliente, nombre, apellido, email, telefono, direccion
  FROM clientes;

CREATE OR REPLACE VIEW `v_clientes_vendedor` AS
  SELECT id_cliente, nombre, apellido, telefono
  FROM clientes;

CREATE OR REPLACE VIEW `v_productos_basico` AS
  SELECT id_producto, nombre, precio, stock, id_categoria
  FROM productos;

CREATE OR REPLACE VIEW `v_ventas_basico` AS
  SELECT id_venta, fecha, id_cliente, id_empleado, total
  FROM ventas;

CREATE OR REPLACE VIEW `v_reportes_ventas` AS
  SELECT
    v.id_venta,
    v.fecha,
    c.nombre AS cliente,
    e.nombre AS vendedor,
    v.total
  FROM ventas v
  LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
  LEFT JOIN empleados e ON v.id_empleado = e.id_empleado;

CREATE OR REPLACE VIEW `v_reportes_auditoria` AS
  SELECT id_auditoria, tabla, accion, descripcion, fecha
  FROM auditoria_cambios;

-- Privilegios para el rol Gerente
GRANT SELECT, INSERT, UPDATE, DELETE ON `marketplace_express`.`clientes` TO 'gerente'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marketplace_express`.`productos` TO 'gerente'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marketplace_express`.`ventas` TO 'gerente'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `marketplace_express`.`empleados` TO 'gerente'@'localhost';
GRANT SELECT ON `marketplace_express`.`v_reportes_ventas` TO 'gerente'@'localhost';
GRANT SELECT ON `marketplace_express`.`v_reportes_auditoria` TO 'gerente'@'localhost';

-- Privilegios para el rol Vendedor
GRANT SELECT ON `marketplace_express`.`v_clientes_vendedor` TO 'vendedor'@'localhost';
GRANT SELECT ON `marketplace_express`.`v_productos_basico` TO 'vendedor'@'localhost';
GRANT INSERT ON `marketplace_express`.`ventas` TO 'vendedor'@'localhost';

-- Privilegios para el rol Contador
GRANT SELECT ON `marketplace_express`.`productos` TO 'contador'@'localhost';
GRANT SELECT ON `marketplace_express`.`ventas` TO 'contador'@'localhost';
GRANT SELECT ON `marketplace_express`.`v_reportes_ventas` TO 'contador'@'localhost';

-- Privilegios para el rol Auditor
GRANT SELECT ON `marketplace_express`.`ventas` TO 'auditor'@'localhost';
GRANT SELECT ON `marketplace_express`.`v_reportes_ventas` TO 'auditor'@'localhost';
GRANT SELECT ON `marketplace_express`.`v_reportes_auditoria` TO 'auditor'@'localhost';

FLUSH PRIVILEGES;

-- Comandos de prueba recomendados:
-- mysql -u vendedor -p -h localhost marketplace_express
-- mysql -u contador -p -h localhost marketplace_express
-- mysql -u auditor -p -h localhost marketplace_express
-- mysql -u gerente -p -h localhost marketplace_express

-- Ejemplos de verificación:
-- SELECT * FROM v_clientes_vendedor;
-- INSERT INTO ventas (id_venta, fecha, id_cliente, id_empleado, total) VALUES (999, '2026-05-25', 1, 2, 50.00);
-- SELECT * FROM v_reportes_ventas;

-- Nota: los roles Vendedor y Contador usan vistas para limitar columnas visibles donde corresponde.
