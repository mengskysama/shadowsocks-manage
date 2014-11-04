/*
Navicat MySQL Data Transfer

Date: 2014-11-04 13:27:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cookie
-- ----------------------------
DROP TABLE IF EXISTS `cookie`;
CREATE TABLE `cookie` (
  `hash` char(32) NOT NULL,
  `ip` varchar(38) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`hash`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cookie
-- ----------------------------


-- ----------------------------
-- Table structure for gift
-- ----------------------------
DROP TABLE IF EXISTS `gift`;
CREATE TABLE `gift` (
  `type` tinyint(4) NOT NULL,
  `last_gift_time` int(11) NOT NULL,
  `gift_transfer_mb` float(11,2) NOT NULL,
  `when_gift_zero` tinyint(4) NOT NULL,
  `every_gift_time` int(11) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gift
-- ----------------------------
INSERT INTO `gift` VALUES ('1', '1415077201', '2048.00', '1', '76800');
INSERT INTO `gift` VALUES ('3', '1415077201', '8888.00', '1', '76800');
INSERT INTO `gift` VALUES ('7', '1415077201', '88888.00', '1', '76800');

-- ----------------------------
-- Table structure for iplog
-- ----------------------------
DROP TABLE IF EXISTS `iplog`;
CREATE TABLE `iplog` (
  `id` int(11) NOT NULL,
  `ip` char(16) NOT NULL,
  `time` int(11) NOT NULL,
  `times` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iplog
-- ----------------------------


-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `online` int(10) NOT NULL,
  `total_transfer` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of status
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `pass` varchar(16) NOT NULL,
  `passwd` varchar(16) NOT NULL,
  `t` int(11) NOT NULL DEFAULT '0',
  `u` bigint(20) NOT NULL,
  `d` bigint(20) NOT NULL,
  `transfer_enable` bigint(20) NOT NULL,
  `port` int(11) NOT NULL,
  `switch` tinyint(4) NOT NULL DEFAULT '1',
  `enable` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `last_get_gitf_time` int(11) NOT NULL DEFAULT '0',
  `last_rest_pass_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`port`)
) ENGINE=InnoDB AUTO_INCREMENT=2009 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('7', 'test@test.com', '10010', '00058538', '1413443799', '0', '0', '93205823488', '50000', '1', '1', '7', '0', '0');