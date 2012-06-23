-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 23, 2012 at 03:02 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rakbuku`
--

-- --------------------------------------------------------

--
-- Table structure for table `rb_activities`
--

CREATE TABLE `rb_activities` (
  `activity_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `activity` varchar(255) NOT NULL DEFAULT '',
  `activity_type` varchar(50) NOT NULL DEFAULT '',
  `activity_date` datetime NOT NULL,
  `activity_affected` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_activities`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_admin_review`
--

CREATE TABLE `rb_admin_review` (
  `admin_review_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `admin_review_date` datetime NOT NULL,
  `admin_review_content` text NOT NULL,
  `admin_review_parent` bigint(20) unsigned DEFAULT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_admin_review`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_attachment`
--

CREATE TABLE `rb_attachment` (
  `attachment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_url` varchar(255) NOT NULL,
  `attachment_file` varchar(255) NOT NULL DEFAULT '',
  `attachment_file_ext` varchar(20) NOT NULL DEFAULT '',
  `attachment_file_path` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_attachment`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_attachment_meta`
--

CREATE TABLE `rb_attachment_meta` (
  `attachment_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`attachment_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_attachment_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_attachment_versions`
--

CREATE TABLE `rb_attachment_versions` (
  `attachment_id` bigint(20) unsigned NOT NULL,
  `version_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_attachment_versions`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_ci_sessions`
--

CREATE TABLE `rb_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_ci_sessions`
--

INSERT INTO `rb_ci_sessions` VALUES('5a1477fe12da7e0d8283b6286bf68cdd', '0.0.0.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', 1340369137, '');
INSERT INTO `rb_ci_sessions` VALUES('7faf905542d6e2df92a6ab3721497636', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', 1340234583, 'a:13:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:10:"user_email";s:19:"dwiash@hasriyan.com";s:15:"user_unique_url";s:7:"pratama";s:19:"user_activation_key";s:20:"pratama4f6bad884f6f1";s:12:"current_user";s:7:"pratama";s:6:"jur_id";s:1:"1";s:9:"firstname";s:3:"Dwi";s:10:"middlename";s:10:"Asharialdy";s:8:"lastname";s:7:"Hambali";s:8:"fullname";s:22:"Dwi Asharialdy Hambali";s:9:"logged_in";b:1;s:9:"role_name";s:5:"admin";}');

-- --------------------------------------------------------

--
-- Table structure for table `rb_comments`
--

CREATE TABLE `rb_comments` (
  `comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_content` longtext NOT NULL,
  `comment_parent` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_comments_meta`
--

CREATE TABLE `rb_comments_meta` (
  `comment_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext NOT NULL,
  PRIMARY KEY (`comment_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_comments_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_fakultas`
--

CREATE TABLE `rb_fakultas` (
  `fak_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fak_name` varchar(50) NOT NULL,
  PRIMARY KEY (`fak_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `rb_fakultas`
--

INSERT INTO `rb_fakultas` VALUES(1, 'Sains dan Teknologi');
INSERT INTO `rb_fakultas` VALUES(2, 'Dakwah');
INSERT INTO `rb_fakultas` VALUES(3, 'Syariah');
INSERT INTO `rb_fakultas` VALUES(70, 'hukum');
INSERT INTO `rb_fakultas` VALUES(71, 'psikologi');
INSERT INTO `rb_fakultas` VALUES(73, 'kedokteran gigi');
INSERT INTO `rb_fakultas` VALUES(78, 'psikologi islam');
INSERT INTO `rb_fakultas` VALUES(82, 'Muamalah');

-- --------------------------------------------------------

--
-- Table structure for table `rb_invitation`
--

CREATE TABLE `rb_invitation` (
  `invitation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invitation_code` varchar(200) NOT NULL,
  `invitation_name` varchar(200) DEFAULT '',
  `invitation_email` varchar(60) NOT NULL,
  `invitation_date` datetime NOT NULL,
  `invite_by` bigint(20) unsigned NOT NULL,
  `invitation_status` varchar(50) NOT NULL DEFAULT 'pending',
  `invitation_for` varchar(10) NOT NULL DEFAULT 'member',
  `invitation_project` bigint(20) DEFAULT NULL,
  `invitation_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`invitation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_invitation`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_jurusan`
--

CREATE TABLE `rb_jurusan` (
  `jur_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jur_name` varchar(50) NOT NULL,
  `fak_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`jur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `rb_jurusan`
--

INSERT INTO `rb_jurusan` VALUES(1, 'teknik informatika', 1);
INSERT INTO `rb_jurusan` VALUES(2, 'matematika', 1);
INSERT INTO `rb_jurusan` VALUES(3, 'Biologi', 1);
INSERT INTO `rb_jurusan` VALUES(4, 'Fisikaa', 1);
INSERT INTO `rb_jurusan` VALUES(5, 'ilmu dakwah', 71);
INSERT INTO `rb_jurusan` VALUES(9, 'kimia', 1);
INSERT INTO `rb_jurusan` VALUES(21, 'hukum islam', 1);
INSERT INTO `rb_jurusan` VALUES(22, 'hehe', 71);
INSERT INTO `rb_jurusan` VALUES(37, 'Fisika', 1);
INSERT INTO `rb_jurusan` VALUES(39, 'Teknik Elektro', 1);
INSERT INTO `rb_jurusan` VALUES(40, 'Teknik Mesin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rb_page_config`
--

CREATE TABLE `rb_page_config` (
  `page_config_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_config_page` varchar(100) NOT NULL,
  `page_config_name` varchar(100) NOT NULL,
  `page_config_content` longtext NOT NULL,
  `page_config_status` varchar(10) NOT NULL DEFAULT 'inactive',
  `page_config_config` text NOT NULL,
  PRIMARY KEY (`page_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_page_config`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_projects`
--

CREATE TABLE `rb_projects` (
  `project_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_title` varchar(255) NOT NULL,
  `project_chapters` int(11) DEFAULT NULL,
  `project_chapter_num` int(11) DEFAULT NULL,
  `project_content` longtext NOT NULL,
  `project_is_parent` varchar(5) DEFAULT 'no',
  `project_parent` bigint(20) unsigned DEFAULT NULL,
  `project_made` datetime NOT NULL,
  `project_published` datetime DEFAULT NULL,
  `project_status` varchar(20) NOT NULL DEFAULT 'created',
  `project_attachment_count` int(11) DEFAULT NULL,
  `project_downloadable` varchar(5) NOT NULL DEFAULT 'yes',
  `project_year` year(4) NOT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `project_author` text NOT NULL,
  `project_reviewer` text,
  `project_jurusan` varchar(100) NOT NULL DEFAULT '',
  `project_fakultas` varchar(100) NOT NULL DEFAULT '',
  `project_strata` varchar(4) NOT NULL DEFAULT '',
  `project_url` varchar(255) NOT NULL DEFAULT '',
  `project_url_edited` varchar(255) DEFAULT NULL,
  `project_keywords` text,
  `project_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_projects_fw`
--

CREATE TABLE `rb_projects_fw` (
  `project_fw_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` bigint(20) unsigned NOT NULL,
  `fw` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`project_fw_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `rb_projects_fw`
--

INSERT INTO `rb_projects_fw` VALUES(45, 10, 'a:4:{i:0;s:13:"pilih project";i:1;s:21:"isi form project baru";i:2;s:12:"admin review";i:3;s:20:"publikasikan project";}');
INSERT INTO `rb_projects_fw` VALUES(50, 1, 'a:6:{i:0;s:13:"pilih project";i:1;s:21:"isi form project baru";i:2;s:28:"undang reviewer/collaborator";i:3;s:20:"review/collaboration";i:4;s:12:"admin review";i:5;s:20:"publikasikan project";}');
INSERT INTO `rb_projects_fw` VALUES(51, 2, 'a:6:{i:0;s:13:"pilih project";i:1;s:21:"isi form project baru";i:2;s:28:"undang reviewer/collaborator";i:3;s:20:"review/collaboration";i:4;s:12:"admin review";i:5;s:20:"publikasikan project";}');
INSERT INTO `rb_projects_fw` VALUES(52, 3, 'a:6:{i:0;s:13:"pilih project";i:1;s:21:"isi form project baru";i:2;s:28:"undang reviewer/collaborator";i:3;s:20:"review/collaboration";i:4;s:12:"admin review";i:5;s:20:"publikasikan project";}');
INSERT INTO `rb_projects_fw` VALUES(53, 4, 'a:6:{i:0;s:13:"pilih project";i:1;s:21:"isi form project baru";i:2;s:28:"undang reviewer/collaborator";i:3;s:20:"review/collaboration";i:4;s:12:"admin review";i:5;s:20:"publikasikan project";}');
INSERT INTO `rb_projects_fw` VALUES(54, 5, 'a:6:{i:0;s:13:"pilih project";i:1;s:21:"isi form project baru";i:2;s:28:"undang reviewer/collaborator";i:3;s:20:"review/collaboration";i:4;s:12:"admin review";i:5;s:20:"publikasikan project";}');

-- --------------------------------------------------------

--
-- Table structure for table `rb_projects_state`
--

CREATE TABLE `rb_projects_state` (
  `project_state_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `project_state` varchar(100) DEFAULT NULL,
  `project_state_next_state` varchar(100) DEFAULT NULL,
  `project_state_next_url` varchar(100) DEFAULT NULL,
  `project_state_fw` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`project_state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_projects_state`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_project_meta`
--

CREATE TABLE `rb_project_meta` (
  `project_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`project_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_project_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_review`
--

CREATE TABLE `rb_review` (
  `review_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `review_date` datetime NOT NULL,
  `review_content` text NOT NULL,
  `review_parent` bigint(20) unsigned DEFAULT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_review`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_reviewer`
--

CREATE TABLE `rb_reviewer` (
  `reviewer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `reviewer_status` varchar(20) DEFAULT 'active',
  `project_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`reviewer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_reviewer`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_review_meta`
--

CREATE TABLE `rb_review_meta` (
  `review_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `review_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`review_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_review_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_role`
--

CREATE TABLE `rb_role` (
  `role_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rb_role`
--

INSERT INTO `rb_role` VALUES(1, 'admin');
INSERT INTO `rb_role` VALUES(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `rb_site_settings`
--

CREATE TABLE `rb_site_settings` (
  `site_settings_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_settings_key` varchar(255) NOT NULL DEFAULT '',
  `site_settings_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`site_settings_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `rb_site_settings`
--

INSERT INTO `rb_site_settings` VALUES(2, 'ID Publisher', 'JBPTUIN');
INSERT INTO `rb_site_settings` VALUES(3, 'Email CKO', 'cenura@gmail.com');
INSERT INTO `rb_site_settings` VALUES(4, 'Nama Kontak', 'Cecep Nurul Alam. ST., MT.');
INSERT INTO `rb_site_settings` VALUES(5, 'Alamat', 'Jl. Raya Cipadung No. 105');
INSERT INTO `rb_site_settings` VALUES(6, 'Kota', 'Bandung');
INSERT INTO `rb_site_settings` VALUES(7, 'Provinsi', 'Jawa Barat');
INSERT INTO `rb_site_settings` VALUES(8, 'Negara', 'Indonesia');
INSERT INTO `rb_site_settings` VALUES(9, 'Telepon', '62-22-780052');
INSERT INTO `rb_site_settings` VALUES(10, 'Fax', '62-22-780052');
INSERT INTO `rb_site_settings` VALUES(11, 'Email Admin', 'magnoworks@hasriyan.com');

-- --------------------------------------------------------

--
-- Table structure for table `rb_topic`
--

CREATE TABLE `rb_topic` (
  `topic_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(50) NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rb_topic`
--

INSERT INTO `rb_topic` VALUES(1, 'RPL');
INSERT INTO `rb_topic` VALUES(3, 'web programming');
INSERT INTO `rb_topic` VALUES(4, 'artificial intelligent');
INSERT INTO `rb_topic` VALUES(6, 'hmmm');

-- --------------------------------------------------------

--
-- Table structure for table `rb_topic_projects`
--

CREATE TABLE `rb_topic_projects` (
  `topic_id` bigint(20) unsigned NOT NULL,
  `project_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_topic_projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_type`
--

CREATE TABLE `rb_type` (
  `type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  `type_slug` varchar(50) NOT NULL DEFAULT '',
  `type_need_reviewer` int(11) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rb_type`
--

INSERT INTO `rb_type` VALUES(1, 'Jurnal', 'jurnal', NULL);
INSERT INTO `rb_type` VALUES(2, 'Skripsi', 'skripsi', NULL);
INSERT INTO `rb_type` VALUES(3, 'Tesis', 'tesis', NULL);
INSERT INTO `rb_type` VALUES(4, 'Disertasi', 'disertasi', NULL);
INSERT INTO `rb_type` VALUES(5, 'Laporan Kerja Praktik', 'laporan-kerja-praktik', NULL);
INSERT INTO `rb_type` VALUES(10, 'Materi Kuliah', 'materi-kuliah', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rb_user`
--

CREATE TABLE `rb_user` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(60) NOT NULL,
  `user_pass` varchar(64) NOT NULL,
  `user_registered` datetime NOT NULL,
  `user_activation_key` varchar(200) NOT NULL,
  `jur_id` bigint(20) unsigned DEFAULT NULL,
  `user_unique_url` varchar(20) DEFAULT NULL,
  `user_firstname` varchar(20) NOT NULL,
  `user_middlename` varchar(20) DEFAULT NULL,
  `user_lastname` varchar(20) DEFAULT NULL,
  `user_front_title` varchar(40) DEFAULT NULL,
  `user_back_title` varchar(40) DEFAULT NULL,
  `user_status` varchar(20) DEFAULT 'inactive',
  `user_invite_quota` int(2) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `rb_user`
--

INSERT INTO `rb_user` VALUES(1, 'dwiash@hasriyan.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-02-06 10:24:57', 'pratama4f6bad884f6f1', 1, 'pratama', 'Dwi', 'Asharialdy', 'Hambali', NULL, 'S.Kom.', 'active', 0);
INSERT INTO `rb_user` VALUES(38, 'pratama@hasriyan.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-14 10:38:44', '8e034c26d43c7b479c32a411c54a847f', NULL, 'prat', 'Pratama', 'Hasriyan', 'Salahudin', NULL, NULL, 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rb_user_meta`
--

CREATE TABLE `rb_user_meta` (
  `user_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`user_meta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `rb_user_meta`
--

INSERT INTO `rb_user_meta` VALUES(7, 2, 'alamat', 'cipageran');
INSERT INTO `rb_user_meta` VALUES(8, 2, 'bio', 'just mea');
INSERT INTO `rb_user_meta` VALUES(9, 2, 's1', 'a:3:{s:13:"pendidikan_s1";s:30:"UIN Sunan Gunung Djati Bandung";s:19:"pendidikan_s1_tahun";s:0:"";s:21:"pendidikan_s1_jurusan";s:18:"Teknik Informatika";}');
INSERT INTO `rb_user_meta` VALUES(10, 2, 's2', 'a:3:{s:13:"pendidikan_s2";s:0:"";s:19:"pendidikan_s2_tahun";s:0:"";s:21:"pendidikan_s2_jurusan";s:0:"";}');
INSERT INTO `rb_user_meta` VALUES(11, 2, 's3', 'a:3:{s:13:"pendidikan_s3";s:0:"";s:19:"pendidikan_s3_tahun";s:0:"";s:21:"pendidikan_s3_jurusan";s:0:"";}');
INSERT INTO `rb_user_meta` VALUES(12, 3, 'alamat', 'soreang');
INSERT INTO `rb_user_meta` VALUES(13, 3, 'bio', 'nya eta weh');
INSERT INTO `rb_user_meta` VALUES(14, 3, 's1', 'a:3:{s:13:"pendidikan_s1";s:30:"UIN Sunan Gunung Djati Bandung";s:19:"pendidikan_s1_tahun";s:4:"2010";s:21:"pendidikan_s1_jurusan";s:18:"Teknik Informatika";}');

-- --------------------------------------------------------

--
-- Table structure for table `rb_user_role`
--

CREATE TABLE `rb_user_role` (
  `role_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rb_user_role`
--

INSERT INTO `rb_user_role` VALUES(1, 1);
INSERT INTO `rb_user_role` VALUES(2, 2);
INSERT INTO `rb_user_role` VALUES(1, 14);
INSERT INTO `rb_user_role` VALUES(2, 3);
INSERT INTO `rb_user_role` VALUES(2, 27);
INSERT INTO `rb_user_role` VALUES(1, 37);
INSERT INTO `rb_user_role` VALUES(2, 38);
INSERT INTO `rb_user_role` VALUES(2, 39);

-- --------------------------------------------------------

--
-- Table structure for table `rb_versions`
--

CREATE TABLE `rb_versions` (
  `version_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version_number` bigint(20) unsigned NOT NULL DEFAULT '1',
  `project_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_versions`
--


-- --------------------------------------------------------

--
-- Table structure for table `rb_version_meta`
--

CREATE TABLE `rb_version_meta` (
  `version_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`version_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rb_version_meta`
--

