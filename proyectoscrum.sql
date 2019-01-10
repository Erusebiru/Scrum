-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2019 a las 15:47:46
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectoscrum`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especificaciones`
--

CREATE TABLE `especificaciones` (
  `id_spec` int(10) NOT NULL,
  `nombre_spec` varchar(50) NOT NULL,
  `horas` int(5) DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `id_sprint` int(10) DEFAULT NULL,
  `id_proyecto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `especificaciones`
--

INSERT INTO `especificaciones` (`id_spec`, `nombre_spec`, `horas`, `estado`, `id_sprint`, `id_proyecto`) VALUES
(1, 'Crear tablas', 2, 'backlog', 4, 2),
(2, 'Añadir colores', 5, 'backlog', 4, 2),
(3, 'Enviar e-mail', 2, 'backlog', 5, 2),
(4, 'Probar querys', 5, 'backlog', 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(10) NOT NULL,
  `nombre_grupo` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nombre_grupo`) VALUES
(1, 'JRY'),
(2, 'DEK'),
(3, 'undefined');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gruposproyectos`
--

CREATE TABLE `gruposproyectos` (
  `id_proyecto` int(10) NOT NULL,
  `id_grupo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `gruposproyectos`
--

INSERT INTO `gruposproyectos` (`id_proyecto`, `id_grupo`) VALUES
(2, 1),
(2, 2),
(5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(10) NOT NULL,
  `nombre_proyecto` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion_proyecto` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `ScrumMaster` int(10) NOT NULL,
  `ProductOwner` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `nombre_proyecto`, `descripcion_proyecto`, `ScrumMaster`, `ProductOwner`) VALUES
(1, 'Quien es quien', 'Es un juego', 7, 8),
(2, 'Scrum', 'Es un metodo agile', 7, 8),
(5, 'Prueba', 'Esto es una prueba', 7, 8),
(6, 'Prueba2', '', 7, 8),
(7, 'Prueba3', 'asdf', 7, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sprints`
--

CREATE TABLE `sprints` (
  `id_sprint` int(10) NOT NULL,
  `horasTotales` int(5) NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `id_proyecto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sprints`
--

INSERT INTO `sprints` (`id_sprint`, `horasTotales`, `Fecha_Inicio`, `Fecha_Fin`, `id_proyecto`) VALUES
(4, 24, '2018-12-13', '2018-12-13', 2),
(5, 27, '2018-12-13', '2018-12-14', 2),
(6, 20, '2018-12-14', '2018-12-21', 2),
(7, 6, '2018-12-21', '2018-12-28', 2),
(8, 30, '2018-12-31', '2019-01-12', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(10) NOT NULL,
  `descripcion_tarea` varchar(150) NOT NULL,
  `horas` int(5) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `dificultad` varchar(20) NOT NULL,
  `id_spec` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuario`
--

CREATE TABLE `tipos_usuario` (
  `id_tipo_usuario` int(10) NOT NULL,
  `nombre_tipo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipos_usuario`
--

INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `nombre_tipo`) VALUES
(1, 'scrumMaster'),
(2, 'productOwner'),
(3, 'developer'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_tipo_usuario` int(10) NOT NULL,
  `id_grupo` int(10) DEFAULT NULL,
  `id_spec` int(10) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password`, `email`, `id_tipo_usuario`, `id_grupo`, `id_spec`, `token`) VALUES
(1, 'Ruben', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', 'Erusebiru@gmail.com', 3, 1, NULL, NULL),
(2, 'Pop', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 'p.sortcusco@gmail.com', 3, 1, NULL, NULL),
(3, 'Yaiza', '99c6b56cedf01890cf29b9db727af00a40ce393ccdb63662034dfdd7f5ca54c2ced364032280697915ce00f53f06a89550bc1b6d06698c20985e6a0313cc713e', 'yaizacortes94@gmail.com', 3, 1, NULL, NULL),
(7, 'Leandro', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 'yaizacortes94@gmail.com', 1, NULL, NULL, NULL),
(8, 'Enric', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 'yaizacortes94@gmail.com', 2, NULL, NULL, NULL),
(9, 'Admin', '887375daec62a9f02d32a63c9e14c7641a9a8a42e4fa8f6590eb928d9744b57bb5057a1d227e4d40ef911ac030590bbce2bfdb78103ff0b79094cee8425601f5', 'admin@localhost', 4, NULL, NULL, NULL),
(12, 'Pepito', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 'pepito@localhost', 3, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `especificaciones`
--
ALTER TABLE `especificaciones`
  ADD PRIMARY KEY (`id_spec`),
  ADD KEY `fk_id_sprint_especificaciones` (`id_sprint`),
  ADD KEY `fk_id_proyecto_especificaciones` (`id_proyecto`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `gruposproyectos`
--
ALTER TABLE `gruposproyectos`
  ADD PRIMARY KEY (`id_proyecto`,`id_grupo`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `fk_id_scrummaster_proyectos` (`ScrumMaster`),
  ADD KEY `fk_id_productowner_proyectos` (`ProductOwner`);

--
-- Indices de la tabla `sprints`
--
ALTER TABLE `sprints`
  ADD PRIMARY KEY (`id_sprint`),
  ADD KEY `fk_id_proyecto_sprints` (`id_proyecto`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `fk_id_spec_tareas` (`id_spec`),
  ADD KEY `fk_id_usuario_tareas` (`id_usuario`);

--
-- Indices de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_id_grupo_usuarios` (`id_grupo`),
  ADD KEY `id_tipo_usuario_usuarios` (`id_tipo_usuario`),
  ADD KEY `id_spec_usuarios` (`id_spec`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `especificaciones`
--
ALTER TABLE `especificaciones`
  MODIFY `id_spec` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sprints`
--
ALTER TABLE `sprints`
  MODIFY `id_sprint` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  MODIFY `id_tipo_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `especificaciones`
--
ALTER TABLE `especificaciones`
  ADD CONSTRAINT `fk_id_proyecto_especificaciones` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_sprint_especificaciones` FOREIGN KEY (`id_sprint`) REFERENCES `sprints` (`id_sprint`) ON DELETE CASCADE;

--
-- Filtros para la tabla `gruposproyectos`
--
ALTER TABLE `gruposproyectos`
  ADD CONSTRAINT `gruposproyectos_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`),
  ADD CONSTRAINT `gruposproyectos_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_id_productowner_proyectos` FOREIGN KEY (`ProductOwner`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_scrummaster_proyectos` FOREIGN KEY (`ScrumMaster`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sprints`
--
ALTER TABLE `sprints`
  ADD CONSTRAINT `fk_id_proyecto_sprints` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `fk_id_spec_tareas` FOREIGN KEY (`id_spec`) REFERENCES `especificaciones` (`id_spec`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_usuario_tareas` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_id_grupo_usuarios` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_spec_usuarios` FOREIGN KEY (`id_spec`) REFERENCES `especificaciones` (`id_spec`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_tipo_usuario_usuarios` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuario` (`id_tipo_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
