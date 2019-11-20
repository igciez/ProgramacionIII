-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2019 a las 00:24:16
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
-- Base de datos: `tablas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `legajo` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `egreso` varchar(250) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`legajo`, `id`, `created_at`, `updated_at`, `egreso`) VALUES
(12, 1, '2019-11-20 00:04:10', '2019-11-20 00:23:36', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ip` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `metodo` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `legajo` int(11) NOT NULL,
  `tipo` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `imagenUno` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `imagenDos` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ip`, `ruta`, `metodo`, `legajo`, `tipo`, `clave`, `email`, `imagenUno`, `imagenDos`, `created_at`, `updated_at`) VALUES
('10001111', 'http://localhost/SegundoParcial/publicusuariosORM/users', 'POST', 1, 'admin', 'caWmQqtTqtRM6', 'nose@hotmail.com', 'C:\\xampp\\htdocs\\SegundoParcial\\src\\app\\modelORM../../../../imagenes/users1admin-19-11-2019-191710.jpg', 'C:\\xampp\\htdocs\\SegundoParcial\\src\\app\\modelORM../../../../imagenes/users1admin-19-11-2019-191710.jpg', '2019-11-19 23:17:10', '2019-11-19 23:17:10'),
('10001111', 'http://localhost/SegundoParcial/publicusuariosORM/users', 'POST', 2, 'profesor', 'caWmQqtTqtRM6', 'nose@hotmail.com', 'C:\\xampp\\htdocs\\SegundoParcial\\src\\app\\modelORM../../../../imagenes/users2profesor-19-11-2019-191750.jpg', 'C:\\xampp\\htdocs\\SegundoParcial\\src\\app\\modelORM../../../../imagenes/users2profesor-19-11-2019-191750.jpg', '2019-11-19 23:17:50', '2019-11-19 23:17:50'),
('10001111', 'http://localhost/SegundoParcial/publicusuariosORM/users', 'POST', 12, 'profesor', 'cavHIvV8N0ywg', 'mario@mail', 'C:\\xampp\\htdocs\\SegundoParcial\\src\\app\\modelORM../../../../imagenes/users12profesor-19-11-2019-193603.jpg', 'C:\\xampp\\htdocs\\SegundoParcial\\src\\app\\modelORM../../../../imagenes/users12profesor-19-11-2019-193603.jpg', '2019-11-19 23:36:03', '2019-11-19 23:36:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`legajo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
