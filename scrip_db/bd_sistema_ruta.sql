-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-08-2020 a las 01:55:06
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginCorreo` (IN `dataUsuario` TEXT)  NO SQL
BEGIN
SELECT * FROM tbl_usuarios WHERE correo_usu = dataUsuario and estado_usu=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginDocumento` (IN `dataUsuario` TEXT)  NO SQL
BEGIN
	SELECT * FROM tbl_usuarios WHERE documento_usu = dataUsuario and estado_usu=1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_gasto`
--

CREATE TABLE `tbl_gasto` (
  `id_gas` bigint(20) NOT NULL,
  `valor_gas` double NOT NULL,
  `fecha_gas` datetime NOT NULL,
  `evidencia_gas` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `nota_gas` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_usu` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_gasto`
--

INSERT INTO `tbl_gasto` (`id_gas`, `valor_gas`, `fecha_gas`, `evidencia_gas`, `nota_gas`, `id_usu`) VALUES
(1, 100, '2020-08-11 18:44:34', 'fdsfdsf', 'sdfsdf', 3),
(2, 1, '2020-08-24 18:47:54', '20200825014754_3.png', 'detalle de goslida', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_errores`
--

CREATE TABLE `tbl_log_errores` (
  `int_id_loge` bigint(20) NOT NULL,
  `text_accion_loge` text COLLATE utf8_swedish_ci NOT NULL,
  `text_descripcion_loge` text COLLATE utf8_swedish_ci NOT NULL,
  `date_fecha_loge` datetime NOT NULL,
  `int_id_usu` bigint(20) NOT NULL,
  `text_controller_loge` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `text_func_accion_loge` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_errores`
--

INSERT INTO `tbl_log_errores` (`int_id_loge`, `text_accion_loge`, `text_descripcion_loge`, `date_fecha_loge`, `int_id_usu`, `text_controller_loge`, `text_func_accion_loge`) VALUES
(3, 'Creacion de usuario /-/ consulta=INSERT INTO tbl_usuarios (id_usu, documento_usu, primer_nombre_usu,segundo_nombre_usu, primer_apellido_usu, segundo_apellido_usu, telefono_1_usu, telefono_2_usu, direcion_usu, sexo_usu, correo_usu, contrasena_usu, fecha_nacimineto_usu, foto_usu) VALUES (NULL, 123213223,\'yeison\',\'sanche\',\'dasf\',\'fdsf\', 1233333444, 3213324324324, \'fdsf\', Hombre, dsf@fdsf.com, \'$2y$09$qr3v1YVHV..NdjwR5tBNE.P1DaKn/XNxfkDntZl6WaNBMPYR8wYTq\', \'2007-08-13\', \'20200822123017_1.png\')', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'@fdsf.com, \'$2y$09$qr3v1YVHV..NdjwR5tBNE.P1DaKn/XNxfkDntZl6WaNBMPYR8wYTq\', \'2007\' at line 1', '2020-08-22 12:30:17', 1, '', ''),
(4, 'Log de usuario /-/ acion=0', 'Table \'bd_sistema_ruta.tbl_log_usuario\' doesn\'t exist', '2020-08-22 12:31:37', 1, '', ''),
(5, 'Log de usuario /-/ acion=0', 'Table \'bd_sistema_ruta.tbl_log_usuario\' doesn\'t exist', '2020-08-22 12:32:35', 1, '', ''),
(6, 'Log de usuario /-/ acion=0', 'Table \'bd_sistema_ruta.tbl_log_usuario\' doesn\'t exist', '2020-08-22 12:33:15', 1, '', ''),
(7, 'Log de usuario /-/ acion=0', 'Unknown column \'int_id_logu\' in \'field list\'', '2020-08-22 12:33:52', 1, '', ''),
(8, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, celular_usu as Celular,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1 ', '', '2020-08-22 13:18:47', 1, 'usuario', 'cargar'),
(9, 'Actualizar usuario /-/ consulta=UPDATE `tbl_usuario_datos_generales` \r\n                  SET \r\n                    primer_nombre_usu=administrador\r\n                    segundo_nombre_usu=administrador\r\n                    primer_apellido_usu=administrador\r\n                    segundo_apellido_usu=administrador\r\n                    telefono_1_usu=23232133444\r\n                    telefono_2_usu=12321321\r\n                    direcion_usu=fadfsf\r\n                    sexo_usu=Mujer\r\n                    correo_usu=WQEWQ@DSD.COM\r\n                    fecha_nacimineto_usu=2006-01-31\r\n                    `foto_usu` = \'20200822145718_1.png\'\r\n                  WHERE `tbl_usuarios`.`int_id_usu` =1', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'segundo_nombre_usu=administrador\r\n                    primer_apellido_usu=admini\' at line 4', '2020-08-22 14:57:18', 1, '', ''),
(10, 'Actualizar usuario /-/ consulta=UPDATE `tbl_usuario_datos_generales` \r\n                  SET \r\n                    primer_nombre_usu=administrador,\r\n                    segundo_nombre_usu=administrador,\r\n                    primer_apellido_usu=administrador,\r\n                    segundo_apellido_usu=administrador,\r\n                    telefono_1_usu=23232133444,\r\n                    telefono_2_usu=12321321,\r\n                    direcion_usu=fadfsf,\r\n                    sexo_usu=Mujer,\r\n                    correo_usu=WQEWQ@DSD.COM,\r\n                    fecha_nacimineto_usu=2006-01-31,\r\n                    `foto_usu` = \'20200822145757_1.png\'\r\n                  WHERE `tbl_usuarios`.`int_id_usu` =1', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'@DSD.COM,\r\n                    fecha_nacimineto_usu=2006-01-31,\r\n               \' at line 11', '2020-08-22 14:57:57', 1, '', ''),
(11, 'Actualizar usuario /-/ consulta=UPDATE `tbl_usuario_datos_generales` \r\n                  SET \r\n                    primer_nombre_usu=\'administrador\',\r\n                    segundo_nombre_usu=\'administrador\',\r\n                    primer_apellido_usu=\'administrador\',\r\n                    segundo_apellido_usu=\'administrador\',\r\n                    telefono_1_usu=23232133444,\r\n                    telefono_2_usu=12321321,\r\n                    direcion_usu=\'fadfsf\',\r\n                    sexo_usu=\'Mujer\',\r\n                    correo_usu=\'WQEWQ@DSD.COM\',\r\n                    fecha_nacimineto_usu=\'2006-01-31\',\r\n                    `foto_usu` = \'20200822145846_1.png\'\r\n                  WHERE `tbl_usuarios`.`int_id_usu` =1', 'Table \'bd_sistema_ruta.tbl_usuario_datos_generales\' doesn\'t exist', '2020-08-22 14:58:46', 1, '', ''),
(12, 'Actualizar usuario /-/ consulta=UPDATE `tbl_usuarios` \r\n                  SET \r\n                    primer_nombre_usu=\'administrador\',\r\n                    segundo_nombre_usu=\'administrador\',\r\n                    primer_apellido_usu=\'administrador\',\r\n                    segundo_apellido_usu=\'administrador\',\r\n                    telefono_1_usu=23232133444,\r\n                    telefono_2_usu=12321321,\r\n                    direcion_usu=\'fadfsf\',\r\n                    sexo_usu=\'Mujer\',\r\n                    correo_usu=\'WQEWQ@DSD.COM\',\r\n                    fecha_nacimineto_usu=\'2006-01-31\',\r\n                    `foto_usu` = \'20200822145914_1.png\'\r\n                  WHERE `tbl_usuarios`.`int_id_usu` =1', 'Unknown column \'tbl_usuarios.int_id_usu\' in \'where clause\'', '2020-08-22 14:59:14', 1, '', ''),
(13, 'Log de usuario /-/ acion=1', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION)', '2020-08-22 14:59:35', 1, '', ''),
(14, 'Actualizar usuario /-/ consulta=UPDATE `tbl_usuarios` \r\n                  SET \r\n                    primer_nombre_usu=\'administrador\',\r\n                    segundo_nombre_usu=\'administrador\',\r\n                    primer_apellido_usu=\'administrador\',\r\n                    segundo_apellido_usu=\'administrador\',\r\n                    telefono_1_usu=23232133444,\r\n                    telefono_2_usu=12321321,\r\n                    direcion_usu=\'fadfsf\',\r\n                    sexo_usu=\'Mujer\',\r\n                    correo_usu=\'WQEWQ@DSD.COM\',\r\n                    fecha_nacimineto_usu=\'2006-01-31,\r\n                    \r\n                  WHERE `tbl_usuarios`.`id_usu` =1', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\'2006-01-31,\r\n                    \r\n                  WHERE `tbl_usuarios`.`id_u\' at line 12', '2020-08-22 15:20:02', 1, '', ''),
(15, 'Actualizar usuario /-/ consulta=UPDATE `tbl_usuarios` \r\n                  SET \r\n                    primer_nombre_usu=\'administrador\',\r\n                    segundo_nombre_usu=\'administrador\',\r\n                    primer_apellido_usu=\'administrador\',\r\n                    segundo_apellido_usu=\'administrador\',\r\n                    telefono_1_usu=23232133444,\r\n                    telefono_2_usu=12321321,\r\n                    direcion_usu=\'fadfsf\',\r\n                    sexo_usu=\'Mujer\',\r\n                    correo_usu=\'WQEWQ@DSD.COM\',\r\n                    fecha_nacimineto_usu=\'2006-01-31\',\r\n                    \r\n                  WHERE `tbl_usuarios`.`id_usu` =1', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'WHERE `tbl_usuarios`.`id_usu` =1\' at line 14', '2020-08-22 15:20:31', 1, '', ''),
(16, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1  AND int_estado_usu = 0', '', '2020-08-22 16:03:25', 1, 'usuario', 'cargar'),
(17, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1  AND int_estado_usu = 0', '', '2020-08-22 16:04:07', 1, 'usuario', 'cargar'),
(18, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1  AND id_usu = 3 AND documento_usu = ', '', '2020-08-22 16:25:33', 1, 'usuario', 'cargar'),
(19, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1  AND documento_usu = ', '', '2020-08-22 16:25:38', 1, 'usuario', 'cargar'),
(20, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1  AND documento_usu = ', '', '2020-08-22 16:25:57', 1, 'usuario', 'cargar'),
(21, 'Creacion de tipo vendedor /-/ consulta=INSERT INTO tbl_tipo_gasto (id_tipog, nombre_tipog, tipo_tipog, id_usu) VALUES (NULL, \'gasolina\', \'1\', \'3\'))', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \')\' at line 1', '2020-08-25 00:45:29', 3, '', ''),
(22, 'Creacion de tipo vendedor /-/ consulta=INSERT INTO `tbl_gasto` (`id_gas`, `valor_gas`, `fecha_gas`, `evidencia_gas`, `nota_gas`, `id_usu`) VALUES (NULL, \'1.000\', now(), \'20200825014635_3.png\', \'detalle de goslida\', \'3\'))', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \')\' at line 1', '2020-08-25 01:46:35', 3, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_gasto`
--

CREATE TABLE `tbl_log_gasto` (
  `id_logg` bigint(20) NOT NULL,
  `accion_logg` text COLLATE utf8_swedish_ci NOT NULL,
  `movimiento_logg` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,3-DESACTIVAR',
  `fecha_logg` datetime NOT NULL,
  `id_gas` bigint(20) NOT NULL,
  `nota_logg` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_gasto`
--

CREATE TABLE `tbl_tipo_gasto` (
  `id_tipog` bigint(20) NOT NULL,
  `nombre_tipog` text COLLATE utf8_swedish_ci NOT NULL,
  `tipo_tipog` int(11) NOT NULL,
  `id_usu` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_tipo_gasto`
--

INSERT INTO `tbl_tipo_gasto` (`id_tipog`, `nombre_tipog`, `tipo_tipog`, `id_usu`) VALUES
(1, 'gasolina', 1, 3),
(2, 'gasolina', 1, 3),
(3, 'comida', 1, 3),
(4, '', 1, 3),
(5, '', 1, 3),
(6, '1', 1, 3),
(7, '1', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usu` bigint(20) NOT NULL,
  `documento_usu` bigint(20) NOT NULL,
  `primer_nombre_usu` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `segundo_nombre_usu` text COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `primer_apellido_usu` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `segundo_apellido_usu` text COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `telefono_1_usu` bigint(20) NOT NULL DEFAULT 0,
  `telefono_2_usu` bigint(20) NOT NULL DEFAULT 0,
  `direcion_usu` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `sexo_usu` int(11) NOT NULL,
  `correo_usu` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `contrasena_usu` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `fecha_nacimineto_usu` datetime NOT NULL,
  `foto_usu` text COLLATE utf8mb4_swedish_ci DEFAULT 'usuario.jpg',
  `estado_usu` int(11) NOT NULL DEFAULT 1,
  `rol_usu` int(11) NOT NULL COMMENT '0-administrador,1-coordinador,2-cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usu`, `documento_usu`, `primer_nombre_usu`, `segundo_nombre_usu`, `primer_apellido_usu`, `segundo_apellido_usu`, `telefono_1_usu`, `telefono_2_usu`, `direcion_usu`, `sexo_usu`, `correo_usu`, `contrasena_usu`, `fecha_nacimineto_usu`, `foto_usu`, `estado_usu`, `rol_usu`) VALUES
(1, 1, 'administrador', 'administrador', 'administrador', 'administrador', 23232133444, 12321321, 'fadfsf', 0, 'WQEWQ@DSD.COM', '$2y$09$aaZZB8K25K6GAKYDNbfmwOyRTB1HdPM7E5kjWTbG9ASbh86oeXFRe', '2006-01-31 00:00:00', '20200822151044_1.png', 1, 0),
(2, 2, '1', '1', '1', '1', 0, 0, '1', 0, '2', '$2y$09$aaZZB8K25K6GAKYDNbfmwOyRTB1HdPM7E5kjWTbG9ASbh86oeXFRe', '2020-08-18 02:28:33', 'usuario.jpg', 1, 1),
(3, 3, '1', '1', '1', '1', 0, 0, '1', 1, '4', '$2y$09$aaZZB8K25K6GAKYDNbfmwOyRTB1HdPM7E5kjWTbG9ASbh86oeXFRe', '2020-08-18 02:28:33', 'usuario.jpg', 1, 2),
(9, 123213223, 'yeison', 'sanche', 'dasf', 'fdsf', 1233333444, 3213324324324, 'fdsf', 0, 'dsf@fdsf.com', '$2y$10$nipZHlZ.aAzgkx3ScH.Uwud.hw/A3FUEnmEeMyuJYbCwy2s8vtE36', '2007-08-13 00:00:00', '20200822123449_1.png', 1, 0),
(10, 1000898270, 'yeison', 'sanchez', 'arley', 'sanchez', 573015651772, 573015651772, 'calle 78c', 0, 'j.arley111@gmail.com', '$2y$09$QWHJ/pXjbd1hh8bZWXYIjOAnZf7HemMHZ4Vg1YZ569T2zTx9oYp2i', '1992-02-05 00:00:00', '20200822172833_1.png', 1, 0),
(11, 99999999999, 'coordidador', 'coordidador', 'coordidador', 'coordidador', 1234567890, 123456783456, 'calle', 0, 'j.a@dfsd.com', '$2y$09$w21TZs59Dni6u.5mbZ5v1.ysPGKyDAJgDJpQHl08ohR/j45eLkdD.', '2007-08-13 00:00:00', '20200822174021_1.png', 1, 1),
(12, 11111111111, 'vendedor', 'vendedor', 'vendedor', 'vendedor', 1111111111111, 1111111111111111, '111111111111', 0, 'j.arley@dfsdf.com', '$2y$09$OEVUaw/ctjZXYHiylkmR.edXFM62KsMdo8JYConn6bzNwE/c7OwuK', '2007-08-13 00:00:00', '20200822174150_1.png', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  ADD PRIMARY KEY (`id_gas`),
  ADD KEY `FK_USUARIO` (`id_usu`);

--
-- Indices de la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  ADD PRIMARY KEY (`int_id_loge`),
  ADD KEY `FK_USUARIO-ERRORES` (`int_id_usu`);

--
-- Indices de la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  ADD PRIMARY KEY (`id_logg`),
  ADD KEY `FK_GASTO` (`id_gas`);

--
-- Indices de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD PRIMARY KEY (`id_logu`),
  ADD KEY `FK_USUARIO-LOG` (`id_usu`);

--
-- Indices de la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  ADD PRIMARY KEY (`id_tipog`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `UNIQUE_CORREO` (`correo_usu`) USING HASH;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  MODIFY `id_gas` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  MODIFY `int_id_loge` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  MODIFY `id_logg` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  MODIFY `id_logu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  MODIFY `id_tipog` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  ADD CONSTRAINT `tbl_gasto_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  ADD CONSTRAINT `tbl_log_errores_ibfk_1` FOREIGN KEY (`int_id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  ADD CONSTRAINT `tbl_log_gasto_ibfk_1` FOREIGN KEY (`id_gas`) REFERENCES `tbl_gasto` (`id_gas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
