-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: coc
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extensao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `criado` datetime DEFAULT NULL,
  `editado` datetime DEFAULT NULL,
  `id_ordem_compra` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_documentos_1_idx` (`id_ordem_compra`),
  CONSTRAINT `fk_documentos_1` FOREIGN KEY (`id_ordem_compra`) REFERENCES `ordem_compra` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos`
--

LOCK TABLES `documentos` WRITE;
/*!40000 ALTER TABLE `documentos` DISABLE KEYS */;
INSERT INTO `documentos` VALUES (73,'Lista de ramais-versão  - Outubro 2020 ','xlsx','Lista de ramais-versão  - Outubro 2020 .xlsx','2020-10-13 16:58:32',NULL,162),(75,'KUTTNER_DO_BRASIL_EQUIPAMENTOS_SIDERURGICOS_LIMITADA 2308901','pdf','KUTTNER_DO_BRASIL_EQUIPAMENTOS_SIDERURGICOS_LIMITADA 2308901.pdf','2020-10-13 17:05:01',NULL,162),(77,'Lista de ramais-versão  - Outubro 2020  (5)','xlsx','Lista de ramais-versão  - Outubro 2020  (5).xlsx','2020-10-13 17:15:01',NULL,163),(78,'Lista de ramais-versão  - Outubro 2020  (4)','xlsx','Lista de ramais-versão  - Outubro 2020  (4).xlsx','2020-10-13 17:15:01',NULL,163),(79,'Lista de ramais-versão  - Outubro 2020  (3)','xlsx','Lista de ramais-versão  - Outubro 2020  (3).xlsx','2020-10-13 17:15:01',NULL,163);
/*!40000 ALTER TABLE `documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `downloads_documentos`
--

DROP TABLE IF EXISTS `downloads_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `downloads_documentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_documento` int DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `data_download` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_downloads_documentos_1_idx` (`id_documento`),
  KEY `fk_downloads_documentos_2_idx` (`id_usuario`),
  CONSTRAINT `fk_downloads_documentos_1` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id`),
  CONSTRAINT `fk_downloads_documentos_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloads_documentos`
--

LOCK TABLES `downloads_documentos` WRITE;
/*!40000 ALTER TABLE `downloads_documentos` DISABLE KEYS */;
INSERT INTO `downloads_documentos` VALUES (33,73,4,'2020-10-13 17:12:42'),(34,75,4,'2020-10-13 17:12:56'),(35,77,14,'2020-10-13 17:16:20'),(36,78,14,'2020-10-13 17:16:32'),(37,79,14,'2020-10-13 17:16:35'),(38,75,4,'2020-10-13 17:16:58'),(39,77,4,'2020-10-14 11:05:34');
/*!40000 ALTER TABLE `downloads_documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_compra`
--

DROP TABLE IF EXISTS `ordem_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordem_compra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `criado` datetime DEFAULT NULL,
  `editado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_compra`
--

LOCK TABLES `ordem_compra` WRITE;
/*!40000 ALTER TABLE `ordem_compra` DISABLE KEYS */;
INSERT INTO `ordem_compra` VALUES (162,'123123','2020-10-13 16:57:43',NULL),(163,'456','2020-10-13 17:14:07',NULL),(164,'18479','2020-10-14 10:35:49',NULL),(166,'111','2020-10-15 15:33:18',NULL);
/*!40000 ALTER TABLE `ordem_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_ordem_compra`
--

DROP TABLE IF EXISTS `usuario_ordem_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_ordem_compra` (
  `id_usuario` int NOT NULL,
  `id_ordem_compra` int NOT NULL,
  `editado` datetime DEFAULT NULL,
  `criado` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`,`id_ordem_compra`),
  KEY `fk_usuario_ordem_compra_1_idx` (`id_usuario`),
  KEY `fk_usuario_ordem_compra_2_idx` (`id_ordem_compra`),
  CONSTRAINT `fk_usuario_ordem_compra_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_usuario_ordem_compra_2` FOREIGN KEY (`id_ordem_compra`) REFERENCES `ordem_compra` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_ordem_compra`
--

LOCK TABLES `usuario_ordem_compra` WRITE;
/*!40000 ALTER TABLE `usuario_ordem_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_ordem_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1234567890',
  `criado` datetime DEFAULT NULL,
  `editado` datetime DEFAULT NULL,
  `permissao` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (4,'l.mendes@kuttner.com.br','1234','2020-06-05 14:46:36','2020-10-13 16:34:08',0),(14,'r.neves@kuttner.com.br','1234','2020-10-13 17:13:52',NULL,0),(15,'p.augusto@kuttner.com.br','1234',NULL,NULL,1);
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

-- Dump completed on 2020-11-11  7:24:50
