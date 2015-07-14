-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fidelidade
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Table structure for table `tb_franquia`
--

DROP TABLE IF EXISTS `tb_franquia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_franquia` (
  `id_franquia` int(11) NOT NULL AUTO_INCREMENT,
  `id_franqueador` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `id_cardapio` int(11) NOT NULL,
  `no_franquia` varchar(100) DEFAULT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `st_ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_franquia`),
  KEY `fk_franquia_franqueador_idx` (`id_franqueador`),
  KEY `fk_franquia_endereco_idx` (`id_endereco`),
  KEY `id_cardapio` (`id_cardapio`),
  CONSTRAINT `fk_franquia_endereco` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_franquia_franqueador` FOREIGN KEY (`id_franqueador`) REFERENCES `tb_franqueador` (`id_franqueador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tb_franquia_ibfk_3` FOREIGN KEY (`id_cardapio`) REFERENCES `tb_cardapio` (`id_cardapio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_franquia_operador`
--

DROP TABLE IF EXISTS `tb_franquia_operador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_franquia_operador` (
  `id_franquia_operador` int(11) NOT NULL AUTO_INCREMENT,
  `id_franquia` int(11) NOT NULL,
  `id_operador` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_franquia_operador`),
  KEY `id_franquia` (`id_franquia`),
  KEY `id_operador` (`id_operador`),
  CONSTRAINT `tb_franquia_operador_ibfk_1` FOREIGN KEY (`id_franquia`) REFERENCES `tb_franquia` (`id_franquia`),
  CONSTRAINT `tb_franquia_operador_ibfk_2` FOREIGN KEY (`id_operador`) REFERENCES `tb_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'fidelidade'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-14 18:47:36
