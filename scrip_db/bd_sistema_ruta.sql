-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-09-2020 a las 01:41:11
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarCliente` (IN `id` BIGINT)  NO SQL
BEGIN
SELECT * FROM tbl_cliente WHERE id_clie=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarUsuario` (IN `id` BIGINT)  NO SQL
BEGIN
SELECT * FROM tbl_usuarios WHERE id_usu=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarLogErrores` (IN `fecha_ini` TEXT, IN `fecha_fin` TEXT)  NO SQL
BEGIN
DELETE FROM tbl_log_errores WHERE date_fecha_loge <= fecha_fin AND date_fecha_loge >= fecha_ini;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logCliente` (IN `movimiento` INT, IN `id` BIGINT, IN `autor` BIGINT, IN `accion_func` TEXT, IN `controller` TEXT)  NO SQL
BEGIN
INSERT INTO tbl_log_cliente (id_logc,movimiento_logc,fecha_logc,id_usu,controller_logc,id_autor_usu,accion_func_logc) VALUES (NULL, movimiento,now(),id,controller,autor,accion_func);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logErrores` (IN `accion` TEXT, IN `descripcion` TEXT, IN `id_usu` BIGINT, IN `controller` TEXT, IN `accion_func` TEXT)  NO SQL
BEGIN
    INSERT INTO `tbl_log_errores` (`int_id_loge`, `text_accion_loge`, `text_descripcion_loge`, `date_fecha_loge`, `int_id_usu`,text_controller_loge,text_func_accion_loge) VALUES (NULL, accion,descripcion,now(),id_usu,controller,accion_func);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logGasto` (IN `movimiento` TEXT, IN `id_gasto` BIGINT, IN `controller` TEXT, IN `autor` BIGINT, IN `accion` TEXT, IN `valor` DOUBLE, IN `nota` TEXT, IN `latitud` TEXT, IN `longitud` TEXT)  NO SQL
BEGIN
	INSERT INTO `tbl_log_gasto` (`id_logg`, `movimiento_logg`, `fecha_logg`, `id_gas`, `controller_logg`, `id_autor_gas`, `accion_func_logu`,valor_logg, nota_logg, latitud_logg, longitud_logg) VALUES (NULL, movimiento, now(), id_gasto, controller, autor, accion,valor,nota,latitud,longitud);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginCorreo` (IN `dataUsuario` TEXT)  NO SQL
BEGIN
SELECT * FROM tbl_usuarios WHERE correo_usu = dataUsuario and estado_usu=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginDocumento` (IN `dataUsuario` TEXT)  NO SQL
BEGIN
	SELECT * FROM tbl_usuarios WHERE documento_usu = dataUsuario and estado_usu=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logPrestamo` (IN `movimiento` TEXT, IN `id_pres` BIGINT, IN `controller` TEXT, IN `autor` BIGINT, IN `accion` TEXT, IN `id_clie` BIGINT, IN `nota` TEXT, IN `valor` DOUBLE, IN `tipo` INT, IN `latitud` TEXT, IN `longitud` TEXT, IN `ip_logp` TEXT)  NO SQL
BEGIN
	INSERT INTO `tbl_log_prestamo` (`id_logp`, `movimiento_logp`, `fecha_logp`, `id_pres`, `controller_logp`, `id_autor_usu`, `accion_func_logp`,id_clie,nota_logp,valor_pres_logp,forma_pago_logp,latitud_logp,longitud_logp,ip_logp) VALUES (NULL, movimiento, now(), id_pres, controller, autor, accion,id_clie,nota,valor,tipo,latitud,longitud,ip_logp);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logTipoGasto` (IN `movimiento` TEXT, IN `id_gasto` BIGINT, IN `controller` TEXT, IN `autor` BIGINT, IN `accion` INT)  NO SQL
BEGIN
	INSERT INTO `tbl_log_tipo_gasto` (`id_logt`, `movimiento_logt`, `fecha_logt`, `id_tipo_gasto_logt`, `controller_logt`, `id_autor_ust`, `accion_func_logt`) VALUES (NULL, movimiento, now(), id_gasto, controller, autor, accion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logUsuarios` (IN `movimiento` TEXT, IN `id` BIGINT, IN `autor` BIGINT, IN `accion_func` TEXT, IN `controller` TEXT)  NO SQL
BEGIN
INSERT INTO tbl_log_usuarios (id_logu,movimiento_logu,fecha_logu,id_usu,id_autor_usu,controller_logu,accion_func_logu) VALUES (NULL, movimiento,now(),id,autor,controller,accion_func);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerAdministradores` ()  NO SQL
BEGIN
	SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios WHERE rol_usu = 0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerCliente` (IN `id` BIGINT)  NO SQL
BEGIN
	SELECT id_clie,primer_nombre_clie,segundo_nombre_clie,primer_apellido_clie,segundo_apellido_clie, documento_clie FROM tbl_cliente WHERE id_usu=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerCoordinadores` ()  NO SQL
BEGIN
	SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios WHERE rol_usu = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerGasto` (IN `id` BIGINT)  NO SQL
BEGIN
SELECT * FROM tbl_gasto 
LEFT JOIN tbl_log_gasto on (tbl_gasto.id_gas=tbl_log_gasto.id_gas)
INNER JOIN tbl_tipo_gasto on (tbl_tipo_gasto.id_tipog = tbl_gasto.id_tipo_tipog)
INNER JOIN tbl_usuarios on (tbl_usuarios.id_usu = tbl_gasto.id_usu)
WHERE tbl_gasto.id_gas=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerSumaGastosUsuario` (IN `id` BIGINT)  NO SQL
BEGIN
SELECT SUM(tbl_gasto.valor_gas) as total,tbl_gasto.estado_gas as estado
FROM `tbl_gasto`
WHERE tbl_gasto.id_usu=id
GROUP BY tbl_gasto.estado_gas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerUsuario` ()  NO SQL
BEGIN
	SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerUsuarioCoordinador` (IN `coordinador` BIGINT)  NO SQL
BEGIN
SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios WHERE id_coordinador_usu = coordinador;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerVendedores` ()  NO SQL
BEGIN
	SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios WHERE rol_usu = 2;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cliente`
--

CREATE TABLE `tbl_cliente` (
  `id_clie` bigint(20) NOT NULL,
  `documento_clie` bigint(20) NOT NULL,
  `documento_ref_clie` bigint(20) NOT NULL,
  `primer_nombre_clie` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `segundo_nombre_clie` text COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `primer_apellido_clie` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `segundo_apellido_clie` text COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `telefono_1_clie` bigint(20) NOT NULL DEFAULT 0,
  `telefono_2_clie` bigint(20) NOT NULL DEFAULT 0,
  `direcion_clie` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `direcion_cobro_clie` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `sexo_clie` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `correo_clie` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `fecha_nacimineto_clie` datetime NOT NULL,
  `foto_clie` text COLLATE utf8mb4_swedish_ci DEFAULT '\'usuario.jpg\'',
  `estado_clie` int(11) NOT NULL DEFAULT 1,
  `estado_localidad_clie` text COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'No tiene',
  `ciudad_localidad_clie` text COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'No tiene',
  `id_usu` bigint(20) NOT NULL DEFAULT 0,
  `prestamo_minimo_client` int(11) NOT NULL,
  `prestamo_maximo_client` int(11) NOT NULL,
  `orden_ruta_clie` int(11) NOT NULL,
  `cumplimineto_client` int(11) NOT NULL DEFAULT 0 COMMENT '0-no pago,1-pago'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_cliente`
--

INSERT INTO `tbl_cliente` (`id_clie`, `documento_clie`, `documento_ref_clie`, `primer_nombre_clie`, `segundo_nombre_clie`, `primer_apellido_clie`, `segundo_apellido_clie`, `telefono_1_clie`, `telefono_2_clie`, `direcion_clie`, `direcion_cobro_clie`, `sexo_clie`, `correo_clie`, `fecha_nacimineto_clie`, `foto_clie`, `estado_clie`, `estado_localidad_clie`, `ciudad_localidad_clie`, `id_usu`, `prestamo_minimo_client`, `prestamo_maximo_client`, `orden_ruta_clie`, `cumplimineto_client`) VALUES
(11, 123456789, 123456789, 'primer', '', 'cliente', '', 1234567890, 1234567890, '123456789', '123456789', 'Hombre', '1@gmail.com', '2007-08-31 00:00:00', 'usuario.jpg', 1, '4', '206', 4, 200, 300, 3, 0),
(12, 123456789, 123456789, 'segundo', '', 'cliente', '', 1234567890, 1234567890, '123456789', '123456789', 'Hombre', '2@GMAIL.COM', '2007-08-31 00:00:00', 'usuario.jpg', 1, '4', '207', 4, 200, 300, 1, 0),
(13, 1234567890, 1234567890, 'tercer', '', 'cliente', '', 1234567890, 1234567890, '1234567890', '1234567890', 'Hombre', '3@GMAIL.COM', '2007-08-31 00:00:00', 'usuario.jpg', 1, '4', '205', 4, 200, 300, 2, 0),
(14, 1234567890, 1234567890, 'cuarto', '', 'cliente', '', 1234567890, 1234567890, '1234567890', '1234567890', 'Hombre', '4@GMAIL.COM', '2007-08-31 00:00:00', 'usuario.jpg', 1, '6', '702', 4, 200, 300, 4, 0),
(15, 1234567890, 1234567890, 'quinto', '', 'cliente', '', 1234567890, 1234567890, '1234567890', '1234567890', 'Hombre', '5@GMAIL.COM', '2007-08-31 00:00:00', 'usuario.jpg', 1, '2', '104', 3, 200, 300, 5, 0),
(16, 1234567890, 1234567890, 'sexto', '', 'cliente', '', 1234567890, 1234567890, '1234567890', '1234567890', 'Hombre', '6@GMAIL.COM', '2007-08-31 00:00:00', 'usuario.jpg', 1, '2', '101', 3, 200, 300, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_gasto`
--

CREATE TABLE `tbl_gasto` (
  `id_gas` bigint(20) NOT NULL,
  `valor_gas` double NOT NULL,
  `fecha_gas` datetime NOT NULL,
  `evidencia_gas` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_usu` bigint(20) NOT NULL,
  `id_tipo_tipog` bigint(20) NOT NULL,
  `estado_gas` int(11) NOT NULL DEFAULT 0,
  `pagado_gasto_gas` double NOT NULL DEFAULT 0,
  `valor_total_gas` double NOT NULL DEFAULT 0,
  `nota_gas` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_gasto`
--

INSERT INTO `tbl_gasto` (`id_gas`, `valor_gas`, `fecha_gas`, `evidencia_gas`, `id_usu`, `id_tipo_tipog`, `estado_gas`, `pagado_gasto_gas`, `valor_total_gas`, `nota_gas`) VALUES
(27, 0, '2020-09-12 16:20:27', '20200912232027_3.png', 3, 7, 1, 0, 200, ''),
(28, 200, '2020-09-12 17:30:46', '20200913003046_3.png', 3, 4, 1, 200, 200, 'dd'),
(29, 200, '2020-09-12 18:27:56', '20200913012756_3.png', 3, 1, 3, 0, 200, 'gg'),
(30, 0, '2020-09-12 18:29:28', '20200913012928_3.png', 3, 1, 1, 200, 200, 'ffff'),
(31, 0, '2020-09-12 18:34:16', '20200913013416_3.png', 3, 1, 1, 200, 200, 'ddd'),
(32, 200, '2020-09-12 18:37:15', '20200913013715_3.png', 3, 2, 3, 0, 200, 'dsadsa'),
(33, 0, '2020-09-12 18:37:29', '20200913013729_3.png', 3, 1, 1, 321312, 321312, '231233');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_cliente`
--

CREATE TABLE `tbl_log_cliente` (
  `id_logc` bigint(20) NOT NULL,
  `movimiento_logc` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,3-DESACTIVAR',
  `fecha_logc` datetime NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `controller_logc` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_usu` bigint(20) NOT NULL,
  `accion_func_logc` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_cliente`
--

INSERT INTO `tbl_log_cliente` (`id_logc`, `movimiento_logc`, `fecha_logc`, `id_usu`, `controller_logc`, `id_autor_usu`, `accion_func_logc`) VALUES
(1, 0, '2020-09-05 20:51:41', 2, '3', 0, 'save'),
(2, 0, '2020-09-05 20:55:14', 3, 'cliente', 3, 'save'),
(3, 0, '2020-09-05 21:00:10', 4, 'cliente', 3, 'save'),
(4, 1, '2020-09-05 23:41:32', 2, 'cliente', 3, 'update'),
(5, 1, '2020-09-05 23:43:51', 2, 'cliente', 3, 'update'),
(6, 1, '2020-09-06 00:04:47', 2, 'cliente', 3, 'update'),
(7, 1, '2020-09-06 00:05:50', 2, 'cliente', 3, 'update'),
(8, 1, '2020-09-06 00:07:24', 2, 'cliente', 3, 'update'),
(9, 1, '2020-09-06 00:08:42', 2, 'cliente', 3, 'update'),
(10, 1, '2020-09-06 00:09:21', 2, 'cliente', 3, 'update'),
(11, 2, '2020-09-07 03:08:24', 0, 'cliente', 3, 'orden'),
(12, 2, '2020-09-07 03:15:50', 4, 'cliente', 3, 'orden'),
(13, 2, '2020-09-07 03:16:58', 4, 'cliente', 3, 'orden'),
(14, 2, '2020-09-07 03:16:58', 3, 'cliente', 3, 'orden'),
(15, 2, '2020-09-07 03:19:10', 2, 'cliente', 3, 'orden'),
(16, 2, '2020-09-07 03:19:10', 4, 'cliente', 3, 'orden'),
(17, 2, '2020-09-07 03:21:42', 2, 'cliente', 3, 'orden'),
(18, 2, '2020-09-07 03:21:42', 4, 'cliente', 3, 'orden'),
(19, 2, '2020-09-07 03:22:53', 2, 'cliente', 3, 'orden'),
(20, 2, '2020-09-07 03:22:53', 4, 'cliente', 3, 'orden'),
(21, 2, '2020-09-07 03:24:55', 2, 'cliente', 3, 'orden'),
(22, 2, '2020-09-07 03:24:56', 4, 'cliente', 3, 'orden'),
(23, 2, '2020-09-07 03:25:47', 4, 'cliente', 3, 'orden'),
(24, 2, '2020-09-07 03:25:48', 2, 'cliente', 3, 'orden'),
(25, 2, '2020-09-07 03:25:53', 2, 'cliente', 3, 'orden'),
(26, 2, '2020-09-07 03:25:53', 4, 'cliente', 3, 'orden'),
(27, 2, '2020-09-07 03:25:58', 3, 'cliente', 3, 'orden'),
(28, 2, '2020-09-07 03:25:58', 2, 'cliente', 3, 'orden'),
(29, 2, '2020-09-07 03:28:17', 3, 'cliente', 3, 'orden'),
(30, 2, '2020-09-07 03:28:17', 4, 'cliente', 3, 'orden'),
(31, 2, '2020-09-07 03:28:32', 2, 'cliente', 3, 'orden'),
(32, 2, '2020-09-07 03:28:32', 3, 'cliente', 3, 'orden'),
(33, 2, '2020-09-07 03:28:37', 2, 'cliente', 3, 'orden'),
(34, 2, '2020-09-07 03:28:37', 3, 'cliente', 3, 'orden'),
(35, 2, '2020-09-07 03:28:41', 4, 'cliente', 3, 'orden'),
(36, 2, '2020-09-07 03:28:41', 3, 'cliente', 3, 'orden'),
(37, 2, '2020-09-07 03:29:29', 3, 'cliente', 3, 'orden'),
(38, 2, '2020-09-07 03:29:30', 4, 'cliente', 3, 'orden'),
(39, 2, '2020-09-07 03:29:33', 2, 'cliente', 3, 'orden'),
(40, 2, '2020-09-07 03:29:33', 4, 'cliente', 3, 'orden'),
(41, 2, '2020-09-07 03:29:37', 2, 'cliente', 3, 'orden'),
(42, 2, '2020-09-07 03:29:37', 4, 'cliente', 3, 'orden'),
(43, 2, '2020-09-07 03:29:40', 3, 'cliente', 3, 'orden'),
(44, 2, '2020-09-07 03:29:41', 4, 'cliente', 3, 'orden'),
(45, 2, '2020-09-07 03:30:07', 3, 'cliente', 3, 'orden'),
(46, 2, '2020-09-07 03:30:07', 4, 'cliente', 3, 'orden'),
(47, 2, '2020-09-07 03:33:41', 3, 'cliente', 3, 'orden'),
(48, 2, '2020-09-07 03:33:41', 4, 'cliente', 3, 'orden'),
(49, 2, '2020-09-07 03:33:51', 3, 'cliente', 3, 'orden'),
(50, 2, '2020-09-07 03:33:52', 4, 'cliente', 3, 'orden'),
(51, 2, '2020-09-07 03:33:55', 2, 'cliente', 3, 'orden'),
(52, 2, '2020-09-07 03:33:55', 4, 'cliente', 3, 'orden'),
(53, 2, '2020-09-07 03:33:59', 2, 'cliente', 3, 'orden'),
(54, 2, '2020-09-07 03:33:59', 3, 'cliente', 3, 'orden'),
(55, 2, '2020-09-07 12:43:14', 2, 'cliente', 3, 'orden'),
(56, 2, '2020-09-07 12:43:14', 3, 'cliente', 3, 'orden'),
(57, 2, '2020-09-08 23:17:56', 2, 'cliente', 3, 'orden'),
(58, 2, '2020-09-08 23:17:56', 3, 'cliente', 3, 'orden'),
(59, 2, '2020-09-09 16:08:27', 3, 'cliente', 3, 'orden'),
(60, 2, '2020-09-09 16:08:27', 2, 'cliente', 3, 'orden'),
(61, 2, '2020-09-09 16:08:33', 4, 'cliente', 3, 'orden'),
(62, 2, '2020-09-09 16:08:33', 2, 'cliente', 3, 'orden'),
(63, 0, '2020-09-09 17:46:16', 5, 'cliente', 4, 'save'),
(64, 0, '2020-09-09 17:47:13', 6, 'cliente', 4, 'save'),
(65, 0, '2020-09-09 17:48:05', 7, 'cliente', 4, 'save'),
(66, 0, '2020-09-09 17:49:35', 8, 'cliente', 4, 'save'),
(67, 0, '2020-09-09 18:33:36', 9, 'cliente', 4, 'save'),
(68, 0, '2020-09-09 18:35:11', 10, 'cliente', 4, 'save'),
(69, 0, '2020-09-09 18:36:56', 11, 'cliente', 4, 'save'),
(70, 0, '2020-09-09 18:37:55', 12, 'cliente', 4, 'save'),
(71, 0, '2020-09-09 18:38:40', 13, 'cliente', 4, 'save'),
(72, 0, '2020-09-09 18:39:23', 14, 'cliente', 4, 'save'),
(73, 2, '2020-09-09 18:40:06', 12, 'cliente', 4, 'orden'),
(74, 2, '2020-09-09 18:40:06', 11, 'cliente', 4, 'orden'),
(75, 2, '2020-09-09 18:40:11', 11, 'cliente', 4, 'orden'),
(76, 2, '2020-09-09 18:40:11', 13, 'cliente', 4, 'orden'),
(77, 0, '2020-09-09 18:53:04', 15, 'cliente', 3, 'save'),
(78, 0, '2020-09-09 18:53:59', 16, 'cliente', 3, 'save'),
(79, 4, '2020-09-09 21:13:06', 13, 'abono', 4, 'abonarPago'),
(80, 4, '2020-09-10 00:43:20', 13, 'abono', 4, 'abonarPago'),
(81, 4, '2020-09-10 02:30:18', 13, 'abono', 4, 'abonarPago'),
(82, 4, '2020-09-10 02:31:23', 11, 'abono', 4, 'abonarPago'),
(83, 4, '2020-09-10 02:37:18', 12, 'abono', 4, 'abonarPago'),
(84, 4, '2020-09-12 14:35:41', 14, 'abono', 4, 'abonarPago'),
(85, 4, '2020-09-12 15:23:00', 14, 'abono', 4, 'abonarPago'),
(86, 4, '2020-09-12 15:44:49', 11, 'abono', 4, 'abonarPago'),
(87, 4, '2020-09-12 16:00:41', 11, 'abono', 4, 'abonarPago');

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
(1, 'c=usuario a=cargar /-/ consulta=SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado, FROM tbl_usuarios WHERE 1 ', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'FROM tbl_usuarios WHERE 1\' at line 1', '2020-08-25 20:21:59', 1, 'usuario', 'cargar'),
(2, 'Consulta de dataTable => SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,\' \',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,\' \',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado, FROM tbl_usuarios WHERE 1 ', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'FROM tbl_usuarios WHERE 1\' at line 1', '2020-08-25 20:25:36', 1, 'usuario', 'cargar'),
(3, ' => CALL logUsuarios(\'3.\',\'0\',1,\'cambiar_estado\',\'usuario\')', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE)', '2020-08-25 20:40:13', 1, 'usuario', 'cambiar_estado'),
(4, ' => CALL logUsuarios(\'3.\',\'0\',1,\'cambiar_estado\',\'usuario\')', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE)', '2020-08-25 20:40:30', 1, 'usuario', 'cambiar_estado'),
(5, ' => CALL logUsuarios(\'3.\',\'0\',1,\'cambiar_estado\',\'usuario\')', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE)', '2020-08-25 20:41:36', 1, 'usuario', 'cambiar_estado'),
(6, ' => CALL logUsuarios(\'3.\',\'0\',1,\'cambiar_estado\',\'usuario\')', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE)', '2020-08-25 20:41:50', 1, 'usuario', 'cambiar_estado'),
(7, ' => CALL logUsuarios(\'3\',\'0\',1,\'cambiar_estado\',\'usuario\')', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE)', '2020-08-25 20:47:21', 1, 'usuario', 'cambiar_estado'),
(8, ' => CALL logUsuarios(\'1\',\'0\',1,\'update\',\'usuario\')', 'Cannot add or update a child row: a foreign key constraint fails (`bd_sistema_ruta`.`tbl_log_usuarios`, CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE)', '2020-08-25 21:04:50', 1, 'usuario', 'update'),
(9, ' => CALL logTipoGasto(\'0\',\'1\',\'tipo_gasto\',3,\'save\')', 'Column \'id_logt\' cannot be null', '2020-08-28 00:04:42', 3, 'tipo_gasto', 'save'),
(10, 'creacion de usuarios. => INSERT INTO tbl_usuarios (id_usu, documento_usu, primer_nombre_usu,segundo_nombre_usu, primer_apellido_usu, segundo_apellido_usu, telefono_1_usu, telefono_2_usu, direcion_usu, sexo_usu, correo_usu, contrasena_usu, fecha_nacimineto_usu, foto_usu,rol_usu,estado_localidad_usu,ciudad_localidad_usu) VALUES (NULL, 4444444444444,\'prueba\',\'\',\'prueba\',\'\', 55555555555555, , \'fffff\', \'Mujer\', \'prueba@GMAIL.COM\', \'$2y$09$lm87QodsS4hs2h4MlprgQ.gyBNyVdc9A8b5BihPLhBPp63iwQMBba\', \'2007-08-19\', \'usuario.jpg\',2,2,101)', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \' \'fffff\', \'Mujer\', \'prueba@GMAIL.COM\', \'$2y$09$lm87QodsS4hs2h4MlprgQ.gyBNyVdc9A8\' at line 1', '2020-08-28 02:24:21', 1, 'usuario', 'save'),
(11, 'c= a= /-/ consulta=CALL obtenerGasto(2)', 'Column \'id_gas\' in where clause is ambiguous', '2020-08-28 06:48:41', 2, 'gasto', 'obtenerGasto'),
(12, 'c= a= /-/ consulta=CALL obtenerGasto()', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.obtenerGasto; expected 1, got 0', '2020-08-28 06:50:22', 2, 'gasto', 'obtenerGasto'),
(13, 'c= a= /-/ consulta=CALL obtenerGasto()', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.obtenerGasto; expected 1, got 0', '2020-08-28 06:50:41', 2, 'gasto', 'obtenerGasto'),
(14, 'c= a= /-/ consulta=CALL obtenerGasto(4)', 'Unknown column \'tbl_tipo_gasto.id_tipog\' in \'on clause\'', '2020-08-28 06:51:11', 2, 'gasto', 'obtenerGasto'),
(15, 'c= a= /-/ consulta=CALL obtenerGasto(4)', 'Unknown column \'tbl_tipo_gasto.id_tipog\' in \'on clause\'', '2020-08-28 06:55:03', 2, 'gasto', 'obtenerGasto'),
(16, 'c= a= /-/ consulta=CALL obtenerSumaGastosUsuario(3)', 'Commands out of sync; you can\'t run this command now', '2020-08-28 07:00:53', 2, 'gasto', 'obtenerGasto'),
(17, 'c= a= /-/ consulta=CALL obtenerSumaGastosUsuario()', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.obtenerSumaGastosUsuario; expected 1, got 0', '2020-08-28 07:08:12', 2, 'gasto', 'obtenerGasto'),
(26, 'Consulta de dataTable => SELECT CASE\r\n               WHEN log.movimiento_logg = 0 THEN \'Gasto propio del vendedor\'\r\n               WHEN log.movimiento_logg = 1 THEN \'Cancelado por el coordinador\'\r\n               WHEN log.movimiento_logg = 2 THEN \'Abono del coordinador\'\r\n               WHEN log.movimiento_logg = 3 THEN \'Anulado por el vendedor\'\r\n               ELSE \'Movimiento descodocido por el sistema.\'\r\n               END as movimiento,\r\n               log.fecha_logg as fecha,\r\n               CONCAT_WS(\'\', usu.primer_nombre_usu, usu.segundo_nombre_usu, usu.primer_apellido_usu, usu.segundo_apellido_usu ) as usuario,\r\n                usu.documento_usu as documento_suario,\r\n                gas.valor_gas as valor,\r\n                tipo.nombre_tipog as tipo\r\n            FROM tbl_log_gasto as log\r\n            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)\r\n            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)\r\n            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)\r\n            WHERE 1 AND log.id_autor_usu = 2', 'Unknown column \'log.id_autor_usu\' in \'where clause\'', '2020-09-02 04:12:49', 1, 'reporte_log_gasto', 'cargar_reporte'),
(27, 'Consulta de dataTable => SELECT CASE\r\n               WHEN log.movimiento_logg = 0 THEN \'Gasto propio del vendedor\'\r\n               WHEN log.movimiento_logg = 1 THEN \'Cancelado por el coordinador\'\r\n               WHEN log.movimiento_logg = 2 THEN \'Abono del coordinador\'\r\n               WHEN log.movimiento_logg = 3 THEN \'Anulado por el vendedor\'\r\n               ELSE \'Movimiento descodocido por el sistema.\'\r\n               END as movimiento,\r\n               log.fecha_logg as fecha,\r\n               CONCAT_WS(\'\', usu.primer_nombre_usu, usu.segundo_nombre_usu, usu.primer_apellido_usu, usu.segundo_apellido_usu ) as usuario,\r\n                usu.documento_usu as documento_suario,\r\n                gas.valor_gas as valor,\r\n                tipo.nombre_tipog as tipo\r\n            FROM tbl_log_gasto as log\r\n            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)\r\n            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)\r\n            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)\r\n            WHERE 1 AND log.fecha_logu >= \'2020-09-02\'', 'Unknown column \'log.fecha_logu\' in \'where clause\'', '2020-09-02 04:13:27', 1, 'reporte_log_gasto', 'cargar_reporte'),
(28, 'Consulta de dataTable => SELECT CASE\r\n               WHEN log.movimiento_logg = 0 THEN \'Gasto propio del vendedor\'\r\n               WHEN log.movimiento_logg = 1 THEN \'Cancelado por el coordinador\'\r\n               WHEN log.movimiento_logg = 2 THEN \'Abono del coordinador\'\r\n               WHEN log.movimiento_logg = 3 THEN \'Anulado por el vendedor\'\r\n               ELSE \'Movimiento descodocido por el sistema.\'\r\n               END as movimiento,\r\n               log.fecha_logg as fecha,\r\n               CONCAT_WS(\'\', usu.primer_nombre_usu, usu.segundo_nombre_usu, usu.primer_apellido_usu, usu.segundo_apellido_usu ) as usuario,\r\n                usu.documento_usu as documento_suario,\r\n                gas.valor_gas as valor,\r\n                tipo.nombre_tipog as tipo\r\n            FROM tbl_log_gasto as log\r\n            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)\r\n            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)\r\n            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)\r\n            WHERE 1 AND log.fecha_logu >= \'2020-09-02\'', 'Unknown column \'log.fecha_logu\' in \'where clause\'', '2020-09-02 04:13:40', 1, 'reporte_log_gasto', 'cargar_reporte'),
(29, 'creacion de usuarios. => INSERT INTO tbl_cliente (id_usu, documento_usu, primer_nombre_usu,segundo_nombre_usu, primer_apellido_usu, segundo_apellido_usu, telefono_1_usu, telefono_2_usu, direcion_usu, sexo_usu, correo_usu, fecha_nacimineto_usu, foto_usu,rol_usu,estado_localidad_usu,ciudad_localidad_usu) VALUES (NULL, 12412443423,\'asde\',\'fdsf\',\'fdsf\',\'nbnbdf\', 4324234324234, 32432432433, \'fdsfsdfdfsf\', \'Hombre\', \'j.a@dfsd.com\', \'2007-08-25\', \'usuario.jpg\',2,5,284)', 'Column \'id_usu\' cannot be null', '2020-09-03 22:27:01', 3, 'cliente', 'save'),
(30, 'creacion de cliente. => INSERT INTO `tbl_cliente` (`id_clie`, `documento_clie`, `documento_ref_clie`, `primer_nombre_clie`, `segundo_nombre_clie`, `primer_apellido_clie`, `segundo_apellido_clie`, `telefono_1_clie`, `telefono_2_clie`, `direcion_clie`, `direcion_cobro_clie`, `sexo_clie`, `correo_clie`, `fecha_nacimineto_clie`, `foto_clie`, `estado_localidad_clie`, `ciudad_localidad_clie`, `id_usu`) VALUES (NULL, 12312322333, 123213233,\'yeison\', \'sanchez\', \'arley\', \'\', 12344234333, 234234234333, \'123fdsfdsf\', \'dsfsdf\',Hombre, \'dsf@ffff.com\', \'2007-08-27\',\'20200906034009_13.png\',4,207,20200906034009_13.png);', 'Unknown column \'Hombre\' in \'field list\'', '2020-09-05 20:40:09', 3, 'cliente', 'save'),
(31, 'creacion de cliente. => INSERT INTO `tbl_cliente` (`id_clie`, `documento_clie`, `documento_ref_clie`, `primer_nombre_clie`, `segundo_nombre_clie`, `primer_apellido_clie`, `segundo_apellido_clie`, `telefono_1_clie`, `telefono_2_clie`, `direcion_clie`, `direcion_cobro_clie`, `sexo_clie`, `correo_clie`, `fecha_nacimineto_clie`, `foto_clie`, `estado_localidad_clie`, `ciudad_localidad_clie`, `id_usu`) VALUES (NULL, 12312333213, 423432423324,\'yeison\', \'sanchez\', \'arley\', \'\', 3423423444, 4324234444, \'fsdfds\', \'fdsfsddddddd\',\'Mujer\', \'j.a@dfsd.com\', \'2002-01-07\',\'20200906034526_33.png\',3,222,20200906034526_33.png);', 'Unknown column \'20200906034526_33.png\' in \'field list\'', '2020-09-05 20:45:26', 3, 'cliente', 'save'),
(32, 'creacion de cliente. => INSERT INTO `tbl_cliente` (`id_clie`, `documento_clie`, `documento_ref_clie`, `primer_nombre_clie`, `segundo_nombre_clie`, `primer_apellido_clie`, `segundo_apellido_clie`, `telefono_1_clie`, `telefono_2_clie`, `direcion_clie`, `direcion_cobro_clie`, `sexo_clie`, `correo_clie`, `fecha_nacimineto_clie`, `foto_clie`, `estado_localidad_clie`, `ciudad_localidad_clie`, `id_usu`) VALUES (NULL, 12312333213, 423432423324,\'yeison\', \'sanchez\', \'arley\', \'\', 3423423444, 4324234444, \'fsdfds\', \'fdsfsddddddd\',\'Mujer\', \'j.a@dfsd.com\', \'2002-01-07\',\'20200906035010_93.png\',3,222,);', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \')\' at line 1', '2020-09-05 20:50:10', 3, 'cliente', 'save'),
(33, 'c= a= /-/ consulta=CALL obtenerCliente()', 'Unknown column \'primer_nombre_usu\' in \'field list\'', '2020-09-05 21:37:43', 3, 'cliente', ''),
(34, 'Consulta de dataTable => SELECT clien.id_clie as id, \r\n                       clien.documento_clie as CC, \r\n                      CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                      clien.telefono_1_usu as t1, \r\n                      clien.telefono_2_usu as t2,\r\n                      clien.correo_usu as Correo,\r\n                      clien.documento_clie as Direcionr,\r\n                      clien.documento_ref_clie as Direcionc, \r\n                      clien.fecha_nacimineto_usu as fecha_cobro, \r\n                      clien.id_clie as id_cobro  \r\n                      FROM tbl_cliente as clien  \r\n                      WHERE 1 ', 'Unknown column \'clien.telefono_1_usu\' in \'field list\'', '2020-09-05 21:46:48', 3, 'cliente', 'cargar'),
(35, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre FROM tbl_cliente as client WHERE id_clie=', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 1', '2020-09-06 02:26:38', 3, 'cliente', 'obtenerDataCliente'),
(36, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,clie.foto_clie as foto FROM tbl_cliente as client WHERE id_clie=2', 'Unknown column \'clie.foto_clie\' in \'field list\'', '2020-09-06 02:48:33', 3, 'cliente', 'obtenerDataCliente'),
(37, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,clie.foto_clie as foto FROM tbl_cliente as client WHERE id_clie=2', 'Unknown column \'clie.foto_clie\' in \'field list\'', '2020-09-06 02:50:26', 3, 'cliente', 'obtenerDataCliente'),
(38, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,client.foto_clie as foto \r\n            client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n            client.telefono_1_clie as telefono1,\r\n            client.telefono_2_clie as telefono2,\r\n            client.direcion_cobro_clie as direcionc,\r\n            client.direcion_clie as direcion,\r\n            client.correo_clie as correo,\r\n            client.fecha_nacimineto_clie as fecha\r\n        FROM tbl_cliente as client WHERE id_clie=2', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n   \' at line 2', '2020-09-06 03:25:21', 3, 'cliente', 'obtenerDataCliente'),
(39, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,client.foto_clie as foto \r\n            client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n            client.telefono_1_clie as telefono1,\r\n            client.telefono_2_clie as telefono2,\r\n            client.direcion_cobro_clie as direcionc,\r\n            client.direcion_clie as direcion,\r\n            client.correo_clie as correo,\r\n            client.fecha_nacimineto_clie as fecha\r\n        FROM tbl_cliente as client WHERE id_clie=2', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n   \' at line 2', '2020-09-06 03:25:28', 3, 'cliente', 'obtenerDataCliente'),
(40, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,client.foto_clie as foto,\r\n            client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n            client.telefono_1_clie as telefono1,\r\n            client.telefono_2_clie as telefono2,\r\n            client.direcion_cobro_clie as direcionc,\r\n            client.direcion_clie as direcion,\r\n            client.correo_clie as correo,\r\n            client.fecha_nacimineto_clie as fecha\r\n        FROM tbl_cliente as client \r\n        INNER JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres<=0)) \r\n        WHERE id_clie=2', 'Column \'id_clie\' in where clause is ambiguous', '2020-09-06 03:31:03', 3, 'cliente', 'obtenerDataCliente'),
(41, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,client.foto_clie as foto,\r\n            client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n            client.telefono_1_clie as telefono1,\r\n            client.telefono_2_clie as telefono2,\r\n            client.direcion_cobro_clie as direcionc,\r\n            client.direcion_clie as direcion,\r\n            client.correo_clie as correo,\r\n            client.fecha_nacimineto_clie as fecha,\r\n            if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,\r\n        FROM tbl_cliente as client \r\n        LEFT JOIN tbl_prestamo as pres on (pres.id_clie=client.id_clie AND (pres.valor_pres>0)) \r\n        WHERE id_clie=2', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'FROM tbl_cliente as client \r\n        LEFT JOIN tbl_prestamo as pres on (pres.id_\' at line 11', '2020-09-06 03:35:15', 3, 'cliente', 'obtenerDataCliente'),
(42, 'c= a= /-/ consulta=SELECT CONCAT_WS(\' \',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,client.foto_clie as foto,\r\n            client.documento_clie as cc,\r\n            client.documento_ref_clie as ccr,\r\n            client.telefono_1_clie as telefono1,\r\n            client.telefono_2_clie as telefono2,\r\n            client.direcion_cobro_clie as direcionc,\r\n            client.direcion_clie as direcion,\r\n            client.correo_clie as correo,\r\n            client.fecha_nacimineto_clie as fecha,\r\n            if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda\r\n        FROM tbl_cliente as client \r\n        LEFT JOIN tbl_prestamo as pres on (pres.id_clie=client.id_clie AND (pres.valor_pres>0)) \r\n        WHERE id_clie=2', 'Column \'id_clie\' in where clause is ambiguous', '2020-09-06 03:35:41', 3, 'cliente', 'obtenerDataCliente'),
(43, ' => CALL logPrestamo(\'0\',\'4\',\'prestamo\',3,\'save\')', 'Unknown column \'controller_logg\' in \'field list\'', '2020-09-07 01:33:55', 3, 'prestamo', 'save'),
(44, ' => CALL logPrestamo(\'0\',\'5\',\'prestamo\',3,\'save\')', 'Unknown column \'accion_func_logu\' in \'field list\'', '2020-09-07 01:36:10', 3, 'prestamo', 'save'),
(45, 'Consulta de dataTable => SELECT clien.id_clie as id, \r\n                       clien.documento_clie as CC, \r\n                      CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                      clien.telefono_1_clie as t1, \r\n                      clien.telefono_2_clie as t2,\r\n                      clien.correo_clie as Correo,\r\n                      clien.documento_clie as Direcionr,\r\n                      clien.documento_ref_clie as Direcionc, \r\n                      clien.fecha_nacimineto_clie as fecha_cobro,\r\n                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,\r\n                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro\r\n                      FROM tbl_cliente as clien \r\n                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) \r\n                      WHERE 1 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'ORDER BY  1 asc LIMIT 0 ,10\' at line 14', '2020-09-07 01:55:03', 3, 'cliente', 'cargar'),
(46, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=Array\r\n                  WHERE tbl_cliente.id_clie =2', 'Unknown column \'Array\' in \'field list\'', '2020-09-07 03:08:24', 3, 'cliente', 'orden'),
(47, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:10:12', 3, 'cliente', 'orden'),
(48, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:13:34', 3, 'cliente', 'orden'),
(49, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:14:05', 3, 'cliente', 'orden'),
(50, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:14:47', 3, 'cliente', 'orden'),
(51, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:15:10', 3, 'cliente', 'orden'),
(52, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=Array\r\n                  WHERE tbl_cliente.id_clie =3', 'Unknown column \'Array\' in \'field list\'', '2020-09-07 03:15:50', 3, 'cliente', 'orden'),
(53, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=3\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:17:28', 3, 'cliente', 'orden'),
(54, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=3\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:17:41', 3, 'cliente', 'orden'),
(55, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=3\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:18:12', 3, 'cliente', 'orden'),
(56, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=3\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:18:39', 3, 'cliente', 'orden'),
(57, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=2\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:20:28', 3, 'cliente', 'orden'),
(58, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:21:12', 3, 'cliente', 'orden'),
(59, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:25:25', 3, 'cliente', 'orden'),
(60, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'WHERE tbl_cliente.id_clie =\' at line 4', '2020-09-07 03:27:57', 3, 'cliente', 'orden'),
(61, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'WHERE tbl_cliente.id_clie =\' at line 4', '2020-09-07 03:28:44', 3, 'cliente', 'orden'),
(62, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:30:27', 3, 'cliente', 'orden'),
(63, 'cambiar orden cliente. => UPDATE tbl_cliente \r\n                  SET \r\n                    orden_ruta_clie=1\r\n                  WHERE tbl_cliente.id_clie =', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 4', '2020-09-07 03:30:58', 3, 'cliente', 'orden'),
(64, 'Consulta de dataTable => SELECT clien.id_clie as id, \r\n                       clien.documento_clie as CC, \r\n                      CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                      clien.telefono_1_clie as t1, \r\n                      clien.telefono_2_clie as t2,\r\n                      clien.correo_clie as Correo,\r\n                      clien.documento_clie as Direcionr,\r\n                      clien.documento_ref_clie as Direcionc, \r\n                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,\r\n                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro\r\n                      FROM tbl_cliente as clien \r\n                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) \r\n                      WHERE pres.valor_pres>0ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'BY clien.orden_ruta_clie ASC\' at line 13', '2020-09-08 22:13:50', 3, 'abono', 'cargar'),
(65, ' => CALL logPrestamo(\'1\',\'\',3,\'abonarPago\',\'abono\',\'3\',\'prueba\',\'18\')', 'Column count doesn\'t match value count at row 1', '2020-09-08 22:29:15', 3, 'abono', 'abonarPago'),
(66, ' => CALL logPrestamo(\'1\',\'9\',3,\'abonarPago\',\'abono\',\'3\',\'prueba\',\'18\')', 'Column count doesn\'t match value count at row 1', '2020-09-08 22:30:14', 3, 'abono', 'abonarPago'),
(67, ' => CALL logPrestamo(\'0\',\'10\',\'prestamo\',3,\'save\')', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.logPrestamo; expected 9, got 5', '2020-09-08 23:08:16', 3, 'prestamo', 'save'),
(68, 'Consulta de dataTable => SELECT clien.id_clie as id, \r\n                       clien.documento_clie as CC, \r\n                      CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                      clien.telefono_1_clie as t1, \r\n                      clien.telefono_2_clie as t2,\r\n                      clien.correo_clie as Correo,\r\n                      clien.documento_clie as Direcionr,\r\n                      clien.documento_ref_clie as Direcionc, \r\n                      clien.fecha_nacimineto_clie as fecha_cobro,\r\n                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,\r\n                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro,\r\n                      clien.orden_ruta_clie as orden\r\n                      FROM tbl_cliente as clien \r\n                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) \r\n                      WHERE id_usu = 4ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'BY clien.orden_ruta_clie ASC\' at line 15', '2020-09-09 17:42:17', 4, 'cliente', 'cargar'),
(69, 'Consulta de dataTable => SELECT clien.id_clie as id, \r\n                       clien.documento_clie as CC, \r\n                      CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                      clien.telefono_1_clie as t1, \r\n                      clien.telefono_2_clie as t2,\r\n                      clien.correo_clie as Correo,\r\n                      clien.documento_clie as Direcionr,\r\n                      clien.documento_ref_clie as Direcionc, \r\n                      clien.fecha_nacimineto_clie as fecha_cobro,\r\n                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,\r\n                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro,\r\n                      clien.orden_ruta_clie as orden\r\n                      FROM tbl_cliente as clien \r\n                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) \r\n                      WHERE clien.id_usu = 4ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'BY clien.orden_ruta_clie ASC\' at line 15', '2020-09-09 17:42:44', 4, 'cliente', 'cargar'),
(70, 'c= a= /-/ consulta=CALL obtenerCliente()', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.obtenerCliente; expected 1, got 0', '2020-09-09 17:50:10', 4, 'historial', ''),
(71, 'c= a= /-/ consulta=CALL obtenerCliente()', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.obtenerCliente; expected 1, got 0', '2020-09-09 18:42:11', 4, 'historial', ''),
(72, 'Consulta de dataTable => SELECT clien.id_clie as id, \r\n                       clien.documento_clie as CC, \r\n                      CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                      clien.telefono_1_clie as t1, \r\n                      clien.telefono_2_clie as t2,\r\n                      clien.correo_clie as Correo,\r\n                      clien.documento_clie as Direcionr,\r\n                      clien.documento_ref_clie as Direcionc, \r\n                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,\r\n                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro,\r\n                      pres.id_pres idPres\r\n                      FROM tbl_cliente as clien \r\n                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) \r\n                      WHERE pres.valor_pres>0 AND clien.id_usu = 3ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'BY clien.orden_ruta_clie ASC\' at line 14', '2020-09-09 18:56:09', 3, 'abono', 'cargar'),
(73, 'c= a= /-/ consulta=SELECT\r\n                     CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                     press.valor_cuotas_pres as couta,\r\n                    logPrestamo.valor_pres_logp as pago,\r\n                    (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                    pressValor.pagado,\r\n                    press.valor_pres as debe\r\n                    FROM tbl_log_prestamo as logPrestamo \r\n                    INNER JOIN tbl_cliente AS clien ON (clien.id_clie=logPrestamo.id_clie)\r\n                    INNER JOIN tbl_prestamo AS press ON (press.id_pres=logPrestamo.id_pres)\r\n                    LEFT JOIN (SELECT SUM(tbl_log_prestamo.valor_pres_logp) AS pagado, tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres FROM tbl_log_prestamo GROUP BY tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres ) AS pressValor ON (pressValor.id_pres=logPrestamo.id_pres AND pressValor.id_clie=logPrestamo.id_clie) \r\n                    WHERE logPrestamo.valor_pres>0 AND logPrestamo.id_autor_usu=ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'ORDER BY clien.orden_ruta_clie ASC\' at line 12', '2020-09-09 19:18:06', 4, 'historial', 'ver'),
(74, 'c= a= /-/ consulta=SELECT\r\n                     CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                     press.valor_cuotas_pres as couta,\r\n                    logPrestamo.valor_pres_logp as pago,\r\n                    (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                    pressValor.pagado,\r\n                    press.valor_pres as debe\r\n                    FROM tbl_log_prestamo as logPrestamo \r\n                    INNER JOIN tbl_cliente AS clien ON (clien.id_clie=logPrestamo.id_clie)\r\n                    INNER JOIN tbl_prestamo AS press ON (press.id_pres=logPrestamo.id_pres)\r\n                    LEFT JOIN (SELECT SUM(tbl_log_prestamo.valor_pres_logp) AS pagado, tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres FROM tbl_log_prestamo GROUP BY tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres ) AS pressValor ON (pressValor.id_pres=logPrestamo.id_pres AND pressValor.id_clie=logPrestamo.id_clie) \r\n                    WHERE logPrestamo.valor_pres>0 AND logPrestamo.id_autor_usu= ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'ORDER BY clien.orden_ruta_clie ASC\' at line 12', '2020-09-09 19:18:22', 4, 'historial', 'ver'),
(75, 'c= a= /-/ consulta=SELECT\r\n                     CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                     press.valor_cuotas_pres as couta,\r\n                    logPrestamo.valor_pres_logp as pago,\r\n                    (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                    pressValor.pagado,\r\n                    press.valor_pres as debe\r\n                    FROM tbl_log_prestamo as logPrestamo \r\n                    INNER JOIN tbl_cliente AS clien ON (clien.id_clie=logPrestamo.id_clie)\r\n                    INNER JOIN tbl_prestamo AS press ON (press.id_pres=logPrestamo.id_pres)\r\n                    LEFT JOIN (SELECT SUM(tbl_log_prestamo.valor_pres_logp) AS pagado, tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres FROM tbl_log_prestamo GROUP BY tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres ) AS pressValor ON (pressValor.id_pres=logPrestamo.id_pres AND pressValor.id_clie=logPrestamo.id_clie) \r\n                    WHERE logPrestamo.movimiento_logp=1 AND logPrestamo.id_autor_usu= ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'ORDER BY clien.orden_ruta_clie ASC\' at line 12', '2020-09-09 19:19:01', 4, 'historial', 'ver'),
(76, 'Abonar. => UPDATE tbl_prestamo SET valor_pres=\'130\' WHERE id_pres =15; UPDATE tbl_cliente SET cumplimineto_client = 1 WHERE id_clie =13', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'UPDATE tbl_cliente SET cumplimineto_client = 1 WHERE id_clie =13\' at line 1', '2020-09-09 20:51:34', 4, 'abono', 'abonarPago'),
(77, ' => CALL logPrestamo(\'0\',\'17\',\'prestamo\',4,\'save\',\'12\',\'Creao prestamo\',\'202\',\'99\')', 'Incorrect number of arguments for PROCEDURE bd_sistema_ruta.logPrestamo; expected 12, got 9', '2020-09-10 02:15:12', 4, 'prestamo', 'save'),
(78, ' => CALL logPrestamo(\'0\',\'18\',\'prestamo\',4,\'save\',\'12\',\'Creao prestamo\',\'202\',\'99\',::1)', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'::1)\' at line 1', '2020-09-10 02:24:38', 4, 'prestamo', 'save'),
(79, ' => CALL logPrestamo(\'0\',\'19\',\'prestamo\',4,\'save\',\'12\',\'Creao prestamo\',\'202\',\'99\',6.2867621,-75.5906337,::1)', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'::1)\' at line 1', '2020-09-10 02:27:17', 4, 'prestamo', 'save'),
(80, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:41:06', 4, 'historial', 'ver'),
(81, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:44:17', 4, 'historial', 'ver'),
(82, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:47:20', 4, 'historial', 'ver'),
(83, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:50:19', 4, 'historial', 'ver'),
(84, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:51:30', 4, 'historial', 'ver'),
(85, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:51:37', 4, 'historial', 'ver'),
(86, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 04:55:44', 4, 'historial', 'ver'),
(87, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 05:01:25', 4, 'historial', 'ver'),
(88, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 05:02:00', 4, 'historial', 'ver');
INSERT INTO `tbl_log_errores` (`int_id_loge`, `text_accion_loge`, `text_descripcion_loge`, `date_fecha_loge`, `int_id_usu`, `text_controller_loge`, `text_func_accion_loge`) VALUES
(89, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 05:02:19', 4, 'historial', 'ver'),
(90, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 12', '2020-09-10 05:09:36', 4, 'historial', 'ver'),
(91, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres,\r\n                rh.cumplimineto_rutaH as cumplimiento,\r\n                diasvTable.diasV\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                LEFT JOIN (\r\n                    SELECT count(tbl_ruta_historial.id_rutaH) AS diasV,tbl_ruta_historial.id_clien,tbl_ruta_historial.cumplimineto_rutaH \r\n                    FROM tbl_ruta_historial\r\n                    WHERE diasvTable.cumplimineto_rutaH=0 \r\n                    GROUP BY tbl_ruta_historial.id_clien) as diasvTable ON (diasvTable.id_clien=clien.id_clie)\r\n                WHERE clien.id_usu=4 ORDER BY clien.orden_ruta_clie ASC', 'Unknown column \'diasvTable.cumplimineto_rutaH\' in \'where clause\'', '2020-09-10 06:27:02', 4, 'historial', 'ver'),
(92, 'c= a= /-/ consulta=SELECT pres.valor_pres,pres.valor_cuotas_pres,pres.id_clie,client.cumplimineto_client\r\n                      FROM tbl_prestamo as pres\r\n                      INNER JOIN tbl_log_prestamo as presLog ON (presLog.id_pres=pres.id_pres) \r\n                      WHERE presLog.id_logp=48', 'Unknown column \'client.cumplimineto_client\' in \'field list\'', '2020-09-11 16:08:34', 4, 'historial', 'abonarPago'),
(93, 'Consulta de dataTable => SELECT \r\n                CONCAT_WS (\' \',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,\r\n                press.valor_cuotas_pres as couta,\r\n                logPrestamo.valor_pres_logp as pago,\r\n                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,\r\n                press.valor_pres as debe,\r\n                logPrestamo.id_logp as idPres,\r\n                press.id_pres as idPrestamos\r\n                rh.cumplimineto_rutaH as cumplimiento,\r\n                diasvTable.diasV,\r\n                clien.id_clie as idClie,\r\n                rh.id_rutaH AS idRuta\r\n                FROM tbl_ruta_historial as rh\r\n                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)\r\n                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)\r\n                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)\r\n                LEFT JOIN (\r\n                    SELECT count(tbl_ruta_historial.id_rutaH) AS diasV,tbl_ruta_historial.id_clien,tbl_ruta_historial.cumplimineto_rutaH \r\n                    FROM tbl_ruta_historial\r\n                    WHERE tbl_ruta_historial.cumplimineto_rutaH=0 \r\n                    GROUP BY tbl_ruta_historial.id_clien) as diasvTable ON (diasvTable.id_clien=clien.id_clie)\r\n                WHERE clien.id_usu=4 ORDER BY rh.fecha_rutaH ASC', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'rh.cumplimineto_rutaH as cumplimiento,\r\n                diasvTable.diasV,\r\n     \' at line 9', '2020-09-12 14:23:03', 4, 'historial', 'ver'),
(94, 'editar historial. => UPDATE tbl_ruta_historial SET cumplimineto_rutaH = \'49\', id_log_pres_rutaH=\'49\',movimiento_logp=3  WHERE id_rutaH =13', 'Unknown column \'movimiento_logp\' in \'field list\'', '2020-09-12 14:30:23', 4, 'historial', 'abonarPago'),
(95, 'Cambio de estado a 1. => UPDATE `tbl_gasto` SET `estado_gas` = \'1\'  WHERE `tbl_gasto`.`id_gas` = ', 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'\' at line 1', '2020-09-12 18:18:25', 2, 'gasto', 'cambiarEstado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_gasto`
--

CREATE TABLE `tbl_log_gasto` (
  `id_logg` bigint(20) NOT NULL,
  `movimiento_logg` int(11) NOT NULL COMMENT '0-registrar gasto propio, 1-UPDATE,3-DESACTIVAR',
  `fecha_logg` datetime NOT NULL,
  `id_gas` bigint(20) NOT NULL,
  `controller_logg` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_gas` bigint(20) NOT NULL,
  `accion_func_logu` text COLLATE utf8_swedish_ci NOT NULL,
  `valor_logg` double NOT NULL DEFAULT 0,
  `nota_logg` text COLLATE utf8_swedish_ci NOT NULL,
  `latitud_logg` text COLLATE utf8_swedish_ci NOT NULL,
  `longitud_logg` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_gasto`
--

INSERT INTO `tbl_log_gasto` (`id_logg`, `movimiento_logg`, `fecha_logg`, `id_gas`, `controller_logg`, `id_autor_gas`, `accion_func_logu`, `valor_logg`, `nota_logg`, `latitud_logg`, `longitud_logg`) VALUES
(32, 0, '2020-09-12 16:20:27', 27, 'gasto', 3, 'save', 0, '', '', ''),
(33, 0, '2020-09-12 17:30:46', 28, 'gasto', 3, 'save', 200, 'Creacion de gatos', '0', '0'),
(34, 2, '2020-09-12 17:36:26', 27, 'gasto', 2, 'abonarGasto', 20, '', '6.2867743', '-75.5906481'),
(35, 2, '2020-09-12 17:37:06', 27, 'gasto', 2, 'abonarGasto', 20, '', '6.2867733999999995', '-75.5906653'),
(36, 2, '2020-09-12 17:37:46', 27, 'gasto', 2, 'abonarGasto', 20, '', '6.2868162', '-75.5906646'),
(37, 2, '2020-09-12 17:44:49', 27, 'gasto', 2, 'abonarGasto', 20, '', '6.2868052', '-75.5906675'),
(38, 2, '2020-09-12 17:47:07', 27, 'gasto', 2, 'abonarGasto', 20, '', '6.2868052', '-75.5906675'),
(39, 2, '2020-09-12 17:58:54', 27, 'gasto', 2, 'abonarGasto', 20, '', '6.2867611', '-75.5906498'),
(40, 2, '2020-09-12 18:09:12', 27, 'gasto', 2, 'abonarGasto', 100, '', '6.286785000000001', '-75.5906277'),
(41, 1, '2020-09-12 18:20:50', 28, 'gasto', 2, 'cambiarEstado', 0, 'Cancelar gatos', '0', '0'),
(42, 1, '2020-09-12 18:24:37', 28, 'gasto', 2, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(43, 1, '2020-09-12 18:24:49', 28, 'gasto', 2, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(44, 1, '2020-09-12 18:26:21', 28, 'gasto', 2, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(45, 0, '2020-09-12 18:27:56', 29, 'gasto', 3, 'save', 200, 'Creacion de gatos', '0', '0'),
(46, 3, '2020-09-12 18:28:23', 29, 'gasto', 3, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(47, 0, '2020-09-12 18:29:28', 30, 'gasto', 3, 'save', 200, 'Creacion de gatos', '0', '0'),
(48, 1, '2020-09-12 18:31:33', 30, 'gasto', 2, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(49, 0, '2020-09-12 18:34:16', 31, 'gasto', 3, 'save', 200, 'Creacion de gatos', '0', '0'),
(50, 1, '2020-09-12 18:34:48', 31, 'gasto', 2, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(51, 0, '2020-09-12 18:37:15', 32, 'gasto', 3, 'save', 200, 'Creacion de gatos', '0', '0'),
(52, 0, '2020-09-12 18:37:29', 33, 'gasto', 3, 'save', 321312, 'Creacion de gatos', '0', '0'),
(53, 3, '2020-09-12 18:37:48', 32, 'gasto', 3, 'cambiarEstado', 200, 'Cancelar gatos', '0', '0'),
(54, 1, '2020-09-12 18:38:37', 33, 'gasto', 2, 'cambiarEstado', 321312, 'Cancelar gatos', '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_prestamo`
--

CREATE TABLE `tbl_log_prestamo` (
  `id_logp` bigint(20) NOT NULL,
  `movimiento_logp` int(11) NOT NULL COMMENT '0-CREAR, 1-ABONAR,3-CANCELAR',
  `fecha_logp` datetime NOT NULL,
  `id_pres` bigint(20) NOT NULL,
  `controller_logp` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_usu` bigint(20) NOT NULL,
  `accion_func_logp` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_clie` bigint(20) NOT NULL,
  `valor_pres_logp` double NOT NULL,
  `nota_logp` text COLLATE utf8_swedish_ci NOT NULL,
  `forma_pago_logp` int(11) NOT NULL,
  `latitud_logp` text COLLATE utf8_swedish_ci DEFAULT '0',
  `longitud_logp` text COLLATE utf8_swedish_ci DEFAULT '0',
  `ip_logp` text COLLATE utf8_swedish_ci DEFAULT '0',
  `apuntadaor_prestamo_logp` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_prestamo`
--

INSERT INTO `tbl_log_prestamo` (`id_logp`, `movimiento_logp`, `fecha_logp`, `id_pres`, `controller_logp`, `id_autor_usu`, `accion_func_logp`, `id_clie`, `valor_pres_logp`, `nota_logp`, `forma_pago_logp`, `latitud_logp`, `longitud_logp`, `ip_logp`, `apuntadaor_prestamo_logp`) VALUES
(60, 3, '2020-09-12 16:00:41', 25, 'abono', 4, 'abonarPago', 11, 22, '', 0, '6.2866391', '-75.5905487', '::1', 61),
(61, 3, '2020-09-12 16:05:34', 25, 'historial', 4, 'abonarPago', 11, 10, '', 3, '6.2867546999999995', '-75.5906655', '::1', 62),
(62, 1, '2020-09-12 16:06:45', 25, 'historial', 4, 'abonarPago', 11, 11, '', 3, '6.2867204', '-75.5906224', '::1', 0),
(63, 3, '2020-09-12 16:10:58', 25, 'historial', 4, 'abonarPago', 11, 20, '', 3, '6.2867757', '-75.5906526', '::1', 64),
(64, 3, '2020-09-12 16:12:03', 25, 'historial', 4, 'abonarPago', 11, 9, '', 3, '6.2867757', '-75.5906526', '::1', 65),
(65, 1, '2020-09-12 16:12:44', 25, 'historial', 4, 'abonarPago', 11, 10, '', 3, '6.2867386', '-75.5906328', '::1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_tipo_gasto`
--

CREATE TABLE `tbl_log_tipo_gasto` (
  `id_logt` bigint(20) NOT NULL,
  `movimiento_logt` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,3-DESACTIVAR',
  `fecha_logt` datetime NOT NULL,
  `id_tipo_gasto_logt` bigint(20) NOT NULL,
  `controller_logt` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_ust` bigint(20) NOT NULL,
  `accion_func_logt` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_tipo_gasto`
--

INSERT INTO `tbl_log_tipo_gasto` (`id_logt`, `movimiento_logt`, `fecha_logt`, `id_tipo_gasto_logt`, `controller_logt`, `id_autor_ust`, `accion_func_logt`) VALUES
(1, 0, '2020-08-28 00:09:31', 2, 'tipo_gasto', 3, '0'),
(2, 0, '2020-08-28 00:37:31', 3, 'tipo_gasto', 3, '0'),
(3, 0, '2020-08-28 00:41:56', 4, 'tipo_gasto', 3, '0'),
(4, 0, '2020-08-28 05:29:31', 5, 'tipo_gasto', 4, '0'),
(5, 0, '2020-08-28 12:23:38', 6, 'tipo_gasto', 3, '0'),
(6, 0, '2020-09-12 16:19:13', 7, 'tipo_gasto', 3, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_usuarios`
--

CREATE TABLE `tbl_log_usuarios` (
  `id_logu` bigint(20) NOT NULL,
  `movimiento_logu` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,3-DESACTIVAR',
  `fecha_logu` datetime NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `controller_logu` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_usu` bigint(20) NOT NULL,
  `accion_func_logu` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_usuarios`
--

INSERT INTO `tbl_log_usuarios` (`id_logu`, `movimiento_logu`, `fecha_logu`, `id_usu`, `controller_logu`, `id_autor_usu`, `accion_func_logu`) VALUES
(1, 0, '2020-08-25 20:12:44', 1, 'usuario', 0, 'save'),
(8, 3, '2020-08-25 20:53:48', 1, 'usuario', 1, 'cambiar_estado'),
(9, 3, '2020-08-25 20:54:03', 1, 'usuario', 1, 'cambiar_estado'),
(10, 3, '2020-08-25 20:54:50', 1, 'usuario', 1, 'cambiar_estado'),
(11, 3, '2020-08-25 20:56:33', 1, 'usuario', 1, 'cambiar_estado'),
(12, 3, '2020-08-25 20:56:44', 1, 'usuario', 1, 'cambiar_estado'),
(14, 1, '2020-08-25 21:06:10', 1, 'usuario', 1, 'update'),
(15, 1, '2020-08-25 21:12:30', 1, 'usuario', 1, 'update'),
(16, 1, '2020-08-25 21:17:30', 1, 'usuario', 1, 'update'),
(17, 1, '2020-08-25 21:57:49', 1, 'usuario', 1, 'update'),
(18, 1, '2020-08-25 22:08:19', 1, 'usuario', 1, 'update'),
(19, 1, '2020-08-25 22:09:06', 1, 'usuario', 1, 'update'),
(20, 0, '2020-08-25 22:14:32', 2, 'usuario', 1, 'save'),
(21, 0, '2020-08-25 22:22:56', 3, 'usuario', 1, 'save'),
(22, 0, '2020-08-28 02:27:48', 4, 'usuario', 1, 'save'),
(23, 1, '2020-08-28 02:28:27', 4, 'usuario', 1, 'update');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_prestamo`
--

CREATE TABLE `tbl_prestamo` (
  `id_pres` bigint(20) NOT NULL,
  `id_clie` bigint(20) NOT NULL,
  `fecha_limite_pres` datetime NOT NULL,
  `valor_pres` double NOT NULL,
  `forma_pago_pres` int(11) NOT NULL COMMENT '1-diario, 2-diapormedio,3-semanal,4-quincedal,5-cada-dos-semanas,6-mensual',
  `numero_cuota_pres` int(11) NOT NULL,
  `valor_cuotas_pres` double NOT NULL,
  `intereses_press` text COLLATE utf8_swedish_ci NOT NULL,
  `valor_neto_clie` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_prestamo`
--

INSERT INTO `tbl_prestamo` (`id_pres`, `id_clie`, `fecha_limite_pres`, `valor_pres`, `forma_pago_pres`, `numero_cuota_pres`, `valor_cuotas_pres`, `intereses_press`, `valor_neto_clie`) VALUES
(25, 11, '2020-09-12 00:00:00', 199, 1, 10, 22, '10', 200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ruta_historial`
--

CREATE TABLE `tbl_ruta_historial` (
  `id_rutaH` bigint(20) NOT NULL,
  `id_clien` bigint(20) NOT NULL,
  `cumplimineto_rutaH` int(11) NOT NULL COMMENT '0-NO PAGO,1-PAGO',
  `fecha_rutaH` datetime NOT NULL,
  `id_pres` bigint(20) NOT NULL,
  `id_log_pres_rutaH` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_ruta_historial`
--

INSERT INTO `tbl_ruta_historial` (`id_rutaH`, `id_clien`, `cumplimineto_rutaH`, `fecha_rutaH`, `id_pres`, `id_log_pres_rutaH`) VALUES
(20, 11, 62, '2020-09-12 16:02:57', 25, 62),
(21, 11, 65, '2020-09-12 16:08:36', 25, 65);

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
(1, 'gasolina', 2, 3),
(2, 'gasolina', 2, 3),
(3, 'alimentacion', 2, 3),
(4, 'autobus choque', 2, 3),
(5, 'gasolina de usuario prueba', 2, 4),
(6, 'Choque', 2, 3),
(7, 'prestamo', 2, 3);

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
  `rol_usu` int(11) NOT NULL COMMENT '0-administrador,1-coordinador,2-cliente',
  `estado_localidad_usu` text COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'No tiene',
  `ciudad_localidad_usu` text COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'No tiene',
  `id_coordinador_usu` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usu`, `documento_usu`, `primer_nombre_usu`, `segundo_nombre_usu`, `primer_apellido_usu`, `segundo_apellido_usu`, `telefono_1_usu`, `telefono_2_usu`, `direcion_usu`, `sexo_usu`, `correo_usu`, `contrasena_usu`, `fecha_nacimineto_usu`, `foto_usu`, `estado_usu`, `rol_usu`, `estado_localidad_usu`, `ciudad_localidad_usu`, `id_coordinador_usu`) VALUES
(1, 123456789, 'Administrado', '', 'Administrado', '', 1234567890, 1234567890, 'No hay', 0, 'brCredit@gmail.com', '$2y$09$kW4CevXhkZTQ3Pm.vh4r5e.zcdT8GFuXNSSHhunPf8T78FOlasJai', '1992-01-01 00:00:00', '20200826031244_0.png', 1, 0, '3', '219', 0),
(2, 1111111111, 'coordinador', '', 'prueba', '', 1111111111, 1111111111, 'no hay', 0, 'coordinador@gmail.com', '$2y$09$CGCFUUzKUYoxwxa96bIlDOMXavvBEOHJRokhlVqKYF0s2BGStNPXS', '2007-08-16 00:00:00', 'usuario.jpg', 1, 1, '2', '105', 0),
(3, 1, 'vendedor', '', 'prueba', '', 2222222222, 2222222222, 'no hay', 0, 'vendedor@gmail.com', '$2y$09$lt2KXTDatmt3ieBT2uPdCeRrxEAUF8GGSWinjSxppjldHVtgNeO7e', '2007-08-16 00:00:00', 'usuario.jpg', 1, 2, '6', '702', 1),
(4, 4, 'prueba', '', 'prueba', '', 55555555555555, 0, 'fffff', 0, 'prueba@GMAIL.COM', '$2y$09$exULs4LOlHnRF0jsNpcaBekB.pC5X1ctHWobB4xA0K6rG5zgu4yaG', '2007-08-19 00:00:00', 'usuario.jpg', 1, 2, '2', '101', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD PRIMARY KEY (`id_clie`);

--
-- Indices de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  ADD PRIMARY KEY (`id_gas`),
  ADD KEY `FK_USUARIO` (`id_usu`);

--
-- Indices de la tabla `tbl_log_cliente`
--
ALTER TABLE `tbl_log_cliente`
  ADD PRIMARY KEY (`id_logc`),
  ADD KEY `FK_CLIENTE-LOG` (`id_usu`);

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
-- Indices de la tabla `tbl_log_prestamo`
--
ALTER TABLE `tbl_log_prestamo`
  ADD PRIMARY KEY (`id_logp`);

--
-- Indices de la tabla `tbl_log_tipo_gasto`
--
ALTER TABLE `tbl_log_tipo_gasto`
  ADD PRIMARY KEY (`id_logt`),
  ADD KEY `FK_TIPO_GASTO-LOG` (`id_logt`);

--
-- Indices de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD PRIMARY KEY (`id_logu`),
  ADD KEY `FK_USUARIO-LOG` (`id_usu`);

--
-- Indices de la tabla `tbl_prestamo`
--
ALTER TABLE `tbl_prestamo`
  ADD PRIMARY KEY (`id_pres`);

--
-- Indices de la tabla `tbl_ruta_historial`
--
ALTER TABLE `tbl_ruta_historial`
  ADD PRIMARY KEY (`id_rutaH`);

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
-- AUTO_INCREMENT de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  MODIFY `id_clie` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  MODIFY `id_gas` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tbl_log_cliente`
--
ALTER TABLE `tbl_log_cliente`
  MODIFY `id_logc` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  MODIFY `int_id_loge` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  MODIFY `id_logg` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `tbl_log_prestamo`
--
ALTER TABLE `tbl_log_prestamo`
  MODIFY `id_logp` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `tbl_log_tipo_gasto`
--
ALTER TABLE `tbl_log_tipo_gasto`
  MODIFY `id_logt` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  MODIFY `id_logu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tbl_prestamo`
--
ALTER TABLE `tbl_prestamo`
  MODIFY `id_pres` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `tbl_ruta_historial`
--
ALTER TABLE `tbl_ruta_historial`
  MODIFY `id_rutaH` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  MODIFY `id_tipog` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `tbl_log_errores_ibfk_1` FOREIGN KEY (`int_id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `eventoPagoHistrorial` ON SCHEDULE EVERY 23 DAY STARTS '2020-09-12 23:59:59' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
INSERT INTO tbl_ruta_historial (id_rutaH, id_clien, cumplimineto_rutaH, fecha_rutaH,id_pres,id_log_pres_rutaH) 
(SELECT NULL,
tbl_cliente.id_clie,
if(tbl_cliente.cumplimineto_client!=0,tbl_cliente.cumplimineto_client,0) AS cumplimineto_rutaH,
now() AS fecha_rutaH,
tbl_prestamo.id_pres,
tbl_cliente.cumplimineto_client
FROM tbl_cliente
INNER JOIN tbl_prestamo ON (tbl_prestamo.id_clie=tbl_cliente.id_clie AND tbl_prestamo.valor_pres>0));

UPDATE tbl_cliente SET cumplimineto_client = 0;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
