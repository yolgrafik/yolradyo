-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: yolcu_db
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `about_pages`
--

DROP TABLE IF EXISTS `about_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `about_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `about_pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `about_pages`
--

LOCK TABLES `about_pages` WRITE;
/*!40000 ALTER TABLE `about_pages` DISABLE KEYS */;
INSERT INTO `about_pages` VALUES (1,'biz-kimiz','Biz Kimiz','RadyoYol, yerel kulturu modern yayin anlayisiyla bulusturan bagimsiz bir radyo platformudur.','<p>RadyoYol, Anadolu’nun zengin müzik kültürünü yaşatmayı ve dinleyicileriyle paylaşmayı amaçlayan bir internet radyosudur. Yayınlarımızda başta Türk Halk Müziği olmak üzere; türküler, deyişler, semahlar, yöresel ezgiler ve kültürümüzün farklı renklerini yansıtan eserler yer almaktadır.\r\n\r\nRadyoYol’da müzik yalnızca bir eğlence aracı değil, aynı zamanda kültürümüzü yaşatan önemli bir mirastır. Bu nedenle yayın akışımızda Türkçe, Kürtçe ve Zazaca eserler ile Anadolu’nun farklı bölgelerinden gelen klamlar, halaylar ve yöresel ezgiler önemli bir yer tutar. Amacımız bu zengin kültürü yaşatmak ve yeni nesillere ulaştırmaktır.\r\n\r\nGünün farklı saatlerinde hazırlanan programlarımızla dinleyicilerimize hem müzik dolu hem de samimi bir yayın ortamı sunuyoruz. Dinleyicilerden gelen istekler, mesajlar ve katkılar RadyoYol’u sadece bir radyo değil, aynı zamanda ortak bir buluşma noktası haline getirir.\r\n\r\nRadyoYol, halk müziğinin ruhunu, Anadolu’nun sesini ve kültürel zenginliğini dijital dünyaya taşıyan bir radyo olarak yayın hayatına devam etmektedir.</p>','uploads/about-pages/69acf66d9d2ff_e279f858-3b9d-4898-be0b-e586e0c9dc2c.png',1,1,'2026-03-08 03:05:09','2026-03-08 03:22:23'),(2,'misyon','Misyon & Vizyon','Misyonumuz nitelikli icerik uretmek, vizyonumuz ise bolgesel sesi ulusal dijital bir markaya donusturmektir.','<h2>Misyonumuz\r\n\r\nRadyoYol olarak misyonumuz; Anadolu’nun zengin müzik kültürünü, halk ozanlarının eserlerini ve yöresel ezgileri geniş kitlelere ulaştırmaktır. Türk Halk Müziği başta olmak üzere türküler, deyişler, semahlar, klamlar ve yöresel halaylar gibi kültürel değerlerimizi yaşatmak ve gelecek nesillere aktarmak en önemli hedefimizdir.\r\n\r\nTürkçe, Kürtçe ve Zazaca eserleri bir araya getirerek farklı kültürlerin sesini aynı platformda buluşturmayı amaçlıyoruz. Dinleyicilerimize samimi, kültürel değeri yüksek ve kaliteli bir yayın sunarak müziğin birleştirici gücünü yaşatmayı misyon ediniyoruz.\r\n\r\nVizyonumuz\r\n\r\nRadyoYol’un vizyonu; halk müziği ve kültürel değerleri yaşatan, güvenilir ve saygın bir dijital radyo platformu olmaktır. Türkiye’de ve dünyada yaşayan dinleyicilere ulaşarak Anadolu’nun müzik mirasını daha geniş kitlelere tanıtmak ve bu kültürü yaşatan önemli yayın platformlarından biri haline gelmek en büyük hedefimizdir...</p>','uploads/about-pages/69acfa65bf88d_ed37b622-a34d-451a-879a-d375779c2b4e.png',1,2,'2026-03-08 03:05:09','2026-03-08 03:28:25'),(3,'politika','Yayin Politikamiz','Yayin politikamiz etik ilkelere, toplumsal sorumluluga ve tarafsiz bilgi aktarimina dayanir.','<p>RadyoYol, yayın hayatını kültürel değerleri koruma, saygı ve toplumsal sorumluluk ilkeleri doğrultusunda sürdürmektedir. Yayınlarımızda Türk Halk Müziği, türküler, deyişler, semahlar, klamlar, halaylar ve yöresel ezgiler gibi Anadolu’nun zengin müzik mirasına geniş yer verilmektedir.\r\n\r\nRadyoYol’da farklı kültürlerin ve dillerin müziğine saygı gösterilir. Bu nedenle Türkçe, Kürtçe ve Zazaca eserler yayın akışımızda yer almakta ve kültürel çeşitlilik korunmaktadır.\r\n\r\nRadyoYol, yayın anlayışında din, dil, ırk ve renk ayrımı yapmadan herkese eşit mesafede duran bir yayın anlayışını benimser. Amacımız müzik aracılığıyla insanları bir araya getirmek, kültürel değerleri yaşatmak ve dinleyicilerimize samimi bir radyo ortamı sunmaktır.\r\n\r\nYayın politikamızın temel ilkeleri şunlardır:\r\n\r\nKültürel değerleri yaşatan ve saygı gösteren içerikler sunmak\r\n\r\nDin, dil, ırk ve renk ayrımı yapmadan herkese eşit yaklaşmak\r\n\r\nDinleyicilerimize kaliteli ve düzenli bir yayın akışı sağlamak\r\n\r\nToplumsal değerlere ve kültürel mirasa uygun yayın yapmak\r\n\r\nDinleyici katılımını ve etkileşimini desteklemek\r\n\r\nHalk müziği ve yöresel ezgilerin yaşatılmasına katkı sağlamak\r\n\r\nRadyoYol, bu ilkeler doğrultusunda yayın hayatını sürdürürken dinleyicilerine samimi, kültürel açıdan zengin ve kaliteli bir radyo deneyimi sunmayı amaçlamaktadır..</p>','uploads/about-pages/69acfab09b62d_ed37b622-a34d-451a-879a-d375779c2b4e.png',1,3,'2026-03-08 03:05:09','2026-03-08 03:27:28'),(4,'reklam','RadyoYol Reklam Ajansı','Markanizi RadyoYol yayinlari ve dijital platformlariyla hedef kitlenize etkili bicimde ulastirin.','<p>RadyoYol Reklam Ajansı, markaların, işletmelerin ve hizmetlerin hedef kitlelerine etkili bir şekilde ulaşmasını sağlamak amacıyla oluşturulmuş profesyonel bir tanıtım platformudur. Radyo reklamları yalnızca bir ürün ya da hizmet duyurusu değil, aynı zamanda markanın doğru kitleyle buluşmasını sağlayan güçlü bir iletişim aracıdır.\r\n\r\nRadyoYol olarak reklam çalışmalarında sadece bir reklam alanı sunmakla kalmıyor, aynı zamanda markaların mesajlarını dinleyicilere en doğru ve etkili şekilde ulaştırmayı hedefliyoruz. Reklam içerikleri hazırlanırken seslendirme, müzik, efekt ve yayın zamanı gibi birçok unsur profesyonel bir yaklaşımla planlanır.\r\n\r\nRadyoYol Reklam Ajansı sayesinde işletmeler; ürünlerini, hizmetlerini ve kampanyalarını geniş bir dinleyici kitlesine duyurma fırsatı bulur. Yayınlarımız aracılığıyla reklam verenlerin markalarını doğru hedef kitleye ulaştırarak güçlü bir tanıtım imkânı sunuyoruz.\r\n\r\nRadyoYol’un geniş dinleyici kitlesi ve güvenilir yayın anlayışı sayesinde reklam verenler hem etkili hem de ekonomik bir tanıtım fırsatı elde eder. Program sponsorluğu, spot reklamlar ve özel tanıtım yayınları gibi farklı reklam seçenekleri ile işletmeler için uygun çözümler sunulmaktadır.\r\n\r\nAmacımız; dinleyicilerimize kaliteli bir yayın sunarken aynı zamanda reklam verenler için güvenilir, etkili ve sürdürülebilir bir tanıtım ortamı oluşturmaktır.\r\n\r\nRadyoYol Reklam Ajansı, markanızı doğru sesle, doğru zamanda ve doğru kitleyle buluşturur..</p>','uploads/about-pages/69acfdcd4be4d_reklam.png',1,4,'2026-03-08 03:34:03','2026-03-08 03:40:45');
/*!40000 ALTER TABLE `about_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_activity_logs`
--

DROP TABLE IF EXISTS `admin_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint unsigned DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `admin_activity_logs_admin_id_foreign` (`admin_id`),
  CONSTRAINT `admin_activity_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `admin_activity_logs_chk_1` CHECK (json_valid(`meta`))
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_activity_logs`
--

LOCK TABLES `admin_activity_logs` WRITE;
/*!40000 ALTER TABLE `admin_activity_logs` DISABLE KEYS */;
INSERT INTO `admin_activity_logs` VALUES (1,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 07:35:50'),(2,1,'admin.updated','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 07:53:37'),(3,1,'settings.updated','{\"section\": \"general\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 12:28:32'),(4,1,'settings.updated','{\"section\": \"branding\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 12:47:02'),(5,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:40:20'),(6,1,'settings.updated','{\"section\": \"branding\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:44:08'),(7,1,'settings.updated','{\"section\": \"general\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:44:29'),(8,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:50:38'),(9,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:52:16'),(10,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:53:45'),(11,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-04 13:54:35'),(12,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:10:58'),(13,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:13:08'),(14,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:13:23'),(15,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:13:26'),(16,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:14:03'),(17,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:14:04'),(18,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:14:07'),(19,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:14:31'),(20,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:18:07'),(21,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:18:14'),(22,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:19:46'),(23,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:20:03'),(24,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:20:04'),(25,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:20:20'),(26,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:21:06'),(27,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:21:12'),(28,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:21:13'),(29,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 14:21:32'),(30,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:23:35'),(31,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:24:28'),(32,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:25:08'),(33,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:27:32'),(34,1,'settings.updated','{\"section\": \"footer\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:31:08'),(35,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:31:21'),(36,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:43:57'),(37,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:44:44'),(38,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:49:08'),(39,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:58:59'),(40,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:59:04'),(41,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 15:59:08'),(42,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:21:08'),(43,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:24:47'),(44,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:25:26'),(45,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:29:01'),(46,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:32:39'),(47,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:33:04'),(48,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:34:01'),(49,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:34:24'),(50,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:34:28'),(51,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:36:46'),(52,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:41:48'),(53,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:45:04'),(54,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:50:33'),(55,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:50:56'),(56,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:57:21'),(57,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 16:58:21'),(58,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:03:30'),(59,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:12:25'),(60,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:21:09'),(61,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:21:29'),(62,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:23:26'),(63,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:24:05'),(64,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:27:30'),(65,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:33:13'),(66,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:46:38'),(67,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:52:36'),(68,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 17:52:57'),(69,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:02:26'),(70,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:03:31'),(71,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:09:35'),(72,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:09:45'),(73,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:10:05'),(74,1,'settings.updated','{\"section\": \"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:23:45'),(75,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:31:46'),(76,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:32:17'),(77,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-04 18:32:33'),(78,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 01:16:10'),(79,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 12:44:16'),(80,1,'menu.updated','{\"id\": 2}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 15:23:18'),(81,1,'menu.created','{\"title\": \"Programcilar\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 15:24:09'),(82,1,'menu.updated','{\"id\": 16}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 15:25:06'),(83,1,'menu.deleted','{\"id\": 16}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 15:26:00'),(84,1,'menu.updated','{\"id\": 2}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 15:44:41'),(85,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 16:20:34'),(86,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 18:00:54'),(87,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 18:04:28'),(88,1,'settings.updated','{\"section\": \"general\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 19:03:37'),(89,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 19:24:10'),(90,1,'settings.updated','{\"section\": \"seo\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 19:34:00'),(91,1,'settings.updated','{\"section\": \"general\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 19:43:27'),(92,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 19:45:15'),(93,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 20:51:20'),(94,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 20:51:42'),(95,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 20:52:07'),(96,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 20:52:22'),(97,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 20:52:59'),(98,1,'settings.updated','{\"section\": \"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 20:53:11'),(99,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:10:31'),(100,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:29:10'),(101,1,'legal_text.updated','{\"slug\": \"kullanim\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:34:24'),(102,1,'legal_text.updated','{\"slug\": \"kullanim\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:37:01'),(103,1,'legal_text.updated','{\"slug\": \"gizlilik\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:37:48'),(104,1,'legal_text.updated','{\"slug\": \"kvkk\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:38:42'),(105,1,'legal_text.updated','{\"slug\": \"cerez\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:39:14'),(106,1,'legal_text.updated','{\"slug\": \"dmca\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-05 21:42:22'),(107,1,'admin.login','{\"email\": \"admin@yolcu.com\", \"admin_id\": 1}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-06 15:48:39'),(108,1,'admin.login','{\"admin_id\":1,\"email\":\"admin@yolcu.com\"}','176.1.239.216','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-06 18:06:14'),(109,1,'settings.updated','{\"section\":\"general\"}','176.1.239.216','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-06 18:07:10'),(110,1,'settings.updated','{\"section\":\"footer\"}','176.1.236.243','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-06 18:51:15'),(111,1,'admin.updated','{\"admin_id\":1,\"email\":\"radyoyoltv@gmail.com\"}','176.1.236.243','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','2026-03-06 18:55:12'),(112,1,'admin.login','{\"admin_id\":1,\"email\":\"radyoyoltv@gmail.com\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 03:39:48'),(113,1,'admin.updated','{\"admin_id\":1,\"email\":\"radyoyoltv@gmail.com\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 03:40:13'),(114,1,'settings.updated','{\"section\":\"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 04:13:15'),(115,1,'settings.updated','{\"section\":\"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 04:13:33'),(116,1,'settings.updated','{\"section\":\"theme\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 04:13:50'),(117,1,'admin.login','{\"admin_id\":1,\"email\":\"radyoyoltv@gmail.com\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 18:40:01'),(118,1,'settings.updated','{\"section\":\"social\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','2026-03-08 20:09:35');
/*!40000 ALTER TABLE `admin_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_two_factor`
--

DROP TABLE IF EXISTS `admin_two_factor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_two_factor` (
  `admin_id` bigint unsigned NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `secret` text COLLATE utf8mb4_unicode_ci,
  `recovery_codes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  CONSTRAINT `admin_two_factor_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `admin_two_factor_chk_1` CHECK (json_valid(`recovery_codes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_two_factor`
--

LOCK TABLES `admin_two_factor` WRITE;
/*!40000 ALTER TABLE `admin_two_factor` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_two_factor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  KEY `admins_role_id_foreign` (`role_id`),
  CONSTRAINT `admins_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Super Admin','radyoyoltv@gmail.com','$2y$12$tiDdp5gTU0gK/t8auhbjs.R.J9A.rWtKawrIAp8qZbSSMCGDwihMu','uploads/avatars/69acef9d0103d_pro_2.jpg',1,1,NULL,'2026-03-04 06:11:51','2026-03-08 02:40:13');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artist_videos`
--

DROP TABLE IF EXISTS `artist_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artist_videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_type` enum('mp4','youtube') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'youtube',
  `mp4_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artist_videos`
--

LOCK TABLES `artist_videos` WRITE;
/*!40000 ALTER TABLE `artist_videos` DISABLE KEYS */;
INSERT INTO `artist_videos` VALUES (1,'RadyoYol Bağlama Türkü Seçkisi','2026 Yeni Türküler RadyoYol özel bağlama seçkisi.\r\nAnadolu’nun en güzel bağlama türküleri, aksak ritimler ve geleneksel Türk halk müziği ezgileri bu videoda bir araya geliyor.',NULL,'youtube',NULL,'https://www.youtube.com/watch?v=BIDVmrHI3ds',1,1,0,'2026-03-08 04:24:40','2026-03-08 07:58:48'),(2,'KOMA ZARiN DEVRiM','KOMA ZARiN DEVRiM Berat Celik\r\nSöz ve Müzik:HEBUN\r\n===Şiir===\r\n      Devrim Ateşiyle Büyüyecek Davamız. \r\n      Bitmedi, Hep Sürecek Zalimle Kavgamız. \r\n      İdamlara Gitsekde Bitmeyecek, İnsanlık    \r\n      Sevdamız. Geri Adım Atarsak Nemerdiz. \r\n      Bunu Böyle Bilsin, Korkak Yürekli Cellatlarımız.','uploads/videos/covers/69ad09c5b55c9_pro_3.jpg','youtube',NULL,'https://www.youtube.com/watch?v=QCzB2T1Gan0',1,1,0,'2026-03-08 04:31:49','2026-03-08 04:31:49'),(3,'GRUP ARJIN feat GRUP SEYRAN','GRUP ARJIN feat GRUP SEYRAN',NULL,'youtube',NULL,'https://youtu.be/ldDMNbO0_VY?si=htBZOyULAEisykXB',1,0,0,'2026-03-08 08:00:27','2026-03-08 08:00:27');
/*!40000 ALTER TABLE `artist_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blacklist`
--

DROP TABLE IF EXISTS `blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blacklist` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blacklist_type_value_unique` (`type`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklist`
--

LOCK TABLES `blacklist` WRITE;
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-radio_status','a:4:{s:2:\"ok\";b:0;s:4:\"song\";s:1:\"-\";s:9:\"listeners\";i:0;s:6:\"status\";s:7:\"offline\";}',1773001471),('laravel-cache-site_settings_address_text','s:0:\"\";',1773000461),('laravel-cache-site_settings_all','a:86:{s:9:\"site_name\";s:9:\"Radyo Yol\";s:11:\"site_slogan\";s:26:\"Türkülerin Susmayan sesi\";s:13:\"contact_email\";s:16:\"info@radyoyol.de\";s:13:\"contact_phone\";s:19:\"0049 176 2005 91 65\";s:12:\"address_text\";s:0:\"\";s:16:\"maintenance_mode\";b:0;s:15:\"brand_logo_path\";s:57:\"assets/brand/cSqvUhksQ490IrFhnRWmYms073aBX4so7kvMwboA.png\";s:12:\"whatsapp_url\";s:27:\"https://wa.me/4917620059161\";s:15:\"whatsapp_active\";b:1;s:12:\"telegram_url\";s:0:\"\";s:15:\"telegram_active\";b:1;s:13:\"instagram_url\";s:29:\"http://instagram.com/radyoyol\";s:16:\"instagram_active\";b:1;s:12:\"facebook_url\";s:40:\"https://www.facebook.com/radyoyol.com.tr\";s:15:\"facebook_active\";b:1;s:10:\"tiktok_url\";s:31:\"https://www.tiktok.com/radyoyol\";s:13:\"tiktok_active\";b:1;s:11:\"youtube_url\";s:32:\"https://www.youtube.com/radyoyol\";s:14:\"youtube_active\";b:1;s:5:\"x_url\";s:0:\"\";s:8:\"x_active\";b:1;s:18:\"brand_favicon_path\";s:57:\"assets/brand/jAULCzo85GFwmnhteMebZQBvqXjFL9EOXcriHUBI.png\";s:13:\"theme_primary\";s:7:\"#000000\";s:12:\"theme_accent\";s:7:\"#ff0000\";s:8:\"theme_bg\";s:7:\"#000000\";s:10:\"theme_text\";s:7:\"#ffffff\";s:10:\"theme_glow\";s:7:\"#0011ff\";s:17:\"footer_legal_text\";s:35:\"RadyoYol Türkülerin Susmayan Sesi\";s:23:\"footer_legal_links_json\";a:5:{i:0;a:2:{s:5:\"label\";s:19:\"Gizlilik Politikasi\";s:3:\"url\";s:9:\"/gizlilik\";}i:1;a:2:{s:5:\"label\";s:16:\"Cerez Politikasi\";s:3:\"url\";s:6:\"/cerez\";}i:2;a:2:{s:5:\"label\";s:17:\"Kullanim Sartlari\";s:3:\"url\";s:9:\"/kullanim\";}i:3;a:2:{s:5:\"label\";s:29:\"DMCA / Telif Hakkı Bildirimi\";s:3:\"url\";s:5:\"/dmca\";}i:4;a:2:{s:5:\"label\";s:21:\"KVKK Aydinlatma Metni\";s:3:\"url\";s:5:\"/kvkk\";}}s:15:\"android_app_url\";s:61:\"https://play.google.com/store/apps/details?id=radyoyol.com.tr\";s:18:\"android_app_active\";b:1;s:11:\"ios_app_url\";s:61:\"https://play.google.com/store/apps/details?id=radyoyol.com.tr\";s:14:\"ios_app_active\";b:1;s:10:\"winamp_url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.pls\";s:13:\"winamp_active\";b:1;s:16:\"media_player_url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.asx\";s:19:\"media_player_active\";b:1;s:13:\"quicktime_url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.qtl\";s:16:\"quicktime_active\";b:1;s:15:\"real_player_url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.ram\";s:18:\"real_player_active\";b:1;s:24:\"member_approval_required\";b:1;s:29:\"member_daily_submission_limit\";i:5;s:22:\"member_max_mp3_size_mb\";i:100;s:11:\"mail_mailer\";s:4:\"smtp\";s:9:\"mail_host\";s:14:\"smtp.gmail.com\";s:9:\"mail_port\";s:3:\"587\";s:13:\"mail_username\";s:20:\"radyoyoltv@gmail.com\";s:13:\"mail_password\";s:19:\"yvbu xark ckxy iizs\";s:15:\"mail_encryption\";s:3:\"tls\";s:17:\"mail_from_address\";s:20:\"radyoyoltv@gmail.com\";s:14:\"mail_from_name\";s:8:\"RadyoYol\";s:15:\"mail_contact_to\";s:20:\"radyoyoltv@gmail.com\";s:14:\"seo_meta_title\";s:20:\"RadyoYol Canli yayin\";s:20:\"seo_meta_description\";s:25:\"radyoyol 7/24 canli yayin\";s:17:\"seo_meta_keywords\";s:0:\"\";s:15:\"seo_meta_author\";s:0:\"\";s:15:\"seo_meta_robots\";s:12:\"index,follow\";s:17:\"seo_canonical_url\";s:0:\"\";s:12:\"seo_og_title\";s:0:\"\";s:18:\"seo_og_description\";s:0:\"\";s:11:\"seo_og_type\";s:7:\"website\";s:13:\"seo_og_locale\";s:5:\"en_US\";s:16:\"seo_twitter_card\";s:19:\"summary_large_image\";s:16:\"seo_twitter_site\";s:0:\"\";s:19:\"seo_twitter_creator\";s:0:\"\";s:23:\"seo_google_verification\";s:0:\"\";s:21:\"seo_bing_verification\";s:0:\"\";s:23:\"seo_yandex_verification\";s:0:\"\";s:19:\"seo_schema_org_name\";s:0:\"\";s:18:\"seo_schema_org_url\";s:0:\"\";s:19:\"seo_schema_org_logo\";s:0:\"\";s:22:\"seo_schema_description\";s:0:\"\";s:24:\"seo_schema_radio_station\";b:1;s:15:\"seo_sitemap_url\";s:0:\"\";s:14:\"seo_geo_region\";s:0:\"\";s:17:\"seo_meta_referrer\";s:0:\"\";s:14:\"contact_mobile\";s:18:\"+49 176 2005 91 65\";s:11:\"contact_fax\";s:0:\"\";s:17:\"contact_map_embed\";s:0:\"\";s:24:\"member_max_video_size_mb\";i:500;s:14:\"legal_kullanim\";s:3675:\"<h1>Kullan─▒m ┼Şartlar─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>Bu web sitesini kullanarak a┼şa─ş─▒da belirtilen kullan─▒m ┼şartlar─▒n─▒ kabul etmi┼ş say─▒l─▒rs─▒n─▒z. L├╝tfen siteyi kullanmadan ├Ânce bu ┼şartlar─▒ dikkatlice okuyunuz.</p>\r\n\r\n<h2>1. Hizmet Tan─▒m─▒</h2>\r\n<p>RadyoYol, internet ├╝zerinden canl─▒ radyo yay─▒n─▒ ve m├╝zik i├ğerikleri sunan bir platformdur. Kullan─▒c─▒lar site ├╝zerinden radyo yay─▒nlar─▒n─▒ dinleyebilir, site i├ğeri─şini g├Âr├╝nt├╝leyebilir ve baz─▒ hizmetlerden faydalanabilir.</p>\r\n\r\n<p>RadyoYol, hizmetlerini geli┼ştirmek, de─şi┼ştirmek veya durdurmak hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>2. Site Kullan─▒m─▒</h2>\r\n<p>Siteyi kullanan t├╝m ziyaret├ğiler a┼şa─ş─▒daki kurallara uymay─▒ kabul eder:</p>\r\n\r\n<ul>\r\n<li>Siteyi yasa d─▒┼ş─▒ ama├ğlarla kullanmamak</li>\r\n<li>Siteye zarar verecek yaz─▒l─▒m, kod veya giri┼şimlerde bulunmamak</li>\r\n<li>Ba┼şka kullan─▒c─▒lar─▒n haklar─▒n─▒ ihlal edecek davran─▒┼şlardan ka├ğ─▒nmak</li>\r\n<li>Hakaret, tehdit veya uygunsuz i├ğerik payla┼şmamak</li>\r\n</ul>\r\n\r\n<p>Bu kurallar─▒ ihlal eden kullan─▒c─▒lar─▒n siteye eri┼şimi ge├ğici veya kal─▒c─▒ olarak engellenebilir.</p>\r\n\r\n<h2>3. ├£yelik</h2>\r\n<p>Sitemizde ├╝yelik gerektiren hizmetler bulunabilir. ├£ye olan kullan─▒c─▒lar do─şru ve g├╝ncel bilgiler vermekle y├╝k├╝ml├╝d├╝r.</p>\r\n\r\n<p>Kullan─▒c─▒lar hesap bilgilerinin gizlili─şinden sorumludur. Hesap g├╝venli─şi kullan─▒c─▒ya aittir.</p>\r\n\r\n<p>RadyoYol y├Ânetimi, kullan─▒m ┼şartlar─▒n─▒ ihlal eden kullan─▒c─▒ hesaplar─▒n─▒ ask─▒ya alma veya kapatma hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>4. Telif Haklar─▒</h2>\r\n<p>Sitede yer alan logo, tasar─▒m, metinler ve di─şer i├ğerikler RadyoYolÔÇÖa veya ilgili hak sahiplerine aittir.</p>\r\n\r\n<p>Sitedeki i├ğeriklerin izinsiz olarak kopyalanmas─▒, ├ğo─şalt─▒lmas─▒ veya ticari ama├ğla kullan─▒lmas─▒ yasakt─▒r.</p>\r\n\r\n<p>Radyo yay─▒nlar─▒nda kullan─▒lan m├╝zik eserlerinin telif haklar─▒ ilgili hak sahiplerine aittir.</p>\r\n\r\n<h2>5. Yay─▒n ─░├ğeri─şi</h2>\r\n<p>RadyoYol ├╝zerinden yay─▒nlanan i├ğerikler bilgilendirme ve e─şlence ama├ğl─▒d─▒r. Yay─▒n ak─▒┼ş─▒ ve i├ğerikler ├Ânceden haber verilmeksizin de─şi┼ştirilebilir.</p>\r\n\r\n<h2>6. Sorumlulu─şun S─▒n─▒rland─▒r─▒lmas─▒</h2>\r\n<p>RadyoYol, site kullan─▒m─▒ndan do─şabilecek do─şrudan veya dolayl─▒ zararlardan sorumlu tutulamaz.</p>\r\n\r\n<p>Kullan─▒c─▒lar siteyi kendi sorumluluklar─▒ alt─▒nda kullanmay─▒ kabul eder.</p>\r\n\r\n<h2>7. Gizlilik</h2>\r\n<p>Kullan─▒c─▒lar─▒n ki┼şisel verileri Gizlilik Politikas─▒ kapsam─▒nda korunmakta ve i┼şlenmektedir.</p>\r\n\r\n<h2>8. De─şi┼şiklikler</h2>\r\n<p>RadyoYol, kullan─▒m ┼şartlar─▒n─▒ diledi─şi zaman g├╝ncelleme hakk─▒n─▒ sakl─▒ tutar. G├╝ncellenen ┼şartlar sitede yay─▒mland─▒─ş─▒ andan itibaren ge├ğerli olur.</p>\r\n\r\n<h2>9. ─░leti┼şim</h2>\r\n<p>Kullan─▒m ┼şartlar─▒ ile ilgili sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb sitesi: radyoyol.de\r\n</p>\";s:14:\"legal_gizlilik\";s:1954:\"<h1>Gizlilik Politikas─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>RadyoYol olarak ziyaret├ğilerimizin gizlili─şini ├Ânemsiyoruz. Bu gizlilik politikas─▒, web sitemizi ziyaret eden kullan─▒c─▒lar─▒n ki┼şisel bilgilerinin nas─▒l topland─▒─ş─▒n─▒, kullan─▒ld─▒─ş─▒n─▒ ve korundu─şunu a├ğ─▒klamaktad─▒r.</p>\r\n\r\n<h2>1. Toplanan Bilgiler</h2>\r\n<p>Sitemizi ziyaret etti─şinizde a┼şa─ş─▒daki bilgiler toplanabilir:</p>\r\n\r\n<ul>\r\n<li>Ad ve e-posta adresi (├╝yelik veya ileti┼şim s─▒ras─▒nda)</li>\r\n<li>IP adresi</li>\r\n<li>Taray─▒c─▒ ve cihaz bilgileri</li>\r\n<li>Site kullan─▒m istatistikleri</li>\r\n</ul>\r\n\r\n<h2>2. Bilgilerin Kullan─▒m─▒</h2>\r\n<p>Toplanan bilgiler a┼şa─ş─▒daki ama├ğlarla kullan─▒labilir:</p>\r\n\r\n<ul>\r\n<li>Site hizmetlerini geli┼ştirmek</li>\r\n<li>Kullan─▒c─▒ deneyimini iyile┼ştirmek</li>\r\n<li>Kullan─▒c─▒ taleplerine cevap vermek</li>\r\n<li>G├╝venlik ve sistem y├Ânetimini sa─şlamak</li>\r\n</ul>\r\n\r\n<h2>3. Bilgilerin Korunmas─▒</h2>\r\n<p>Ki┼şisel verileriniz yetkisiz eri┼şim, de─şi┼ştirme veya k├Ât├╝ye kullan─▒m riskine kar┼ş─▒ uygun g├╝venlik ├Ânlemleri ile korunmaktad─▒r.</p>\r\n\r\n<h2>4. ├£├ğ├╝nc├╝ Taraf Hizmetler</h2>\r\n<p>Sitemizde analiz ara├ğlar─▒ veya ├╝├ğ├╝nc├╝ taraf hizmetler kullan─▒labilir. Bu hizmetler kendi gizlilik politikalar─▒na tabidir.</p>\r\n\r\n<h2>5. De─şi┼şiklikler</h2>\r\n<p>RadyoYol gizlilik politikas─▒n─▒ gerekli g├Ârd├╝─ş├╝nde g├╝ncelleme hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>6. ─░leti┼şim</h2>\r\n<p>Gizlilik politikas─▒ hakk─▒nda sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>\";s:10:\"legal_kvkk\";s:1556:\"<h1>KVKK Ayd─▒nlatma Metni</h1>\r\n\r\n<p>RadyoYol olarak ki┼şisel verilerinizin g├╝venli─şine ├Ânem veriyoruz. Bu metin, ki┼şisel verilerinizin hangi ama├ğlarla i┼şlendi─şini a├ğ─▒klamak amac─▒yla haz─▒rlanm─▒┼şt─▒r.</p>\r\n\r\n<h2>1. Veri Sorumlusu</h2>\r\n<p>Ki┼şisel verileriniz RadyoYol taraf─▒ndan i┼şlenmektedir.</p>\r\n\r\n<h2>2. ─░┼şlenen Ki┼şisel Veriler</h2>\r\n\r\n<ul>\r\n<li>Ad ve soyad</li>\r\n<li>E-posta adresi</li>\r\n<li>IP adresi</li>\r\n<li>Site kullan─▒m bilgileri</li>\r\n</ul>\r\n\r\n<h2>3. Verilerin ─░┼şlenme Ama├ğlar─▒</h2>\r\n\r\n<ul>\r\n<li>Site hizmetlerini sunmak</li>\r\n<li>Kullan─▒c─▒ taleplerini kar┼ş─▒lamak</li>\r\n<li>Sistem g├╝venli─şini sa─şlamak</li>\r\n<li>Yasal y├╝k├╝ml├╝l├╝kleri yerine getirmek</li>\r\n</ul>\r\n\r\n<h2>4. Verilerin Saklanmas─▒</h2>\r\n<p>Ki┼şisel veriler yaln─▒zca gerekli s├╝re boyunca saklan─▒r ve yasal y├╝k├╝ml├╝l├╝kler do─şrultusunda korunur.</p>\r\n\r\n<h2>5. Haklar─▒n─▒z</h2>\r\n<p>Kullan─▒c─▒lar KVKK kapsam─▒nda a┼şa─ş─▒daki haklara sahiptir:</p>\r\n\r\n<ul>\r\n<li>Ki┼şisel verilerinin i┼şlenip i┼şlenmedi─şini ├Â─şrenme</li>\r\n<li>Verilerin d├╝zeltilmesini talep etme</li>\r\n<li>Verilerin silinmesini talep etme</li>\r\n</ul>\r\n\r\n<h2>6. ─░leti┼şim</h2>\r\n<p>Ki┼şisel verilerinizle ilgili talepler i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>\";s:11:\"legal_cerez\";s:1371:\"<h1>├çerez Politikas─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>Bu web sitesi kullan─▒c─▒ deneyimini geli┼ştirmek amac─▒yla ├ğerezler kullanmaktad─▒r.</p>\r\n\r\n<h2>1. ├çerez Nedir?</h2>\r\n<p>├çerezler, ziyaret etti─şiniz web siteleri taraf─▒ndan taray─▒c─▒n─▒za kaydedilen k├╝├ğ├╝k veri dosyalar─▒d─▒r.</p>\r\n\r\n<h2>2. Kullan─▒lan ├çerez T├╝rleri</h2>\r\n\r\n<ul>\r\n<li><strong>Zorunlu ├çerezler:</strong> Sitenin d├╝zg├╝n ├ğal─▒┼şmas─▒ i├ğin gereklidir.</li>\r\n<li><strong>Performans ├çerezleri:</strong> Site kullan─▒m─▒n─▒ analiz etmek i├ğin kullan─▒l─▒r.</li>\r\n<li><strong>Fonksiyonel ├çerezler:</strong> Kullan─▒c─▒ tercihlerini hat─▒rlamak i├ğin kullan─▒l─▒r.</li>\r\n</ul>\r\n\r\n<h2>3. ├çerezlerin Y├Ânetimi</h2>\r\n<p>Kullan─▒c─▒lar taray─▒c─▒ ayarlar─▒n─▒ de─şi┼ştirerek ├ğerezleri engelleyebilir veya silebilir.</p>\r\n\r\n<h2>4. ├çerez Politikas─▒ De─şi┼şiklikleri</h2>\r\n<p>Bu politika zaman zaman g├╝ncellenebilir.</p>\r\n\r\n<h2>5. ─░leti┼şim</h2>\r\n<p>├çerez politikas─▒ ile ilgili sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>\";s:10:\"legal_dmca\";s:2119:\"<h1>DMCA / Telif Hakk─▒ Bildirimi</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>RadyoYol, telif haklar─▒na sayg─▒ g├Âstermeyi ilke edinmi┼ştir. Sitemizde yay─▒nlanan i├ğeriklerin telif haklar─▒ ilgili hak sahiplerine aittir.</p>\r\n\r\n<h2>1. Telif Haklar─▒na Sayg─▒</h2>\r\n<p>RadyoYol ├╝zerinden yay─▒nlanan m├╝zik eserleri, i├ğerikler ve di─şer materyaller ilgili sanat├ğ─▒lar, yap─▒mc─▒lar veya hak sahiplerine aittir. Telif hakk─▒ ihlali olu┼şturabilecek i├ğeriklerin tespit edilmesi durumunda gerekli i┼şlemler yap─▒lacakt─▒r.</p>\r\n\r\n<h2>2. Telif Hakk─▒ ─░hlali Bildirimi</h2>\r\n<p>E─şer telif hakk─▒na sahip oldu─şunuz bir i├ğeri─şin izinsiz olarak yay─▒nland─▒─ş─▒n─▒ d├╝┼ş├╝n├╝yorsan─▒z, a┼şa─ş─▒daki bilgileri i├ğeren bir bildirim g├Ândererek bizimle ileti┼şime ge├ğebilirsiniz:</p>\r\n\r\n<ul>\r\n<li>Telif hakk─▒ sahibi veya yetkili temsilcisinin ad─▒</li>\r\n<li>─░hlale konu oldu─şu d├╝┼ş├╝n├╝len i├ğeri─şin a├ğ─▒k tan─▒m─▒</li>\r\n<li>─░lgili i├ğeri─şin bulundu─şu sayfan─▒n ba─şlant─▒s─▒ (URL)</li>\r\n<li>─░leti┼şim bilgileriniz (e-posta veya telefon)</li>\r\n<li>─░hlal iddias─▒n─▒n do─şru oldu─şuna dair beyan</li>\r\n</ul>\r\n\r\n<h2>3. ─░├ğeri─şin Kald─▒r─▒lmas─▒</h2>\r\n<p>Taraf─▒m─▒za iletilen telif hakk─▒ ihlali bildirimleri incelendikten sonra gerekli g├Âr├╝ld├╝─ş├╝ takdirde ilgili i├ğerik kald─▒r─▒labilir veya eri┼şime kapat─▒labilir.</p>\r\n\r\n<h2>4. Yanl─▒┼ş Bildirimler</h2>\r\n<p>Kas─▒tl─▒ olarak yanl─▒┼ş telif hakk─▒ bildirimi yap─▒lmas─▒ durumunda yasal sorumluluk do─şabilir.</p>\r\n\r\n<h2>5. ─░leti┼şim</h2>\r\n<p>Telif hakk─▒ bildirimleri i├ğin a┼şa─ş─▒daki ileti┼şim adresinden bizimle ula┼şabilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb sitesi: radyoyol.de\r\n</p>\";}',1773001230),('laravel-cache-site_settings_android_app_active','b:1;',1773001230),('laravel-cache-site_settings_android_app_url','s:61:\"https://play.google.com/store/apps/details?id=radyoyol.com.tr\";',1773001230),('laravel-cache-site_settings_brand_logo_path','s:57:\"assets/brand/cSqvUhksQ490IrFhnRWmYms073aBX4so7kvMwboA.png\";',1773001230),('laravel-cache-site_settings_contact_email','s:16:\"info@radyoyol.de\";',1773000461),('laravel-cache-site_settings_contact_fax','s:0:\"\";',1773000461),('laravel-cache-site_settings_contact_map_embed','s:0:\"\";',1773000461),('laravel-cache-site_settings_contact_mobile','s:18:\"+49 176 2005 91 65\";',1773000461),('laravel-cache-site_settings_contact_phone','s:19:\"0049 176 2005 91 65\";',1773000461),('laravel-cache-site_settings_facebook_active','b:1;',1773001230),('laravel-cache-site_settings_facebook_url','s:40:\"https://www.facebook.com/radyoyol.com.tr\";',1773001230),('laravel-cache-site_settings_instagram_active','b:1;',1773001230),('laravel-cache-site_settings_instagram_url','s:29:\"http://instagram.com/radyoyol\";',1773001230),('laravel-cache-site_settings_ios_app_active','b:1;',1773001230),('laravel-cache-site_settings_ios_app_url','s:61:\"https://play.google.com/store/apps/details?id=radyoyol.com.tr\";',1773001230),('laravel-cache-site_settings_legal_cerez','s:1371:\"<h1>├çerez Politikas─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>Bu web sitesi kullan─▒c─▒ deneyimini geli┼ştirmek amac─▒yla ├ğerezler kullanmaktad─▒r.</p>\r\n\r\n<h2>1. ├çerez Nedir?</h2>\r\n<p>├çerezler, ziyaret etti─şiniz web siteleri taraf─▒ndan taray─▒c─▒n─▒za kaydedilen k├╝├ğ├╝k veri dosyalar─▒d─▒r.</p>\r\n\r\n<h2>2. Kullan─▒lan ├çerez T├╝rleri</h2>\r\n\r\n<ul>\r\n<li><strong>Zorunlu ├çerezler:</strong> Sitenin d├╝zg├╝n ├ğal─▒┼şmas─▒ i├ğin gereklidir.</li>\r\n<li><strong>Performans ├çerezleri:</strong> Site kullan─▒m─▒n─▒ analiz etmek i├ğin kullan─▒l─▒r.</li>\r\n<li><strong>Fonksiyonel ├çerezler:</strong> Kullan─▒c─▒ tercihlerini hat─▒rlamak i├ğin kullan─▒l─▒r.</li>\r\n</ul>\r\n\r\n<h2>3. ├çerezlerin Y├Ânetimi</h2>\r\n<p>Kullan─▒c─▒lar taray─▒c─▒ ayarlar─▒n─▒ de─şi┼ştirerek ├ğerezleri engelleyebilir veya silebilir.</p>\r\n\r\n<h2>4. ├çerez Politikas─▒ De─şi┼şiklikleri</h2>\r\n<p>Bu politika zaman zaman g├╝ncellenebilir.</p>\r\n\r\n<h2>5. ─░leti┼şim</h2>\r\n<p>├çerez politikas─▒ ile ilgili sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>\";',1772942535),('laravel-cache-site_settings_legal_dmca','s:2119:\"<h1>DMCA / Telif Hakk─▒ Bildirimi</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>RadyoYol, telif haklar─▒na sayg─▒ g├Âstermeyi ilke edinmi┼ştir. Sitemizde yay─▒nlanan i├ğeriklerin telif haklar─▒ ilgili hak sahiplerine aittir.</p>\r\n\r\n<h2>1. Telif Haklar─▒na Sayg─▒</h2>\r\n<p>RadyoYol ├╝zerinden yay─▒nlanan m├╝zik eserleri, i├ğerikler ve di─şer materyaller ilgili sanat├ğ─▒lar, yap─▒mc─▒lar veya hak sahiplerine aittir. Telif hakk─▒ ihlali olu┼şturabilecek i├ğeriklerin tespit edilmesi durumunda gerekli i┼şlemler yap─▒lacakt─▒r.</p>\r\n\r\n<h2>2. Telif Hakk─▒ ─░hlali Bildirimi</h2>\r\n<p>E─şer telif hakk─▒na sahip oldu─şunuz bir i├ğeri─şin izinsiz olarak yay─▒nland─▒─ş─▒n─▒ d├╝┼ş├╝n├╝yorsan─▒z, a┼şa─ş─▒daki bilgileri i├ğeren bir bildirim g├Ândererek bizimle ileti┼şime ge├ğebilirsiniz:</p>\r\n\r\n<ul>\r\n<li>Telif hakk─▒ sahibi veya yetkili temsilcisinin ad─▒</li>\r\n<li>─░hlale konu oldu─şu d├╝┼ş├╝n├╝len i├ğeri─şin a├ğ─▒k tan─▒m─▒</li>\r\n<li>─░lgili i├ğeri─şin bulundu─şu sayfan─▒n ba─şlant─▒s─▒ (URL)</li>\r\n<li>─░leti┼şim bilgileriniz (e-posta veya telefon)</li>\r\n<li>─░hlal iddias─▒n─▒n do─şru oldu─şuna dair beyan</li>\r\n</ul>\r\n\r\n<h2>3. ─░├ğeri─şin Kald─▒r─▒lmas─▒</h2>\r\n<p>Taraf─▒m─▒za iletilen telif hakk─▒ ihlali bildirimleri incelendikten sonra gerekli g├Âr├╝ld├╝─ş├╝ takdirde ilgili i├ğerik kald─▒r─▒labilir veya eri┼şime kapat─▒labilir.</p>\r\n\r\n<h2>4. Yanl─▒┼ş Bildirimler</h2>\r\n<p>Kas─▒tl─▒ olarak yanl─▒┼ş telif hakk─▒ bildirimi yap─▒lmas─▒ durumunda yasal sorumluluk do─şabilir.</p>\r\n\r\n<h2>5. ─░leti┼şim</h2>\r\n<p>Telif hakk─▒ bildirimleri i├ğin a┼şa─ş─▒daki ileti┼şim adresinden bizimle ula┼şabilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb sitesi: radyoyol.de\r\n</p>\";',1772942532),('laravel-cache-site_settings_legal_gizlilik','s:1954:\"<h1>Gizlilik Politikas─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>RadyoYol olarak ziyaret├ğilerimizin gizlili─şini ├Ânemsiyoruz. Bu gizlilik politikas─▒, web sitemizi ziyaret eden kullan─▒c─▒lar─▒n ki┼şisel bilgilerinin nas─▒l topland─▒─ş─▒n─▒, kullan─▒ld─▒─ş─▒n─▒ ve korundu─şunu a├ğ─▒klamaktad─▒r.</p>\r\n\r\n<h2>1. Toplanan Bilgiler</h2>\r\n<p>Sitemizi ziyaret etti─şinizde a┼şa─ş─▒daki bilgiler toplanabilir:</p>\r\n\r\n<ul>\r\n<li>Ad ve e-posta adresi (├╝yelik veya ileti┼şim s─▒ras─▒nda)</li>\r\n<li>IP adresi</li>\r\n<li>Taray─▒c─▒ ve cihaz bilgileri</li>\r\n<li>Site kullan─▒m istatistikleri</li>\r\n</ul>\r\n\r\n<h2>2. Bilgilerin Kullan─▒m─▒</h2>\r\n<p>Toplanan bilgiler a┼şa─ş─▒daki ama├ğlarla kullan─▒labilir:</p>\r\n\r\n<ul>\r\n<li>Site hizmetlerini geli┼ştirmek</li>\r\n<li>Kullan─▒c─▒ deneyimini iyile┼ştirmek</li>\r\n<li>Kullan─▒c─▒ taleplerine cevap vermek</li>\r\n<li>G├╝venlik ve sistem y├Ânetimini sa─şlamak</li>\r\n</ul>\r\n\r\n<h2>3. Bilgilerin Korunmas─▒</h2>\r\n<p>Ki┼şisel verileriniz yetkisiz eri┼şim, de─şi┼ştirme veya k├Ât├╝ye kullan─▒m riskine kar┼ş─▒ uygun g├╝venlik ├Ânlemleri ile korunmaktad─▒r.</p>\r\n\r\n<h2>4. ├£├ğ├╝nc├╝ Taraf Hizmetler</h2>\r\n<p>Sitemizde analiz ara├ğlar─▒ veya ├╝├ğ├╝nc├╝ taraf hizmetler kullan─▒labilir. Bu hizmetler kendi gizlilik politikalar─▒na tabidir.</p>\r\n\r\n<h2>5. De─şi┼şiklikler</h2>\r\n<p>RadyoYol gizlilik politikas─▒n─▒ gerekli g├Ârd├╝─ş├╝nde g├╝ncelleme hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>6. ─░leti┼şim</h2>\r\n<p>Gizlilik politikas─▒ hakk─▒nda sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>\";',1772942536),('laravel-cache-site_settings_legal_kvkk','s:1556:\"<h1>KVKK Ayd─▒nlatma Metni</h1>\r\n\r\n<p>RadyoYol olarak ki┼şisel verilerinizin g├╝venli─şine ├Ânem veriyoruz. Bu metin, ki┼şisel verilerinizin hangi ama├ğlarla i┼şlendi─şini a├ğ─▒klamak amac─▒yla haz─▒rlanm─▒┼şt─▒r.</p>\r\n\r\n<h2>1. Veri Sorumlusu</h2>\r\n<p>Ki┼şisel verileriniz RadyoYol taraf─▒ndan i┼şlenmektedir.</p>\r\n\r\n<h2>2. ─░┼şlenen Ki┼şisel Veriler</h2>\r\n\r\n<ul>\r\n<li>Ad ve soyad</li>\r\n<li>E-posta adresi</li>\r\n<li>IP adresi</li>\r\n<li>Site kullan─▒m bilgileri</li>\r\n</ul>\r\n\r\n<h2>3. Verilerin ─░┼şlenme Ama├ğlar─▒</h2>\r\n\r\n<ul>\r\n<li>Site hizmetlerini sunmak</li>\r\n<li>Kullan─▒c─▒ taleplerini kar┼ş─▒lamak</li>\r\n<li>Sistem g├╝venli─şini sa─şlamak</li>\r\n<li>Yasal y├╝k├╝ml├╝l├╝kleri yerine getirmek</li>\r\n</ul>\r\n\r\n<h2>4. Verilerin Saklanmas─▒</h2>\r\n<p>Ki┼şisel veriler yaln─▒zca gerekli s├╝re boyunca saklan─▒r ve yasal y├╝k├╝ml├╝l├╝kler do─şrultusunda korunur.</p>\r\n\r\n<h2>5. Haklar─▒n─▒z</h2>\r\n<p>Kullan─▒c─▒lar KVKK kapsam─▒nda a┼şa─ş─▒daki haklara sahiptir:</p>\r\n\r\n<ul>\r\n<li>Ki┼şisel verilerinin i┼şlenip i┼şlenmedi─şini ├Â─şrenme</li>\r\n<li>Verilerin d├╝zeltilmesini talep etme</li>\r\n<li>Verilerin silinmesini talep etme</li>\r\n</ul>\r\n\r\n<h2>6. ─░leti┼şim</h2>\r\n<p>Ki┼şisel verilerinizle ilgili talepler i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>\";',1772942527),('laravel-cache-site_settings_maintenance_mode','b:0;',1773001470),('laravel-cache-site_settings_media_player_active','b:1;',1773001230),('laravel-cache-site_settings_media_player_url','s:44:\"https://r1.comcities.com/tunein/radyoyol.asx\";',1773001230),('laravel-cache-site_settings_quicktime_active','b:1;',1773001230),('laravel-cache-site_settings_quicktime_url','s:44:\"https://r1.comcities.com/tunein/radyoyol.qtl\";',1773001230),('laravel-cache-site_settings_real_player_active','b:1;',1773001230),('laravel-cache-site_settings_real_player_url','s:44:\"https://r1.comcities.com/tunein/radyoyol.ram\";',1773001230),('laravel-cache-site_settings_seo_bing_verification','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_canonical_url','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_geo_region','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_google_verification','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_meta_author','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_meta_description','s:25:\"radyoyol 7/24 canli yayin\";',1772942918),('laravel-cache-site_settings_seo_meta_keywords','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_meta_referrer','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_meta_robots','s:12:\"index,follow\";',1772942918),('laravel-cache-site_settings_seo_meta_title','s:20:\"RadyoYol Canli yayin\";',1772942918),('laravel-cache-site_settings_seo_og_description','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_og_image_path','N;',1772942918),('laravel-cache-site_settings_seo_og_locale','s:5:\"en_US\";',1772942918),('laravel-cache-site_settings_seo_og_title','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_og_type','s:7:\"website\";',1772942918),('laravel-cache-site_settings_seo_schema_description','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_schema_json','N;',1772942918),('laravel-cache-site_settings_seo_schema_org_logo','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_schema_org_name','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_schema_org_url','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_schema_radio_station','b:1;',1772942918),('laravel-cache-site_settings_seo_sitemap_url','s:0:\"\";',1772942918),('laravel-cache-site_settings_seo_yandex_verification','s:0:\"\";',1772942918),('laravel-cache-site_settings_site_name','s:9:\"Radyo Yol\";',1773000461),('laravel-cache-site_settings_site_slogan','s:26:\"Türkülerin Susmayan sesi\";',1773000461),('laravel-cache-site_settings_social_links','a:13:{s:8:\"whatsapp\";a:2:{s:3:\"url\";s:27:\"https://wa.me/4917620059161\";s:9:\"is_active\";b:1;}s:8:\"telegram\";a:2:{s:3:\"url\";s:0:\"\";s:9:\"is_active\";b:1;}s:9:\"instagram\";a:2:{s:3:\"url\";s:29:\"http://instagram.com/radyoyol\";s:9:\"is_active\";b:1;}s:8:\"facebook\";a:2:{s:3:\"url\";s:40:\"https://www.facebook.com/radyoyol.com.tr\";s:9:\"is_active\";b:1;}s:6:\"tiktok\";a:2:{s:3:\"url\";s:31:\"https://www.tiktok.com/radyoyol\";s:9:\"is_active\";b:1;}s:7:\"youtube\";a:2:{s:3:\"url\";s:32:\"https://www.youtube.com/radyoyol\";s:9:\"is_active\";b:1;}s:1:\"x\";a:2:{s:3:\"url\";s:0:\"\";s:9:\"is_active\";b:1;}s:11:\"android_app\";a:2:{s:3:\"url\";s:61:\"https://play.google.com/store/apps/details?id=radyoyol.com.tr\";s:9:\"is_active\";b:1;}s:7:\"ios_app\";a:2:{s:3:\"url\";s:61:\"https://play.google.com/store/apps/details?id=radyoyol.com.tr\";s:9:\"is_active\";b:1;}s:6:\"winamp\";a:2:{s:3:\"url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.pls\";s:9:\"is_active\";b:1;}s:12:\"media_player\";a:2:{s:3:\"url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.asx\";s:9:\"is_active\";b:1;}s:9:\"quicktime\";a:2:{s:3:\"url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.qtl\";s:9:\"is_active\";b:1;}s:11:\"real_player\";a:2:{s:3:\"url\";s:44:\"https://r1.comcities.com/tunein/radyoyol.ram\";s:9:\"is_active\";b:1;}}',1773001230),('laravel-cache-site_settings_telegram_active','b:1;',1773001230),('laravel-cache-site_settings_telegram_url','s:0:\"\";',1773001230),('laravel-cache-site_settings_tiktok_active','b:1;',1773001230),('laravel-cache-site_settings_tiktok_url','s:31:\"https://www.tiktok.com/radyoyol\";',1773001230),('laravel-cache-site_settings_whatsapp_active','b:1;',1773001230),('laravel-cache-site_settings_whatsapp_url','s:27:\"https://wa.me/4917620059161\";',1773001230),('laravel-cache-site_settings_winamp_active','b:1;',1773001230),('laravel-cache-site_settings_winamp_url','s:44:\"https://r1.comcities.com/tunein/radyoyol.pls\";',1773001230),('laravel-cache-site_settings_x_active','b:1;',1773001230),('laravel-cache-site_settings_x_url','s:0:\"\";',1773001230),('laravel-cache-site_settings_youtube_active','b:1;',1773001230),('laravel-cache-site_settings_youtube_url','s:32:\"https://www.youtube.com/radyoyol\";',1773001230);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dj_profiles`
--

DROP TABLE IF EXISTS `dj_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dj_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initials` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_live` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dj_profiles`
--

LOCK TABLES `dj_profiles` WRITE;
/*!40000 ALTER TABLE `dj_profiles` DISABLE KEYS */;
INSERT INTO `dj_profiles` VALUES (1,'Dj Desmal','Yöresel Ezgiler Kürtce','DE','djs/K2fiEcOIVi8K9ptBWR6nqz0H3xdI4dRCnNJFFQgZ.jpg',1,'2026-03-04 09:52:36','2026-03-08 02:47:41'),(2,'ozocan','Yöresel Ezgiler Kürtce',NULL,'djs/KEYjKOEazypt5zRJnd3d76ZSPp1kXuDH5lY0pE1D.jpg',0,'2026-03-04 10:16:07','2026-03-08 02:48:32'),(3,'Markaz','Gurbetten SILAYA','DE','djs/9cEnr8rHZgt325E7XcJs2BA6fP75zRLUOENeD8Ca.jpg',0,'2026-03-04 10:17:09','2026-03-04 10:17:09'),(4,'Fido','Yöresel Ezgiler Kürtce','DE','djs/U5UvZNkt0ynket5AO5R5zKP53qPP6mKcvVnkFRaq.jpg',0,'2026-03-04 10:59:07','2026-03-08 02:48:22');
/*!40000 ALTER TABLE `dj_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_comments`
--

DROP TABLE IF EXISTS `forum_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_comments_user_id_foreign` (`user_id`),
  KEY `forum_comments_post_id_index` (`post_id`),
  CONSTRAINT `forum_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `forum_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_comments`
--

LOCK TABLES `forum_comments` WRITE;
/*!40000 ALTER TABLE `forum_comments` DISABLE KEYS */;
INSERT INTO `forum_comments` VALUES (1,1,1,'selamlar arkadaslar','2026-03-05 17:57:54','2026-03-05 17:57:54');
/*!40000 ALTER TABLE `forum_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_posts`
--

DROP TABLE IF EXISTS `forum_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `approval_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forum_posts_slug_unique` (`slug`),
  KEY `forum_posts_user_id_foreign` (`user_id`),
  KEY `forum_posts_type_created_at_index` (`type`,`created_at`),
  CONSTRAINT `forum_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_posts`
--

LOCK TABLES `forum_posts` WRITE;
/*!40000 ALTER TABLE `forum_posts` DISABLE KEYS */;
INSERT INTO `forum_posts` VALUES (1,1,'photo','cacoali','cacoali','iyi yayinlar severek dinliyorum',NULL,'uploads/forum/photos/Fgqic54u6yYfHRAuk9qDgRxawjAUkbRVJb4hh23o.jpg','pro_2.jpg','photo','open','approved','2026-03-05 17:02:40','2026-03-05 17:51:04'),(2,1,'complaint','yayin','yayin','merhabalar yayin durmadan kesiliyor',NULL,NULL,NULL,NULL,'open','approved','2026-03-05 18:47:18','2026-03-05 18:47:18'),(3,1,'video','iltica','iltica','yeni eserimiz iyi yayinlar',NULL,'uploads/listener/videos/ehDF4HUZwcywplUFBn8MaCDkWAn80x78tmQpnQQp.mp4','0305.mp4','video','open','approved','2026-03-05 18:59:19','2026-03-05 18:59:41');
/*!40000 ALTER TABLE `forum_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_photos`
--

DROP TABLE IF EXISTS `gallery_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `album_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_cover` tinyint(1) NOT NULL DEFAULT '0',
  `is_announcement` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_photos_album_id_foreign` (`album_id`),
  CONSTRAINT `gallery_photos_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `photo_albums` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_photos`
--

LOCK TABLES `gallery_photos` WRITE;
/*!40000 ALTER TABLE `gallery_photos` DISABLE KEYS */;
INSERT INTO `gallery_photos` VALUES (1,1,'radyoyol','radyoyol türkülerin susmayan sesi','uploads/gallery/photos/69ad18616d54c_e279f858-3b9d-4898-be0b-e586e0c9dc2c.png',0,0,1,0,'2026-03-08 05:34:09','2026-03-08 05:34:09'),(2,NULL,'2015 yılında yayın hayatına başlayan Radyo Yol','Günün her bölümünde farklı programları ile dinleyenlerini sıkmayan ve canlılık katan programcılık anlayışı ile dinleyicilerini kendilerine bağlamayı başarıyorlar. Hayata karşı motive olmada etkili rol oynamayı tercih eden bir nevi dinleyenlerine koçluk görevi yapıyor. Kesintisiz Radyo Yol için internet sitemizi tercih edin. Ayrıca tüm akıllı cihazlardan da 24 saat Radyo Yol dinleyebilirsiniz. Sıkmadan reklamcılık anlayışı ile aşırı yoğun reklamlardan kaçınan ama reklamsız da olmayacağını tatlı bir şekilde dinleyenlerine aktarıyor. Hazırlanan özgün','uploads/gallery/photos/69ad1b6eb1529_2e1e19b9-ab8e-4903-bb35-61837caeb3fe.png',0,0,1,0,'2026-03-08 05:47:10','2026-03-08 05:47:10'),(3,1,NULL,NULL,'uploads/gallery/photos/69ad1fa28f6cd_2e1e19b9-ab8e-4903-bb35-61837caeb3fe.png',0,0,1,0,'2026-03-08 06:05:06','2026-03-08 06:05:06'),(4,1,NULL,NULL,'uploads/gallery/photos/69ad1fa2917b3_e279f858-3b9d-4898-be0b-e586e0c9dc2c.png',0,0,1,0,'2026-03-08 06:05:06','2026-03-08 06:05:06'),(5,1,NULL,NULL,'uploads/gallery/photos/69ad1fa291dab_ed37b622-a34d-451a-879a-d375779c2b4e.png',0,0,1,0,'2026-03-08 06:05:06','2026-03-08 06:05:06'),(6,3,NULL,NULL,'uploads/gallery/photos/69ad246cf1d9b_1.jpg',0,0,1,0,'2026-03-08 06:25:32','2026-03-08 06:25:32'),(7,3,NULL,NULL,'uploads/gallery/photos/69ad246cf3b01_2.jpg',0,0,1,0,'2026-03-08 06:25:32','2026-03-08 06:25:32'),(8,3,NULL,NULL,'uploads/gallery/photos/69ad246cf4053_3.jpg',0,0,1,0,'2026-03-08 06:25:32','2026-03-08 06:25:32'),(9,3,NULL,NULL,'uploads/gallery/photos/69ad246d00448_4.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(10,3,NULL,NULL,'uploads/gallery/photos/69ad246d009f1_5.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(11,3,NULL,NULL,'uploads/gallery/photos/69ad246d00ee9_6.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(12,3,NULL,NULL,'uploads/gallery/photos/69ad246d01388_7.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(13,3,NULL,NULL,'uploads/gallery/photos/69ad246d0189e_8.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(14,3,NULL,NULL,'uploads/gallery/photos/69ad246d01ceb_9.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(15,3,NULL,NULL,'uploads/gallery/photos/69ad246d0219f_10.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(16,3,NULL,NULL,'uploads/gallery/photos/69ad246d0266b_11.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(17,3,NULL,NULL,'uploads/gallery/photos/69ad246d02af5_12.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(18,3,NULL,NULL,'uploads/gallery/photos/69ad246d02f6d_13.jpg',0,0,1,0,'2026-03-08 06:25:33','2026-03-08 06:25:33'),(19,NULL,'RadyoYoldan duyuru Yeni web site tasarim','RadyoYoldan duyuru Yeni web site tasarim','uploads/gallery/photos/69ad27a5a471c_arkaplan.png',0,1,1,0,'2026-03-08 06:39:17','2026-03-08 06:39:17'),(20,NULL,'radyoyol türküler',NULL,'uploads/gallery/photos/69ad2e926eaa4_2.jpg',0,0,1,0,'2026-03-08 07:08:50','2026-03-08 07:08:50'),(21,NULL,'Elif Anna',NULL,'uploads/gallery/photos/69ad2ebef0ebc_11.jpg',0,0,1,0,'2026-03-08 07:09:34','2026-03-08 07:09:34');
/*!40000 ALTER TABLE `gallery_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"2e1f07d2-2a5c-4c35-95c1-7b257caa7a68\",\"displayName\":\"App\\\\Notifications\\\\PasswordChangedByUser\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\PasswordChangedByUser\\\":2:{s:11:\\\"\\u0000*\\u0000siteName\\\";s:9:\\\"Radyo Yol\\\";s:2:\\\"id\\\";s:36:\\\"581ed774-316e-409e-bc67-a7480c113c5e\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\",\"batchId\":null},\"createdAt\":1772745580,\"delay\":null}',0,NULL,1772745580,1772745580);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_submissions`
--

DROP TABLE IF EXISTS `member_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_submissions_user_id_status_index` (`user_id`,`status`),
  KEY `member_submissions_created_at_index` (`created_at`),
  CONSTRAINT `member_submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_submissions`
--

LOCK TABLES `member_submissions` WRITE;
/*!40000 ALTER TABLE `member_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location` enum('header','footer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('page','url') COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `target_blank` tinyint unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_location_index` (`location`),
  KEY `menu_items_parent_id_index` (`parent_id`),
  KEY `menu_items_sort_order_index` (`sort_order`),
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,'header','Anasayfa','page','/',NULL,0,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(2,'header','Programlar','page','/programlar',NULL,1,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(3,'header','Haberler','page','/haberler',NULL,2,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(4,'header','Video Galeri','page','/videolar',17,0,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(5,'header','Foto Galeri','page','/galeri',17,1,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(6,'header','Sponsorlar','page','/sponsorlar',NULL,3,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(7,'header','Hakkimizda','page','/hakkimizda/biz-kimiz',NULL,4,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(8,'header','Iletisim','page','/iletisim',NULL,5,0,1,'2026-03-04 18:11:00','2026-03-05 16:15:12'),(9,'header','Biz Kimiz','page','/hakkimizda/biz-kimiz',7,0,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(10,'header','Misyon & Vizyon','page','/hakkimizda/misyon',7,1,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(11,'header','Yayin Politikamiz','page','/hakkimizda/politika',7,2,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(12,'footer','Gizlilik Politikasi','page','/gizlilik',NULL,0,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(13,'footer','Cerez Politikasi','page','/cerez',NULL,1,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(14,'footer','Kullanim Sartlari','page','/kullanim',NULL,2,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(15,'footer','KVKK Aydinlatma Metni','page','/kvkk',NULL,3,0,1,'2026-03-04 18:11:00','2026-03-04 18:11:00'),(17,'header','Medya','page','/videolar',NULL,3,0,1,'2026-03-05 16:15:12','2026-03-05 16:15:12');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `programci_id` bigint unsigned DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_programci_id_foreign` (`programci_id`),
  KEY `messages_user_id_foreign` (`user_id`),
  CONSTRAINT `messages_programci_id_foreign` FOREIGN KEY (`programci_id`) REFERENCES `programcilar` (`id`) ON DELETE SET NULL,
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,13,'Programc─▒ ─░leti┼şim: ALi Celik','selamlar nasilsiniz canlar','failed','2026-03-05 16:45:48','2026-03-05 16:45:48'),(2,1,13,'Programc─▒ ─░leti┼şim: ALi Celik','selam canlar nasilsiniz','sent','2026-03-05 17:16:04','2026-03-05 17:16:04'),(3,1,15,'Programc─▒ ─░leti┼şim: yolcu','merhabalar nasilsiniz deneme','sent','2026-03-05 17:26:32','2026-03-05 17:26:32'),(4,1,NULL,'─░leti┼şim Formu','selamlar nasilsinizdsfsdfsdfsdfsdfsd','sent','2026-03-05 18:00:14','2026-03-05 18:00:14'),(5,1,NULL,'video klip','Ad: ali  celik\nE-posta: yolgrafik46@gmail.com\nTelefon: -\n\nmerhabalar canlar size ulasmak istiyorum','sent','2026-03-05 18:23:26','2026-03-05 18:23:26');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_03_03_000001_create_settings_table',1),(5,'2025_03_03_000002_add_player_settings_to_settings_table',1),(6,'2025_03_03_000003_add_shoutcast_settings',1),(7,'2025_03_03_100000_create_site_settings_table',1),(8,'2025_03_03_200001_create_roles_table',1),(9,'2025_03_03_200002_create_permissions_table',1),(10,'2025_03_03_200003_create_admins_table',1),(11,'2025_03_03_200004_create_role_permission_table',1),(12,'2025_03_03_200005_create_admin_activity_logs_table',1),(13,'2025_03_03_200006_create_admin_two_factor_table',1),(14,'2025_03_03_200007_seed_roles_and_permissions',1),(15,'2025_03_03_200008_seed_default_admin',1),(16,'2025_03_03_210000_add_avatar_path_to_admins_table',1),(17,'2025_03_03_220000_create_song_requests_table',1),(18,'2025_03_03_230000_make_email_nullable_in_song_requests',1),(19,'2025_03_03_300001_create_sliders_table',1),(20,'2025_03_03_310000_create_blacklist_table',2),(21,'2025_03_03_320000_create_schedules_table',3),(22,'2025_03_03_330000_create_dj_profiles_table',4),(23,'2025_03_03_340000_add_dj_id_to_schedules_table',5),(25,'2025_03_03_120000_create_site_theme_settings_table',6),(26,'2025_03_03_341000_backfill_schedule_dj_id_from_host',6),(27,'2025_03_03_150000_create_site_theme_table',7),(28,'2025_03_03_200000_add_button_schedule_colors_to_site_theme',8),(30,'2025_03_03_210000_add_line_color_to_site_theme',9),(31,'2025_03_04_100000_create_menu_items_table',10),(32,'2025_03_04_120000_create_schedule_presets_table',11),(33,'2025_03_04_150000_add_radio_force_status',12),(34,'2025_03_04_160000_add_description_to_schedules',13),(35,'2025_03_04_170000_create_programcilar_table',14),(36,'2025_03_04_170001_add_programci_id_to_schedules_table',14),(37,'2026_03_05_165738_create_messages_table',15),(38,'2026_03_05_180000_restructure_menu_media_dropdown',16),(39,'2026_03_06_100000_add_status_to_users_table',17),(40,'2026_03_06_100001_create_member_submissions_table',17),(41,'2026_03_06_100002_seed_member_settings',17),(42,'2026_03_06_120000_seed_mail_settings',18),(43,'2026_03_06_140000_create_forum_tables',19),(44,'2026_03_06_150000_add_attachments_to_forum_posts',20),(45,'2026_03_06_160000_rename_menu_item_reklam_to_sponsorlar',21),(46,'2026_03_06_170000_add_approval_status_to_forum_posts',22),(47,'2026_03_06_180000_make_messages_user_id_nullable',23),(48,'2026_03_06_180000_add_member_max_video_size_mb',24),(49,'2026_03_07_100000_update_user_status_to_aktif_pasif_ban',25),(50,'2026_03_08_100000_add_dmca_to_footer_legal_links',26),(51,'2026_03_07_180000_create_news_table',27),(52,'2026_03_07_181000_normalize_news_tables',27),(53,'2026_03_07_190000_extend_news_for_media_support',27),(54,'2026_03_08_130000_create_about_pages_table',28),(55,'2026_03_08_150000_add_reklam_to_about_pages',29),(56,'2026_03_08_170000_create_artist_videos_table',30),(57,'2026_03_08_180000_add_is_featured_to_artist_videos_table',31),(58,'2026_03_08_190000_create_photo_gallery_tables',32),(59,'2026_03_08_191000_add_fields_to_gallery_photos_table',33),(60,'2026_03_08_192000_make_album_optional_in_gallery_photos',34),(61,'2026_03_08_193000_change_short_description_to_text_in_gallery_photos',35),(62,'2026_03_08_194000_add_cover_image_to_photo_albums',36),(63,'2026_03_08_201000_add_is_announcement_to_gallery_photos_table',37),(64,'2026_03_08_203000_create_sponsors_table',38),(65,'2026_03_08_220000_add_slug_and_description_to_sponsors_table',39),(66,'2026_03_08_230000_add_video_fields_to_sponsors_table',40),(67,'2026_03_09_120000_add_images_to_sponsors_table',41),(68,'2026_03_09_150000_fix_sponsorlar_menu_url',42),(69,'2026_03_08_235000_add_video_poster_to_sponsors_table',43);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'RadyoYol Yeni Sitesi Yayında: Daha Hızlı ve Modern Deneyim','radyoyol-yeni-sitesi-yayinda-daha-hizli-ve-modern-deneyim','RadyoYol yenilenen arayüzü ve performans iyileştirmeleriyle yayında.','RadyoYol yeni web sitesi; daha hızlı sayfa geçişleri, mobil uyumluluk ve geliştirilmiş canlı yayın deneyimi ile kullanıcılarla buluştu. Yeni altyapı sayesinde içerikler daha stabil ve daha hızlı yükleniyor.',NULL,1,'2026-03-08 02:41:51','2026-03-08 02:54:57','uploads/news/69acf311db500_2e1e19b9-ab8e-4903-bb35-61837caeb3fe.png',NULL),(2,'Yeni Haberler Alanı ile Güncel İçerikler Tek Noktada','yeni-haberler-alani-ile-guncel-icerikler-tek-noktada','Haberler bölümüyle RadyoYol duyuruları artık daha düzenli.','Siteye eklenen Haberler alanı sayesinde yayın, program ve platform duyuruları tek bir merkezde toplandı. Kullanıcılar en yeni gelişmelere anasayfadan kolayca ulaşabiliyor.',NULL,1,'2026-03-08 02:41:51','2026-03-08 02:55:09','uploads/news/69acf31d88788_e279f858-3b9d-4898-be0b-e586e0c9dc2c.png',NULL),(3,'Gelişmiş Mobil Uyum: RadyoYol Her Ekranda Hazır','gelismis-mobil-uyum-radyoyol-her-ekranda-hazir','Yeni tasarım telefon ve tabletlerde daha akıcı kullanım sunuyor.','RadyoYol yeni teması mobil cihazlar için optimize edildi. Menü, oynatıcı ve içerik blokları farklı ekran boyutlarında daha okunabilir ve daha kullanışlı hale getirildi.',NULL,1,'2026-03-08 02:41:51','2026-03-08 02:55:20','uploads/news/69acf32840b5e_ed37b622-a34d-451a-879a-d375779c2b4e.png',NULL),(4,'Canlı Yayın ve Program Akışı Bileşenleri Yenilendi','canli-yayin-ve-program-akisi-bilesenleri-yenilendi','Program akış kartları ve canlı yayın göstergeleri güçlendirildi.','Yeni sürümle birlikte canlı yayın alanı, program akışı gösterimi ve ilgili bileşenler güncellendi. Dinleyiciler artık yayındaki içerikleri daha net ve anlık takip edebiliyor.',NULL,1,'2026-03-08 02:41:51','2026-03-08 02:41:51',NULL,NULL),(5,'RadyoYol Altyapısı Güncellendi: Daha Güvenli ve Kararlı','radyoyol-altyapisi-guncellendi-daha-guvenli-ve-kararli','Arka plan iyileştirmeleriyle kesintisiz deneyim hedefleniyor.','Veritabanı ve uygulama altyapısında yapılan teknik iyileştirmelerle RadyoYol daha güvenli ve daha kararlı bir yapıya kavuştu. Bu güncellemeler site sürekliliği ve performansa doğrudan katkı sağlıyor.',NULL,1,'2026-03-08 02:41:51','2026-03-08 02:41:51',NULL,NULL),(6,'Kadir gecesi ve Aleviler','kadir-gecesi-ve-aleviler-kaynak-linki-httpswwwalevihaberlercomtrhaberkadir-gecesi-ve-aleviler-904','Alevilerin Kadir gecesi hakkında yaklaşımları merak ediliyor. Bu yazımızda, hem Ramazan ayı içerisinde bulunan Kadir gecesi hakkındaki ve hem de Kadir gecesi ile bağlantılı olarak Alevilerin tuttuğu 3 günlük oruç hakkındaki görüşleri derledik.\r\n\r\nKaynak Linki = https://www.alevihaberler.com.tr/haber/kadir-gecesi-ve-aleviler-904','Kadir Gecesi, Ramazan ayının 27. gecesi olan 26 Mart 2025 Çarşamba gününe geliyor. Kadir gecesi, Kur’ân-ı Kerîm’in indirilmeye başlandığı gece olarak bilinir. Kadr sûresinde verilen bilgiler, Kur’an’ın ramazan ayında (el-Bakara 2/185) ve bütün hikmetli işlerin kararlaştırıldığı mübarek bir gecede (ed-Duhân 44/3-4) indirildiğine dair âyetlerle birlikte ele alındığında Kadir gecesinin ramazan ayı içinde bulunduğu sonucu ortaya çıkar. Bakara suresi 185.ayette “sizden bu ayı idrak eden,onda oruç tutsun” buyruğuna uyan Aleviler Ramazan ayında Kadir gecesi önünde ve arkasında olarak 3 gün oruç tutarlar. Öte yandan, Alevilerde Kadir Gecesi, genel olarak Sünni İslam’daki gibi özel bir kandil gecesi olarak kutlanmaz veya aynı şekilde vurgulanmaz. Alevilerde bu geceye dair özel bir kutlama ya da ibadet geleneği yaygın değildir. Alevilik, İslam’ın kendine özgü bir yorumunu benimseyen bir inanç sistemi olup, ibadet ve ritüellerinde Sünni İslam’dan farklı uygulamalar ön plandadır. Kadir Gecesi, İslam dünyasında Kur’an’ın Hz. Muhammed’e vahiy yoluyla inmeye başladığı gece olarak Ramazan ayının son günlerinde (çoğunlukla 27. gece) büyük bir önem taşır ve özel ibadetlerle geçirilir. Aleviler Kadir Gecesi’ni tamamen yok saymazlar; ancak bu geceyi, Sünni Müslümanların yaptığı gibi camilerde namaz kılma, Kur’an okuma veya kandil kutlamalarıyla değil, daha çok kendi inanç sistemleri içindeki anlamlarla değerlendirirler. Bu noktada öne çıkan ibadet türü, Kadir gecesi ile bağlantılı olarak tutulan 3 günlük oruçtur. Bu konuda görüşlerini açıklayan Cemil Kılıç şöyle diyor: “Ramazan orucu, Alevi inancına göre farz olarak kabul edilse de, gün sayısı olarak bir aylık süreyi ifade etmez. Üç gün oruç tutmanın yeterli olacağı düşünülür. Ayrıca bu üç günün de hangi günler olduğu kesin belli değildir. Bir görüşe göre 3 gün dolunay günleridir. Bir başka görüşe göre ise 19- 20- 21. günlerdir. Bu günler, Hz. Ali’nin yaralanıp şehit olduğu günlerdir. Bir başka görüş de Kadir Gecesi ile başlayan günlerdir.” Aynı konuda görüşlerini açıklayan Seyyid Seyfeddin Ocağı evlatlarından Seyyid Hakkı ise şöyle diyor: “Aleviler açısından Ramazan Ayı’nın 19, 20 ve 21’de Şahı Merdan Ali’nin niyetine, yapılan matemdir, tutulan matem orucudur. Bu üç günlük matem veya matem orucunun, 30 günlük Ramazan orucu ile hiç bir alakası yoktur.” Alevilikte, Kur’an’ın zahiri (dışsal) anlamından ziyade batıni (içsel) yorumuna vurgu yapılır ve bu bağlamda Kadir Gecesi’nin manevi önemi, bireysel bir tefekkür veya cem ibadeti içinde ele alınabilir. “Senin dervişlerin semahı döner Kadir gecesi çırağlar yanar İnşallah yükümüz dergâhı tutar Gel dinim imanım İmam Hüseyin   Abdal Pir Sultanım imamlar nerde Aşkına nur doldurduğumuz yerde Kendi sırda kaygısız ehil yerde Gel dinim imanım İmam Hüseyin” KADİR GECESİ DUASI “Allahümme inneke afüvvün kerîmün tuhibbül afve fa’fü anni.” Allah’ım sen affedicisin, affı seversin, beni affeyle. Bu duayla birlikte, Fatiha, Nas gibi bilinen tüm dualar okunabilir. KADİR SURESİ NASIL OKUNUR? “İnna enzelnahü fiy leyletilkadr. Ve ma edrake ma leyletülkadr. Leyletülkadri hayrün min elfi şehr. Tenezzelülmelaiketü verruhu fiyha biizni rabbihim min külli emr. Selamün hiye hatta matle\'ılfecr.” KADİR SURESİNİN TÜRKÇE ANLAMI NEDİR? Şüphesiz, biz onu (Kur\'an\'ı) Kadir gecesinde indirdik. Kadir gecesinin ne olduğunu sen ne bileceksin! Kadir gecesi bin aydan daha hayırlıdır. Melekler ve Ruh (Cebrail) o gecede, Rablerinin izniyle her türlü iş için iner de iner. O gece, tan yerinin ağarmasına kadar bir esenliktir.\r\n\r\nKaynak Linki = https://www.alevihaberler.com.tr/haber/kadir-gecesi-ve-aleviler-904',NULL,1,'2026-03-08 02:53:05','2026-03-08 02:54:03','uploads/news/69acf2a183061_kadir-gecesi-ve-aleviler-1742935478.webp',NULL);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_media`
--

DROP TABLE IF EXISTS `news_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `news_id` bigint unsigned NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_media_news_id_sort_order_index` (`news_id`,`sort_order`),
  KEY `news_media_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_media`
--

LOCK TABLES `news_media` WRITE;
/*!40000 ALTER TABLE `news_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('yolgrafik46@gmail.com','$2y$12$M21fT6cpmWeBkw.Aw5/lUe2egsl3aemhezTzuFXgpiJ6EjOR8wBq2','2026-03-05 20:14:15');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'news.view','Haber G├Âr├╝nt├╝leme','2026-03-04 06:11:51','2026-03-04 06:11:51'),(2,'news.create','Haber Olu┼şturma','2026-03-04 06:11:51','2026-03-04 06:11:51'),(3,'news.edit','Haber D├╝zenleme','2026-03-04 06:11:51','2026-03-04 06:11:51'),(4,'news.delete','Haber Silme','2026-03-04 06:11:51','2026-03-04 06:11:51'),(5,'settings.manage','Ayarlar Y├Ânetimi','2026-03-04 06:11:51','2026-03-04 06:11:51'),(6,'users.manage','Kullan─▒c─▒ Y├Ânetimi','2026-03-04 06:11:51','2026-03-04 06:11:51'),(7,'ads.manage','Reklam Y├Ânetimi','2026-03-04 06:11:51','2026-03-04 06:11:51'),(8,'messages.moderate','Mesaj Moderasyon','2026-03-04 06:11:51','2026-03-04 06:11:51'),(9,'logs.view','Aktivite Loglar─▒ G├Âr├╝nt├╝leme','2026-03-04 06:11:51','2026-03-04 06:11:51');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_albums`
--

DROP TABLE IF EXISTS `photo_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo_albums` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `photo_albums_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_albums`
--

LOCK TABLES `photo_albums` WRITE;
/*!40000 ALTER TABLE `photo_albums` DISABLE KEYS */;
INSERT INTO `photo_albums` VALUES (1,'radyoyol','radyoyol-QfZD','Türkülein susmayan sesi',NULL,1,0,'2026-03-08 05:33:35','2026-03-08 05:33:35'),(2,'Yöresel Resimler','yoresel-resimler-UM8B',NULL,'uploads/gallery/albums/69ad2018ee08a_ed37b622-a34d-451a-879a-d375779c2b4e.png',1,0,'2026-03-08 06:07:04','2026-03-08 06:07:04'),(3,'Alevi Resimleri','alevi-resimleri-Hpl4',NULL,'uploads/gallery/albums/69ad2459bef3c_1.jpg',1,0,'2026-03-08 06:25:13','2026-03-08 06:25:13');
/*!40000 ALTER TABLE `photo_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programcilar`
--

DROP TABLE IF EXISTS `programcilar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programcilar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kisa_aciklama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uzun_aciklama` longtext COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `sira` int unsigned NOT NULL DEFAULT '0',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `programcilar_slug_unique` (`slug`),
  KEY `programcilar_slug_index` (`slug`),
  KEY `programcilar_aktif_index` (`aktif`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programcilar`
--

LOCK TABLES `programcilar` WRITE;
/*!40000 ALTER TABLE `programcilar` DISABLE KEYS */;
INSERT INTO `programcilar` VALUES (1,'Fido','fido','programcilar/y9l50s7OGwsZdCCfYWwC6vfuIMdGVOaZXx7JSo0q.jpg','Heybemdeki T├╝rk├╝ler','Fido, y─▒llard─▒r radyomuzda T├╝rk halk m├╝zi─şinin en g├╝zel ├Ârneklerini dinleyicilerle bulu┼şturuyor. Heybemdeki T├╝rk├╝ler program─▒ ile Anadolu\'nun d├Ârt bir yan─▒ndan t├╝rk├╝leri sizlere ula┼şt─▒r─▒yor.','fido@radyoyol.com','https://instagram.com/fido','https://facebook.com/fido',NULL,'https://youtube.com/@fido',NULL,1,1,NULL,NULL,NULL,'2026-03-05 14:35:22','2026-03-05 14:42:31'),(2,'Markaz','markaz',NULL,'Gurbetten S─░LAYA','Markaz, gurbet├ği dinleyicilerimiz i├ğin ├Âzel haz─▒rlad─▒─ş─▒ Gurbetten S─░LAYA program─▒ ile memleket hasretini gideriyor. Her hafta en sevilen t├╝rk├╝ler ve an─▒lar sizlerle.','markaz@radyoyol.com','https://instagram.com/markaz','https://facebook.com/markaz',NULL,'https://youtube.com/@markaz',NULL,1,2,NULL,NULL,'2026-03-05 14:45:20','2026-03-05 14:35:22','2026-03-05 14:45:20'),(3,'Ozocan','ozocan',NULL,'Yol T├╝rk├╝leri','Ozocan ile Yol T├╝rk├╝leri program─▒nda, yollara d├╝┼şenlerin t├╝rk├╝lerini dinliyoruz. Uzun yollar, g├╝zel an─▒lar ve unutulmaz melodiler.','ozocan@radyoyol.com','https://instagram.com/ozocan','https://facebook.com/ozocan','https://tiktok.com/@ozocan','https://youtube.com/@ozocan',NULL,1,3,NULL,NULL,'2026-03-05 14:45:17','2026-03-05 14:35:22','2026-03-05 14:45:17'),(4,'ALi Celik','ali-celik','programcilar/FqeIkdb9qleFSlxZGF6e5MeBULGwVbrUFAgUwpE2.jpg','Heybemdeki T├╝rk├╝ler','radyoyol yayinci kurucu','radyoyoltv@gmail.com','https://instagram.com/alicelik02','https://facebook.com/alicelik02','https://www.tiktok.com/radyoyol','https://youtube.com/@radyoyol','https://radyoyol.de/',1,1,'radyoyol','radyoyol,','2026-03-05 15:09:17','2026-03-05 15:03:06','2026-03-05 15:09:17'),(11,'ozocan','ozocan-1','programcilar/YkQhT0FWNljcCNupNHfBEowkcyJh7AjwnzDWnqeG.jpg','Heybemdeki T├╝rk├╝ler',NULL,'ozocan46@gmail.com',NULL,NULL,NULL,NULL,NULL,1,0,NULL,NULL,NULL,'2026-03-05 15:08:24','2026-03-05 15:08:24'),(12,'MaRKAZ','markaz-1','programcilar/XcCDEKy65ftShNuT6vfmRHU2tLXQxMXaHiGIO0Hc.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,NULL,NULL,'2026-03-05 15:08:45','2026-03-05 15:08:45'),(13,'ALi Celik','yolcu','programcilar/qE8MR6f2OMwgkZyRFGPJZ4stldU01urhZYSAQRXh.jpg','Yöresel Ezgiler Kürtce','Radyo Yol, internet üzerinden yayın yapan bir radyodur. 2015 yılında yayın hayatına başlamıştır. Din, dil, renk ayrımı yapmadan hep birlikte türkülerler var olmaya çalışmaktadır. Kurulduğu günden bu yana kendine has bir dinleyici kitlesine sahip Türkü radyoları arasına girmeyi başarmıştır.\r\n\r\nRadyo Yol, “Türkülerin Yeni Yolu” sloganı ile internet üzerinden yayınları günün her saatinde kesintisiz ve canlı olarak dinlenebilmektedir. Yayın akışını Türküler, kürtçe deyişler, semahlar, halaylar, özgün müzik ve yöresel şarkılar oluşturmaktadır. Yolu türküden geçenlerin buluştuğu bir radyo kanalıdır.','radyoyoltv@gmail.com','https://instagram.com/alicelik02','https://facebook.com/alicelik02','https://www.tiktok.com/radyoyol','https://www.youtube.com/radyoyol','https://radyoyol.de/',1,0,'radyoyol',NULL,NULL,'2026-03-05 15:09:51','2026-03-08 02:49:45'),(14,'Koma Zarin','koma-zarin','programcilar/RLwizxNX5S75DEKxiP22Qh0ka8TZPrFNDby01YTG.jpg','Kürtce zazaca ezgiler','Radyo Yol, internet üzerinden yayın yapan bir radyodur. 2015 yılında yayın hayatına başlamıştır. Din, dil, renk ayrımı yapmadan hep birlikte türkülerler var olmaya çalışmaktadır. Kurulduğu günden bu yana kendine has bir dinleyici kitlesine sahip Türkü radyoları arasına girmeyi başarmıştır.\r\n\r\nRadyo Yol, “Türkülerin Yeni Yolu” sloganı ile internet üzerinden yayınları günün her saatinde kesintisiz ve canlı olarak dinlenebilmektedir. Yayın akışını Türküler, kürtçe deyişler, semahlar, halaylar, özgün müzik ve yöresel şarkılar oluşturmaktadır. Yolu türküden geçenlerin buluştuğu bir radyo kanalıdır.','komazarin@gmail.com','https://instagram.com/alicelik02','https://facebook.com/alicelik02','https://www.tiktok.com/radyoyol','https://www.youtube.com/radyoyol','https://radyoyol.de/',1,0,NULL,NULL,NULL,'2026-03-05 15:30:18','2026-03-08 02:50:04'),(15,'yolcu','desmal','programcilar/PZPLlXQXukwDyVOqoS1kMRFJAS2SobDa9oeoSQaq.jpg','yolunuz yolumuzdur',NULL,'alicelikx02@gmail.com','https://instagram.com/alicelik02','https://facebook.com/alicelik02','https://www.tiktok.com/radyoyol','https://www.youtube.com/radyoyol','https://radyoyol.de/',1,0,'radyoyol',NULL,NULL,'2026-03-05 17:24:42','2026-03-05 17:26:00');
/*!40000 ALTER TABLE `programcilar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permission` (
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_permission_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','2026-03-04 06:11:51','2026-03-04 06:11:51'),(2,'Editor','2026-03-04 06:11:51','2026-03-04 06:11:51'),(3,'Moderator','2026-03-04 06:11:51','2026-03-04 06:11:51'),(4,'DJ','2026-03-04 06:11:51','2026-03-04 06:11:51');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_presets`
--

DROP TABLE IF EXISTS `schedule_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule_presets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_presets`
--

LOCK TABLES `schedule_presets` WRITE;
/*!40000 ALTER TABLE `schedule_presets` DISABLE KEYS */;
INSERT INTO `schedule_presets` VALUES (1,'Sabah Kuşağı','06:00:00','10:00:00',1,'2026-03-05 12:00:16','2026-03-07 00:00:43'),(2,'Öğle Kuşağı','12:00:00','15:00:00',2,'2026-03-05 12:00:16','2026-03-07 00:06:22'),(3,'├û─şleden Sonra','15:00:00','18:00:00',3,'2026-03-05 12:00:16','2026-03-05 12:00:16'),(4,'Akşam kuşağı','18:00:00','22:00:00',4,'2026-03-05 12:00:16','2026-03-07 00:01:39'),(5,'Y├Âresel Halaylar','20:00:00','23:00:00',5,'2026-03-05 12:01:24','2026-03-05 12:01:24');
/*!40000 ALTER TABLE `schedule_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `day_of_week` tinyint unsigned NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dj_id` bigint unsigned DEFAULT NULL,
  `programci_id` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_dj_id_foreign` (`dj_id`),
  KEY `schedules_programci_id_foreign` (`programci_id`),
  CONSTRAINT `schedules_dj_id_foreign` FOREIGN KEY (`dj_id`) REFERENCES `dj_profiles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `schedules_programci_id_foreign` FOREIGN KEY (`programci_id`) REFERENCES `programcilar` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,0,'09:00:00','12:00:00','Sabah Kusagi','Türkülerin Susmayan sesi','DJ Ali',2,NULL,1,0,'2026-03-04 07:23:05','2026-03-06 23:58:09'),(2,0,'12:00:00','15:00:00','Öğle Yayını',NULL,'Desmal',3,NULL,1,1,'2026-03-04 07:23:05','2026-03-04 10:57:28'),(3,0,'15:00:00','18:00:00','Öğleden Sonra',NULL,'DJ Ay┼şe',NULL,NULL,1,2,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(4,0,'18:00:00','22:00:00','Akşam Kuşağı',NULL,'Desmal',4,NULL,1,3,'2026-03-04 07:23:05','2026-03-04 10:59:22'),(5,1,'09:00:00','12:00:00','Sabah Kuşağı',NULL,'DJ Ali',NULL,NULL,1,0,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(6,1,'12:00:00','15:00:00','Öğle Yayını',NULL,'Desmal',NULL,NULL,1,1,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(7,1,'15:00:00','18:00:00','Öğleden Sonra',NULL,'DJ Ay┼şe',NULL,NULL,1,2,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(8,1,'18:00:00','22:00:00','Akşam Kuşağı',NULL,'Desmal',NULL,NULL,1,3,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(9,2,'09:00:00','12:00:00','Sabah Kuşağı',NULL,'DJ Ali celik',1,NULL,1,0,'2026-03-04 07:23:05','2026-03-04 10:19:28'),(10,2,'12:00:00','15:00:00','Öğle Yayını',NULL,'Desmal',2,NULL,1,1,'2026-03-04 07:23:05','2026-03-04 10:19:13'),(11,2,'15:00:00','18:00:00','Öğleden Sonra',NULL,'DJ Ay┼şe',3,NULL,1,2,'2026-03-04 07:23:05','2026-03-04 10:19:45'),(12,2,'18:00:00','22:00:00','Akşam Kuşağı',NULL,'Desmal',1,NULL,1,3,'2026-03-04 07:23:05','2026-03-04 10:19:36'),(18,4,'12:00:00','15:00:00','Öğle Yayını',NULL,'Desmal',NULL,NULL,1,1,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(19,4,'15:00:00','18:00:00','Öğleden Sonra',NULL,'DJ Ay┼şe',NULL,NULL,1,2,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(20,4,'18:00:00','22:00:00','Akşam Kuşağı',NULL,'Desmal',1,13,1,3,'2026-03-04 07:23:05','2026-03-07 00:07:23'),(21,5,'09:00:00','12:00:00','Sabah Kuşağı',NULL,'DJ Ali',NULL,NULL,1,0,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(22,5,'12:00:00','15:00:00','Öğle Yayını',NULL,'Desmal',NULL,NULL,1,1,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(23,5,'15:00:00','18:00:00','Öğleden Sonra',NULL,'DJ Ay┼şe',NULL,NULL,1,2,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(24,5,'18:00:00','22:00:00','Akşam Kuşağı',NULL,'Desmal',NULL,NULL,1,3,'2026-03-04 07:23:05','2026-03-04 07:23:05'),(29,6,'20:00:00','23:00:00','Yöresel Halaylar',NULL,NULL,1,NULL,1,1,'2026-03-05 12:04:57','2026-03-05 12:04:57'),(30,6,'12:00:00','15:00:00','Öğle Yayını',NULL,NULL,4,NULL,1,2,'2026-03-05 12:05:16','2026-03-05 12:05:16'),(31,6,'18:00:00','22:00:00','Akşam Kuşağı',NULL,NULL,3,NULL,1,3,'2026-03-05 12:05:24','2026-03-05 12:05:24'),(32,6,'06:00:00','10:00:00','Sabah Kuşağı',NULL,NULL,4,NULL,1,4,'2026-03-05 12:05:54','2026-03-05 12:05:54'),(33,3,'06:00:00','10:00:00','Sabah Kuşağı',NULL,NULL,1,NULL,1,1,'2026-03-05 12:06:30','2026-03-05 12:06:30'),(34,3,'12:00:00','15:00:00','Öğle Yayını',NULL,NULL,4,NULL,1,2,'2026-03-05 12:06:40','2026-03-05 12:06:40'),(35,3,'15:00:00','18:00:00','Öğleden Sonra',NULL,NULL,2,NULL,1,3,'2026-03-05 12:06:48','2026-03-05 12:06:48'),(36,3,'20:00:00','23:00:00','Yöresel Halaylar',NULL,NULL,3,NULL,1,4,'2026-03-05 12:06:58','2026-03-05 12:06:58'),(37,4,'06:00:00','10:00:00','Sabah Kuşağı',NULL,NULL,1,13,1,4,'2026-03-07 00:02:13','2026-03-07 00:02:13');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('V37XprZJPrhxGWbgLfvABYnzaACZaBCNrtdqLzLM',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR0MwdzNUZ3prMzhDVGZhMElvTmRDRTU1bTNHaTlNd2JyMjlwbFVnQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly95b2wudGVzdC9hcGkvcmFkaW8vc3RhdHVzIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE1OiJhZG1pbl9sb2dnZWRfaW4iO2I6MTtzOjg6ImFkbWluX2lkIjtpOjE7fQ==',1773001466);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `radio_stream_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio_backup_stream_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio_auto_play` tinyint(1) NOT NULL DEFAULT '0',
  `radio_default_volume` decimal(3,2) NOT NULL DEFAULT '0.80',
  `shoutcast_base_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shoutcast_sid` tinyint unsigned NOT NULL DEFAULT '1',
  `radio_force_status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'https://r1.comcities.com/proxy/radyoyol/stream',NULL,1,0.80,NULL,1,NULL,'2026-03-04 06:11:51','2026-03-04 11:27:09');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'site_name','Radyo Yol','text','2026-03-04 11:28:32','2026-03-06 23:07:10'),(2,'site_slogan','Türkülerin Susmayan sesi','text','2026-03-04 11:28:32','2026-03-06 23:07:10'),(3,'contact_email','info@radyoyol.de','text','2026-03-04 11:28:32','2026-03-06 23:07:10'),(4,'contact_phone','0049 176 2005 91 65','text','2026-03-04 11:28:32','2026-03-06 23:07:10'),(5,'address_text','','text','2026-03-04 11:28:32','2026-03-06 23:07:10'),(6,'maintenance_mode','0','boolean','2026-03-04 11:28:32','2026-03-06 23:07:10'),(7,'brand_logo_path','assets/brand/cSqvUhksQ490IrFhnRWmYms073aBX4so7kvMwboA.png','text','2026-03-04 11:47:02','2026-03-04 11:47:02'),(8,'whatsapp_url','https://wa.me/4917620059161','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(9,'whatsapp_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(10,'telegram_url','','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(11,'telegram_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(12,'instagram_url','http://instagram.com/radyoyol','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(13,'instagram_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(14,'facebook_url','https://www.facebook.com/radyoyol.com.tr','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(15,'facebook_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(16,'tiktok_url','https://www.tiktok.com/radyoyol','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(17,'tiktok_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(18,'youtube_url','https://www.youtube.com/radyoyol','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(19,'youtube_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(20,'x_url','','text','2026-03-04 12:40:20','2026-03-08 19:09:35'),(21,'x_active','1','boolean','2026-03-04 12:40:20','2026-03-08 19:09:35'),(22,'brand_favicon_path','assets/brand/jAULCzo85GFwmnhteMebZQBvqXjFL9EOXcriHUBI.png','text','2026-03-04 12:44:08','2026-03-04 12:44:08'),(23,'theme_primary','#000000','color','2026-03-04 13:13:08','2026-03-04 13:21:32'),(24,'theme_accent','#ff0000','color','2026-03-04 13:13:08','2026-03-04 13:21:32'),(25,'theme_bg','#000000','color','2026-03-04 13:13:08','2026-03-04 13:21:32'),(26,'theme_text','#ffffff','color','2026-03-04 13:13:08','2026-03-04 13:21:32'),(27,'theme_glow','#0011ff','color','2026-03-04 13:13:08','2026-03-04 13:21:32'),(28,'footer_legal_text','RadyoYol Türkülerin Susmayan Sesi','text','2026-03-04 14:31:08','2026-03-06 23:51:15'),(29,'footer_legal_links_json','[{\"label\":\"Gizlilik Politikasi\",\"url\":\"\\/gizlilik\"},{\"label\":\"Cerez Politikasi\",\"url\":\"\\/cerez\"},{\"label\":\"Kullanim Sartlari\",\"url\":\"\\/kullanim\"},{\"label\":\"DMCA \\/ Telif Hakk\\u0131 Bildirimi\",\"url\":\"\\/dmca\"},{\"label\":\"KVKK Aydinlatma Metni\",\"url\":\"\\/kvkk\"}]','json','2026-03-04 14:31:08','2026-03-06 23:51:15'),(30,'android_app_url','https://play.google.com/store/apps/details?id=radyoyol.com.tr','text','2026-03-04 17:02:26','2026-03-08 19:09:35'),(31,'android_app_active','1','boolean','2026-03-04 17:02:26','2026-03-08 19:09:35'),(32,'ios_app_url','https://play.google.com/store/apps/details?id=radyoyol.com.tr','text','2026-03-04 17:02:26','2026-03-08 19:09:35'),(33,'ios_app_active','1','boolean','2026-03-04 17:02:26','2026-03-08 19:09:35'),(34,'winamp_url','https://r1.comcities.com/tunein/radyoyol.pls','text','2026-03-04 17:02:26','2026-03-08 19:09:35'),(35,'winamp_active','1','boolean','2026-03-04 17:02:26','2026-03-08 19:09:35'),(36,'media_player_url','https://r1.comcities.com/tunein/radyoyol.asx','text','2026-03-04 17:02:26','2026-03-08 19:09:35'),(37,'media_player_active','1','boolean','2026-03-04 17:02:26','2026-03-08 19:09:35'),(38,'quicktime_url','https://r1.comcities.com/tunein/radyoyol.qtl','text','2026-03-04 17:02:26','2026-03-08 19:09:35'),(39,'quicktime_active','1','boolean','2026-03-04 17:02:26','2026-03-08 19:09:35'),(40,'real_player_url','https://r1.comcities.com/tunein/radyoyol.ram','text','2026-03-04 17:02:26','2026-03-08 19:09:35'),(41,'real_player_active','1','boolean','2026-03-04 17:02:26','2026-03-08 19:09:35'),(42,'member_approval_required','1','boolean','2026-03-05 16:41:04','2026-03-05 18:58:43'),(43,'member_daily_submission_limit','5','integer','2026-03-05 16:41:04','2026-03-05 18:58:43'),(44,'member_max_mp3_size_mb','100','integer','2026-03-05 16:41:04','2026-03-05 18:58:43'),(45,'mail_mailer','smtp','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(46,'mail_host','smtp.gmail.com','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(47,'mail_port','587','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(48,'mail_username','radyoyoltv@gmail.com','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(49,'mail_password','yvbu xark ckxy iizs','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(50,'mail_encryption','tls','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(51,'mail_from_address','radyoyoltv@gmail.com','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(52,'mail_from_name','RadyoYol','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(53,'mail_contact_to','radyoyoltv@gmail.com','text','2026-03-05 16:49:45','2026-03-05 17:11:39'),(54,'seo_meta_title','RadyoYol Canli yayin','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(55,'seo_meta_description','radyoyol 7/24 canli yayin','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(56,'seo_meta_keywords','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(57,'seo_meta_author','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(58,'seo_meta_robots','index,follow','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(59,'seo_canonical_url','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(60,'seo_og_title','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(61,'seo_og_description','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(62,'seo_og_type','website','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(63,'seo_og_locale','en_US','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(64,'seo_twitter_card','summary_large_image','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(65,'seo_twitter_site','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(66,'seo_twitter_creator','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(67,'seo_google_verification','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(68,'seo_bing_verification','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(69,'seo_yandex_verification','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(70,'seo_schema_org_name','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(71,'seo_schema_org_url','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(72,'seo_schema_org_logo','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(73,'seo_schema_description','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(74,'seo_schema_radio_station','1','boolean','2026-03-05 18:34:00','2026-03-05 18:34:00'),(75,'seo_sitemap_url','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(76,'seo_geo_region','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(77,'seo_meta_referrer','','text','2026-03-05 18:34:00','2026-03-05 18:34:00'),(78,'contact_mobile','+49 176 2005 91 65','text','2026-03-05 18:43:27','2026-03-06 23:07:10'),(79,'contact_fax','','text','2026-03-05 18:43:27','2026-03-06 23:07:10'),(80,'contact_map_embed','','text','2026-03-05 18:43:27','2026-03-06 23:07:10'),(81,'member_max_video_size_mb','500','integer','2026-03-05 18:55:38','2026-03-05 18:58:43'),(82,'legal_kullanim','<h1>Kullan─▒m ┼Şartlar─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>Bu web sitesini kullanarak a┼şa─ş─▒da belirtilen kullan─▒m ┼şartlar─▒n─▒ kabul etmi┼ş say─▒l─▒rs─▒n─▒z. L├╝tfen siteyi kullanmadan ├Ânce bu ┼şartlar─▒ dikkatlice okuyunuz.</p>\r\n\r\n<h2>1. Hizmet Tan─▒m─▒</h2>\r\n<p>RadyoYol, internet ├╝zerinden canl─▒ radyo yay─▒n─▒ ve m├╝zik i├ğerikleri sunan bir platformdur. Kullan─▒c─▒lar site ├╝zerinden radyo yay─▒nlar─▒n─▒ dinleyebilir, site i├ğeri─şini g├Âr├╝nt├╝leyebilir ve baz─▒ hizmetlerden faydalanabilir.</p>\r\n\r\n<p>RadyoYol, hizmetlerini geli┼ştirmek, de─şi┼ştirmek veya durdurmak hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>2. Site Kullan─▒m─▒</h2>\r\n<p>Siteyi kullanan t├╝m ziyaret├ğiler a┼şa─ş─▒daki kurallara uymay─▒ kabul eder:</p>\r\n\r\n<ul>\r\n<li>Siteyi yasa d─▒┼ş─▒ ama├ğlarla kullanmamak</li>\r\n<li>Siteye zarar verecek yaz─▒l─▒m, kod veya giri┼şimlerde bulunmamak</li>\r\n<li>Ba┼şka kullan─▒c─▒lar─▒n haklar─▒n─▒ ihlal edecek davran─▒┼şlardan ka├ğ─▒nmak</li>\r\n<li>Hakaret, tehdit veya uygunsuz i├ğerik payla┼şmamak</li>\r\n</ul>\r\n\r\n<p>Bu kurallar─▒ ihlal eden kullan─▒c─▒lar─▒n siteye eri┼şimi ge├ğici veya kal─▒c─▒ olarak engellenebilir.</p>\r\n\r\n<h2>3. ├£yelik</h2>\r\n<p>Sitemizde ├╝yelik gerektiren hizmetler bulunabilir. ├£ye olan kullan─▒c─▒lar do─şru ve g├╝ncel bilgiler vermekle y├╝k├╝ml├╝d├╝r.</p>\r\n\r\n<p>Kullan─▒c─▒lar hesap bilgilerinin gizlili─şinden sorumludur. Hesap g├╝venli─şi kullan─▒c─▒ya aittir.</p>\r\n\r\n<p>RadyoYol y├Ânetimi, kullan─▒m ┼şartlar─▒n─▒ ihlal eden kullan─▒c─▒ hesaplar─▒n─▒ ask─▒ya alma veya kapatma hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>4. Telif Haklar─▒</h2>\r\n<p>Sitede yer alan logo, tasar─▒m, metinler ve di─şer i├ğerikler RadyoYolÔÇÖa veya ilgili hak sahiplerine aittir.</p>\r\n\r\n<p>Sitedeki i├ğeriklerin izinsiz olarak kopyalanmas─▒, ├ğo─şalt─▒lmas─▒ veya ticari ama├ğla kullan─▒lmas─▒ yasakt─▒r.</p>\r\n\r\n<p>Radyo yay─▒nlar─▒nda kullan─▒lan m├╝zik eserlerinin telif haklar─▒ ilgili hak sahiplerine aittir.</p>\r\n\r\n<h2>5. Yay─▒n ─░├ğeri─şi</h2>\r\n<p>RadyoYol ├╝zerinden yay─▒nlanan i├ğerikler bilgilendirme ve e─şlence ama├ğl─▒d─▒r. Yay─▒n ak─▒┼ş─▒ ve i├ğerikler ├Ânceden haber verilmeksizin de─şi┼ştirilebilir.</p>\r\n\r\n<h2>6. Sorumlulu─şun S─▒n─▒rland─▒r─▒lmas─▒</h2>\r\n<p>RadyoYol, site kullan─▒m─▒ndan do─şabilecek do─şrudan veya dolayl─▒ zararlardan sorumlu tutulamaz.</p>\r\n\r\n<p>Kullan─▒c─▒lar siteyi kendi sorumluluklar─▒ alt─▒nda kullanmay─▒ kabul eder.</p>\r\n\r\n<h2>7. Gizlilik</h2>\r\n<p>Kullan─▒c─▒lar─▒n ki┼şisel verileri Gizlilik Politikas─▒ kapsam─▒nda korunmakta ve i┼şlenmektedir.</p>\r\n\r\n<h2>8. De─şi┼şiklikler</h2>\r\n<p>RadyoYol, kullan─▒m ┼şartlar─▒n─▒ diledi─şi zaman g├╝ncelleme hakk─▒n─▒ sakl─▒ tutar. G├╝ncellenen ┼şartlar sitede yay─▒mland─▒─ş─▒ andan itibaren ge├ğerli olur.</p>\r\n\r\n<h2>9. ─░leti┼şim</h2>\r\n<p>Kullan─▒m ┼şartlar─▒ ile ilgili sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb sitesi: radyoyol.de\r\n</p>','text','2026-03-05 20:34:24','2026-03-05 20:37:01'),(83,'legal_gizlilik','<h1>Gizlilik Politikas─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>RadyoYol olarak ziyaret├ğilerimizin gizlili─şini ├Ânemsiyoruz. Bu gizlilik politikas─▒, web sitemizi ziyaret eden kullan─▒c─▒lar─▒n ki┼şisel bilgilerinin nas─▒l topland─▒─ş─▒n─▒, kullan─▒ld─▒─ş─▒n─▒ ve korundu─şunu a├ğ─▒klamaktad─▒r.</p>\r\n\r\n<h2>1. Toplanan Bilgiler</h2>\r\n<p>Sitemizi ziyaret etti─şinizde a┼şa─ş─▒daki bilgiler toplanabilir:</p>\r\n\r\n<ul>\r\n<li>Ad ve e-posta adresi (├╝yelik veya ileti┼şim s─▒ras─▒nda)</li>\r\n<li>IP adresi</li>\r\n<li>Taray─▒c─▒ ve cihaz bilgileri</li>\r\n<li>Site kullan─▒m istatistikleri</li>\r\n</ul>\r\n\r\n<h2>2. Bilgilerin Kullan─▒m─▒</h2>\r\n<p>Toplanan bilgiler a┼şa─ş─▒daki ama├ğlarla kullan─▒labilir:</p>\r\n\r\n<ul>\r\n<li>Site hizmetlerini geli┼ştirmek</li>\r\n<li>Kullan─▒c─▒ deneyimini iyile┼ştirmek</li>\r\n<li>Kullan─▒c─▒ taleplerine cevap vermek</li>\r\n<li>G├╝venlik ve sistem y├Ânetimini sa─şlamak</li>\r\n</ul>\r\n\r\n<h2>3. Bilgilerin Korunmas─▒</h2>\r\n<p>Ki┼şisel verileriniz yetkisiz eri┼şim, de─şi┼ştirme veya k├Ât├╝ye kullan─▒m riskine kar┼ş─▒ uygun g├╝venlik ├Ânlemleri ile korunmaktad─▒r.</p>\r\n\r\n<h2>4. ├£├ğ├╝nc├╝ Taraf Hizmetler</h2>\r\n<p>Sitemizde analiz ara├ğlar─▒ veya ├╝├ğ├╝nc├╝ taraf hizmetler kullan─▒labilir. Bu hizmetler kendi gizlilik politikalar─▒na tabidir.</p>\r\n\r\n<h2>5. De─şi┼şiklikler</h2>\r\n<p>RadyoYol gizlilik politikas─▒n─▒ gerekli g├Ârd├╝─ş├╝nde g├╝ncelleme hakk─▒n─▒ sakl─▒ tutar.</p>\r\n\r\n<h2>6. ─░leti┼şim</h2>\r\n<p>Gizlilik politikas─▒ hakk─▒nda sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>','text','2026-03-05 20:37:48','2026-03-05 20:37:48'),(84,'legal_kvkk','<h1>KVKK Ayd─▒nlatma Metni</h1>\r\n\r\n<p>RadyoYol olarak ki┼şisel verilerinizin g├╝venli─şine ├Ânem veriyoruz. Bu metin, ki┼şisel verilerinizin hangi ama├ğlarla i┼şlendi─şini a├ğ─▒klamak amac─▒yla haz─▒rlanm─▒┼şt─▒r.</p>\r\n\r\n<h2>1. Veri Sorumlusu</h2>\r\n<p>Ki┼şisel verileriniz RadyoYol taraf─▒ndan i┼şlenmektedir.</p>\r\n\r\n<h2>2. ─░┼şlenen Ki┼şisel Veriler</h2>\r\n\r\n<ul>\r\n<li>Ad ve soyad</li>\r\n<li>E-posta adresi</li>\r\n<li>IP adresi</li>\r\n<li>Site kullan─▒m bilgileri</li>\r\n</ul>\r\n\r\n<h2>3. Verilerin ─░┼şlenme Ama├ğlar─▒</h2>\r\n\r\n<ul>\r\n<li>Site hizmetlerini sunmak</li>\r\n<li>Kullan─▒c─▒ taleplerini kar┼ş─▒lamak</li>\r\n<li>Sistem g├╝venli─şini sa─şlamak</li>\r\n<li>Yasal y├╝k├╝ml├╝l├╝kleri yerine getirmek</li>\r\n</ul>\r\n\r\n<h2>4. Verilerin Saklanmas─▒</h2>\r\n<p>Ki┼şisel veriler yaln─▒zca gerekli s├╝re boyunca saklan─▒r ve yasal y├╝k├╝ml├╝l├╝kler do─şrultusunda korunur.</p>\r\n\r\n<h2>5. Haklar─▒n─▒z</h2>\r\n<p>Kullan─▒c─▒lar KVKK kapsam─▒nda a┼şa─ş─▒daki haklara sahiptir:</p>\r\n\r\n<ul>\r\n<li>Ki┼şisel verilerinin i┼şlenip i┼şlenmedi─şini ├Â─şrenme</li>\r\n<li>Verilerin d├╝zeltilmesini talep etme</li>\r\n<li>Verilerin silinmesini talep etme</li>\r\n</ul>\r\n\r\n<h2>6. ─░leti┼şim</h2>\r\n<p>Ki┼şisel verilerinizle ilgili talepler i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>','text','2026-03-05 20:38:42','2026-03-05 20:38:42'),(85,'legal_cerez','<h1>├çerez Politikas─▒</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>Bu web sitesi kullan─▒c─▒ deneyimini geli┼ştirmek amac─▒yla ├ğerezler kullanmaktad─▒r.</p>\r\n\r\n<h2>1. ├çerez Nedir?</h2>\r\n<p>├çerezler, ziyaret etti─şiniz web siteleri taraf─▒ndan taray─▒c─▒n─▒za kaydedilen k├╝├ğ├╝k veri dosyalar─▒d─▒r.</p>\r\n\r\n<h2>2. Kullan─▒lan ├çerez T├╝rleri</h2>\r\n\r\n<ul>\r\n<li><strong>Zorunlu ├çerezler:</strong> Sitenin d├╝zg├╝n ├ğal─▒┼şmas─▒ i├ğin gereklidir.</li>\r\n<li><strong>Performans ├çerezleri:</strong> Site kullan─▒m─▒n─▒ analiz etmek i├ğin kullan─▒l─▒r.</li>\r\n<li><strong>Fonksiyonel ├çerezler:</strong> Kullan─▒c─▒ tercihlerini hat─▒rlamak i├ğin kullan─▒l─▒r.</li>\r\n</ul>\r\n\r\n<h2>3. ├çerezlerin Y├Ânetimi</h2>\r\n<p>Kullan─▒c─▒lar taray─▒c─▒ ayarlar─▒n─▒ de─şi┼ştirerek ├ğerezleri engelleyebilir veya silebilir.</p>\r\n\r\n<h2>4. ├çerez Politikas─▒ De─şi┼şiklikleri</h2>\r\n<p>Bu politika zaman zaman g├╝ncellenebilir.</p>\r\n\r\n<h2>5. ─░leti┼şim</h2>\r\n<p>├çerez politikas─▒ ile ilgili sorular─▒n─▒z i├ğin bizimle ileti┼şime ge├ğebilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb: radyoyol.de\r\n</p>','text','2026-03-05 20:39:14','2026-03-05 20:39:14'),(86,'legal_dmca','<h1>DMCA / Telif Hakk─▒ Bildirimi</h1>\r\n\r\n<p><strong>Son G├╝ncelleme:</strong> [Tarih]</p>\r\n\r\n<p>RadyoYol, telif haklar─▒na sayg─▒ g├Âstermeyi ilke edinmi┼ştir. Sitemizde yay─▒nlanan i├ğeriklerin telif haklar─▒ ilgili hak sahiplerine aittir.</p>\r\n\r\n<h2>1. Telif Haklar─▒na Sayg─▒</h2>\r\n<p>RadyoYol ├╝zerinden yay─▒nlanan m├╝zik eserleri, i├ğerikler ve di─şer materyaller ilgili sanat├ğ─▒lar, yap─▒mc─▒lar veya hak sahiplerine aittir. Telif hakk─▒ ihlali olu┼şturabilecek i├ğeriklerin tespit edilmesi durumunda gerekli i┼şlemler yap─▒lacakt─▒r.</p>\r\n\r\n<h2>2. Telif Hakk─▒ ─░hlali Bildirimi</h2>\r\n<p>E─şer telif hakk─▒na sahip oldu─şunuz bir i├ğeri─şin izinsiz olarak yay─▒nland─▒─ş─▒n─▒ d├╝┼ş├╝n├╝yorsan─▒z, a┼şa─ş─▒daki bilgileri i├ğeren bir bildirim g├Ândererek bizimle ileti┼şime ge├ğebilirsiniz:</p>\r\n\r\n<ul>\r\n<li>Telif hakk─▒ sahibi veya yetkili temsilcisinin ad─▒</li>\r\n<li>─░hlale konu oldu─şu d├╝┼ş├╝n├╝len i├ğeri─şin a├ğ─▒k tan─▒m─▒</li>\r\n<li>─░lgili i├ğeri─şin bulundu─şu sayfan─▒n ba─şlant─▒s─▒ (URL)</li>\r\n<li>─░leti┼şim bilgileriniz (e-posta veya telefon)</li>\r\n<li>─░hlal iddias─▒n─▒n do─şru oldu─şuna dair beyan</li>\r\n</ul>\r\n\r\n<h2>3. ─░├ğeri─şin Kald─▒r─▒lmas─▒</h2>\r\n<p>Taraf─▒m─▒za iletilen telif hakk─▒ ihlali bildirimleri incelendikten sonra gerekli g├Âr├╝ld├╝─ş├╝ takdirde ilgili i├ğerik kald─▒r─▒labilir veya eri┼şime kapat─▒labilir.</p>\r\n\r\n<h2>4. Yanl─▒┼ş Bildirimler</h2>\r\n<p>Kas─▒tl─▒ olarak yanl─▒┼ş telif hakk─▒ bildirimi yap─▒lmas─▒ durumunda yasal sorumluluk do─şabilir.</p>\r\n\r\n<h2>5. ─░leti┼şim</h2>\r\n<p>Telif hakk─▒ bildirimleri i├ğin a┼şa─ş─▒daki ileti┼şim adresinden bizimle ula┼şabilirsiniz.</p>\r\n\r\n<p>\r\nE-posta: radyoyoltv@gmail.com<br>\r\nWeb sitesi: radyoyol.de\r\n</p>','text','2026-03-05 20:42:22','2026-03-05 20:42:22');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_theme`
--

DROP TABLE IF EXISTS `site_theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_theme` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` tinyint unsigned NOT NULL DEFAULT '1',
  `bg_mode` enum('color','image') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'color',
  `bg_color` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0b0f16',
  `bg_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overlay_color` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#000000',
  `overlay_opacity` tinyint unsigned NOT NULL DEFAULT '55',
  `bg_blur` tinyint unsigned NOT NULL DEFAULT '0',
  `button_color` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c92a2a',
  `button_hover_color` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#dc2626',
  `schedule_color` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1e2430',
  `schedule_active_color` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c92a2a',
  `line_color` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_theme`
--

LOCK TABLES `site_theme` WRITE;
/*!40000 ALTER TABLE `site_theme` DISABLE KEYS */;
INSERT INTO `site_theme` VALUES (1,20,'color','#5c5c5c','uploads/theme/ddwBKvE8Y37LzxgLbveowvqL5aPxw3ayACTWa2mk.png','#000000',55,5,'#000000','#dc2626','#080808','#1e00ff','#ffffff','2026-03-04 14:21:27','2026-03-08 03:13:50');
/*!40000 ALTER TABLE `site_theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_theme_settings`
--

DROP TABLE IF EXISTS `site_theme_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_theme_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `primary` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ff0033',
  `primary_hover` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ff3355',
  `secondary` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#374151',
  `secondary_hover` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#4b5563',
  `accent` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c92a2a',
  `glow` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c92a2a',
  `background` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0b0f16',
  `surface` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#111827',
  `surface_2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0f172a',
  `border` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rgba(255,255,255,0.12)',
  `text` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `text_muted` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#a9b1c3',
  `link` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#60a5fa',
  `link_hover` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#93c5fd',
  `header_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_text` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `header_active` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c92a2a',
  `footer_bg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_text` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#a9b1c3',
  `footer_link` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#a9b1c3',
  `footer_link_hover` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  `input_bg` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rgba(255,255,255,0.06)',
  `input_text` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#f0f2f5',
  `focus_ring` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c92a2a',
  `radius` smallint unsigned NOT NULL DEFAULT '14',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_theme_settings`
--

LOCK TABLES `site_theme_settings` WRITE;
/*!40000 ALTER TABLE `site_theme_settings` DISABLE KEYS */;
INSERT INTO `site_theme_settings` VALUES (1,'#ff0033','#ff3355','#374151','#4b5563','#c92a2a','#c92a2a','#0b0f16','#111827','#0f172a','rgba(255,255,255,0.12)','#ffffff','#a9b1c3','#60a5fa','#93c5fd',NULL,'#ffffff','#c92a2a',NULL,'#a9b1c3','#a9b1c3','#ffffff','rgba(255,255,255,0.06)','#f0f2f5','#c92a2a',14,'2026-03-04 13:28:14','2026-03-04 13:28:14');
/*!40000 ALTER TABLE `site_theme_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (1,'yolcu',NULL,NULL,NULL,'uploads/sliders/69a7ea257eff7_e279f858-3b9d-4898-be0b-e586e0c9dc2c.png',1,1,'2026-03-04 07:15:33','2026-03-04 07:15:33'),(2,'Radyo Yol','Türkülerin Susmayan sesi','uygulama indir','https://play.google.com/store/apps/details?id=radyoyol.com.tr','uploads/sliders/69a985513642f_2e1e19b9-ab8e-4903-bb35-61837caeb3fe.png',1,2,'2026-03-05 12:29:53','2026-03-06 23:57:17');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song_requests`
--

DROP TABLE IF EXISTS `song_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `song_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artist_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `song_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_requests`
--

LOCK TABLES `song_requests` WRITE;
/*!40000 ALTER TABLE `song_requests` DISABLE KEYS */;
INSERT INTO `song_requests` VALUES (8,'Haydarli02','alicelik@outlook.de','Grup Evan','salama','iyi yayinlar olsun','approved','2026-03-07 01:16:45','2026-03-07 01:16:30','2026-03-07 01:16:45'),(9,'yolcu','alicelik@outlook.de','ferhat tuc','ucurum','iyi yayinlar','approved','2026-03-07 04:04:19','2026-03-07 04:00:50','2026-03-07 04:04:19'),(10,'desmal','yolcu@gmail.com','yardil','sallama','iyi yayinlar','rejected',NULL,'2026-03-07 04:05:08','2026-03-07 04:05:20');
/*!40000 ALTER TABLE `song_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sponsors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `video_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_youtube_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_poster_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sponsors_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sponsors`
--

LOCK TABLES `sponsors` WRITE;
/*!40000 ALTER TABLE `sponsors` DISABLE KEYS */;
INSERT INTO `sponsors` VALUES (1,'radyoyol','radyoyol-Jsaj','radyoyol türkülerin yeni yolu',NULL,NULL,NULL,NULL,NULL,'uploads/sponsors/69ad4220d6eff_errr.jpg',NULL,'https://radyoyol.de/','https://www.facebook.com/radyoyol.com.tr','http://instagram.com/',NULL,'https://www.youtube.com/radyoyol',0,1,'2026-03-08 08:32:16','2026-03-08 08:32:16'),(2,'Yol Grafik','yol-grafik-iyRs','Yol Grafik Resturan Menü Tasatim logo web tasarim',NULL,NULL,NULL,NULL,NULL,'uploads/sponsors/69adc4622cabc_7.jpg','[\"uploads/sponsors/69adc4622cabc_7.jpg\", \"uploads/sponsors/69add0dd90fb7_pro_2.jpg\", \"uploads/sponsors/69add0dd91165_pro_3.jpg\"]','https://radyoyol.de/','https://www.facebook.com/radyoyol.com.tr','http://instagram.com/yolgrafik',NULL,NULL,0,1,'2026-03-08 17:48:02','2026-03-08 18:41:17'),(3,'yol girafik tasarim marbaa','yol-girafik-tasarim-marbaa-GW3H','yol girafik tasarim marbaa',NULL,NULL,NULL,NULL,NULL,'uploads/sponsors/69adc60317eff_logografik.png',NULL,'https://radyoyol.de/','https://www.facebook.com/radyoyol.com.tr','http://instagram.com/yolgrafik',NULL,NULL,0,1,'2026-03-08 17:54:59','2026-03-08 17:54:59'),(4,'Radyo yol','radyo-yol-dNy5','türkülerin susmayan sesi radyoyol','türkülerin susmayan sesi radyoyol','mp4',NULL,'uploads/sponsors/videos/69adc9711782c_yol.mp4',NULL,NULL,NULL,'https://radyoyol.de/','https://www.facebook.com/radyoyol.com.tr','http://instagram.com/yolgrafik',NULL,NULL,0,1,'2026-03-08 18:09:37','2026-03-08 18:10:42'),(5,'yol girafik tasarim','yol-girafik-tasarim-yXGj','yol grafik','yol grafik','mp4',NULL,'uploads/sponsors/videos/69add800a3689_yol.mp4','uploads/sponsors/video-posters/69add800a3875_poster.jpg',NULL,'[]','https://radyoyol.de/','https://www.facebook.com/radyoyol.com.tr','http://instagram.com/yolgrafik',NULL,'https://www.youtube.com/radyoyol',0,1,'2026-03-08 19:11:44','2026-03-08 19:11:44');
/*!40000 ALTER TABLE `sponsors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ali  celik','yolgrafik46@gmail.com',NULL,'$2y$12$Q2rnzlKvfu8Sk9T5YppN7esonkevk2Vz5P38j1P9mpPo8R/Svugw2','aktif',NULL,'2026-03-05 16:44:53','2026-03-05 20:19:40');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'yolcu_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-08 21:25:04
