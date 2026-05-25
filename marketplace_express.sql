-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2026 a las 21:23:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `marketplace_express`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_cambios`
--

CREATE TABLE `auditoria_cambios` (
  `id_auditoria` int(11) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(6, 'Accesorios'),
(10, 'Automotriz'),
(9, 'Belleza'),
(4, 'Deportes'),
(8, 'Electrodomesticos'),
(2, 'Hogar'),
(7, 'Oficina'),
(3, 'Ropa'),
(1, 'Tecnologia'),
(5, 'Videojuegos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `email`, `telefono`, `direccion`) VALUES
(1, 'Ana', 'Ramirez', 'ana@gmail.com', '7000-4444', 'La Libertad'),
(2, 'Elena', 'Cruz', 'elena@gmail.com', '7000-6666', 'Usulutan'),
(3, 'Pedro', 'Vasquez', 'pedro@gmail.com', '7000-7777', 'Ahuachapan'),
(4, 'Miguel', 'Flores', 'miguel@gmail.com', '7000-9999', 'Cuscatlan'),
(5, 'Laura', 'Torres', 'laura@gmail.com', '7000-1010', 'Morazan'),
(6, 'Eliseo ', 'Martinez', 'Eliseo.martinez@gmail.com', '2121-2828', 'San Salvador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_backup`
--

CREATE TABLE `clientes_backup` (
  `id_cliente` int(11) NOT NULL DEFAULT 0,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes_backup`
--

INSERT INTO `clientes_backup` (`id_cliente`, `nombre`, `apellido`, `email`, `telefono`, `direccion`) VALUES
(1, 'Carlos', 'Lopez', 'carlos@gmail.com', '7000-1111', 'San Salvador'),
(2, 'Maria', 'Hernandez', 'maria@gmail.com', '7000-2222', 'Santa Ana'),
(3, 'Jose', 'Martinez', 'jose@gmail.com', '7000-3333', 'San Miguel'),
(4, 'Ana', 'Ramirez', 'ana@gmail.com', '7000-4444', 'La Libertad'),
(5, 'Luis', 'Gomez', 'luis@gmail.com', '7000-5555', 'Sonsonate'),
(6, 'Elena', 'Cruz', 'elena@gmail.com', '7000-6666', 'Usulutan'),
(7, 'Pedro', 'Vasquez', 'pedro@gmail.com', '7000-7777', 'Ahuachapan'),
(8, 'Sofia', 'Reyes', 'sofia@gmail.com', '7000-8888', 'Chalatenango'),
(9, 'Miguel', 'Flores', 'miguel@gmail.com', '7000-9999', 'Cuscatlan'),
(10, 'Laura', 'Torres', 'laura@gmail.com', '7000-1010', 'Morazan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detalle`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(5, 4, 7, 1, 700.00),
(8, 6, 9, 1, 150.00),
(9, 7, 8, 1, 60.00),
(10, 10, 10, 1, 80.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `cargo` varchar(50) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `correo`, `clave`, `cargo`) VALUES
(1, 'Administrador', 'admin@marketplace.com', '$2y$10$U2zAhWTsCzdkvJZIUQakfuKxN.n1rs/vMeq8BQqFwDXIme83qNd9e', 'admin'),
(2, 'Juan Pérez', 'juan.perez@marketplace.com', '$2y$10$npUQOW1V7d9Kk7XnO4Y4xOCK1ND6MtSIRXHa4NSlqF2rOheKjPYwy', 'vendedor'),
(3, 'María López', 'maria.lopez@marketplace.com', 'Venta2026$', 'usuario'),
(4, 'alexander', 'alexander@gmail.com', '$2y$10$COU5SYuAwxJwOQn0zTn1sOIs/v74p/TnqzlS2MEgCkHcuoLpjiCXm', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `stock`, `id_categoria`) VALUES
(1, 'Laptop HP', 850.00, 15, 1),
(2, 'Mouse Logitech', 25.50, 40, 1),
(3, 'Teclado Redragon', 45.00, 20, 1),
(4, 'Silla Gamer', 220.00, 10, 2),
(5, 'Camisa Deportiva', 18.00, 50, 3),
(6, 'Balon Futbol', 30.00, 25, 4),
(7, 'PlayStation 5', 700.00, 8, 5),
(8, 'Audifonos Bluetooth', 60.00, 35, 6),
(9, 'Impresora Epson', 150.00, 12, 7),
(10, 'Licuadora Oster', 80.00, 18, 8);

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `trg_auditoria_productos` AFTER UPDATE ON `productos` FOR EACH ROW BEGIN
    INSERT INTO auditoria_cambios
    (tabla, accion, descripcion)
    VALUES
    (
        'productos',
        'UPDATE',
        CONCAT('Producto actualizado ID: ', OLD.id_producto)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `fecha`, `id_cliente`, `id_empleado`, `total`) VALUES
(4, '2026-05-04', 1, 1, 700.00),
(6, '2026-05-06', 2, 5, 150.00),
(7, '2026-05-07', 3, 6, 60.00),
(9, '2026-05-09', 4, 8, 18.00),
(10, '2026-05-10', 5, 9, 80.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria_cambios`
--
ALTER TABLE `auditoria_cambios`
  ADD PRIMARY KEY (`id_auditoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_cliente_email` (`email`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_venta` (`id_venta`),
  ADD KEY `fk_detalle_producto` (`id_producto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_categoria` (`id_categoria`),
  ADD KEY `idx_producto_nombre` (`nombre`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_venta_cliente` (`id_cliente`),
  ADD KEY `fk_venta_empleado` (`id_empleado`),
  ADD KEY `idx_ventas_fecha` (`fecha`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria_cambios`
--
ALTER TABLE `auditoria_cambios`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `fk_detalle_venta` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `fk_venta_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
