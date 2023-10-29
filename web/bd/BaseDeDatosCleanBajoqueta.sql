-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.24-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bbdd_cleanbajoqueta
CREATE DATABASE IF NOT EXISTS `bbdd_cleanbajoqueta` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `bbdd_cleanbajoqueta`;

-- Volcando estructura para tabla bbdd_cleanbajoqueta.contaminante
CREATE TABLE IF NOT EXISTS `contaminante` (
  `idContaminante` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idContaminante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.medicion
CREATE TABLE IF NOT EXISTS `medicion` (
  `idMedicion` int(11) NOT NULL AUTO_INCREMENT,
  `idContaminante` int(11) DEFAULT NULL,
  `instante` varchar(10) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `latitud` float DEFAULT 0,
  `longitud` float DEFAULT 0,
  `temperatura` float DEFAULT NULL,
  PRIMARY KEY (`idMedicion`),
  KEY `medicion_contaminante` (`idContaminante`),
  CONSTRAINT `medicion_contaminante` FOREIGN KEY (`idContaminante`) REFERENCES `contaminante` (`idContaminante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.sonda
CREATE TABLE IF NOT EXISTS `sonda` (
  `idSonda` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idSonda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.sondamedicion
CREATE TABLE IF NOT EXISTS `sondamedicion` (
  `idSonda` int(11) NOT NULL,
  `idMedicion` int(11) NOT NULL,
  PRIMARY KEY (`idSonda`,`idMedicion`) USING BTREE,
  KEY `medicion_sonda` (`idMedicion`),
  CONSTRAINT `medicion_sonda` FOREIGN KEY (`idMedicion`) REFERENCES `medicion` (`idMedicion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sonda_medicion` FOREIGN KEY (`idSonda`) REFERENCES `sonda` (`idSonda`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `nombreApellido` varchar(50) NOT NULL DEFAULT 'John Doe',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.telefono
CREATE TABLE IF NOT EXISTS `telefono` (
  `email` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  PRIMARY KEY (`email`,`telefono`),
  CONSTRAINT `usuario_telefono` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.usuariomedicion
CREATE TABLE IF NOT EXISTS `usuariomedicion` (
  `email` varchar(50) NOT NULL,
  `idMedicion` int(11) NOT NULL,
  PRIMARY KEY (`email`,`idMedicion`),
  KEY `medicion_usuario` (`idMedicion`),
  CONSTRAINT `medicion_usuario` FOREIGN KEY (`idMedicion`) REFERENCES `medicion` (`idMedicion`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuario_medicion` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bbdd_cleanbajoqueta.usuariosonda
CREATE TABLE IF NOT EXISTS `usuariosonda` (
  `email` varchar(50) NOT NULL,
  `idSonda` int(11) NOT NULL,
  PRIMARY KEY (`email`,`idSonda`),
  KEY `sonda` (`idSonda`),
  CONSTRAINT `sonda` FOREIGN KEY (`idSonda`) REFERENCES `sonda` (`idSonda`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuario` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
