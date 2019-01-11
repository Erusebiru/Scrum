-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: proyectoscrum
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `especificaciones`
--

DROP TABLE IF EXISTS `especificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especificaciones` (
  `id_spec` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_spec` varchar(50) NOT NULL,
  `horas` int(5) DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `id_sprint` int(10) DEFAULT NULL,
  `id_proyecto` int(10) NOT NULL,
  PRIMARY KEY (`id_spec`),
  KEY `fk_id_sprint_especificaciones` (`id_sprint`),
  KEY `fk_id_proyecto_especificaciones` (`id_proyecto`),
  CONSTRAINT `fk_id_proyecto_especificaciones` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE,
  CONSTRAINT `fk_id_sprint_especificaciones` FOREIGN KEY (`id_sprint`) REFERENCES `sprints` (`id_sprint`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especificaciones`
--

LOCK TABLES `especificaciones` WRITE;
/*!40000 ALTER TABLE `especificaciones` DISABLE KEYS */;
INSERT INTO `especificaciones` VALUES (1,'Crear tablas',2,'backlog',4,2),(2,'Aplicar estilo CSS',5,'backlog',4,2),(3,'Enviar e-mail',2,'asignada',5,2),(4,'Probar querys',5,'asignada',5,2),(5,'Mostrar backlog',1,'asignada',NULL,2);
/*!40000 ALTER TABLE `especificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos` (
  `id_grupo` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (1,'JRY'),(2,'DEK'),(3,'undefined');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gruposproyectos`
--

DROP TABLE IF EXISTS `gruposproyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gruposproyectos` (
  `id_proyecto` int(10) NOT NULL,
  `id_grupo` int(10) NOT NULL,
  PRIMARY KEY (`id_proyecto`,`id_grupo`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `gruposproyectos_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`),
  CONSTRAINT `gruposproyectos_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gruposproyectos`
--

LOCK TABLES `gruposproyectos` WRITE;
/*!40000 ALTER TABLE `gruposproyectos` DISABLE KEYS */;
INSERT INTO `gruposproyectos` VALUES (2,1),(5,1),(2,2);
/*!40000 ALTER TABLE `gruposproyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos` (
  `id_proyecto` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion_proyecto` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `ScrumMaster` int(10) NOT NULL,
  `ProductOwner` int(10) NOT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `fk_id_scrummaster_proyectos` (`ScrumMaster`),
  KEY `fk_id_productowner_proyectos` (`ProductOwner`),
  CONSTRAINT `fk_id_productowner_proyectos` FOREIGN KEY (`ProductOwner`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  CONSTRAINT `fk_id_scrummaster_proyectos` FOREIGN KEY (`ScrumMaster`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (1,'Quien es quien','Es un juego',7,8),(2,'Scrum','Es un metodo agile',7,8),(5,'Prueba','Esto es una prueba',7,8),(6,'Prueba2','',7,8),(7,'Prueba3','asdf',7,8);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sprints`
--

DROP TABLE IF EXISTS `sprints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sprints` (
  `id_sprint` int(10) NOT NULL AUTO_INCREMENT,
  `horasTotales` int(5) NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date NOT NULL,
  `id_proyecto` int(10) NOT NULL,
  PRIMARY KEY (`id_sprint`),
  KEY `fk_id_proyecto_sprints` (`id_proyecto`),
  CONSTRAINT `fk_id_proyecto_sprints` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sprints`
--

LOCK TABLES `sprints` WRITE;
/*!40000 ALTER TABLE `sprints` DISABLE KEYS */;
INSERT INTO `sprints` VALUES (4,24,'2018-12-13','2018-12-13',2),(5,27,'2018-12-13','2018-12-14',2),(6,20,'2018-12-14','2018-12-21',2),(7,6,'2018-12-21','2018-12-28',2),(8,30,'2018-12-31','2019-01-12',2);
/*!40000 ALTER TABLE `sprints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareas`
--

DROP TABLE IF EXISTS `tareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tareas` (
  `id_tarea` int(10) NOT NULL AUTO_INCREMENT,
  `descripcion_tarea` varchar(150) NOT NULL,
  `horas` int(5) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `dificultad` varchar(20) NOT NULL,
  `id_spec` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  PRIMARY KEY (`id_tarea`),
  KEY `fk_id_spec_tareas` (`id_spec`),
  KEY `fk_id_usuario_tareas` (`id_usuario`),
  CONSTRAINT `fk_id_spec_tareas` FOREIGN KEY (`id_spec`) REFERENCES `especificaciones` (`id_spec`) ON DELETE CASCADE,
  CONSTRAINT `fk_id_usuario_tareas` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas`
--

LOCK TABLES `tareas` WRITE;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_usuario`
--

DROP TABLE IF EXISTS `tipos_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_usuario` (
  `id_tipo_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(40) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_usuario`
--

LOCK TABLES `tipos_usuario` WRITE;
/*!40000 ALTER TABLE `tipos_usuario` DISABLE KEYS */;
INSERT INTO `tipos_usuario` VALUES (1,'scrumMaster'),(2,'productOwner'),(3,'developer'),(4,'admin');
/*!40000 ALTER TABLE `tipos_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(100) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_tipo_usuario` int(10) NOT NULL,
  `id_grupo` int(10) DEFAULT NULL,
  `id_spec` int(10) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_id_grupo_usuarios` (`id_grupo`),
  KEY `id_tipo_usuario_usuarios` (`id_tipo_usuario`),
  KEY `id_spec_usuarios` (`id_spec`),
  CONSTRAINT `fk_id_grupo_usuarios` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE CASCADE,
  CONSTRAINT `id_spec_usuarios` FOREIGN KEY (`id_spec`) REFERENCES `especificaciones` (`id_spec`) ON DELETE CASCADE,
  CONSTRAINT `id_tipo_usuario_usuarios` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuario` (`id_tipo_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Ruben','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','Erusebiru@gmail.com',3,1,NULL,NULL),(2,'Pop','fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe','p.sortcusco@gmail.com',3,1,NULL,NULL),(3,'Yaiza','99c6b56cedf01890cf29b9db727af00a40ce393ccdb63662034dfdd7f5ca54c2ced364032280697915ce00f53f06a89550bc1b6d06698c20985e6a0313cc713e','yaizacortes94@gmail.com',3,1,NULL,NULL),(7,'Leandro','fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe','yaizacortes94@gmail.com',1,NULL,NULL,NULL),(8,'Enric','fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe','yaizacortes94@gmail.com',2,NULL,NULL,NULL),(9,'Admin','887375daec62a9f02d32a63c9e14c7641a9a8a42e4fa8f6590eb928d9744b57bb5057a1d227e4d40ef911ac030590bbce2bfdb78103ff0b79094cee8425601f5','admin@localhost',4,NULL,NULL,NULL),(12,'Pepito','fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe','pepito@localhost',3,NULL,NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-11 19:26:21
