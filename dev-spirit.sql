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
-- Table structure for `skills`
-- ----------------------------
DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `skill_name` varchar(256) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of skills
-- ----------------------------
INSERT INTO `skills` VALUES ('1', null, 'Software Development', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('2', '1', 'PHP', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('3', '1', 'Java Web (JEE)', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('4', '1', 'Java Mobile Android', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('5', '1', 'Java Desktop', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('6', '1', 'Java Other', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('7', '1', 'iOS Mobile Apps Development', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('8', '1', 'Python', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('9', '1', 'Ruby', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('10', '1', 'Perl', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('11', '1', '.NET', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('12', '1', 'Scala', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('13', '1', 'Erlang', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('14', '1', 'Visual Basic 6', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('15', null, 'UI / UX', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('16', '15', 'HTML & CSS', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('17', '15', 'Javacript (ECMA Script) General', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('18', '15', 'jQuery Javascript Framework', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('19', '15', 'Other Javascript Framework', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('20', '15', 'Photoshop General', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('21', '15', 'Photoshop Web Design', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('22', '15', 'CorelDraw General', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('23', null, 'Database System', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('24', '23', 'MySQL', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('25', '23', 'PostgreSQL', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('26', '23', 'Oracle', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('27', '23', 'Microsoft SQL', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('28', '23', 'NoSQL Products', '2015-11-22 14:11:01', null, 'N');
INSERT INTO `skills` VALUES ('29', null, 'Computer Networking', null, null, 'N');
INSERT INTO `skills` VALUES ('30', '29', 'General Computer Networking', null, null, 'N');
INSERT INTO `skills` VALUES ('31', '29', 'Linux Server Administer', null, null, 'N');
INSERT INTO `skills` VALUES ('32', '29', 'Windows Server Administer', null, null, 'N');
INSERT INTO `skills` VALUES ('33', null, 'Microcontroller', null, null, 'N');
INSERT INTO `skills` VALUES ('34', '1', 'ANSI C', null, null, 'N');
INSERT INTO `skills` VALUES ('35', '1', 'C++', null, null, 'N');
INSERT INTO `skills` VALUES ('36', null, 'Software System Analyst', null, null, 'N');
INSERT INTO `skills` VALUES ('37', null, 'Computer Hardware', null, null, 'N');
INSERT INTO `skills` VALUES ('38', '37', 'Computer Assemblying', null, null, 'N');
INSERT INTO `skills` VALUES ('39', '37', 'Computer Problem Troubleshooting', null, null, 'N');
INSERT INTO `skills` VALUES ('40', '37', 'Computer Overclocking', null, null, 'N');
INSERT INTO `skills` VALUES ('41', '37', 'Printer Repair', null, null, 'N');

-- ----------------------------
-- Table structure for `members_skills`
-- ----------------------------
DROP TABLE IF EXISTS `members_skills`;
CREATE TABLE `members_skills` (
  `member_skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skill_parent_id` int(11) NOT NULL,
  `skill_self_assesment` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`member_skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
