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
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `regional_name` varchar(64) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `province_code` char(2) NOT NULL,
  `city_code` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=549 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of regionals
-- ----------------------------
INSERT INTO `regionals` VALUES
(1,'ACEH',NULL,'11','00'),
(2,'KAB. SIMEULUE',1,'11','01'),
(3,'KAB. ACEH SINGKIL',1,'11','02'),
(4,'KAB. ACEH SELATAN',1,'11','03'),
(5,'KAB. ACEH TENGGARA',1,'11','04'),
(6,'KAB. ACEH TIMUR',1,'11','05'),
(7,'KAB. ACEH TENGAH',1,'11','06'),
(8,'KAB. ACEH BARAT',1,'11','07'),
(9,'KAB. ACEH BESAR',1,'11','08'),
(10,'KAB. PIDIE',1,'11','09'),
(11,'KAB. BIREUEN',1,'11','10'),
(12,'KAB. ACEH UTARA',1,'11','11'),
(13,'KAB. ACEH BARAT DAYA',1,'11','12'),
(14,'KAB. GAYO LUES',1,'11','13'),
(15,'KAB. ACEH TAMIANG',1,'11','14'),
(16,'KAB. NAGAN RAYA',1,'11','15'),
(17,'KAB. ACEH JAYA',1,'11','16'),
(18,'KAB. BENER MERIAH',1,'11','17'),
(19,'KAB. PIDIE JAYA',1,'11','18'),
(20,'KOTA BANDA ACEH',1,'11','71'),
(21,'KOTA SABANG',1,'11','72'),
(22,'KOTA LANGSA',1,'11','73'),
(23,'KOTA LHOKSEUMAWE',1,'11','74'),
(24,'KOTA SUBULUSSALAM',1,'11','75'),
(25,'SUMATERA UTARA',NULL,'12','00'),
(26,'KAB. NIAS',25,'12','01'),
(27,'KAB. MANDAILING NATAL',25,'12','02'),
(28,'KAB. TAPANULI SELATAN',25,'12','03'),
(29,'KAB. TAPANULI TENGAH',25,'12','04'),
(30,'KAB. TAPANULI UTARA',25,'12','05'),
(31,'KAB. TOBA SAMOSIR',25,'12','06'),
(32,'KAB. LABUHAN BATU',25,'12','07'),
(33,'KAB. ASAHAN',25,'12','08'),
(34,'KAB. SIMALUNGUN',25,'12','09'),
(35,'KAB. DAIRI',25,'12','10'),
(36,'KAB. KARO',25,'12','11'),
(37,'KAB. DELI SERDANG',25,'12','12'),
(38,'KAB. LANGKAT',25,'12','13'),
(39,'KAB. NIAS SELATAN',25,'12','14'),
(40,'KAB. HUMBANG HASUNDUTAN',25,'12','15'),
(41,'KAB. PAKPAK BHARAT',25,'12','16'),
(42,'KAB. SAMOSIR',25,'12','17'),
(43,'KAB. SERDANG BEDAGAI',25,'12','18'),
(44,'KAB. BATU BARA',25,'12','19'),
(45,'KAB. PADANG LAWAS UTARA',25,'12','20'),
(46,'KAB. PADANG LAWAS',25,'12','21'),
(47,'KAB. LABUHAN BATU SELATAN',25,'12','22'),
(48,'KAB. LABUHAN BATU UTARA',25,'12','23'),
(49,'KAB. NIAS UTARA',25,'12','24'),
(50,'KAB. NIAS BARAT',25,'12','25'),
(51,'KOTA SIBOLGA',25,'12','71'),
(52,'KOTA TANJUNG BALAI',25,'12','72'),
(53,'KOTA PEMATANG SIANTAR',25,'12','73'),
(54,'KOTA TEBING TINGGI',25,'12','74'),
(55,'KOTA MEDAN',25,'12','75'),
(56,'KOTA BINJAI',25,'12','76'),
(57,'KOTA PADANGSIDIMPUAN',25,'12','77'),
(58,'KOTA GUNUNGSITOLI',25,'12','78'),
(59,'SUMATERA BARAT',NULL,'13','00'),
(60,'KAB. KEPULAUAN MENTAWAI',59,'13','01'),
(61,'KAB. PESISIR SELATAN',59,'13','02'),
(62,'KAB. SOLOK',59,'13','03'),
(63,'KAB. SIJUNJUNG',59,'13','04'),
(64,'KAB. TANAH DATAR',59,'13','05'),
(65,'KAB. PADANG PARIAMAN',59,'13','06'),
(66,'KAB. AGAM',59,'13','07'),
(67,'KAB. LIMA PULUH KOTA',59,'13','08'),
(68,'KAB. PASAMAN',59,'13','09'),
(69,'KAB. SOLOK SELATAN',59,'13','10'),
(70,'KAB. DHARMASRAYA',59,'13','11'),
(71,'KAB. PASAMAN BARAT',59,'13','12'),
(72,'KOTA PADANG',59,'13','71'),
(73,'KOTA SOLOK',59,'13','72'),
(74,'KOTA SAWAH LUNTO',59,'13','73'),
(75,'KOTA PADANG PANJANG',59,'13','74'),
(76,'KOTA BUKITTINGGI',59,'13','75'),
(77,'KOTA PAYAKUMBUH',59,'13','76'),
(78,'KOTA PARIAMAN',59,'13','77'),
(79,'RIAU',NULL,'14','00'),
(80,'KAB. KUANTAN SINGINGI',79,'14','01'),
(81,'KAB. INDRAGIRI HULU',79,'14','02'),
(82,'KAB. INDRAGIRI HILIR',79,'14','03'),
(83,'KAB. PELALAWAN',79,'14','04'),
(84,'KAB. S I A K',79,'14','05'),
(85,'KAB. KAMPAR',79,'14','06'),
(86,'KAB. ROKAN HULU',79,'14','07'),
(87,'KAB. BENGKALIS',79,'14','08'),
(88,'KAB. ROKAN HILIR',79,'14','09'),
(89,'KAB. KEPULAUAN MERANTI',79,'14','10'),
(90,'KOTA PEKANBARU',79,'14','71'),
(91,'KOTA D U M A I',79,'14','73'),
(92,'JAMBI',NULL,'15','00'),
(93,'KAB. KERINCI',92,'15','01'),
(94,'KAB. MERANGIN',92,'15','02'),
(95,'KAB. SAROLANGUN',92,'15','03'),
(96,'KAB. BATANG HARI',92,'15','04'),
(97,'KAB. MUARO JAMBI',92,'15','05'),
(98,'KAB. TANJUNG JABUNG TIMUR',92,'15','06'),
(99,'KAB. TANJUNG JABUNG BARAT',92,'15','07'),
(100,'KAB. TEBO',92,'15','08'),
(101,'KAB. BUNGO',92,'15','09'),
(102,'KOTA JAMBI',92,'15','71'),
(103,'KOTA SUNGAI PENUH',92,'15','72'),
(104,'SUMATERA SELATAN',NULL,'16','00'),
(105,'KAB. OGAN KOMERING ULU',104,'16','01'),
(106,'KAB. OGAN KOMERING ILIR',104,'16','02'),
(107,'KAB. MUARA ENIM',104,'16','03'),
(108,'KAB. LAHAT',104,'16','04'),
(109,'KAB. MUSI RAWAS',104,'16','05'),
(110,'KAB. MUSI BANYUASIN',104,'16','06'),
(111,'KAB. BANYU ASIN',104,'16','07'),
(112,'KAB. OGAN KOMERING ULU SELATAN',104,'16','08'),
(113,'KAB. OGAN KOMERING ULU TIMUR',104,'16','09'),
(114,'KAB. OGAN ILIR',104,'16','10'),
(115,'KAB. EMPAT LAWANG',104,'16','11'),
(116,'KAB. PENUKAL ABAB LEMATANG ILIR',104,'16','12'),
(117,'KAB. MUSI RAWAS UTARA',104,'16','13'),
(118,'KOTA PALEMBANG',104,'16','71'),
(119,'KOTA PRABUMULIH',104,'16','72'),
(120,'KOTA PAGAR ALAM',104,'16','73'),
(121,'KOTA LUBUKLINGGAU',104,'16','74'),
(122,'BENGKULU',NULL,'17','00'),
(123,'KAB. BENGKULU SELATAN',122,'17','01'),
(124,'KAB. REJANG LEBONG',122,'17','02'),
(125,'KAB. BENGKULU UTARA',122,'17','03'),
(126,'KAB. KAUR',122,'17','04'),
(127,'KAB. SELUMA',122,'17','05'),
(128,'KAB. MUKOMUKO',122,'17','06'),
(129,'KAB. LEBONG',122,'17','07'),
(130,'KAB. KEPAHIANG',122,'17','08'),
(131,'KAB. BENGKULU TENGAH',122,'17','09'),
(132,'KOTA BENGKULU',122,'17','71'),
(133,'LAMPUNG',NULL,'18','00'),
(134,'KAB. LAMPUNG BARAT',133,'18','01'),
(135,'KAB. TANGGAMUS',133,'18','02'),
(136,'KAB. LAMPUNG SELATAN',133,'18','03'),
(137,'KAB. LAMPUNG TIMUR',133,'18','04'),
(138,'KAB. LAMPUNG TENGAH',133,'18','05'),
(139,'KAB. LAMPUNG UTARA',133,'18','06'),
(140,'KAB. WAY KANAN',133,'18','07'),
(141,'KAB. TULANGBAWANG',133,'18','08'),
(142,'KAB. PESAWARAN',133,'18','09'),
(143,'KAB. PRINGSEWU',133,'18','10'),
(144,'KAB. MESUJI',133,'18','11'),
(145,'KAB. TULANG BAWANG BARAT',133,'18','12'),
(146,'KAB. PESISIR BARAT',133,'18','13'),
(147,'KOTA BANDAR LAMPUNG',133,'18','71'),
(148,'KOTA METRO',133,'18','72'),
(149,'KEPULAUAN BANGKA BELITUNG',NULL,'19','00'),
(150,'KAB. BANGKA',149,'19','01'),
(151,'KAB. BELITUNG',149,'19','02'),
(152,'KAB. BANGKA BARAT',149,'19','03'),
(153,'KAB. BANGKA TENGAH',149,'19','04'),
(154,'KAB. BANGKA SELATAN',149,'19','05'),
(155,'KAB. BELITUNG TIMUR',149,'19','06'),
(156,'KOTA PANGKAL PINANG',149,'19','71'),
(157,'KEPULAUAN RIAU',NULL,'21','00'),
(158,'KAB. KARIMUN',157,'21','01'),
(159,'KAB. BINTAN',157,'21','02'),
(160,'KAB. NATUNA',157,'21','03'),
(161,'KAB. LINGGA',157,'21','04'),
(162,'KAB. KEPULAUAN ANAMBAS',157,'21','05'),
(163,'KOTA B A T A M',157,'21','71'),
(164,'KOTA TANJUNG PINANG',157,'21','72'),
(165,'DKI JAKARTA',NULL,'31','00'),
(166,'KAB. KEPULAUAN SERIBU',165,'31','01'),
(167,'KOTA JAKARTA SELATAN',165,'31','71'),
(168,'KOTA JAKARTA TIMUR',165,'31','72'),
(169,'KOTA JAKARTA PUSAT',165,'31','73'),
(170,'KOTA JAKARTA BARAT',165,'31','74'),
(171,'KOTA JAKARTA UTARA',165,'31','75'),
(172,'JAWA BARAT',NULL,'32','00'),
(173,'KAB. BOGOR',172,'32','01'),
(174,'KAB. SUKABUMI',172,'32','02'),
(175,'KAB. CIANJUR',172,'32','03'),
(176,'KAB. BANDUNG',172,'32','04'),
(177,'KAB. GARUT',172,'32','05'),
(178,'KAB. TASIKMALAYA',172,'32','06'),
(179,'KAB. CIAMIS',172,'32','07'),
(180,'KAB. KUNINGAN',172,'32','08'),
(181,'KAB. CIREBON',172,'32','09'),
(182,'KAB. MAJALENGKA',172,'32','10'),
(183,'KAB. SUMEDANG',172,'32','11'),
(184,'KAB. INDRAMAYU',172,'32','12'),
(185,'KAB. SUBANG',172,'32','13'),
(186,'KAB. PURWAKARTA',172,'32','14'),
(187,'KAB. KARAWANG',172,'32','15'),
(188,'KAB. BEKASI',172,'32','16'),
(189,'KAB. BANDUNG BARAT',172,'32','17'),
(190,'KAB. PANGANDARAN',172,'32','18'),
(191,'KOTA BOGOR',172,'32','71'),
(192,'KOTA SUKABUMI',172,'32','72'),
(193,'KOTA BANDUNG',172,'32','73'),
(194,'KOTA CIREBON',172,'32','74'),
(195,'KOTA BEKASI',172,'32','75'),
(196,'KOTA DEPOK',172,'32','76'),
(197,'KOTA CIMAHI',172,'32','77'),
(198,'KOTA TASIKMALAYA',172,'32','78'),
(199,'KOTA BANJAR',172,'32','79'),
(200,'JAWA TENGAH',NULL,'33','00'),
(201,'KAB. CILACAP',200,'33','01'),
(202,'KAB. BANYUMAS',200,'33','02'),
(203,'KAB. PURBALINGGA',200,'33','03'),
(204,'KAB. BANJARNEGARA',200,'33','04'),
(205,'KAB. KEBUMEN',200,'33','05'),
(206,'KAB. PURWOREJO',200,'33','06'),
(207,'KAB. WONOSOBO',200,'33','07'),
(208,'KAB. MAGELANG',200,'33','08'),
(209,'KAB. BOYOLALI',200,'33','09'),
(210,'KAB. KLATEN',200,'33','10'),
(211,'KAB. SUKOHARJO',200,'33','11'),
(212,'KAB. WONOGIRI',200,'33','12'),
(213,'KAB. KARANGANYAR',200,'33','13'),
(214,'KAB. SRAGEN',200,'33','14'),
(215,'KAB. GROBOGAN',200,'33','15'),
(216,'KAB. BLORA',200,'33','16'),
(217,'KAB. REMBANG',200,'33','17'),
(218,'KAB. PATI',200,'33','18'),
(219,'KAB. KUDUS',200,'33','19'),
(220,'KAB. JEPARA',200,'33','20'),
(221,'KAB. DEMAK',200,'33','21'),
(222,'KAB. SEMARANG',200,'33','22'),
(223,'KAB. TEMANGGUNG',200,'33','23'),
(224,'KAB. KENDAL',200,'33','24'),
(225,'KAB. BATANG',200,'33','25'),
(226,'KAB. PEKALONGAN',200,'33','26'),
(227,'KAB. PEMALANG',200,'33','27'),
(228,'KAB. TEGAL',200,'33','28'),
(229,'KAB. BREBES',200,'33','29'),
(230,'KOTA MAGELANG',200,'33','71'),
(231,'KOTA SURAKARTA',200,'33','72'),
(232,'KOTA SALATIGA',200,'33','73'),
(233,'KOTA SEMARANG',200,'33','74'),
(234,'KOTA PEKALONGAN',200,'33','75'),
(235,'KOTA TEGAL',200,'33','76'),
(236,'DI YOGYAKARTA',NULL,'34','00'),
(237,'KAB. KULON PROGO',236,'34','01'),
(238,'KAB. BANTUL',236,'34','02'),
(239,'KAB. GUNUNG KIDUL',236,'34','03'),
(240,'KAB. SLEMAN',236,'34','04'),
(241,'KOTA YOGYAKARTA',236,'34','71'),
(242,'JAWA TIMUR',NULL,'35','00'),
(243,'KAB. PACITAN',242,'35','01'),
(244,'KAB. PONOROGO',242,'35','02'),
(245,'KAB. TRENGGALEK',242,'35','03'),
(246,'KAB. TULUNGAGUNG',242,'35','04'),
(247,'KAB. BLITAR',242,'35','05'),
(248,'KAB. KEDIRI',242,'35','06'),
(249,'KAB. MALANG',242,'35','07'),
(250,'KAB. LUMAJANG',242,'35','08'),
(251,'KAB. JEMBER',242,'35','09'),
(252,'KAB. BANYUWANGI',242,'35','10'),
(253,'KAB. BONDOWOSO',242,'35','11'),
(254,'KAB. SITUBONDO',242,'35','12'),
(255,'KAB. PROBOLINGGO',242,'35','13'),
(256,'KAB. PASURUAN',242,'35','14'),
(257,'KAB. SIDOARJO',242,'35','15'),
(258,'KAB. MOJOKERTO',242,'35','16'),
(259,'KAB. JOMBANG',242,'35','17'),
(260,'KAB. NGANJUK',242,'35','18'),
(261,'KAB. MADIUN',242,'35','19'),
(262,'KAB. MAGETAN',242,'35','20'),
(263,'KAB. NGAWI',242,'35','21'),
(264,'KAB. BOJONEGORO',242,'35','22'),
(265,'KAB. TUBAN',242,'35','23'),
(266,'KAB. LAMONGAN',242,'35','24'),
(267,'KAB. GRESIK',242,'35','25'),
(268,'KAB. BANGKALAN',242,'35','26'),
(269,'KAB. SAMPANG',242,'35','27'),
(270,'KAB. PAMEKASAN',242,'35','28'),
(271,'KAB. SUMENEP',242,'35','29'),
(272,'KOTA KEDIRI',242,'35','71'),
(273,'KOTA BLITAR',242,'35','72'),
(274,'KOTA MALANG',242,'35','73'),
(275,'KOTA PROBOLINGGO',242,'35','74'),
(276,'KOTA PASURUAN',242,'35','75'),
(277,'KOTA MOJOKERTO',242,'35','76'),
(278,'KOTA MADIUN',242,'35','77'),
(279,'KOTA SURABAYA',242,'35','78'),
(280,'KOTA BATU',242,'35','79'),
(281,'BANTEN',NULL,'36','00'),
(282,'KAB. PANDEGLANG',281,'36','01'),
(283,'KAB. LEBAK',281,'36','02'),
(284,'KAB. TANGERANG',281,'36','03'),
(285,'KAB. SERANG',281,'36','04'),
(286,'KOTA TANGERANG',281,'36','71'),
(287,'KOTA CILEGON',281,'36','72'),
(288,'KOTA SERANG',281,'36','73'),
(289,'KOTA TANGERANG SELATAN',281,'36','74'),
(290,'BALI',NULL,'51','00'),
(291,'KAB. JEMBRANA',290,'51','01'),
(292,'KAB. TABANAN',290,'51','02'),
(293,'KAB. BADUNG',290,'51','03'),
(294,'KAB. GIANYAR',290,'51','04'),
(295,'KAB. KLUNGKUNG',290,'51','05'),
(296,'KAB. BANGLI',290,'51','06'),
(297,'KAB. KARANG ASEM',290,'51','07'),
(298,'KAB. BULELENG',290,'51','08'),
(299,'KOTA DENPASAR',290,'51','71'),
(300,'NUSA TENGGARA BARAT',NULL,'52','00'),
(301,'KAB. LOMBOK BARAT',300,'52','01'),
(302,'KAB. LOMBOK TENGAH',300,'52','02'),
(303,'KAB. LOMBOK TIMUR',300,'52','03'),
(304,'KAB. SUMBAWA',300,'52','04'),
(305,'KAB. DOMPU',300,'52','05'),
(306,'KAB. BIMA',300,'52','06'),
(307,'KAB. SUMBAWA BARAT',300,'52','07'),
(308,'KAB. LOMBOK UTARA',300,'52','08'),
(309,'KOTA MATARAM',300,'52','71'),
(310,'KOTA BIMA',300,'52','72'),
(311,'NUSA TENGGARA TIMUR',NULL,'53','00'),
(312,'KAB. SUMBA BARAT',311,'53','01'),
(313,'KAB. SUMBA TIMUR',311,'53','02'),
(314,'KAB. KUPANG',311,'53','03'),
(315,'KAB. TIMOR TENGAH SELATAN',311,'53','04'),
(316,'KAB. TIMOR TENGAH UTARA',311,'53','05'),
(317,'KAB. BELU',311,'53','06'),
(318,'KAB. ALOR',311,'53','07'),
(319,'KAB. LEMBATA',311,'53','08'),
(320,'KAB. FLORES TIMUR',311,'53','09'),
(321,'KAB. SIKKA',311,'53','10'),
(322,'KAB. ENDE',311,'53','11'),
(323,'KAB. NGADA',311,'53','12'),
(324,'KAB. MANGGARAI',311,'53','13'),
(325,'KAB. ROTE NDAO',311,'53','14'),
(326,'KAB. MANGGARAI BARAT',311,'53','15'),
(327,'KAB. SUMBA TENGAH',311,'53','16'),
(328,'KAB. SUMBA BARAT DAYA',311,'53','17'),
(329,'KAB. NAGEKEO',311,'53','18'),
(330,'KAB. MANGGARAI TIMUR',311,'53','19'),
(331,'KAB. SABU RAIJUA',311,'53','20'),
(332,'KAB. MALAKA',311,'53','21'),
(333,'KOTA KUPANG',311,'53','71'),
(334,'KALIMANTAN BARAT',NULL,'61','00'),
(335,'KAB. SAMBAS',334,'61','01'),
(336,'KAB. BENGKAYANG',334,'61','02'),
(337,'KAB. LANDAK',334,'61','03'),
(338,'KAB. MEMPAWAH',334,'61','04'),
(339,'KAB. SANGGAU',334,'61','05'),
(340,'KAB. KETAPANG',334,'61','06'),
(341,'KAB. SINTANG',334,'61','07'),
(342,'KAB. KAPUAS HULU',334,'61','08'),
(343,'KAB. SEKADAU',334,'61','09'),
(344,'KAB. MELAWI',334,'61','10'),
(345,'KAB. KAYONG UTARA',334,'61','11'),
(346,'KAB. KUBU RAYA',334,'61','12'),
(347,'KOTA PONTIANAK',334,'61','71'),
(348,'KOTA SINGKAWANG',334,'61','72'),
(349,'KALIMANTAN TENGAH',NULL,'62','00'),
(350,'KAB. KOTAWARINGIN BARAT',349,'62','01'),
(351,'KAB. KOTAWARINGIN TIMUR',349,'62','02'),
(352,'KAB. KAPUAS',349,'62','03'),
(353,'KAB. BARITO SELATAN',349,'62','04'),
(354,'KAB. BARITO UTARA',349,'62','05'),
(355,'KAB. SUKAMARA',349,'62','06'),
(356,'KAB. LAMANDAU',349,'62','07'),
(357,'KAB. SERUYAN',349,'62','08'),
(358,'KAB. KATINGAN',349,'62','09'),
(359,'KAB. PULANG PISAU',349,'62','10'),
(360,'KAB. GUNUNG MAS',349,'62','11'),
(361,'KAB. BARITO TIMUR',349,'62','12'),
(362,'KAB. MURUNG RAYA',349,'62','13'),
(363,'KOTA PALANGKA RAYA',349,'62','71'),
(364,'KALIMANTAN SELATAN',NULL,'63','00'),
(365,'KAB. TANAH LAUT',364,'63','01'),
(366,'KAB. KOTA BARU',364,'63','02'),
(367,'KAB. BANJAR',364,'63','03'),
(368,'KAB. BARITO KUALA',364,'63','04'),
(369,'KAB. TAPIN',364,'63','05'),
(370,'KAB. HULU SUNGAI SELATAN',364,'63','06'),
(371,'KAB. HULU SUNGAI TENGAH',364,'63','07'),
(372,'KAB. HULU SUNGAI UTARA',364,'63','08'),
(373,'KAB. TABALONG',364,'63','09'),
(374,'KAB. TANAH BUMBU',364,'63','10'),
(375,'KAB. BALANGAN',364,'63','11'),
(376,'KOTA BANJARMASIN',364,'63','71'),
(377,'KOTA BANJAR BARU',364,'63','72'),
(378,'KALIMANTAN TIMUR',NULL,'64','00'),
(379,'KAB. PASER',378,'64','01'),
(380,'KAB. KUTAI BARAT',378,'64','02'),
(381,'KAB. KUTAI KARTANEGARA',378,'64','03'),
(382,'KAB. KUTAI TIMUR',378,'64','04'),
(383,'KAB. BERAU',378,'64','05'),
(384,'KAB. PENAJAM PASER UTARA',378,'64','09'),
(385,'KAB. MAHAKAM HULU',378,'64','11'),
(386,'KOTA BALIKPAPAN',378,'64','71'),
(387,'KOTA SAMARINDA',378,'64','72'),
(388,'KOTA BONTANG',378,'64','74'),
(389,'KALIMANTAN UTARA',NULL,'65','00'),
(390,'KAB. MALINAU',389,'65','01'),
(391,'KAB. BULUNGAN',389,'65','02'),
(392,'KAB. TANA TIDUNG',389,'65','03'),
(393,'KAB. NUNUKAN',389,'65','04'),
(394,'KOTA TARAKAN',389,'65','71'),
(395,'SULAWESI UTARA',NULL,'71','00'),
(396,'KAB. BOLAANG MONGONDOW',395,'71','01'),
(397,'KAB. MINAHASA',395,'71','02'),
(398,'KAB. KEPULAUAN SANGIHE',395,'71','03'),
(399,'KAB. KEPULAUAN TALAUD',395,'71','04'),
(400,'KAB. MINAHASA SELATAN',395,'71','05'),
(401,'KAB. MINAHASA UTARA',395,'71','06'),
(402,'KAB. BOLAANG MONGONDOW UTARA',395,'71','07'),
(403,'KAB. SIAU TAGULANDANG BIARO',395,'71','08'),
(404,'KAB. MINAHASA TENGGARA',395,'71','09'),
(405,'KAB. BOLAANG MONGONDOW SELATAN',395,'71','10'),
(406,'KAB. BOLAANG MONGONDOW TIMUR',395,'71','11'),
(407,'KOTA MANADO',395,'71','71'),
(408,'KOTA BITUNG',395,'71','72'),
(409,'KOTA TOMOHON',395,'71','73'),
(410,'KOTA KOTAMOBAGU',395,'71','74'),
(411,'SULAWESI TENGAH',NULL,'72','00'),
(412,'KAB. BANGGAI KEPULAUAN',411,'72','01'),
(413,'KAB. BANGGAI',411,'72','02'),
(414,'KAB. MOROWALI',411,'72','03'),
(415,'KAB. POSO',411,'72','04'),
(416,'KAB. DONGGALA',411,'72','05'),
(417,'KAB. TOLI-TOLI',411,'72','06'),
(418,'KAB. BUOL',411,'72','07'),
(419,'KAB. PARIGI MOUTONG',411,'72','08'),
(420,'KAB. TOJO UNA-UNA',411,'72','09'),
(421,'KAB. SIGI',411,'72','10'),
(422,'KAB. BANGGAI LAUT',411,'72','11'),
(423,'KAB. MOROWALI UTARA',411,'72','12'),
(424,'KOTA PALU',411,'72','71'),
(425,'SULAWESI SELATAN',NULL,'73','00'),
(426,'KAB. KEPULAUAN SELAYAR',425,'73','01'),
(427,'KAB. BULUKUMBA',425,'73','02'),
(428,'KAB. BANTAENG',425,'73','03'),
(429,'KAB. JENEPONTO',425,'73','04'),
(430,'KAB. TAKALAR',425,'73','05'),
(431,'KAB. GOWA',425,'73','06'),
(432,'KAB. SINJAI',425,'73','07'),
(433,'KAB. MAROS',425,'73','08'),
(434,'KAB. PANGKAJENE DAN KEPULAUAN',425,'73','09'),
(435,'KAB. BARRU',425,'73','10'),
(436,'KAB. BONE',425,'73','11'),
(437,'KAB. SOPPENG',425,'73','12'),
(438,'KAB. WAJO',425,'73','13'),
(439,'KAB. SIDENRENG RAPPANG',425,'73','14'),
(440,'KAB. PINRANG',425,'73','15'),
(441,'KAB. ENREKANG',425,'73','16'),
(442,'KAB. LUWU',425,'73','17'),
(443,'KAB. TANA TORAJA',425,'73','18'),
(444,'KAB. LUWU UTARA',425,'73','22'),
(445,'KAB. LUWU TIMUR',425,'73','25'),
(446,'KAB. TORAJA UTARA',425,'73','26'),
(447,'KOTA MAKASSAR',425,'73','71'),
(448,'KOTA PAREPARE',425,'73','72'),
(449,'KOTA PALOPO',425,'73','73'),
(450,'SULAWESI TENGGARA',NULL,'74','00'),
(451,'KAB. BUTON',450,'74','01'),
(452,'KAB. MUNA',450,'74','02'),
(453,'KAB. KONAWE',450,'74','03'),
(454,'KAB. KOLAKA',450,'74','04'),
(455,'KAB. KONAWE SELATAN',450,'74','05'),
(456,'KAB. BOMBANA',450,'74','06'),
(457,'KAB. WAKATOBI',450,'74','07'),
(458,'KAB. KOLAKA UTARA',450,'74','08'),
(459,'KAB. BUTON UTARA',450,'74','09'),
(460,'KAB. KONAWE UTARA',450,'74','10'),
(461,'KAB. KOLAKA TIMUR',450,'74','11'),
(462,'KAB. KONAWE KEPULAUAN',450,'74','12'),
(463,'KAB. MUNA BARAT',450,'74','13'),
(464,'KAB. BUTON TENGAH',450,'74','14'),
(465,'KAB. BUTON SELATAN',450,'74','15'),
(466,'KOTA KENDARI',450,'74','71'),
(467,'KOTA BAUBAU',450,'74','72'),
(468,'GORONTALO',NULL,'75','00'),
(469,'KAB. BOALEMO',468,'75','01'),
(470,'KAB. GORONTALO',468,'75','02'),
(471,'KAB. POHUWATO',468,'75','03'),
(472,'KAB. BONE BOLANGO',468,'75','04'),
(473,'KAB. GORONTALO UTARA',468,'75','05'),
(474,'KOTA GORONTALO',468,'75','71'),
(475,'SULAWESI BARAT',NULL,'76','00'),
(476,'KAB. MAJENE',475,'76','01'),
(477,'KAB. POLEWALI MANDAR',475,'76','02'),
(478,'KAB. MAMASA',475,'76','03'),
(479,'KAB. MAMUJU',475,'76','04'),
(480,'KAB. MAMUJU UTARA',475,'76','05'),
(481,'KAB. MAMUJU TENGAH',475,'76','06'),
(482,'MALUKU',NULL,'81','00'),
(483,'KAB. MALUKU TENGGARA BARAT',482,'81','01'),
(484,'KAB. MALUKU TENGGARA',482,'81','02'),
(485,'KAB. MALUKU TENGAH',482,'81','03'),
(486,'KAB. BURU',482,'81','04'),
(487,'KAB. KEPULAUAN ARU',482,'81','05'),
(488,'KAB. SERAM BAGIAN BARAT',482,'81','06'),
(489,'KAB. SERAM BAGIAN TIMUR',482,'81','07'),
(490,'KAB. MALUKU BARAT DAYA',482,'81','08'),
(491,'KAB. BURU SELATAN',482,'81','09'),
(492,'KOTA AMBON',482,'81','71'),
(493,'KOTA TUAL',482,'81','72'),
(494,'MALUKU UTARA',NULL,'82','00'),
(495,'KAB. HALMAHERA BARAT',494,'82','01'),
(496,'KAB. HALMAHERA TENGAH',494,'82','02'),
(497,'KAB. KEPULAUAN SULA',494,'82','03'),
(498,'KAB. HALMAHERA SELATAN',494,'82','04'),
(499,'KAB. HALMAHERA UTARA',494,'82','05'),
(500,'KAB. HALMAHERA TIMUR',494,'82','06'),
(501,'KAB. PULAU MOROTAI',494,'82','07'),
(502,'KAB. PULAU TALIABU',494,'82','08'),
(503,'KOTA TERNATE',494,'82','71'),
(504,'KOTA TIDORE KEPULAUAN',494,'82','72'),
(505,'PAPUA BARAT',NULL,'91','00'),
(506,'KAB. FAKFAK',505,'91','01'),
(507,'KAB. KAIMANA',505,'91','02'),
(508,'KAB. TELUK WONDAMA',505,'91','03'),
(509,'KAB. TELUK BINTUNI',505,'91','04'),
(510,'KAB. MANOKWARI',505,'91','05'),
(511,'KAB. SORONG SELATAN',505,'91','06'),
(512,'KAB. SORONG',505,'91','07'),
(513,'KAB. RAJA AMPAT',505,'91','08'),
(514,'KAB. TAMBRAUW',505,'91','09'),
(515,'KAB. MAYBRAT',505,'91','10'),
(516,'KAB. MANOKWARI SELATAN',505,'91','11'),
(517,'KAB. PEGUNUNGAN ARFAK',505,'91','12'),
(518,'KOTA SORONG',505,'91','71'),
(519,'PAPUA',NULL,'94','00'),
(520,'KAB. MERAUKE',519,'94','01'),
(521,'KAB. JAYAWIJAYA',519,'94','02'),
(522,'KAB. JAYAPURA',519,'94','03'),
(523,'KAB. NABIRE',519,'94','04'),
(524,'KAB. KEPULAUAN YAPEN',519,'94','08'),
(525,'KAB. BIAK NUMFOR',519,'94','09'),
(526,'KAB. PANIAI',519,'94','10'),
(527,'KAB. PUNCAK JAYA',519,'94','11'),
(528,'KAB. MIMIKA',519,'94','12'),
(529,'KAB. BOVEN DIGOEL',519,'94','13'),
(530,'KAB. MAPPI',519,'94','14'),
(531,'KAB. ASMAT',519,'94','15'),
(532,'KAB. YAHUKIMO',519,'94','16'),
(533,'KAB. PEGUNUNGAN BINTANG',519,'94','17'),
(534,'KAB. TOLIKARA',519,'94','18'),
(535,'KAB. SARMI',519,'94','19'),
(536,'KAB. KEEROM',519,'94','20'),
(537,'KAB. WAROPEN',519,'94','26'),
(538,'KAB. SUPIORI',519,'94','27'),
(539,'KAB. MAMBERAMO RAYA',519,'94','28'),
(540,'KAB. NDUGA',519,'94','29'),
(541,'KAB. LANNY JAYA',519,'94','30'),
(542,'KAB. MAMBERAMO TENGAH',519,'94','31'),
(543,'KAB. YALIMO',519,'94','32'),
(544,'KAB. PUNCAK',519,'94','33'),
(545,'KAB. DOGIYAI',519,'94','34'),
(546,'KAB. INTAN JAYA',519,'94','35'),
(547,'KAB. DEIYAI',519,'94','36'),
(548,'KOTA JAYAPURA',519,'94','71');

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
