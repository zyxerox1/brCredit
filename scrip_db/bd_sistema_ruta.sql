-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2020 a las 20:04:38
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarUsuario` (IN `id` BIGINT)  NO SQL
BEGIN
SELECT * FROM tbl_usuarios WHERE id_usu=id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarLogErrores` (IN `fecha_ini` TEXT, IN `fecha_fin` TEXT)  NO SQL
BEGIN
DELETE FROM tbl_log_errores WHERE date_fecha_loge <= fecha_fin AND date_fecha_loge >= fecha_ini;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logErrores` (IN `accion` TEXT, IN `descripcion` TEXT, IN `id_usu` BIGINT, IN `controller` TEXT, IN `accion_func` TEXT)  NO SQL
BEGIN
    INSERT INTO `tbl_log_errores` (`int_id_loge`, `text_accion_loge`, `text_descripcion_loge`, `date_fecha_loge`, `int_id_usu`,text_controller_loge,text_func_accion_loge) VALUES (NULL, accion,descripcion,now(),id_usu,controller,accion_func);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logGasto` (IN `movimiento` TEXT, IN `id_gasto` BIGINT, IN `controller` TEXT, IN `autor` BIGINT, IN `accion` TEXT)  NO SQL
BEGIN
	INSERT INTO `tbl_log_gasto` (`id_logg`, `movimiento_logg`, `fecha_logg`, `id_gas`, `controller_logg`, `id_autor_gas`, `accion_func_logu`) VALUES (NULL, movimiento, now(), id_gasto, controller, autor, accion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginCorreo` (IN `dataUsuario` TEXT)  NO SQL
BEGIN
SELECT * FROM tbl_usuarios WHERE correo_usu = dataUsuario and estado_usu=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginDocumento` (IN `dataUsuario` TEXT)  NO SQL
BEGIN
	SELECT * FROM tbl_usuarios WHERE documento_usu = dataUsuario and estado_usu=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logTipoGasto` (IN `movimiento` TEXT, IN `id_gasto` BIGINT, IN `controller` TEXT, IN `autor` BIGINT, IN `accion` INT)  NO SQL
BEGIN
	INSERT INTO `tbl_log_tipo_gasto` (`id_logt`, `movimiento_logt`, `fecha_logt`, `id_tipo_gasto_logt`, `controller_logt`, `id_autor_ust`, `accion_func_logt`) VALUES (NULL, movimiento, now(), id_gasto, controller, autor, accion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logUsuarios` (IN `movimiento` TEXT, IN `id` BIGINT, IN `autor` BIGINT, IN `accion_func` TEXT, IN `controller` TEXT)  NO SQL
BEGIN
DECLARE query_p VARCHAR(100);
INSERT INTO tbl_log_usuarios (id_logu,movimiento_logu,fecha_logu,id_usu,id_autor_usu,controller_logu,accion_func_logu) VALUES (NULL, movimiento,now(),id,autor,controller,accion_func);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerAdministradores` ()  NO SQL
BEGIN
	SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios WHERE rol_usu = 0;
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
  `fecha_nacimineto_usu` datetime NOT NULL,
  `foto_usu` text COLLATE utf8mb4_swedish_ci DEFAULT 'usuario.jpg',
  `estado_usu` int(11) NOT NULL DEFAULT 1,
  `rol_usu` int(11) NOT NULL COMMENT '0-administrador,1-coordinador,2-cliente',
  `estado_localidad_usu` text COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'No tiene',
  `ciudad_localidad_usu` text COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'No tiene',
  `id_coordinador_usu` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_cliente`
--

INSERT INTO `tbl_cliente` (`id_usu`, `documento_usu`, `primer_nombre_usu`, `segundo_nombre_usu`, `primer_apellido_usu`, `segundo_apellido_usu`, `telefono_1_usu`, `telefono_2_usu`, `direcion_usu`, `sexo_usu`, `correo_usu`, `fecha_nacimineto_usu`, `foto_usu`, `estado_usu`, `rol_usu`, `estado_localidad_usu`, `ciudad_localidad_usu`, `id_coordinador_usu`) VALUES
(1, 12412443423, 'asde', 'fdsf', 'fdsf', 'nbnbdf', 4324234324234, 32432432433, 'fdsfsdfdfsf', 0, 'j.a@dfsd.com', '2007-08-25 00:00:00', 'usuario.jpg', 1, 2, '5', '284', 0);

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
  `id_usu` bigint(20) NOT NULL,
  `id_tipo_tipog` bigint(20) NOT NULL,
  `estado_gas` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_gasto`
--

INSERT INTO `tbl_gasto` (`id_gas`, `valor_gas`, `fecha_gas`, `evidencia_gas`, `nota_gas`, `id_usu`, `id_tipo_tipog`, `estado_gas`) VALUES
(1, 1, '2020-08-28 01:26:19', '20200828082619_3.png', 'no', 3, 1, 3),
(2, 2344, '2020-08-28 01:43:29', '20200828084329_3.png', 'no', 3, 2, 1),
(3, 1333, '2020-08-28 01:47:37', '20200828084737_3.png', 'hola', 3, 3, 3),
(4, 133, '2020-08-28 01:48:31', '20200828084831_3.png', '223', 3, 4, 0),
(5, 4234, '2020-08-28 01:49:12', '20200828084912_3.png', '312321', 3, 3, 3),
(24, 332, '2020-08-28 07:44:38', '20200828144438_4.pdf', 'prueba', 4, 5, 0),
(25, 13, '2020-08-28 07:45:16', '20200828144516_4.pdf', 'fdsf', 4, 5, 0),
(26, 1111111, '2020-08-28 12:26:18', '20200828192618_3.jpg', 'No hay', 3, 6, 3);

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
(29, 'creacion de usuarios. => INSERT INTO tbl_cliente (id_usu, documento_usu, primer_nombre_usu,segundo_nombre_usu, primer_apellido_usu, segundo_apellido_usu, telefono_1_usu, telefono_2_usu, direcion_usu, sexo_usu, correo_usu, fecha_nacimineto_usu, foto_usu,rol_usu,estado_localidad_usu,ciudad_localidad_usu) VALUES (NULL, 12412443423,\'asde\',\'fdsf\',\'fdsf\',\'nbnbdf\', 4324234324234, 32432432433, \'fdsfsdfdfsf\', \'Hombre\', \'j.a@dfsd.com\', \'2007-08-25\', \'usuario.jpg\',2,5,284)', 'Column \'id_usu\' cannot be null', '2020-09-03 22:27:01', 3, 'cliente', 'save');

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
  `accion_func_logu` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_log_gasto`
--

INSERT INTO `tbl_log_gasto` (`id_logg`, `movimiento_logg`, `fecha_logg`, `id_gas`, `controller_logg`, `id_autor_gas`, `accion_func_logu`) VALUES
(2, 0, '2020-08-28 01:26:19', 1, 'gasto', 3, '0'),
(3, 0, '2020-08-28 01:43:29', 2, 'gasto', 3, 'save'),
(4, 0, '2020-08-28 01:47:37', 3, 'gasto', 3, 'save'),
(5, 0, '2020-08-28 01:48:31', 4, 'gasto', 3, 'save'),
(6, 0, '2020-08-28 01:49:12', 5, 'gasto', 3, 'save'),
(7, 0, '2020-08-28 05:30:44', 6, 'gasto', 4, 'save'),
(8, 0, '2020-08-28 05:46:24', 7, 'gasto', 3, 'save'),
(9, 0, '2020-08-28 05:46:57', 8, 'gasto', 3, 'save'),
(10, 0, '2020-08-28 05:47:17', 9, 'gasto', 3, 'save'),
(11, 0, '2020-08-28 05:47:55', 10, 'gasto', 3, 'save'),
(12, 0, '2020-08-28 05:48:22', 11, 'gasto', 3, 'save'),
(13, 0, '2020-08-28 05:49:24', 12, 'gasto', 3, 'save'),
(14, 0, '2020-08-28 05:51:04', 13, 'gasto', 3, 'save'),
(15, 0, '2020-08-28 05:51:46', 14, 'gasto', 3, 'save'),
(16, 0, '2020-08-28 05:51:57', 15, 'gasto', 3, 'save'),
(17, 0, '2020-08-28 05:52:16', 16, 'gasto', 3, 'save'),
(18, 0, '2020-08-28 05:53:23', 17, 'gasto', 3, 'save'),
(19, 0, '2020-08-28 05:55:36', 18, 'gasto', 3, 'save'),
(20, 0, '2020-08-28 05:57:19', 19, 'gasto', 3, 'save'),
(21, 0, '2020-08-28 05:59:11', 20, 'gasto', 3, 'save'),
(22, 0, '2020-08-28 07:11:55', 21, 'gasto', 4, 'save'),
(23, 0, '2020-08-28 07:14:37', 22, 'gasto', 4, 'save'),
(24, 0, '2020-08-28 07:39:14', 23, 'gasto', 4, 'save'),
(25, 0, '2020-08-28 07:44:38', 24, 'gasto', 4, 'save'),
(26, 0, '2020-08-28 07:45:16', 25, 'gasto', 4, 'save'),
(27, 0, '2020-08-28 12:26:18', 26, 'gasto', 3, 'save'),
(28, 3, '2020-09-03 19:18:38', 3, 'gasto', 3, 'cambiarEstado'),
(29, 3, '2020-09-03 19:27:18', 5, 'gasto', 3, 'cambiarEstado'),
(30, 3, '2020-09-03 20:05:12', 26, 'gasto', 3, 'cambiarEstado'),
(31, 3, '2020-09-03 20:05:58', 1, 'gasto', 3, 'cambiarEstado');

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
(5, 0, '2020-08-28 12:23:38', 6, 'tipo_gasto', 3, '0');

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
(6, 'Choque', 2, 3);

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
(3, 2222222222, 'vendedor', '', 'prueba', '', 2222222222, 2222222222, 'no hay', 0, 'vendedor@gmail.com', '$2y$09$lt2KXTDatmt3ieBT2uPdCeRrxEAUF8GGSWinjSxppjldHVtgNeO7e', '2007-08-16 00:00:00', 'usuario.jpg', 1, 2, '6', '702', 1),
(4, 4444444444444, 'prueba', '', 'prueba', '', 55555555555555, 0, 'fffff', 0, 'prueba@GMAIL.COM', '$2y$09$exULs4LOlHnRF0jsNpcaBekB.pC5X1ctHWobB4xA0K6rG5zgu4yaG', '2007-08-19 00:00:00', 'usuario.jpg', 1, 2, '2', '101', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD PRIMARY KEY (`id_usu`);

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
  MODIFY `id_usu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  MODIFY `id_gas` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  MODIFY `int_id_loge` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  MODIFY `id_logg` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tbl_log_tipo_gasto`
--
ALTER TABLE `tbl_log_tipo_gasto`
  MODIFY `id_logt` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  MODIFY `id_logu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  MODIFY `id_tipog` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
