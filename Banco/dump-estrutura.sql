CREATE DATABASE  IF NOT EXISTS `fidelidade` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `fidelidade`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: fidelidade
-- ------------------------------------------------------
-- Server version	5.5.39

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
-- Table structure for table `rl_usuario_perfil`
--

DROP TABLE IF EXISTS `rl_usuario_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rl_usuario_perfil` (
  `id_usuario_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_usuario_perfil`),
  KEY `fk_usuarioperfil_usuario_idx` (`id_usuario`),
  KEY `fk_usuarioperfil_perfil_idx` (`id_perfil`),
  CONSTRAINT `fk_usuarioperfil_perfil` FOREIGN KEY (`id_perfil`) REFERENCES `tb_perfil` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarioperfil_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_bairro`
--

DROP TABLE IF EXISTS `tb_bairro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_bairro` (
  `id_bairro` int(11) NOT NULL AUTO_INCREMENT,
  `id_municipio` int(11) NOT NULL,
  `no_bairro` varchar(200) NOT NULL,
  PRIMARY KEY (`id_bairro`),
  KEY `FK_BAIRRO_MUNICIPIO_idx` (`id_municipio`),
  CONSTRAINT `FK_BAIRRO_MUNICIPIO` FOREIGN KEY (`id_municipio`) REFERENCES `tb_municipio` (`id_municipio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49898 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_cardapio`
--

DROP TABLE IF EXISTS `tb_cardapio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_cardapio` (
  `id_cardapio` int(11) NOT NULL AUTO_INCREMENT,
  `no_cardapio` varchar(100) NOT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_cardapio`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_configuracao_franquia_nivel`
--

DROP TABLE IF EXISTS `tb_configuracao_franquia_nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_configuracao_franquia_nivel` (
  `id_configuracao_franquia_nivel` int(11) NOT NULL AUTO_INCREMENT,
  `id_franqueador` int(11) NOT NULL,
  `no_nivel` varchar(45) DEFAULT NULL,
  `nu_pontos_bonus_cadastro` int(11) DEFAULT NULL,
  `nu_valor_bonus_cadastro` int(11) DEFAULT NULL,
  `nu_quantidade_pontos_necessaio` int(11) DEFAULT NULL,
  `nu_porcentagem_pontos_extra` int(11) DEFAULT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_configuracao_franquia_nivel`),
  KEY `fk_configuracaofranquianivel_franqueador_idx` (`id_franqueador`),
  CONSTRAINT `fk_configuracaofranquianivel_franqueador` FOREIGN KEY (`id_franqueador`) REFERENCES `tb_franqueador` (`id_franqueador`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_email_error`
--

DROP TABLE IF EXISTS `tb_email_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_email_error` (
  `id_email_error` int(11) NOT NULL AUTO_INCREMENT,
  `no_destinatario` varchar(100) NOT NULL,
  `ds_assunto` varchar(250) NOT NULL,
  `ds_mensagem` text NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `dt_envio` datetime DEFAULT NULL,
  `st_envio` int(11) NOT NULL,
  PRIMARY KEY (`id_email_error`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_email_feedback`
--

DROP TABLE IF EXISTS `tb_email_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_email_feedback` (
  `id_email_fedback` int(11) NOT NULL AUTO_INCREMENT,
  `ds_mensagem` text NOT NULL,
  `id_franqueador` int(11) NOT NULL,
  PRIMARY KEY (`id_email_fedback`),
  KEY `id_franqueador` (`id_franqueador`),
  CONSTRAINT `tb_email_feedback_ibfk_1` FOREIGN KEY (`id_franqueador`) REFERENCES `tb_franqueador` (`id_franqueador`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_endereco`
--

DROP TABLE IF EXISTS `tb_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `id_municipio` int(11) NOT NULL,
  `id_bairro` int(11) DEFAULT NULL,
  `no_logradouro` varchar(100) NOT NULL,
  `no_complemento` varchar(100) DEFAULT NULL,
  `nu_endereco` varchar(10) DEFAULT NULL,
  `no_bairro` varchar(200) DEFAULT NULL,
  `nu_cep` int(8) DEFAULT NULL,
  `no_longitude` varchar(250) DEFAULT NULL,
  `no_latitude` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `FK_ENDERECO_MUNICPIO_idx` (`id_bairro`),
  KEY `FK_ENDERECO_MUNICIPIO_idx` (`id_municipio`),
  CONSTRAINT `FK_ENDERECO_BAIRRO` FOREIGN KEY (`id_bairro`) REFERENCES `tb_bairro` (`id_bairro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_ENDERECO_MUNICIPIO` FOREIGN KEY (`id_municipio`) REFERENCES `tb_municipio` (`id_municipio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_enquete`
--

DROP TABLE IF EXISTS `tb_enquete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_enquete` (
  `id_enquete` int(11) NOT NULL AUTO_INCREMENT,
  `no_enquete` varchar(45) NOT NULL,
  `dt_inicio` datetime NOT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_fim` datetime NOT NULL,
  `no_pergunta` text NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `nu_pontos` varchar(250) DEFAULT NULL,
  `nu_bonus` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_enquete`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_enquete_resposta`
--

DROP TABLE IF EXISTS `tb_enquete_resposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_enquete_resposta` (
  `id_resposta` int(11) NOT NULL AUTO_INCREMENT,
  `id_enquete` int(11) DEFAULT NULL,
  `no_resposta` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_resposta`),
  KEY `id_enquete` (`id_enquete`),
  CONSTRAINT `FK_7A6E5402845C259` FOREIGN KEY (`id_enquete`) REFERENCES `tb_enquete` (`id_enquete`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_estado`
--

DROP TABLE IF EXISTS `tb_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_estado` (
  `id_estado` int(2) NOT NULL AUTO_INCREMENT,
  `sg_uf` varchar(10) NOT NULL,
  `no_estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_feedback`
--

DROP TABLE IF EXISTS `tb_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `id_franqueador` int(11) NOT NULL,
  `no_feedback` varchar(45) DEFAULT NULL,
  `dt_inicio` datetime DEFAULT NULL,
  `ds_feedback` text,
  `dt_cadastro` datetime DEFAULT NULL,
  `st_ativo` int(11) NOT NULL,
  PRIMARY KEY (`id_feedback`),
  KEY `fk_feedback_franqueador_idx` (`id_franqueador`),
  CONSTRAINT `fk_feedback_franqueador` FOREIGN KEY (`id_franqueador`) REFERENCES `tb_franqueador` (`id_franqueador`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_franqueador`
--

DROP TABLE IF EXISTS `tb_franqueador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_franqueador` (
  `id_franqueador` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_operador` int(11) DEFAULT NULL,
  `id_endereco` int(11) NOT NULL,
  `nu_cnpj` varchar(14) NOT NULL,
  `no_razao_social` varchar(100) NOT NULL,
  `no_fantasia` varchar(100) NOT NULL,
  `st_niveis` int(11) NOT NULL,
  `nu_valor_minimo_resgate` int(11) NOT NULL,
  `nu_pontos_transacao` int(11) NOT NULL,
  `nu_porcentagem_bonus_transacao` int(11) NOT NULL,
  `dt_validade_bonus` datetime NOT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_franqueador`),
  KEY `fk_franqueador_usuario_idx` (`id_usuario`),
  KEY `fk_franqueador_endereco_idx` (`id_endereco`),
  KEY `fk_franqueador_operador_idx` (`id_operador`),
  CONSTRAINT `fk_franqueador_operador` FOREIGN KEY (`id_operador`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_franqueador_endereco` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_franqueador_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_franquia`
--

DROP TABLE IF EXISTS `tb_franquia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_franquia` (
  `id_franquia` int(11) NOT NULL AUTO_INCREMENT,
  `id_franqueador` int(11) NOT NULL,
  `id_operador` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `id_cardapio` int(11) NOT NULL,
  `no_responsavel` varchar(150) NOT NULL,
  `no_email_responsavel` varchar(150) NOT NULL,
  `no_franquia` varchar(100) DEFAULT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `st_ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_franquia`),
  KEY `fk_franquia_franqueador_idx` (`id_franqueador`),
  KEY `fk_franquia_endereco_idx` (`id_endereco`),
  KEY `id_operador` (`id_operador`),
  KEY `id_cardapio` (`id_cardapio`),
  CONSTRAINT `fk_franquia_endereco` FOREIGN KEY (`id_endereco`) REFERENCES `tb_endereco` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_franquia_franqueador` FOREIGN KEY (`id_franqueador`) REFERENCES `tb_franqueador` (`id_franqueador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tb_franquia_ibfk_2` FOREIGN KEY (`id_operador`) REFERENCES `tb_usuario` (`id_usuario`),
  CONSTRAINT `tb_franquia_ibfk_3` FOREIGN KEY (`id_cardapio`) REFERENCES `tb_cardapio` (`id_cardapio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_franquia_promocao`
--

DROP TABLE IF EXISTS `tb_franquia_promocao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_franquia_promocao` (
  `id_franquia_promocao` int(11) NOT NULL AUTO_INCREMENT,
  `id_franquia` int(11) NOT NULL,
  `id_promocao` int(11) NOT NULL,
  PRIMARY KEY (`id_franquia_promocao`),
  KEY `id_franquia` (`id_franquia`),
  KEY `id_promocao` (`id_promocao`),
  CONSTRAINT `tb_franquia_promocao_ibfk_1` FOREIGN KEY (`id_franquia`) REFERENCES `tb_franquia` (`id_franquia`),
  CONSTRAINT `tb_franquia_promocao_ibfk_2` FOREIGN KEY (`id_promocao`) REFERENCES `tb_promocao` (`id_promocao`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_logradouro`
--

DROP TABLE IF EXISTS `tb_logradouro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_logradouro` (
  `id_logradouro` int(11) NOT NULL AUTO_INCREMENT,
  `id_bairro` int(11) NOT NULL,
  `id_tipo_logradouro` int(11) DEFAULT NULL,
  `no_logradouro` varchar(200) DEFAULT NULL,
  `nu_cep` int(8) NOT NULL,
  PRIMARY KEY (`id_logradouro`),
  KEY `FK_LOGRADOURO_BAIRRO_idx` (`id_bairro`),
  CONSTRAINT `FK_LOGRADOURO_BAIRRO` FOREIGN KEY (`id_bairro`) REFERENCES `tb_bairro` (`id_bairro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=735230 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_municipio`
--

DROP TABLE IF EXISTS `tb_municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_municipio` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `no_municipio` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `FK_MUNICIPIO_ESTADO_idx` (`id_estado`),
  CONSTRAINT `FK_MUNICIPIO_ESTADO` FOREIGN KEY (`id_estado`) REFERENCES `tb_estado` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_newsletter`
--

DROP TABLE IF EXISTS `tb_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_newsletter` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `no_nome` varchar(100) NOT NULL,
  `no_email` varchar(100) NOT NULL,
  `nu_telefone` int(11) DEFAULT NULL,
  `ds_como_conheceu` varchar(100) DEFAULT NULL,
  `ds_mensagem` text,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_perfil`
--

DROP TABLE IF EXISTS `tb_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `no_perfil` varchar(100) NOT NULL,
  `sg_perfil` varchar(45) NOT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `dt_atualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_pessoa`
--

DROP TABLE IF EXISTS `tb_pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pessoa` (
  `id_pessoa` int(11) NOT NULL AUTO_INCREMENT,
  `no_pessoa` varchar(100) NOT NULL,
  `no_imagem` varchar(100) DEFAULT NULL,
  `dt_cadastro` datetime NOT NULL,
  `dt_atualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_pessoa_fisica`
--

DROP TABLE IF EXISTS `tb_pessoa_fisica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pessoa_fisica` (
  `id_pessoa` int(11) NOT NULL,
  `nu_cpf` varchar(11) DEFAULT NULL,
  `no_email` varchar(100) DEFAULT NULL,
  `dt_nascimento` datetime DEFAULT NULL,
  `sg_sexo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_pessoa`),
  KEY `FK_PESSOAFISICA_PESSOA_idx` (`id_pessoa`),
  CONSTRAINT `FK_PESSOAFISICA_PESSOA` FOREIGN KEY (`id_pessoa`) REFERENCES `tb_pessoa` (`id_pessoa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_pessoa_juridica`
--

DROP TABLE IF EXISTS `tb_pessoa_juridica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pessoa_juridica` (
  `id_pessoa` int(11) NOT NULL,
  `nu_cnpj` varchar(14) NOT NULL,
  `no_fantasia` varchar(100) DEFAULT NULL,
  `no_razao_social` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_pessoa`),
  KEY `FK_PESSOAJURIDICA_PESSOA_idx` (`id_pessoa`),
  CONSTRAINT `FK_PESSOAJURIDICA_PESSOA` FOREIGN KEY (`id_pessoa`) REFERENCES `tb_pessoa` (`id_pessoa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_produto`
--

DROP TABLE IF EXISTS `tb_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `id_cardapio` int(11) DEFAULT NULL,
  `no_produto` varchar(100) NOT NULL,
  `nu_valor` decimal(10,0) NOT NULL,
  `no_imagem` varchar(100) NOT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_cardapio` (`id_cardapio`),
  CONSTRAINT `tb_produto_ibfk_1` FOREIGN KEY (`id_cardapio`) REFERENCES `tb_cardapio` (`id_cardapio`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_promocao`
--

DROP TABLE IF EXISTS `tb_promocao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_promocao` (
  `id_promocao` int(11) NOT NULL AUTO_INCREMENT,
  `no_promocao` varchar(100) NOT NULL,
  `ds_promocao` text NOT NULL,
  `dt_validade` datetime NOT NULL,
  `no_imagem` varchar(100) DEFAULT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id_promocao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_questao_enquete`
--

DROP TABLE IF EXISTS `tb_questao_enquete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_questao_enquete` (
  `id_questao_enquete` int(11) NOT NULL AUTO_INCREMENT,
  `no_questao_enquete` text NOT NULL,
  `qt_votos` varchar(45) NOT NULL,
  PRIMARY KEY (`id_questao_enquete`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) DEFAULT NULL,
  `no_senha` varchar(32) NOT NULL,
  `st_ativo` int(11) NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `dt_atualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `UNIQ_5DB26AFF3AE81E6F` (`id_pessoa`),
  KEY `FK_USUARIO_PESSAO_idx` (`id_pessoa`),
  CONSTRAINT `FK_USUARIO_PESSAO` FOREIGN KEY (`id_pessoa`) REFERENCES `tb_pessoa` (`id_pessoa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-12 22:01:53
