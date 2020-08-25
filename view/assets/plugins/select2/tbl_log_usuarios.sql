-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-08-2020 a las 03:11:18
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_sistema_ruta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_usuarios`
--

CREATE TABLE `tbl_log_usuarios` (
  `id_logu` bigint(20) NOT NULL,
  `accion_logu` text COLLATE utf8_swedish_ci NOT NULL,
  `movimiento_logu` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,3-DESACTIVAR',
  `fecha_logu` datetime NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `nota_logu` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_usuarios`
--

INSERT INTO `tbl_log_usuarios` (`id_logu`, `accion_logu`, `movimiento_logu`, `fecha_logu`, `id_usu`, `nota_logu`) VALUES
(1, '0', 0, '2020-08-22 12:34:49', 9, NULL),
(3, '1', 0, '2020-08-22 15:10:44', 1, NULL),
(4, '1', 0, '2020-08-22 15:22:05', 1, NULL),
(5, '1', 0, '2020-08-22 15:22:47', 1, NULL),
(6, '1', 0, '2020-08-22 15:24:19', 1, NULL),
(7, '1', 0, '2020-08-22 15:25:24', 1, NULL),
(8, 'cambiar estado', 0, '2020-08-22 15:51:14', 1, NULL),
(9, 'cambiar estado', 0, '2020-08-22 15:51:21', 1, NULL),
(10, '0', 0, '2020-08-22 17:28:34', 1, NULL),
(11, 'cambiar estado', 0, '2020-08-22 17:29:57', 1, NULL),
(12, 'cambiar estado', 0, '2020-08-22 17:30:30', 1, NULL),
(13, '1', 0, '2020-08-22 17:31:20', 1, NULL),
(14, '0', 0, '2020-08-22 17:40:21', 1, NULL),
(15, '0', 0, '2020-08-22 17:41:50', 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD PRIMARY KEY (`id_logu`),
  ADD KEY `FK_USUARIO-LOG` (`id_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  MODIFY `id_logu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
