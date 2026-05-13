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


-- Dumping database structure for yic_found_db
CREATE DATABASE IF NOT EXISTS `yic_found_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `yic_found_db`;

-- Dumping structure for table yic_found_db.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text,
  `status` enum('LOST','FOUND') NOT NULL,
  `date_posted` date NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `university_id_display` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_resolved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table yic_found_db.items: ~10 rows (approximately)
INSERT INTO `items` (`id`, `item_name`, `category`, `description`, `status`, `date_posted`, `image_url`, `user_id`, `user_name`, `university_id_display`, `created_at`, `is_resolved`) VALUES
	(1, 'Black Laptop', 'Electronics', 'Dell laptop found in the library', 'LOST', '2026-04-12', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500', NULL, 'Nora', 'S123', '2026-05-12 22:39:42', 0),
	(2, 'Golden Ring', 'Personal Items', 'Small gold ring near the cafeteria', 'FOUND', '2026-04-14', 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=500', NULL, 'Wafa', 'S456', '2026-05-12 22:39:42', 0),
	(3, 'Headphone', 'Electronics', 'Sony wireless headphones', 'FOUND', '2026-04-15', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500', NULL, 'Amjad', 'S789', '2026-05-12 22:39:42', 0),
	(4, 'Smart Watch', 'Electronics', 'Apple Watch Series 7', 'LOST', '2026-04-15', 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&q=80&w=400', NULL, 'Jana', 'S111', '2026-05-12 22:39:42', 0),
	(5, 'Leather Wallet', 'Personal Items', 'Brown leather wallet with ID', 'FOUND', '2026-04-15', 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&q=80&w=400', NULL, 'Sara', 'S222', '2026-05-12 22:39:42', 0),
	(6, 'Tablet', 'Electronics', 'iPad Pro with apple pencil', 'LOST', '2026-04-15', 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&q=80&w=400', NULL, 'Lama', 'S333', '2026-05-12 22:39:42', 0),
	(7, 'Car Keys', 'Personal Items', 'Toyota car keys found in parking', 'FOUND', '2026-04-16', NULL, NULL, 'Amani', 'S999', '2026-05-12 22:39:42', 0),
	(8, 'Calculater', 'Electronics', 'Casio calculator', 'LOST', '2026-04-16', NULL, NULL, 'Aseel', 'S888', '2026-05-12 22:39:42', 0),
	(9, 'Student ID', 'Documents', 'Lost ID for student Layla', 'LOST', '2026-04-17', NULL, NULL, 'Mona', 'S777', '2026-05-12 22:39:42', 0),
	(10, 'Water Bottle', 'Personal Items', 'Blue thermal bottle', 'FOUND', '2026-04-17', NULL, NULL, 'Huda', 'S666', '2026-05-12 22:39:42', 0);

-- Dumping structure for table yic_found_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `university_id` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `university_id` (`university_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table yic_found_db.users: ~10 rows (approximately)
INSERT INTO `users` (`id`, `fullname`, `university_id`, `email`, `password`, `role`, `created_at`) VALUES
	(1, 'Wafa Adel', 'S456', 'wafa@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-12 22:39:42'),
	(2, 'Admin User', 'A001', 'admin@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'admin', '2026-05-12 22:39:42'),
	(3, 'Jana Aljohani', 'S444', 'jana@yic.edu.sa', '$2y$10$r4X82UI.kzg/LVHS3GXsdefDfwTqV9A9ArVtdegotOBM7hA4gXq0m', 'student', '2026-05-12 22:49:14'),
	(4, 'Sara Ahmed', 'A002', 'adminsara@yic.edu.sa', '$2y$10$Wm3ZImnf.y831Tf5Gocy6OItwVrq13/OkmiWqdM.QPHVlrW7Wa8W2', 'admin', '2026-05-12 23:51:35'),
	(5, 'Laila Mohammed', 'S101', 'laila@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-13 00:13:56'),
	(6, 'Hind Ahmed', 'S102', 'hind@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-13 00:13:56'),
	(7, 'Raghad Ali', 'S103', 'raghad@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-13 00:13:56'),
	(8, 'Sahar Saleh', 'S104', 'sahar@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-13 00:13:56'),
	(9, 'Noura Khalid', 'S105', 'noura@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-13 00:13:56'),
	(10, 'Fatimah Hassan', 'S106', 'fatimah@yic.edu.sa', '$2y$10$abcdefghij1234567890', 'student', '2026-05-13 00:13:56');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
