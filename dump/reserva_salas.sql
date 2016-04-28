/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50619
Source Host           : localhost:3306
Source Database       : reserva_salas

Target Server Type    : MYSQL
Target Server Version : 50619
File Encoding         : 65001

Date: 2016-04-28 20:37:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `reservas`
-- ----------------------------
DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) NOT NULL,
  `id_salas` int(11) NOT NULL,
  `data_entrada` datetime NOT NULL,
  `data_saida` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_reservas_salas` (`id_salas`) USING BTREE,
  KEY `idx_usuarios` (`id_usuarios`),
  CONSTRAINT `fk_reservas_salas` FOREIGN KEY (`id_salas`) REFERENCES `salas` (`id`),
  CONSTRAINT `fk_reservas_usuarios` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of reservas
-- ----------------------------
INSERT INTO `reservas` VALUES ('3', '1', '2', '2016-04-28 15:00:00', '2016-04-28 15:59:00');
INSERT INTO `reservas` VALUES ('4', '2', '1', '2016-04-28 15:00:00', '2016-04-28 15:59:00');
INSERT INTO `reservas` VALUES ('5', '2', '2', '2016-04-28 16:00:00', '2016-04-28 16:59:00');
INSERT INTO `reservas` VALUES ('8', '1', '4', '2016-04-28 17:00:00', '2016-04-28 17:59:00');
INSERT INTO `reservas` VALUES ('9', '1', '2', '2016-04-28 14:00:00', '2016-04-28 14:59:00');
INSERT INTO `reservas` VALUES ('10', '2', '5', '2016-04-28 17:00:00', '2016-04-28 17:59:00');
INSERT INTO `reservas` VALUES ('11', '3', '5', '2016-04-28 18:15:00', '2016-04-28 19:14:00');

-- ----------------------------
-- Table structure for `salas`
-- ----------------------------
DROP TABLE IF EXISTS `salas`;
CREATE TABLE `salas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(5) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salas
-- ----------------------------
INSERT INTO `salas` VALUES ('1', '201', '0');
INSERT INTO `salas` VALUES ('2', '301', '1');
INSERT INTO `salas` VALUES ('3', '401', '1');
INSERT INTO `salas` VALUES ('4', '501', '1');
INSERT INTO `salas` VALUES ('5', '601', '1');

-- ----------------------------
-- Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `login` varchar(15) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'Administrador', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '1');
INSERT INTO `usuarios` VALUES ('2', 'Luciano', 'luciano', '827ccb0eea8a706c4c34a16891f84e7b', '1');
INSERT INTO `usuarios` VALUES ('3', 'Pedro', 'pedro', '827ccb0eea8a706c4c34a16891f84e7b', '0');
