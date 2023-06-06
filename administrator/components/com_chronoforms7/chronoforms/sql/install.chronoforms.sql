-- --------------------------------------------------------

--
-- Table structure for table `#__chronog3_acls`
--

-- CREATE TABLE IF NOT EXISTS `#__chronog3_acls` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `aco` varchar(255) NOT NULL DEFAULT '',
--   `title` varchar(255) NOT NULL DEFAULT '',
--   `enabled` tinyint(1) NOT NULL DEFAULT '0',
--   `rules` text,
--   PRIMARY KEY (`id`),
--   KEY `aco` (`aco`)
-- ) DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `#__chronog3_aclevels`
--

CREATE TABLE IF NOT EXISTS `#__chronog3_acl_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `desc` text NOT NULL,
  `rules` longtext NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__chronog3_extensions`
--

CREATE TABLE IF NOT EXISTS `#__chronog3_extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(4) NOT NULL DEFAULT '0',
  `settings` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) DEFAULT CHARSET=utf8;

--
-- Table structure for table `#__chronog3_users_service_accounts`
--

CREATE TABLE IF NOT EXISTS `#__chronog3_users_service_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `service` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `params` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `user_id` (`user_id`)
) DEFAULT CHARSET=utf8;


--
-- Table structure for table `jos_chronog3_connections`
--

CREATE TABLE IF NOT EXISTS `#__chronog3_forms7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `alias` varchar(200) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `apptype` varchar(200) NOT NULL,
  `settings` longtext NOT NULL,
  `pgroups` longtext NOT NULL,
  `pages` longtext NOT NULL,
  `views` longtext NOT NULL,
  `functions` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alias` (`alias`)
) DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__chronog3_forms7_log`
--

CREATE TABLE IF NOT EXISTS `#__chronog3_forms7_datalog` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(5) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `ipaddress` varchar(50) NOT NULL,
  `page` varchar(50) NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `uid` (`uid`),
  KEY `form_id` (`form_id`),
  KEY `user_id` (`user_id`)
) DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__chronog3_forms7_blocks`
--

-- CREATE TABLE IF NOT EXISTS `#__chronog3_forms7_blocks` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `title` varchar(255) NOT NULL,
--   `block_id` varchar(50) NOT NULL,
--   `desc` text NOT NULL,
--   `type` varchar(20) NOT NULL,
--   `group` varchar(30) NOT NULL,
--   `content` longtext NOT NULL,
--   `published` tinyint(1) NOT NULL DEFAULT 1,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `#__chronog3_forms7_locales`
--

-- CREATE TABLE IF NOT EXISTS `#__chronog3_forms7_locales` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `title` varchar(255) NOT NULL,
--   `alias` varchar(255) NOT NULL,
--   `enabled` tinyint(1) NOT NULL DEFAULT 1,
--   `desc` text NOT NULL,
--   `locales` longtext NOT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
