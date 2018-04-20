-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2018 at 07:13 AM
-- Server version: 5.6.36-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `savemar_wrdp1`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Mr WordPress', '', 'https://wordpress.org/', '', '2014-06-18 16:26:07', '2014-06-18 16:26:07', 'Hi, this is a comment.\nTo delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.', 0, '1', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://media.savemari.com', 'yes'),
(2, 'blogname', 'Zimbabwe Creative Media', 'yes'),
(3, 'blogdescription', 'Now and forever', 'yes'),
(4, 'users_can_register', '0', 'yes'),
(5, 'admin_email', 'thabo@mediafisher.co.uk', 'yes'),
(6, 'start_of_week', '1', 'yes'),
(7, 'use_balanceTags', '0', 'yes'),
(8, 'use_smilies', '1', 'yes'),
(9, 'require_name_email', '', 'yes'),
(10, 'comments_notify', '', 'yes'),
(11, 'posts_per_rss', '10', 'yes'),
(12, 'rss_use_excerpt', '0', 'yes'),
(13, 'mailserver_url', 'mail.example.com', 'yes'),
(14, 'mailserver_login', 'login@example.com', 'yes'),
(15, 'mailserver_pass', 'password', 'yes'),
(16, 'mailserver_port', '110', 'yes'),
(17, 'default_category', '1', 'yes'),
(18, 'default_comment_status', 'closed', 'yes'),
(19, 'default_ping_status', 'closed', 'yes'),
(20, 'default_pingback_flag', '', 'yes'),
(21, 'posts_per_page', '10', 'yes'),
(22, 'date_format', 'F j, Y', 'yes'),
(23, 'time_format', 'g:i a', 'yes'),
(24, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(25, 'comment_moderation', '', 'yes'),
(26, 'moderation_notify', '', 'yes'),
(27, 'permalink_structure', '/%postname%/', 'yes'),
(28, 'gzipcompression', '0', 'yes'),
(29, 'hack_file', '0', 'yes'),
(30, 'blog_charset', 'UTF-8', 'yes'),
(31, 'moderation_keys', '', 'no'),
(32, 'active_plugins', 'a:4:{i:0;s:19:\"jetpack/jetpack.php\";i:1;s:37:\"mojo-marketplace/mojo-marketplace.php\";i:2;s:55:\"ultimate-coming-soon-page/ultimate-coming-soon-page.php\";i:3;s:27:\"wp-super-cache/wp-cache.php\";}', 'yes'),
(33, 'home', 'http://media.savemari.com', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'advanced_edit', '0', 'yes'),
(37, 'comment_max_links', '2', 'yes'),
(38, 'gmt_offset', '', 'yes'),
(39, 'default_email_category', '1', 'yes'),
(40, 'recently_edited', '', 'no'),
(41, 'template', 'twentyfourteen', 'yes'),
(42, 'stylesheet', 'twentyfourteen', 'yes'),
(43, 'comment_whitelist', '1', 'yes'),
(44, 'blacklist_keys', '', 'no'),
(45, 'comment_registration', '1', 'yes'),
(46, 'html_type', 'text/html', 'yes'),
(47, 'use_trackback', '0', 'yes'),
(48, 'default_role', 'subscriber', 'yes'),
(49, 'db_version', '27918', 'yes'),
(50, 'uploads_use_yearmonth_folders', '1', 'yes'),
(51, 'upload_path', '', 'yes'),
(52, 'blog_public', '1', 'yes'),
(53, 'default_link_category', '2', 'yes'),
(54, 'show_on_front', 'posts', 'yes'),
(55, 'tag_base', '', 'yes'),
(56, 'show_avatars', '1', 'yes'),
(57, 'avatar_rating', 'G', 'yes'),
(58, 'upload_url_path', '', 'yes'),
(59, 'thumbnail_size_w', '150', 'yes'),
(60, 'thumbnail_size_h', '150', 'yes'),
(61, 'thumbnail_crop', '1', 'yes'),
(62, 'medium_size_w', '300', 'yes'),
(63, 'medium_size_h', '300', 'yes'),
(64, 'avatar_default', 'mystery', 'yes'),
(65, 'large_size_w', '1024', 'yes'),
(66, 'large_size_h', '1024', 'yes'),
(67, 'image_default_link_type', 'file', 'yes'),
(68, 'image_default_size', '', 'yes'),
(69, 'image_default_align', '', 'yes'),
(70, 'close_comments_for_old_posts', '', 'yes'),
(71, 'close_comments_days_old', '14', 'yes'),
(72, 'thread_comments', '1', 'yes'),
(73, 'thread_comments_depth', '5', 'yes'),
(74, 'page_comments', '', 'yes'),
(75, 'comments_per_page', '50', 'yes'),
(76, 'default_comments_page', 'newest', 'yes'),
(77, 'comment_order', 'asc', 'yes'),
(78, 'sticky_posts', 'a:0:{}', 'yes'),
(79, 'widget_categories', 'a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(80, 'widget_text', 'a:0:{}', 'yes'),
(81, 'widget_rss', 'a:0:{}', 'yes'),
(82, 'uninstall_plugins', 'a:1:{s:27:\"wp-super-cache/wp-cache.php\";s:23:\"wpsupercache_deactivate\";}', 'no'),
(83, 'timezone_string', 'Europe/London', 'yes'),
(84, 'page_for_posts', '0', 'yes'),
(85, 'page_on_front', '0', 'yes'),
(86, 'default_post_format', '0', 'yes'),
(87, 'link_manager_enabled', '0', 'yes'),
(88, 'initial_db_version', '27916', 'yes'),
(89, 'wp_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:9:\"add_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(90, 'widget_search', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(91, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(92, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(93, 'widget_archives', 'a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(94, 'widget_meta', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(95, 'sidebars_widgets', 'a:5:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}s:13:\"array_version\";i:3;}', 'yes'),
(96, 'cron', 'a:9:{i:1506186859;a:1:{s:11:\"wp_cache_gc\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:2:{s:8:\"schedule\";b:0;s:4:\"args\";a:0:{}}}}i:1506187454;a:1:{s:20:\"jetpack_clean_nonces\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1506187607;a:1:{s:14:\"mm_cron_hourly\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1506188113;a:1:{s:19:\"wp_cache_gc_watcher\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1506219805;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1506227206;a:1:{s:18:\"mm_cron_twicedaily\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1506263010;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1506270406;a:1:{s:13:\"mm_cron_daily\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}', 'yes'),
(128, 'jetpack_activated', '1', 'yes'),
(129, 'jetpack_options', 'a:2:{s:7:\"version\";s:16:\"2.9.3:1399904654\";s:11:\"old_version\";s:16:\"2.9.3:1399904654\";}', 'yes'),
(130, 'recently_activated', 'a:0:{}', 'yes'),
(132, 'ossdl_off_cdn_url', 'http://media.savemari.com', 'yes'),
(133, 'ossdl_off_include_dirs', 'wp-content,wp-includes', 'yes'),
(134, 'ossdl_off_exclude', '.php', 'yes'),
(135, 'ossdl_cname', '', 'yes'),
(136, 'wpsupercache_start', '1399904671', 'yes'),
(137, 'wpsupercache_count', '0', 'yes'),
(142, 'mm_master_aff', 'hostgator', 'yes'),
(143, 'mm_install_date', 'Jun 18, 2014', 'yes'),
(170, 'wpsupercache_gc_time', '1506186259', 'yes'),
(182, '_transient_is_multi_author', '0', 'yes'),
(183, 'seedprod_comingsoon_options', 'a:16:{s:18:\"comingsoon_enabled\";a:1:{i:0;s:1:\"1\";}s:16:\"comingsoon_image\";s:74:\"http://media.savemari.com/wp-content/uploads/2014/06/SAVE-MARI_WEB_new.png\";s:19:\"comingsoon_headline\";s:0:\"\";s:22:\"comingsoon_description\";s:0:\"\";s:22:\"comingsoon_mailinglist\";s:4:\"none\";s:29:\"comingsoon_feedburner_address\";s:0:\"\";s:21:\"comingsoon_customhtml\";s:0:\"\";s:26:\"comingsoon_custom_bg_color\";s:7:\"#ffffff\";s:34:\"comingsoon_background_noise_effect\";s:2:\"on\";s:26:\"comingsoon_custom_bg_image\";s:0:\"\";s:21:\"comingsoon_font_color\";s:5:\"black\";s:29:\"comingsoon_text_shadow_effect\";s:2:\"on\";s:24:\"comingsoon_headline_font\";s:0:\"\";s:20:\"comingsoon_body_font\";s:7:\"empty_0\";s:21:\"comingsoon_custom_css\";s:0:\"\";s:24:\"comingsoon_footer_credit\";s:1:\"0\";}', 'yes'),
(189, '_transient_twentyfourteen_category_count', '1', 'yes'),
(866, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:23:\"thabo@mediafisher.co.uk\";s:7:\"version\";s:6:\"3.9.20\";s:9:\"timestamp\";i:1505874216;}', 'yes'),
(6208, 'db_upgraded', '', 'yes'),
(9827, 'rewrite_rules', 'a:68:{s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:20:\"(.?.+?)(/[0-9]+)?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:20:\"([^/]+)(/[0-9]+)?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";}', 'yes'),
(23649, '_site_transient_timeout_ghu-1eda13567dd0e7ce35b07e674764d1ef', '1505668203', 'yes'),
(23650, '_site_transient_ghu-1eda13567dd0e7ce35b07e674764d1ef', 'O:8:\"stdClass\":12:{s:4:\"name\";s:20:\"mojo-marketplace.php\";s:4:\"path\";s:20:\"mojo-marketplace.php\";s:3:\"sha\";s:40:\"654d3cc7bef6f1a99cb51eaa72f6fbc2360da6ab\";s:4:\"size\";i:1959;s:3:\"url\";s:109:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/contents/mojo-marketplace.php?ref=production\";s:8:\"html_url\";s:91:\"https://github.com/mojoness/mojo-marketplace-wp-plugin/blob/production/mojo-marketplace.php\";s:7:\"git_url\";s:115:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/blobs/654d3cc7bef6f1a99cb51eaa72f6fbc2360da6ab\";s:12:\"download_url\";s:101:\"https://raw.githubusercontent.com/mojoness/mojo-marketplace-wp-plugin/production/mojo-marketplace.php\";s:4:\"type\";s:4:\"file\";s:7:\"content\";s:2656:\"PD9waHAKLyoKUGx1Z2luIE5hbWU6IE1PSk8gTWFya2V0cGxhY2UKRGVzY3Jp\ncHRpb246IFRoaXMgcGx1Z2luIGFkZHMgc2hvcnRjb2Rlcywgd2lkZ2V0cywg\nYW5kIHRoZW1lcyB0byB5b3VyIFdvcmRQcmVzcyBzaXRlLgpWZXJzaW9uOiAx\nLjIuMwpBdXRob3I6IE1pa2UgSGFuc2VuCkF1dGhvciBVUkk6IGh0dHA6Ly9t\naWtlaGFuc2VuLm1lP3V0bV9jYW1wYWlnbj1wbHVnaW4mdXRtX3NvdXJjZT1t\nb2pvX3dwX3BsdWdpbgpMaWNlbnNlOiBHUEx2MiBvciBsYXRlcgpMaWNlbnNl\nIFVSSTogaHR0cDovL3d3dy5nbnUub3JnL2xpY2Vuc2VzL2dwbC0yLjAuaHRt\nbAoqLwoKLy8gRG8gbm90IGFjY2VzcyBmaWxlIGRpcmVjdGx5IQppZiAoICEg\nZGVmaW5lZCggJ1dQSU5DJyApICkgeyBkaWU7IH0KCmRlZmluZSggJ01NX0JB\nU0VfRElSJywgcGx1Z2luX2Rpcl9wYXRoKCBfX0ZJTEVfXyApICk7CmRlZmlu\nZSggJ01NX0JBU0VfVVJMJywgcGx1Z2luX2Rpcl91cmwoIF9fRklMRV9fICkg\nKTsKZGVmaW5lKCAnTU1fQVNTRVRTX1VSTCcsICdodHRwczovL3d3dy5tb2pv\nbWFya2V0cGxhY2UuY29tL21vam8tcGx1Z2luLWFzc2V0cy8nICk7CmRlZmlu\nZSggJ01NX1ZFUlNJT04nLCAnMS4xLjMnICk7CgpyZXF1aXJlX29uY2UoIE1N\nX0JBU0VfRElSIC4gJ2luYy9iYXNlLnBocCcgKTsKcmVxdWlyZV9vbmNlKCBN\nTV9CQVNFX0RJUiAuICdpbmMvY2hlY2tvdXQucGhwJyApOwpyZXF1aXJlX29u\nY2UoIE1NX0JBU0VfRElSIC4gJ2luYy9jaHVybi5waHAnICk7CnJlcXVpcmVf\nb25jZSggTU1fQkFTRV9ESVIgLiAnaW5jL21lbnUucGhwJyApOwpyZXF1aXJl\nX29uY2UoIE1NX0JBU0VfRElSIC4gJ2luYy9zaG9ydGNvZGUtZ2VuZXJhdG9y\nLnBocCcgKTsKcmVxdWlyZV9vbmNlKCBNTV9CQVNFX0RJUiAuICdpbmMvbW9q\nby10aGVtZXMucGhwJyApOwpyZXF1aXJlX29uY2UoIE1NX0JBU0VfRElSIC4g\nJ2luYy9zdHlsZXMucGhwJyApOwpyZXF1aXJlX29uY2UoIE1NX0JBU0VfRElS\nIC4gJ2luYy9wbHVnaW4tc2VhcmNoLnBocCcgKTsKcmVxdWlyZV9vbmNlKCBN\nTV9CQVNFX0RJUiAuICdpbmMvamV0cGFjay5waHAnICk7CnJlcXVpcmVfb25j\nZSggTU1fQkFTRV9ESVIgLiAnaW5jL3VzZXItZXhwZXJpZW5jZS10cmFja2lu\nZy5waHAnICk7CnJlcXVpcmVfb25jZSggTU1fQkFTRV9ESVIgLiAnaW5jL25v\ndGlmaWNhdGlvbnMucGhwJyApOwpyZXF1aXJlX29uY2UoIE1NX0JBU0VfRElS\nIC4gJ2luYy9zcGFtLXByZXZlbnRpb24ucGhwJyApOwpyZXF1aXJlX29uY2Uo\nIE1NX0JBU0VfRElSIC4gJ2luYy9zdGFnaW5nLnBocCcgKTsKcmVxdWlyZV9v\nbmNlKCBNTV9CQVNFX0RJUiAuICdpbmMvdXBkYXRlcy5waHAnICk7CnJlcXVp\ncmVfb25jZSggTU1fQkFTRV9ESVIgLiAnaW5jL2NvbWluZy1zb29uLnBocCcg\nKTsKcmVxdWlyZV9vbmNlKCBNTV9CQVNFX0RJUiAuICdpbmMvdGVzdHMucGhw\nJyApOwpyZXF1aXJlX29uY2UoIE1NX0JBU0VfRElSIC4gJ2luYy9wZXJmb3Jt\nYW5jZS5waHAnICk7Cm1tX3JlcXVpcmUoIE1NX0JBU0VfRElSIC4gJ2luYy9i\ncmFuZGluZy5waHAnICk7CnJlcXVpcmVfb25jZSggTU1fQkFTRV9ESVIgLiAn\naW5jL2VkaXRvci1wcm9tcHQucGhwJyApOwptbV9yZXF1aXJlKCBNTV9CQVNF\nX0RJUiAuICdpbmMvc3NvLnBocCcgKTsKbW1fcmVxdWlyZSggTU1fQkFTRV9E\nSVIgLiAndmVuZG9yL2pldHBhY2svamV0cGFjay1vbmJvYXJkaW5nL2pldHBh\nY2stb25ib2FyZGluZy5waHAnICk7CmlmICggbW1famV0cGFja19ibHVlaG9z\ndF9vbmx5KCkgKSB7CgltbV9yZXF1aXJlKCBNTV9CQVNFX0RJUiAuICd2ZW5k\nb3IvamV0cGFjay9qZXRwYWNrLW9uYm9hcmRpbmctdHJhY2tzL2pldHBhY2st\nb25ib2FyZGluZy10cmFja3MucGhwJyApOwp9Cm1tX3JlcXVpcmUoIE1NX0JB\nU0VfRElSIC4gJ3VwZGF0ZXIucGhwJyApOwptbV9yZXF1aXJlKCBNTV9CQVNF\nX0RJUiAuICdpbmMvY2xpLnBocCcgKTsK\n\";s:8:\"encoding\";s:6:\"base64\";s:6:\"_links\";O:8:\"stdClass\":3:{s:4:\"self\";s:109:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/contents/mojo-marketplace.php?ref=production\";s:3:\"git\";s:115:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/blobs/654d3cc7bef6f1a99cb51eaa72f6fbc2360da6ab\";s:4:\"html\";s:91:\"https://github.com/mojoness/mojo-marketplace-wp-plugin/blob/production/mojo-marketplace.php\";}}', 'yes'),
(23652, '_site_transient_timeout_ghu-aca1a99da826e8036f3bd23a2dafb4ea', '1505668204', 'yes'),
(23653, '_site_transient_ghu-aca1a99da826e8036f3bd23a2dafb4ea', 'O:8:\"stdClass\":3:{s:11:\"total_count\";i:1;s:18:\"incomplete_results\";b:0;s:5:\"items\";a:1:{i:0;O:8:\"stdClass\":70:{s:2:\"id\";i:16290496;s:4:\"name\";s:26:\"mojo-marketplace-wp-plugin\";s:9:\"full_name\";s:35:\"mojoness/mojo-marketplace-wp-plugin\";s:5:\"owner\";O:8:\"stdClass\":17:{s:5:\"login\";s:8:\"mojoness\";s:2:\"id\";i:1278255;s:10:\"avatar_url\";s:52:\"https://avatars0.githubusercontent.com/u/1278255?v=4\";s:11:\"gravatar_id\";s:0:\"\";s:3:\"url\";s:37:\"https://api.github.com/users/mojoness\";s:8:\"html_url\";s:27:\"https://github.com/mojoness\";s:13:\"followers_url\";s:47:\"https://api.github.com/users/mojoness/followers\";s:13:\"following_url\";s:60:\"https://api.github.com/users/mojoness/following{/other_user}\";s:9:\"gists_url\";s:53:\"https://api.github.com/users/mojoness/gists{/gist_id}\";s:11:\"starred_url\";s:60:\"https://api.github.com/users/mojoness/starred{/owner}{/repo}\";s:17:\"subscriptions_url\";s:51:\"https://api.github.com/users/mojoness/subscriptions\";s:17:\"organizations_url\";s:42:\"https://api.github.com/users/mojoness/orgs\";s:9:\"repos_url\";s:43:\"https://api.github.com/users/mojoness/repos\";s:10:\"events_url\";s:54:\"https://api.github.com/users/mojoness/events{/privacy}\";s:19:\"received_events_url\";s:53:\"https://api.github.com/users/mojoness/received_events\";s:4:\"type\";s:12:\"Organization\";s:10:\"site_admin\";b:0;}s:7:\"private\";b:0;s:8:\"html_url\";s:54:\"https://github.com/mojoness/mojo-marketplace-wp-plugin\";s:11:\"description\";s:58:\"WordPress plugin that has shortcodes, widgets and themes. \";s:4:\"fork\";b:0;s:3:\"url\";s:64:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin\";s:9:\"forks_url\";s:70:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/forks\";s:8:\"keys_url\";s:78:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/keys{/key_id}\";s:17:\"collaborators_url\";s:93:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/collaborators{/collaborator}\";s:9:\"teams_url\";s:70:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/teams\";s:9:\"hooks_url\";s:70:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/hooks\";s:16:\"issue_events_url\";s:87:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/issues/events{/number}\";s:10:\"events_url\";s:71:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/events\";s:13:\"assignees_url\";s:81:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/assignees{/user}\";s:12:\"branches_url\";s:82:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/branches{/branch}\";s:8:\"tags_url\";s:69:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/tags\";s:9:\"blobs_url\";s:80:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/blobs{/sha}\";s:12:\"git_tags_url\";s:79:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/tags{/sha}\";s:12:\"git_refs_url\";s:79:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/refs{/sha}\";s:9:\"trees_url\";s:80:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/trees{/sha}\";s:12:\"statuses_url\";s:79:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/statuses/{sha}\";s:13:\"languages_url\";s:74:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/languages\";s:14:\"stargazers_url\";s:75:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/stargazers\";s:16:\"contributors_url\";s:77:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/contributors\";s:15:\"subscribers_url\";s:76:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/subscribers\";s:16:\"subscription_url\";s:77:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/subscription\";s:11:\"commits_url\";s:78:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/commits{/sha}\";s:15:\"git_commits_url\";s:82:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/git/commits{/sha}\";s:12:\"comments_url\";s:82:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/comments{/number}\";s:17:\"issue_comment_url\";s:89:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/issues/comments{/number}\";s:12:\"contents_url\";s:81:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/contents/{+path}\";s:11:\"compare_url\";s:88:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/compare/{base}...{head}\";s:10:\"merges_url\";s:71:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/merges\";s:11:\"archive_url\";s:87:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/{archive_format}{/ref}\";s:13:\"downloads_url\";s:74:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/downloads\";s:10:\"issues_url\";s:80:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/issues{/number}\";s:9:\"pulls_url\";s:79:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/pulls{/number}\";s:14:\"milestones_url\";s:84:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/milestones{/number}\";s:17:\"notifications_url\";s:104:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/notifications{?since,all,participating}\";s:10:\"labels_url\";s:78:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/labels{/name}\";s:12:\"releases_url\";s:78:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/releases{/id}\";s:15:\"deployments_url\";s:76:\"https://api.github.com/repos/mojoness/mojo-marketplace-wp-plugin/deployments\";s:10:\"created_at\";s:20:\"2014-01-27T19:47:10Z\";s:10:\"updated_at\";s:20:\"2017-09-11T05:46:55Z\";s:9:\"pushed_at\";s:20:\"2017-09-15T15:52:44Z\";s:7:\"git_url\";s:56:\"git://github.com/mojoness/mojo-marketplace-wp-plugin.git\";s:7:\"ssh_url\";s:54:\"git@github.com:mojoness/mojo-marketplace-wp-plugin.git\";s:9:\"clone_url\";s:58:\"https://github.com/mojoness/mojo-marketplace-wp-plugin.git\";s:7:\"svn_url\";s:54:\"https://github.com/mojoness/mojo-marketplace-wp-plugin\";s:8:\"homepage\";N;s:4:\"size\";i:3848;s:16:\"stargazers_count\";i:6;s:14:\"watchers_count\";i:6;s:8:\"language\";s:3:\"PHP\";s:10:\"has_issues\";b:1;s:12:\"has_projects\";b:1;s:13:\"has_downloads\";b:1;s:8:\"has_wiki\";b:1;s:9:\"has_pages\";b:0;s:11:\"forks_count\";i:5;s:10:\"mirror_url\";N;s:17:\"open_issues_count\";i:2;s:5:\"forks\";i:5;s:11:\"open_issues\";i:2;s:8:\"watchers\";i:6;s:14:\"default_branch\";s:6:\"master\";s:5:\"score\";d:53.2436679999999995516191120259463787078857421875;}}}', 'yes'),
(23655, '_site_transient_timeout_ghu-cd60ad3e4bd0d8706fc4a4f35f398ee5', '1505668204', 'yes'),
(23656, '_site_transient_ghu-cd60ad3e4bd0d8706fc4a4f35f398ee5', 'no tags here', 'yes'),
(23657, '_site_transient_timeout_ghu-9bb54241f94b24d969f7f1e4865eb9ed', '1505668204', 'yes'),
(23658, '_site_transient_ghu-9bb54241f94b24d969f7f1e4865eb9ed', 'O:8:\"stdClass\":2:{s:7:\"message\";s:9:\"Not Found\";s:17:\"documentation_url\";s:31:\"https://developer.github.com/v3\";}', 'yes'),
(23815, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:10:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:7:\"upgrade\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.8.2.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.8.2.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-4.8.2-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.8.2-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"4.8.2\";s:7:\"version\";s:5:\"4.8.2\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:1;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.8.2.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.8.2.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-4.8.2-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.8.2-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"4.8.2\";s:7:\"version\";s:5:\"4.8.2\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:2;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.7.6.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.7.6.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-4.7.6-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.7.6-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"4.7.6\";s:7:\"version\";s:5:\"4.7.6\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:3;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.6.7.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-4.6.7.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-4.6.7-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.6.7-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"4.6.7\";s:7:\"version\";s:5:\"4.6.7\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:4;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.5.10.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.5.10.zip\";s:10:\"no_content\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.5.10-no-content.zip\";s:11:\"new_bundled\";s:72:\"https://downloads.wordpress.org/release/wordpress-4.5.10-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"4.5.10\";s:7:\"version\";s:6:\"4.5.10\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:5;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.4.11.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.4.11.zip\";s:10:\"no_content\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.4.11-no-content.zip\";s:11:\"new_bundled\";s:72:\"https://downloads.wordpress.org/release/wordpress-4.4.11-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"4.4.11\";s:7:\"version\";s:6:\"4.4.11\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:6;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.3.12.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.3.12.zip\";s:10:\"no_content\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.3.12-no-content.zip\";s:11:\"new_bundled\";s:72:\"https://downloads.wordpress.org/release/wordpress-4.3.12-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"4.3.12\";s:7:\"version\";s:6:\"4.3.12\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:7;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.2.16.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.2.16.zip\";s:10:\"no_content\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.2.16-no-content.zip\";s:11:\"new_bundled\";s:72:\"https://downloads.wordpress.org/release/wordpress-4.2.16-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"4.2.16\";s:7:\"version\";s:6:\"4.2.16\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:8;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.1.19.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.1.19.zip\";s:10:\"no_content\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.1.19-no-content.zip\";s:11:\"new_bundled\";s:72:\"https://downloads.wordpress.org/release/wordpress-4.1.19-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"4.1.19\";s:7:\"version\";s:6:\"4.1.19\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}i:9;O:8:\"stdClass\":10:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.0.19.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:60:\"https://downloads.wordpress.org/release/wordpress-4.0.19.zip\";s:10:\"no_content\";s:71:\"https://downloads.wordpress.org/release/wordpress-4.0.19-no-content.zip\";s:11:\"new_bundled\";s:72:\"https://downloads.wordpress.org/release/wordpress-4.0.19-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:6:\"4.0.19\";s:7:\"version\";s:6:\"4.0.19\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"4.7\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1506186259;s:15:\"version_checked\";s:6:\"3.9.20\";s:12:\"translations\";a:0:{}}', 'yes'),
(23869, '_transient_timeout_seedprod_fonts', '1506190546', 'no');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(23870, '_transient_seedprod_fonts', 's:22332:\"a:638:{s:7:\"empty_0\";s:13:\"Select a Font\";s:10:\"optgroup_1\";s:12:\"System Fonts\";s:6:\"_arial\";s:5:\"Arial\";s:12:\"_arial_black\";s:11:\"Arial Black\";s:8:\"_georgia\";s:7:\"Georgia\";s:15:\"_helvetica_neue\";s:14:\"Helvetica Neue\";s:7:\"_impact\";s:6:\"Impact\";s:7:\"_lucida\";s:13:\"Lucida Grande\";s:9:\"_palatino\";s:8:\"Palatino\";s:7:\"_tahoma\";s:6:\"Tahoma\";s:6:\"_times\";s:15:\"Times New Roman\";s:10:\"_trebuchet\";s:9:\"Trebuchet\";s:8:\"_verdana\";s:7:\"Verdana\";s:13:\"optgroupend_1\";s:0:\"\";s:10:\"optgroup_2\";s:12:\"Google Fonts\";s:7:\"ABeeZee\";s:7:\"ABeeZee\";s:4:\"Abel\";s:4:\"Abel\";s:13:\"Abril+Fatface\";s:13:\"Abril Fatface\";s:8:\"Aclonica\";s:8:\"Aclonica\";s:4:\"Acme\";s:4:\"Acme\";s:5:\"Actor\";s:5:\"Actor\";s:7:\"Adamina\";s:7:\"Adamina\";s:10:\"Advent+Pro\";s:10:\"Advent Pro\";s:15:\"Aguafina+Script\";s:15:\"Aguafina Script\";s:7:\"Akronim\";s:7:\"Akronim\";s:6:\"Aladin\";s:6:\"Aladin\";s:7:\"Aldrich\";s:7:\"Aldrich\";s:8:\"Alegreya\";s:8:\"Alegreya\";s:11:\"Alegreya+SC\";s:11:\"Alegreya SC\";s:10:\"Alex+Brush\";s:10:\"Alex Brush\";s:13:\"Alfa+Slab+One\";s:13:\"Alfa Slab One\";s:5:\"Alice\";s:5:\"Alice\";s:5:\"Alike\";s:5:\"Alike\";s:13:\"Alike+Angular\";s:13:\"Alike Angular\";s:5:\"Allan\";s:5:\"Allan\";s:7:\"Allerta\";s:7:\"Allerta\";s:15:\"Allerta+Stencil\";s:15:\"Allerta Stencil\";s:6:\"Allura\";s:6:\"Allura\";s:8:\"Almendra\";s:8:\"Almendra\";s:16:\"Almendra+Display\";s:16:\"Almendra Display\";s:11:\"Almendra+SC\";s:11:\"Almendra SC\";s:8:\"Amarante\";s:8:\"Amarante\";s:8:\"Amaranth\";s:8:\"Amaranth\";s:9:\"Amatic+SC\";s:9:\"Amatic SC\";s:9:\"Amethysta\";s:9:\"Amethysta\";s:7:\"Anaheim\";s:7:\"Anaheim\";s:6:\"Andada\";s:6:\"Andada\";s:6:\"Andika\";s:6:\"Andika\";s:24:\"Annie+Use+Your+Telescope\";s:24:\"Annie Use Your Telescope\";s:13:\"Anonymous+Pro\";s:13:\"Anonymous Pro\";s:5:\"Antic\";s:5:\"Antic\";s:12:\"Antic+Didone\";s:12:\"Antic Didone\";s:10:\"Antic+Slab\";s:10:\"Antic Slab\";s:5:\"Anton\";s:5:\"Anton\";s:6:\"Arapey\";s:6:\"Arapey\";s:7:\"Arbutus\";s:7:\"Arbutus\";s:12:\"Arbutus+Slab\";s:12:\"Arbutus Slab\";s:19:\"Architects+Daughter\";s:19:\"Architects Daughter\";s:13:\"Archivo+Black\";s:13:\"Archivo Black\";s:14:\"Archivo+Narrow\";s:14:\"Archivo Narrow\";s:5:\"Arimo\";s:5:\"Arimo\";s:8:\"Arizonia\";s:8:\"Arizonia\";s:6:\"Armata\";s:6:\"Armata\";s:8:\"Artifika\";s:8:\"Artifika\";s:4:\"Arvo\";s:4:\"Arvo\";s:4:\"Asap\";s:4:\"Asap\";s:5:\"Asset\";s:5:\"Asset\";s:7:\"Astloch\";s:7:\"Astloch\";s:4:\"Asul\";s:4:\"Asul\";s:10:\"Atomic+Age\";s:10:\"Atomic Age\";s:6:\"Aubrey\";s:6:\"Aubrey\";s:9:\"Audiowide\";s:9:\"Audiowide\";s:10:\"Autour+One\";s:10:\"Autour One\";s:7:\"Average\";s:7:\"Average\";s:12:\"Average+Sans\";s:12:\"Average Sans\";s:19:\"Averia+Gruesa+Libre\";s:19:\"Averia Gruesa Libre\";s:12:\"Averia+Libre\";s:12:\"Averia Libre\";s:17:\"Averia+Sans+Libre\";s:17:\"Averia Sans Libre\";s:18:\"Averia+Serif+Libre\";s:18:\"Averia Serif Libre\";s:10:\"Bad+Script\";s:10:\"Bad Script\";s:9:\"Balthazar\";s:9:\"Balthazar\";s:7:\"Bangers\";s:7:\"Bangers\";s:5:\"Basic\";s:5:\"Basic\";s:7:\"Baumans\";s:7:\"Baumans\";s:8:\"Belgrano\";s:8:\"Belgrano\";s:7:\"Belleza\";s:7:\"Belleza\";s:9:\"BenchNine\";s:9:\"BenchNine\";s:7:\"Bentham\";s:7:\"Bentham\";s:15:\"Berkshire+Swash\";s:15:\"Berkshire Swash\";s:5:\"Bevan\";s:5:\"Bevan\";s:13:\"Bigelow+Rules\";s:13:\"Bigelow Rules\";s:11:\"Bigshot+One\";s:11:\"Bigshot One\";s:5:\"Bilbo\";s:5:\"Bilbo\";s:16:\"Bilbo+Swash+Caps\";s:16:\"Bilbo Swash Caps\";s:6:\"Bitter\";s:6:\"Bitter\";s:13:\"Black+Ops+One\";s:13:\"Black Ops One\";s:6:\"Bonbon\";s:6:\"Bonbon\";s:8:\"Boogaloo\";s:8:\"Boogaloo\";s:10:\"Bowlby+One\";s:10:\"Bowlby One\";s:13:\"Bowlby+One+SC\";s:13:\"Bowlby One SC\";s:7:\"Brawler\";s:7:\"Brawler\";s:10:\"Bree+Serif\";s:10:\"Bree Serif\";s:14:\"Bubblegum+Sans\";s:14:\"Bubblegum Sans\";s:11:\"Bubbler+One\";s:11:\"Bubbler One\";s:4:\"Buda\";s:4:\"Buda\";s:7:\"Buenard\";s:7:\"Buenard\";s:10:\"Butcherman\";s:10:\"Butcherman\";s:14:\"Butterfly+Kids\";s:14:\"Butterfly Kids\";s:5:\"Cabin\";s:5:\"Cabin\";s:15:\"Cabin+Condensed\";s:15:\"Cabin Condensed\";s:12:\"Cabin+Sketch\";s:12:\"Cabin Sketch\";s:15:\"Caesar+Dressing\";s:15:\"Caesar Dressing\";s:10:\"Cagliostro\";s:10:\"Cagliostro\";s:14:\"Calligraffitti\";s:14:\"Calligraffitti\";s:5:\"Cambo\";s:5:\"Cambo\";s:6:\"Candal\";s:6:\"Candal\";s:9:\"Cantarell\";s:9:\"Cantarell\";s:11:\"Cantata+One\";s:11:\"Cantata One\";s:11:\"Cantora+One\";s:11:\"Cantora One\";s:8:\"Capriola\";s:8:\"Capriola\";s:5:\"Cardo\";s:5:\"Cardo\";s:5:\"Carme\";s:5:\"Carme\";s:14:\"Carrois+Gothic\";s:14:\"Carrois Gothic\";s:17:\"Carrois+Gothic+SC\";s:17:\"Carrois Gothic SC\";s:10:\"Carter+One\";s:10:\"Carter One\";s:6:\"Caudex\";s:6:\"Caudex\";s:18:\"Cedarville+Cursive\";s:18:\"Cedarville Cursive\";s:11:\"Ceviche+One\";s:11:\"Ceviche One\";s:10:\"Changa+One\";s:10:\"Changa One\";s:6:\"Chango\";s:6:\"Chango\";s:18:\"Chau+Philomene+One\";s:18:\"Chau Philomene One\";s:9:\"Chela+One\";s:9:\"Chela One\";s:14:\"Chelsea+Market\";s:14:\"Chelsea Market\";s:17:\"Cherry+Cream+Soda\";s:17:\"Cherry Cream Soda\";s:12:\"Cherry+Swash\";s:12:\"Cherry Swash\";s:5:\"Chewy\";s:5:\"Chewy\";s:6:\"Chicle\";s:6:\"Chicle\";s:5:\"Chivo\";s:5:\"Chivo\";s:6:\"Cinzel\";s:6:\"Cinzel\";s:17:\"Cinzel+Decorative\";s:17:\"Cinzel Decorative\";s:14:\"Clicker+Script\";s:14:\"Clicker Script\";s:4:\"Coda\";s:4:\"Coda\";s:12:\"Coda+Caption\";s:12:\"Coda Caption\";s:8:\"Codystar\";s:8:\"Codystar\";s:5:\"Combo\";s:5:\"Combo\";s:9:\"Comfortaa\";s:9:\"Comfortaa\";s:11:\"Coming+Soon\";s:11:\"Coming Soon\";s:11:\"Concert+One\";s:11:\"Concert One\";s:9:\"Condiment\";s:9:\"Condiment\";s:12:\"Contrail+One\";s:12:\"Contrail One\";s:11:\"Convergence\";s:11:\"Convergence\";s:6:\"Cookie\";s:6:\"Cookie\";s:5:\"Copse\";s:5:\"Copse\";s:6:\"Corben\";s:6:\"Corben\";s:9:\"Courgette\";s:9:\"Courgette\";s:7:\"Cousine\";s:7:\"Cousine\";s:8:\"Coustard\";s:8:\"Coustard\";s:21:\"Covered+By+Your+Grace\";s:21:\"Covered By Your Grace\";s:12:\"Crafty+Girls\";s:12:\"Crafty Girls\";s:9:\"Creepster\";s:9:\"Creepster\";s:11:\"Crete+Round\";s:11:\"Crete Round\";s:12:\"Crimson+Text\";s:12:\"Crimson Text\";s:13:\"Croissant+One\";s:13:\"Croissant One\";s:7:\"Crushed\";s:7:\"Crushed\";s:6:\"Cuprum\";s:6:\"Cuprum\";s:6:\"Cutive\";s:6:\"Cutive\";s:11:\"Cutive+Mono\";s:11:\"Cutive Mono\";s:6:\"Damion\";s:6:\"Damion\";s:14:\"Dancing+Script\";s:14:\"Dancing Script\";s:20:\"Dawning+of+a+New+Day\";s:20:\"Dawning of a New Day\";s:8:\"Days+One\";s:8:\"Days One\";s:6:\"Delius\";s:6:\"Delius\";s:17:\"Delius+Swash+Caps\";s:17:\"Delius Swash Caps\";s:14:\"Delius+Unicase\";s:14:\"Delius Unicase\";s:13:\"Della+Respira\";s:13:\"Della Respira\";s:8:\"Denk+One\";s:8:\"Denk One\";s:10:\"Devonshire\";s:10:\"Devonshire\";s:13:\"Didact+Gothic\";s:13:\"Didact Gothic\";s:9:\"Diplomata\";s:9:\"Diplomata\";s:12:\"Diplomata+SC\";s:12:\"Diplomata SC\";s:6:\"Domine\";s:6:\"Domine\";s:11:\"Donegal+One\";s:11:\"Donegal One\";s:10:\"Doppio+One\";s:10:\"Doppio One\";s:5:\"Dorsa\";s:5:\"Dorsa\";s:5:\"Dosis\";s:5:\"Dosis\";s:11:\"Dr+Sugiyama\";s:11:\"Dr Sugiyama\";s:10:\"Droid+Sans\";s:10:\"Droid Sans\";s:15:\"Droid+Sans+Mono\";s:15:\"Droid Sans Mono\";s:11:\"Droid+Serif\";s:11:\"Droid Serif\";s:9:\"Duru+Sans\";s:9:\"Duru Sans\";s:9:\"Dynalight\";s:9:\"Dynalight\";s:11:\"EB+Garamond\";s:11:\"EB Garamond\";s:10:\"Eagle+Lake\";s:10:\"Eagle Lake\";s:5:\"Eater\";s:5:\"Eater\";s:9:\"Economica\";s:9:\"Economica\";s:11:\"Electrolize\";s:11:\"Electrolize\";s:5:\"Elsie\";s:5:\"Elsie\";s:16:\"Elsie+Swash+Caps\";s:16:\"Elsie Swash Caps\";s:11:\"Emblema+One\";s:11:\"Emblema One\";s:12:\"Emilys+Candy\";s:12:\"Emilys Candy\";s:10:\"Engagement\";s:10:\"Engagement\";s:9:\"Englebert\";s:9:\"Englebert\";s:9:\"Enriqueta\";s:9:\"Enriqueta\";s:9:\"Erica+One\";s:9:\"Erica One\";s:7:\"Esteban\";s:7:\"Esteban\";s:15:\"Euphoria+Script\";s:15:\"Euphoria Script\";s:5:\"Ewert\";s:5:\"Ewert\";s:3:\"Exo\";s:3:\"Exo\";s:13:\"Expletus+Sans\";s:13:\"Expletus Sans\";s:12:\"Fanwood+Text\";s:12:\"Fanwood Text\";s:9:\"Fascinate\";s:9:\"Fascinate\";s:16:\"Fascinate+Inline\";s:16:\"Fascinate Inline\";s:10:\"Faster+One\";s:10:\"Faster One\";s:8:\"Federant\";s:8:\"Federant\";s:6:\"Federo\";s:6:\"Federo\";s:6:\"Felipa\";s:6:\"Felipa\";s:5:\"Fenix\";s:5:\"Fenix\";s:12:\"Finger+Paint\";s:12:\"Finger Paint\";s:10:\"Fjalla+One\";s:10:\"Fjalla One\";s:9:\"Fjord+One\";s:9:\"Fjord One\";s:8:\"Flamenco\";s:8:\"Flamenco\";s:7:\"Flavors\";s:7:\"Flavors\";s:10:\"Fondamento\";s:10:\"Fondamento\";s:16:\"Fontdiner+Swanky\";s:16:\"Fontdiner Swanky\";s:5:\"Forum\";s:5:\"Forum\";s:12:\"Francois+One\";s:12:\"Francois One\";s:12:\"Freckle+Face\";s:12:\"Freckle Face\";s:20:\"Fredericka+the+Great\";s:20:\"Fredericka the Great\";s:11:\"Fredoka+One\";s:11:\"Fredoka One\";s:6:\"Fresca\";s:6:\"Fresca\";s:7:\"Frijole\";s:7:\"Frijole\";s:7:\"Fruktur\";s:7:\"Fruktur\";s:9:\"Fugaz+One\";s:9:\"Fugaz One\";s:8:\"Gabriela\";s:8:\"Gabriela\";s:6:\"Gafata\";s:6:\"Gafata\";s:8:\"Galdeano\";s:8:\"Galdeano\";s:7:\"Galindo\";s:7:\"Galindo\";s:13:\"Gentium+Basic\";s:13:\"Gentium Basic\";s:18:\"Gentium+Book+Basic\";s:18:\"Gentium Book Basic\";s:3:\"Geo\";s:3:\"Geo\";s:7:\"Geostar\";s:7:\"Geostar\";s:12:\"Geostar+Fill\";s:12:\"Geostar Fill\";s:12:\"Germania+One\";s:12:\"Germania One\";s:13:\"Gilda+Display\";s:13:\"Gilda Display\";s:14:\"Give+You+Glory\";s:14:\"Give You Glory\";s:13:\"Glass+Antiqua\";s:13:\"Glass Antiqua\";s:6:\"Glegoo\";s:6:\"Glegoo\";s:17:\"Gloria+Hallelujah\";s:17:\"Gloria Hallelujah\";s:10:\"Goblin+One\";s:10:\"Goblin One\";s:10:\"Gochi+Hand\";s:10:\"Gochi Hand\";s:8:\"Gorditas\";s:8:\"Gorditas\";s:21:\"Goudy+Bookletter+1911\";s:21:\"Goudy Bookletter 1911\";s:8:\"Graduate\";s:8:\"Graduate\";s:11:\"Grand+Hotel\";s:11:\"Grand Hotel\";s:12:\"Gravitas+One\";s:12:\"Gravitas One\";s:11:\"Great+Vibes\";s:11:\"Great Vibes\";s:6:\"Griffy\";s:6:\"Griffy\";s:6:\"Gruppo\";s:6:\"Gruppo\";s:5:\"Gudea\";s:5:\"Gudea\";s:6:\"Habibi\";s:6:\"Habibi\";s:15:\"Hammersmith+One\";s:15:\"Hammersmith One\";s:7:\"Hanalei\";s:7:\"Hanalei\";s:12:\"Hanalei+Fill\";s:12:\"Hanalei Fill\";s:7:\"Handlee\";s:7:\"Handlee\";s:12:\"Happy+Monkey\";s:12:\"Happy Monkey\";s:12:\"Headland+One\";s:12:\"Headland One\";s:11:\"Henny+Penny\";s:11:\"Henny Penny\";s:20:\"Herr+Von+Muellerhoff\";s:20:\"Herr Von Muellerhoff\";s:15:\"Holtwood+One+SC\";s:15:\"Holtwood One SC\";s:14:\"Homemade+Apple\";s:14:\"Homemade Apple\";s:8:\"Homenaje\";s:8:\"Homenaje\";s:15:\"IM+Fell+DW+Pica\";s:15:\"IM Fell DW Pica\";s:18:\"IM+Fell+DW+Pica+SC\";s:18:\"IM Fell DW Pica SC\";s:19:\"IM+Fell+Double+Pica\";s:19:\"IM Fell Double Pica\";s:22:\"IM+Fell+Double+Pica+SC\";s:22:\"IM Fell Double Pica SC\";s:15:\"IM+Fell+English\";s:15:\"IM Fell English\";s:18:\"IM+Fell+English+SC\";s:18:\"IM Fell English SC\";s:20:\"IM+Fell+French+Canon\";s:20:\"IM Fell French Canon\";s:23:\"IM+Fell+French+Canon+SC\";s:23:\"IM Fell French Canon SC\";s:20:\"IM+Fell+Great+Primer\";s:20:\"IM Fell Great Primer\";s:23:\"IM+Fell+Great+Primer+SC\";s:23:\"IM Fell Great Primer SC\";s:7:\"Iceberg\";s:7:\"Iceberg\";s:7:\"Iceland\";s:7:\"Iceland\";s:7:\"Imprima\";s:7:\"Imprima\";s:11:\"Inconsolata\";s:11:\"Inconsolata\";s:5:\"Inder\";s:5:\"Inder\";s:12:\"Indie+Flower\";s:12:\"Indie Flower\";s:5:\"Inika\";s:5:\"Inika\";s:12:\"Irish+Grover\";s:12:\"Irish Grover\";s:9:\"Istok+Web\";s:9:\"Istok Web\";s:8:\"Italiana\";s:8:\"Italiana\";s:9:\"Italianno\";s:9:\"Italianno\";s:16:\"Jacques+Francois\";s:16:\"Jacques Francois\";s:23:\"Jacques+Francois+Shadow\";s:23:\"Jacques Francois Shadow\";s:14:\"Jim+Nightshade\";s:14:\"Jim Nightshade\";s:10:\"Jockey+One\";s:10:\"Jockey One\";s:12:\"Jolly+Lodger\";s:12:\"Jolly Lodger\";s:12:\"Josefin+Sans\";s:12:\"Josefin Sans\";s:12:\"Josefin+Slab\";s:12:\"Josefin Slab\";s:8:\"Joti+One\";s:8:\"Joti One\";s:6:\"Judson\";s:6:\"Judson\";s:5:\"Julee\";s:5:\"Julee\";s:15:\"Julius+Sans+One\";s:15:\"Julius Sans One\";s:5:\"Junge\";s:5:\"Junge\";s:4:\"Jura\";s:4:\"Jura\";s:17:\"Just+Another+Hand\";s:17:\"Just Another Hand\";s:23:\"Just+Me+Again+Down+Here\";s:23:\"Just Me Again Down Here\";s:7:\"Kameron\";s:7:\"Kameron\";s:5:\"Karla\";s:5:\"Karla\";s:14:\"Kaushan+Script\";s:14:\"Kaushan Script\";s:6:\"Kavoon\";s:6:\"Kavoon\";s:10:\"Keania+One\";s:10:\"Keania One\";s:10:\"Kelly+Slab\";s:10:\"Kelly Slab\";s:5:\"Kenia\";s:5:\"Kenia\";s:8:\"Kite+One\";s:8:\"Kite One\";s:7:\"Knewave\";s:7:\"Knewave\";s:9:\"Kotta+One\";s:9:\"Kotta One\";s:6:\"Kranky\";s:6:\"Kranky\";s:5:\"Kreon\";s:5:\"Kreon\";s:6:\"Kristi\";s:6:\"Kristi\";s:9:\"Krona+One\";s:9:\"Krona One\";s:15:\"La+Belle+Aurore\";s:15:\"La Belle Aurore\";s:8:\"Lancelot\";s:8:\"Lancelot\";s:4:\"Lato\";s:4:\"Lato\";s:13:\"League+Script\";s:13:\"League Script\";s:12:\"Leckerli+One\";s:12:\"Leckerli One\";s:6:\"Ledger\";s:6:\"Ledger\";s:6:\"Lekton\";s:6:\"Lekton\";s:5:\"Lemon\";s:5:\"Lemon\";s:17:\"Libre+Baskerville\";s:17:\"Libre Baskerville\";s:11:\"Life+Savers\";s:11:\"Life Savers\";s:10:\"Lilita+One\";s:10:\"Lilita One\";s:9:\"Limelight\";s:9:\"Limelight\";s:11:\"Linden+Hill\";s:11:\"Linden Hill\";s:7:\"Lobster\";s:7:\"Lobster\";s:11:\"Lobster+Two\";s:11:\"Lobster Two\";s:16:\"Londrina+Outline\";s:16:\"Londrina Outline\";s:15:\"Londrina+Shadow\";s:15:\"Londrina Shadow\";s:15:\"Londrina+Sketch\";s:15:\"Londrina Sketch\";s:14:\"Londrina+Solid\";s:14:\"Londrina Solid\";s:4:\"Lora\";s:4:\"Lora\";s:21:\"Love+Ya+Like+A+Sister\";s:21:\"Love Ya Like A Sister\";s:17:\"Loved+by+the+King\";s:17:\"Loved by the King\";s:14:\"Lovers+Quarrel\";s:14:\"Lovers Quarrel\";s:12:\"Luckiest+Guy\";s:12:\"Luckiest Guy\";s:8:\"Lusitana\";s:8:\"Lusitana\";s:7:\"Lustria\";s:7:\"Lustria\";s:7:\"Macondo\";s:7:\"Macondo\";s:18:\"Macondo+Swash+Caps\";s:18:\"Macondo Swash Caps\";s:5:\"Magra\";s:5:\"Magra\";s:13:\"Maiden+Orange\";s:13:\"Maiden Orange\";s:4:\"Mako\";s:4:\"Mako\";s:9:\"Marcellus\";s:9:\"Marcellus\";s:12:\"Marcellus+SC\";s:12:\"Marcellus SC\";s:12:\"Marck+Script\";s:12:\"Marck Script\";s:9:\"Margarine\";s:9:\"Margarine\";s:9:\"Marko+One\";s:9:\"Marko One\";s:8:\"Marmelad\";s:8:\"Marmelad\";s:6:\"Marvel\";s:6:\"Marvel\";s:4:\"Mate\";s:4:\"Mate\";s:7:\"Mate+SC\";s:7:\"Mate SC\";s:9:\"Maven+Pro\";s:9:\"Maven Pro\";s:7:\"McLaren\";s:7:\"McLaren\";s:6:\"Meddon\";s:6:\"Meddon\";s:13:\"MedievalSharp\";s:13:\"MedievalSharp\";s:10:\"Medula+One\";s:10:\"Medula One\";s:6:\"Megrim\";s:6:\"Megrim\";s:11:\"Meie+Script\";s:11:\"Meie Script\";s:8:\"Merienda\";s:8:\"Merienda\";s:12:\"Merienda+One\";s:12:\"Merienda One\";s:12:\"Merriweather\";s:12:\"Merriweather\";s:17:\"Merriweather+Sans\";s:17:\"Merriweather Sans\";s:11:\"Metal+Mania\";s:11:\"Metal Mania\";s:12:\"Metamorphous\";s:12:\"Metamorphous\";s:11:\"Metrophobic\";s:11:\"Metrophobic\";s:8:\"Michroma\";s:8:\"Michroma\";s:7:\"Milonga\";s:7:\"Milonga\";s:9:\"Miltonian\";s:9:\"Miltonian\";s:16:\"Miltonian+Tattoo\";s:16:\"Miltonian Tattoo\";s:7:\"Miniver\";s:7:\"Miniver\";s:14:\"Miss+Fajardose\";s:14:\"Miss Fajardose\";s:14:\"Modern+Antiqua\";s:14:\"Modern Antiqua\";s:7:\"Molengo\";s:7:\"Molengo\";s:5:\"Molle\";s:5:\"Molle\";s:5:\"Monda\";s:5:\"Monda\";s:8:\"Monofett\";s:8:\"Monofett\";s:7:\"Monoton\";s:7:\"Monoton\";s:20:\"Monsieur+La+Doulaise\";s:20:\"Monsieur La Doulaise\";s:7:\"Montaga\";s:7:\"Montaga\";s:6:\"Montez\";s:6:\"Montez\";s:10:\"Montserrat\";s:10:\"Montserrat\";s:21:\"Montserrat+Alternates\";s:21:\"Montserrat Alternates\";s:20:\"Montserrat+Subrayada\";s:20:\"Montserrat Subrayada\";s:22:\"Mountains+of+Christmas\";s:22:\"Mountains of Christmas\";s:13:\"Mouse+Memoirs\";s:13:\"Mouse Memoirs\";s:10:\"Mr+Bedfort\";s:10:\"Mr Bedfort\";s:8:\"Mr+Dafoe\";s:8:\"Mr Dafoe\";s:14:\"Mr+De+Haviland\";s:14:\"Mr De Haviland\";s:19:\"Mrs+Saint+Delafield\";s:19:\"Mrs Saint Delafield\";s:13:\"Mrs+Sheppards\";s:13:\"Mrs Sheppards\";s:4:\"Muli\";s:4:\"Muli\";s:13:\"Mystery+Quest\";s:13:\"Mystery Quest\";s:6:\"Neucha\";s:6:\"Neucha\";s:6:\"Neuton\";s:6:\"Neuton\";s:10:\"New+Rocker\";s:10:\"New Rocker\";s:10:\"News+Cycle\";s:10:\"News Cycle\";s:7:\"Niconne\";s:7:\"Niconne\";s:9:\"Nixie+One\";s:9:\"Nixie One\";s:6:\"Nobile\";s:6:\"Nobile\";s:7:\"Norican\";s:7:\"Norican\";s:7:\"Nosifer\";s:7:\"Nosifer\";s:20:\"Nothing+You+Could+Do\";s:20:\"Nothing You Could Do\";s:12:\"Noticia+Text\";s:12:\"Noticia Text\";s:8:\"Nova+Cut\";s:8:\"Nova Cut\";s:9:\"Nova+Flat\";s:9:\"Nova Flat\";s:9:\"Nova+Mono\";s:9:\"Nova Mono\";s:9:\"Nova+Oval\";s:9:\"Nova Oval\";s:10:\"Nova+Round\";s:10:\"Nova Round\";s:11:\"Nova+Script\";s:11:\"Nova Script\";s:9:\"Nova+Slim\";s:9:\"Nova Slim\";s:11:\"Nova+Square\";s:11:\"Nova Square\";s:6:\"Numans\";s:6:\"Numans\";s:6:\"Nunito\";s:6:\"Nunito\";s:7:\"Offside\";s:7:\"Offside\";s:15:\"Old+Standard+TT\";s:15:\"Old Standard TT\";s:9:\"Oldenburg\";s:9:\"Oldenburg\";s:11:\"Oleo+Script\";s:11:\"Oleo Script\";s:22:\"Oleo+Script+Swash+Caps\";s:22:\"Oleo Script Swash Caps\";s:9:\"Open+Sans\";s:9:\"Open Sans\";s:19:\"Open+Sans+Condensed\";s:19:\"Open Sans Condensed\";s:11:\"Oranienbaum\";s:11:\"Oranienbaum\";s:8:\"Orbitron\";s:8:\"Orbitron\";s:7:\"Oregano\";s:7:\"Oregano\";s:7:\"Orienta\";s:7:\"Orienta\";s:15:\"Original+Surfer\";s:15:\"Original Surfer\";s:6:\"Oswald\";s:6:\"Oswald\";s:16:\"Over+the+Rainbow\";s:16:\"Over the Rainbow\";s:8:\"Overlock\";s:8:\"Overlock\";s:11:\"Overlock+SC\";s:11:\"Overlock SC\";s:3:\"Ovo\";s:3:\"Ovo\";s:6:\"Oxygen\";s:6:\"Oxygen\";s:11:\"Oxygen+Mono\";s:11:\"Oxygen Mono\";s:7:\"PT+Mono\";s:7:\"PT Mono\";s:7:\"PT+Sans\";s:7:\"PT Sans\";s:15:\"PT+Sans+Caption\";s:15:\"PT Sans Caption\";s:14:\"PT+Sans+Narrow\";s:14:\"PT Sans Narrow\";s:8:\"PT+Serif\";s:8:\"PT Serif\";s:16:\"PT+Serif+Caption\";s:16:\"PT Serif Caption\";s:8:\"Pacifico\";s:8:\"Pacifico\";s:7:\"Paprika\";s:7:\"Paprika\";s:10:\"Parisienne\";s:10:\"Parisienne\";s:11:\"Passero+One\";s:11:\"Passero One\";s:11:\"Passion+One\";s:11:\"Passion One\";s:12:\"Patrick+Hand\";s:12:\"Patrick Hand\";s:15:\"Patrick+Hand+SC\";s:15:\"Patrick Hand SC\";s:9:\"Patua+One\";s:9:\"Patua One\";s:11:\"Paytone+One\";s:11:\"Paytone One\";s:7:\"Peralta\";s:7:\"Peralta\";s:16:\"Permanent+Marker\";s:16:\"Permanent Marker\";s:19:\"Petit+Formal+Script\";s:19:\"Petit Formal Script\";s:7:\"Petrona\";s:7:\"Petrona\";s:11:\"Philosopher\";s:11:\"Philosopher\";s:6:\"Piedra\";s:6:\"Piedra\";s:13:\"Pinyon+Script\";s:13:\"Pinyon Script\";s:10:\"Pirata+One\";s:10:\"Pirata One\";s:7:\"Plaster\";s:7:\"Plaster\";s:4:\"Play\";s:4:\"Play\";s:8:\"Playball\";s:8:\"Playball\";s:16:\"Playfair+Display\";s:16:\"Playfair Display\";s:19:\"Playfair+Display+SC\";s:19:\"Playfair Display SC\";s:7:\"Podkova\";s:7:\"Podkova\";s:10:\"Poiret+One\";s:10:\"Poiret One\";s:10:\"Poller+One\";s:10:\"Poller One\";s:4:\"Poly\";s:4:\"Poly\";s:8:\"Pompiere\";s:8:\"Pompiere\";s:12:\"Pontano+Sans\";s:12:\"Pontano Sans\";s:16:\"Port+Lligat+Sans\";s:16:\"Port Lligat Sans\";s:16:\"Port+Lligat+Slab\";s:16:\"Port Lligat Slab\";s:5:\"Prata\";s:5:\"Prata\";s:14:\"Press+Start+2P\";s:14:\"Press Start 2P\";s:14:\"Princess+Sofia\";s:14:\"Princess Sofia\";s:8:\"Prociono\";s:8:\"Prociono\";s:10:\"Prosto+One\";s:10:\"Prosto One\";s:7:\"Puritan\";s:7:\"Puritan\";s:12:\"Purple+Purse\";s:12:\"Purple Purse\";s:6:\"Quando\";s:6:\"Quando\";s:8:\"Quantico\";s:8:\"Quantico\";s:12:\"Quattrocento\";s:12:\"Quattrocento\";s:17:\"Quattrocento+Sans\";s:17:\"Quattrocento Sans\";s:9:\"Questrial\";s:9:\"Questrial\";s:9:\"Quicksand\";s:9:\"Quicksand\";s:14:\"Quintessential\";s:14:\"Quintessential\";s:7:\"Qwigley\";s:7:\"Qwigley\";s:15:\"Racing+Sans+One\";s:15:\"Racing Sans One\";s:6:\"Radley\";s:6:\"Radley\";s:7:\"Raleway\";s:7:\"Raleway\";s:12:\"Raleway+Dots\";s:12:\"Raleway Dots\";s:6:\"Rambla\";s:6:\"Rambla\";s:12:\"Rammetto+One\";s:12:\"Rammetto One\";s:8:\"Ranchers\";s:8:\"Ranchers\";s:6:\"Rancho\";s:6:\"Rancho\";s:9:\"Rationale\";s:9:\"Rationale\";s:9:\"Redressed\";s:9:\"Redressed\";s:13:\"Reenie+Beanie\";s:13:\"Reenie Beanie\";s:7:\"Revalia\";s:7:\"Revalia\";s:6:\"Ribeye\";s:6:\"Ribeye\";s:13:\"Ribeye+Marrow\";s:13:\"Ribeye Marrow\";s:9:\"Righteous\";s:9:\"Righteous\";s:6:\"Risque\";s:6:\"Risque\";s:6:\"Roboto\";s:6:\"Roboto\";s:16:\"Roboto+Condensed\";s:16:\"Roboto Condensed\";s:9:\"Rochester\";s:9:\"Rochester\";s:9:\"Rock+Salt\";s:9:\"Rock Salt\";s:7:\"Rokkitt\";s:7:\"Rokkitt\";s:9:\"Romanesco\";s:9:\"Romanesco\";s:9:\"Ropa+Sans\";s:9:\"Ropa Sans\";s:7:\"Rosario\";s:7:\"Rosario\";s:8:\"Rosarivo\";s:8:\"Rosarivo\";s:12:\"Rouge+Script\";s:12:\"Rouge Script\";s:4:\"Ruda\";s:4:\"Ruda\";s:6:\"Rufina\";s:6:\"Rufina\";s:11:\"Ruge+Boogie\";s:11:\"Ruge Boogie\";s:6:\"Ruluko\";s:6:\"Ruluko\";s:10:\"Rum+Raisin\";s:10:\"Rum Raisin\";s:14:\"Ruslan+Display\";s:14:\"Ruslan Display\";s:9:\"Russo+One\";s:9:\"Russo One\";s:6:\"Ruthie\";s:6:\"Ruthie\";s:3:\"Rye\";s:3:\"Rye\";s:10:\"Sacramento\";s:10:\"Sacramento\";s:4:\"Sail\";s:4:\"Sail\";s:5:\"Salsa\";s:5:\"Salsa\";s:7:\"Sanchez\";s:7:\"Sanchez\";s:8:\"Sancreek\";s:8:\"Sancreek\";s:11:\"Sansita+One\";s:11:\"Sansita One\";s:6:\"Sarina\";s:6:\"Sarina\";s:7:\"Satisfy\";s:7:\"Satisfy\";s:5:\"Scada\";s:5:\"Scada\";s:10:\"Schoolbell\";s:10:\"Schoolbell\";s:14:\"Seaweed+Script\";s:14:\"Seaweed Script\";s:9:\"Sevillana\";s:9:\"Sevillana\";s:11:\"Seymour+One\";s:11:\"Seymour One\";s:18:\"Shadows+Into+Light\";s:18:\"Shadows Into Light\";s:22:\"Shadows+Into+Light+Two\";s:22:\"Shadows Into Light Two\";s:6:\"Shanti\";s:6:\"Shanti\";s:5:\"Share\";s:5:\"Share\";s:10:\"Share+Tech\";s:10:\"Share Tech\";s:15:\"Share+Tech+Mono\";s:15:\"Share Tech Mono\";s:9:\"Shojumaru\";s:9:\"Shojumaru\";s:11:\"Short+Stack\";s:11:\"Short Stack\";s:10:\"Sigmar+One\";s:10:\"Sigmar One\";s:7:\"Signika\";s:7:\"Signika\";s:16:\"Signika+Negative\";s:16:\"Signika Negative\";s:9:\"Simonetta\";s:9:\"Simonetta\";s:7:\"Sintony\";s:7:\"Sintony\";s:13:\"Sirin+Stencil\";s:13:\"Sirin Stencil\";s:8:\"Six+Caps\";s:8:\"Six Caps\";s:7:\"Skranji\";s:7:\"Skranji\";s:7:\"Slackey\";s:7:\"Slackey\";s:6:\"Smokum\";s:6:\"Smokum\";s:6:\"Smythe\";s:6:\"Smythe\";s:7:\"Sniglet\";s:7:\"Sniglet\";s:7:\"Snippet\";s:7:\"Snippet\";s:13:\"Snowburst+One\";s:13:\"Snowburst One\";s:10:\"Sofadi+One\";s:10:\"Sofadi One\";s:5:\"Sofia\";s:5:\"Sofia\";s:10:\"Sonsie+One\";s:10:\"Sonsie One\";s:16:\"Sorts+Mill+Goudy\";s:16:\"Sorts Mill Goudy\";s:15:\"Source+Code+Pro\";s:15:\"Source Code Pro\";s:15:\"Source+Sans+Pro\";s:15:\"Source Sans Pro\";s:13:\"Special+Elite\";s:13:\"Special Elite\";s:10:\"Spicy+Rice\";s:10:\"Spicy Rice\";s:9:\"Spinnaker\";s:9:\"Spinnaker\";s:6:\"Spirax\";s:6:\"Spirax\";s:10:\"Squada+One\";s:10:\"Squada One\";s:9:\"Stalemate\";s:9:\"Stalemate\";s:13:\"Stalinist+One\";s:13:\"Stalinist One\";s:15:\"Stardos+Stencil\";s:15:\"Stardos Stencil\";s:21:\"Stint+Ultra+Condensed\";s:21:\"Stint Ultra Condensed\";s:20:\"Stint+Ultra+Expanded\";s:20:\"Stint Ultra Expanded\";s:5:\"Stoke\";s:5:\"Stoke\";s:6:\"Strait\";s:6:\"Strait\";s:19:\"Sue+Ellen+Francisco\";s:19:\"Sue Ellen Francisco\";s:9:\"Sunshiney\";s:9:\"Sunshiney\";s:16:\"Supermercado+One\";s:16:\"Supermercado One\";s:18:\"Swanky+and+Moo+Moo\";s:18:\"Swanky and Moo Moo\";s:9:\"Syncopate\";s:9:\"Syncopate\";s:9:\"Tangerine\";s:9:\"Tangerine\";s:5:\"Tauri\";s:5:\"Tauri\";s:5:\"Telex\";s:5:\"Telex\";s:10:\"Tenor+Sans\";s:10:\"Tenor Sans\";s:11:\"Text+Me+One\";s:11:\"Text Me One\";s:18:\"The+Girl+Next+Door\";s:18:\"The Girl Next Door\";s:6:\"Tienne\";s:6:\"Tienne\";s:5:\"Tinos\";s:5:\"Tinos\";s:9:\"Titan+One\";s:9:\"Titan One\";s:13:\"Titillium+Web\";s:13:\"Titillium Web\";s:11:\"Trade+Winds\";s:11:\"Trade Winds\";s:7:\"Trocchi\";s:7:\"Trocchi\";s:7:\"Trochut\";s:7:\"Trochut\";s:7:\"Trykker\";s:7:\"Trykker\";s:10:\"Tulpen+One\";s:10:\"Tulpen One\";s:6:\"Ubuntu\";s:6:\"Ubuntu\";s:16:\"Ubuntu+Condensed\";s:16:\"Ubuntu Condensed\";s:11:\"Ubuntu+Mono\";s:11:\"Ubuntu Mono\";s:5:\"Ultra\";s:5:\"Ultra\";s:14:\"Uncial+Antiqua\";s:14:\"Uncial Antiqua\";s:8:\"Underdog\";s:8:\"Underdog\";s:9:\"Unica+One\";s:9:\"Unica One\";s:14:\"UnifrakturCook\";s:14:\"UnifrakturCook\";s:18:\"UnifrakturMaguntia\";s:18:\"UnifrakturMaguntia\";s:7:\"Unkempt\";s:7:\"Unkempt\";s:6:\"Unlock\";s:6:\"Unlock\";s:4:\"Unna\";s:4:\"Unna\";s:5:\"VT323\";s:5:\"VT323\";s:11:\"Vampiro+One\";s:11:\"Vampiro One\";s:6:\"Varela\";s:6:\"Varela\";s:12:\"Varela+Round\";s:12:\"Varela Round\";s:11:\"Vast+Shadow\";s:11:\"Vast Shadow\";s:5:\"Vibur\";s:5:\"Vibur\";s:8:\"Vidaloka\";s:8:\"Vidaloka\";s:4:\"Viga\";s:4:\"Viga\";s:5:\"Voces\";s:5:\"Voces\";s:7:\"Volkhov\";s:7:\"Volkhov\";s:8:\"Vollkorn\";s:8:\"Vollkorn\";s:8:\"Voltaire\";s:8:\"Voltaire\";s:23:\"Waiting+for+the+Sunrise\";s:23:\"Waiting for the Sunrise\";s:8:\"Wallpoet\";s:8:\"Wallpoet\";s:15:\"Walter+Turncoat\";s:15:\"Walter Turncoat\";s:6:\"Warnes\";s:6:\"Warnes\";s:9:\"Wellfleet\";s:9:\"Wellfleet\";s:9:\"Wendy+One\";s:9:\"Wendy One\";s:8:\"Wire+One\";s:8:\"Wire One\";s:17:\"Yanone+Kaffeesatz\";s:17:\"Yanone Kaffeesatz\";s:10:\"Yellowtail\";s:10:\"Yellowtail\";s:10:\"Yeseva+One\";s:10:\"Yeseva One\";s:10:\"Yesteryear\";s:10:\"Yesteryear\";s:6:\"Zeyada\";s:6:\"Zeyada\";s:13:\"optgroupend_2\";s:0:\"\";}\";', 'no'),
(23887, '_site_transient_timeout_theme_roots', '1506188060', 'yes'),
(23888, '_site_transient_theme_roots', 'a:3:{s:14:\"twentyfourteen\";s:7:\"/themes\";s:14:\"twentythirteen\";s:7:\"/themes\";s:12:\"twentytwelve\";s:7:\"/themes\";}', 'yes'),
(23889, '_site_transient_update_themes', 'O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1506186263;s:7:\"checked\";a:3:{s:14:\"twentyfourteen\";s:3:\"1.1\";s:14:\"twentythirteen\";s:3:\"1.2\";s:12:\"twentytwelve\";s:3:\"1.4\";}s:8:\"response\";a:3:{s:14:\"twentyfourteen\";a:4:{s:5:\"theme\";s:14:\"twentyfourteen\";s:11:\"new_version\";s:3:\"2.0\";s:3:\"url\";s:44:\"https://wordpress.org/themes/twentyfourteen/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/theme/twentyfourteen.2.0.zip\";}s:14:\"twentythirteen\";a:4:{s:5:\"theme\";s:14:\"twentythirteen\";s:11:\"new_version\";s:3:\"2.2\";s:3:\"url\";s:44:\"https://wordpress.org/themes/twentythirteen/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/theme/twentythirteen.2.2.zip\";}s:12:\"twentytwelve\";a:4:{s:5:\"theme\";s:12:\"twentytwelve\";s:11:\"new_version\";s:3:\"2.3\";s:3:\"url\";s:42:\"https://wordpress.org/themes/twentytwelve/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/theme/twentytwelve.2.3.zip\";}}s:12:\"translations\";a:0:{}}', 'yes'),
(23890, '_site_transient_update_plugins', 'O:8:\"stdClass\":3:{s:12:\"last_checked\";i:1506186262;s:8:\"response\";a:2:{s:55:\"ultimate-coming-soon-page/ultimate-coming-soon-page.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:39:\"w.org/plugins/ultimate-coming-soon-page\";s:4:\"slug\";s:25:\"ultimate-coming-soon-page\";s:6:\"plugin\";s:55:\"ultimate-coming-soon-page/ultimate-coming-soon-page.php\";s:11:\"new_version\";s:6:\"1.16.1\";s:3:\"url\";s:56:\"https://wordpress.org/plugins/ultimate-coming-soon-page/\";s:7:\"package\";s:68:\"https://downloads.wordpress.org/plugin/ultimate-coming-soon-page.zip\";s:14:\"upgrade_notice\";s:174:\"<p>This plugin is being deprecated and will be removed soon from wordpress.org. Please use our new version located at: Coming Soon Page &amp; Maintenance Mode by SeedProd</p>\";s:6:\"tested\";s:6:\"4.4.10\";s:13:\"compatibility\";a:0:{}}s:27:\"wp-super-cache/wp-cache.php\";O:8:\"stdClass\":8:{s:2:\"id\";s:28:\"w.org/plugins/wp-super-cache\";s:4:\"slug\";s:14:\"wp-super-cache\";s:6:\"plugin\";s:27:\"wp-super-cache/wp-cache.php\";s:11:\"new_version\";s:5:\"1.5.5\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/wp-super-cache/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/wp-super-cache.1.5.5.zip\";s:6:\"tested\";s:5:\"4.8.1\";s:13:\"compatibility\";a:0:{}}}s:12:\"translations\";a:0:{}}', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 4, '_wp_attached_file', '2014/06/SAVE-MARI_WEB_new.png'),
(3, 4, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:400;s:6:\"height\";i:45;s:4:\"file\";s:29:\"2014/06/SAVE-MARI_WEB_new.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:28:\"SAVE-MARI_WEB_new-150x45.png\";s:5:\"width\";i:150;s:6:\"height\";i:45;s:9:\"mime-type\";s:9:\"image/png\";}s:6:\"medium\";a:4:{s:4:\"file\";s:28:\"SAVE-MARI_WEB_new-300x33.png\";s:5:\"width\";i:300;s:6:\"height\";i:33;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:10:{s:8:\"aperture\";i:0;s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";i:0;s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";i:0;s:3:\"iso\";i:0;s:13:\"shutter_speed\";i:0;s:5:\"title\";s:0:\"\";}}');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2014-06-18 16:26:08', '2014-06-18 16:26:08', 'Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!', 'Hello world!', '', 'publish', 'closed', 'open', '', 'hello-world', '', '', '2014-06-18 16:26:08', '2014-06-18 16:26:08', '', 0, 'http://media.savemari.com/?p=1', 0, 'post', '', 1),
(2, 1, '2014-06-18 16:26:08', '2014-06-18 16:26:08', 'This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\n\n<blockquote>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my blog. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</blockquote>\n\n...or something like this:\n\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>\n\nAs a new WordPress user, you should go to <a href=\"http://media.savemari.com/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!', 'Sample Page', '', 'publish', 'open', 'open', '', 'sample-page', '', '', '2014-06-18 16:26:08', '2014-06-18 16:26:08', '', 0, 'http://media.savemari.com/?page_id=2', 0, 'page', '', 0),
(3, 1, '2014-06-18 16:26:08', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2014-06-18 16:26:08', '0000-00-00 00:00:00', '', 0, 'http://media.savemari.com/?p=3', 0, 'post', '', 0),
(4, 1, '2014-06-18 16:29:16', '2014-06-18 16:29:16', '', 'SAVE-MARI_WEB_new', '', 'inherit', 'closed', 'closed', '', 'save-mari_web_new', '', '', '2014-06-18 16:29:16', '2014-06-18 16:29:16', '', 0, 'http://media.savemari.com/wp-content/uploads/2014/06/SAVE-MARI_WEB_new.png', 0, 'attachment', 'image/png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'first_name', ''),
(2, 1, 'last_name', ''),
(3, 1, 'nickname', 'Thabo'),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'comment_shortcuts', 'false'),
(7, 1, 'admin_color', 'fresh'),
(8, 1, 'use_ssl', '0'),
(9, 1, 'show_admin_bar_front', 'true'),
(10, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(11, 1, 'wp_user_level', '10'),
(12, 1, 'dismissed_wp_pointers', 'wp350_media,wp360_revisions,wp360_locks,wp390_widgets'),
(13, 1, 'show_welcome_panel', '1'),
(14, 1, 'wp_dashboard_quick_press_last_post_id', '3'),
(15, 1, 'wp_user-settings', 'imgsize=full'),
(16, 1, 'wp_user-settings-time', '1403108976');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'Thabo', '$P$B/yJ3Q.KvSzeDTMs1TihKzcoaj6nz0.', 'Thabo', 'thabo@mediafisher.co.uk', '', '2014-06-18 16:26:08', '', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`);

--
-- Indexes for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`);

--
-- Indexes for table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`);

--
-- Indexes for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`);

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23891;

--
-- AUTO_INCREMENT for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
