-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2020 a las 04:50:48
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `crearCodigoRuta` ()  NO SQL
BEGIN
INSERT INTO 
tbl_data_ruta (id_usu,text_codigo_ruta) 
(SELECT usu.id_usu,CONCAT(usu.primer_nombre_usu,'-',SUBSTRING(usu.documento_usu, -4, 2),usu.id_usu,SUBSTRING(usu.documento_usu, -2, 2)) AS codigo FROM tbl_usuarios AS usu WHERE usu.rol_usu=2);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarLogErrores` (IN `fecha_ini` TEXT, IN `fecha_fin` TEXT)  NO SQL
BEGIN
DELETE FROM tbl_log_errores WHERE date_fecha_loge <= fecha_fin AND date_fecha_loge >= fecha_ini;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FiltroRuta` ()  NO SQL
BEGIN
SELECT usu.codigo_ruta AS codigo,usu.id_usu AS id,usu.documento_usu AS cedula
FROM tbl_usuarios AS usu
WHERE usu.rol_usu = 2;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `logUsuarios` (IN `movimiento` TEXT, IN `id` BIGINT, IN `autor` BIGINT, IN `accion_func` TEXT, IN `controller` TEXT, IN `dia` TEXT)  NO SQL
BEGIN
INSERT INTO tbl_log_usuarios (id_logu,movimiento_logu,fecha_logu,id_usu,id_autor_usu,controller_logu,accion_func_logu,fecha_dia_validar_logu) VALUES (NULL, movimiento,now(),id,autor,controller,accion_func,dia);
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerFiltroCliente` (IN `id` BIGINT)  NO SQL
BEGIN

	SELECT
    id_clie AS id,
    CONCAT_WS(' ', primer_nombre_clie, segundo_nombre_clie, primer_apellido_clie, segundo_apellido_clie) AS cliente, documento_clie as documento FROM tbl_cliente WHERE id_usu=id;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerVendedores` ()  NO SQL
BEGIN
	SELECT id_usu,primer_nombre_usu,segundo_nombre_usu,primer_apellido_usu,segundo_apellido_usu, documento_usu FROM tbl_usuarios WHERE rol_usu = 2;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_caja`
--

CREATE TABLE `tbl_caja` (
  `id_caja` bigint(20) NOT NULL,
  `saldo_caja` double NOT NULL,
  `id_usu` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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
  `prestamo_minimo_client` double NOT NULL,
  `prestamo_maximo_client` double NOT NULL,
  `orden_ruta_clie` int(11) NOT NULL,
  `cumplimineto_client` int(11) NOT NULL DEFAULT 0 COMMENT '0-no pago,1-pago',
  `autorizarMaxMin_clie` int(11) NOT NULL DEFAULT 0,
  `max_auto_clie` double NOT NULL DEFAULT 0,
  `min_auto_clie` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historial_vendedor`
--

CREATE TABLE `tbl_historial_vendedor` (
  `id_histV` bigint(20) NOT NULL,
  `saldoInicial_histV` double NOT NULL,
  `cerrado_histV` int(11) NOT NULL,
  `validar_histV` int(11) NOT NULL,
  `fecha_histV` datetime NOT NULL,
  `id_usu` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_cierre`
--

CREATE TABLE `tbl_log_cierre` (
  `id_cierre` bigint(20) NOT NULL,
  `fecha_cierre` datetime NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `tipo_cierre` int(11) NOT NULL COMMENT '0-manual,1-automatico',
  `longitud_cierre` text COLLATE utf8_swedish_ci NOT NULL,
  `latitud_cierre` text COLLATE utf8_swedish_ci NOT NULL,
  `ip_cierre` double NOT NULL,
  `id_usu_cierre` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_cliente`
--

CREATE TABLE `tbl_log_cliente` (
  `id_logc` bigint(20) NOT NULL,
  `movimiento_logc` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,2-cambiar orden,3-DESACTIVAR,4-ABONO,5-ACTUALIZAR ABONO,6-CAMBIO ESTADO,7-autorizar cambio de saldo',
  `fecha_logc` datetime NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `controller_logc` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_usu` bigint(20) NOT NULL,
  `accion_func_logc` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_prestamo`
--

CREATE TABLE `tbl_log_prestamo` (
  `id_logp` bigint(20) NOT NULL,
  `movimiento_logp` int(11) NOT NULL COMMENT '0-CREAR, 1-ABONAR,2-ACTUALIZAR,3-CANCELAR',
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
  `apuntadaor_prestamo_logp` bigint(20) NOT NULL DEFAULT 0,
  `numeroCouta_logp` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_log_usuarios`
--

CREATE TABLE `tbl_log_usuarios` (
  `id_logu` bigint(20) NOT NULL,
  `movimiento_logu` int(11) NOT NULL COMMENT '0-CREAR, 1-UPDATE,3-DESACTIVAR,4-validar',
  `fecha_logu` datetime NOT NULL,
  `fecha_dia_validar_logu` datetime DEFAULT NULL,
  `id_usu` bigint(20) NOT NULL,
  `controller_logu` text COLLATE utf8_swedish_ci DEFAULT NULL,
  `id_autor_usu` bigint(20) NOT NULL,
  `accion_func_logu` text COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_notificaciones`
--

CREATE TABLE `tbl_notificaciones` (
  `id_noti` int(11) NOT NULL,
  `id_usu_remitente_noti` bigint(20) NOT NULL,
  `id_usu_destinatario_noti` bigint(20) NOT NULL,
  `tipo_noti` int(11) NOT NULL,
  `leido_noti` int(11) NOT NULL,
  `fecha_noti` datetime NOT NULL,
  `mensaje_noti` text COLLATE utf8_swedish_ci NOT NULL,
  `tittle_noti` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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
  `valor_neto_clie` double NOT NULL,
  `atraso_pres` int(11) NOT NULL DEFAULT 0,
  `estado_pres` int(11) NOT NULL DEFAULT 1,
  `valor_desactivado_pres` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_retiro`
--

CREATE TABLE `tbl_retiro` (
  `id_ret` bigint(20) NOT NULL,
  `id_caja` bigint(20) NOT NULL,
  `id_usu` bigint(20) NOT NULL,
  `id_ruta_usu` bigint(20) NOT NULL,
  `descripcion_ret` text COLLATE utf8_swedish_ci NOT NULL,
  `valor_ret` double NOT NULL,
  `latitud_ret` text COLLATE utf8_swedish_ci NOT NULL,
  `longitud_ret` text COLLATE utf8_swedish_ci NOT NULL,
  `fecha_ret` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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
  `codigo_ruta` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `cerrar_usu` int(11) NOT NULL COMMENT '1-manual,2-administrador festivo',
  `validar_usu` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usu`, `documento_usu`, `primer_nombre_usu`, `segundo_nombre_usu`, `primer_apellido_usu`, `segundo_apellido_usu`, `telefono_1_usu`, `telefono_2_usu`, `direcion_usu`, `sexo_usu`, `correo_usu`, `contrasena_usu`, `fecha_nacimineto_usu`, `foto_usu`, `estado_usu`, `rol_usu`, `estado_localidad_usu`, `ciudad_localidad_usu`, `codigo_ruta`, `cerrar_usu`, `validar_usu`) VALUES
(1, 1000898270, 'administrador', ' ', 'coordinador', ' ', 3015651772, 421244112, 'no hay', 0, 'brCredit@gmail.com', '$2y$09$RWom31HGCjhcYrM8rrvbWOA1TsIc7YNI24uScBT1Yz3YRLvJtqdYi', '2008-02-04 00:00:00', '20201111051747_1.png', 1, 1, '3', '223', '', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_caja`
--
ALTER TABLE `tbl_caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD PRIMARY KEY (`id_clie`),
  ADD KEY `FK_USUARIO` (`id_usu`);

--
-- Indices de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  ADD PRIMARY KEY (`id_gas`),
  ADD KEY `FK_USUARIO` (`id_usu`);

--
-- Indices de la tabla `tbl_historial_vendedor`
--
ALTER TABLE `tbl_historial_vendedor`
  ADD PRIMARY KEY (`id_histV`);

--
-- Indices de la tabla `tbl_log_cierre`
--
ALTER TABLE `tbl_log_cierre`
  ADD PRIMARY KEY (`id_cierre`);

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
  ADD PRIMARY KEY (`id_logp`),
  ADD KEY `FK_PRESTAMO` (`id_pres`);

--
-- Indices de la tabla `tbl_log_tipo_gasto`
--
ALTER TABLE `tbl_log_tipo_gasto`
  ADD PRIMARY KEY (`id_logt`),
  ADD KEY `FK_TIPO_GASTO-LOG` (`id_tipo_gasto_logt`) USING BTREE;

--
-- Indices de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD PRIMARY KEY (`id_logu`),
  ADD KEY `FK_USUARIO-LOG` (`id_usu`);

--
-- Indices de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  ADD PRIMARY KEY (`id_noti`);

--
-- Indices de la tabla `tbl_prestamo`
--
ALTER TABLE `tbl_prestamo`
  ADD PRIMARY KEY (`id_pres`),
  ADD KEY `FK_CLIENTE` (`id_clie`);

--
-- Indices de la tabla `tbl_retiro`
--
ALTER TABLE `tbl_retiro`
  ADD PRIMARY KEY (`id_ret`);

--
-- Indices de la tabla `tbl_ruta_historial`
--
ALTER TABLE `tbl_ruta_historial`
  ADD PRIMARY KEY (`id_rutaH`);

--
-- Indices de la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  ADD PRIMARY KEY (`id_tipog`),
  ADD KEY `FK_USUARIO` (`id_usu`);

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
-- AUTO_INCREMENT de la tabla `tbl_caja`
--
ALTER TABLE `tbl_caja`
  MODIFY `id_caja` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  MODIFY `id_clie` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  MODIFY `id_gas` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_vendedor`
--
ALTER TABLE `tbl_historial_vendedor`
  MODIFY `id_histV` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_cierre`
--
ALTER TABLE `tbl_log_cierre`
  MODIFY `id_cierre` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_cliente`
--
ALTER TABLE `tbl_log_cliente`
  MODIFY `id_logc` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  MODIFY `int_id_loge` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  MODIFY `id_logg` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_prestamo`
--
ALTER TABLE `tbl_log_prestamo`
  MODIFY `id_logp` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_tipo_gasto`
--
ALTER TABLE `tbl_log_tipo_gasto`
  MODIFY `id_logt` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  MODIFY `id_logu` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_noti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_prestamo`
--
ALTER TABLE `tbl_prestamo`
  MODIFY `id_pres` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_retiro`
--
ALTER TABLE `tbl_retiro`
  MODIFY `id_ret` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_ruta_historial`
--
ALTER TABLE `tbl_ruta_historial`
  MODIFY `id_rutaH` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  MODIFY `id_tipog` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD CONSTRAINT `tbl_cliente_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`);

--
-- Filtros para la tabla `tbl_gasto`
--
ALTER TABLE `tbl_gasto`
  ADD CONSTRAINT `tbl_gasto_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_log_cliente`
--
ALTER TABLE `tbl_log_cliente`
  ADD CONSTRAINT `tbl_log_cliente_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_cliente` (`id_clie`);

--
-- Filtros para la tabla `tbl_log_errores`
--
ALTER TABLE `tbl_log_errores`
  ADD CONSTRAINT `tbl_log_errores_ibfk_1` FOREIGN KEY (`int_id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_log_gasto`
--
ALTER TABLE `tbl_log_gasto`
  ADD CONSTRAINT `tbl_log_gasto_ibfk_1` FOREIGN KEY (`id_gas`) REFERENCES `tbl_gasto` (`id_gas`);

--
-- Filtros para la tabla `tbl_log_prestamo`
--
ALTER TABLE `tbl_log_prestamo`
  ADD CONSTRAINT `tbl_log_prestamo_ibfk_1` FOREIGN KEY (`id_pres`) REFERENCES `tbl_prestamo` (`id_pres`);

--
-- Filtros para la tabla `tbl_log_tipo_gasto`
--
ALTER TABLE `tbl_log_tipo_gasto`
  ADD CONSTRAINT `tbl_log_tipo_gasto_ibfk_1` FOREIGN KEY (`id_tipo_gasto_logt`) REFERENCES `tbl_tipo_gasto` (`id_tipog`);

--
-- Filtros para la tabla `tbl_log_usuarios`
--
ALTER TABLE `tbl_log_usuarios`
  ADD CONSTRAINT `tbl_log_usuarios_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_prestamo`
--
ALTER TABLE `tbl_prestamo`
  ADD CONSTRAINT `tbl_prestamo_ibfk_1` FOREIGN KEY (`id_clie`) REFERENCES `tbl_cliente` (`id_clie`);

--
-- Filtros para la tabla `tbl_tipo_gasto`
--
ALTER TABLE `tbl_tipo_gasto`
  ADD CONSTRAINT `tbl_tipo_gasto_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `tbl_usuarios` (`id_usu`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `eventoPagoHistrorial` ON SCHEDULE EVERY 1 DAY STARTS '2020-11-19 23:59:59' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
INSERT INTO tbl_ruta_historial (id_rutaH, id_clien, cumplimineto_rutaH, fecha_rutaH,id_pres,id_log_pres_rutaH) 
(SELECT NULL,
tbl_cliente.id_clie,
if(tbl_cliente.cumplimineto_client!=0,tbl_cliente.cumplimineto_client,0) AS cumplimineto_rutaH,
now() AS fecha_rutaH,
tbl_prestamo.id_pres,
tbl_cliente.cumplimineto_client
FROM tbl_cliente
LEFT JOIN tbl_prestamo ON (tbl_prestamo.id_clie=tbl_cliente.id_clie AND tbl_prestamo.valor_pres>0));

UPDATE tbl_cliente SET cumplimineto_client = 0;

INSERT INTO tbl_historial_vendedor (id_histV, saldoInicial_histV, cerrado_histV, validar_histV,fecha_histV,id_usu) 
(SELECT null,
 caj.saldo_caja as saldoInicial_histV,
 1,
 usu.validar_usu as validar_histV,
 now() as fecha_histV,
 usu.id_usu
FROM tbl_usuarios as usu
INNER JOIN tbl_caja as caj on (caj.id_usu=usu.id_usu)
WHERE usu.rol_usu=2);

UPDATE tbl_usuarios SET tbl_usuarios.cerrar_usu = 0;

UPDATE
    tbl_prestamo
    INNER JOIN tbl_cliente ON (tbl_cliente.id_clie=tbl_prestamo.id_clie)
SET
    tbl_prestamo.atraso_pres = tbl_prestamo.atraso_pres+1
WHERE tbl_cliente.cumplimineto_client=0 AND tbl_prestamo.estado_pres=1;

END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
