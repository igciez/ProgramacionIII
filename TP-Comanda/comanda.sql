-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2019 a las 00:07:16
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(250) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `tipo`, `clave`, `estado`, `created_at`, `updated_at`) VALUES
(5, 'Silvio', 'Siloi', 'socio', 'caCkHa6lffLpI', 'activo', '2019-11-29 01:51:15', '2019-11-29 01:51:15'),
(6, 'lucas', 'patrol', 'cocinero', 'caCkHa6lffLpI', 'activo', '2019-12-02 23:34:54', '2019-12-02 23:34:54'),
(7, 'juan', 'Nuaj', 'mozo', 'caCkHa6lffLpI', 'activo', '2019-12-03 00:56:58', '2019-12-03 00:56:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_mesa` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `nombrePedido` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `nombreCliente` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `tiempo_preparacion` varchar(450) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_empleado`, `id_mesa`, `nombrePedido`, `nombreCliente`, `estado`, `tiempo_preparacion`, `created_at`, `updated_at`) VALUES
(1, 7, '81624', 'Array', 'cliente', 'pendiente', '', '2019-12-03 01:21:34', '2019-12-03 01:21:34'),
(3, 7, 'dfeb8', 'empanadas', 'cliente', 'Entregado', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NzUzMjc5MTIsImV4cCI6MTU3NTMzOTkxMiwiYXVkIjoiOTNkYjBiNjU4Mzc0ODkwY2JjM2VmMmZhMTFiNjA5ZGFlMDk1OWNiYiIsImRhdGEiOiJ0aWVtcG9QcmVwYXJhY2lvbiIsImFwcCI6IkFQSSBSRVNUIENEIFVUTiBGUkEifQ.atmqwhmfYz-EoU4Ur363fk-sdb', '2019-12-03 01:24:14', '2019-12-03 03:05:20'),
(4, 7, 'c41fb', 'vino', 'cliente', 'pendiente', '', '2019-12-03 01:27:08', '2019-12-03 01:27:08'),
(5, 7, 'dfeb8', 'cerbeza', 'cliente', 'pendiente', '', '2019-12-03 01:28:03', '2019-12-03 01:28:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
