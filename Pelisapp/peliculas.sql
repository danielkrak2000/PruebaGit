-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-06-2022 a las 14:12:16
-- Versión del servidor: 8.0.27-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `peliculas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `codigo_pelicula` int NOT NULL,
  `nombre` varchar(170) NOT NULL,
  `director` varchar(50) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `votaciones` int NOT NULL,
  `puntuacion` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`codigo_pelicula`, `nombre`, `director`, `genero`, `imagen`, `votaciones`, `puntuacion`) VALUES
(1, 'EL GOLPE', 'GEORGE ROY HILL', 'COMEDIA', 'El_golpe.jpg', 6, 23),
(2, 'LOS PAJAROS', 'ALFRED HITCHOCK', 'TERROR', 'Los pajaros.jpg', 0, 0),
(3, 'SOSPECHOSOS HABITUALES', 'BRYAN SINGER', 'SUSPENSE', 'sospechosos_habituales.jpg', 0, 0),
(4, 'PIRATAS DEL CARIBE. EN EL FIN DEL MUNDO', 'GORE VERBINSKI', 'AVENTURAS', 'piratas3.jpg', 0, 0),
(5, 'EL SEÑOR LOS DE LOS ANILLOS. LA COMUNIDAD DEL ANIL', 'PETER JACKSON', 'AVENTURAS', 'señor-anillos-1.jpg', 0, 0),
(6, 'WILLOW', 'RON HOWARD ', 'AVENTURAS', 'willow.jpg', 0, 0),
(7, 'BRAVEHEART', 'MEL GIBSON', 'AVENTURAS', 'Braveheart.jpg', 0, 0),
(8, 'ALIEN, EL OCTAVO PASAJERO', 'RIDLEY SCOTT ', 'TERROR', '', 0, 0),
(9, 'HOTEL RWANDA', 'TERRY GEORGE', 'DRAMA', '', 0, 0),
(10, 'CRASH (COLISIÓN)', 'PAUL HAGGIS', 'DRAMA', '', 0, 0),
(11, 'EL TEMIBLE BURLON', 'ROBERT SIODMAK', 'AVENTURAS', '', 0, 0),
(12, 'EL NUMERO 23', 'JOEL SCHUMACHER', 'SUSPENSE', '', 0, 0),
(13, 'BEN-HUR', 'WILLIAM WYLER ', 'DRAMA', '', 0, 0),
(14, 'SHREK 3', 'CHRIS MILLER', 'COMEDIA', '', 0, 0),
(15, 'LA LISTA DE SHILDER ', 'STEVEN SPIELBERG', 'DRAMA', '', 0, 0),
(16, 'LA GRAN EVASION', 'JOHN STURGES', 'BELICA', '', 0, 0),
(17, 'DOCE DEL PATIBULO', 'ROBERT ALDRICH', 'BELICA', '', 0, 0),
(18, 'DOCE MONOS', 'TERRY GILLIAM', 'SUSPENSE', '', 0, 0),
(19, 'AL ESTE DEL EDEN', 'ELIA KAZAN ', 'DRAMA', '', 0, 0),
(20, 'TIBURON', 'STEVEN SPIELBERG', 'TERROR', 'Jordi_Évole.jpg', 0, 0),
(21, 'MATRIX', ' LARRY Y ANDY WACHOWSKI', 'CIENCIA FICCION', '', 0, 0),
(22, 'AMERICAN HISTORY X', 'TONY KAYE', 'DRAMA', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `plan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contraseña`, `rol`, `correo`, `plan`) VALUES
(0, 'admin', 'admin', 'admin', 'admin@admin.es', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`codigo_pelicula`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `codigo_pelicula` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
