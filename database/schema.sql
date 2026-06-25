-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: laravel_db
-- ------------------------------------------------------
-- Server version	8.0.44

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `event` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `referer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `activity_logs_causer_type_causer_id_index` (`causer_type`,`causer_id`),
  KEY `activity_logs_log_name_index` (`log_name`),
  KEY `activity_logs_event_index` (`event`),
  KEY `activity_logs_created_at_index` (`created_at`),
  KEY `activity_logs_batch_uuid_index` (`batch_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_tokens`
--

DROP TABLE IF EXISTS `api_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dealer_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` json DEFAULT NULL,
  `restrictions` json DEFAULT NULL,
  `rate_limit` int NOT NULL DEFAULT '60',
  `last_used_at` timestamp NULL DEFAULT NULL,
  `last_used_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_count` bigint unsigned NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','revoked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint unsigned NOT NULL,
  `revoked_by` bigint unsigned DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `revocation_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_tokens_token_unique` (`token`),
  KEY `api_tokens_dealer_id_index` (`dealer_id`),
  KEY `api_tokens_token_index` (`token`),
  KEY `api_tokens_status_index` (`status`),
  KEY `api_tokens_expires_at_index` (`expires_at`),
  KEY `api_tokens_last_used_at_index` (`last_used_at`),
  KEY `api_tokens_created_by_foreign` (`created_by`),
  KEY `api_tokens_revoked_by_foreign` (`revoked_by`),
  CONSTRAINT `api_tokens_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `api_tokens_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `api_tokens_revoked_by_foreign` FOREIGN KEY (`revoked_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_tokens`
--

LOCK TABLES `api_tokens` WRITE;
/*!40000 ALTER TABLE `api_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_tokens` ENABLE KEYS */;
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
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
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
  PRIMARY KEY (`key`)
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_index` (`parent_id`),
  KEY `categories_slug_index` (`slug`),
  KEY `categories_status_index` (`status`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Bitki Koruma','bitki-koruma',NULL,'Bitki Koruma Ürünleri | AgriCatalog','Tarımsal üretimde bitki sağlığını korumak için fungisit, herbisit ve insektisit ürünlerimizi keşfedin.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(2,'Fungisitler','fungisitler',1,'Fungisit Ürünleri - Mantar İlaçları','Bitkilerdeki mantar hastalıklarına karşı etkili fungisit ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(3,'Herbisitler','herbisitler',1,'Herbisit Ürünleri - Yabancı Ot İlaçları','Yabancı otlarla etkili mücadele için herbisit ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(4,'İnsektisitler','insektisitler',1,'İnsektisit Ürünleri - Böcek İlaçları','Zararlı böceklere karşı güvenilir insektisit ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(5,'Akarisitler','akarisitler',1,'Akarisit Ürünleri - Akar İlaçları','Akar ve kırmızı örümcek mücadelesi için akarisit ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(6,'Bitki Besleme','bitki-besleme',NULL,'Bitki Besleme Ürünleri | AgriCatalog','Verimli tarımsal üretim için gübre ve bitki besleme ürünlerimizi inceleyin.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(7,'Taban Gübreler','taban-gubreler',6,'Taban Gübre Çeşitleri','Toprak verimliliğini artıran taban gübre ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(8,'Yaprak Gübreler','yaprak-gubreler',6,'Yaprak Gübre Çeşitleri','Hızlı emilim sağlayan yaprak gübre ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(9,'Özel Gübreler','ozel-gubreler',6,'Özel Formül Gübreler','Bitki ihtiyaçlarına özel formüle edilmiş gübrelerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(10,'Organomineral Gübreler','organomineral-gubreler',6,'Organomineral Gübre Çeşitleri','Organik ve mineral içerik birleşimi gübrelerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(11,'Tohum','tohum',NULL,'Tohum Çeşitleri | AgriCatalog','Yüksek verimli ve dayanıklı tohum çeşitlerimizi keşfedin.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(12,'Buğday Tohumu','bugday-tohumu',11,'Buğday Tohumu Çeşitleri','Yüksek verimli buğday tohumu çeşitlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(13,'Mısır Tohumu','misir-tohumu',11,'Mısır Tohumu Çeşitleri','Hibrit ve yerli mısır tohumu çeşitlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(14,'Ayçiçeği Tohumu','aycicegi-tohumu',11,'Ayçiçeği Tohumu Çeşitleri','Yağlık ve çerezlik ayçiçeği tohumu çeşitlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(15,'Yem Bitkileri Tohumu','yem-bitkileri-tohumu',11,'Yem Bitkileri Tohumu','Hayvancılık için yem bitkileri tohumu çeşitlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39'),(16,'Biyostimülantlar','biyostimulantlar',NULL,'Biyostimülant Ürünleri | AgriCatalog','Bitki gelişimini destekleyen biyostimülant ürünlerimiz.','active','2025-12-23 09:31:39','2025-12-23 09:31:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dealer_users`
--

DROP TABLE IF EXISTS `dealer_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dealer_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dealer_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `role` enum('owner','manager','employee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `permissions` json DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dealer_users_dealer_id_user_id_unique` (`dealer_id`,`user_id`),
  KEY `dealer_users_dealer_id_index` (`dealer_id`),
  KEY `dealer_users_user_id_index` (`user_id`),
  KEY `dealer_users_role_index` (`role`),
  CONSTRAINT `dealer_users_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dealer_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dealer_users`
--

LOCK TABLES `dealer_users` WRITE;
/*!40000 ALTER TABLE `dealer_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `dealer_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dealers`
--

DROP TABLE IF EXISTS `dealers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dealers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_office` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `working_hours` json DEFAULT NULL,
  `social_media` json DEFAULT NULL,
  `status` enum('pending','active','inactive','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `suspension_reason` text COLLATE utf8mb4_unicode_ci,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dealers_tax_number_unique` (`tax_number`),
  UNIQUE KEY `dealers_email_unique` (`email`),
  KEY `dealers_company_name_index` (`company_name`),
  KEY `dealers_tax_number_index` (`tax_number`),
  KEY `dealers_email_index` (`email`),
  KEY `dealers_city_index` (`city`),
  KEY `dealers_district_index` (`district`),
  KEY `dealers_status_index` (`status`),
  KEY `dealers_latitude_longitude_index` (`latitude`,`longitude`),
  KEY `dealers_approved_by_foreign` (`approved_by`),
  CONSTRAINT `dealers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dealers`
--

LOCK TABLES `dealers` WRITE;
/*!40000 ALTER TABLE `dealers` DISABLE KEYS */;
INSERT INTO `dealers` VALUES (1,'Ege Tarım Merkezi Ltd. Şti.','1234567890','Konak','02324567890','info@egetarim.com.tr','www.egetarim.com.tr','Kemalpaşa Cad. No:123 Bornova','İzmir','Bornova','35060',38.41920000,27.12870000,NULL,'Ege bölgesinin en büyük tarımsal ürün bayilerinden biri olarak 2010 yılından beri hizmet vermekteyiz.','{\"friday\": \"08:30-18:00\", \"monday\": \"08:30-18:00\", \"sunday\": \"Kapalı\", \"tuesday\": \"08:30-18:00\", \"saturday\": \"09:00-13:00\", \"thursday\": \"08:30-18:00\", \"wednesday\": \"08:30-18:00\"}','{\"facebook\": \"egetarimltd\", \"linkedin\": \"ege-tarim-ltd\", \"instagram\": \"egetarim\"}','active','2025-11-23 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(2,'Anadolu Ziraat Ticaret A.Ş.','9876543210','Çankaya','03122345678','info@anadoluziraat.com','www.anadoluziraat.com','Ankara Yolu 5.km No:45','Ankara','Yenimahalle','06100',39.93340000,32.85970000,NULL,'İç Anadolu bölgesinin güvenilir tarım ortağı. 25 yıllık deneyim.','{\"friday\": \"08:00-17:30\", \"monday\": \"08:00-17:30\", \"sunday\": \"Kapalı\", \"tuesday\": \"08:00-17:30\", \"saturday\": \"Kapalı\", \"thursday\": \"08:00-17:30\", \"wednesday\": \"08:00-17:30\"}','{\"twitter\": \"anadoluziraat\", \"facebook\": \"anadoluziraat\"}','active','2025-10-24 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(3,'Karadeniz Tarım San. ve Tic. Ltd. Şti.','5554443332','Atakum','03624567890','bilgi@karadeniztarim.com','www.karadeniztarim.com','Atatürk Bulvarı No:234','Samsun','Atakum','55200',41.29280000,36.33130000,NULL,'Karadeniz bölgesinin tarımsal ihtiyaçlarına 15 yıldır çözüm sunuyoruz.','{\"friday\": \"08:30-18:30\", \"monday\": \"08:30-18:30\", \"sunday\": \"Kapalı\", \"tuesday\": \"08:30-18:30\", \"saturday\": \"09:00-14:00\", \"thursday\": \"08:30-18:30\", \"wednesday\": \"08:30-18:30\"}','{\"instagram\": \"karadeniztarim\"}','active','2025-11-08 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(4,'Akdeniz Tarımsal Ürünler Ltd. Şti.','1112223334','Muratpaşa','02423456789','info@akdeniztarim.net',NULL,'Lara Cad. No:567','Antalya','Muratpaşa','07100',36.89690000,30.71330000,NULL,'Seracılık ve tarım konusunda uzman kadromuzla hizmetinizdeyiz.',NULL,NULL,'active','2025-12-03 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(5,'GAP Tarım Ürünleri A.Ş.','7778889990','Haliliye','04143456789','gap@gaptarim.com.tr','www.gaptarim.com.tr','Atatürk Mahallesi GAP Cad. No:89','Şanlıurfa','Haliliye','63300',37.16740000,38.79550000,NULL,'GAP bölgesinin en büyük tarımsal girdi tedarikçisi.','{\"friday\": \"07:30-18:00\", \"monday\": \"07:30-18:00\", \"sunday\": \"Kapalı\", \"tuesday\": \"07:30-18:00\", \"saturday\": \"08:00-12:00\", \"thursday\": \"07:30-18:00\", \"wednesday\": \"07:30-18:00\"}',NULL,'active','2025-09-24 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(6,'Çukurova Ziraat Ltd. Şti.','2223334445','Seyhan','03224567890','info@cukurovaziraat.com',NULL,'Turgut Özal Bulvarı No:123','Adana','Seyhan','01170',37.00000000,35.32130000,NULL,'Çukurova\'nın verimli topraklarında çiftçimizin yanındayız.',NULL,NULL,'pending',NULL,NULL,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(7,'Trakya Tarım Ticaret A.Ş.','6667778889','Merkez','02842345678','bilgi@trakyatarim.com','www.trakyatarim.com','İstasyon Cad. No:45','Edirne','Merkez','22100',41.68180000,26.56230000,NULL,'Trakya\'nın bereketli topraklarında modern tarımın öncüsü.',NULL,NULL,'active','2025-08-25 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(8,'Marmara Tarımsal Kalkınma Ltd. Şti.','3334445556','Osmangazi','02242345678','info@marmaratarim.com',NULL,'Mudanya Yolu No:78','Bursa','Osmangazi','16050',40.18280000,29.06100000,NULL,'Marmara bölgesinin tarımsal kalkınmasına katkı sağlıyoruz.',NULL,NULL,'inactive',NULL,NULL,'Geçici olarak faaliyetleri durduruldu.','2025-12-13 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40'),(9,'Doğu Anadolu Tarım Ltd. Şti.','8889990001','Yakutiye','04423456789','info@doguanadolutarim.com',NULL,'Cumhuriyet Cad. No:234','Erzurum','Yakutiye','25100',39.93340000,41.27640000,NULL,'Doğu Anadolu\'nun zorlu iklim şartlarına uygun ürünler sunuyoruz.',NULL,NULL,'active','2025-06-26 09:31:40',1,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40'),(10,'Orta Karadeniz Tarım San. Tic. A.Ş.','4445556667','İlkadım','03623456789','info@ortakaradeniztarim.com',NULL,'19 Mayıs Bulvarı No:567','Samsun','İlkadım','55020',41.27970000,36.33610000,NULL,'Fındık ve diğer tarımsal ürünlerde uzman kadromuzla hizmetinizdeyiz.',NULL,NULL,'pending',NULL,NULL,NULL,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40');
/*!40000 ALTER TABLE `dealers` ENABLE KEYS */;
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
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `dealer_id` bigint unsigned NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_time` time NOT NULL,
  `seller_info` json NOT NULL,
  `buyer_info` json NOT NULL,
  `items` json NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `discount_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_base` decimal(12,2) NOT NULL,
  `tax_details` json NOT NULL,
  `tax_total` decimal(10,2) NOT NULL,
  `grand_total` decimal(12,2) NOT NULL,
  `total_in_words` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TRY',
  `exchange_rate` decimal(10,4) NOT NULL DEFAULT '1.0000',
  `type` enum('sales','return','proforma') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sales',
  `status` enum('draft','approved','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `pdf_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_invoice_uuid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_invoice_date` timestamp NULL DEFAULT NULL,
  `e_invoice_status` enum('pending','sent','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_invoice_response` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned NOT NULL,
  `cancelled_by` bigint unsigned DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_invoice_number_index` (`invoice_number`),
  KEY `invoices_order_id_index` (`order_id`),
  KEY `invoices_dealer_id_index` (`dealer_id`),
  KEY `invoices_invoice_date_index` (`invoice_date`),
  KEY `invoices_type_index` (`type`),
  KEY `invoices_status_index` (`status`),
  KEY `invoices_serial_sequence_index` (`serial`,`sequence`),
  KEY `invoices_e_invoice_uuid_index` (`e_invoice_uuid`),
  KEY `invoices_created_by_foreign` (`created_by`),
  KEY `invoices_cancelled_by_foreign` (`cancelled_by`),
  CONSTRAINT `invoices_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `invoices_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_12_23_083127_create_categories_table',1),(5,'2025_12_23_083157_create_products_table',1),(6,'2025_12_23_090000_create_pages_table',1),(7,'2025_12_23_090100_create_dealers_table',1),(8,'2025_12_23_090200_create_dealer_users_table',1),(9,'2025_12_23_090300_create_orders_table',1),(10,'2025_12_23_090400_create_invoices_table',1),(11,'2025_12_23_090500_create_api_tokens_table',1),(12,'2025_12_23_090600_create_activity_logs_table',1),(13,'2025_12_23_090700_add_invoice_foreign_key_to_orders_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `items` json NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TRY',
  `payment_method` enum('credit_card','bank_transfer','cash','check') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('pending','paid','partially_paid','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `shipping_method` enum('cargo','pickup','dealer_delivery') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` json DEFAULT NULL,
  `billing_address` json NOT NULL,
  `tracking_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `internal_notes` text COLLATE utf8mb4_unicode_ci,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_order_number_index` (`order_number`),
  KEY `orders_dealer_id_index` (`dealer_id`),
  KEY `orders_user_id_index` (`user_id`),
  KEY `orders_status_index` (`status`),
  KEY `orders_payment_status_index` (`payment_status`),
  KEY `orders_created_at_index` (`created_at`),
  KEY `orders_invoice_id_index` (`invoice_id`),
  CONSTRAINT `orders_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `orders_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_by` bigint unsigned NOT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`),
  KEY `pages_slug_index` (`slug`),
  KEY `pages_status_index` (`status`),
  KEY `pages_published_at_index` (`published_at`),
  KEY `pages_template_index` (`template`),
  KEY `pages_created_by_foreign` (`created_by`),
  KEY `pages_updated_by_foreign` (`updated_by`),
  CONSTRAINT `pages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Hakkımızda','hakkimizda','<h1>Hakkımızda</h1>\n                \n                <p><strong>AgriCatalog</strong>, 1998 yılından bu yana Türk tarımına hizmet veren, sektörün güvenilir isimlerinden biridir.</p>\n                \n                <h2>Misyonumuz</h2>\n                <p>Modern tarım teknolojilerini ve en kaliteli tarımsal girdileri çiftçilerimizle buluşturarak, sürdürülebilir ve verimli tarımsal üretimi desteklemek.</p>\n                \n                <h2>Vizyonumuz</h2>\n                <p>Türkiye\'nin tarımsal üretimde öncü ve yenilikçi çözüm ortağı olmak, dünya standartlarında ürün ve hizmetlerle ülkemizin tarımsal potansiyelini artırmak.</p>\n                \n                <h2>Değerlerimiz</h2>\n                <ul>\n                    <li><strong>Güvenilirlik:</strong> Müşterilerimize ve iş ortaklarımıza karşı her zaman dürüst ve şeffaf olmak.</li>\n                    <li><strong>Kalite:</strong> En yüksek kalite standartlarında ürün ve hizmet sunmak.</li>\n                    <li><strong>Yenilikçilik:</strong> Sürekli araştırma ve geliştirme ile sektöre yenilikler katmak.</li>\n                    <li><strong>Sürdürülebilirlik:</strong> Çevreye duyarlı ve sürdürülebilir tarım uygulamalarını desteklemek.</li>\n                    <li><strong>Müşteri Odaklılık:</strong> Müşterilerimizin ihtiyaçlarını önceleyerek çözüm üretmek.</li>\n                </ul>','default','Hakkımızda - AgriCatalog','AgriCatalog olarak 1998\'den bu yana Türk tarımına hizmet veriyoruz. Misyonumuz, vizyonumuz ve değerlerimiz.','agricatalog hakkında, tarım şirketi, tarımsal ürünler, kurumsal',NULL,'published',1,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40'),(2,'İletişim','iletisim','<h1>İletişim</h1>\n                \n                <p>AgriCatalog olarak, müşterilerimizin ve iş ortaklarımızın sorularını yanıtlamak ve en iyi hizmeti sunmak için buradayız.</p>\n                \n                <h2>İletişim Bilgileri</h2>\n                \n                <div class=\"contact-info\">\n                    <p><strong>Merkez Ofis:</strong><br>\n                    Atatürk Cad. No:123<br>\n                    Yenişehir, Ankara 06420<br>\n                    Türkiye</p>\n                    \n                    <p><strong>Telefon:</strong> +90 312 123 45 67<br>\n                    <strong>Faks:</strong> +90 312 123 45 68<br>\n                    <strong>E-posta:</strong> info@agricatalog.com</p>\n                    \n                    <p><strong>Müşteri Hizmetleri:</strong><br>\n                    Telefon: 444 2 AGR (247)<br>\n                    E-posta: destek@agricatalog.com</p>\n                </div>\n                \n                <h2>Çalışma Saatleri</h2>\n                <p>Pazartesi - Cuma: 08:30 - 18:00<br>\n                Cumartesi: 09:00 - 13:00<br>\n                Pazar: Kapalı</p>\n                \n                <h2>Bölge Müdürlükleri</h2>\n                <p><strong>Ege Bölge Müdürlüğü:</strong> İzmir - Tel: +90 232 123 45 67<br>\n                <strong>Akdeniz Bölge Müdürlüğü:</strong> Antalya - Tel: +90 242 123 45 67<br>\n                <strong>Karadeniz Bölge Müdürlüğü:</strong> Samsun - Tel: +90 362 123 45 67<br>\n                <strong>Güneydoğu Bölge Müdürlüğü:</strong> Şanlıurfa - Tel: +90 414 123 45 67</p>','contact','İletişim - AgriCatalog','AgriCatalog iletişim bilgileri, adres, telefon ve e-posta. Müşteri hizmetleri ve bölge müdürlükleri.','iletişim, adres, telefon, müşteri hizmetleri, bölge müdürlükleri',NULL,'published',1,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40'),(3,'Kalite Politikamız','kalite-politikamiz','<h1>Kalite Politikamız</h1>\n                \n                <p>AgriCatalog olarak, kaliteyi sadece ürünlerimizde değil, tüm iş süreçlerimizde ve hizmetlerimizde bir yaşam biçimi olarak benimsiyoruz.</p>\n                \n                <h2>Kalite Taahhüdümüz</h2>\n                <p>Müşterilerimize sunduğumuz tüm ürün ve hizmetlerde en yüksek kalite standartlarını sağlamayı taahhüt ediyoruz. Bu kapsamda:</p>\n                \n                <ul>\n                    <li>ISO 9001:2015 Kalite Yönetim Sistemi sertifikasına sahibiz</li>\n                    <li>Tüm ürünlerimiz uluslararası kalite standartlarına uygun olarak üretilir veya tedarik edilir</li>\n                    <li>Düzenli kalite kontrol ve denetim süreçleri uygularız</li>\n                    <li>Müşteri memnuniyetini sürekli ölçer ve iyileştiririz</li>\n                </ul>\n                \n                <h2>Sertifikalarımız</h2>\n                <ul>\n                    <li>ISO 9001:2015 Kalite Yönetim Sistemi</li>\n                    <li>ISO 14001:2015 Çevre Yönetim Sistemi</li>\n                    <li>OHSAS 18001 İş Sağlığı ve Güvenliği</li>\n                    <li>TSE Hizmet Yeterlilik Belgesi</li>\n                </ul>\n                \n                <h2>Kalite Kontrol Sürecimiz</h2>\n                <p>Ürünlerimizin kalitesini garanti altına almak için:</p>\n                <ol>\n                    <li>Tedarikçi seçimi ve değerlendirmesi</li>\n                    <li>Ürün kabul testleri</li>\n                    <li>Depolama koşulları kontrolü</li>\n                    <li>Sevkiyat öncesi son kontroller</li>\n                    <li>Müşteri geri bildirimlerinin değerlendirilmesi</li>\n                </ol>','default','Kalite Politikamız - AgriCatalog','AgriCatalog kalite politikası, ISO sertifikaları ve kalite kontrol süreçleri. Müşteri memnuniyeti önceliğimizdir.','kalite politikası, iso 9001, kalite kontrol, sertifikalar',NULL,'published',1,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40'),(4,'Gizlilik Politikası','gizlilik-politikasi','<h1>Gizlilik Politikası</h1>\n                \n                <p>Son Güncelleme: 23.12.2025</p>\n                \n                <p>AgriCatalog olarak, web sitemizi ziyaret eden kullanıcılarımızın gizliliğini korumayı taahhüt ediyoruz. Bu gizlilik politikası, kişisel verilerinizin nasıl toplandığı, kullanıldığı ve korunduğu hakkında bilgi vermektedir.</p>\n                \n                <h2>Toplanan Bilgiler</h2>\n                <p>Web sitemizi ziyaret ettiğinizde veya hizmetlerimizi kullandığınızda aşağıdaki bilgileri toplayabiliriz:</p>\n                <ul>\n                    <li>Ad, soyad ve iletişim bilgileri</li>\n                    <li>E-posta adresi ve telefon numarası</li>\n                    <li>Şirket bilgileri ve vergi numarası</li>\n                    <li>IP adresi ve tarayıcı bilgileri</li>\n                    <li>Web sitesi kullanım verileri</li>\n                </ul>\n                \n                <h2>Bilgilerin Kullanımı</h2>\n                <p>Topladığımız bilgileri şu amaçlarla kullanırız:</p>\n                <ul>\n                    <li>Ürün ve hizmetlerimizi sunmak</li>\n                    <li>Siparişlerinizi işlemek ve takip etmek</li>\n                    <li>Müşteri desteği sağlamak</li>\n                    <li>Yasal yükümlülüklerimizi yerine getirmek</li>\n                    <li>Hizmetlerimizi geliştirmek</li>\n                </ul>\n                \n                <h2>Bilgilerin Korunması</h2>\n                <p>Kişisel verilerinizi korumak için endüstri standardı güvenlik önlemleri kullanıyoruz. Verileriniz şifreli bağlantılar üzerinden iletilir ve güvenli sunucularda saklanır.</p>\n                \n                <h2>Çerezler</h2>\n                <p>Web sitemizde çerezler kullanılmaktadır. Çerezler, web sitesi deneyiminizi iyileştirmek ve size daha kişiselleştirilmiş hizmet sunmak için kullanılır.</p>\n                \n                <h2>İletişim</h2>\n                <p>Gizlilik politikamız hakkında sorularınız varsa, lütfen bizimle iletişime geçin:<br>\n                E-posta: privacy@agricatalog.com<br>\n                Telefon: +90 312 123 45 67</p>','default','Gizlilik Politikası - AgriCatalog','AgriCatalog gizlilik politikası ve kişisel verilerin korunması. KVKK uyumlu gizlilik bildirimi.','gizlilik politikası, kvkk, kişisel veriler, çerezler',NULL,'published',1,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40'),(5,'Kullanım Şartları','kullanim-sartlari','<h1>Kullanım Şartları</h1>\n                \n                <p>AgriCatalog web sitesini kullanmaya başlamadan önce lütfen bu kullanım şartlarını dikkatlice okuyunuz.</p>\n                \n                <h2>Genel Şartlar</h2>\n                <p>Bu web sitesini kullanarak, aşağıdaki şartları kabul etmiş sayılırsınız:</p>\n                \n                <ol>\n                    <li>Web sitesindeki tüm içerikler AgriCatalog\'a aittir ve telif hakları ile korunmaktadır.</li>\n                    <li>Site içeriğini kopyalamak, dağıtmak veya değiştirmek yasaktır.</li>\n                    <li>Verilen bilgilerin doğruluğu garanti edilmekle birlikte, AgriCatalog sorumluluk kabul etmez.</li>\n                    <li>Ürün fiyatları ve stok durumları önceden haber verilmeksizin değiştirilebilir.</li>\n                    <li>Web sitesinin kesintisiz ve hatasız çalışacağı garanti edilmez.</li>\n                </ol>\n                \n                <h2>Kullanıcı Sorumlulukları</h2>\n                <ul>\n                    <li>Doğru ve güncel bilgi vermek</li>\n                    <li>Yasalara ve etik kurallara uymak</li>\n                    <li>Başkalarının haklarına saygı göstermek</li>\n                    <li>Güvenlik açıklarını istismar etmemek</li>\n                </ul>\n                \n                <h2>Sorumluluk Reddi</h2>\n                <p>AgriCatalog, web sitesinin kullanımından doğabilecek doğrudan veya dolaylı zararlardan sorumlu tutulamaz.</p>\n                \n                <h2>Değişiklikler</h2>\n                <p>AgriCatalog, bu kullanım şartlarını önceden bildirmeksizin değiştirme hakkını saklı tutar.</p>','default','Kullanım Şartları - AgriCatalog','AgriCatalog web sitesi kullanım şartları ve koşulları. Yasal bilgiler ve sorumluluklar.','kullanım şartları, yasal bilgiler, sorumluluk reddi',NULL,'published',1,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40'),(6,'Sıkça Sorulan Sorular','sikca-sorulan-sorular','<h1>Sıkça Sorulan Sorular</h1>\n                \n                <h2>Sipariş ve Teslimat</h2>\n                \n                <h3>Nasıl sipariş verebilirim?</h3>\n                <p>Siparişlerinizi bayi portalı üzerinden veya müşteri temsilciniz aracılığıyla verebilirsiniz. Toplu siparişler için özel fiyatlandırma yapılmaktadır.</p>\n                \n                <h3>Minimum sipariş miktarı var mı?</h3>\n                <p>Evet, her ürün için belirlenen minimum sipariş miktarları bulunmaktadır. Detaylı bilgi için müşteri hizmetlerimizle iletişime geçebilirsiniz.</p>\n                \n                <h3>Teslimat süresi ne kadar?</h3>\n                <p>Stokta bulunan ürünler için teslimat süresi 2-5 iş günüdür. Özel sipariş ürünleri için süre değişebilir.</p>\n                \n                <h2>Ürünler ve Kullanım</h2>\n                \n                <h3>Ürünleriniz orijinal mi?</h3>\n                <p>Tüm ürünlerimiz orijinal ve lisanslıdır. Üretici firmalardan direkt tedarik edilmektedir.</p>\n                \n                <h3>Teknik destek sağlıyor musunuz?</h3>\n                <p>Evet, uzman ziraat mühendislerimiz ürünlerin doğru kullanımı konusunda ücretsiz teknik destek sağlamaktadır.</p>\n                \n                <h3>İade ve değişim şartları nelerdir?</h3>\n                <p>Hatalı veya hasarlı ürünler 7 gün içinde iade edilebilir. Ürün ambalajı açılmamış olmalıdır.</p>\n                \n                <h2>Bayilik ve İş Ortaklığı</h2>\n                \n                <h3>Nasıl bayi olabilirim?</h3>\n                <p>Bayilik başvuruları web sitemizden veya 444 2 AGR numaralı müşteri hizmetlerimizden yapılabilir.</p>\n                \n                <h3>Bayi olmanın avantajları nelerdir?</h3>\n                <p>Özel fiyatlandırma, vade imkanları, teknik destek ve pazarlama desteği gibi birçok avantaj sunuyoruz.</p>','default','Sıkça Sorulan Sorular - AgriCatalog','AgriCatalog hakkında sıkça sorulan sorular ve cevapları. Sipariş, teslimat, ürünler ve bayilik.','sss, sıkça sorulan sorular, yardım, destek',NULL,'published',1,NULL,'2025-12-23 09:31:40','2025-12-23 09:31:40','2025-12-23 09:31:40');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `long_description` longtext COLLATE utf8mb4_unicode_ci,
  `active_ingredient` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formulation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_areas` text COLLATE utf8mb4_unicode_ci,
  `technical_info` json DEFAULT NULL,
  `images` json DEFAULT NULL,
  `brochure_pdf` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_index` (`category_id`),
  KEY `products_slug_index` (`slug`),
  KEY `products_sku_index` (`sku`),
  KEY `products_status_index` (`status`),
  FULLTEXT KEY `products_name_short_description_long_description_fulltext` (`name`,`short_description`,`long_description`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,'MaxiGuard 500 SC','maxiguard-500-sc','FNG-001','Sistemik ve koruyucu etkili geniş spektrumlu fungisit','MaxiGuard 500 SC, buğday, arpa, şeker pancarı ve domateste görülen mantar hastalıklarına karşı etkili sistemik fungisittir. Hem koruyucu hem de tedavi edici özelliğe sahiptir. Bitkinin tüm yeşil aksamına hızla nüfuz eder ve sisteme alınarak uzun süre koruma sağlar.','500 g/l Azoxystrobin','SC (Süspansiyon Konsantre)','Buğday, Arpa, Şeker Pancarı, Domates, Patates','{\"Doz\": \"50-75 ml/da\", \"PHI\": \"14 gün\", \"Ambalaj\": \"1L, 5L, 20L\", \"Karışabilirlik\": \"Çoğu pestisit ile karışır\", \"Uygulama Zamanı\": \"Hastalık belirtileri görülmeden önce\"}','[]',NULL,'MaxiGuard 500 SC Fungisit','Sistemik ve koruyucu etkili, 500 g/l Azoxystrobin içeren geniş spektrumlu fungisit. Buğday, arpa ve diğer ürünlerde mantar hastalıklarına karşı etkili.','fungisit, azoxystrobin, mantar ilacı, sistemik fungisit','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(2,2,'CropShield Pro WG','cropshield-pro-wg','FNG-002','Külleme ve pas hastalıklarına karşı özel formülasyon','CropShield Pro WG, tahıllarda külleme ve pas hastalıklarına karşı geliştirilmiş, suda dağılabilen granül formülasyonlu modern bir fungisittir. Hızlı sistemik etki gösterir ve uzun süre koruma sağlar.','%50 Propiconazole','WG (Suda Dağılan Granül)','Buğday, Arpa, Çavdar, Yulaf','{\"Doz\": \"25-30 g/da\", \"PHI\": \"21 gün\", \"Ambalaj\": \"1kg, 5kg\", \"Çözünürlük\": \"Suda tam çözünür\", \"Uygulama Zamanı\": \"Hastalık belirtileri görüldüğünde\"}','[]',NULL,'CropShield Pro WG - Külleme ve Pas İlacı','Tahıllarda külleme ve pas hastalıklarına karşı %50 Propiconazole içeren granül fungisit.','külleme ilacı, pas ilacı, propiconazole, tahıl fungisiti','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(3,2,'BioProtect Plus','bioprotect-plus','FNG-003','Organik tarıma uygun biyolojik fungisit','BioProtect Plus, Trichoderma harzianum içeren, organik tarımda kullanılabilen biyolojik fungisittir. Toprak kökenli hastalıklara karşı etkilidir. Faydalı mikroorganizmaları korur ve toprağın biyolojik dengesini bozmaz.','Trichoderma harzianum 1x10⁸ CFU/g','WP (Islanabilir Toz)','Sebze, Meyve, Süs Bitkileri','{\"Doz\": \"200-300 g/da\", \"PHI\": \"0 gün\", \"Ambalaj\": \"500g, 1kg\", \"Saklama\": \"Serin ve kuru yerde\", \"Organik Sertifika\": \"FiBL listesinde\"}','[]',NULL,'BioProtect Plus - Organik Biyolojik Fungisit','Trichoderma harzianum içeren, organik tarıma uygun biyolojik fungisit. Toprak kökenli hastalıklara karşı etkili.','biyolojik fungisit, organik fungisit, trichoderma, organik tarım','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(4,3,'WeedMaster Gold EC','weedmaster-gold-ec','HRB-001','Geniş ve dar yapraklı yabancı otlara karşı total herbisit','WeedMaster Gold EC, geniş ve dar yapraklı yabancı otlara karşı güçlü sistematik etkiye sahip total herbisittir. Özellikle nadas alanları ve tarla kenarlarının temizliğinde kullanılır.','480 g/l Glyphosate IPA tuzu','EC (Emülsiyon Konsantre)','Nadas alanları, Bahçe, Bağ, Tarla kenarları','{\"Doz\": \"400-600 ml/da\", \"Ambalaj\": \"1L, 5L, 20L\", \"Karışım\": \"Yayıcı yapıştırıcı ile kullanılabilir\", \"Etki Süresi\": \"7-10 gün\", \"Yağmur Dayanımı\": \"6 saat\"}','[]',NULL,'WeedMaster Gold EC Total Herbisit','Geniş spektrumlu, 480 g/l Glyphosate içeren total herbisit. Tüm yabancı otlara karşı etkili.','herbisit, yabancı ot ilacı, glyphosate, total herbisit','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(5,3,'CerealGuard 75 WG','cerealguard-75-wg','HRB-002','Tahıllarda geniş yapraklı yabancı otlara karşı seçici herbisit','CerealGuard 75 WG, buğday ve arpada geniş yapraklı yabancı otlara karşı seçici herbisittir. Tahıla zarar vermeden yabancı otları kontrol eder.','%75 Tribenuron-methyl','WG (Suda Dağılan Granül)','Buğday, Arpa','{\"Doz\": \"1.5-2 g/da\", \"PHI\": \"30 gün\", \"Ambalaj\": \"100g, 500g\", \"Sıcaklık\": \"5-25°C arası uygulama\", \"Uygulama Zamanı\": \"Yabancı otlar 2-6 yapraklı dönemde\"}','[]',NULL,'CerealGuard 75 WG Tahıl Herbisiti','Tahıllarda geniş yapraklı yabancı otlara karşı %75 Tribenuron-methyl içeren seçici herbisit.','tahıl herbisiti, tribenuron-methyl, seçici herbisit, buğday ot ilacı','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(6,4,'InsectShield Max EC','insectshield-max-ec','INS-001','Emici ve çiğneyici böceklere karşı geniş spektrumlu insektisit','InsectShield Max EC, sebze ve meyvelerde emici ve çiğneyici böceklere karşı hızlı ve uzun etkili insektisittir. Kontak ve mide zehiri olarak etki gösterir.','200 g/l Chlorpyrifos-ethyl','EC (Emülsiyon Konsantre)','Domates, Biber, Patlıcan, Elma, Kiraz','{\"Doz\": \"100-150 ml/100L su\", \"PHI\": \"7-21 gün (ürüne göre)\", \"Tekrar\": \"10-14 gün ara ile\", \"Ambalaj\": \"250ml, 1L, 5L\", \"Etki Şekli\": \"Kontak ve mide zehiri\"}','[]',NULL,'InsectShield Max EC İnsektisit','Emici ve çiğneyici böceklere karşı 200 g/l Chlorpyrifos-ethyl içeren geniş spektrumlu insektisit.','insektisit, böcek ilacı, chlorpyrifos, tarım ilacı','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(7,7,'PowerBase 20-20-0+Zn','powerbase-20-20-0zn','GBR-001','Çinko katkılı kompoze taban gübresi','PowerBase 20-20-0+Zn, yüksek fosfor içeriği ile kök gelişimini destekler. Çinko katkısı ile mikroelement ihtiyacını karşılar. Özellikle tahıl ekiminde kullanılır.','%20 N, %20 P₂O₅, %1 Zn','Granül','Buğday, Arpa, Mısır, Ayçiçeği','{\"Doz\": \"20-40 kg/da\", \"Ambalaj\": \"25kg, 50kg\", \"Saklama\": \"Kuru ve serin yerde\", \"Uygulama\": \"Ekim öncesi toprağa\", \"Granül Boyutu\": \"2-4 mm\"}','[]',NULL,'PowerBase 20-20-0+Zn Taban Gübresi','Çinko katkılı, %20 azot ve %20 fosfor içeren kompoze taban gübresi. Kök gelişimi için ideal.','taban gübre, kompoze gübre, çinkolu gübre, DAP gübre','active','2025-12-23 09:31:40','2025-12-23 09:31:40'),(8,12,'Altın Başak - Ekmeklik Buğday','altin-basak-ekmeklik-bugday','THM-001','Yüksek verimli, kışlık ekmeklik buğday tohumu','Altın Başak ekmeklik buğday çeşidi, yüksek verim potansiyeli ve hastalıklara dayanıklılığı ile öne çıkar. Orta erkenci, kışa dayanıklı ve yatmaya mukavim özellik gösterir.','Sertifikalı Buğday Tohumu','R2 Sertifikalı Tohum','Tüm buğday ekim alanları','{\"Ambalaj\": \"25kg\", \"Ekim Normu\": \"22-25 kg/da\", \"Protein Oranı\": \"%12-14\", \"Verim Potansiyeli\": \"600-800 kg/da\", \"Bin Tane Ağırlığı\": \"38-42 g\"}','[]',NULL,'Altın Başak Ekmeklik Buğday Tohumu','Yüksek verimli, hastalıklara dayanıklı kışlık ekmeklik buğday tohumu. 600-800 kg/da verim potansiyeli.','buğday tohumu, ekmeklik buğday, kışlık buğday, sertifikalı tohum','active','2025-12-23 09:31:40','2025-12-23 09:31:40');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
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
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@agricatalog.com','2025-12-23 09:31:38','$2y$12$g0nBPzlJFwhtEaJiOV/tNeGIMX4hrOLtxR.yzVHnUYZ14HPKEkhra',NULL,'2025-12-23 09:31:38','2025-12-23 09:31:38'),(2,'Ahmet Yılmaz','ahmet.yilmaz@agricatalog.com','2025-12-23 09:31:38','$2y$12$mUNbP75XtSD9atZ3Oj5qnuIySr.IFYF02P35NpRTkKlD3wpcgY/zW',NULL,'2025-12-23 09:31:39','2025-12-23 09:31:39'),(3,'Ayşe Demir','ayse.demir@agricatalog.com','2025-12-23 09:31:39','$2y$12$fyiuYnGLkAcVp4gnVihmiOFnMZtQ21bg48eodZMJsPRGBKAGOTB4K',NULL,'2025-12-23 09:31:39','2025-12-23 09:31:39'),(4,'Mehmet Kaya','mehmet.kaya@agricatalog.com','2025-12-23 09:31:39','$2y$12$XlB06DI8dVb/zgiuuks9Oe1DeOJyaJNZM4GKhGR9QFFKaIXX2QiTW',NULL,'2025-12-23 09:31:39','2025-12-23 09:31:39'),(5,'Fatma Öztürk','fatma.ozturk@agricatalog.com','2025-12-23 09:31:39','$2y$12$TqhYHTNzrmhVQsB.ZBsBieLkYI3f15ubVy.7xdEkrSp1XIPEipw7K',NULL,'2025-12-23 09:31:39','2025-12-23 09:31:39'),(6,'Ali Çelik','ali.celik@agricatalog.com','2025-12-23 09:31:39','$2y$12$ekUzkWaHxQnliKkYZOoz5.ztZmn//MOob3H4Zi5p4qe9oqkzuPBcC',NULL,'2025-12-23 09:31:39','2025-12-23 09:31:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-23  9:33:25
