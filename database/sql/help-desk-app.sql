-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table helpdesk_app.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.departments: ~3 rows (approximately)
INSERT INTO `departments` (`id`, `department_name`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Technical', NULL, '2024-06-10 14:51:38', '2024-06-10 14:51:38'),
	(2, 'Billing', NULL, '2024-06-10 14:52:17', '2024-06-10 15:16:47'),
	(3, 'Sales', NULL, '2024-06-10 14:57:54', '2024-06-10 14:57:54');

-- Dumping structure for table helpdesk_app.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table helpdesk_app.help_desk_categories
CREATE TABLE IF NOT EXISTS `help_desk_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.help_desk_categories: ~2 rows (approximately)
INSERT INTO `help_desk_categories` (`id`, `category_name`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Software', NULL, '2024-06-01 10:31:41', '2024-06-01 10:31:41'),
	(2, 'Hardware', NULL, '2024-06-01 10:38:12', '2024-06-01 10:38:12'),
	(6, 'Networking', NULL, '2024-06-01 11:06:44', '2024-06-01 11:13:33');

-- Dumping structure for table helpdesk_app.help_desk_sub_categories
CREATE TABLE IF NOT EXISTS `help_desk_sub_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint DEFAULT NULL,
  `sub_category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.help_desk_sub_categories: ~0 rows (approximately)

-- Dumping structure for table helpdesk_app.help_desk_tickets
CREATE TABLE IF NOT EXISTS `help_desk_tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_request_id` bigint DEFAULT NULL,
  `category_id` bigint DEFAULT NULL,
  `sub_category_id` bigint DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ticket_date` datetime DEFAULT NULL,
  `assign_to` bigint DEFAULT NULL,
  `status` enum('open','on progress','finished','declined') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `help_desk_tickets_ticket_id_unique` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.help_desk_tickets: ~0 rows (approximately)

-- Dumping structure for table helpdesk_app.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.migrations: ~11 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_03_03_110006_create_user_operators_table', 1),
	(6, '2024_03_03_110602_create_departments_table', 1),
	(7, '2024_03_03_113457_create_help_desk_categories_table', 1),
	(8, '2024_03_03_113702_create_help_desk_sub_categories_table', 1),
	(9, '2024_03_03_144119_create_help_desk_tickets_table', 1),
	(10, '2024_03_03_145159_create_ticket_conversations_table', 1),
	(11, '2024_03_03_153445_create_sys_user_groups_table', 2),
	(12, '2024_03_03_154236_create_sys_module_menus_table', 2),
	(13, '2024_03_03_154724_create_sys_user_module_roles_table', 2),
	(14, '2024_03_08_221607_create_sys_user_logs_table', 3);

-- Dumping structure for table helpdesk_app.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table helpdesk_app.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table helpdesk_app.sys_module_menus
CREATE TABLE IF NOT EXISTS `sys_module_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_menu` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.sys_module_menus: ~2 rows (approximately)
INSERT INTO `sys_module_menus` (`id`, `name`, `route_name`, `link_path`, `description`, `icon`, `created_by`, `order_menu`, `created_at`, `updated_at`) VALUES
	(1, 'sys_user_group', 'user_group', '/admin/user-group', 'User Group', 'fa fa-users', 'admin app', 2, '2024-05-04 07:08:15', '2024-05-04 07:08:15'),
	(2, 'sys_user_management', 'user_management', '/admin/user-management', 'User Management', 'fa fa-user-plus', 'admin app', 2, '2024-05-04 07:13:30', '2024-05-04 07:13:30'),
	(3, 'sys_module_permission', 'module_permission', '/admin/module-permission', 'Module Permission', 'fa fa-th-large', 'admin app', 2, '2024-05-04 07:19:59', '2024-05-04 07:19:59'),
	(4, 'help_desk_category', 'help_desk_category', '/help-desk-category', 'Help Desk Category', 'fa fa-list-alt', 'admin app', 1, '2024-06-01 08:10:15', '2024-06-01 08:10:15'),
	(5, 'department', 'department', '/department', 'Department', 'fa fa-server', 'admin app', 1, '2024-06-08 06:07:56', '2024-06-08 06:13:06');

-- Dumping structure for table helpdesk_app.sys_user_groups
CREATE TABLE IF NOT EXISTS `sys_user_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.sys_user_groups: ~3 rows (approximately)
INSERT INTO `sys_user_groups` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'super-admin', 'admin app', '2024-03-11 02:40:38', '2024-03-11 04:28:25'),
	(2, 'operator', 'admin app', '2024-03-11 02:41:24', '2024-03-11 02:41:24'),
	(3, 'user', 'admin app', '2024-03-11 02:41:34', '2024-03-11 02:41:34');

-- Dumping structure for table helpdesk_app.sys_user_logs
CREATE TABLE IF NOT EXISTS `sys_user_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.sys_user_logs: ~32 rows (approximately)
INSERT INTO `sys_user_logs` (`id`, `user_id`, `email`, `ip_address`, `user_agent`, `activity`, `status`, `date_time`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'false', '2024-03-08 17:24:13', '2024-03-08 17:24:13', '2024-03-08 17:24:13'),
	(2, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-08 17:28:19', '2024-03-08 17:28:19', '2024-03-08 17:28:19'),
	(3, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'false', '2024-03-09 13:53:15', '2024-03-09 13:53:15', '2024-03-09 13:53:15'),
	(4, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-09 13:53:21', '2024-03-09 13:53:21', '2024-03-09 13:53:21'),
	(5, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'false', '2024-03-09 22:54:44', '2024-03-09 22:54:44', '2024-03-09 22:54:44'),
	(6, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'false', '2024-03-09 22:54:51', '2024-03-09 22:54:51', '2024-03-09 22:54:51'),
	(7, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-09 22:54:56', '2024-03-09 22:54:56', '2024-03-09 22:54:56'),
	(8, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'false', '2024-03-11 02:27:20', '2024-03-11 02:27:20', '2024-03-11 02:27:20'),
	(9, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-11 02:27:25', '2024-03-11 02:27:25', '2024-03-11 02:27:25'),
	(10, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-11 08:41:47', '2024-03-11 08:41:47', '2024-03-11 08:41:47'),
	(11, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-03-11 08:58:18', '2024-03-11 08:58:18', '2024-03-11 08:58:18'),
	(12, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-11 08:58:49', '2024-03-11 08:58:49', '2024-03-11 08:58:49'),
	(13, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-03-11 08:59:41', '2024-03-11 08:59:41', '2024-03-11 08:59:41'),
	(14, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-11 08:59:50', '2024-03-11 08:59:50', '2024-03-11 08:59:50'),
	(15, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'login to system', 'true', '2024-03-11 15:16:56', '2024-03-11 15:16:56', '2024-03-11 15:16:56'),
	(16, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'false', '2024-04-07 14:27:53', '2024-04-07 14:27:53', '2024-04-07 14:27:53'),
	(17, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'false', '2024-04-07 14:28:30', '2024-04-07 14:28:30', '2024-04-07 14:28:30'),
	(18, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-07 14:50:07', '2024-04-07 14:50:07', '2024-04-07 14:50:07'),
	(19, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-08 13:50:39', '2024-04-08 13:50:39', '2024-04-08 13:50:39'),
	(20, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-04-08 15:07:52', '2024-04-08 15:07:52', '2024-04-08 15:07:52'),
	(21, NULL, 'diki@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'false', '2024-04-08 15:08:05', '2024-04-08 15:08:05', '2024-04-08 15:08:05'),
	(22, NULL, 'diki@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'false', '2024-04-08 15:08:10', '2024-04-08 15:08:10', '2024-04-08 15:08:10'),
	(23, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-08 15:14:54', '2024-04-08 15:14:54', '2024-04-08 15:14:54'),
	(24, 2, 'dicky@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-08 15:19:44', '2024-04-08 15:19:44', '2024-04-08 15:19:44'),
	(25, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-04-08 15:19:54', '2024-04-08 15:19:54', '2024-04-08 15:19:54'),
	(26, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'false', '2024-04-11 04:09:04', '2024-04-11 04:09:04', '2024-04-11 04:09:04'),
	(27, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-11 04:09:08', '2024-04-11 04:09:08', '2024-04-11 04:09:08'),
	(28, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-04-11 05:59:05', '2024-04-11 05:59:05', '2024-04-11 05:59:05'),
	(29, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-11 14:29:12', '2024-04-11 14:29:12', '2024-04-11 14:29:12'),
	(30, NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-04-11 16:41:46', '2024-04-11 16:41:46', '2024-04-11 16:41:46'),
	(31, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'false', '2024-04-11 16:45:27', '2024-04-11 16:45:27', '2024-04-11 16:45:27'),
	(32, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'login to system', 'true', '2024-04-11 16:45:45', '2024-04-11 16:45:45', '2024-04-11 16:45:45'),
	(33, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-04-11 16:46:03', '2024-04-11 16:46:03', '2024-04-11 16:46:03'),
	(34, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-04 04:47:24', '2024-05-04 04:47:24', '2024-05-04 04:47:24'),
	(35, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-04 04:48:27', '2024-05-04 04:48:27', '2024-05-04 04:48:27'),
	(36, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-04 04:49:47', '2024-05-04 04:49:47', '2024-05-04 04:49:47'),
	(37, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-12 12:06:35', '2024-05-12 12:06:35', '2024-05-12 12:06:35'),
	(38, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-12 12:06:40', '2024-05-12 12:06:40', '2024-05-12 12:06:40'),
	(39, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-12 12:06:47', '2024-05-12 12:06:47', '2024-05-12 12:06:47'),
	(40, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-12 12:08:52', '2024-05-12 12:08:52', '2024-05-12 12:08:52'),
	(41, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-23 16:16:17', '2024-05-23 16:16:17', '2024-05-23 16:16:17'),
	(42, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'false', '2024-05-23 16:16:32', '2024-05-23 16:16:32', '2024-05-23 16:16:32'),
	(43, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-23 16:18:28', '2024-05-23 16:18:28', '2024-05-23 16:18:28'),
	(44, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-05-24 14:09:57', '2024-05-24 14:09:57', '2024-05-24 14:09:57'),
	(45, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-01 07:57:02', '2024-06-01 07:57:02', '2024-06-01 07:57:02'),
	(46, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-06-01 09:53:47', '2024-06-01 09:53:47', '2024-06-01 09:53:47'),
	(47, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-01 09:55:31', '2024-06-01 09:55:31', '2024-06-01 09:55:31'),
	(48, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-06-01 11:23:23', '2024-06-01 11:23:23', '2024-06-01 11:23:23'),
	(49, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-06 23:18:22', '2024-06-06 23:18:22', '2024-06-06 23:18:22'),
	(50, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-07 14:56:21', '2024-06-07 14:56:21', '2024-06-07 14:56:21'),
	(51, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-06-07 17:01:04', '2024-06-07 17:01:04', '2024-06-07 17:01:04'),
	(52, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-08 05:07:44', '2024-06-08 05:07:44', '2024-06-08 05:07:44'),
	(53, 4, 'admin@helpdeskapp.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-08 05:42:59', '2024-06-08 05:42:59', '2024-06-08 05:42:59'),
	(54, 4, 'admin@helpdeskapp.id', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'logout from system', 'true', '2024-06-08 05:44:21', '2024-06-08 05:44:21', '2024-06-08 05:44:21'),
	(55, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-10 14:43:33', '2024-06-10 14:43:33', '2024-06-10 14:43:33'),
	(56, 1, 'adminapp@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'login to system', 'true', '2024-06-12 15:09:40', '2024-06-12 15:09:40', '2024-06-12 15:09:40');

-- Dumping structure for table helpdesk_app.sys_user_module_roles
CREATE TABLE IF NOT EXISTS `sys_user_module_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sys_module_id` bigint DEFAULT NULL,
  `sys_user_group_id` bigint DEFAULT NULL,
  `is_access` tinyint DEFAULT NULL,
  `function` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.sys_user_module_roles: ~4 rows (approximately)
INSERT INTO `sys_user_module_roles` (`id`, `sys_module_id`, `sys_user_group_id`, `is_access`, `function`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, '["add","edit","delete"]', '2024-06-01 07:58:00', '2024-06-07 16:30:26'),
	(2, 2, 1, 1, '["edit","change_password","delete","add"]', '2024-06-01 07:59:39', '2024-06-08 05:45:00'),
	(3, 3, 1, 1, '["module_roles","edit","module_roles_show","delete","add"]', '2024-06-01 08:00:12', '2024-06-08 05:53:22'),
	(4, 4, 1, 1, '["add","edit","delete"]', '2024-06-01 08:10:28', '2024-06-07 16:40:03'),
	(5, 5, 1, 1, '["add","edit","delete"]', '2024-06-08 06:08:55', '2024-06-08 06:08:55');

-- Dumping structure for table helpdesk_app.ticket_conversations
CREATE TABLE IF NOT EXISTS `ticket_conversations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `help_desk_ticket_id` bigint DEFAULT NULL,
  `user_request_id` bigint DEFAULT NULL,
  `user_operator_id` bigint DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `conversation_time` timestamp NULL DEFAULT NULL,
  `status` enum('open','reply','closed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.ticket_conversations: ~0 rows (approximately)

-- Dumping structure for table helpdesk_app.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` tinyint DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roles`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin app', 'adminapp@gmail.com', '2024-03-08 17:27:38', '$2y$12$MjzTTV7VaN51ZSm695C8xOcSDEs8QPwUHjFTc4hF8bCAsJziTgHHa', 1, 1, NULL, '2024-03-08 17:27:49', '2024-03-08 17:27:51'),
	(2, 'Dicky Hermawans', 'dicky@gmail.com', NULL, '$2y$12$u43CBQkKdfarR9MIECzp0uxDTUlDFCeLSUGkctH9.sB2o0hzkOwMO', 3, 1, NULL, '2024-04-07 15:39:02', '2024-04-11 05:10:13'),
	(3, 'khoirul', 'khoirul@gmail.com', NULL, '$2y$12$dQO.NyPhGBnK1TBl1CuB7ehzYatDdhGXbCxqb8pcKe4ybBzUwBm1.', 2, 1, NULL, '2024-04-07 15:44:37', '2024-04-07 16:17:43'),
	(4, 'admin app 2', 'admin@helpdeskapp.id', NULL, '$2y$12$nMOWPjKwctiZ3TKxGlEnaeJEHpkwqZ30gS02jWmbggZ5ahcsUgeZ.', 1, 1, NULL, '2024-06-01 07:56:23', '2024-06-01 07:56:23');

-- Dumping structure for table helpdesk_app.user_operators
CREATE TABLE IF NOT EXISTS `user_operators` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  `operator_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk_app.user_operators: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
