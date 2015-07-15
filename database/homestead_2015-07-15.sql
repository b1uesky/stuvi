# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.19-1~exp1ubuntu2)
# Database: homestead
# Generation Time: 2015-07-15 18:17:41 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table addresses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `addresses`;

CREATE TABLE `addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `addressee` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address_line1` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `address_line2` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state_a2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `state_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `country_a2` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'US',
  `country_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'United States',
  `phone_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_index` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;

INSERT INTO `addresses` (`id`, `user_id`, `is_enabled`, `is_default`, `addressee`, `address_line1`, `address_line2`, `city`, `state_a2`, `state_name`, `zip`, `country_a2`, `country_name`, `phone_number`, `created_at`, `updated_at`)
VALUES
	(1,4,1,1,'Eileen Jenkins','2535 West Trace Apt. 728','Apt. 879','Rolfsonburgh','MO','Iowa','76301-7391','US','United States of America','1-939-806-8856x31858','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(2,4,1,0,'Dr. Gregg Tremblay PhD','79161 Linnea Squares Suite 866','Apt. 208','Lake Magdalenberg','NM','Indiana','29124-0481','US','United States of America','(637)316-5749','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,4,1,0,'Madison Schamberger','7882 Breitenberg Land Apt. 880','Suite 694','East Kyle','IA','Alabama','83023-7007','US','United States of America','(970)009-7573x695','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,4,1,0,'Antwan Feest','38730 Bernadine Camp Suite 418','Suite 676','Flochester','VA','Ohio','65582-0051','US','United States of America','709.413.6529','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,4,1,0,'Prof. Terry Bergnaum IV','0106 Bette Gardens Apt. 134','Suite 400','East Jaydon','ID','Arkansas','25357-7761','US','United States of America','1-201-394-7156x53352','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(6,4,1,0,'Dr. Dale Price IV','339 Fritsch Common Suite 602','Suite 396','Lake Chasityton','AL','New Jersey','21276-7599','US','United States of America','008-269-4369x335','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(7,4,1,0,'Miss Esperanza Auer','93484 Pfannerstill Haven','Apt. 862','East Nicolasport','LA','New York','17159-3144','US','United States of America','746-281-8689x758','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(8,4,1,0,'Ms. Celine Windler DDS','057 Laurianne Loop','Suite 280','Christelleville','MO','Utah','39980','US','United States of America','04919092220','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(9,4,1,0,'Felicity Von','54616 Francisca Track','Apt. 628','Dillanland','OR','Illinois','74182-7405','US','United States of America','1-780-513-9848x603','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(10,4,1,0,'Prof. Terrance Ferry','1746 Tremblay Field','Suite 354','New Vida','NM','Indiana','09474-4062','US','United States of America','770-355-1889','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(11,1,1,1,'Tianyou Luo','185 Freeman St.','Apt. 739','Brookline','MA',NULL,'02446','US','United States','(857) 206 4789','2015-07-15 12:36:08','2015-07-15 12:36:08');

/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book_authors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book_authors`;

CREATE TABLE `book_authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `book_authors_book_id_foreign` (`book_id`),
  CONSTRAINT `book_authors_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `book_authors` WRITE;
/*!40000 ALTER TABLE `book_authors` DISABLE KEYS */;

INSERT INTO `book_authors` (`id`, `book_id`, `full_name`, `first_name`, `last_name`, `created_at`, `updated_at`)
VALUES
	(1,1,'R. Richards',NULL,NULL,'2015-07-14 17:39:52','2015-07-14 17:39:52'),
	(2,2,'Robert Sedgewick',NULL,NULL,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(3,2,'Kevin Wayne',NULL,NULL,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(4,3,'Bradley Green',NULL,NULL,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(5,4,'Gayle Laakmann McDowell',NULL,NULL,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(6,5,'Thomas H. Cormen',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(7,5,'Charles E. Leiserson',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(8,5,'Ronald L. Rivest',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(9,5,'Clifford Stein',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(10,6,'Adnan Aziz',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(11,6,'Tsung-Hsien Lee',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(12,6,'Amit Prakash',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(13,7,'Narasimha Karumanchi',NULL,NULL,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(14,8,'John Mongan',NULL,NULL,'2015-07-14 17:39:55','2015-07-14 17:39:55'),
	(15,8,'Noah Kindler',NULL,NULL,'2015-07-14 17:39:55','2015-07-14 17:39:55'),
	(16,8,'Eric Gigu?re',NULL,NULL,'2015-07-14 17:39:55','2015-07-14 17:39:55');

/*!40000 ALTER TABLE `book_authors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table book_image_sets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `book_image_sets`;

CREATE TABLE `book_image_sets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `small_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medium_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `large_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `book_image_sets_book_id_foreign` (`book_id`),
  CONSTRAINT `book_image_sets_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `book_image_sets` WRITE;
/*!40000 ALTER TABLE `book_image_sets` DISABLE KEYS */;

INSERT INTO `book_image_sets` (`id`, `book_id`, `small_image`, `medium_image`, `large_image`, `created_at`, `updated_at`)
VALUES
	(1,1,NULL,NULL,NULL,'2015-07-14 17:39:52','2015-07-14 17:39:52'),
	(2,2,'http://ecx.images-amazon.com/images/I/51UDgHU9z9L._SL75_.jpg','http://ecx.images-amazon.com/images/I/51UDgHU9z9L._SL160_.jpg','http://ecx.images-amazon.com/images/I/51UDgHU9z9L.jpg','2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(3,3,'http://ecx.images-amazon.com/images/I/513fa9R0E8L._SL75_.jpg','http://ecx.images-amazon.com/images/I/513fa9R0E8L._SL160_.jpg','http://ecx.images-amazon.com/images/I/513fa9R0E8L.jpg','2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(4,4,'http://ecx.images-amazon.com/images/I/41wgksZup2L._SL75_.jpg','http://ecx.images-amazon.com/images/I/41wgksZup2L._SL160_.jpg','http://ecx.images-amazon.com/images/I/41wgksZup2L.jpg','2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(5,5,'http://ecx.images-amazon.com/images/I/51WLL1XC30L._SL75_.jpg','http://ecx.images-amazon.com/images/I/51WLL1XC30L._SL160_.jpg','http://ecx.images-amazon.com/images/I/51WLL1XC30L.jpg','2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(6,6,'http://ecx.images-amazon.com/images/I/51TYTkI4QbL._SL75_.jpg','http://ecx.images-amazon.com/images/I/51TYTkI4QbL._SL160_.jpg','http://ecx.images-amazon.com/images/I/51TYTkI4QbL.jpg','2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(7,7,'http://ecx.images-amazon.com/images/I/513E0i3NoAL._SL75_.jpg','http://ecx.images-amazon.com/images/I/513E0i3NoAL._SL160_.jpg','http://ecx.images-amazon.com/images/I/513E0i3NoAL.jpg','2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(8,8,'http://ecx.images-amazon.com/images/I/51sxN5J9vgL._SL75_.jpg','http://ecx.images-amazon.com/images/I/51sxN5J9vgL._SL160_.jpg','http://ecx.images-amazon.com/images/I/51sxN5J9vgL.jpg','2015-07-14 17:39:55','2015-07-14 17:39:55');

/*!40000 ALTER TABLE `book_image_sets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table books
# ------------------------------------------------------------

DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edition` tinyint(4) NOT NULL DEFAULT '1',
  `isbn10` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `isbn13` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `num_pages` smallint(6) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `binding` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `list_price` decimal(8,2) DEFAULT NULL,
  `lowest_new_price` decimal(8,2) DEFAULT NULL,
  `lowest_used_price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;

INSERT INTO `books` (`id`, `title`, `edition`, `isbn10`, `isbn13`, `num_pages`, `verified`, `binding`, `language`, `list_price`, `lowest_new_price`, `lowest_used_price`, `created_at`, `updated_at`)
VALUES
	(1,'Principles of Solid Mechanics (Advanced Topics in Mechanical Engineering Series.)',1,'084930315X','9780849303159',446,0,'Hardcover','English',NULL,80.13,NULL,'2015-07-14 17:39:52','2015-07-14 17:39:52'),
	(2,'Algorithms (4th Edition)',4,'032157351X','9780321573513',992,0,'Hardcover','English',84.99,55.74,55.70,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(3,'Programming Problems: Advanced Algorithms (Volume 2)',1,'1484964098','9781484964095',200,0,'Paperback','English',13.95,11.97,8.57,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(4,'Cracking the Coding Interview: 150 Programming Questions and Solutions',5,'098478280X','9780984782802',508,0,'Paperback','English',39.95,17.96,16.01,'2015-07-14 17:39:53','2015-07-14 17:39:53'),
	(5,'Introduction to Algorithms, 3rd Edition',3,'0262033844','9780262033848',1312,0,'Hardcover','English',94.00,63.57,55.99,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(6,'Elements of Programming Interviews: The Insiders\' Guide',1,'1479274836','9781479274833',492,0,'Paperback','English',39.95,17.12,17.12,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(7,'Data Structures and Algorithms Made Easy: Data Structure and Algorithmic Puzzles, Second Edition',2,'1468108867','9781468108866',434,0,'Paperback','English',39.99,25.00,21.85,'2015-07-14 17:39:54','2015-07-14 17:39:54'),
	(8,'Programming Interviews Exposed: Secrets to Landing Your Next Job',3,'1118261364','9781118261361',336,0,'Paperback','English',29.99,14.98,10.49,'2015-07-14 17:39:55','2015-07-14 17:39:55');

/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table buyer_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `buyer_orders`;

CREATE TABLE `buyer_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` int(10) unsigned NOT NULL,
  `courier_id` int(10) unsigned DEFAULT NULL,
  `time_delivered` timestamp NULL DEFAULT NULL,
  `shipping_address_id` int(10) unsigned NOT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `buyer_orders_shipping_address_id_foreign` (`shipping_address_id`),
  KEY `buyer_orders_buyer_id_foreign` (`buyer_id`),
  KEY `buyer_orders_courier_id_foreign` (`courier_id`),
  CONSTRAINT `buyer_orders_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`),
  CONSTRAINT `buyer_orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`),
  CONSTRAINT `buyer_orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `buyer_orders` WRITE;
/*!40000 ALTER TABLE `buyer_orders` DISABLE KEYS */;

INSERT INTO `buyer_orders` (`id`, `buyer_id`, `courier_id`, `time_delivered`, `shipping_address_id`, `cancelled`, `cancelled_time`, `created_at`, `updated_at`)
VALUES
	(1,4,NULL,NULL,1,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(2,4,NULL,NULL,2,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,4,NULL,NULL,3,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,4,NULL,NULL,4,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,4,NULL,NULL,5,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(6,4,NULL,NULL,6,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(7,4,NULL,NULL,7,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(8,4,NULL,NULL,8,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(9,4,NULL,NULL,9,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(10,4,NULL,NULL,10,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(11,1,NULL,NULL,11,0,NULL,'2015-07-15 12:36:18','2015-07-15 12:36:18');

/*!40000 ALTER TABLE `buyer_orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table buyer_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `buyer_payments`;

CREATE TABLE `buyer_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyer_order_id` int(10) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `charge_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `object` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `card_last4` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `card_brand` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `card_fingerprint` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `buyer_payments_buyer_order_id_foreign` (`buyer_order_id`),
  CONSTRAINT `buyer_payments_buyer_order_id_foreign` FOREIGN KEY (`buyer_order_id`) REFERENCES `buyer_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `buyer_payments` WRITE;
/*!40000 ALTER TABLE `buyer_payments` DISABLE KEYS */;

INSERT INTO `buyer_payments` (`id`, `buyer_order_id`, `amount`, `charge_id`, `card_id`, `object`, `card_last4`, `card_brand`, `card_fingerprint`, `created_at`, `updated_at`)
VALUES
	(1,1,2999,'1','1','1','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(2,2,2999,'2','2','2','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,3,2999,'3','3','3','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,4,2999,'4','4','4','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,5,2999,'5','5','5','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(6,6,2999,'6','6','6','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(7,7,2999,'7','7','7','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(8,8,2999,'8','8','8','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(9,9,2999,'9','9','9','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(10,10,2999,'10','10','10','1234','visa','fp','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(11,11,4999,'ch_16OsrmEevVfPfVHNWIgsMIdL','card_16OsrlEevVfPfVHNeRSeU9Vf','card','4242','Visa','q75AIt0EYz99oKnd','2015-07-15 12:36:20','2015-07-15 12:36:20');

/*!40000 ALTER TABLE `buyer_payments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cart_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart_items`;

CREATE TABLE `cart_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table carts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `carts`;

CREATE TABLE `carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;

INSERT INTO `carts` (`id`, `user_id`, `quantity`, `created_at`, `updated_at`)
VALUES
	(1,1,0,'2015-07-15 11:46:18','2015-07-15 12:22:54');

/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table colleges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `colleges`;

CREATE TABLE `colleges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `university_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `colleges_university_id_foreign` (`university_id`),
  CONSTRAINT `colleges_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `a2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `a3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `major_id` int(10) unsigned DEFAULT NULL,
  `professor_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_major_id_foreign` (`major_id`),
  KEY `courses_professor_id_foreign` (`professor_id`),
  CONSTRAINT `courses_professor_id_foreign` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`id`),
  CONSTRAINT `courses_major_id_foreign` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table majors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `majors`;

CREATE TABLE `majors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `college_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `majors_college_id_foreign` (`college_id`),
  CONSTRAINT `majors_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_01_15_090136_create_states',1),
	('2014_01_15_090147_create_countries',1),
	('2014_10_11_000000_create_universities_table',1),
	('2014_10_12_000000_create_users_table',1),
	('2014_10_12_100000_create_password_resets_table',1),
	('2014_10_13_105422_create_addresses',1),
	('2015_04_15_144206_create_books_table',1),
	('2015_04_15_145000_create_book_image_sets_table',1),
	('2015_04_15_150513_create_products_table',1),
	('2015_04_15_150728_create_product_images_table',1),
	('2015_04_15_151321_create_product_conditions_table',1),
	('2015_05_28_154639_create_buyer_orders_table',1),
	('2015_05_28_154640_create_buyer_payments_table',1),
	('2015_05_28_154742_create_seller_orders_table',1),
	('2015_05_28_154749_create_seller_payments_table',1),
	('2015_06_10_142829_create_book_authors_table',1),
	('2015_06_26_135056_create_stripe_authorization_credentials_table',1),
	('2015_06_26_165446_create_stripe_transfer_table',1),
	('2015_07_02_165932_create_colleges_table',1),
	('2015_07_02_165945_create_majors_table',1),
	('2015_07_02_165950_create_professors_table',1),
	('2015_07_02_165956_create_courses_table',1),
	('2015_07_03_105801_create_professor_university_table',1),
	('2015_07_06_171641_create_carts_table',1),
	('2015_07_06_171738_create_cart_items_table',1),
	('2015_07_10_120754_create_stripe_refunds_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table product_conditions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_conditions`;

CREATE TABLE `product_conditions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `broken_binding` tinyint(1) NOT NULL,
  `general_condition` tinyint(4) NOT NULL,
  `highlights_and_notes` tinyint(4) NOT NULL,
  `damaged_pages` tinyint(4) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_conditions_product_id_foreign` (`product_id`),
  CONSTRAINT `product_conditions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `product_conditions` WRITE;
/*!40000 ALTER TABLE `product_conditions` DISABLE KEYS */;

INSERT INTO `product_conditions` (`id`, `description`, `created_at`, `updated_at`, `broken_binding`, `general_condition`, `highlights_and_notes`, `damaged_pages`, `product_id`)
VALUES
	(1,'Brand new!','2015-07-14 17:39:56','2015-07-14 17:39:56',0,0,0,0,1),
	(2,'Excellent!','2015-07-14 17:39:56','2015-07-14 17:39:56',0,1,1,1,2),
	(3,'Good.','2015-07-14 17:39:56','2015-07-14 17:39:56',0,2,2,2,3),
	(4,'Brand new!','2015-07-14 17:39:56','2015-07-14 17:39:56',0,0,0,0,4),
	(5,'Excellent!','2015-07-14 17:39:56','2015-07-14 17:39:56',0,1,1,1,5),
	(6,'Good.','2015-07-14 17:39:56','2015-07-14 17:39:56',0,2,2,2,6),
	(7,'Brand new!','2015-07-14 17:39:56','2015-07-14 17:39:56',0,0,0,0,7),
	(8,'Excellent!','2015-07-14 17:39:56','2015-07-14 17:39:56',0,1,1,1,8),
	(9,'Good.','2015-07-14 17:39:56','2015-07-14 17:39:56',0,2,2,2,9);

/*!40000 ALTER TABLE `product_conditions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_images`;

CREATE TABLE `product_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;

INSERT INTO `product_images` (`id`, `path`, `product_id`, `created_at`, `updated_at`)
VALUES
	(1,'/img/product/Algorithms.png',1,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(2,'/img/product/Algorithms.png',2,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,'/img/product/Algorithms.png',3,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,'/img/product/Programming-Problems.jpg',4,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,'/img/product/Programming-Problems.jpg',4,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(6,'/img/product/Programming-Problems.jpg',4,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(7,'/img/product/Programming-Problems.jpg',5,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(8,'/img/product/Programming-Problems.jpg',6,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(9,'/img/product/Principles-of-solid-mechanics.jpg',7,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(10,'/img/product/Principles-of-solid-mechanics.jpg',7,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(11,'/img/product/Principles-of-solid-mechanics.jpg',8,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(12,'/img/product/Principles-of-solid-mechanics.jpg',9,'2015-07-14 17:39:56','2015-07-14 17:39:56');

/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` decimal(8,2) NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `sold` tinyint(1) NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `products_book_id_foreign` (`book_id`),
  KEY `products_seller_id_foreign` (`seller_id`),
  CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`),
  CONSTRAINT `products_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `price`, `book_id`, `seller_id`, `sold`, `verified`, `created_at`, `updated_at`)
VALUES
	(1,49.99,2,3,1,0,'2015-07-14 17:39:56','2015-07-15 12:36:18'),
	(2,39.99,2,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,29.99,2,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,49.99,3,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,39.99,3,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(6,29.99,3,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(7,129.99,1,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(8,109.99,1,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(9,89.99,1,3,0,0,'2015-07-14 17:39:56','2015-07-14 17:39:56');

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table professor_university
# ------------------------------------------------------------

DROP TABLE IF EXISTS `professor_university`;

CREATE TABLE `professor_university` (
  `professor_id` int(10) unsigned NOT NULL,
  `university_id` int(10) unsigned NOT NULL,
  KEY `professor_university_professor_id_index` (`professor_id`),
  KEY `professor_university_university_id_index` (`university_id`),
  CONSTRAINT `professor_university_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `professor_university_professor_id_foreign` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table professors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `professors`;

CREATE TABLE `professors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table seller_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seller_orders`;

CREATE TABLE `seller_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `scheduled_pickup_time` timestamp NULL DEFAULT NULL,
  `pickup_time` timestamp NULL DEFAULT NULL,
  `pickup_code` int(11) DEFAULT NULL,
  `courier_id` int(10) unsigned DEFAULT NULL,
  `buyer_order_id` int(10) unsigned NOT NULL,
  `address_id` int(10) unsigned DEFAULT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `seller_orders_product_id_foreign` (`product_id`),
  KEY `seller_orders_buyer_order_id_foreign` (`buyer_order_id`),
  KEY `seller_orders_courier_id_foreign` (`courier_id`),
  KEY `seller_orders_address_id_foreign` (`address_id`),
  CONSTRAINT `seller_orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  CONSTRAINT `seller_orders_buyer_order_id_foreign` FOREIGN KEY (`buyer_order_id`) REFERENCES `buyer_orders` (`id`),
  CONSTRAINT `seller_orders_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`),
  CONSTRAINT `seller_orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `seller_orders` WRITE;
/*!40000 ALTER TABLE `seller_orders` DISABLE KEYS */;

INSERT INTO `seller_orders` (`id`, `product_id`, `scheduled_pickup_time`, `pickup_time`, `pickup_code`, `courier_id`, `buyer_order_id`, `address_id`, `cancelled`, `cancelled_time`, `created_at`, `updated_at`)
VALUES
	(1,1,NULL,NULL,NULL,NULL,1,NULL,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(2,2,NULL,NULL,NULL,NULL,2,NULL,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,3,NULL,NULL,NULL,NULL,3,NULL,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,4,NULL,NULL,NULL,NULL,4,NULL,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,1,'2015-07-14 17:39:56',NULL,1234,NULL,1,1,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(6,1,'2015-07-14 17:39:56',NULL,1234,NULL,1,1,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(7,2,'2015-07-14 17:39:56',NULL,1234,NULL,2,2,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(8,2,'2015-07-14 17:39:56',NULL,1234,NULL,2,2,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(9,3,'2015-07-14 17:39:56',NULL,1234,NULL,3,3,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(10,3,'2015-07-14 17:39:56',NULL,1234,NULL,3,3,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(11,4,'2015-07-14 17:39:56',NULL,1234,NULL,4,4,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(12,4,'2015-07-14 17:39:56',NULL,1234,NULL,4,4,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(13,5,'2015-07-14 17:39:56',NULL,1234,NULL,5,5,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(14,5,'2015-07-14 17:39:56',NULL,1234,NULL,5,5,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(15,6,'2015-07-14 17:39:56',NULL,1234,NULL,6,6,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(16,6,'2015-07-14 17:39:56',NULL,1234,NULL,6,6,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(17,7,'2015-07-14 17:39:56',NULL,1234,NULL,7,7,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(18,7,'2015-07-14 17:39:56',NULL,1234,NULL,7,7,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(19,8,'2015-07-14 17:39:56',NULL,1234,NULL,8,8,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(20,8,'2015-07-14 17:39:56',NULL,1234,NULL,8,8,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(21,9,'2015-07-14 17:39:56',NULL,1234,NULL,9,9,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(22,9,'2015-07-14 17:39:56',NULL,1234,NULL,9,9,0,NULL,'2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(23,1,NULL,NULL,NULL,NULL,11,NULL,0,NULL,'2015-07-15 12:36:18','2015-07-15 12:36:18');

/*!40000 ALTER TABLE `seller_orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table seller_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seller_payments`;

CREATE TABLE `seller_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_order_id` int(10) unsigned NOT NULL,
  `stripe_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_token_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `seller_payments_seller_order_id_foreign` (`seller_order_id`),
  CONSTRAINT `seller_payments_seller_order_id_foreign` FOREIGN KEY (`seller_order_id`) REFERENCES `seller_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table states
# ------------------------------------------------------------

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_a2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `a2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table stripe_authorization_credentials
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_authorization_credentials`;

CREATE TABLE `stripe_authorization_credentials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refresh_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_publishable_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `stripe_authorization_credentials_user_id_foreign` (`user_id`),
  CONSTRAINT `stripe_authorization_credentials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table stripe_refunds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_refunds`;

CREATE TABLE `stripe_refunds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `buyer_order_id` int(10) unsigned NOT NULL,
  `refund_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `operator_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `stripe_refunds_buyer_order_id_foreign` (`buyer_order_id`),
  KEY `stripe_refunds_operator_id_foreign` (`operator_id`),
  CONSTRAINT `stripe_refunds_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `stripe_refunds_buyer_order_id_foreign` FOREIGN KEY (`buyer_order_id`) REFERENCES `buyer_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table stripe_transfers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_transfers`;

CREATE TABLE `stripe_transfers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seller_order_id` int(10) unsigned NOT NULL,
  `transfer_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destination_payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `application_fee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `stripe_transfers_seller_order_id_foreign` (`seller_order_id`),
  CONSTRAINT `stripe_transfers_seller_order_id_foreign` FOREIGN KEY (`seller_order_id`) REFERENCES `seller_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table universities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `universities`;

CREATE TABLE `universities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_suffix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `universities` WRITE;
/*!40000 ALTER TABLE `universities` DISABLE KEYS */;

INSERT INTO `universities` (`id`, `name`, `abbreviation`, `email_suffix`, `is_public`)
VALUES
	(1,'Boston University','BU','bu.edu',1),
	(2,'Massachusetts Institute of Technology','MIT','mit.edu',0),
	(3,'Northeastern University','NEU','neu.edu',0),
	(4,'Harvard University','HARVARD','harvard.edu',0),
	(5,'Boston College','BC','bc.edu',0);

/*!40000 ALTER TABLE `universities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `university_id` int(10) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'u',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_university_id_foreign` (`university_id`),
  CONSTRAINT `users_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `activated`, `activation_code`, `phone_number`, `first_name`, `last_name`, `university_id`, `remember_token`, `role`, `created_at`, `updated_at`)
VALUES
	(1,'luoty@bu.edu','$2y$10$xUrF/jXuPFtdyVXmU9V1N.R9JpdB32HBi3wsYiAfkyQg4vM4RCBNe',1,'7f39563b6ffebba18ad7a94526226970','8572064789','Tianyou','Luo',1,NULL,'uac','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(2,'test@bu.edu','$2y$10$NZbzBthXaT8Q3aHTj97s6u09CJGR6EBrHxswGKLc3/Q/9.GgbiO5G',1,'31395796e282e4b5f1add19d201f4075','','Pengcheng','Ding',1,NULL,'uac','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(3,'seller@stuvi.com','$2y$10$m6SFVQOB0cb30haT81rwa..t/utjpZQXfSUO/HP.L2MYAf7Ru7kRS',1,'da23a4e91fc334aec934832399ee9e3c','','Seller','Stuvi',1,NULL,'ua','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(4,'buyer@stuvi.com','$2y$10$Ou/cwZSJgXwB0LmN5QClROvA1qsOubOnDzjxi.Cm7/6fEcCJcr7bi',1,'8f5bb0e8a021179a91e98b6186b84da7','','Buyer','Stuvi',1,NULL,'ua','2015-07-14 17:39:56','2015-07-14 17:39:56'),
	(5,'courier@stuvi.com','$2y$10$L8XnqxzY44EG5ASRu1bHSOpVr.z0VdQ81.CS3sS792POM11HdpdCC',1,'734a3fbcc31794ed8ccd01572dc72227','','Courier','Stuvi',1,NULL,'ac','2015-07-14 17:39:56','2015-07-14 17:39:56');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
