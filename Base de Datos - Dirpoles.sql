-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-04-2025 a las 01:27:42
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dirpoles`
--
CREATE DATABASE IF NOT EXISTS `dirpoles` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `dirpoles`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `becas`
--

CREATE TABLE `becas` (
  `id_becas` int(11) NOT NULL,
  `id_solicitud_serv` int(11) DEFAULT NULL,
  `cta_bcv` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `direccion_pdf` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tipo_banco` varchar(4) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `becas`
--

INSERT INTO `becas` (`id_becas`, `id_solicitud_serv`, `cta_bcv`, `direccion_pdf`, `tipo_banco`, `fecha_creacion`) VALUES
(4, 27, '0101000000000000', 'uploads/trabajo social/becas/planillas de inscripcion/67c626635e65c_El cantico de la Llama y la Coro', '0102', '2025-03-03'),
(5, 36, '0102000000000000', 'uploads/trabajo social/becas/planillas de inscripcion/67d0ebaa3b7ff_El cantico de la Llama y la Coro', '0102', '2025-03-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiario`
--

CREATE TABLE `beneficiario` (
  `id_beneficiario` int(11) NOT NULL,
  `id_pnf` int(11) DEFAULT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tipo_cedula` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cedula` varchar(12) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `genero` char(10) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estatus` int(10) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `beneficiario`
--

INSERT INTO `beneficiario` (`id_beneficiario`, `id_pnf`, `nombres`, `apellidos`, `tipo_cedula`, `cedula`, `fecha_nac`, `telefono`, `correo`, `genero`, `direccion`, `estatus`, `fecha_creacion`) VALUES
(1, 1, 'Daniel', 'Zabala', 'V', '28281435', '2002-04-05', '04141110000', 'daniel@gmail.es', 'M', 'Calle 56', 1, '2025-03-03'),
(2, 5, 'Jesús ', 'Matos', 'V', '30995937', '2004-11-13', '04129991111', 'jesusmatos@gmail.com', 'M', 'Calle 54', 1, '2025-03-11'),
(4, 9, 'Valeria Valentina', 'Sevillano Ortegano', 'E', '30615761', '2006-09-09', '04141111000', 'Valerias@hotmail.com', 'F', 'calle 1', 1, '2025-03-16'),
(5, 9, 'asd', 'asd', 'V', '00000000', '2005-05-05', '04261234444', 'asd@gmail.com', 'M', 'asd', 1, '2025-03-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `modulo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `accion` enum('Registro','Lectura','Actualización','Eliminación') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bitacora`, `id_empleado`, `modulo`, `accion`, `descripcion`, `fecha`) VALUES
(1, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-16 03:05:29'),
(2, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-17 00:54:47'),
(3, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-17 00:56:50'),
(4, 1, 'Beneficiario', 'Registro', 'Registro de beneficiario exitoso', '2025-03-17 01:05:19'),
(5, 1, 'Beneficiario', 'Registro', 'Registro de beneficiario exitoso', '2025-03-17 01:30:14'),
(6, 1, 'Empleado', 'Actualización', 'Edicion de empleado exitoso', '2025-03-17 11:55:56'),
(11, 1, 'Empleado', 'Eliminación', 'Eliminacion de empleado exitoso', '2025-03-17 12:04:29'),
(13, 1, 'Empleado', 'Eliminación', 'Eliminacion de empleado exitoso', '2025-03-17 12:08:05'),
(14, 1, 'Discapacidad', 'Registro', 'Diagnostico registrado con éxito.', '2025-03-17 14:52:43'),
(15, 1, 'Discapacidad', 'Actualización', 'Diagnostico actualizado con éxito.', '2025-03-17 14:55:31'),
(16, 1, 'Discapacidad', 'Eliminación', 'Diagnostico eliminado con éxito.', '2025-03-17 14:55:35'),
(17, 1, 'Inventario Médico', 'Registro', 'Inventario registrado con exito.', '2025-03-17 15:05:14'),
(18, 1, 'Inventario Médico', 'Registro', 'Entrada del insumo registrada con éxito.', '2025-03-17 15:05:28'),
(19, 1, 'Inventario Médico', 'Actualización', 'Inventario actualizado con exito.', '2025-03-17 15:10:39'),
(20, 1, 'Inventario Médico', 'Registro', 'Salida registrada con exito.', '2025-03-17 15:29:34'),
(21, 1, 'Medicina', 'Registro', 'Diagnostico registrado con exito.', '2025-03-17 15:29:34'),
(22, 1, 'Medicina', 'Actualización', 'Diagnostico actualizado con éxito.', '2025-03-17 15:31:00'),
(23, 1, 'Medicina', 'Eliminación', 'Diagnostico eliminado con éxito.', '2025-03-17 15:32:06'),
(24, 2, 'Psicología', 'Registro', 'Cita del Diagnostico registrada con éxito.', '2025-03-17 16:19:37'),
(25, 2, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', '2025-03-17 16:19:37'),
(26, 1, 'Psicología', 'Actualización', 'Diagnostico actualizado con éxito.', '2025-03-17 16:19:44'),
(27, 1, 'Empleado', 'Eliminación', 'Eliminacion de empleado exitoso', '2025-03-18 15:57:28'),
(28, 1, 'Beneficiario', 'Eliminación', 'Eliminación de beneficiario exitosa', '2025-03-18 16:03:28'),
(29, 1, 'Inventario Médico', '', 'Inventario desbloqueado con exito.', '2025-03-18 16:31:46'),
(30, 1, 'Inventario Médico', 'Actualización', 'Inventario actualizado con exito.', '2025-03-18 16:31:46'),
(31, 1, 'Inventario Médico', 'Registro', 'Entrada del insumo registrada con éxito.', '2025-03-18 16:32:30'),
(32, 1, 'Inventario Médico', 'Actualización', 'Inventario actualizado con exito.', '2025-03-18 16:36:43'),
(33, 1, 'Inventario Médico', 'Actualización', 'Inventario actualizado con exito.', '2025-03-18 16:38:33'),
(34, 1, 'Cita', '', 'Creación de cita exitosa', '2025-03-19 03:17:13'),
(35, 1, 'Cita', 'Registro', 'Creación de cita exitosa', '2025-03-19 12:04:33'),
(36, 1, 'Cita', 'Registro', 'Creación de cita exitosa', '2025-03-19 12:05:06'),
(37, 1, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', '2025-03-19 12:15:25'),
(38, 1, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', '2025-03-19 12:15:32'),
(39, 1, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', '2025-03-19 12:15:40'),
(40, 1, 'Psicología', 'Registro', 'Diagnostico registrado con éxito.', '2025-03-19 12:15:56'),
(41, 2, 'Psicología', 'Actualización', 'Diagnostico actualizado con éxito.', '2025-03-20 22:22:46'),
(42, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-20 22:40:55'),
(43, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-20 22:41:28'),
(44, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-20 22:41:54'),
(45, 1, 'Empleado', 'Actualización', 'Actualización de empleado exitoso', '2025-03-20 22:42:22'),
(46, 1, 'Empleado', 'Actualización', 'Actualización de empleado exitoso', '2025-03-20 22:43:26'),
(47, 1, 'Empleado', 'Registro', 'Registro de empleado exitoso', '2025-03-20 22:43:56'),
(48, 3, 'Inventario Médico', 'Registro', 'Salida registrada con exito.', '2025-03-20 22:44:58'),
(49, 3, 'Medicina', 'Registro', 'Diagnostico registrado con exito.', '2025-03-20 22:44:58'),
(50, 3, 'Inventario Médico', 'Registro', 'Entrada del insumo registrada con éxito.', '2025-03-20 22:48:38'),
(51, 6, 'Discapacidad', 'Registro', 'Diagnostico registrado con exito.', '2025-03-20 22:56:58'),
(52, 1, 'Discapacidad', 'Registro', 'Diagnostico registrado con exito.', '2025-03-20 22:58:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_beneficiario` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `fecha`, `hora`, `id_beneficiario`, `id_empleado`, `estatus`, `fecha_creacion`) VALUES
(2, '2025-03-03', '10:34:00', 1, 2, 1, '2025-03-03'),
(3, '2025-03-03', '12:35:00', 1, 2, 1, '2025-03-03'),
(4, '2025-03-03', '10:45:00', 1, 2, 1, '2025-03-03'),
(5, '2025-03-10', '10:00:00', 1, 2, 1, '2025-03-08'),
(6, '2025-03-10', '11:00:00', 1, 2, 1, '2025-03-08'),
(7, '2025-03-11', '10:30:00', 1, 2, 1, '2025-03-08'),
(8, '2025-03-11', '12:40:00', 1, 2, 1, '2025-03-08'),
(9, '2025-03-17', '10:20:00', 5, 2, 1, '2025-03-17'),
(10, '2025-03-24', '09:19:00', 2, 2, 1, '2025-03-18'),
(11, '2025-03-25', '11:04:00', 4, 2, 1, '2025-03-19'),
(12, '2025-03-25', '10:00:00', 2, 2, 1, '2025-03-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_medica`
--

CREATE TABLE `consulta_medica` (
  `id_consulta_med` int(11) NOT NULL,
  `id_detalle_patologia` int(11) NOT NULL,
  `id_solicitud_serv` int(11) NOT NULL,
  `estatura` decimal(4,2) NOT NULL,
  `peso` decimal(4,2) NOT NULL,
  `tipo_sangre` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `motivo_visita` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `diagnostico` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tratamiento` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `consulta_medica`
--

INSERT INTO `consulta_medica` (`id_consulta_med`, `id_detalle_patologia`, `id_solicitud_serv`, `estatura`, `peso`, `tipo_sangre`, `motivo_visita`, `diagnostico`, `tratamiento`, `observaciones`, `fecha_creacion`) VALUES
(3, 14, 38, '1.75', '88.00', 'A+', 'si', 'asd', 'asd', 'asd', '2025-03-13'),
(4, 15, 39, '1.88', '80.00', 'A+', 'Motivo', 'Diagnostico', 'Tratamiento', 'Observaciones', '2025-03-15'),
(5, 18, 47, '1.60', '70.00', 'A+', 'asd', 'asd', 'asd', 'dsa', '2025-03-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_psicologica`
--

CREATE TABLE `consulta_psicologica` (
  `id_psicologia` int(11) NOT NULL,
  `id_solicitud_serv` int(11) NOT NULL,
  `id_detalle_patologia` int(11) DEFAULT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `diagnostico` text COLLATE utf8mb4_spanish2_ci,
  `tratamiento_gen` text COLLATE utf8mb4_spanish2_ci,
  `observaciones` text COLLATE utf8mb4_spanish2_ci,
  `motivo_otro` text COLLATE utf8mb4_spanish2_ci,
  `motivo` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `consulta_psicologica`
--

INSERT INTO `consulta_psicologica` (`id_psicologia`, `id_solicitud_serv`, `id_detalle_patologia`, `id_cita`, `diagnostico`, `tratamiento_gen`, `observaciones`, `motivo_otro`, `motivo`, `fecha_creacion`) VALUES
(8, 23, 6, 4, 'N/A', 'N/A', 'N/A', 'Sin motivo', 'general', '2025-03-03'),
(9, 24, 7, NULL, 'Aplicable', 'Aplicable', 'Aplicable', 'Sin motivo', 'general', '2025-03-03'),
(10, 29, 9, 7, 'No', 'No', 'se', 'Sin motivo', 'general', '2025-03-08'),
(11, 30, 10, 8, 'asd', 'asd', 'asd', 'Sin motivo', 'general', '2025-03-08'),
(12, 32, NULL, NULL, NULL, NULL, 'asd', 'asd', 'cambio', '2025-03-11'),
(13, 33, NULL, NULL, NULL, NULL, '2', '2', 'retiro', '2025-03-11'),
(14, 42, 17, 9, 'N/As', 'N/A', 'N/A', 'Sin motivo', 'general', '2025-03-17'),
(15, 43, NULL, NULL, NULL, NULL, 'asd', 'asd', 'cambio', '2025-03-19'),
(16, 44, NULL, NULL, NULL, NULL, 'ss', 'ss', 'retiro', '2025-03-19'),
(17, 45, NULL, NULL, NULL, NULL, 'cy', 'cu', 'retiro', '2025-03-19'),
(18, 46, NULL, NULL, NULL, NULL, 'no se', 'no se', 'cambio', '2025-03-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_insumo`
--

CREATE TABLE `detalle_insumo` (
  `id_detalle_insumo` int(11) NOT NULL,
  `id_consulta_med` int(11) NOT NULL,
  `id_insumo` int(11) NOT NULL,
  `cantidad_usada` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_insumo`
--

INSERT INTO `detalle_insumo` (`id_detalle_insumo`, `id_consulta_med`, `id_insumo`, `cantidad_usada`) VALUES
(3, 3, 3, '5'),
(4, 4, 8, '10'),
(5, 5, 9, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_patologia`
--

CREATE TABLE `detalle_patologia` (
  `id_detalle_patologia` int(11) NOT NULL,
  `id_patologia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_patologia`
--

INSERT INTO `detalle_patologia` (`id_detalle_patologia`, `id_patologia`) VALUES
(10, NULL),
(2, 1),
(18, 1),
(3, 2),
(12, 2),
(14, 2),
(15, 3),
(6, 4),
(7, 4),
(9, 4),
(17, 4),
(5, 5),
(4, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discapacidad`
--

CREATE TABLE `discapacidad` (
  `id_discapacidad` int(11) NOT NULL,
  `id_solicitud_serv` int(11) NOT NULL,
  `condicion_medica` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cirugia_prev` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `toma_medicamentos_reg` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `naturaleza_discapacidad` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `impacto_disc` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `habilidades_funcionales_b` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `requiere_asistencia` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dispositivo_asistencia` varchar(500) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `salud_mental` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apoyo_psicologico` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `carnet_discapacidad` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `discapacidad`
--

INSERT INTO `discapacidad` (`id_discapacidad`, `id_solicitud_serv`, `condicion_medica`, `cirugia_prev`, `toma_medicamentos_reg`, `naturaleza_discapacidad`, `impacto_disc`, `habilidades_funcionales_b`, `requiere_asistencia`, `dispositivo_asistencia`, `salud_mental`, `apoyo_psicologico`, `fecha_creacion`, `carnet_discapacidad`) VALUES
(1, 48, 'a', 'No', 'No', 'a', 'a', 'a', 'No', 'a', 'a', 'No', '2025-03-20', 'D- 123123123'),
(2, 49, 'asd', 'No', 'No', 'asd', 'asd', 'asd', 'No', 'asd', 'asd', 'No', '2025-03-20', 'D- 111111');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tipo_cedula` varchar(1) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cedula` varchar(10) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` varchar(12) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `id_tipo_empleado` int(1) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion` mediumtext COLLATE utf8mb4_spanish2_ci,
  `clave` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `apellido`, `tipo_cedula`, `cedula`, `correo`, `telefono`, `id_tipo_empleado`, `fecha_nacimiento`, `direccion`, `clave`, `estatus`, `fecha_creacion`) VALUES
(1, 'Roberth', 'Matos', 'V', '28281433', 'admin@gmail.com', '04129298008', 6, '2002-04-05', 'Calle 54', '1234567r', 1, '2025-03-03'),
(2, 'Psicólogo', 'Rodriguez', 'V', '28281434', 'roberth@gmail.com', '04169298001', 1, '2002-04-05', 'Calle 55', '1234567r', 1, '2025-03-03'),
(3, 'Empleado', 'Medico', 'V', '12000000', 'medico@gmail.com', '04120000000', 2, '2000-01-01', 'Calle 1', '1234567r', 1, '2025-03-20'),
(4, 'Empleado', 'Trabajador Social', 'V', '12000001', 'trabajador_social@gmail.com', '04160000000', 3, '2000-01-01', 'Calle 1', '1234567r', 1, '2025-03-20'),
(5, 'Empleado', 'Orientador', 'V', '12000002', 'orientacion@gmail.com', '04160000001', 4, '2000-01-01', 'Calle 1', '1234567r', 1, '2025-03-20'),
(6, 'Empleado', 'Discapacidad', 'V', '12000004', 'discapacidad@gmail.com', '04160000002', 5, '2000-01-01', 'Calle 1', '1234567r', 1, '2025-03-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exoneracion`
--

CREATE TABLE `exoneracion` (
  `id_exoneracion` int(11) NOT NULL,
  `id_solicitud_serv` int(11) DEFAULT NULL,
  `motivo` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `otro_motivo` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `direccion_carta` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `direccion_estudiose` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `carnet_discapacidad` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `exoneracion`
--

INSERT INTO `exoneracion` (`id_exoneracion`, `id_solicitud_serv`, `motivo`, `otro_motivo`, `direccion_carta`, `direccion_estudiose`, `carnet_discapacidad`, `fecha_creacion`) VALUES
(1, 34, 'inscripcion', 'si', 'uploads/trabajo social/exoneracion/cartas/67d0e4e3bea17.pdf', NULL, 'D- 111111111', '2025-03-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fames`
--

CREATE TABLE `fames` (
  `id_fames` int(11) NOT NULL,
  `id_solicitud_serv` int(11) DEFAULT NULL,
  `id_detalle_patologia` int(11) NOT NULL,
  `tipo_ayuda` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `otro_tipo` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `fames`
--

INSERT INTO `fames` (`id_fames`, `id_solicitud_serv`, `id_detalle_patologia`, `tipo_ayuda`, `otro_tipo`, `fecha_creacion`) VALUES
(1, 35, 12, 'examenes', 'N/A', '2025-03-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `id_empleado`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES
(37, 2, 'Lunes', '08:00:00', '13:30:00'),
(38, 2, 'Martes', '08:00:00', '13:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id_insumo` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `nombre_insumo` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_insumo` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_creacion` date NOT NULL,
  `cantidad` int(255) NOT NULL,
  `estatus` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id_insumo`, `id_presentacion`, `nombre_insumo`, `descripcion`, `tipo_insumo`, `fecha_vencimiento`, `fecha_creacion`, `cantidad`, `estatus`) VALUES
(3, 19, 'Vitamina B', 'Vitaminas', 'Quirurgico', '2025-03-31', '2025-03-13', 100, 'Activo'),
(4, 18, 'Loratadina', '500mg', 'Quirurgico', '2025-03-31', '2025-03-14', 3, 'Activo'),
(8, 20, 'Gatorade', 's', 'Quirurgico', '2025-06-30', '2025-03-15', 10, 'Activo'),
(9, 18, 'hOLK', 'asd', 'Quirurgico', '2025-03-31', '2025-03-16', 154, 'Activo'),
(10, 22, 'Lozartan', 'de 500mg', 'Quirurgico', '2025-06-02', '2025-03-17', 100, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_medico`
--

CREATE TABLE `inventario_medico` (
  `id_inv_med` int(11) NOT NULL,
  `id_insumo` int(11) DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_movimiento` date NOT NULL,
  `tipo_movimiento` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cantidad` int(255) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `inventario_medico`
--

INSERT INTO `inventario_medico` (`id_inv_med`, `id_insumo`, `id_empleado`, `fecha_movimiento`, `tipo_movimiento`, `cantidad`, `descripcion`) VALUES
(4, 3, 1, '2025-03-13', 'Registro', 0, 'Nuevo registro'),
(5, 3, 1, '2025-03-13', 'Entrada', 10, 'Compra de tabletas'),
(6, 3, 1, '2025-03-13', 'Entrada', 10, 'Compra de tabletas de vitaminas'),
(7, 3, 1, '2025-03-13', 'Entrada', 10, 'Compra adicional del producto de vitamina b, esto lo escribo largo para ver que tanto debo truncar la tabla en los movimientos.'),
(9, 3, 1, '2025-03-13', 'Salida', 5, 'Salida de insumo para la consulta médica'),
(10, 3, 1, '2025-03-13', 'Salida', 5, 'Salida de insumo para la consulta médica'),
(11, 4, 1, '2025-03-14', 'Registro', 0, 'Nuevo registro'),
(12, 4, 1, '2025-03-14', 'Entrada', 10, 'Entrada'),
(16, 4, 1, '2025-03-14', 'Entrada', 5, 'a'),
(20, 3, 1, '2025-03-14', 'Entrada', 10, 'compra'),
(23, 3, 1, '2025-03-15', 'Entrada', 100, 'Compra'),
(24, 8, 1, '2025-03-15', 'Registro', 0, 'Nuevo registro'),
(25, 8, 1, '2025-03-15', 'Entrada', 10, 'Compra'),
(26, 8, 1, '2025-03-15', 'Salida', 10, 'Salida de insumo para la consulta médica'),
(27, 9, 1, '2025-03-16', 'Registro', 0, 'Nuevo registro'),
(28, 9, 1, '2025-03-16', 'Entrada', 5, 'compra inaudita'),
(29, 10, 1, '2025-03-17', 'Registro', 0, 'Nuevo registro'),
(30, 10, 1, '2025-03-17', 'Entrada', 100, 'Compra'),
(31, 4, 1, '2025-03-17', 'Salida', 2, 'Salida de insumo para la consulta médica'),
(32, 9, 1, '2025-03-18', 'Entrada', 155, 'Compra'),
(33, 9, 3, '2025-03-20', 'Salida', 1, 'Salida de insumo para la consulta médica'),
(34, 8, 3, '2025-03-20', 'Entrada', 10, 'Compra propia con mi propia plata');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_referencias`
--

CREATE TABLE `log_referencias` (
  `id_log` int(11) NOT NULL,
  `id_referencia` int(11) NOT NULL,
  `estado_anterior` enum('Pendiente','Aceptada','Rechazada') COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estado_nuevo` enum('Pendiente','Aceptada','Rechazada') COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_accion` datetime DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text COLLATE utf8mb4_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orientacion`
--

CREATE TABLE `orientacion` (
  `id_orientacion` int(11) NOT NULL,
  `id_solicitud_serv` int(11) DEFAULT NULL,
  `motivo_orientacion` mediumtext COLLATE utf8mb4_spanish2_ci,
  `descripcion_orientacion` mediumtext COLLATE utf8mb4_spanish2_ci,
  `obs_adic_orientacion` mediumtext COLLATE utf8mb4_spanish2_ci,
  `indicaciones_orientacion` mediumtext COLLATE utf8mb4_spanish2_ci,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `orientacion`
--

INSERT INTO `orientacion` (`id_orientacion`, `id_solicitud_serv`, `motivo_orientacion`, `descripcion_orientacion`, `obs_adic_orientacion`, `indicaciones_orientacion`, `fecha_creacion`) VALUES
(5, 26, 'ninguno', '1', '1', '1', '2025-03-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologia`
--

CREATE TABLE `patologia` (
  `id_patologia` int(11) NOT NULL,
  `nombre_patologia` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tipo_patologia` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `patologia`
--

INSERT INTO `patologia` (`id_patologia`, `nombre_patologia`, `tipo_patologia`, `fecha_creacion`) VALUES
(1, 'Diabetes tipo 1', 'medica', '2024-11-20'),
(2, 'Hipertensión ', 'medica', '2024-11-20'),
(3, 'Alzheimer ', 'medica', '2024-11-20'),
(4, 'Trastorno de ansiedad', 'psicologica', '2024-11-20'),
(5, 'Trastorno bipolar', 'psicologica', '2024-11-20'),
(6, 'Esquizofrenia ', 'psicologica', '2024-11-20'),
(8, 'Lupus', 'medica', '2024-11-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pnf`
--

CREATE TABLE `pnf` (
  `id_pnf` int(11) NOT NULL,
  `nombre_pnf` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `pnf`
--

INSERT INTO `pnf` (`id_pnf`, `nombre_pnf`, `estatus`, `fecha_creacion`) VALUES
(1, 'PNF Administración', 1, '2024-11-12'),
(2, 'PNF Contaduría', 1, '2024-11-12'),
(3, 'PNF Informática', 1, '2024-11-12'),
(4, 'PNF Higiene y Seguridad Laboral', 1, '2024-11-12'),
(5, 'PNF Deporte', 1, '2024-11-12'),
(6, 'PNF Turismo', 1, '2024-11-12'),
(7, 'PNF Ciencias de la Información', 1, '2024-11-12'),
(8, 'PNF Sistemas de Calidad y Ambiente', 1, '2024-11-12'),
(9, 'PNF Agroalimentación', 1, '2024-11-12'),
(10, 'PNF Distribución y Logística', 1, '2024-11-12'),
(15, 'PNF Fisioterapeuta', 1, '2024-11-21'),
(16, 'PNF Materiales Industriales', 1, '2024-11-26'),
(17, 'PNF Procesos Químicos', 1, '2024-11-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion_insumo`
--

CREATE TABLE `presentacion_insumo` (
  `id_presentacion` int(11) NOT NULL,
  `nombre_presentacion` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `presentacion_insumo`
--

INSERT INTO `presentacion_insumo` (`id_presentacion`, `nombre_presentacion`, `fecha_creacion`) VALUES
(17, 'Comprimidos', '2024-11-20'),
(18, 'Capsulas blandas', '2024-11-20'),
(19, 'Tabletas', '2024-11-20'),
(20, 'jarabe', '2024-11-20'),
(21, 'Granulado', '2024-11-20'),
(22, 'Emulsion', '2024-11-20'),
(23, 'Caja ', '2024-11-20'),
(25, 'Cremas', '2024-11-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias`
--

CREATE TABLE `referencias` (
  `id_referencia` int(11) NOT NULL,
  `id_beneficiario` int(11) NOT NULL,
  `id_empleado_origen` int(11) NOT NULL,
  `id_servicio_origen` int(11) NOT NULL,
  `id_empleado_destino` int(11) DEFAULT NULL,
  `id_servicio_destino` int(11) NOT NULL,
  `fecha_referencia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `motivo` varchar(255) DEFAULT NULL,
  `estado` enum('Pendiente','Aceptada','Rechazada') DEFAULT 'Pendiente',
  `observaciones` text,
  `archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicios` int(11) NOT NULL,
  `nombre_serv` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicios`, `nombre_serv`, `estatus`, `fecha_creacion`) VALUES
(2, 'Psicologia', 1, '2024-11-12'),
(3, 'Medicina', 1, '2024-11-12'),
(4, 'Orientacion', 1, '2024-11-12'),
(5, 'Trabajo Social', 1, '2024-11-12'),
(6, 'Discapacidad', 1, '2024-11-12'),
(9, 'Musica', 1, '2024-11-20'),
(11, 'Comedor', 1, '2024-11-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_de_servicio`
--

CREATE TABLE `solicitud_de_servicio` (
  `id_solicitud_serv` int(11) NOT NULL,
  `id_servicios` int(11) NOT NULL,
  `id_beneficiario` int(11) DEFAULT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `solicitud_de_servicio`
--

INSERT INTO `solicitud_de_servicio` (`id_solicitud_serv`, `id_servicios`, `id_beneficiario`, `id_empleado`) VALUES
(23, 2, 1, 2),
(24, 2, 1, 1),
(26, 4, 1, 1),
(27, 5, 1, 1),
(29, 2, 1, 2),
(30, 2, 1, 2),
(32, 2, 1, 1),
(33, 2, 1, 1),
(34, 5, 1, 1),
(35, 5, 1, 1),
(36, 5, 2, 1),
(38, 3, 1, 1),
(39, 3, 2, 1),
(42, 2, 5, 2),
(43, 2, 1, 1),
(44, 2, 1, 1),
(45, 2, 2, 1),
(46, 2, 1, 1),
(47, 3, 1, 3),
(48, 6, 2, 6),
(49, 6, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empleado`
--

CREATE TABLE `tipo_empleado` (
  `id_tipo_emp` int(11) NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_empleado`
--

INSERT INTO `tipo_empleado` (`id_tipo_emp`, `tipo`, `estatus`, `fecha_creacion`) VALUES
(1, 'Psicologo', 1, '2024-11-12'),
(2, 'Medico', 1, '2024-11-12'),
(3, 'Trabajador Social', 1, '2024-11-12'),
(4, 'Orientador', 1, '2024-11-12'),
(5, 'Discapacidad', 1, '2024-11-12'),
(6, 'Administrador', 1, '2024-11-12'),
(8, 'Secretaria', 1, '2024-11-14'),
(12, 'Gerente', 1, '2024-11-21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `becas`
--
ALTER TABLE `becas`
  ADD PRIMARY KEY (`id_becas`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`);

--
-- Indices de la tabla `beneficiario`
--
ALTER TABLE `beneficiario`
  ADD PRIMARY KEY (`id_beneficiario`) USING BTREE,
  ADD KEY `id_pnf` (`id_pnf`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_beneficiario` (`id_beneficiario`);

--
-- Indices de la tabla `consulta_medica`
--
ALTER TABLE `consulta_medica`
  ADD PRIMARY KEY (`id_consulta_med`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`),
  ADD KEY `id_detalle_patologia` (`id_detalle_patologia`);

--
-- Indices de la tabla `consulta_psicologica`
--
ALTER TABLE `consulta_psicologica`
  ADD PRIMARY KEY (`id_psicologia`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`),
  ADD KEY `id_cita` (`id_cita`),
  ADD KEY `id_detalle_patologia` (`id_detalle_patologia`);

--
-- Indices de la tabla `detalle_insumo`
--
ALTER TABLE `detalle_insumo`
  ADD PRIMARY KEY (`id_detalle_insumo`),
  ADD KEY `id_insumo` (`id_insumo`),
  ADD KEY `id_consulta_med` (`id_consulta_med`);

--
-- Indices de la tabla `detalle_patologia`
--
ALTER TABLE `detalle_patologia`
  ADD PRIMARY KEY (`id_detalle_patologia`),
  ADD KEY `id_patologia` (`id_patologia`);

--
-- Indices de la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  ADD PRIMARY KEY (`id_discapacidad`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_tipo_empleado` (`id_tipo_empleado`);

--
-- Indices de la tabla `exoneracion`
--
ALTER TABLE `exoneracion`
  ADD PRIMARY KEY (`id_exoneracion`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`);

--
-- Indices de la tabla `fames`
--
ALTER TABLE `fames`
  ADD PRIMARY KEY (`id_fames`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`),
  ADD KEY `id_detalle_patologia` (`id_detalle_patologia`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id_insumo`),
  ADD KEY `id_presentacion` (`id_presentacion`);

--
-- Indices de la tabla `inventario_medico`
--
ALTER TABLE `inventario_medico`
  ADD PRIMARY KEY (`id_inv_med`),
  ADD KEY `id_insumo` (`id_insumo`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `log_referencias`
--
ALTER TABLE `log_referencias`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_referencia` (`id_referencia`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `orientacion`
--
ALTER TABLE `orientacion`
  ADD PRIMARY KEY (`id_orientacion`),
  ADD KEY `id_solicitud_serv` (`id_solicitud_serv`);

--
-- Indices de la tabla `patologia`
--
ALTER TABLE `patologia`
  ADD PRIMARY KEY (`id_patologia`);

--
-- Indices de la tabla `pnf`
--
ALTER TABLE `pnf`
  ADD PRIMARY KEY (`id_pnf`) USING BTREE;

--
-- Indices de la tabla `presentacion_insumo`
--
ALTER TABLE `presentacion_insumo`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD PRIMARY KEY (`id_referencia`),
  ADD KEY `id_beneficiario` (`id_beneficiario`),
  ADD KEY `id_empleado_origen` (`id_empleado_origen`),
  ADD KEY `id_servicio_origen` (`id_servicio_origen`),
  ADD KEY `id_empleado_destino` (`id_empleado_destino`),
  ADD KEY `id_servicio_destino` (`id_servicio_destino`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicios`);

--
-- Indices de la tabla `solicitud_de_servicio`
--
ALTER TABLE `solicitud_de_servicio`
  ADD PRIMARY KEY (`id_solicitud_serv`),
  ADD KEY `id_beneficiario` (`id_beneficiario`),
  ADD KEY `id_servicios` (`id_servicios`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `tipo_empleado`
--
ALTER TABLE `tipo_empleado`
  ADD PRIMARY KEY (`id_tipo_emp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `becas`
--
ALTER TABLE `becas`
  MODIFY `id_becas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `beneficiario`
--
ALTER TABLE `beneficiario`
  MODIFY `id_beneficiario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `consulta_medica`
--
ALTER TABLE `consulta_medica`
  MODIFY `id_consulta_med` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `consulta_psicologica`
--
ALTER TABLE `consulta_psicologica`
  MODIFY `id_psicologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `detalle_insumo`
--
ALTER TABLE `detalle_insumo`
  MODIFY `id_detalle_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_patologia`
--
ALTER TABLE `detalle_patologia`
  MODIFY `id_detalle_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  MODIFY `id_discapacidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `exoneracion`
--
ALTER TABLE `exoneracion`
  MODIFY `id_exoneracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fames`
--
ALTER TABLE `fames`
  MODIFY `id_fames` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `inventario_medico`
--
ALTER TABLE `inventario_medico`
  MODIFY `id_inv_med` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `log_referencias`
--
ALTER TABLE `log_referencias`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orientacion`
--
ALTER TABLE `orientacion`
  MODIFY `id_orientacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_patologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pnf`
--
ALTER TABLE `pnf`
  MODIFY `id_pnf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `presentacion_insumo`
--
ALTER TABLE `presentacion_insumo`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `referencias`
--
ALTER TABLE `referencias`
  MODIFY `id_referencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `solicitud_de_servicio`
--
ALTER TABLE `solicitud_de_servicio`
  MODIFY `id_solicitud_serv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tipo_empleado`
--
ALTER TABLE `tipo_empleado`
  MODIFY `id_tipo_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `becas`
--
ALTER TABLE `becas`
  ADD CONSTRAINT `becas_ibfk_1` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`);

--
-- Filtros para la tabla `beneficiario`
--
ALTER TABLE `beneficiario`
  ADD CONSTRAINT `beneficiario_ibfk_1` FOREIGN KEY (`id_pnf`) REFERENCES `pnf` (`id_pnf`);

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_beneficiario`) REFERENCES `beneficiario` (`id_beneficiario`),
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `consulta_medica`
--
ALTER TABLE `consulta_medica`
  ADD CONSTRAINT `consulta_medica_ibfk_1` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`),
  ADD CONSTRAINT `consulta_medica_ibfk_2` FOREIGN KEY (`id_detalle_patologia`) REFERENCES `detalle_patologia` (`id_detalle_patologia`);

--
-- Filtros para la tabla `consulta_psicologica`
--
ALTER TABLE `consulta_psicologica`
  ADD CONSTRAINT `consulta_psicologica_ibfk_1` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`),
  ADD CONSTRAINT `consulta_psicologica_ibfk_2` FOREIGN KEY (`id_detalle_patologia`) REFERENCES `detalle_patologia` (`id_detalle_patologia`),
  ADD CONSTRAINT `consulta_psicologica_ibfk_3` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`);

--
-- Filtros para la tabla `detalle_insumo`
--
ALTER TABLE `detalle_insumo`
  ADD CONSTRAINT `detalle_insumo_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumos` (`id_insumo`),
  ADD CONSTRAINT `detalle_insumo_ibfk_2` FOREIGN KEY (`id_consulta_med`) REFERENCES `consulta_medica` (`id_consulta_med`);

--
-- Filtros para la tabla `detalle_patologia`
--
ALTER TABLE `detalle_patologia`
  ADD CONSTRAINT `detalle_patologia_ibfk_1` FOREIGN KEY (`id_patologia`) REFERENCES `patologia` (`id_patologia`);

--
-- Filtros para la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  ADD CONSTRAINT `discapacidad_ibfk_1` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_tipo_empleado`) REFERENCES `tipo_empleado` (`id_tipo_emp`);

--
-- Filtros para la tabla `exoneracion`
--
ALTER TABLE `exoneracion`
  ADD CONSTRAINT `exoneracion_ibfk_1` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`);

--
-- Filtros para la tabla `fames`
--
ALTER TABLE `fames`
  ADD CONSTRAINT `fames_ibfk_1` FOREIGN KEY (`id_detalle_patologia`) REFERENCES `detalle_patologia` (`id_detalle_patologia`),
  ADD CONSTRAINT `fames_ibfk_2` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD CONSTRAINT `insumos_ibfk_1` FOREIGN KEY (`id_presentacion`) REFERENCES `presentacion_insumo` (`id_presentacion`);

--
-- Filtros para la tabla `inventario_medico`
--
ALTER TABLE `inventario_medico`
  ADD CONSTRAINT `inventario_medico_ibfk_1` FOREIGN KEY (`id_insumo`) REFERENCES `insumos` (`id_insumo`),
  ADD CONSTRAINT `inventario_medico_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `log_referencias`
--
ALTER TABLE `log_referencias`
  ADD CONSTRAINT `log_referencias_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `orientacion`
--
ALTER TABLE `orientacion`
  ADD CONSTRAINT `orientacion_ibfk_1` FOREIGN KEY (`id_solicitud_serv`) REFERENCES `solicitud_de_servicio` (`id_solicitud_serv`);

--
-- Filtros para la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD CONSTRAINT `referencias_ibfk_1` FOREIGN KEY (`id_beneficiario`) REFERENCES `beneficiario` (`id_beneficiario`),
  ADD CONSTRAINT `referencias_ibfk_2` FOREIGN KEY (`id_empleado_origen`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `referencias_ibfk_3` FOREIGN KEY (`id_empleado_destino`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `referencias_ibfk_4` FOREIGN KEY (`id_servicio_origen`) REFERENCES `servicio` (`id_servicios`),
  ADD CONSTRAINT `referencias_ibfk_5` FOREIGN KEY (`id_servicio_destino`) REFERENCES `servicio` (`id_servicios`);

--
-- Filtros para la tabla `solicitud_de_servicio`
--
ALTER TABLE `solicitud_de_servicio`
  ADD CONSTRAINT `solicitud_de_servicio_ibfk_1` FOREIGN KEY (`id_servicios`) REFERENCES `servicio` (`id_servicios`),
  ADD CONSTRAINT `solicitud_de_servicio_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `solicitud_de_servicio_ibfk_3` FOREIGN KEY (`id_beneficiario`) REFERENCES `beneficiario` (`id_beneficiario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
