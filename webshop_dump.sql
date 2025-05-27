-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: echo
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
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price_per_item` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,3,199.99),(2,1,2,4,149.99),(8,6,3,7,249.99),(12,8,3,1,249.99),(13,9,3,1,249.99),(16,10,9,1,59.99),(17,10,20,1,249.99),(18,11,7,1,129.99),(20,12,2,1,149.99),(21,13,3,2,249.99),(22,13,8,1,49.99),(24,14,3,3,249.99),(25,15,1,6,199.99),(26,15,2,1,149.99),(27,16,3,3,249.99),(29,18,3,1,249.99),(30,19,2,5,149.99),(31,20,1,3,199.99),(32,21,1,2,199.99),(33,21,4,1,129.99),(34,22,25,1,299.99),(35,23,25,1,299.99),(36,24,25,2,299.99),(37,25,22,1,39.99);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,1199.93,'N/A','2025-05-11 16:12:40'),(2,2,179.99,'N/A','2025-05-11 16:46:08'),(3,2,179.99,'N/A','2025-05-11 18:24:20'),(4,2,149.99,'N/A','2025-05-11 18:24:32'),(5,2,129.99,'N/A','2025-05-11 18:36:47'),(6,2,1749.93,'N/A','2025-05-11 18:40:24'),(7,2,649.97,'N/A','2025-05-11 20:15:32'),(8,3,399.98,'N/A','2025-05-11 20:22:12'),(9,5,449.98,'N/A','2025-05-12 12:27:34'),(10,6,309.98,'N/A','2025-05-26 18:04:32'),(11,6,129.99,'N/A','2025-05-26 18:06:19'),(12,7,349.98,'N/A','2025-05-27 00:14:26'),(13,7,549.97,'N/A','2025-05-27 00:14:32'),(14,5,1349.94,'N/A','2025-05-27 00:39:27'),(15,5,1349.93,'N/A','2025-05-27 02:45:54'),(16,5,749.97,'N/A','2025-05-27 02:48:55'),(17,5,99.67,'N/A','2025-05-27 02:52:56'),(18,5,249.99,'N/A','2025-05-27 02:58:24'),(19,5,749.95,'N/A','2025-05-27 02:58:35'),(20,5,599.97,'N/A','2025-05-27 13:07:00'),(21,5,529.97,'N/A','2025-05-27 15:53:00'),(22,5,299.99,'N/A','2025-05-27 15:56:54'),(23,5,299.99,'N/A','2025-05-27 16:05:46'),(24,9,599.98,'N/A','2025-05-27 16:25:06'),(25,5,39.99,'N/A','2025-05-27 16:25:44'),(26,5,599.98,'N/A','2025-05-27 16:30:00');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `rating` float DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `image_filename` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'uncategorized',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'ErgoComfort Chair','Ergonomic office chair with lumbar support and breathable mesh.',4.7,199.99,'chair1.png','2025-04-27 17:20:04','chair'),(2,'FlexiWork Mesh Chair','Flexible mesh office chair with adjustable height and armrests.',4.5,149.99,'chair2.png','2025-04-27 17:20:04','chair'),(3,'UrbanPro Executive Chair','Executive leather office chair with reclining function.',4.8,249.99,'chair3.png','2025-04-27 17:20:04','chair'),(4,'CompactSpace Chair','Minimalist compact office chair, perfect for small spaces.',4.3,129.99,'chair2.png','2025-04-27 17:20:04','chair'),(6,'Nordic Coffee Table','Sleek wooden coffee table with minimalist design.',4.1,89.99,'table1.png','2025-05-11 17:10:53','table'),(7,'Urban Bookshelf','Industrial-style bookshelf with metal frame.',4.3,129.99,'shelf1.png','2025-05-11 17:10:53','shelf'),(8,'Scandi Side Table','Compact side table perfect for small spaces.',4,49.99,'table2.png','2025-05-11 17:10:53','table'),(9,'Loft Floor Lamp','Adjustable-height lamp with warm LED light.',4.5,59.99,'lamp1.png','2025-05-11 17:10:53','lighting'),(10,'Retro Desk Lamp','Vintage desk lamp with brass finish.',4.2,39.99,'lamp1.png','2025-05-11 17:10:53','lighting'),(11,'Classic Rug 160x230','Soft wool rug in neutral tones.',4.4,149.99,'sample1.png','2025-05-11 17:10:53','decor'),(13,'Glass TV Stand','Tempered glass TV stand with two shelves.',4,119.99,'sample1.png','2025-05-11 17:10:53','tv stand'),(14,'Marble Dining Table','Round marble top dining table seating four.',4.7,399.99,'table1.png','2025-05-11 17:10:53','table'),(17,'Canvas Wall Art','Abstract canvas art for living room.',4.2,49.99,'sample1.png','2025-05-11 17:10:53','decor'),(18,'Plant Stand','Metal plant stand for indoor greenery.',4,29.99,'sample1.png','2025-05-11 17:10:53','decor'),(20,'Ergo Office Desk','Height-adjustable standing desk.',4.5,249.99,'table2.png','2025-05-11 17:10:53','desk'),(21,'Linen Sofa Cover','Removable linen cover for 3-seat sofa.',4.1,69.99,'sample1.png','2025-05-11 17:10:53','upholstery'),(22,'Steel Coat Rack','Freestanding steel coat rack with hooks.',4,39.99,'sample1.png','2025-05-11 17:10:53','storage'),(24,'Throw Pillow Set','Set of 4 decorative throw pillows.',4.2,29.99,'sample1.png','2025-05-11 17:10:53','decor'),(25,'Bamboo Sideboard','Low-profile bamboo sideboard with sliding doors.',4.3,299.99,'shelf1.png','2025-05-11 17:10:53','storage');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `salutation` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_info` text COLLATE utf8mb4_general_ci,
  `is_admin` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mr','d','d','d','1','d','f@m.com','wd','$2y$10$g6w1FHCC1vKyrhrQa0cg9OqqlLY/BrB35p2vbVTgmB3hYv5tjzTkq','d',0,0,'2025-05-11 14:42:11'),(2,'Mr','w','w','w','1','w','w@w.com','w','$2y$10$xkiuRNQHyT/rpbUSTGfCkerJWV7VkpH8YSrUM2o7D896KoxbGX6k2','w',0,0,'2025-05-11 14:53:34'),(3,'Ms','s','s','d','1','d','s@d.com','s','$2y$10$LQcBJj.c.abSysh7VpMB4eaYHvB65rcs93XH3ENoCFgS/T77WOoZ6','s',0,1,'2025-05-11 20:21:45'),(4,'Ms.','Jane','Doe',NULL,NULL,NULL,'jane.doe@example.com','janedoe','6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b',NULL,1,1,'2025-05-12 11:09:56'),(5,'Mr.','1','1CHECK','12','1','england','a@a.com','1','$2y$10$8PHCduE93nKoF4XdUWSm9u3Oq9AyvoHh1Goids.2DLhpsDLUAXxH.','1',1,1,'2025-05-12 11:12:46'),(6,'Mx','Juan','Deporto','w','1','1','juan@juan.juan','juan','$2y$10$iyfeCLrEva9Nej.Zr/c8VeNKobZmaIh1zE9vv7baMIXNoxKEmk0ba','j',0,0,'2025-05-26 18:03:57'),(7,'Mr.','1','1','1yi','1','1234','i@i.at','ia','$2y$10$QwiCJVSi/UlXXe4ZHbC1buWEEsTm5D8/hKGTbxweVYvmcBjZ8JRli','1',0,1,'2025-05-26 23:56:37'),(8,'Mr.','prr prr','patapim','1','1','1334','d23232@gmail.com','pr','$2y$10$pHB8bg8x1glm648HV/Z.Oudkwxxw74.HRHLI0CoEoODHc4GwOUCoe','tung',0,0,'2025-05-27 02:22:11'),(9,'Mr.','tung','sahur','1','16','1','1@tung.com','sahur','$2y$10$SbwOxCnJk1AeGashlT1vdugkLEZjfkaLqb3.a/H1cSmxlY0t8AJuS',NULL,0,0,'2025-05-27 16:24:35');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vouchers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `expires_at` date DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT '0',
  `used_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vouchers`
--

LOCK TABLES `vouchers` WRITE;
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-27 18:42:58
