-- RADYOYOL - Temiz SQL Şema ve Varsayılan Veriler
-- MySQL 5.7+ / MariaDB 10.3+
-- Kullanım: mysql -u kullanici -p veritabani < database/schema.sql

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- Mevcut tabloları temizle (ters sırada foreign key için)
DROP TABLE IF EXISTS `admin_activity_logs`;
DROP TABLE IF EXISTS `admin_two_factor`;
DROP TABLE IF EXISTS `role_permission`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `menu_items`;
DROP TABLE IF EXISTS `song_requests`;
DROP TABLE IF EXISTS `sliders`;
DROP TABLE IF EXISTS `blacklist`;
DROP TABLE IF EXISTS `schedules`;
DROP TABLE IF EXISTS `dj_profiles`;
DROP TABLE IF EXISTS `site_theme_settings`;
DROP TABLE IF EXISTS `site_theme`;
DROP TABLE IF EXISTS `site_settings`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- TABLOLAR
-- ============================================

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `radio_stream_url` varchar(255) DEFAULT NULL,
  `radio_backup_stream_url` varchar(255) DEFAULT NULL,
  `radio_auto_play` tinyint(1) NOT NULL DEFAULT 0,
  `radio_default_volume` decimal(3,2) NOT NULL DEFAULT 0.80,
  `shoutcast_base_url` varchar(500) DEFAULT NULL,
  `shoutcast_sid` tinyint unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext,
  `type` varchar(20) NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `site_theme_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `primary` varchar(20) NOT NULL DEFAULT '#ff0033',
  `primary_hover` varchar(20) NOT NULL DEFAULT '#ff3355',
  `secondary` varchar(20) NOT NULL DEFAULT '#374151',
  `secondary_hover` varchar(20) NOT NULL DEFAULT '#4b5563',
  `accent` varchar(20) NOT NULL DEFAULT '#c92a2a',
  `glow` varchar(20) NOT NULL DEFAULT '#c92a2a',
  `background` varchar(20) NOT NULL DEFAULT '#0b0f16',
  `surface` varchar(20) NOT NULL DEFAULT '#111827',
  `surface_2` varchar(20) NOT NULL DEFAULT '#0f172a',
  `border` varchar(30) NOT NULL DEFAULT 'rgba(255,255,255,0.12)',
  `text` varchar(20) NOT NULL DEFAULT '#ffffff',
  `text_muted` varchar(20) NOT NULL DEFAULT '#a9b1c3',
  `link` varchar(20) NOT NULL DEFAULT '#60a5fa',
  `link_hover` varchar(20) NOT NULL DEFAULT '#93c5fd',
  `header_bg` varchar(50) DEFAULT NULL,
  `header_text` varchar(20) NOT NULL DEFAULT '#ffffff',
  `header_active` varchar(20) NOT NULL DEFAULT '#c92a2a',
  `footer_bg` varchar(50) DEFAULT NULL,
  `footer_text` varchar(30) NOT NULL DEFAULT '#a9b1c3',
  `footer_link` varchar(30) NOT NULL DEFAULT '#a9b1c3',
  `footer_link_hover` varchar(20) NOT NULL DEFAULT '#ffffff',
  `input_bg` varchar(30) NOT NULL DEFAULT 'rgba(255,255,255,0.06)',
  `input_text` varchar(20) NOT NULL DEFAULT '#f0f2f5',
  `focus_ring` varchar(20) NOT NULL DEFAULT '#c92a2a',
  `radius` smallint unsigned NOT NULL DEFAULT 14,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `site_theme` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` tinyint unsigned NOT NULL DEFAULT 1,
  `bg_mode` enum('color','image') NOT NULL DEFAULT 'color',
  `bg_color` varchar(16) NOT NULL DEFAULT '#0b0f16',
  `bg_image` varchar(255) DEFAULT NULL,
  `overlay_color` varchar(16) NOT NULL DEFAULT '#000000',
  `overlay_opacity` tinyint unsigned NOT NULL DEFAULT 55,
  `bg_blur` tinyint unsigned NOT NULL DEFAULT 0,
  `button_color` varchar(16) NOT NULL DEFAULT '#c92a2a',
  `button_hover_color` varchar(16) NOT NULL DEFAULT '#dc2626',
  `schedule_color` varchar(16) NOT NULL DEFAULT '#1e2430',
  `schedule_active_color` varchar(16) NOT NULL DEFAULT '#c92a2a',
  `line_color` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  KEY `admins_role_id_foreign` (`role_id`),
  CONSTRAINT `admins_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `role_permission` (
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_permission_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `admin_activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `meta` json DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `admin_activity_logs_admin_id_foreign` (`admin_id`),
  CONSTRAINT `admin_activity_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `admin_two_factor` (
  `admin_id` bigint unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `secret` text,
  `recovery_codes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  CONSTRAINT `admin_two_factor_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `song_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `artist_name` varchar(255) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `message` text,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `blacklist` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `value` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blacklist_type_value_unique` (`type`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `dj_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `is_live` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `day_of_week` tinyint unsigned NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `host` varchar(255) DEFAULT NULL,
  `dj_id` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_dj_id_foreign` (`dj_id`),
  CONSTRAINT `schedules_dj_id_foreign` FOREIGN KEY (`dj_id`) REFERENCES `dj_profiles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location` enum('header','footer') NOT NULL,
  `title` varchar(120) NOT NULL,
  `type` enum('page','url') NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT 0,
  `target_blank` tinyint unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_location_index` (`location`),
  KEY `menu_items_parent_id_index` (`parent_id`),
  KEY `menu_items_sort_order_index` (`sort_order`),
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- VARSAYILAN VERİLER
-- ============================================

INSERT INTO `settings` (`radio_stream_url`, `radio_backup_stream_url`, `radio_auto_play`, `radio_default_volume`, `shoutcast_base_url`, `shoutcast_sid`, `created_at`, `updated_at`) VALUES
(NULL, NULL, 0, 0.80, NULL, 1, NOW(), NOW());

INSERT INTO `site_theme_settings` (`primary`, `primary_hover`, `secondary`, `secondary_hover`, `accent`, `glow`, `background`, `surface`, `surface_2`, `border`, `text`, `text_muted`, `link`, `link_hover`, `header_text`, `header_active`, `footer_text`, `footer_link`, `footer_link_hover`, `input_bg`, `input_text`, `focus_ring`, `radius`, `created_at`, `updated_at`) VALUES
('#ff0033', '#ff3355', '#374151', '#4b5563', '#c92a2a', '#c92a2a', '#0b0f16', '#111827', '#0f172a', 'rgba(255,255,255,0.12)', '#ffffff', '#a9b1c3', '#60a5fa', '#93c5fd', '#ffffff', '#c92a2a', '#a9b1c3', '#a9b1c3', '#ffffff', 'rgba(255,255,255,0.06)', '#f0f2f5', '#c92a2a', 14, NOW(), NOW());

INSERT INTO `site_theme` (`theme_id`, `bg_mode`, `bg_color`, `overlay_color`, `overlay_opacity`, `bg_blur`, `button_color`, `button_hover_color`, `schedule_color`, `schedule_active_color`, `created_at`, `updated_at`) VALUES
(1, 'color', '#0b0f16', '#000000', 55, 0, '#c92a2a', '#dc2626', '#1e2430', '#c92a2a', NOW(), NOW());

INSERT INTO `permissions` (`key`, `label`, `created_at`, `updated_at`) VALUES
('news.view', 'Haber Görüntüleme', NOW(), NOW()),
('news.create', 'Haber Oluşturma', NOW(), NOW()),
('news.edit', 'Haber Düzenleme', NOW(), NOW()),
('news.delete', 'Haber Silme', NOW(), NOW()),
('settings.manage', 'Ayarlar Yönetimi', NOW(), NOW()),
('users.manage', 'Kullanıcı Yönetimi', NOW(), NOW()),
('ads.manage', 'Reklam Yönetimi', NOW(), NOW()),
('messages.moderate', 'Mesaj Moderasyon', NOW(), NOW()),
('logs.view', 'Aktivite Logları Görüntüleme', NOW(), NOW());

INSERT INTO `roles` (`name`, `created_at`, `updated_at`) VALUES
('Super Admin', NOW(), NOW()),
('Editor', NOW(), NOW()),
('Moderator', NOW(), NOW()),
('DJ', NOW(), NOW());

INSERT INTO `role_permission` (`role_id`, `permission_id`)
SELECT 1, id FROM `permissions`;

INSERT INTO `admins` (`name`, `email`, `password`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
('Super Admin', 'admin@yolcu.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, NOW(), NOW());

INSERT INTO `site_settings` (`key`, `value`, `type`, `created_at`, `updated_at`) VALUES
('site_name', 'RADYOYOL', 'text', NOW(), NOW()),
('site_slogan', '', 'text', NOW(), NOW()),
('contact_email', '', 'text', NOW(), NOW()),
('contact_phone', '', 'text', NOW(), NOW()),
('address_text', '', 'text', NOW(), NOW()),
('maintenance_mode', '0', 'boolean', NOW(), NOW()),
('footer_legal_text', 'Radyoyol Tüm Hakları Saklıdır', 'text', NOW(), NOW()),
('footer_legal_links_json', '[{"label":"Gizlilik Politikası","url":"/gizlilik"},{"label":"Çerez Politikası","url":"/cerez"},{"label":"Kullanım Şartları","url":"/kullanim"},{"label":"KVKK Aydınlatma Metni","url":"/kvkk"}]', 'json', NOW(), NOW());

INSERT INTO `menu_items` (`location`, `title`, `type`, `url`, `parent_id`, `sort_order`, `target_blank`, `is_active`, `created_at`, `updated_at`) VALUES
('header', 'Anasayfa', 'page', '/', NULL, 0, 0, 1, NOW(), NOW()),
('header', 'Programlar', 'page', '/programlar', NULL, 1, 0, 1, NOW(), NOW()),
('header', 'Haberler', 'page', '/haberler', NULL, 2, 0, 1, NOW(), NOW()),
('header', 'Medya', 'page', '/videolar', NULL, 3, 0, 1, NOW(), NOW()),
('header', 'Reklam & Isbirligi', 'page', '/reklam', NULL, 4, 0, 1, NOW(), NOW()),
('header', 'Hakkimizda', 'page', '/hakkimizda/biz-kimiz', NULL, 5, 0, 1, NOW(), NOW()),
('header', 'Iletisim', 'page', '/iletisim', NULL, 6, 0, 1, NOW(), NOW()),
('footer', 'Gizlilik Politikasi', 'page', '/gizlilik', NULL, 0, 0, 1, NOW(), NOW()),
('footer', 'Cerez Politikasi', 'page', '/cerez', NULL, 1, 0, 1, NOW(), NOW()),
('footer', 'Kullanim Sartlari', 'page', '/kullanim', NULL, 2, 0, 1, NOW(), NOW()),
('footer', 'KVKK Aydinlatma Metni', 'page', '/kvkk', NULL, 3, 0, 1, NOW(), NOW());

-- Medya alt menüleri (parent_id=4 Medya), Hakkımızda alt menüleri (parent_id=6 Hakkımızda)
INSERT INTO `menu_items` (`location`, `title`, `type`, `url`, `parent_id`, `sort_order`, `target_blank`, `is_active`, `created_at`, `updated_at`) VALUES
('header', 'Video Galeri', 'page', '/videolar', 4, 0, 0, 1, NOW(), NOW()),
('header', 'Foto Galeri', 'page', '/galeri', 4, 1, 0, 1, NOW(), NOW()),
('header', 'Biz Kimiz', 'page', '/hakkimizda/biz-kimiz', 6, 0, 0, 1, NOW(), NOW()),
('header', 'Misyon & Vizyon', 'page', '/hakkimizda/misyon', 6, 1, 0, 1, NOW(), NOW()),
('header', 'Yayin Politikamiz', 'page', '/hakkimizda/politika', 6, 2, 0, 1, NOW(), NOW());

-- Admin giriş: admin@yolcu.com / password
-- Şifre değiştirmek: php artisan tinker
--   App\Models\Admin::first()->update(['password'=>\Illuminate\Support\Facades\Hash::make('yeni_sifre')]);
