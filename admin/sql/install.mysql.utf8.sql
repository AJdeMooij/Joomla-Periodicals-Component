-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'periodicals'
-- Contains references to periodicals pdf files
-- ---

DROP TABLE IF EXISTS `#__periodicals`;
    
CREATE TABLE `#__periodicals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `upload_filename` varchar(255) NOT NULL,
  `year` smallint(4) NULL,
  `month` varchar(40) NULL,
  `day` varchar(200) NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) COMMENT 'Contains references to the periodicals pdf files';
