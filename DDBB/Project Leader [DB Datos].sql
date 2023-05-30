-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2014 a las 22:03:43
-- Versión del servidor: 5.6.11
-- Versión de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `project_leader`
--
CREATE DATABASE IF NOT EXISTS `project_leader` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `project_leader`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `empresa` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idUser` int(10) NOT NULL,
  `idProyecto` int(10) NOT NULL,
  `comentario` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `fechaHora` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comentarios_ibfk_1` (`idUser`),
  KEY `comentarios_ibfk_2` (`idProyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idCliente` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(1300) COLLATE utf8_unicode_ci NOT NULL,
  `fechaEntrega` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `prioridad` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proyectos_ibfk_1` (`idCliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE IF NOT EXISTS `puesto` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fechaNacimiento` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `idPuesto` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  KEY `usuarios_ibfk_1` (`idPuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idProyecto`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idPuesto`) REFERENCES `puesto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Restricciones para tablas volcadas
--

--
-- Volcado de datos para la tabla `puesto`
--
INSERT INTO `puesto` (`id`, `nombre`, `descripcion`) VALUES
(18, 'Jefe', 'Jefe de la Empresa'),
(19, 'Programador Web', 'Programador Web'),
(20, 'Programador Movil', 'Programador de Dispositivos Moviles'),
(21, 'Diseñador Grafico', 'Diseños Graficos y Web');

--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (`id`, `user`, `pass`, `nombre`, `fechaNacimiento`, `dni`, `telefono`, `email`, `idPuesto`) VALUES
(1, 'Luffy', '4bd0ec65b8f729d265faeba6fa933846d7c2d687', 'Monkey D. Luffy', '5 de Mayo', '400.000.000', '400.000.000', 'Luffy@one.piece', 18),
(2, 'Zoro', '49883eb5e70c93a32d57fc28e63210ebbeee983f', 'Roronoa Zoro', '11 de Noviembre', '120.000.000', '120.000.000', 'Zoro@one.piece', 19),
(3, 'Tony', 'd77ea13296d447f99a18bdc422e8fc7a808e7ba6', 'Tony Tony Chopper', '24 de Diciembre', '50', '50', 'Chopper@one.piece', 20),
(4, 'Robin', '3398634ce832346f0eaba574c18077083b0c4e1a', 'Niko Robin', '06 de Febrero', '80.000.000', '80.000.000', 'robin@one.piece', 21);

--
-- Volcado de datos para la tabla `clientes`
--
INSERT INTO `clientes` (`id`, `nombre`, `empresa`, `telefono`, `email`) VALUES
(17, 'Franky', 'Franky Family (Water 7)', '44.000.000', 'Franky@one.piec'),
(18, 'Nami', 'La Ga​ta Ladrona (La Ga​ta Ladrona)', '16.000.000', 'Nami@one.piece'),
(19, 'Sanji', 'Baratie', '77,000,000', 'Sanji@one.piece');

--
-- Volcado de datos para la tabla `proyectos`
--
INSERT INTO `proyectos` (`id`, `idCliente`, `nombre`, `descripcion`, `fechaEntrega`, `prioridad`, `estado`) VALUES
(15, 17, 'Grand Line', 'Proyecto Web', '10-06-2014', '1', 'Activo'),
(16, 18, 'Nuevo Mundo', 'Proyecto para Dispositivos Moviles', '10-07-2014', '3', 'Activo'),
(17, 19, 'Red Line', 'Proyecto Conjunto Web-Movil', '10-05-2014', '2', 'Desactivo');

--
-- Volcado de datos para la tabla `comentarios`
--
INSERT INTO `comentarios` (`id`, `idUser`, `idProyecto`, `comentario`, `fechaHora`) VALUES
(62, 1, 15, 'Este Proyecto Es Muy Urgente', '14-05-2014'),
(63, 3, 16, 'Lo Llevo Muy Avanzado', '15-05-2014');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
