-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: glow_edge_studios
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `user_user_id` int NOT NULL,
  `services_services_id` int NOT NULL,
  `client_message` text,
  `status` varchar(45) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL,
  `admin_msg` text,
  `booking_id` int NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `bookings_pk` (`booking_id`),
  KEY `fk_user_has_services_services1_idx` (`services_services_id`),
  KEY `fk_user_has_services_user1_idx` (`user_user_id`),
  CONSTRAINT `fk_user_has_services_services1` FOREIGN KEY (`services_services_id`) REFERENCES `services` (`services_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_has_services_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (26,1,'I need a new website designed for my business.','pending','2025-08-09 08:23:56',NULL,NULL,1),(30,1,'Requesting a quote for an Android application.','pending','2025-08-09 08:23:56',NULL,NULL,2),(30,3,'Can you help with UI/UX for a mobile app?','confirmed','2025-08-09 08:23:56',NULL,NULL,3),(30,4,'Need help with SEO for my e-commerce site.','confirmed','2025-08-09 08:23:56',NULL,NULL,4),(30,5,'Looking for a new logo and branding package.','completed','2025-08-09 08:23:56',NULL,NULL,5),(30,6,'Want to discuss cloud hosting options for my server.','pending','2025-08-09 08:23:56',NULL,NULL,6),(30,7,'Requesting a meeting to analyze our sales data.','completed','2025-08-09 08:23:56',NULL,NULL,7),(30,8,'Please write 5 blog posts for my website.','cancelled','2025-08-09 08:23:56',NULL,NULL,8),(33,9,'Need social media content for the next month.','confirmed','2025-08-09 08:23:56',NULL,NULL,9),(33,10,'Loo king for a promotional video for our new product.','pending','2025-08-09 08:23:56',NULL,NULL,10);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolio` (
  `portfolio_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`portfolio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (15,'test1','test1','img_68847ab4e15448.48947483_png'),(16,'test1','test1','img_68847accad29c6.44644991_png'),(17,'test1','test1','img_68847ae670ce15.74205398_png');
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(45) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'admin'),(2,'user');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `services_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  `price` double DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`services_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Graphic Design','Professional logo, branding, and marketing material design.',600,'public/assets/upload/test.jpg'),(2,'Photography Services','High-quality photography for products, events, and portraits.',750,'public/assets/upload/test.jpg'),(3,'Graphic Design','Professional logo, branding, and marketing material design.',600,'public/assets/upload/test.jpg'),(4,'Photography Services','High-quality photography for products, events, and portraits.',750,'public/assets/upload/test.jpg'),(5,'Graphic Design','Professional logo, branding, and marketing material design.',600,'public/assets/upload/test.jpg'),(6,'Photography Services','High-quality photography for products, events, and portraits.',750,'public/assets/upload/test.jpg'),(7,'Graphic Design','Professional logo, branding, and marketing material design.',600,'public/assets/upload/test.jpg'),(8,'Photography Services','High-quality photography for products, events, and portraits.',750,'public/assets/upload/test.jpg'),(9,'Graphic Design','Professional logo, branding, and marketing material design.',600,'public/assets/upload/test.jpg'),(10,'Photography Services','High-quality photography for products, events, and portraits.',750,'public/assets/upload/test.jpg');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `whatsapp` varchar(15) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (26,'rukshan','e@gmail.com','$2y$10$bL.l0n94OOMHoK4cxiD8BeksWspaykdN43ZM6q47lB2blRYUUaoLO',NULL,NULL,NULL,NULL),(27,'Rukshan','a@gmail.com','$2y$10$4G7bbTp4s30k2sWxiL7KZuDQsy/EzFYtVb96sxJkITHATDMEfPG5C',NULL,NULL,NULL,NULL),(28,'Rasintha','r@gmail.com','$2y$10$o23FFS4gy/mzJcN7FoAZFu2lDlDvcLGWzUJorL.M7njOAO3ymgCk2',NULL,NULL,NULL,NULL),(29,'Ru','b@gmail.com','$2y$10$d077ULiwfj.0NuH1tkyGOe1Sm92fxUTxkWfXTpYSZIreCK3DG21Tu',NULL,NULL,NULL,NULL),(30,'Rasintha Rukshan','rasintharukshanp@gmail.com','$2y$10$8iUcKrGFsIiyHkl6A4NvvO4RdHbA0vsoftAZ/5XhgEhmsou5Njq7y','0788116854','no01, example rode, Anuradha','0788116854','img_68a06927d41f7819099030.jpeg'),(31,'Ru','c@gmail.com','$2y$10$9vUpe1pkt78s4i.DJdtha.bwhIgTUA3mdVX3lysAZPqWLtsQj38dy',NULL,NULL,NULL,NULL),(32,'r','d@e.c','$2y$10$bKe9ens7PNs.ccFypRJcwu9tIWKG.w3GUqnuXyZnMkhc71zLDi5JS',NULL,NULL,NULL,NULL),(33,'a','a@a.a','$2y$10$8KpsWhLjZrySKFU97aAaDedYrXAAOvpNzChFgrvcRmr8NZPXoPDL2',NULL,NULL,NULL,NULL),(34,'11111111','jhbd@jsjjs.com','$2y$10$MD/QEgC6WH9BLcPhaWV4Y.MNZCZ2X45eFh65ngNyzlgGgb1BE/L3u',NULL,NULL,NULL,NULL),(35,'z','z@z.z','$2y$10$fakvEI5npRBlLPfeGTVVK.LMUk3vLU.BuTCO97w6aovTxVIzhdeAC',NULL,NULL,NULL,NULL),(36,'a','ze@gmail.com','$2y$10$AEKDQJwe/6BaOY2W1vnT6eNE3jsexVFuWebUm6nddUHY/KTGKeH.u',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_portfolio`
--

DROP TABLE IF EXISTS `user_has_portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_portfolio` (
  `user_user_id` int NOT NULL,
  `portfolio_portfolio_id` int NOT NULL,
  PRIMARY KEY (`user_user_id`,`portfolio_portfolio_id`),
  KEY `fk_user_has_portfolio_portfolio1_idx` (`portfolio_portfolio_id`),
  KEY `fk_user_has_portfolio_user1_idx` (`user_user_id`),
  CONSTRAINT `fk_user_has_portfolio_portfolio1` FOREIGN KEY (`portfolio_portfolio_id`) REFERENCES `portfolio` (`portfolio_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_has_portfolio_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_portfolio`
--

LOCK TABLES `user_has_portfolio` WRITE;
/*!40000 ALTER TABLE `user_has_portfolio` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_has_portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_role`
--

DROP TABLE IF EXISTS `user_has_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_role` (
  `user_user_id` int NOT NULL,
  `role_role_id` int NOT NULL,
  PRIMARY KEY (`user_user_id`,`role_role_id`),
  KEY `fk_user_has_role_role1_idx` (`role_role_id`),
  KEY `fk_user_has_role_user_idx` (`user_user_id`),
  CONSTRAINT `fk_user_has_role_role1` FOREIGN KEY (`role_role_id`) REFERENCES `role` (`role_id`),
  CONSTRAINT `fk_user_has_role_user` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_role`
--

LOCK TABLES `user_has_role` WRITE;
/*!40000 ALTER TABLE `user_has_role` DISABLE KEYS */;
INSERT INTO `user_has_role` VALUES (26,1),(30,1),(27,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2);
/*!40000 ALTER TABLE `user_has_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_services`
--

DROP TABLE IF EXISTS `user_has_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_services` (
  `user_user_id` int NOT NULL,
  `services_services_id` int NOT NULL,
  PRIMARY KEY (`user_user_id`,`services_services_id`),
  KEY `fk_user_has_services_services2_idx` (`services_services_id`),
  KEY `fk_user_has_services_user2_idx` (`user_user_id`),
  CONSTRAINT `fk_user_has_services_services2` FOREIGN KEY (`services_services_id`) REFERENCES `services` (`services_id`),
  CONSTRAINT `fk_user_has_services_user2` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_services`
--

LOCK TABLES `user_has_services` WRITE;
/*!40000 ALTER TABLE `user_has_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_has_services` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-19 17:22:51
