/*
Navicat MySQL Data Transfer

Source Server         : Local MariaDB
Source Server Version : 50531
Source Host           : localhost:3306
Source Database       : dev-spirit

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2015-10-27 23:53:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `career_levels`
-- ----------------------------
DROP TABLE IF EXISTS `career_levels`;
CREATE TABLE `career_levels` (
  `career_level_id` varchar(16) NOT NULL,
  `order_by` int(11) NOT NULL,
  PRIMARY KEY (`career_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of career_levels
-- ----------------------------
INSERT INTO `career_levels` VALUES ('ASST-MANAGER', '5');
INSERT INTO `career_levels` VALUES ('DIREKTUR', '8');
INSERT INTO `career_levels` VALUES ('GENERAL-MANAGER', '7');
INSERT INTO `career_levels` VALUES ('MANAGER', '6');
INSERT INTO `career_levels` VALUES ('STAFF', '3');
INSERT INTO `career_levels` VALUES ('SUPERVISOR', '4');
INSERT INTO `career_levels` VALUES ('TRAINEE', '2');
INSERT INTO `career_levels` VALUES ('VOLUNTEER', '1');

-- ----------------------------
-- Table structure for `functionals`
-- ----------------------------
DROP TABLE IF EXISTS `functionals`;
CREATE TABLE `functionals` (
  `functional_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `functional_title` varchar(128) NOT NULL,
  `functional_url` varchar(128) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`functional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of functionals
-- ----------------------------

-- ----------------------------
-- Table structure for `industries`
-- ----------------------------
DROP TABLE IF EXISTS `industries`;
CREATE TABLE `industries` (
  `industry_id` int(11) NOT NULL AUTO_INCREMENT,
  `industry_name` varchar(128) NOT NULL,
  PRIMARY KEY (`industry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of industries
-- ----------------------------
INSERT INTO `industries` VALUES ('1', 'Accounts / Audit');
INSERT INTO `industries` VALUES ('2', 'Advertising / Publishing');
INSERT INTO `industries` VALUES ('3', 'Aerospace');
INSERT INTO `industries` VALUES ('4', 'Agribusiness');
INSERT INTO `industries` VALUES ('5', 'Airlines');
INSERT INTO `industries` VALUES ('6', 'Automotive');
INSERT INTO `industries` VALUES ('7', 'Candy / Confectionary');
INSERT INTO `industries` VALUES ('8', 'Chemical');
INSERT INTO `industries` VALUES ('9', 'Computer / IT');
INSERT INTO `industries` VALUES ('10', 'Conglomerate');
INSERT INTO `industries` VALUES ('11', 'Construction');
INSERT INTO `industries` VALUES ('12', 'Consumer Goods');
INSERT INTO `industries` VALUES ('13', 'Cosmetics');
INSERT INTO `industries` VALUES ('14', 'Courier');
INSERT INTO `industries` VALUES ('15', 'Custom Broker / Forwarder');
INSERT INTO `industries` VALUES ('16', 'Education');
INSERT INTO `industries` VALUES ('17', 'Electronics / Semiconductors');
INSERT INTO `industries` VALUES ('18', 'Energy');
INSERT INTO `industries` VALUES ('19', 'Engineering & Construction');
INSERT INTO `industries` VALUES ('20', 'Entertainment');
INSERT INTO `industries` VALUES ('21', 'Environment / Waste Management');
INSERT INTO `industries` VALUES ('22', 'Financials / Banking');
INSERT INTO `industries` VALUES ('23', 'Fishery');
INSERT INTO `industries` VALUES ('24', 'Food & Beverage');
INSERT INTO `industries` VALUES ('25', 'Food Processing');
INSERT INTO `industries` VALUES ('26', 'Forestry / Timber');
INSERT INTO `industries` VALUES ('27', 'Furniture');
INSERT INTO `industries` VALUES ('28', 'Garment / Textile');
INSERT INTO `industries` VALUES ('29', 'Goverment Related');
INSERT INTO `industries` VALUES ('30', 'Health Care');
INSERT INTO `industries` VALUES ('31', 'Hospitality');
INSERT INTO `industries` VALUES ('32', 'Insurance');
INSERT INTO `industries` VALUES ('33', 'Interior Design');
INSERT INTO `industries` VALUES ('34', 'Internet');
INSERT INTO `industries` VALUES ('35', 'Law');
INSERT INTO `industries` VALUES ('36', 'Leather');
INSERT INTO `industries` VALUES ('37', 'Leisure');
INSERT INTO `industries` VALUES ('38', 'Logistics / Transportation');
INSERT INTO `industries` VALUES ('39', 'Machinery / Equipment');
INSERT INTO `industries` VALUES ('40', 'Manufacturing');
INSERT INTO `industries` VALUES ('41', 'Mechanical / Electrical');
INSERT INTO `industries` VALUES ('42', 'Media');
INSERT INTO `industries` VALUES ('43', 'Metal');
INSERT INTO `industries` VALUES ('44', 'Mining / Minerals');
INSERT INTO `industries` VALUES ('45', 'Natural Resources, Others');
INSERT INTO `industries` VALUES ('46', 'Natural Resources Processing');
INSERT INTO `industries` VALUES ('47', 'Non-profit Sector');
INSERT INTO `industries` VALUES ('48', 'Oil and Gas');
INSERT INTO `industries` VALUES ('49', 'Pharmaceuticals');
INSERT INTO `industries` VALUES ('50', 'Polymer / Plastic / Rubber');
INSERT INTO `industries` VALUES ('51', 'Printing and Packaging');
INSERT INTO `industries` VALUES ('52', 'Property / Real Estate');
INSERT INTO `industries` VALUES ('53', 'Pulp / Paper');
INSERT INTO `industries` VALUES ('54', 'Removals');
INSERT INTO `industries` VALUES ('55', 'Restaurant');
INSERT INTO `industries` VALUES ('56', 'Retail');
INSERT INTO `industries` VALUES ('57', 'Security Services');
INSERT INTO `industries` VALUES ('58', 'Service');
INSERT INTO `industries` VALUES ('59', 'Shipping');
INSERT INTO `industries` VALUES ('60', 'Telecommunications');
INSERT INTO `industries` VALUES ('61', 'Toys');
INSERT INTO `industries` VALUES ('62', 'Trading');
INSERT INTO `industries` VALUES ('63', 'Travel & Tour');
INSERT INTO `industries` VALUES ('64', 'Warehousing');
INSERT INTO `industries` VALUES ('65', 'General & Wholesale Trading');

-- ----------------------------
-- Table structure for `jobs`
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `job_id` varchar(16) NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jobs
-- ----------------------------
INSERT INTO `jobs` VALUES ('FREELANCER');
INSERT INTO `jobs` VALUES ('KARYAWAN');
INSERT INTO `jobs` VALUES ('MAHASISWA');
INSERT INTO `jobs` VALUES ('OWNER');
INSERT INTO `jobs` VALUES ('PELAJAR');

-- ----------------------------
-- Table structure for `members_portfolios`
-- ----------------------------
DROP TABLE IF EXISTS `members_portfolios`;
CREATE TABLE `members_portfolios` (
  `member_portfolio_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(64) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `start_date_y` char(4) NOT NULL,
  `start_date_m` char(2) DEFAULT NULL,
  `start_date_d` char(2) DEFAULT NULL,
  `end_date_y` char(4) DEFAULT NULL,
  `end_date_m` char(2) DEFAULT NULL,
  `end_date_d` char(2) DEFAULT NULL,
  `work_status` char(1) NOT NULL COMMENT 'A => Active, R = Resign',
  `job_title` varchar(64) NOT NULL,
  `job_desc` varchar(256) DEFAULT NULL,
  `career_level_id` varchar(16) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`member_portfolio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of members_portfolios
-- ----------------------------

-- ----------------------------
-- Table structure for `members_profiles`
-- ----------------------------
DROP TABLE IF EXISTS `members_profiles`;
CREATE TABLE `members_profiles` (
  `member_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(64) NOT NULL,
  `contact_phone` varchar(32) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `birth_place` varchar(32) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `identity_number` varchar(32) DEFAULT NULL,
  `identity_type` varchar(8) DEFAULT NULL,
  `religion_id` int(11) DEFAULT NULL,
  `gender` varchar(6) NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `job_id` varchar(16) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`member_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of members_profiles
-- ----------------------------

-- ----------------------------
-- Table structure for `members_socmeds`
-- ----------------------------
DROP TABLE IF EXISTS `members_socmeds`;
CREATE TABLE `members_socmeds` (
  `member_socmed_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `socmed_type` varchar(16) NOT NULL,
  `account_name` varchar(64) DEFAULT NULL,
  `account_url` varchar(128) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`member_socmed_id`),
  UNIQUE KEY `uid_socmedtype_unique` (`user_id`,`socmed_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of members_socmeds
-- ----------------------------

-- ----------------------------
-- Table structure for `regionals`
-- ----------------------------
DROP TABLE IF EXISTS `regionals`;
CREATE TABLE `regionals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regional_name` varchar(64) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `province_code` varchar(4) NOT NULL,
  `city_code` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=499 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of regionals
-- ----------------------------
INSERT INTO `regionals` VALUES ('1', 'NANGGROE ACEH DARUSSALAM', null, '11', '00');
INSERT INTO `regionals` VALUES ('2', 'KAB. ACEH SELATAN', '1', '11', '01');
INSERT INTO `regionals` VALUES ('3', 'KAB. ACEH TENGGARA', '1', '11', '02');
INSERT INTO `regionals` VALUES ('4', 'KAB. ACEH TIMUR', '1', '11', '03');
INSERT INTO `regionals` VALUES ('5', 'KAB. ACEH TENGAH', '1', '11', '04');
INSERT INTO `regionals` VALUES ('6', 'KAB. ACEH BARAT', '1', '11', '05');
INSERT INTO `regionals` VALUES ('7', 'KAB. ACEH BESAR', '1', '11', '06');
INSERT INTO `regionals` VALUES ('8', 'KAB. PIDIE', '1', '11', '07');
INSERT INTO `regionals` VALUES ('9', 'KAB. ACEH UTARA', '1', '11', '08');
INSERT INTO `regionals` VALUES ('10', 'KAB. SIMEULUE', '1', '11', '09');
INSERT INTO `regionals` VALUES ('11', 'KAB. ACEH SINGKIL', '1', '11', '10');
INSERT INTO `regionals` VALUES ('12', 'KAB. BIREUEN', '1', '11', '11');
INSERT INTO `regionals` VALUES ('13', 'KAB. ACEH BARAT DAYA', '1', '11', '12');
INSERT INTO `regionals` VALUES ('14', 'KAB. GAYO LUES', '1', '11', '13');
INSERT INTO `regionals` VALUES ('15', 'KAB. ACEH JAYA', '1', '11', '14');
INSERT INTO `regionals` VALUES ('16', 'KAB. NAGAN RAYA', '1', '11', '15');
INSERT INTO `regionals` VALUES ('17', 'KAB. ACEH TAMIANG', '1', '11', '16');
INSERT INTO `regionals` VALUES ('18', 'KAB. BENER MERIAH', '1', '11', '17');
INSERT INTO `regionals` VALUES ('19', 'KAB. PIDIE JAYA', '1', '11', '18');
INSERT INTO `regionals` VALUES ('20', 'KOTA BANDA ACEH', '1', '11', '19');
INSERT INTO `regionals` VALUES ('21', 'KOTA SABANG', '1', '11', '20');
INSERT INTO `regionals` VALUES ('22', 'KOTA LHOKSEUMAWE', '1', '11', '21');
INSERT INTO `regionals` VALUES ('23', 'KOTA LANGSA', '1', '11', '22');
INSERT INTO `regionals` VALUES ('24', 'KOTA SUBULUSSALAM', '1', '11', '23');
INSERT INTO `regionals` VALUES ('25', 'SUMATERA UTARA', null, '12', '00');
INSERT INTO `regionals` VALUES ('26', 'KAB. TAPANULI TENGAH', '25', '12', '01');
INSERT INTO `regionals` VALUES ('27', 'KAB. TAPANULI UTARA', '25', '12', '02');
INSERT INTO `regionals` VALUES ('28', 'KAB. TAPANULI SELATAN', '25', '12', '03');
INSERT INTO `regionals` VALUES ('29', 'KAB. NIAS', '25', '12', '04');
INSERT INTO `regionals` VALUES ('30', 'KAB. LANGKAT', '25', '12', '05');
INSERT INTO `regionals` VALUES ('31', 'KAB. KARO', '25', '12', '06');
INSERT INTO `regionals` VALUES ('32', 'KAB. DELI SERDANG', '25', '12', '07');
INSERT INTO `regionals` VALUES ('33', 'KAB. SIMALUNGUN', '25', '12', '08');
INSERT INTO `regionals` VALUES ('34', 'KAB. ASAHAN', '25', '12', '09');
INSERT INTO `regionals` VALUES ('35', 'KAB. LABUHAN BATU', '25', '12', '10');
INSERT INTO `regionals` VALUES ('36', 'KAB. DAIRI', '25', '12', '11');
INSERT INTO `regionals` VALUES ('37', 'KAB. TOBA SAMOSIR', '25', '12', '12');
INSERT INTO `regionals` VALUES ('38', 'KAB. MANDAILING NATAL', '25', '12', '13');
INSERT INTO `regionals` VALUES ('39', 'KAB. NIAS SELATAN', '25', '12', '14');
INSERT INTO `regionals` VALUES ('40', 'KAB. PAKPAK BHARAT', '25', '12', '15');
INSERT INTO `regionals` VALUES ('41', 'KAB HUMBANG HASUNDUTAN', '25', '12', '16');
INSERT INTO `regionals` VALUES ('42', 'KAB. SAMOSIR', '25', '12', '17');
INSERT INTO `regionals` VALUES ('43', 'KAB. SERDANG BEDAGAI', '25', '12', '18');
INSERT INTO `regionals` VALUES ('44', 'KAB. BATU BARA', '25', '12', '19');
INSERT INTO `regionals` VALUES ('45', 'KAB. PADANG LAWAS UTARA', '25', '12', '20');
INSERT INTO `regionals` VALUES ('46', 'KAB. PADANG LAWAS', '25', '12', '21');
INSERT INTO `regionals` VALUES ('47', 'KOTA MEDAN', '25', '12', '22');
INSERT INTO `regionals` VALUES ('48', 'KOTA PEMATANG SIANTAR', '25', '12', '23');
INSERT INTO `regionals` VALUES ('49', 'KOTA SIBOLGA', '25', '12', '24');
INSERT INTO `regionals` VALUES ('50', 'KOTA TANJUNG BALAI', '25', '12', '25');
INSERT INTO `regionals` VALUES ('51', 'KOTA BINJAI', '25', '12', '26');
INSERT INTO `regionals` VALUES ('52', 'KOTA TEBING TINGGI', '25', '12', '27');
INSERT INTO `regionals` VALUES ('53', 'KOTA PADANG SIDEMPUAN', '25', '12', '28');
INSERT INTO `regionals` VALUES ('54', 'SUMATERA BARAT', null, '13', '00');
INSERT INTO `regionals` VALUES ('55', 'KAB. PESISIR SELATAN', '54', '13', '01');
INSERT INTO `regionals` VALUES ('56', 'KAB. SOLOK', '54', '13', '02');
INSERT INTO `regionals` VALUES ('57', 'KAB. SW.LUNTO\'SIJUNJUNG', '54', '13', '03');
INSERT INTO `regionals` VALUES ('58', 'KAB. TANAH DATAR', '54', '13', '04');
INSERT INTO `regionals` VALUES ('59', 'KAB. PADANG PARIAMAN', '54', '13', '05');
INSERT INTO `regionals` VALUES ('60', 'KAB. AGAM', '54', '13', '06');
INSERT INTO `regionals` VALUES ('61', 'KAB. LIMA PULUH. KOTA', '54', '13', '07');
INSERT INTO `regionals` VALUES ('62', 'KAB. PASAMAN', '54', '13', '08');
INSERT INTO `regionals` VALUES ('63', 'KAB. KEPULAUAN MENTAWAI', '54', '13', '09');
INSERT INTO `regionals` VALUES ('64', 'KAB. DHARMASRAYA', '54', '13', '10');
INSERT INTO `regionals` VALUES ('65', 'KAB. SOLOK SELATAN', '54', '13', '11');
INSERT INTO `regionals` VALUES ('66', 'KAB. PASAMAN BARAT', '54', '13', '12');
INSERT INTO `regionals` VALUES ('67', 'KOTA PADANG', '54', '13', '13');
INSERT INTO `regionals` VALUES ('68', 'KOTA SOLOK', '54', '13', '14');
INSERT INTO `regionals` VALUES ('69', 'KOTA SAWAHLUNTO', '54', '13', '15');
INSERT INTO `regionals` VALUES ('70', 'KOTA PADANG PANJANG', '54', '13', '16');
INSERT INTO `regionals` VALUES ('71', 'KOTA BUKITTINGGI', '54', '13', '17');
INSERT INTO `regionals` VALUES ('72', 'KOTA PAYAKUMBUH', '54', '13', '18');
INSERT INTO `regionals` VALUES ('73', 'KOTA PARIAMAN', '54', '13', '19');
INSERT INTO `regionals` VALUES ('74', 'RIAU', null, '14', '00');
INSERT INTO `regionals` VALUES ('75', 'KAB. KAMPAR', '74', '14', '01');
INSERT INTO `regionals` VALUES ('76', 'KAB. INDRAGIRI HULU', '74', '14', '02');
INSERT INTO `regionals` VALUES ('77', 'KAB. BENGKALIS', '74', '14', '03');
INSERT INTO `regionals` VALUES ('78', 'KAB. INDRAGIRI HILIR', '74', '14', '04');
INSERT INTO `regionals` VALUES ('79', 'KAB. PELALAWAN', '74', '14', '05');
INSERT INTO `regionals` VALUES ('80', 'KAB. ROKAN HULU', '74', '14', '06');
INSERT INTO `regionals` VALUES ('81', 'KAB. ROKAN HILIR', '74', '14', '07');
INSERT INTO `regionals` VALUES ('82', 'KAB. SIAK', '74', '14', '08');
INSERT INTO `regionals` VALUES ('83', 'KAB. KUANTAN SINGINGI', '74', '14', '09');
INSERT INTO `regionals` VALUES ('84', 'KOTA PEKANBARU', '74', '14', '10');
INSERT INTO `regionals` VALUES ('85', 'KOTA DUMAI', '74', '14', '11');
INSERT INTO `regionals` VALUES ('86', 'JAMBI', null, '15', '00');
INSERT INTO `regionals` VALUES ('87', 'KAB. KERINCI', '86', '15', '01');
INSERT INTO `regionals` VALUES ('88', 'KAB. MERANGIN', '86', '15', '02');
INSERT INTO `regionals` VALUES ('89', 'KAB. SAROLANGUN', '86', '15', '03');
INSERT INTO `regionals` VALUES ('90', 'KAB. BATANGHARI', '86', '15', '04');
INSERT INTO `regionals` VALUES ('91', 'KAB. MUARO JAMBI', '86', '15', '05');
INSERT INTO `regionals` VALUES ('92', 'KAB TANJUNG JABUNG BARAT', '86', '15', '06');
INSERT INTO `regionals` VALUES ('93', 'KAB TANJUNG JABUNG TIMUR', '86', '15', '07');
INSERT INTO `regionals` VALUES ('94', 'KAB. BUNGO', '86', '15', '08');
INSERT INTO `regionals` VALUES ('95', 'KAB. TEBO', '86', '15', '09');
INSERT INTO `regionals` VALUES ('96', 'KOTA JAMBI', '86', '15', '10');
INSERT INTO `regionals` VALUES ('97', 'SUMATERA SELATAN', null, '16', '00');
INSERT INTO `regionals` VALUES ('98', 'KAB. OGAN KOMERING ULU', '97', '16', '01');
INSERT INTO `regionals` VALUES ('99', 'KAB. OGAN KOMERING ILIR', '97', '16', '02');
INSERT INTO `regionals` VALUES ('100', 'KAB. MUARA ENIM', '97', '16', '03');
INSERT INTO `regionals` VALUES ('101', 'KAB. LAHAT', '97', '16', '04');
INSERT INTO `regionals` VALUES ('102', 'KAB. MUSI RAWAS', '97', '16', '05');
INSERT INTO `regionals` VALUES ('103', 'KAB. MUSI BANYUASIN', '97', '16', '06');
INSERT INTO `regionals` VALUES ('104', 'KAB. BANYUASIN', '97', '16', '07');
INSERT INTO `regionals` VALUES ('105', 'KAB. OKU TIMUR', '97', '16', '08');
INSERT INTO `regionals` VALUES ('106', 'KAB. OKU SELATAN', '97', '16', '09');
INSERT INTO `regionals` VALUES ('107', 'KAB. OGAN ILIR', '97', '16', '10');
INSERT INTO `regionals` VALUES ('108', 'KAB. EMPAT LAWANG', '97', '16', '11');
INSERT INTO `regionals` VALUES ('109', 'KOTA PALEMBANG', '97', '16', '12');
INSERT INTO `regionals` VALUES ('110', 'KOTA PAGAR ALAM', '97', '16', '13');
INSERT INTO `regionals` VALUES ('111', 'KOTA LUBUK LINGGAU', '97', '16', '14');
INSERT INTO `regionals` VALUES ('112', 'KOTA PRABUMULIH', '97', '16', '15');
INSERT INTO `regionals` VALUES ('113', 'BENGKULU', null, '17', '00');
INSERT INTO `regionals` VALUES ('114', 'KAB. BENGKULU SELATAN', '113', '17', '01');
INSERT INTO `regionals` VALUES ('115', 'KAB. REJANG LEBONG', '113', '17', '02');
INSERT INTO `regionals` VALUES ('116', 'KAB. BENGKULU UTARA', '113', '17', '03');
INSERT INTO `regionals` VALUES ('117', 'KAB. KAUR', '113', '17', '04');
INSERT INTO `regionals` VALUES ('118', 'KAB. SELUMA', '113', '17', '05');
INSERT INTO `regionals` VALUES ('119', 'KAB. MUKO MUKO', '113', '17', '06');
INSERT INTO `regionals` VALUES ('120', 'KAB. LEBONG', '113', '17', '07');
INSERT INTO `regionals` VALUES ('121', 'KAB. KEPAHIANG', '113', '17', '08');
INSERT INTO `regionals` VALUES ('122', 'KOTA BENGKULU', '113', '17', '09');
INSERT INTO `regionals` VALUES ('123', 'LAMPUNG', null, '18', '00');
INSERT INTO `regionals` VALUES ('124', 'KAB. LAMPUNG SELATAN', '123', '18', '01');
INSERT INTO `regionals` VALUES ('125', 'KAB. LAMPUNG TENGAH', '123', '18', '02');
INSERT INTO `regionals` VALUES ('126', 'KAB. LAMPUNG UTARA', '123', '18', '03');
INSERT INTO `regionals` VALUES ('127', 'KAB. LAMPUNG BARAT', '123', '18', '04');
INSERT INTO `regionals` VALUES ('128', 'KAB. TULANG BAWANG', '123', '18', '05');
INSERT INTO `regionals` VALUES ('129', 'KAB. TANGGAMUS', '123', '18', '06');
INSERT INTO `regionals` VALUES ('130', 'KAB. LAMPUNG TIMUR', '123', '18', '07');
INSERT INTO `regionals` VALUES ('131', 'KAB. WAY KANAN', '123', '18', '08');
INSERT INTO `regionals` VALUES ('132', 'KAB. PESAWARAN', '123', '18', '09');
INSERT INTO `regionals` VALUES ('133', 'KOTA BANDAR LAMPUNG', '123', '18', '10');
INSERT INTO `regionals` VALUES ('134', 'KOTA METRO', '123', '18', '11');
INSERT INTO `regionals` VALUES ('135', 'KEP. BANGKA BELITUNG', null, '19', '00');
INSERT INTO `regionals` VALUES ('136', 'KAB. BANGKA', '135', '19', '01');
INSERT INTO `regionals` VALUES ('137', 'KAB. BELITUNG', '135', '19', '02');
INSERT INTO `regionals` VALUES ('138', 'KAB. BANGKA SELATAN', '135', '19', '03');
INSERT INTO `regionals` VALUES ('139', 'KAB. BANGKA TENGAH', '135', '19', '04');
INSERT INTO `regionals` VALUES ('140', 'KAB. BANGKA BARAT', '135', '19', '05');
INSERT INTO `regionals` VALUES ('141', 'KAB. BELITUNG TIMUR', '135', '19', '06');
INSERT INTO `regionals` VALUES ('142', 'KOTA PANGKAL PINANG', '135', '19', '07');
INSERT INTO `regionals` VALUES ('143', 'KEP. RIAU', null, '21', '00');
INSERT INTO `regionals` VALUES ('144', 'KAB. BINTAN', '143', '21', '01');
INSERT INTO `regionals` VALUES ('145', 'KAB. KARIMUN', '143', '21', '02');
INSERT INTO `regionals` VALUES ('146', 'KAB. NATUNA', '143', '21', '03');
INSERT INTO `regionals` VALUES ('147', 'KAB. LINGGA', '143', '21', '04');
INSERT INTO `regionals` VALUES ('148', 'KOTA BATAM', '143', '21', '05');
INSERT INTO `regionals` VALUES ('149', 'KOTA TANJUNG PINANG', '143', '21', '06');
INSERT INTO `regionals` VALUES ('150', 'DKI JAKARTA', null, '31', '00');
INSERT INTO `regionals` VALUES ('151', 'KAB. ADM. KEP. SERIBU', '150', '31', '01');
INSERT INTO `regionals` VALUES ('152', 'KODYA JAKARTA PUSAT', '150', '31', '02');
INSERT INTO `regionals` VALUES ('153', 'KODYA JAKARTA UTARA', '150', '31', '03');
INSERT INTO `regionals` VALUES ('154', 'KODYA JAKARTA BARAT', '150', '31', '04');
INSERT INTO `regionals` VALUES ('155', 'KODYA JAKARTA SELATAN', '150', '31', '05');
INSERT INTO `regionals` VALUES ('156', 'KODYA JAKARTA TIMUR', '150', '31', '06');
INSERT INTO `regionals` VALUES ('157', 'JAWA BARAT', null, '32', '00');
INSERT INTO `regionals` VALUES ('158', 'KAB. BOGOR', '157', '32', '01');
INSERT INTO `regionals` VALUES ('159', 'KAB. SUKABUMI', '157', '32', '02');
INSERT INTO `regionals` VALUES ('160', 'KAB. CIANJUR', '157', '32', '03');
INSERT INTO `regionals` VALUES ('161', 'KAB. BANDUNG', '157', '32', '04');
INSERT INTO `regionals` VALUES ('162', 'KAB. GARUT', '157', '32', '05');
INSERT INTO `regionals` VALUES ('163', 'KAB. TASIKMALAYA', '157', '32', '06');
INSERT INTO `regionals` VALUES ('164', 'KAB. CIAMIS', '157', '32', '07');
INSERT INTO `regionals` VALUES ('165', 'KAB. KUNINGAN', '157', '32', '08');
INSERT INTO `regionals` VALUES ('166', 'KAB. CIREBON', '157', '32', '09');
INSERT INTO `regionals` VALUES ('167', 'KAB. MAJALENGKA', '157', '32', '10');
INSERT INTO `regionals` VALUES ('168', 'KAB. SUMEDANG', '157', '32', '11');
INSERT INTO `regionals` VALUES ('169', 'KAB. INDRAMAYU', '157', '32', '12');
INSERT INTO `regionals` VALUES ('170', 'KAB. SUBANG', '157', '32', '13');
INSERT INTO `regionals` VALUES ('171', 'KAB. PURWAKARTA', '157', '32', '14');
INSERT INTO `regionals` VALUES ('172', 'KAB. KARAWANG', '157', '32', '15');
INSERT INTO `regionals` VALUES ('173', 'KAB. BEKASI', '157', '32', '16');
INSERT INTO `regionals` VALUES ('174', 'KAB. BANDUNG BARAT', '157', '32', '17');
INSERT INTO `regionals` VALUES ('175', 'KOTA BOGOR', '157', '32', '18');
INSERT INTO `regionals` VALUES ('176', 'KOTA SUKABUMI', '157', '32', '19');
INSERT INTO `regionals` VALUES ('177', 'KOTA BANDUNG', '157', '32', '20');
INSERT INTO `regionals` VALUES ('178', 'KOTA CIREBON', '157', '32', '21');
INSERT INTO `regionals` VALUES ('179', 'KOTA BEKASI', '157', '32', '22');
INSERT INTO `regionals` VALUES ('180', 'KOTA DEPOK', '157', '32', '23');
INSERT INTO `regionals` VALUES ('181', 'KOTA CIMAHI', '157', '32', '24');
INSERT INTO `regionals` VALUES ('182', 'KOTA TASIKMALAYA', '157', '32', '25');
INSERT INTO `regionals` VALUES ('183', 'KOTA BANJAR', '157', '32', '26');
INSERT INTO `regionals` VALUES ('184', 'JAWA TENGAH', null, '33', '00');
INSERT INTO `regionals` VALUES ('185', 'KAB. CILACAP', '184', '33', '01');
INSERT INTO `regionals` VALUES ('186', 'KAB. BANYUMAS', '184', '33', '02');
INSERT INTO `regionals` VALUES ('187', 'KAB. PURBALINGGA', '184', '33', '03');
INSERT INTO `regionals` VALUES ('188', 'KAB. BANJARNEGARA', '184', '33', '04');
INSERT INTO `regionals` VALUES ('189', 'KAB. KEBUMEN', '184', '33', '05');
INSERT INTO `regionals` VALUES ('190', 'KAB. PURWOREJO', '184', '33', '06');
INSERT INTO `regionals` VALUES ('191', 'KAB. WONOSOBO', '184', '33', '07');
INSERT INTO `regionals` VALUES ('192', 'KAB. MAGELANG', '184', '33', '08');
INSERT INTO `regionals` VALUES ('193', 'KAB. BOYOLALI', '184', '33', '09');
INSERT INTO `regionals` VALUES ('194', 'KAB. KLATEN', '184', '33', '10');
INSERT INTO `regionals` VALUES ('195', 'KAB. SUKOHARJO', '184', '33', '11');
INSERT INTO `regionals` VALUES ('196', 'KAB. WONOGIRI', '184', '33', '12');
INSERT INTO `regionals` VALUES ('197', 'KAB. KARANGANYAR', '184', '33', '13');
INSERT INTO `regionals` VALUES ('198', 'KAB. SRAGEN', '184', '33', '14');
INSERT INTO `regionals` VALUES ('199', 'KAB. GROBOGAN', '184', '33', '15');
INSERT INTO `regionals` VALUES ('200', 'KAB. BLORA', '184', '33', '16');
INSERT INTO `regionals` VALUES ('201', 'KAB. REMBANG', '184', '33', '17');
INSERT INTO `regionals` VALUES ('202', 'KAB. PATI', '184', '33', '18');
INSERT INTO `regionals` VALUES ('203', 'KAB. KUDUS', '184', '33', '19');
INSERT INTO `regionals` VALUES ('204', 'KAB. JEPARA', '184', '33', '20');
INSERT INTO `regionals` VALUES ('205', 'KAB. DEMAK', '184', '33', '21');
INSERT INTO `regionals` VALUES ('206', 'KAB. SEMARANG', '184', '33', '22');
INSERT INTO `regionals` VALUES ('207', 'KAB. TEMANGGUNG', '184', '33', '23');
INSERT INTO `regionals` VALUES ('208', 'KAB. KENDAL', '184', '33', '24');
INSERT INTO `regionals` VALUES ('209', 'KAB. BATANG', '184', '33', '25');
INSERT INTO `regionals` VALUES ('210', 'KAB. PEKALONGAN', '184', '33', '26');
INSERT INTO `regionals` VALUES ('211', 'KAB. PEMALANG', '184', '33', '27');
INSERT INTO `regionals` VALUES ('212', 'KAB. TEGAL', '184', '33', '28');
INSERT INTO `regionals` VALUES ('213', 'KAB. BREBES', '184', '33', '29');
INSERT INTO `regionals` VALUES ('214', 'KOTA MAGELANG', '184', '33', '30');
INSERT INTO `regionals` VALUES ('215', 'KOTA SURAKARTA', '184', '33', '31');
INSERT INTO `regionals` VALUES ('216', 'KOTA SALATIGA', '184', '33', '32');
INSERT INTO `regionals` VALUES ('217', 'KOTA SEMARANG', '184', '33', '33');
INSERT INTO `regionals` VALUES ('218', 'KOTA PEKALONGAN', '184', '33', '34');
INSERT INTO `regionals` VALUES ('219', 'KOTA TEGAL', '184', '33', '35');
INSERT INTO `regionals` VALUES ('220', 'DAERAH ISTIMEWA YOGYAKARTA', null, '34', '00');
INSERT INTO `regionals` VALUES ('221', 'KAB. KULON PROGO', '220', '34', '01');
INSERT INTO `regionals` VALUES ('222', 'KAB. BANTUL', '220', '34', '02');
INSERT INTO `regionals` VALUES ('223', 'KAB. GUNUNG KIDUL', '220', '34', '03');
INSERT INTO `regionals` VALUES ('224', 'KAB. SLEMAN', '220', '34', '04');
INSERT INTO `regionals` VALUES ('225', 'KOTA YOGYAKARTA', '220', '34', '05');
INSERT INTO `regionals` VALUES ('226', 'JAWA TIMUR', null, '35', '00');
INSERT INTO `regionals` VALUES ('227', 'KAB. PACITAN', '226', '35', '01');
INSERT INTO `regionals` VALUES ('228', 'KAB. PONOROGO', '226', '35', '02');
INSERT INTO `regionals` VALUES ('229', 'KAB. TRENGGALEK', '226', '35', '03');
INSERT INTO `regionals` VALUES ('230', 'KAB. TULUNGAGUNG', '226', '35', '04');
INSERT INTO `regionals` VALUES ('231', 'KAB. BLITAR', '226', '35', '05');
INSERT INTO `regionals` VALUES ('232', 'KAB. KEDIRI', '226', '35', '06');
INSERT INTO `regionals` VALUES ('233', 'KAB. MALANG', '226', '35', '07');
INSERT INTO `regionals` VALUES ('234', 'KAB. LUMAJANG', '226', '35', '08');
INSERT INTO `regionals` VALUES ('235', 'KAB. JEMBER', '226', '35', '09');
INSERT INTO `regionals` VALUES ('236', 'KAB. BANYUWANGI', '226', '35', '10');
INSERT INTO `regionals` VALUES ('237', 'KAB. BONDOWOSO', '226', '35', '11');
INSERT INTO `regionals` VALUES ('238', 'KAB. SITUBONDO', '226', '35', '12');
INSERT INTO `regionals` VALUES ('239', 'KAB. PROBOLINGGO', '226', '35', '13');
INSERT INTO `regionals` VALUES ('240', 'KAB. PASURUAN', '226', '35', '14');
INSERT INTO `regionals` VALUES ('241', 'KAB. SIDOARJO', '226', '35', '15');
INSERT INTO `regionals` VALUES ('242', 'KAB. MOJOKERTO', '226', '35', '16');
INSERT INTO `regionals` VALUES ('243', 'KAB. JOMBANG', '226', '35', '17');
INSERT INTO `regionals` VALUES ('244', 'KAB. NGANJUK', '226', '35', '18');
INSERT INTO `regionals` VALUES ('245', 'KAB. MADIUN', '226', '35', '19');
INSERT INTO `regionals` VALUES ('246', 'KAB. MAGETAN', '226', '35', '20');
INSERT INTO `regionals` VALUES ('247', 'KAB. NGAWI', '226', '35', '21');
INSERT INTO `regionals` VALUES ('248', 'KAB. BOJONEGORO', '226', '35', '22');
INSERT INTO `regionals` VALUES ('249', 'KAB. TUBAN', '226', '35', '23');
INSERT INTO `regionals` VALUES ('250', 'KAB. LAMONGAN', '226', '35', '24');
INSERT INTO `regionals` VALUES ('251', 'KAB. GRESIK', '226', '35', '25');
INSERT INTO `regionals` VALUES ('252', 'KAB. BANGKALAN', '226', '35', '26');
INSERT INTO `regionals` VALUES ('253', 'KAB. SAMPANG', '226', '35', '27');
INSERT INTO `regionals` VALUES ('254', 'KAB. PAMEKASAN', '226', '35', '28');
INSERT INTO `regionals` VALUES ('255', 'KAB. SUMENEP', '226', '35', '29');
INSERT INTO `regionals` VALUES ('256', 'KOTA KEDIRI', '226', '35', '30');
INSERT INTO `regionals` VALUES ('257', 'KOTA BLITAR', '226', '35', '31');
INSERT INTO `regionals` VALUES ('258', 'KOTA MALANG', '226', '35', '32');
INSERT INTO `regionals` VALUES ('259', 'KOTA PROBOLINGGO', '226', '35', '33');
INSERT INTO `regionals` VALUES ('260', 'KOTA PASURUAN', '226', '35', '34');
INSERT INTO `regionals` VALUES ('261', 'KOTA MOJOKERTO', '226', '35', '35');
INSERT INTO `regionals` VALUES ('262', 'KOTA MADIUN', '226', '35', '36');
INSERT INTO `regionals` VALUES ('263', 'KOTA SURABAYA', '226', '35', '37');
INSERT INTO `regionals` VALUES ('264', 'KOTA BATU', '226', '35', '38');
INSERT INTO `regionals` VALUES ('265', 'BANTEN', null, '36', '00');
INSERT INTO `regionals` VALUES ('266', 'KAB. PANDEGLANG', '265', '36', '01');
INSERT INTO `regionals` VALUES ('267', 'KAB. LEBAK', '265', '36', '02');
INSERT INTO `regionals` VALUES ('268', 'KAB. TANGERANG', '265', '36', '03');
INSERT INTO `regionals` VALUES ('269', 'KAB. SERANG', '265', '36', '04');
INSERT INTO `regionals` VALUES ('270', 'KOTA TANGERANG', '265', '36', '05');
INSERT INTO `regionals` VALUES ('271', 'KOTA CILEGON', '265', '36', '06');
INSERT INTO `regionals` VALUES ('272', 'KOTA SERANG', '265', '36', '07');
INSERT INTO `regionals` VALUES ('273', 'BALI', null, '51', '00');
INSERT INTO `regionals` VALUES ('274', 'KAB. JEMBRANA', '273', '51', '01');
INSERT INTO `regionals` VALUES ('275', 'KAB. TABANAN', '273', '51', '02');
INSERT INTO `regionals` VALUES ('276', 'KAB. BADUNG', '273', '51', '03');
INSERT INTO `regionals` VALUES ('277', 'KAB. GIANYAR', '273', '51', '04');
INSERT INTO `regionals` VALUES ('278', 'KAB. KLUNGKUNG', '273', '51', '05');
INSERT INTO `regionals` VALUES ('279', 'KAB. BANGLI', '273', '51', '06');
INSERT INTO `regionals` VALUES ('280', 'KAB. KARANGASEM', '273', '51', '07');
INSERT INTO `regionals` VALUES ('281', 'KAB. BULELENG', '273', '51', '08');
INSERT INTO `regionals` VALUES ('282', 'KOTA DENPASAR', '273', '51', '09');
INSERT INTO `regionals` VALUES ('283', 'NUSA TENGGARA BARAT', null, '52', '00');
INSERT INTO `regionals` VALUES ('284', 'KAB. LOMBOK BARAT', '283', '52', '01');
INSERT INTO `regionals` VALUES ('285', 'KAB. LOMBOK TENGAH', '283', '52', '02');
INSERT INTO `regionals` VALUES ('286', 'KAB. LOMBOK TIMUR', '283', '52', '03');
INSERT INTO `regionals` VALUES ('287', 'KAB. SUMBAWA', '283', '52', '04');
INSERT INTO `regionals` VALUES ('288', 'KAB. DOMPU', '283', '52', '05');
INSERT INTO `regionals` VALUES ('289', 'KAB. BIMA', '283', '52', '06');
INSERT INTO `regionals` VALUES ('290', 'KAB. SUMBAWA BARAT', '283', '52', '07');
INSERT INTO `regionals` VALUES ('291', 'KOTA MATARAM', '283', '52', '08');
INSERT INTO `regionals` VALUES ('292', 'KOTA BIMA', '283', '52', '09');
INSERT INTO `regionals` VALUES ('293', 'NUSA TENGGARA TIMUR', null, '53', '00');
INSERT INTO `regionals` VALUES ('294', 'KAB. KUPANG', '293', '53', '01');
INSERT INTO `regionals` VALUES ('295', 'KAB TIMOR TENGAH SELATAN', '293', '53', '02');
INSERT INTO `regionals` VALUES ('296', 'KAB. TIMOR TENGAH UTARA', '293', '53', '03');
INSERT INTO `regionals` VALUES ('297', 'KAB. BELU', '293', '53', '04');
INSERT INTO `regionals` VALUES ('298', 'KAB. ALOR', '293', '53', '05');
INSERT INTO `regionals` VALUES ('299', 'KAB. FLORES TIMUR', '293', '53', '06');
INSERT INTO `regionals` VALUES ('300', 'KAB. SIKKA', '293', '53', '07');
INSERT INTO `regionals` VALUES ('301', 'KAB. ENDE', '293', '53', '08');
INSERT INTO `regionals` VALUES ('302', 'KAB. NGADA', '293', '53', '09');
INSERT INTO `regionals` VALUES ('303', 'KAB. MANGGARAI', '293', '53', '10');
INSERT INTO `regionals` VALUES ('304', 'KAB. SUMBA TIMUR', '293', '53', '11');
INSERT INTO `regionals` VALUES ('305', 'KAB. SUMBA BARAT', '293', '53', '12');
INSERT INTO `regionals` VALUES ('306', 'KAB. LEMBATA', '293', '53', '13');
INSERT INTO `regionals` VALUES ('307', 'KAB. ROTE NDAO', '293', '53', '14');
INSERT INTO `regionals` VALUES ('308', 'KAB. MANGGARAI BARAT', '293', '53', '15');
INSERT INTO `regionals` VALUES ('309', 'KAB. NAGEKEO', '293', '53', '16');
INSERT INTO `regionals` VALUES ('310', 'KAB. SUMBA TENGAH', '293', '53', '17');
INSERT INTO `regionals` VALUES ('311', 'KAB. SUMBA BARAT DAYA', '293', '53', '18');
INSERT INTO `regionals` VALUES ('312', 'KAB. MANGGARAI TIMUR', '293', '53', '19');
INSERT INTO `regionals` VALUES ('313', 'KOTA KUPANG', '293', '53', '20');
INSERT INTO `regionals` VALUES ('314', 'KALIMANTAN BARAT', null, '61', '00');
INSERT INTO `regionals` VALUES ('315', 'KAB. SAMBAS', '314', '61', '01');
INSERT INTO `regionals` VALUES ('316', 'KAB. PONTIANAK', '314', '61', '02');
INSERT INTO `regionals` VALUES ('317', 'KAB. SANGGAU', '314', '61', '03');
INSERT INTO `regionals` VALUES ('318', 'KAB. KETAPANG', '314', '61', '04');
INSERT INTO `regionals` VALUES ('319', 'KAB. SINTANG', '314', '61', '05');
INSERT INTO `regionals` VALUES ('320', 'KAB. KAPUAS HULU', '314', '61', '06');
INSERT INTO `regionals` VALUES ('321', 'KAB. BENGKAYANG', '314', '61', '07');
INSERT INTO `regionals` VALUES ('322', 'KAB. LANDAK', '314', '61', '08');
INSERT INTO `regionals` VALUES ('323', 'KAB. SEKADAU', '314', '61', '09');
INSERT INTO `regionals` VALUES ('324', 'KAB. MELAWI', '314', '61', '10');
INSERT INTO `regionals` VALUES ('325', 'KAB. KAYONG UTARA', '314', '61', '11');
INSERT INTO `regionals` VALUES ('326', 'KAB. KUBU RAYA', '314', '61', '12');
INSERT INTO `regionals` VALUES ('327', 'KOTA PONTIANAK', '314', '61', '13');
INSERT INTO `regionals` VALUES ('328', 'KOTA SINGKAWANG', '314', '61', '14');
INSERT INTO `regionals` VALUES ('329', 'KALIMANTAN TENGAH', null, '62', '00');
INSERT INTO `regionals` VALUES ('330', 'KAB. KOTAWARINGIN BARAT', '329', '62', '01');
INSERT INTO `regionals` VALUES ('331', 'KAB. KOTAWARINGIN TIMUR', '329', '62', '02');
INSERT INTO `regionals` VALUES ('332', 'KAB. KAPUAS', '329', '62', '03');
INSERT INTO `regionals` VALUES ('333', 'KAB. BARITO SELATAN', '329', '62', '04');
INSERT INTO `regionals` VALUES ('334', 'KAB. BARITO UTARA', '329', '62', '05');
INSERT INTO `regionals` VALUES ('335', 'KAB. KATINGAN', '329', '62', '06');
INSERT INTO `regionals` VALUES ('336', 'KAB. SERUYAN', '329', '62', '07');
INSERT INTO `regionals` VALUES ('337', 'KAB. SUKAMARA', '329', '62', '08');
INSERT INTO `regionals` VALUES ('338', 'KAB. LAMANDAU', '329', '62', '09');
INSERT INTO `regionals` VALUES ('339', 'KAB. GUNUNG MAS', '329', '62', '10');
INSERT INTO `regionals` VALUES ('340', 'KAB. PULANG PISAU', '329', '62', '11');
INSERT INTO `regionals` VALUES ('341', 'KAB. MURUNG RAYA', '329', '62', '12');
INSERT INTO `regionals` VALUES ('342', 'KAB. BARITO TIMUR', '329', '62', '13');
INSERT INTO `regionals` VALUES ('343', 'KOTA PALANGKARAYA', '329', '62', '14');
INSERT INTO `regionals` VALUES ('344', 'KALIMANTAN SELATAN', null, '63', '00');
INSERT INTO `regionals` VALUES ('345', 'KAB. TANAH LAUT', '343', '63', '01');
INSERT INTO `regionals` VALUES ('346', 'KAB. KOTABARU', '343', '63', '02');
INSERT INTO `regionals` VALUES ('347', 'KAB. BANJAR', '343', '63', '03');
INSERT INTO `regionals` VALUES ('348', 'KAB. BARITO KUALA', '343', '63', '04');
INSERT INTO `regionals` VALUES ('349', 'KAB. TAPIN', '343', '63', '05');
INSERT INTO `regionals` VALUES ('350', 'KAB. HULU SUNGAI SELATAN', '343', '63', '06');
INSERT INTO `regionals` VALUES ('351', 'KAB. HULU SUNGAI TENGAH', '343', '63', '07');
INSERT INTO `regionals` VALUES ('352', 'KAB. HULU SUNGAI UTARA', '343', '63', '08');
INSERT INTO `regionals` VALUES ('353', 'KAB. TABALONG', '343', '63', '09');
INSERT INTO `regionals` VALUES ('354', 'KAB. TANAH BUMBU', '343', '63', '10');
INSERT INTO `regionals` VALUES ('355', 'KAB. BALANGAN', '343', '63', '11');
INSERT INTO `regionals` VALUES ('356', 'KOTA BANJARMASIN', '343', '63', '12');
INSERT INTO `regionals` VALUES ('357', 'KOTA BANJARBARU', '343', '63', '13');
INSERT INTO `regionals` VALUES ('358', 'KALIMANTAN TIMUR', null, '', '00');
INSERT INTO `regionals` VALUES ('359', 'KAB. PASER', '357', '64', '01');
INSERT INTO `regionals` VALUES ('360', 'KAB. KUTAI KERTANEGARA', '357', '64', '02');
INSERT INTO `regionals` VALUES ('361', 'KAB. BERAU', '357', '64', '03');
INSERT INTO `regionals` VALUES ('362', 'KAB. BULUNGAN', '357', '64', '04');
INSERT INTO `regionals` VALUES ('363', 'KAB. NUNUKAN', '357', '64', '05');
INSERT INTO `regionals` VALUES ('364', 'KAB. MALINAU', '357', '64', '06');
INSERT INTO `regionals` VALUES ('365', 'KAB. KUTAI BARAT', '357', '64', '07');
INSERT INTO `regionals` VALUES ('366', 'KAB. KUTAI TIMUR', '357', '64', '08');
INSERT INTO `regionals` VALUES ('367', 'KAB PENAJAM PASER UTARA', '357', '64', '09');
INSERT INTO `regionals` VALUES ('368', 'KAB TANA TIDUNG', '357', '64', '10');
INSERT INTO `regionals` VALUES ('369', 'KOTA BALIKPAPAN', '357', '64', '11');
INSERT INTO `regionals` VALUES ('370', 'KOTA SAMARINDA', '357', '64', '12');
INSERT INTO `regionals` VALUES ('371', 'KOTA TARAKAN', '357', '64', '13');
INSERT INTO `regionals` VALUES ('372', 'KOTA BONTANG', '357', '64', '14');
INSERT INTO `regionals` VALUES ('373', 'SULAWESI UTARA', null, '71', '00');
INSERT INTO `regionals` VALUES ('374', 'KAB BOLAANG MONGONDOW', '372', '71', '01');
INSERT INTO `regionals` VALUES ('375', 'KAB. MINAHASA', '372', '71', '02');
INSERT INTO `regionals` VALUES ('376', 'KAB. KEPULAUAN SANGIHE', '372', '71', '03');
INSERT INTO `regionals` VALUES ('377', 'KAB. KEPULAUAN TALAUD', '372', '71', '04');
INSERT INTO `regionals` VALUES ('378', 'KAB. MINAHASA SELATAN', '372', '71', '05');
INSERT INTO `regionals` VALUES ('379', 'KAB. MINAHASA UTARA', '372', '71', '06');
INSERT INTO `regionals` VALUES ('380', 'KAB. MINAHASA TENGGARA', '372', '71', '07');
INSERT INTO `regionals` VALUES ('381', 'KAB. BOLMONG UTARA', '372', '71', '08');
INSERT INTO `regionals` VALUES ('382', 'KAB. KEP. SITARO', '372', '71', '09');
INSERT INTO `regionals` VALUES ('383', 'KOTA MANADO', '372', '71', '10');
INSERT INTO `regionals` VALUES ('384', 'KOTA BITUNG', '372', '71', '11');
INSERT INTO `regionals` VALUES ('385', 'KOTA TOMOHON', '372', '71', '12');
INSERT INTO `regionals` VALUES ('386', 'KOTA. KOTAMOBAGU', '372', '71', '13');
INSERT INTO `regionals` VALUES ('387', 'SULAWESI TENGAH', null, '72', '00');
INSERT INTO `regionals` VALUES ('388', 'KAB. BANGGAI', '386', '72', '01');
INSERT INTO `regionals` VALUES ('389', 'KAB. POSO', '386', '72', '02');
INSERT INTO `regionals` VALUES ('390', 'KAB. DONGGALA', '386', '72', '03');
INSERT INTO `regionals` VALUES ('391', 'KAB. TOLI TOLI', '386', '72', '04');
INSERT INTO `regionals` VALUES ('392', 'KAB. BUOL', '386', '72', '05');
INSERT INTO `regionals` VALUES ('393', 'KAB. MOROWALI', '386', '72', '06');
INSERT INTO `regionals` VALUES ('394', 'KAB BANGGAI KEPULAUAN', '386', '72', '07');
INSERT INTO `regionals` VALUES ('395', 'KAB. PARIGI MOUTONG', '386', '72', '08');
INSERT INTO `regionals` VALUES ('396', 'KAB. TOJO UNA UNA', '386', '72', '09');
INSERT INTO `regionals` VALUES ('397', 'KOTA PALU', '386', '72', '10');
INSERT INTO `regionals` VALUES ('398', 'SULAWESI SELATAN', null, '73', '00');
INSERT INTO `regionals` VALUES ('399', 'KAB. SELAYAR', '397', '73', '01');
INSERT INTO `regionals` VALUES ('400', 'KAB. BULUKUMBA', '397', '73', '02');
INSERT INTO `regionals` VALUES ('401', 'KAB. BANTAENG', '397', '73', '03');
INSERT INTO `regionals` VALUES ('402', 'KAB. JENEPONTO', '397', '73', '04');
INSERT INTO `regionals` VALUES ('403', 'KAB. TAKALAR', '397', '73', '05');
INSERT INTO `regionals` VALUES ('404', 'KAB. GOWA', '397', '73', '06');
INSERT INTO `regionals` VALUES ('405', 'KAB. SINJAI', '397', '73', '07');
INSERT INTO `regionals` VALUES ('406', 'KAB. BONE', '397', '73', '08');
INSERT INTO `regionals` VALUES ('407', 'KAB. MAROS', '397', '73', '09');
INSERT INTO `regionals` VALUES ('408', 'KAB. PANGKAJENE KEP.', '397', '73', '10');
INSERT INTO `regionals` VALUES ('409', 'KAB. BARRU', '397', '73', '11');
INSERT INTO `regionals` VALUES ('410', 'KAB. SOPPENG', '397', '73', '12');
INSERT INTO `regionals` VALUES ('411', 'KAB. WAJO', '397', '73', '13');
INSERT INTO `regionals` VALUES ('412', 'KAB. SIDENRENG RAPANG', '397', '73', '14');
INSERT INTO `regionals` VALUES ('413', 'KAB. PINRANG', '397', '73', '15');
INSERT INTO `regionals` VALUES ('414', 'KAB. ENREKANG', '397', '73', '16');
INSERT INTO `regionals` VALUES ('415', 'KAB. LUWU', '397', '73', '17');
INSERT INTO `regionals` VALUES ('416', 'KAB. TANA TORAJA', '397', '73', '18');
INSERT INTO `regionals` VALUES ('417', 'KAB. LUWU UTARA', '397', '73', '19');
INSERT INTO `regionals` VALUES ('418', 'KAB. LUWU TIMUR', '397', '73', '20');
INSERT INTO `regionals` VALUES ('419', 'KOTA MAKASSAR', '397', '73', '21');
INSERT INTO `regionals` VALUES ('420', 'KOTA PARE PARE', '397', '73', '22');
INSERT INTO `regionals` VALUES ('421', 'KOTA PALOPO', '397', '73', '23');
INSERT INTO `regionals` VALUES ('422', 'SULAWESI TENGGARA', null, '74', '00');
INSERT INTO `regionals` VALUES ('423', 'KAB. KOLAKA', '421', '74', '01');
INSERT INTO `regionals` VALUES ('424', 'KAB. KONAWE', '421', '74', '02');
INSERT INTO `regionals` VALUES ('425', 'KAB. MUNA', '421', '74', '03');
INSERT INTO `regionals` VALUES ('426', 'KAB. BUTON', '421', '74', '04');
INSERT INTO `regionals` VALUES ('427', 'KAB. KONAWE SELATAN', '421', '74', '05');
INSERT INTO `regionals` VALUES ('428', 'KAB. BOMBANA', '421', '74', '06');
INSERT INTO `regionals` VALUES ('429', 'KAB. WAKATOBI', '421', '74', '07');
INSERT INTO `regionals` VALUES ('430', 'KAB. KOLAKA UTARA', '421', '74', '08');
INSERT INTO `regionals` VALUES ('431', 'KAB. KONAWE UTARA', '421', '74', '09');
INSERT INTO `regionals` VALUES ('432', 'KAB. BUTON UTARA', '421', '74', '10');
INSERT INTO `regionals` VALUES ('433', 'KOTA KENDARI', '421', '74', '11');
INSERT INTO `regionals` VALUES ('434', 'KOTA BAU BAU', '421', '74', '12');
INSERT INTO `regionals` VALUES ('435', 'GORONTALO', null, '75', '00');
INSERT INTO `regionals` VALUES ('436', 'KAB. GORONTALO', '434', '75', '01');
INSERT INTO `regionals` VALUES ('437', 'KAB. BOALEMO', '434', '75', '02');
INSERT INTO `regionals` VALUES ('438', 'KAB. BONE BOLANGO', '434', '75', '03');
INSERT INTO `regionals` VALUES ('439', 'KAB. PAHUWATO', '434', '75', '04');
INSERT INTO `regionals` VALUES ('440', 'KAB. GORONTALO UTARA', '434', '75', '05');
INSERT INTO `regionals` VALUES ('441', 'KOTA GORONTALO', '434', '75', '06');
INSERT INTO `regionals` VALUES ('442', 'SULAWESI BARAT', null, '76', '00');
INSERT INTO `regionals` VALUES ('443', 'KAB. MAMUJU UTARA', '441', '76', '01');
INSERT INTO `regionals` VALUES ('444', 'KAB. MAMUJU', '441', '76', '02');
INSERT INTO `regionals` VALUES ('445', 'KAB. MAMASA', '441', '76', '03');
INSERT INTO `regionals` VALUES ('446', 'KAB. POLEWALI MANDAR', '441', '76', '04');
INSERT INTO `regionals` VALUES ('447', 'KAB. MAJENE', '441', '76', '05');
INSERT INTO `regionals` VALUES ('448', 'MALUKU', null, '81', '00');
INSERT INTO `regionals` VALUES ('449', 'KAB. MALUKU TENGAH', '447', '81', '01');
INSERT INTO `regionals` VALUES ('450', 'KAB. MALUKU TENGGARA', '447', '81', '02');
INSERT INTO `regionals` VALUES ('451', 'KAB MALUKU TENGGARA BRT', '447', '81', '03');
INSERT INTO `regionals` VALUES ('452', 'KAB. BURU', '447', '81', '04');
INSERT INTO `regionals` VALUES ('453', 'KAB. SERAM BAGIAN TIMUR', '447', '81', '05');
INSERT INTO `regionals` VALUES ('454', 'KAB. SERAM BAGIAN BARAT', '447', '81', '06');
INSERT INTO `regionals` VALUES ('455', 'KAB. KEPULAUAN ARU', '447', '81', '07');
INSERT INTO `regionals` VALUES ('456', 'KOTA AMBON', '447', '81', '08');
INSERT INTO `regionals` VALUES ('457', 'KOTA TUAL', '447', '81', '09');
INSERT INTO `regionals` VALUES ('458', 'MALUKU UTARA', null, '82', '00');
INSERT INTO `regionals` VALUES ('459', 'KAB. HALMAHERA BARAT', '457', '82', '01');
INSERT INTO `regionals` VALUES ('460', 'KAB. HALMAHERA TENGAH', '457', '82', '02');
INSERT INTO `regionals` VALUES ('461', 'KAB. HALMAHERA UTARA', '457', '82', '03');
INSERT INTO `regionals` VALUES ('462', 'KAB. HALMAHERA SELATAN', '457', '82', '04');
INSERT INTO `regionals` VALUES ('463', 'KAB. KEPULAUAN SULA', '457', '82', '05');
INSERT INTO `regionals` VALUES ('464', 'KAB. HALMAHERA TIMUR', '457', '82', '06');
INSERT INTO `regionals` VALUES ('465', 'KOTA TERNATE', '457', '82', '07');
INSERT INTO `regionals` VALUES ('466', 'KOTA TIDORE KEPULAUAN', '457', '82', '08');
INSERT INTO `regionals` VALUES ('467', 'PAPUA', null, '91', '00');
INSERT INTO `regionals` VALUES ('468', 'KAB. MERAUKE', '466', '91', '01');
INSERT INTO `regionals` VALUES ('469', 'KAB. JAYAWIJAYA', '466', '91', '02');
INSERT INTO `regionals` VALUES ('470', 'KAB. JAYAPURA', '466', '91', '03');
INSERT INTO `regionals` VALUES ('471', 'KAB. NABIRE', '466', '91', '04');
INSERT INTO `regionals` VALUES ('472', 'KAB. YAPEN WAROPEN', '466', '91', '05');
INSERT INTO `regionals` VALUES ('473', 'KAB. BIAK NUMFOR', '466', '91', '06');
INSERT INTO `regionals` VALUES ('474', 'KAB. PUNCAK JAYA', '466', '91', '07');
INSERT INTO `regionals` VALUES ('475', 'KAB. PANIAI', '466', '91', '08');
INSERT INTO `regionals` VALUES ('476', 'KAB. MIMIKA', '466', '91', '09');
INSERT INTO `regionals` VALUES ('477', 'KAB. SARMI', '466', '91', '10');
INSERT INTO `regionals` VALUES ('478', 'KAB. KEEROM', '466', '91', '11');
INSERT INTO `regionals` VALUES ('479', 'KAB PEGUNUNGAN BINTANG', '466', '91', '12');
INSERT INTO `regionals` VALUES ('480', 'KAB. YAHUKIMO', '466', '91', '13');
INSERT INTO `regionals` VALUES ('481', 'KAB. TOLIKARA', '466', '91', '14');
INSERT INTO `regionals` VALUES ('482', 'KAB. WAROPEN', '466', '91', '15');
INSERT INTO `regionals` VALUES ('483', 'KAB. BOVEN DIGOEL', '466', '91', '16');
INSERT INTO `regionals` VALUES ('484', 'KAB. MAPPI', '466', '91', '17');
INSERT INTO `regionals` VALUES ('485', 'KAB. ASMAT', '466', '91', '18');
INSERT INTO `regionals` VALUES ('486', 'KAB. SUPIORI', '466', '91', '19');
INSERT INTO `regionals` VALUES ('487', 'KAB. MAMBERAMO RAYA', '466', '91', '20');
INSERT INTO `regionals` VALUES ('488', 'KOTA JAYAPURA', '466', '91', '21');
INSERT INTO `regionals` VALUES ('489', 'PAPUA BARAT  (PP No. 24\'2007)', null, '92', '00');
INSERT INTO `regionals` VALUES ('490', 'KAB. SORONG', '488', '92', '01');
INSERT INTO `regionals` VALUES ('491', 'KAB. MANOKWARI', '488', '92', '02');
INSERT INTO `regionals` VALUES ('492', 'KAB. FAK FAK', '488', '92', '03');
INSERT INTO `regionals` VALUES ('493', 'KAB. SORONG SELATAN', '488', '92', '04');
INSERT INTO `regionals` VALUES ('494', 'KAB. RAJA AMPAT', '488', '92', '05');
INSERT INTO `regionals` VALUES ('495', 'KAB. TELUK BENTUNI', '488', '92', '06');
INSERT INTO `regionals` VALUES ('496', 'KAB. TELUK WONDAMA', '488', '92', '07');
INSERT INTO `regionals` VALUES ('497', 'KAB. KAIMANA', '488', '92', '08');
INSERT INTO `regionals` VALUES ('498', 'KOTA SORONG', '488', '92', '09');

-- ----------------------------
-- Table structure for `religions`
-- ----------------------------
DROP TABLE IF EXISTS `religions`;
CREATE TABLE `religions` (
  `religion_id` int(11) NOT NULL AUTO_INCREMENT,
  `religion_name` varchar(32) NOT NULL,
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of religions
-- ----------------------------
INSERT INTO `religions` VALUES ('1', 'Kristen');
INSERT INTO `religions` VALUES ('2', 'Katolik');
INSERT INTO `religions` VALUES ('3', 'Islam');
INSERT INTO `religions` VALUES ('4', 'Hindu');
INSERT INTO `religions` VALUES ('5', 'Buddha');
INSERT INTO `religions` VALUES ('6', 'Others');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` varchar(16) NOT NULL DEFAULT '',
  `title_alias` varchar(64) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('admin-regional', 'Administrator Regional', 'N');
INSERT INTO `roles` VALUES ('admin-super', 'Administrator General', 'N');
INSERT INTO `roles` VALUES ('member', 'Member', 'N');
INSERT INTO `roles` VALUES ('volunteer', 'Author Voluntary', 'N');

-- ----------------------------
-- Table structure for `roles_access`
-- ----------------------------
DROP TABLE IF EXISTS `roles_access`;
CREATE TABLE `roles_access` (
  `role_access_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `functional_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`role_access_id`),
  UNIQUE KEY `rid_fid_unique` (`role_id`,`functional_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles_access
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `activated` char(1) NOT NULL DEFAULT 'N',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uname_email_unique` (`username`,`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for `users_activations`
-- ----------------------------
DROP TABLE IF EXISTS `users_activations`;
CREATE TABLE `users_activations` (
  `user_activation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activation_key` varchar(32) NOT NULL,
  `expired_date` datetime NOT NULL,
  `email_sent` char(1) NOT NULL DEFAULT 'N',
  `created` datetime NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_activation_id`),
  UNIQUE KEY `uid_unique` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_activations
-- ----------------------------

-- ----------------------------
-- Table structure for `users_reset_pwd`
-- ----------------------------
DROP TABLE IF EXISTS `users_reset_pwd`;
CREATE TABLE `users_reset_pwd` (
  `user_reset_pwd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reset_key` varchar(32) NOT NULL,
  `expired_date` datetime NOT NULL,
  `email_sent` char(1) NOT NULL DEFAULT 'N',
  `created` datetime NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_reset_pwd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_reset_pwd
-- ----------------------------

-- ----------------------------
-- Table structure for `users_roles`
-- ----------------------------
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` varchar(16) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_role_id`),
  UNIQUE KEY `uid_rid_unique` (`user_id`,`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_roles
-- ----------------------------
