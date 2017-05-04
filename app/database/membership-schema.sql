--
-- Table structure for table `career_levels`
--

CREATE TABLE IF NOT EXISTS `career_levels` (
  `career_level_id` varchar(16) NOT NULL,
  `order_by` int(11) NOT NULL,
  PRIMARY KEY (`career_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `functionals`
--

CREATE TABLE IF NOT EXISTS `functionals` (
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

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE IF NOT EXISTS `industries` (
  `industry_id` int(11) NOT NULL AUTO_INCREMENT,
  `industry_name` varchar(128) NOT NULL,
  PRIMARY KEY (`industry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `job_id` varchar(16) NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members_portfolios`
--

CREATE TABLE IF NOT EXISTS `members_portfolios` (
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

-- --------------------------------------------------------

--
-- Table structure for table `members_profiles`
--

CREATE TABLE IF NOT EXISTS `members_profiles` (
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

-- --------------------------------------------------------

--
-- Table structure for table `members_skills`
--

CREATE TABLE IF NOT EXISTS `members_skills` (
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

-- --------------------------------------------------------

--
-- Table structure for table `members_socmeds`
--

CREATE TABLE IF NOT EXISTS `members_socmeds` (
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

-- --------------------------------------------------------

--
-- Table structure for table `regionals`
--

CREATE TABLE IF NOT EXISTS `regionals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regional_name` varchar(64) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `province_code` varchar(4) NOT NULL,
  `city_code` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE IF NOT EXISTS `religions` (
  `religion_id` int(11) NOT NULL AUTO_INCREMENT,
  `religion_name` varchar(32) NOT NULL,
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` varchar(16) NOT NULL DEFAULT '',
  `title_alias` varchar(64) DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles_access`
--

CREATE TABLE IF NOT EXISTS `roles_access` (
  `role_access_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `functional_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`role_access_id`),
  UNIQUE KEY `rid_fid_unique` (`role_id`,`functional_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `skill_name` varchar(256) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `last_login` datetime DEFAULT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uname_email_unique` (`username`,`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_activations`
--

CREATE TABLE IF NOT EXISTS `users_activations` (
  `user_activation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activation_key` varchar(32) NOT NULL,
  `expired_date` datetime NOT NULL,
  `email_sent` char(1) NOT NULL DEFAULT 'N',
  `created` datetime NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_activation_id`),
  UNIQUE KEY `uid_actkey_unique` (`user_id`,`activation_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_reset_pwd`
--

CREATE TABLE IF NOT EXISTS `users_reset_pwd` (
  `user_reset_pwd_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reset_key` varchar(32) NOT NULL,
  `expired_date` datetime NOT NULL,
  `email_sent` char(1) NOT NULL DEFAULT 'N',
  `created` datetime NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_reset_pwd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` varchar(16) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_role_id`),
  UNIQUE KEY `uid_rid_unique` (`user_id`,`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
