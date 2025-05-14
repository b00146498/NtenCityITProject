-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.1.72-community - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ntencity
CREATE DATABASE IF NOT EXISTS `ntencity` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ntencity`;

-- Dumping structure for table ntencity.activities
CREATE TABLE IF NOT EXISTS `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `strava_id` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `distance` double(8,2) NOT NULL,
  `moving_time` int(11) NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activities_strava_id_unique` (`strava_id`),
  KEY `activities_client_id_foreign` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.activities: 0 rows
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;

-- Dumping structure for view ntencity.appointmentevent
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `appointmentevent` (
	`id` INT(11) NOT NULL,
	`title` VARCHAR(101) NOT NULL COLLATE 'latin1_swedish_ci',
	`start` VARBINARY(19) NULL,
	`end` VARBINARY(19) NULL
) ENGINE=MyISAM;

-- Dumping structure for table ntencity.appointments
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `practice_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','confirmed','checked-in','completed','canceled') DEFAULT 'pending',
  `notes` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `employee_id` (`employee_id`),
  KEY `practice_id` (`practice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.appointments: 21 rows
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` (`id`, `client_id`, `employee_id`, `practice_id`, `booking_date`, `start_time`, `end_time`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 1, '2025-02-20', '10:00:00', '10:45:00', 'confirmed', 'Routine checkup', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(2, 2, 2, 2, '2025-02-21', '14:30:00', '15:15:00', 'pending', 'First-time consultation', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(3, 3, 3, 3, '2025-02-22', '11:15:00', '12:00:00', 'checked-in', 'Follow-up session', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(4, 4, 4, 4, '2025-02-23', '09:45:00', '10:30:00', 'completed', 'Rehabilitation therapy', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(5, 5, 5, 5, '2025-02-24', '13:00:00', '13:45:00', 'canceled', 'Client rescheduled', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(6, 6, 6, 6, '2025-02-25', '16:00:00', '16:45:00', 'confirmed', 'Strength training session', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(7, 7, 7, 7, '2025-02-26', '12:30:00', '13:15:00', 'pending', 'Post-injury assessment', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(8, 8, 8, 8, '2025-02-27', '15:45:00', '16:30:00', 'completed', 'Final therapy session', '2025-03-01 12:36:11', '2025-03-01 12:36:11', NULL),
	(9, 1, 1, 1, '2025-03-14', '17:00:00', '18:00:00', 'pending', 'Need medication', '2025-03-01 12:37:26', '2025-03-01 12:37:26', NULL),
	(10, 1, 1, 1, '2025-03-13', '12:00:00', '12:45:00', 'pending', NULL, '2025-03-12 11:19:54', '2025-03-12 11:19:54', NULL),
	(11, 1, 1, 1, '2025-03-14', '11:30:00', '12:15:00', 'pending', NULL, '2025-03-12 15:01:42', '2025-03-12 15:01:42', NULL),
	(12, 1, 1, 1, '2025-03-14', '11:30:00', '12:15:00', 'pending', NULL, '2025-03-12 15:01:47', '2025-03-12 15:01:47', NULL),
	(13, 1, 2, 1, '2025-03-06', '11:30:00', '12:15:00', 'pending', NULL, '2025-03-12 15:48:32', '2025-03-12 15:48:32', NULL),
	(14, 4, 2, 1, '2025-04-15', '14:00:00', '15:00:00', 'confirmed', NULL, '2025-04-03 15:51:04', '2025-04-03 15:51:04', NULL),
	(15, 1, 31, 1, '2025-05-13', '09:30:00', '10:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-7D40D5B5AF, Amount: €105\n\nPayment processed: Transaction ID: TRANS-A5BAD3BC79, Amount: €105\n\nPayment processed: Transaction ID: TRANS-7ED75B59A3, Amount: €105', '2025-05-08 22:57:17', '2025-05-08 22:57:48', NULL),
	(16, 1, 19, 3, '2025-05-21', '09:30:00', '10:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: €105\n\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: €105\n\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: €105\n\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: €105\n\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: €105\n\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: €105\n\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: €105\n\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: €105\n\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: €105\n\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: €105\n\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: €105\n\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: €105\n\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: €105\n\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: €105\n\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: €105\n\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: €105\n\nPayment processed: Transaction ID: TRANS-357A01D2BB, Amount: €105\n\nPayment processed: Transaction ID: TRANS-68D6E81E25, Amount: €105\n\nPayment processed: Transaction ID: TRANS-7FCE59A7B1, Amount: €105\n\nPayment processed: Transaction ID: TRANS-B3D71E42ED, Amount: €105\n\nPayment processed: Transaction ID: TRANS-E67EFA9D66, Amount: €105', '2025-05-12 21:23:12', '2025-05-12 21:25:08', NULL),
	(17, 1, 19, 4, '2025-05-15', '10:00:00', '10:45:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-54C6D6449F, Amount: €105', '2025-05-12 21:25:37', '2025-05-12 21:25:42', NULL),
	(18, 1, 16, 5, '2025-05-13', '09:30:00', '10:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-AAC4F6EE42, Amount: €105', '2025-05-13 01:15:57', '2025-05-13 01:16:01', NULL),
	(19, 1, 11, 4, '2025-05-14', '13:30:00', '14:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-117E2086FD, Amount: €105', '2025-05-13 01:17:40', '2025-05-13 01:17:43', NULL),
	(20, 23, 8, 4, '2025-05-15', '10:30:00', '11:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-139E83A538, Amount: €105', '2025-05-13 11:36:26', '2025-05-13 11:36:30', NULL),
	(21, 35, 6, 6, '2025-05-13', '13:30:00', '14:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-6DD1199DC7, Amount: €105', '2025-05-13 22:24:36', '2025-05-13 22:24:42', NULL),
	(22, 35, 11, 1, '2025-05-14', '10:30:00', '11:15:00', 'confirmed', '\n\nPayment processed: Transaction ID: TRANS-918F495426, Amount: €105', '2025-05-14 11:59:56', '2025-05-14 12:00:04', NULL);
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;

-- Dumping structure for table ntencity.client
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `county` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_status` enum('Active','Inactive') NOT NULL,
  `practice_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `userid` bigint(20) unsigned DEFAULT NULL,
  `strava_access_token` varchar(191) DEFAULT NULL,
  `strava_refresh_token` varchar(191) DEFAULT NULL,
  `strava_token_expires` datetime DEFAULT NULL,
  `strava_token_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `FK_client_user_unique` (`userid`),
  KEY `practice_id` (`practice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.client: 35 rows
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `first_name`, `surname`, `date_of_birth`, `gender`, `email`, `contact_number`, `street`, `city`, `county`, `username`, `password`, `account_status`, `practice_id`, `created_at`, `updated_at`, `deleted_at`, `userid`, `strava_access_token`, `strava_refresh_token`, `strava_token_expires`, `strava_token_expires_at`) VALUES
	(1, 'Liam', 'McCarthy', '2000-01-01', 'Male', 'liammurphy@example.com', '0871122334', '10 Cherry Lane', 'Dublin', 'Dublin', 'liamm', 'liamm', 'Active', 6, '2025-02-25 13:18:24', '2025-02-25 13:18:24', NULL, NULL, NULL, NULL, NULL, NULL),
	(2, 'Emma', 'Byrne', '1987-09-15', 'Female', 'emmabyrne@example.com', '0862233445', '22 Oakwood Ave', 'Cork', 'Cork', 'emmab', 'clientpass2', 'Active', 2, '2025-02-24 20:20:34', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'Daniel', 'O’Brien', '2000-10-01', 'Male', 'danielobrien@example.com', '0853344556', '33 Meadow Lane', 'Galway', 'Galway', 'danielo', 'danialo', 'Inactive', 1, '2025-02-27 14:06:20', '2025-02-27 14:06:20', NULL, NULL, NULL, NULL, NULL, NULL),
	(4, 'Sophie', 'Walsh', '2000-03-21', 'Female', 'sophiewalsh@example.com', '0894455667', '44 Elmwood Dr', 'Limerick', 'Limerick', 'sophiew', 'clientpass4', 'Active', 4, '2025-02-24 20:20:34', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'Jack', 'Kelly', '1982-07-14', 'Male', 'jackkelly@example.com', '0875566778', '55 Pine View', 'Waterford', 'Waterford', 'jackk', 'clientpass5', 'Active', 5, '2025-02-24 20:20:34', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'Laura', 'McCarthy', '1998-12-05', 'Female', 'lauramccarthy@example.com', '0836677889', '66 Willow Park', 'Kilkenny', 'Kilkenny', 'lauram', 'clientpass6', 'Inactive', 6, '2025-02-24 20:20:34', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 'Michael', 'Doyle', '1975-05-30', 'Male', 'michaeldoyle@example.com', '0867788990', '77 Cedar Ridge', 'Sligo', 'Sligo', 'michaeld', 'clientpass7', 'Active', 7, '2025-02-24 20:20:34', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'Hannah', 'Ryan', '1991-08-17', 'Female', 'hannahryan@example.com', '0858899001', '88 Aspen Court', 'Wexford', 'Wexford', 'hannahry', 'clientpass8', 'Inactive', 8, '2025-02-24 20:20:34', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 'Morgan', 'Bartlett', '1992-04-10', 'Male', 'MorganBartlett@yahoo.com', '0871122334', '10 Cherry Lane', 'Dublin', 'Dublin', 'morganb', 'clientpass1', 'Active', 1, '2025-02-26 12:38:41', '0000-00-00 00:00:00', NULL, 6, NULL, NULL, NULL, NULL),
	(10, 'Josh', 'Welsh', '2001-01-01', 'Male', 'b00146498@mytudublin.ie', '0830689411', '18 spire view way, Johnstown', 'Navan', 'Meath', 'joshw', 'joshw123', 'Active', 2, '2025-02-26 15:46:48', '2025-02-26 15:46:48', NULL, 7, NULL, NULL, NULL, NULL),
	(11, 'Josh', 'Welsh', '2003-01-01', 'Male', 'duudwef@yhaoo.ie', '0830689411', '18 spire view way, Johnstown', 'Navan', 'Meath', 'joshwydbcuicwi', 'josh1123', 'Active', 1, '2025-02-26 15:59:22', '2025-02-26 15:59:22', NULL, NULL, NULL, NULL, NULL, NULL),
	(12, 'hueduiedi', 'huhduhdu', '2003-02-01', 'Male', 'uhwudhuwed@uuheuhu.com', '0830689411', '18 spire view way, Johnstown', 'Navan', 'Meath', 'heidik', 'heidik123', 'Active', 1, '2025-02-26 16:34:22', '2025-02-26 16:34:22', NULL, 14, NULL, NULL, NULL, NULL),
	(13, 'Manny', 'Clo', '1997-08-19', 'Male', 'Mannyl@yahoo.com', '0851235698', '7 Clove hill', 'Widdowtown', 'Tipperary', 'MannyC', 'Mannyc123', 'Active', 7, '2025-02-27 13:43:58', '2025-02-27 13:43:58', NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 'Serena', 'Sophie', '2003-10-10', 'Female', 'Serena@yahoo.ie', '0845236985', '6 Kilala Road', 'Cabra', 'Dublin', 'SerenaS', 'Serena123', 'Active', 4, '2025-02-27 17:06:08', '2025-02-27 17:06:08', NULL, 16, NULL, NULL, NULL, NULL),
	(15, 'Anna', 'Kane', '2004-02-09', 'Male', 'annajaynegk@yahoo.ie', '0865236987', '6 Trim Road', 'Johnstown', 'Meath', 'Annak123', 'Annak123', 'Active', 4, '2025-02-27 19:17:24', '2025-02-27 19:17:24', NULL, 17, NULL, NULL, NULL, NULL),
	(16, 'Amos', 'Fakrogha', '2005-05-05', 'Male', 'Amosf@gmail.com', '0861542698', '41 Glentain Manor', 'Letterkenny', 'Donegal', 'Amosk', 'Amosk123', 'Active', 3, '2025-02-28 12:22:54', '2025-02-28 12:22:54', NULL, 19, NULL, NULL, NULL, NULL),
	(17, 'Nadia', 'Elena', '1976-08-11', 'Female', 'nadia@yahoo.com', '0861549685', '18 spire view way, Johnstown', 'Navan', 'Meath', 'naidae1', 'nadiaelena1111', 'Active', 2, '2025-03-03 21:42:29', '2025-03-03 21:42:29', NULL, 22, NULL, NULL, NULL, NULL),
	(18, 'Siobhan', 'Orielly', '2009-04-04', 'Female', 'Siobhan@yahoo.ie', '0856985745', '7 Kilala Road', 'Cabra', 'Dublin', 'Siobhano', 'siobhan12', 'Active', 7, '2025-03-05 14:08:59', '2025-03-05 14:08:59', NULL, 34, NULL, NULL, NULL, NULL),
	(19, 'Maya', 'Kate', '2016-08-05', 'Female', 'Mayak@yahoo.ie', '08568416856', '6 Candy Kane', 'Lolipop', 'Cork', 'Myak12', 'Mayak123', 'Active', 4, '2025-03-13 19:34:29', '2025-03-13 19:34:29', NULL, NULL, NULL, NULL, NULL, NULL),
	(20, 'Louise', 'Mongan', '2004-07-11', 'Female', 'Louise@yahoo.ie', '0892546985', '7 chestnut', 'star city', 'meath', 'Lmongan12', 'louisem12', 'Active', 4, '2025-03-18 14:29:01', '2025-03-18 14:29:01', NULL, 39, NULL, NULL, NULL, NULL),
	(21, 'Ross', 'Geller', '2006-06-20', 'Male', 'Ross@gmail.com', '0892451552', '5 central perk', 'Harlem', 'New York', 'Rossg', 'rossg12345', 'Active', 5, '2025-03-18 14:41:36', '2025-03-18 14:41:36', NULL, 40, NULL, NULL, NULL, NULL),
	(22, 'Rachel', 'Green', '1995-01-01', 'Female', 'Rachel@hotmal.com', '0845741111', '7 jail', 'Johnstown', 'meath', 'rachelg', 'rachelg123', 'Active', 8, '2025-03-18 14:48:22', '2025-03-18 14:48:22', NULL, 41, NULL, NULL, NULL, NULL),
	(23, 'Sarah', 'Johnson', '2001-04-14', 'Female', 'Sarah@hotmail.com', '0871443211', '80 Street', 'City', 'County', 'Sarahj', 'sarahj123', 'Active', 4, '2025-04-03 19:03:01', '2025-04-03 18:03:01', NULL, 42, '83fcd926505dfae1b121415b7cfa78c5bc9e27e9', '740df11c006c5f2e71a7db1eea2121221146f85c', '2025-04-03 23:16:52', NULL),
	(24, 'Chandler', 'Bing', '2003-09-22', 'Male', 'Chandler@yahoo.ie', '0831542698', '56 Birch', 'Swords', 'Dublin', 'Chandlerb', 'chandlerb123', 'Active', 2, '2025-03-19 22:31:36', '2025-03-19 22:31:36', NULL, 43, NULL, NULL, NULL, NULL),
	(25, 'Lesliy', 'Eghrice', '2003-02-01', 'Male', 'lesliy4@gmail.com', '0861552222', '18 spire view way, Johnstown', 'Navan', 'Meath', 'Lesliy4', 'Lesliy4pass', 'Active', 1, '2025-03-25 22:06:42', '2025-03-25 22:06:42', NULL, 52, NULL, NULL, NULL, NULL),
	(26, 'Bekky', 'Mazilu', '2003-09-01', 'Female', 'rebeccamazilu2003@icloud.com', '0871452200', '7 The Spire', 'Town', 'Dublin', 'Bmaz123', 'rebeccam123', 'Active', 6, '2025-04-11 10:07:14', '2025-04-11 09:07:13', NULL, 53, '88e235a91e3c44b0d2b6f4d70ad061de4391dcb5', '6c5223d91ce30a4a832c208e23fe48fc5e4ff498', NULL, '2025-04-11 15:07:13'),
	(27, 'Cecilia', 'Murphy', '2003-09-22', 'Female', 'CeciliaM123@gmail.com', '0831129587', '17 Millbrook', 'Finglas', 'Dublin', 'Cecilia14', 'Cecilia12345', 'Active', 5, '2025-05-07 14:48:57', '2025-05-07 13:48:57', NULL, 55, '43cbca3c2df2df6b40013748c7ca2000016ab235', '6c5223d91ce30a4a832c208e23fe48fc5e4ff498', NULL, '2025-05-07 19:48:57'),
	(28, 'David', 'Nunez', '1995-05-05', 'Male', 'DavidN14@yahoo.com', '0871449865', '45 Clonmaggaden Lawn', 'Navan', 'Meath', 'DavidN17', 'david123', 'Active', 8, '2025-05-07 21:37:22', '2025-05-07 20:37:22', NULL, 56, '32c10a5160698ed300cfe0f950423f8737360679', '6c5223d91ce30a4a832c208e23fe48fc5e4ff498', NULL, '2025-05-08 02:28:38'),
	(29, 'Gemma', 'Murphy', '1987-11-15', 'Female', 'Gemma@yahoo.ie', '081457788', '30 Birch Lawn', 'Navan', 'Meath', 'Gmurph', 'Gemma123', 'Active', 6, '2025-05-08 23:29:43', '2025-05-08 23:29:43', NULL, 57, NULL, NULL, NULL, NULL),
	(30, 'Amy', 'Walsh', '1990-07-18', 'Female', 'amy.walsh@example.com', '0853344556', '12 Oak View', 'Kilkenny', 'Kilkenny', 'amywalsh', 'password23', 'Active', 6, '2025-05-12 23:54:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(31, 'David', 'Kelly', '1985-03-22', 'Male', 'david.kelly@example.com', '0875566778', '55 Meadow Lane', 'Kilkenny', 'Kilkenny', 'davidkelly', 'password24', 'Active', 6, '2025-05-12 23:54:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(32, 'Niamh', 'Ryan', '1993-11-05', 'Female', 'niamh.ryan@example.com', '0869988776', '101 Cedar Drive', 'Kilkenny', 'Kilkenny', 'niamhryan', 'password25', 'Active', 6, '2025-05-12 23:54:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(33, 'Thomas', 'Doyle', '1978-09-15', 'Male', 'thomas.doyle@example.com', '0832211334', '88 Willow Grove', 'Kilkenny', 'Kilkenny', 'thomasdoyle', 'password26', 'Active', 6, '2025-05-12 23:54:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(34, 'Diana', 'Ross', '2000-02-11', 'Female', 'Dianar@yahoo.ie', '0831521144', '90 Stephans Green', 'City Centre', 'Dublin', 'Dianar123', 'Dianar123', 'Active', 5, '2025-05-12 23:09:40', '2025-05-12 23:09:40', NULL, 58, NULL, NULL, NULL, NULL),
	(35, 'Abel', 'Ikhaguebor', '2003-01-20', 'Male', 'abelikhaguebor@gmail.com', '0871445212', '54 County Glen', 'Crumlin', 'Dublin', 'Abel123', 'Abelpass123', 'Active', 6, '2025-05-14 11:33:42', '2025-05-14 10:33:42', NULL, 59, 'c4f2e80b2f0194e090d78fd0abd34a963845951e', '4fc0ee650104729b64e7e98ecb9d67cf12d7e195', NULL, '2025-05-14 16:33:42');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Dumping structure for table ntencity.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_email_unique` (`email`),
  KEY `clients_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.clients: 0 rows
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table ntencity.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL DEFAULT '0',
  `firstname` text,
  `surname` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.customer: 1 rows
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `firstname`, `surname`) VALUES
	(0, 'rebeca', 'leo');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table ntencity.diary_entries
CREATE TABLE IF NOT EXISTS `diary_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_diary_employee` (`employee_id`),
  KEY `fk_diary_client` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.diary_entries: 14 rows
/*!40000 ALTER TABLE `diary_entries` DISABLE KEYS */;
INSERT INTO `diary_entries` (`id`, `employee_id`, `client_id`, `entry_date`, `content`, `created_at`, `updated_at`) VALUES
	(13, 19, 5, '2025-02-28', 'Jack is good', '2025-02-28 12:58:52', '2025-02-28 12:58:52'),
	(4, 5, 1, '2025-02-19', 'Liam is better', '2025-02-19 15:41:55', '2025-02-19 15:41:55'),
	(3, 1, 1, '2025-02-19', 'Liam is getting very slow', '2025-02-19 15:13:49', '2025-02-20 22:44:59'),
	(12, 19, 16, '2025-02-28', 'Amos has a fever.', '2025-02-28 12:24:08', '2025-02-28 12:24:08'),
	(11, 17, 15, '2025-02-27', 'Anna is getting bad again.', '2025-02-27 19:20:31', '2025-02-27 19:20:31'),
	(10, 1, 2, '2025-02-24', 'Emma is feeling a lot better', '2025-02-24 20:40:50', '2025-02-24 20:40:50'),
	(14, 21, 15, '2025-03-01', 'Anna isbetter', '2025-03-01 13:05:31', '2025-03-01 13:05:31'),
	(15, 22, 17, '2025-03-03', 'Nadia is getting better rapidly.', '2025-03-03 21:43:38', '2025-03-03 21:43:38'),
	(16, 23, 16, '2025-03-04', 'Amos right leg is weak.', '2025-03-04 09:22:36', '2025-03-04 09:22:36'),
	(17, 26, 17, '2025-03-04', 'Nadi is sick', '2025-03-04 09:52:51', '2025-03-04 09:52:51'),
	(18, 36, 18, '2025-03-05', 'Siobhans back is tender.', '2025-03-05 14:59:50', '2025-03-05 14:59:50'),
	(19, 1, 16, '2025-03-10', 'Amos needs a lot of fluids', '2025-03-10 10:34:48', '2025-03-10 10:34:48'),
	(20, 49, 26, '2025-04-07', 'Bekky\'s progress has increased', '2025-04-07 21:30:44', '2025-04-07 21:30:44'),
	(21, 49, 35, '2025-05-13', 'Abel completed a full-body strength and mobility session focused on lower limb stability and core engagement. He responded well to the new circuit format and showed improved endurance during static holds.\r\n\r\nProgress Since Last Session:\r\n\r\nImproved plank hold time from 45s to 60s\r\n\r\nIncreased resistance on leg press by 10kg\r\n\r\nMore confident transitioning between movements', '2025-05-13 17:54:59', '2025-05-13 17:54:59');
/*!40000 ALTER TABLE `diary_entries` ENABLE KEYS */;

-- Dumping structure for table ntencity.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_first_name` varchar(50) NOT NULL,
  `emp_surname` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `emergency_contact` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `county` varchar(50) NOT NULL,
  `pps_number` varchar(15) NOT NULL,
  `role` varchar(50) NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `practice_id` int(11) NOT NULL,
  `userid` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pps_number` (`pps_number`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `FK_member_user_unique` (`userid`),
  KEY `practice_id` (`practice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.employee: 27 rows
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`id`, `emp_first_name`, `emp_surname`, `date_of_birth`, `gender`, `contact_number`, `emergency_contact`, `email`, `street`, `city`, `county`, `pps_number`, `role`, `iban`, `bic`, `username`, `password`, `practice_id`, `userid`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'John', 'Doe', '1985-06-15', 'Male', '0871234567', 'Jane Doe', 'johndoe@example.com', '12 Elm St', 'Dublin', 'Dublin', '123456A', 'Physiotherapist', 'IE29AIBK93115212345678', 'AIBKIE2D', 'johndoe', 'password123', 1, NULL, NULL, NULL, NULL),
	(2, 'Sarah', 'Connor', '1990-09-25', 'Female', '0877654321', 'Michael Connor', 'sarahconnor@example.com', '34 Oak St', 'Cork', 'Cork', '987654B', 'Personal Trainer', 'IE56BOFI90001712345678', 'BOFIIE2D', 'sconnor', 'securePass1', 2, NULL, NULL, NULL, NULL),
	(3, 'James', 'Smith', '1978-03-12', 'Male', '0869876543', 'Emma Smith', 'jamessmith@example.com', '56 Willow Rd', 'Galway', 'Galway', '789123C', 'Rehab Specialist', 'IE12ULSB98541212345678', 'ULSBIE2D', 'jsmith', 'pass789!', 3, NULL, NULL, NULL, NULL),
	(4, 'Emily', 'Blake', '1982-07-22', 'Female', '0852345678', 'Robert Blake', 'emilyblake@example.com', '78 Pine St', 'Limerick', 'Limerick', '456321D', 'Receptionist', 'IE98PSTN23452112345678', 'PSTNIE2D', 'eblake', 'mypassword', 4, NULL, NULL, NULL, NULL),
	(5, 'Tom', 'Wilson', '1995-11-05', 'Male', '0893456789', 'Anna Wilson', 'tomwilson@example.com', '90 Birch Ave', 'Waterford', 'Waterford', '852741E', 'Manager', 'IE76PERM98564712345678', 'PERMIE2D', 'twilson', 'wilsonpass', 5, NULL, NULL, NULL, NULL),
	(6, 'Olivia', 'Hart', '1989-02-14', 'Female', '0835678901', 'Daniel Hart', 'oliviahart@example.com', '11 Cedar St', 'Kilkenny', 'Kilkenny', '951357F', 'Staff', 'IE44HBCI78965412345678', 'HBCIIE2D', 'ohart', 'password2024', 6, NULL, NULL, NULL, NULL),
	(7, 'Mark', 'Evans', '1976-08-30', 'Male', '0861239874', 'Laura Evans', 'markevans@example.com', '23 Spruce Ln', 'Sligo', 'Sligo', '753159G', 'Physiotherapist', 'IE32NWES96325812345678', 'NWESIE2D', 'mevans', 'strongpass', 7, NULL, NULL, NULL, NULL),
	(8, 'Sophie', 'Reed', '1993-06-19', 'Female', '0876543210', 'James Reed', 'sophiereed@example.com', '45 Sycamore Blvd', 'Wexford', 'Wexford', '159753H', 'Personal Trainer', 'IE21ALLY45678912345678', 'ALLYIE2D', 'sreed', 'reedsecure', 8, NULL, NULL, NULL, NULL),
	(9, 'Michael', 'Walsh', '1982-06-23', 'Male', '0879876543', 'Anna Walsh', 'michael.walsh@healthylife.com', '123 Main St', 'Dublin', 'Dublin', '7654321B', 'Physiotherapist', 'IE29AIBK93115212345679', 'AIBKIE2D', 'michaelwalsh', 'password2', 1, NULL, NULL, NULL, NULL),
	(10, 'Emily', 'Ryan', '1978-10-05', 'Female', '0866543210', 'Liam Ryan', 'emily.ryan@healthylife.com', '123 Main St', 'Dublin', 'Dublin', '9876543C', 'Senior Physiotherapist', 'IE29AIBK93115212345680', 'AIBKIE2D', 'emilyryan', 'password3', 1, NULL, NULL, NULL, NULL),
	(11, 'Emma', 'Byrne', '1989-11-22', 'Female', '0834567890', 'Jack Byrne', 'emma.byrne@wellness.com', '456 High St', 'Cork', 'Cork', '8765432E', 'Personal Trainer', 'IE56BOFI90001712345679', 'BOFIIE2D', 'emmabyrne', 'password5', 2, NULL, NULL, NULL, NULL),
	(12, 'John', 'Kavanagh', '1985-03-15', 'Male', '0823456789', 'Laura Kavanagh', 'john.kavanagh@wellness.com', '456 High St', 'Cork', 'Cork', '2345678F', 'Senior Trainer', 'IE56BOFI90001712345680', 'BOFIIE2D', 'johnkavanagh', 'password6', 2, NULL, NULL, NULL, NULL),
	(13, 'Laura', 'Daly', '1991-05-14', 'Female', '0891122334', 'James Daly', 'laura.daly@brightrecovery.com', '789 Park Ave', 'Galway', 'Galway', '3456789G', 'Receptionist', 'IE12ULSB98541212345678', 'ULSBIE2D', 'lauradaly', 'password7', 3, NULL, NULL, NULL, NULL),
	(14, 'Robert', 'Lynch', '1984-09-30', 'Male', '0869871234', 'Sophie Lynch', 'robert.lynch@brightrecovery.com', '789 Park Ave', 'Galway', 'Galway', '4567890H', 'Physiotherapist', 'IE12ULSB98541212345679', 'ULSBIE2D', 'robertlynch', 'password8', 3, NULL, NULL, NULL, NULL),
	(15, 'Anna', 'Kelly', '1979-12-18', 'Female', '0858764321', 'Tom Kelly', 'anna.kelly@brightrecovery.com', '789 Park Ave', 'Galway', 'Galway', '5678901I', 'Senior Physiotherapist', 'IE12ULSB98541212345680', 'ULSBIE2D', 'annakelly', 'password9', 3, NULL, NULL, NULL, NULL),
	(16, 'Sean', 'OBrien', '1993-08-25', 'Male', '0872345678', 'Claire OBrien', 'sean.obrien@totalhealth.com', '321 River Rd', 'Limerick', 'Limerick', '6789012J', 'Receptionist', 'IE98PSTN23452112345678', 'PSTNIE2D', 'seanobrien', 'password10', 4, NULL, NULL, NULL, NULL),
	(17, 'Sophia', 'Moore', '1987-01-20', 'Female', '0863456789', 'Mark Moore', 'sophia.moore@totalhealth.com', '321 River Rd', 'Limerick', 'Limerick', '7890123K', 'Personal Trainer', 'IE98PSTN23452112345679', 'PSTNIE2D', 'sophiamoore', 'password11', 4, NULL, NULL, NULL, NULL),
	(18, 'Ryan', 'Doyle', '1982-04-07', 'Male', '0854567890', 'Linda Doyle', 'ryan.doyle@totalhealth.com', '321 River Rd', 'Limerick', 'Limerick', '8901234L', 'Senior Trainer', 'IE98PSTN23452112345680', 'PSTNIE2D', 'ryandoyle', 'password12', 4, NULL, NULL, NULL, NULL),
	(19, 'Glen', 'Mccarthy', '1985-05-07', 'Male', '0830660000', '0861114444', 'Glen@gmail.com', '18 spire view way, Johnstown', 'Navan', 'Meath', '256981G', 'Staff', 'IE 845128512', '874512G', 'GlenG', 'Glenmc123', 6, 49, '2025-03-23 22:13:29', '2025-03-23 22:13:29', NULL),
	(20, 'Chloe', 'Kennedy', '1977-11-29', 'Female', '0895566777', 'Liam Kennedy', 'chloe.kennedy@primemotion.com', '654 Vision St', 'Waterford', 'Waterford', '8765432O', 'Senior Physiotherapist', 'IE76PERM98564712345680', 'PERMIE2D', 'chloekennedy', 'password15', 5, NULL, NULL, NULL, NULL),
	(21, 'Patrick', 'Reilly', '1992-02-14', 'Male', '0873344556', 'Clare Reilly', 'patrick.reilly@fitstrong.com', '987 Maple Rd', 'Kilkenny', 'Kilkenny', '9876543P', 'Receptionist', 'IE44HBCI78965412345678', 'HBCIIE2D', 'patrickreilly', 'password16', 6, NULL, NULL, NULL, NULL),
	(22, 'Hannah', 'Dunne', '1986-08-05', 'Female', '0891122335', 'Tom Dunne', 'hannah.dunne@fitstrong.com', '987 Maple Rd', 'Kilkenny', 'Kilkenny', '6543214Q', 'Personal Trainer', 'IE44HBCI78965412345679', 'HBCIIE2D', 'hannahdunne', 'password17', 6, NULL, NULL, NULL, NULL),
	(23, 'Shane', 'Farrell', '1981-12-23', 'Male', '0867788990', 'Sarah Farrell', 'shane.farrell@fitstrong.com', '987 Maple Rd', 'Kilkenny', 'Kilkenny', '8765435R', 'Senior Trainer', 'IE44HBCI78965412345680', 'HBCIIE2D', 'shanefarrell', 'password18', 6, NULL, NULL, NULL, NULL),
	(24, 'Laura', 'O’Brien', '1990-06-17', 'Female', '0856655443', 'Emma O’Brien', 'laura.obrien@fitstrong.com', '45 Birch Lane', 'Kilkenny', 'Kilkenny', '4455667S', 'Junior Physiotherapist', 'IE29AIBK93115212345678', 'AIBKIE2D', 'lauraobrien', 'password19', 6, NULL, NULL, NULL, NULL),
	(25, 'Ciaran', 'Murphy', '1984-04-22', 'Male', '0832244668', 'Niall Murphy', 'ciaran.murphy@fitstrong.com', '22 Forest Park', 'Kilkenny', 'Kilkenny', '3344558T', 'Massage Therapist', 'IE88BOFI90568512345671', 'BOFIIE2D', 'ciaranmurphy', 'password20', 6, NULL, NULL, NULL, NULL),
	(26, 'Rachel', 'Flynn', '1995-09-10', 'Female', '0869988776', 'James Flynn', 'rachel.flynn@fitstrong.com', '11 Pine Grove', 'Kilkenny', 'Kilkenny', '5566779U', 'Sports Therapist', 'IE11ULSB98564712345678', 'ULSBIE2D', 'rachelflynn', 'password21', 6, NULL, NULL, NULL, NULL),
	(27, 'Eoin', 'Byrne', '1988-03-03', 'Male', '0894433221', 'Aoife Byrne', 'eoin.byrne@fitstrong.com', '78 Rosewood Ave', 'Kilkenny', 'Kilkenny', '6677880V', 'Exercise Specialist', 'IE60IRCE93115212345679', 'IRCEIE2D', 'eoinbyrne', 'password22', 6, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;

-- Dumping structure for table ntencity.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.failed_jobs: 0 rows
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table ntencity.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.migrations: 18 rows
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_02_05_223600_add_deleted_at_to_client_table', 1),
	(15, '2025_02_05_225613_add_deleted_at_to_employee_table', 2),
	(16, '2025_02_12_232054_add_deleted_at_to_practice_table', 2),
	(17, '2025_02_18_205858_add_user_id_to_clients_table', 3),
	(18, '2025_02_18_210113_create_clients_table', 4),
	(19, '2025_03_04_091243_add_role_to_users_table', 4),
	(20, '2025_02_18_205800_create_clients_table', 5),
	(22, '2025_03_13_125403_add_deleted_at_to_notifications_table', 6),
	(23, '2025_03_13_130412_create_notifications_table', 7),
	(24, '2025_03_22_231849_add_profile_picture_to_employees_table', 7),
	(25, '2025_04_03_162605_add_strava_tokens_to_users_table', 8),
	(26, '2025_04_03_164825_add_strava_tokens_to_client_table_cleaned', 9),
	(27, '2025_04_03_165459_create_activities_table', 10),
	(28, '2025_04_07_163236_add_strava_tokens_to_clients_table', 11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table ntencity.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.notifications: 29 rows
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('155fb6cf-7143-4aa1-a382-2f2a17e22644', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":15,"booking_date":"2025-05-13T00:00:00.000000Z","formatted_date":"Tuesday, May 13, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-7D40D5B5AF, Amount: \\u20ac105","message":"Your appointment on Tuesday, May 13 at 9:30 AM has been confirmed!"}', NULL, '2025-05-08 22:57:28', '2025-05-08 22:57:28'),
	('1f07158f-1bec-4177-9888-42a511c84155', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":15,"booking_date":"2025-05-13T00:00:00.000000Z","formatted_date":"Tuesday, May 13, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-7D40D5B5AF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-A5BAD3BC79, Amount: \\u20ac105","message":"Your appointment on Tuesday, May 13 at 9:30 AM has been confirmed!"}', NULL, '2025-05-08 22:57:44', '2025-05-08 22:57:44'),
	('60688deb-31fa-4080-bb60-4ec37abb8d90', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":15,"booking_date":"2025-05-13T00:00:00.000000Z","formatted_date":"Tuesday, May 13, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-7D40D5B5AF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-A5BAD3BC79, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-7ED75B59A3, Amount: \\u20ac105","message":"Your appointment on Tuesday, May 13 at 9:30 AM has been confirmed!"}', NULL, '2025-05-08 22:57:48', '2025-05-08 22:57:48'),
	('6e7f497e-1681-44a3-9027-756425b12b8d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:23:24', '2025-05-12 21:23:24'),
	('04ea92ba-74aa-468e-9369-356a2542b1c0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:23:39', '2025-05-12 21:23:39'),
	('278134c9-32fd-4b41-9107-89de8036c89e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:23:44', '2025-05-12 21:23:44'),
	('2784ab0a-8cb1-4a7f-8137-4f7fe873ff71', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:23:48', '2025-05-12 21:23:48'),
	('9d02d220-fbf3-49e2-87cc-360f76b846bb', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:23:52', '2025-05-12 21:23:52'),
	('98b103e2-493a-4360-8fba-e7ace7566183', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:23:56', '2025-05-12 21:23:56'),
	('875c5eb8-6dd2-4991-956b-233fdb0faeb4', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:02', '2025-05-12 21:24:02'),
	('25e551fa-3c46-49cc-bfd1-e4060137c786', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:07', '2025-05-12 21:24:07'),
	('5acb0a2c-087c-4841-a1be-e0569feb0263', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:12', '2025-05-12 21:24:12'),
	('725ea83e-4fc1-40b5-9e1c-6c485ccb5dc6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:16', '2025-05-12 21:24:16'),
	('b8b21e71-6825-439a-8903-a377568ab6db', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:21', '2025-05-12 21:24:21'),
	('51a4cdd3-4a8d-407e-92b0-6f017a315dd8', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:26', '2025-05-12 21:24:26'),
	('49ec0b13-7bea-40a8-bfb3-91dd04402eaf', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:30', '2025-05-12 21:24:30'),
	('f9023ba4-4a1c-4d38-a377-88a64157e447', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:35', '2025-05-12 21:24:35'),
	('08282b5e-bda6-477a-8f7c-bbb4928caf18', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:40', '2025-05-12 21:24:40'),
	('8d5512f4-2a3a-48c9-a7f6-85d975484ed0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:44', '2025-05-12 21:24:44'),
	('8f48b58a-ae5d-4691-bf72-f1d75378604a', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-357A01D2BB, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:49', '2025-05-12 21:24:49'),
	('d23449d6-c01a-4fc9-91f9-a14957aae073', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-357A01D2BB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-68D6E81E25, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:54', '2025-05-12 21:24:54'),
	('5422f0aa-ac91-43d4-b6fd-2cadabbf6443', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-357A01D2BB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-68D6E81E25, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-7FCE59A7B1, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:24:59', '2025-05-12 21:24:59'),
	('75de1937-c3e2-4006-914a-8deb68cfb267', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-357A01D2BB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-68D6E81E25, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-7FCE59A7B1, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B3D71E42ED, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:25:03', '2025-05-12 21:25:03'),
	('bb65b545-3c67-432c-b805-8c650e1306e0', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":16,"booking_date":"2025-05-21T00:00:00.000000Z","formatted_date":"Wednesday, May 21, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-A822DB4C5F, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-42496E1F9B, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-23E9F06EC5, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-2FD235F1E0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-91040D6AB6, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-651E15A2E3, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-1A5AC1CC08, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-CB62BF26AB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-DDEC60D2D0, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B96B8B29CC, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-BBF840FDBF, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B0F3A31907, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-583B76DF21, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-677893B6ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-5E8BD54C3E, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-74DD28CC10, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-357A01D2BB, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-68D6E81E25, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-7FCE59A7B1, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-B3D71E42ED, Amount: \\u20ac105\\n\\nPayment processed: Transaction ID: TRANS-E67EFA9D66, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 21 at 9:30 AM has been confirmed!"}', NULL, '2025-05-12 21:25:08', '2025-05-12 21:25:08'),
	('701337d9-cda4-4b32-b601-70c5abf8e671', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":17,"booking_date":"2025-05-15T00:00:00.000000Z","formatted_date":"Thursday, May 15, 2025","start_time":"10:00:00","end_time":"10:45:00","formatted_time":"10:00 AM - 10:45 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-54C6D6449F, Amount: \\u20ac105","message":"Your appointment on Thursday, May 15 at 10:00 AM has been confirmed!"}', NULL, '2025-05-12 21:25:42', '2025-05-12 21:25:42'),
	('9684b7bd-3e09-4ff3-a9a9-c2127b80866d', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":18,"booking_date":"2025-05-13T00:00:00.000000Z","formatted_date":"Tuesday, May 13, 2025","start_time":"09:30:00","end_time":"10:15:00","formatted_time":"9:30 AM - 10:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-AAC4F6EE42, Amount: \\u20ac105","message":"Your appointment on Tuesday, May 13 at 9:30 AM has been confirmed!"}', NULL, '2025-05-13 01:16:03', '2025-05-13 01:16:03'),
	('2b2664e8-8b54-497d-b48c-adf79f1fce1e', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 1, '{"type":"confirmation","appointment_id":19,"booking_date":"2025-05-14T00:00:00.000000Z","formatted_date":"Wednesday, May 14, 2025","start_time":"13:30:00","end_time":"14:15:00","formatted_time":"1:30 PM - 2:15 PM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-117E2086FD, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 14 at 1:30 PM has been confirmed!"}', NULL, '2025-05-13 01:17:43', '2025-05-13 01:17:43'),
	('324ced3f-0e02-4728-90ff-defa4bb7ca59', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 23, '{"type":"confirmation","appointment_id":20,"booking_date":"2025-05-15T00:00:00.000000Z","formatted_date":"Thursday, May 15, 2025","start_time":"10:30:00","end_time":"11:15:00","formatted_time":"10:30 AM - 11:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-139E83A538, Amount: \\u20ac105","message":"Your appointment on Thursday, May 15 at 10:30 AM has been confirmed!"}', NULL, '2025-05-13 11:36:36', '2025-05-13 11:36:36'),
	('5c619a75-52ef-4707-963a-8cee9e5177b6', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 35, '{"type":"confirmation","appointment_id":21,"booking_date":"2025-05-13T00:00:00.000000Z","formatted_date":"Tuesday, May 13, 2025","start_time":"13:30:00","end_time":"14:15:00","formatted_time":"1:30 PM - 2:15 PM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-6DD1199DC7, Amount: \\u20ac105","message":"Your appointment on Tuesday, May 13 at 1:30 PM has been confirmed!"}', NULL, '2025-05-13 22:24:47', '2025-05-13 22:24:47'),
	('0085e890-5278-4b24-8f10-4ad9a4b9e8d5', 'App\\Notifications\\AppointmentNotification', 'App\\Models\\client', 35, '{"type":"confirmation","appointment_id":22,"booking_date":"2025-05-14T00:00:00.000000Z","formatted_date":"Wednesday, May 14, 2025","start_time":"10:30:00","end_time":"11:15:00","formatted_time":"10:30 AM - 11:15 AM","status":"confirmed","notes":"\\n\\nPayment processed: Transaction ID: TRANS-918F495426, Amount: \\u20ac105","message":"Your appointment on Wednesday, May 14 at 10:30 AM has been confirmed!"}', NULL, '2025-05-14 12:00:12', '2025-05-14 12:00:12');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table ntencity.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.password_resets: 1 rows
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('annajaynegk@yahoo.ie', '$2y$10$Xk34KdZr80gHiCiy41Rxh..EyoQ1STKEnDwecmcm2pNyTif4KMi.q', '2025-04-07 17:51:06');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table ntencity.personalisedtrainingplan
CREATE TABLE IF NOT EXISTS `personalisedtrainingplan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.personalisedtrainingplan: 42 rows
/*!40000 ALTER TABLE `personalisedtrainingplan` DISABLE KEYS */;
INSERT INTO `personalisedtrainingplan` (`id`, `client_id`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, '2025-06-01', '2025-06-11', '2025-03-07 13:15:50', '2025-03-12 15:06:56', NULL),
	(2, 2, '2025-03-10', '2025-07-10', '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL),
	(3, 3, '2025-04-01', '2025-07-01', '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL),
	(4, 4, '2025-05-01', '2025-08-01', '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL),
	(5, 5, '2025-06-01', '2025-09-01', '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL),
	(6, 6, '2025-03-10', '2025-03-15', '2025-03-10 19:44:47', '2025-03-10 19:44:47', NULL),
	(7, 2, '2025-01-10', '2025-01-20', '2025-03-10 20:03:01', '2025-03-10 20:03:01', NULL),
	(8, 2, '2025-01-10', '2025-01-20', '2025-03-10 20:05:50', '2025-03-10 20:05:50', NULL),
	(9, 2, '2025-10-10', '2025-10-15', '2025-03-10 20:06:08', '2025-03-10 20:06:08', NULL),
	(10, 2, '2025-10-10', '2025-10-15', '2025-03-10 20:08:54', '2025-03-10 20:08:54', NULL),
	(11, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:09:34', '2025-03-12 15:19:30', '2025-03-12 15:19:30'),
	(12, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:10:12', '2025-03-12 15:19:26', '2025-03-12 15:19:26'),
	(13, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:10:17', '2025-03-10 20:10:17', NULL),
	(14, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:10:32', '2025-03-10 20:10:32', NULL),
	(15, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:10:38', '2025-03-10 20:10:38', NULL),
	(16, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:11:14', '2025-03-12 15:19:14', '2025-03-12 15:19:14'),
	(17, 6, '0025-10-10', '2025-10-15', '2025-03-10 20:13:45', '2025-03-10 20:13:45', NULL),
	(18, 6, '2025-05-10', '2025-05-15', '2025-03-10 20:14:06', '2025-03-12 15:19:20', '2025-03-12 15:19:20'),
	(19, 5, '2025-05-10', '2025-02-14', '2025-03-10 21:05:51', '2025-03-10 21:05:51', NULL),
	(20, 14, '2025-02-06', '2025-02-20', '2025-03-10 21:14:34', '2025-03-10 21:14:34', NULL),
	(21, 16, '2025-02-05', '2025-05-20', '2025-03-11 10:55:00', '2025-03-11 10:55:00', NULL),
	(22, 15, '2025-01-01', '2025-01-20', '2025-03-11 11:33:40', '2025-03-11 11:33:40', NULL),
	(23, NULL, NULL, NULL, '2025-03-11 11:44:05', '2025-03-11 11:44:13', '2025-03-11 11:44:13'),
	(24, 17, '2025-09-22', '2025-09-30', '2025-03-12 11:04:43', '2025-03-12 11:04:43', NULL),
	(25, 14, '2025-03-15', '2025-03-20', '2025-03-12 12:02:48', '2025-03-12 12:02:48', NULL),
	(26, 10, '2025-03-16', '2025-03-26', '2025-03-12 12:10:54', '2025-03-13 19:56:54', '2025-03-13 19:56:54'),
	(27, 13, '2025-04-02', '2025-04-22', '2025-03-13 19:30:06', '2025-03-13 19:30:06', NULL),
	(28, 19, '2025-03-13', '2025-03-20', '2025-03-13 19:34:49', '2025-03-13 19:34:49', NULL),
	(29, 5, '2025-03-18', '2025-04-08', '2025-03-13 19:54:50', '2025-03-13 19:55:16', '2025-03-13 19:55:16'),
	(30, 14, '2025-03-15', '2025-03-22', '2025-03-13 20:33:31', '2025-03-13 20:34:34', '2025-03-13 20:34:34'),
	(31, 14, '2025-03-15', '2025-03-22', '2025-03-13 20:35:28', '2025-03-13 20:35:28', NULL),
	(32, 15, '2025-03-19', '2025-03-25', '2025-03-13 20:44:57', '2025-03-13 20:44:57', NULL),
	(33, 13, '2025-03-12', '2025-03-22', '2025-03-14 11:07:43', '2025-03-14 11:07:43', NULL),
	(34, 16, '2025-03-15', '2025-03-24', '2025-03-14 11:38:17', '2025-03-14 11:38:17', NULL),
	(35, 13, '2025-03-12', '2025-03-09', '2025-03-14 15:10:49', '2025-03-14 15:10:49', NULL),
	(36, 23, '2025-03-23', '2025-03-29', '2025-03-18 22:27:48', '2025-03-18 22:27:48', NULL),
	(37, 26, '2025-04-15', '2025-04-22', '2025-04-09 13:18:10', '2025-04-09 13:18:10', NULL),
	(38, 17, '2025-05-12', '2025-05-19', '2025-05-07 21:10:53', '2025-05-07 21:10:53', NULL),
	(39, 15, '2025-05-12', '2025-05-12', '2025-05-08 23:39:49', '2025-05-08 23:39:49', NULL),
	(40, 25, '2025-05-14', '2025-05-21', '2025-05-12 23:57:13', '2025-05-12 23:57:13', NULL),
	(41, 16, '2025-05-14', '2025-05-21', '2025-05-13 22:18:02', '2025-05-13 22:18:02', NULL),
	(42, 35, '2025-05-17', '2025-05-24', '2025-05-13 22:28:15', '2025-05-13 22:28:15', NULL),
	(43, 35, '2025-05-15', '2025-05-22', '2025-05-14 12:02:37', '2025-05-14 12:02:37', NULL);
/*!40000 ALTER TABLE `personalisedtrainingplan` ENABLE KEYS */;

-- Dumping structure for table ntencity.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.personal_access_tokens: 0 rows
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table ntencity.practice
CREATE TABLE IF NOT EXISTS `practice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_type` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `county` varchar(50) NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.practice: 8 rows
/*!40000 ALTER TABLE `practice` DISABLE KEYS */;
INSERT INTO `practice` (`id`, `company_name`, `company_type`, `street`, `city`, `county`, `iban`, `bic`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Healthy Life Physiotherapy', 'Physiotherapy', '123 Main St', 'Dublin', 'Dublin', 'IE29AIBK93115212345678', 'AIBKIE2D', NULL, NULL, NULL),
	(2, 'Wellness Training Center', 'Personal Training', '456 High St', 'Cork', 'Cork', 'IE56BOFI90001712345678', 'BOFIIE2D', NULL, NULL, NULL),
	(3, 'Bright Recovery Clinic', 'Physiotherapy', '789 Park Ave', 'Galway', 'Galway', 'IE12ULSB98541212345678', 'ULSBIE2D', NULL, NULL, NULL),
	(4, 'Total Health Fitness', 'Personal Training', '321 River Rd', 'Limerick', 'Limerick', 'IE98PSTN23452112345678', 'PSTNIE2D', NULL, NULL, NULL),
	(5, 'Prime Motion Therapy', 'Physiotherapy', '654 Vision St', 'Waterford', 'Waterford', 'IE76PERM98564712345678', 'PERMIE2D', NULL, NULL, NULL),
	(6, 'Fit & Strong Center', 'Personal Training', '987 Maple Rd', 'Kilkenny', 'Kilkenny', 'IE44HBCI78965412345678', 'HBCIIE2D', NULL, NULL, NULL),
	(7, 'Rehab & Recovery Hub', 'Physiotherapy', '159 Healing Ave', 'Sligo', 'Sligo', 'IE32NWES96325812345678', 'NWESIE2D', NULL, NULL, NULL),
	(8, 'Peak Performance Gym', 'Personal Training', '753 Mental St', 'Wexford', 'Wexford', 'IE21ALLY45678912345678', 'ALLYIE2D', NULL, NULL, NULL);
/*!40000 ALTER TABLE `practice` ENABLE KEYS */;

-- Dumping structure for table ntencity.standardexercises
CREATE TABLE IF NOT EXISTS `standardexercises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exercise_name` varchar(255) NOT NULL,
  `exercise_video_link` varchar(255) DEFAULT NULL,
  `target_body_area` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exercise_name` (`exercise_name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.standardexercises: 21 rows
/*!40000 ALTER TABLE `standardexercises` DISABLE KEYS */;
INSERT INTO `standardexercises` (`id`, `exercise_name`, `exercise_video_link`, `target_body_area`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Deadlift', 'https://www.youtube.com/embed/op9kVnSso6Q?si=5ltjmKcHRwln-Xfq', 'lower back, hamstrings', '2025-03-07 13:15:50', '2025-03-12 14:13:19', NULL),
	(2, 'Bench press', 'https://www.youtube.com/embed/SCVCLChPQFY?si=-q-Zcm77Oh0xdAKq', 'chest, triceps', '2025-03-07 13:15:50', '2025-03-13 21:10:02', NULL),
	(3, 'Treadmill', 'https://www.youtube.com/embed/rjPqkRZ_vdo?si=4WHF5rMvCHkX_FUf', 'cardio, legs', '2025-03-07 13:15:50', '2025-03-13 21:10:11', NULL),
	(4, 'Cycling', 'https://www.youtube.com/embed/r1Nw0vNWh1Q?si=uwppVifiPW2z18R8', 'cardio, quads', '2025-03-07 13:15:50', '2025-03-13 21:10:34', NULL),
	(5, 'Squat', 'https://www.youtube.com/embed/xqvCmoLULNY?si=GmbauOTEzp-rRZOR', 'quads, glutes', '2025-03-07 13:15:50', '2025-03-13 21:10:46', NULL),
	(6, 'Pull-up', 'https://www.youtube.com/embed/_9bXjKFDT64?si=hjN4-K7qve-Z0pWG', 'back, biceps', '2025-03-07 13:15:50', '2025-03-13 21:10:57', NULL),
	(7, 'Push-up', 'https://www.youtube.com/embed/WDIpL0pjun0?si=udBe5tpO9tph6P_O', 'chest, triceps', '2025-03-07 13:15:50', '2025-03-13 21:11:06', NULL),
	(8, 'Lunges', 'https://www.youtube.com/embed/BbExjzx75Hs?si=jgIxg3HV770dt2P7', 'quads, hamstrings', '2025-03-07 13:15:50', '2025-03-13 21:11:16', NULL),
	(9, 'Plank', 'https://www.youtube.com/embed/pvIjsG5Svck?si=BdE4YaR6qn7oMLka', 'core', '2025-03-07 13:15:50', '2025-03-13 21:11:26', NULL),
	(10, 'Bicep curl', 'https://www.youtube.com/embed/ykJmrZ5v0Oo?si=9PpnzPrbIwf487SK', 'biceps', '2025-03-07 13:15:50', '2025-03-13 21:13:44', NULL),
	(11, 'Tricep dip', 'https://www.youtube.com/embed/JhX1nBnirNw?si=RIkF8br--ubpUAOz', 'triceps', '2025-03-07 13:15:50', '2025-03-13 21:15:11', NULL),
	(12, 'Leg press', 'https://www.youtube.com/embed/fM2WvgirlLM?si=zlp0kvrGZ0_J6O3b', 'quads, hamstrings', '2025-03-07 13:15:50', '2025-03-13 21:15:37', NULL),
	(13, 'Lat pulldown', 'https://www.youtube.com/embed/AOpi-p0cJkc?si=s5hvsBTXmoIdAwU3', 'back', '2025-03-07 13:15:50', '2025-03-13 21:15:49', NULL),
	(14, 'Shoulder press', 'https://www.youtube.com/embed/B-aVuyhvLHU?si=zuS4OcmEISTDVb3g', 'shoulders', '2025-03-07 13:15:50', '2025-03-13 21:15:25', NULL),
	(15, 'Calf raise', 'https://www.youtube.com/embed/UV8gOrHmuKc?si=yiZ0jL1TfYYPhuny', 'calves', '2025-03-07 13:15:50', '2025-03-13 21:15:01', NULL),
	(16, 'Rowing machine', 'https://www.youtube.com/embed/UCXxvVItLoM?si=FKmvl5dLkL4MDi9q', 'back, cardio', '2025-03-07 13:15:50', '2025-03-13 21:14:45', NULL),
	(17, 'Step-up', 'https://www.youtube.com/embed/wfhXnLILqdk?si=fmL-F9nUL-6Ijzpt', 'glutes, quads', '2025-03-07 13:15:50', '2025-03-13 21:14:35', NULL),
	(18, 'Hammer curl', 'https://www.youtube.com/embed/OPqe0kCxmR8?si=31V8DvIFIDRdVLm0', 'biceps', '2025-03-07 13:15:50', '2025-03-13 21:14:25', NULL),
	(19, 'Incline bench press', 'https://www.youtube.com/embed/5k_enq6vXGM?si=15ML8hnEYcJRzhDR', 'chest, shoulders', '2025-03-07 13:15:50', '2025-03-13 21:13:55', NULL),
	(20, 'Leg curl', 'https://www.youtube.com/embed/Orxowest56U?si=z4GdA6ap27Nc0dsp', 'hamstrings', '2025-03-07 13:15:50', '2025-03-13 21:14:05', NULL),
	(21, 'Ab roller', 'https://www.youtube.com/embed/gdhzhdnHpUs?si=V0ZKOJEnSVgrni6m', 'core', '2025-03-07 13:15:50', '2025-03-13 21:14:15', NULL);
/*!40000 ALTER TABLE `standardexercises` ENABLE KEYS */;

-- Dumping structure for table ntencity.tpelog
CREATE TABLE IF NOT EXISTS `tpelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `exercise_id` int(11) DEFAULT NULL,
  `num_sets` int(11) DEFAULT NULL,
  `num_reps` int(11) DEFAULT NULL,
  `minutes` int(11) DEFAULT NULL,
  `recovery_interval` int(11) DEFAULT NULL,
  `intensity` varchar(50) DEFAULT NULL,
  `incline` decimal(4,2) DEFAULT NULL,
  `times_per_week` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `plan_id` (`plan_id`),
  KEY `exercise_id` (`exercise_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

-- Dumping data for table ntencity.tpelog: 52 rows
/*!40000 ALTER TABLE `tpelog` DISABLE KEYS */;
INSERT INTO `tpelog` (`id`, `plan_id`, `exercise_id`, `num_sets`, `num_reps`, `minutes`, `recovery_interval`, `intensity`, `incline`, `times_per_week`, `created_at`, `updated_at`, `deleted_at`, `completed`) VALUES
	(1, 1, 1, 4, 8, NULL, NULL, 'high', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(2, 1, 2, 3, 10, NULL, NULL, 'medium', NULL, 4, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(3, 1, 5, 4, 10, NULL, NULL, 'high', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(4, 1, 10, 3, 12, NULL, NULL, 'medium', NULL, 4, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(5, 2, 3, NULL, NULL, 30, NULL, 'low', 2.00, 5, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(6, 2, 4, NULL, NULL, 45, NULL, 'medium', NULL, 4, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(7, 2, 9, 3, NULL, 5, NULL, 'medium', NULL, 5, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(8, 2, 20, 4, 12, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(9, 3, 6, 3, 8, NULL, NULL, 'high', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(10, 3, 7, 3, 15, NULL, NULL, 'medium', NULL, 4, '2025-03-07 13:15:50', '2025-03-13 14:01:01', '2025-03-13 14:01:01', 0),
	(11, 3, 14, 4, 10, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(12, 3, 18, 3, 10, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(13, 4, 5, 3, 12, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-13 14:01:06', '2025-03-13 14:01:06', 0),
	(14, 4, 8, 3, 12, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(15, 4, 11, 4, 10, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(16, 4, 15, 4, 12, NULL, NULL, 'medium', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(17, 5, 1, 4, 8, NULL, NULL, 'high', NULL, 3, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(18, 5, 3, NULL, NULL, 40, NULL, 'medium', 1.50, 5, '2025-03-07 13:15:50', '2025-03-13 14:01:11', '2025-03-13 14:01:11', 0),
	(19, 5, 13, 3, 10, NULL, NULL, 'medium', NULL, 4, '2025-03-07 13:15:50', '2025-03-07 13:15:50', NULL, 0),
	(20, 5, 21, 3, NULL, 5, NULL, 'medium', NULL, 5, '2025-03-07 13:15:50', '2025-03-13 14:01:15', '2025-03-13 14:01:15', 0),
	(21, 6, 2, 3, 3, 3, NULL, '3', 3.00, 3, '2025-03-10 19:10:49', '2025-03-10 19:10:49', NULL, 0),
	(22, 2, 5, 7, 7, 7, NULL, 'Intense', 7.00, 7, '2025-03-10 21:48:19', '2025-03-10 21:48:19', NULL, 0),
	(23, 4, 6, 3, NULL, NULL, NULL, 'Intense', NULL, 3, '2025-03-10 21:49:09', '2025-03-10 21:49:09', NULL, 0),
	(24, 3, 5, 6, 6, 6, NULL, 'Vigorous', 6.00, 6, '2025-03-10 22:08:29', '2025-03-10 22:08:29', NULL, 0),
	(25, 10, 3, 1, 10, 10, NULL, NULL, 5.00, NULL, '2025-03-10 22:27:02', '2025-03-10 22:27:02', NULL, 0),
	(26, 1, 4, 1, 10, NULL, NULL, NULL, -1.00, NULL, '2025-03-10 22:27:46', '2025-03-10 22:27:46', NULL, 0),
	(27, 3, 13, 1, 10, 3, NULL, NULL, 7.00, NULL, '2025-03-11 10:55:33', '2025-03-11 10:55:33', NULL, 0),
	(28, 5, 3, 5, 5, 20, NULL, NULL, 4.00, NULL, '2025-03-13 12:51:57', '2025-03-13 14:01:20', '2025-03-13 14:01:20', 0),
	(29, 2, 3, 3, 8, 30, NULL, NULL, 6.00, NULL, '2025-03-13 13:50:06', '2025-03-13 13:50:06', NULL, 0),
	(30, 2, 3, 3, 8, 30, NULL, NULL, 3.00, NULL, '2025-03-13 13:51:01', '2025-03-13 19:49:45', '2025-03-13 19:49:45', 0),
	(31, 5, 3, 0, 0, 80, NULL, NULL, 7.00, NULL, '2025-03-13 13:57:53', '2025-03-13 14:00:57', '2025-03-13 14:00:57', 0),
	(32, 5, 7, 0, 0, 30, NULL, NULL, 0.00, NULL, '2025-03-13 13:58:26', '2025-03-13 14:00:53', '2025-03-13 14:00:53', 0),
	(33, 6, 5, 0, 0, 30, NULL, NULL, 0.00, NULL, '2025-03-13 14:02:16', '2025-03-13 19:49:38', '2025-03-13 19:49:38', 0),
	(34, 6, 5, 0, 0, 30, NULL, NULL, 0.00, 2, '2025-03-13 14:07:04', '2025-03-13 14:07:04', NULL, 0),
	(35, 1, 3, 4, 4, 61, NULL, NULL, 20.00, 7, '2025-03-13 14:09:25', '2025-03-13 14:09:25', NULL, 0),
	(36, 5, 7, 8, 0, 30, NULL, NULL, 0.00, 4, '2025-03-13 19:05:43', '2025-03-13 19:05:43', NULL, 0),
	(37, 27, 1, 5, 6, 46, NULL, NULL, -15.00, 3, '2025-03-13 19:30:40', '2025-03-13 19:30:40', NULL, 0),
	(38, 24, 5, 0, 0, 30, NULL, NULL, 0.00, 3, '2025-03-13 19:31:55', '2025-03-13 19:49:31', '2025-03-13 19:49:31', 0),
	(39, 28, 3, 0, 0, 30, NULL, NULL, -3.00, 3, '2025-03-13 19:38:06', '2025-03-13 19:49:25', '2025-03-13 19:49:25', 0),
	(40, 3, 19, 0, 0, 30, NULL, 'Maximum Effort', 0.00, 7, '2025-03-13 19:44:26', '2025-03-13 19:44:26', NULL, 0),
	(41, 30, 3, 4, 6, 50, NULL, 'Light', 4.00, 4, '2025-03-13 20:33:59', '2025-03-13 20:34:47', '2025-03-13 20:34:47', 0),
	(42, 31, 5, 0, 0, 47, NULL, 'Light', 0.00, 4, '2025-03-13 20:36:02', '2025-03-13 20:36:02', NULL, 0),
	(43, 32, 5, 5, 0, 12, NULL, 'Very Light', 0.00, 3, '2025-03-13 20:45:26', '2025-03-13 20:45:26', NULL, 0),
	(44, 33, 5, 6, 0, 55, NULL, 'Moderate', 0.00, 4, '2025-03-14 11:08:00', '2025-03-14 11:08:00', NULL, 0),
	(45, 34, 6, 3, 4, 10, NULL, 'Vigorous', 0.00, 5, '2025-03-14 11:41:00', '2025-03-14 11:41:00', NULL, 0),
	(46, 36, 6, 4, 4, 30, NULL, 'Very Light', 0.00, 4, '2025-03-18 22:28:09', '2025-04-07 13:53:35', NULL, 1),
	(47, 37, 18, 5, 2, 30, NULL, 'Light', 0.00, 4, '2025-04-09 13:18:40', '2025-04-11 09:57:05', NULL, 1),
	(48, 38, 4, 0, 0, 49, NULL, 'Light', 10.00, 3, '2025-05-07 21:11:20', '2025-05-07 21:11:20', NULL, 0),
	(49, 22, 11, 6, 9, 4, NULL, 'Moderate', 0.00, 3, '2025-05-09 00:03:08', '2025-05-09 00:03:08', NULL, 0),
	(50, 36, 4, 6, 7, 30, 135, 'Moderate', 8.00, 3, '2025-05-09 00:20:00', '2025-05-09 00:20:00', NULL, 0),
	(51, 34, 1, 4, 6, 30, 80, 'Light', 0.00, 3, '2025-05-13 22:18:58', '2025-05-13 22:18:58', NULL, 0),
	(52, 42, 1, 7, 10, 34, 210, 'Moderate', 0.00, 4, '2025-05-13 22:28:56', '2025-05-13 22:28:56', NULL, 0),
	(53, 42, 2, 7, 6, 44, 90, 'Moderate', 0.00, 4, '2025-05-14 12:03:11', '2025-05-14 12:03:11', NULL, 0);
/*!40000 ALTER TABLE `tpelog` ENABLE KEYS */;

-- Dumping structure for table ntencity.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'client',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table ntencity.users: 59 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
	(1, 'Rebecca', 'Rebeccamazilu@yahoo.com', NULL, '$2y$10$6UOTaC1.wHbNJLJezOwB1e/q/ZilW5aPz4zQGJacAQZf5bL9cvyQC', 'WSLEnwlNuI0QeDk7D3h9kFbFHvZr9LjZdkRCvxqTMIjzyAus02UEyrjsiRYk', '2025-02-10 20:52:19', '2025-02-10 20:52:19', 'client'),
	(2, 'Rebecca', 'b00146498@mytudublin.ie', NULL, '$2y$10$vQ9aO/M.CrBo3EjhJdIcMuKWC.RyIDS/rMWpQD5aAXE4qRHXUJmJu', NULL, '2025-02-13 17:32:48', '2025-02-13 17:32:48', 'client'),
	(3, 'Josh', 'JoshPayne@yahoo.ie', NULL, '$2y$10$RTVAmAt8TKvEOqI.ojeuReOaL6WGRQGVqZQ.vYHOBKn.9ypKWzakO', NULL, '2025-02-13 18:09:56', '2025-02-13 18:09:56', 'client'),
	(4, 'Nadia', 'Nadiamazilu@example.com', NULL, '$2y$10$zLmOFZ2LZTvq7RR2i5b7LOPEJ6850B2VGgjZN9yiwtJzmqEjK7rxK', NULL, '2025-02-13 18:29:59', '2025-02-13 18:29:59', 'client'),
	(5, 'Kayla', 'Kayla@yahoo.com', NULL, '$2y$10$ZLbPPHlZt..LBiPgx4KA.ug.QUhAS7ifQ26wZZZn50An4zwJzmoiu', NULL, '2025-02-19 15:23:59', '2025-02-19 15:23:59', 'client'),
	(6, 'Morgan Bartlett', 'MorganBartlett@yahoo.com', NULL, '$2y$10$It79w6KqvbxQz1uSfg/aQuOReXFhM7ZKwAsvdNMzzAzLEKMqh9c.q', NULL, '2025-02-26 11:51:04', '2025-02-26 11:51:04', 'client'),
	(7, 'Josh Whelan', 'joshwhelan@yhaoo.com', NULL, '$2y$10$4U3iJFqv9K5hRziUz/3o8eMZXovfEpsuM6WSDJtHKJm/OayTgOBVO', NULL, '2025-02-26 13:06:09', '2025-02-26 13:06:09', 'client'),
	(8, 'Eoin Kelly', 'Eoinkelly@yahoo.ie', NULL, '$2y$10$TUrHkQHl5lr8jhl.KESkGe0B5/qO0uqAX58oaB0PRVLHzx/jkiAKG', NULL, '2025-02-26 16:02:10', '2025-02-26 16:02:10', 'client'),
	(9, 'Linda Kell', 'Linda@yahoo.ie', NULL, '$2y$10$kj9YJ.K8YnYfxhGIKtB3U.gNCwNgpwfU19UZbTYwlS72ztGTZem1K', NULL, '2025-02-26 16:11:33', '2025-02-26 16:11:33', 'client'),
	(10, 'Linda kell', 'kells@yahoo.ie', NULL, '$2y$10$a.fw5Hqz4OmwsRH0qMQR.eaGvo76vovZL5EG99HbytztM8.9n6ijC', NULL, '2025-02-26 16:13:31', '2025-02-26 16:13:31', 'client'),
	(11, 'chcgywg', 'bshdbwhe@dcubcd.com', NULL, '$2y$10$FYVG9F58P5v6on14aj5DbeDizOeopafGtLVWaLX9PKdziLPr72Mi.', NULL, '2025-02-26 16:19:00', '2025-02-26 16:19:00', 'client'),
	(12, 'gdwgd', 'udwcuiw@uwi.com', NULL, '$2y$10$SD8g5XQlsuyb8eYrHS7Ha.I2CEEFejZGqrUH8/J6jFgna6mnL4Vka', NULL, '2025-02-26 16:20:27', '2025-02-26 16:20:27', 'client'),
	(13, 'jdsjh', 'jdchsduh@yahoo.ie', NULL, '$2y$10$ki2kS5L2ol2T/TX0cCimT.y68OSjYBtPUbQgKXSZGJzMxDon9rPEW', NULL, '2025-02-26 16:29:19', '2025-02-26 16:29:19', 'client'),
	(14, 'jdhiwdqjo', 'didhewi@yahoo.ie', NULL, '$2y$10$tMi4bNwUqqEd.RKfN09hCe/HnPWV5FeQNknSF5PHr1fnzRFlyGd5C', NULL, '2025-02-26 16:30:39', '2025-02-26 16:30:39', 'client'),
	(15, 'uhudehued', 'hsuh@yahoo.ie', NULL, '$2y$10$wspiMa.6JQRPOdlPE6kJAuDGOeEmZtUDjjKg/YE3tdEL6TBYtQPOa', NULL, '2025-02-26 16:49:58', '2025-02-26 16:49:58', 'client'),
	(16, 'Serena', 'Serena@yahoo.ie', NULL, '$2y$10$69AtNHa84JUPY62f4qkVx.lx/rmjxm0B6y0GDKA8xoHdXCSesRuxi', NULL, '2025-02-27 17:04:37', '2025-02-27 17:04:37', 'client'),
	(17, 'Anna Jayne Goonan Kane', 'annajaynegk@yahoo.ie', NULL, '$2y$10$ZioUZak1NpsGxmUJ9OsLaeRWJjGip.DqOSCPJNWWE7pt7wDPVJ4bW', NULL, '2025-02-27 19:16:25', '2025-02-27 19:16:25', 'client'),
	(18, 'Adam Kelly', 'Adamk@gmail.com', NULL, '$2y$10$t4arO43xd3fGW8BN6IgTOOI0lb39LLiHdolFaBA6cFqsftlA/DnWG', NULL, '2025-02-27 19:31:15', '2025-02-27 19:31:15', 'client'),
	(19, 'Amos Fakrogha', 'Amos@yahoo.ie', NULL, '$2y$10$he8gll0IUDcJmnaLWNFAAuLWuxFozQTqCcQgbj35DpvxW9al6juCu', NULL, '2025-02-28 12:21:40', '2025-02-28 12:21:40', 'client'),
	(20, 'Eoin KElly', 'Eoinkelly@gmail.com', NULL, '$2y$10$zZQU4NUTNmHHuBaH0t23Su9kzRrg33zrkUIfvOtAj5c3/ELI5xKpW', NULL, '2025-02-28 13:01:23', '2025-02-28 13:01:23', 'client'),
	(21, 'Kean Lynch', 'KeanL@gmail.com', NULL, '$2y$10$n2fUozNFl.7UNEfyaZ7w8.d/RpiarGfKPdO/tvLz3ENLZHoYj2LxW', NULL, '2025-03-01 12:17:12', '2025-03-01 12:17:12', 'client'),
	(22, 'nadia mazilu', 'nadia@yahoo.com', NULL, '$2y$10$jPg7xUwbCO7CNIsg/MoiquFR8Ht5RCMIWatl7jOVm/jd4NK7q9ZbC', NULL, '2025-03-03 21:41:22', '2025-03-03 21:41:22', 'client'),
	(23, 'Neymar Volvic', 'Volvic@yahoo.ie', NULL, '$2y$10$NvsOMQWEUTsegTuujRToY.mSP1vCk4sHWbNBDW1cLUJf1/YkYm3Vm', NULL, '2025-03-04 09:20:49', '2025-03-04 09:20:49', 'client'),
	(24, 'Josh Blue', 'Blue@yahoo.ie', NULL, '$2y$10$7BJMqIKnquWEFDIMUe9SduSfHLZkwebD2YgYekNeCJVBJCLsUsDoa', NULL, '2025-03-04 09:37:34', '2025-03-04 09:37:34', 'client'),
	(25, 'Siobhon Oneil', 'Oneil@yahoo.ie', NULL, '$2y$10$I0pwp7zNFApMHF5eEG/8Zu3XIfUYl0.0t20iZoHAIF8PW00.CmXE6', NULL, '2025-03-04 09:43:58', '2025-03-04 09:43:58', 'client'),
	(26, 'Daragh Liam', 'Daragh@yahoo.ie', NULL, '$2y$10$JcEUIJx..aUYP2RvKDiyoOuALb0ktyNNSYfEFYnlLtnqsAh4ClUo.', NULL, '2025-03-04 09:47:24', '2025-03-04 09:47:24', 'client'),
	(27, 'Seven Eleven', 'Seven@gmail.com', NULL, '$2y$10$6BmPTFOlH3EMojbEWFN3aeqUBSjzDJTMZvfGmspa9ycXgtCVo7LHy', NULL, '2025-03-04 10:09:52', '2025-03-04 10:09:52', 'client'),
	(28, 'Bradley Cooper', 'Cooper@gmail.com', NULL, '$2y$10$p709xWrffhBqJksxTSKoPuZZStdw4k4C0yBXLQv/N.PGl28uayiXq', NULL, '2025-03-04 10:22:56', '2025-03-04 10:22:56', 'client'),
	(29, 'Jessica Taylor', 'Jess@hotmail.com', NULL, '$2y$10$fNdzzicAVNzEJ0gbC7mpuOz59qhzFUT8.M9X4R1.LG557Sfpm10UO', NULL, '2025-03-04 10:36:31', '2025-03-04 10:36:31', 'client'),
	(30, 'adam Mccarthy', 'asjdkjbbas@gmail.com', NULL, '$2y$10$WY0h4CZVAoUrhh9njJfwhe/6Kxm9Hstjw2erlcd8GGmYKYjo4EFWK', NULL, '2025-03-04 21:51:35', '2025-03-04 21:51:35', 'client'),
	(31, 'adam Mccarthy', 'adammccarthy@yahoo.ie', NULL, '$2y$10$T6oR1ftjbG0S0rA1J8KNhODwLjP/DefV6K8IR8CO1xwAQ1hxpuR1.', NULL, '2025-03-04 21:57:58', '2025-03-04 21:57:58', 'client'),
	(32, 'Stephan Lynch', 'Stephan@yahoo.ie', NULL, '$2y$10$vs8QBcYYNMYhdj5//jFF7uZ0UdG6h5smsGJukCo7CJoeTrZIiBjY6', NULL, '2025-03-05 13:40:35', '2025-03-05 13:40:35', 'client'),
	(33, 'Brian Malley', 'Malley@gmail.com', NULL, '$2y$10$PD1ALuRtAoKkHLS.9u.QW.oTl71qeGu.iCV7NAJSKBbfkQT13cSZO', NULL, '2025-03-05 13:54:50', '2025-03-05 13:54:50', 'client'),
	(34, 'Siobhan Orielly', 'Siobh@gmail.com', NULL, '$2y$10$KK0rrQdjXVaGp3uCjECTN.1Hw42LlPoyyHFpma/NrfF7dg.ek7qn2', NULL, '2025-03-05 14:08:03', '2025-03-05 14:08:03', 'client'),
	(35, 'Liam Neeson', 'Liam@yahoo.ie', NULL, '$2y$10$YalOO.rR93lUt6q5szSVoOJLDCGOEtnYcokysRdzlgFOFY5qxrd6O', NULL, '2025-03-05 14:19:53', '2025-03-05 14:19:53', 'client'),
	(36, 'duieie euhd', 'uehue@yahoo.ie', NULL, '$2y$10$TszcEQf5BKKPAGDU0JzRquO1dSjiOoo7u/hp1yN0GXQ6CZEQ39J66', NULL, '2025-03-05 14:23:41', '2025-03-05 14:23:41', 'client'),
	(37, 'Paula Kane', 'Paula@yahoo.ie', NULL, '$2y$10$b8Bx2hfHChtSafupSaL46uJPdEvzet6ycLC9LIypdBPHblBkzIwY2', NULL, '2025-03-07 12:48:04', '2025-03-07 12:48:04', 'client'),
	(38, 'Eoin OK', 'OK@gmail.com', NULL, '$2y$10$HH2GoVdEWtCE5JiLRGXqEelvHD4GWp7R3s8bdb0tzKTDHYHLyAWmm', NULL, '2025-03-14 11:56:37', '2025-03-14 11:56:37', 'employee'),
	(39, 'Louise Mongan', 'Louisem@gmail.com', NULL, '$2y$10$P4bIoE/uagBjkv0oGwtPs.ZF2M6HrW85V5I94IZ7u8pv2MYK6EIjS', NULL, '2025-03-18 13:01:34', '2025-03-18 13:01:34', 'client'),
	(40, 'Ross Geller', 'Ross@gmail.com', NULL, '$2y$10$RM2G5p2d2bnMXRGKYdj60Os6OZ1JeBq4coCixXxGMHoMYCAAxljoO', NULL, '2025-03-18 14:40:42', '2025-03-18 14:40:42', 'client'),
	(41, 'Rachel Green', 'Rachel@hotmal.com', NULL, '$2y$10$oUifXRwtFOPUMmAza50squ4GUHUK.ftWFkEjE5BID.aPu98BZLSTi', NULL, '2025-03-18 14:47:24', '2025-03-18 14:47:24', 'client'),
	(42, 'Sarah Johnson', 'Sarah@hotmail.com', NULL, '$2y$10$9XqIpV35ehpaDprMs2WJs.xyIK9NWr4yFyEmWlhNPzqIzatp0cSIm', NULL, '2025-03-18 16:22:56', '2025-03-18 16:22:56', 'client'),
	(43, 'Chandler Bing', 'Chandler@yahoo.ie', NULL, '$2y$10$XfYKerqxeoG.iiO3LfnHEOx2GuN6nFCiPCNu.LWfIH/eTG76ch/Xq', NULL, '2025-03-19 22:30:16', '2025-03-19 22:30:16', 'client'),
	(44, 'Joanna Forde', 'Joanna@yahoo.ie', NULL, '$2y$10$ZgozslgCnWxENdMLJM43M.5zaD4uHMNQDBN8lpdait/OQVSLC1Yju', NULL, '2025-03-20 13:08:34', '2025-03-20 13:08:34', 'employee'),
	(45, 'Emp new', 'Emp@gmail.com', NULL, '$2y$10$17h3SZi6dOSpC4hqgkghSObp9mkUmTuas6HO8aFFpP.skXCK5CUo2', NULL, '2025-03-20 15:07:14', '2025-03-20 15:07:14', 'employee'),
	(46, 'Monica Geller', 'Monica@yahoo.ie', NULL, '$2y$10$jv59uzYJiEehzSl35bHOA.wXA6YOnELF1jArNfdKKGP6pF/sdTXgG', NULL, '2025-03-20 15:20:15', '2025-03-20 15:20:15', 'employee'),
	(47, 'Rebecca Sophy Mazilu', 'Rebeccasophie@gmail.com', NULL, '$2y$10$2y62sqgI.U37odG3cpHqoOb.lIZEEcklWJb9zjh5geE.19igvwGbm', NULL, '2025-03-23 20:17:01', '2025-03-23 20:17:01', 'employee'),
	(48, 'Valerie Mccarthy', 'Valmc@hotmail.com', NULL, '$2y$10$dMu7B09UpQBxc2yNe21XTuVNqHXzKHva8xmmkTDErN0aXsmco603u', NULL, '2025-03-23 20:24:19', '2025-03-23 20:24:19', 'employee'),
	(49, 'Glen Mccarthy', 'Glen@gmail.com', NULL, '$2y$10$NpRNC7MofXZATatP5Uwe3eB4hQlwJ9KO2zGAIdPUHN5X8gc1Dy1Xq', NULL, '2025-03-23 22:12:29', '2025-03-23 22:12:29', 'employee'),
	(50, 'Lesliy Eghaghe', 'LesliyE@hotmail.com', NULL, '$2y$10$jVlHBr8tLg07xqHt70MYHuf0BUuugCbBvB6ZEzFGXWVB5wJvHtYaa', NULL, '2025-03-25 19:47:09', '2025-03-25 19:47:09', 'client'),
	(51, 'Lesliy Eghaghe2', 'Lesliy2@hotmail.com', NULL, '$2y$10$Qel7sEfhtwfNz7N/9GyuUe6eItbhPT9G7LpGYiloi.c.Fblzi1sY.', NULL, '2025-03-25 19:52:07', '2025-03-25 19:52:07', 'client'),
	(52, 'Lesliy4', 'lesliy4@gmail.com', NULL, '$2y$10$D4UEyU/bfG/TEdlviMp.GOFsmFIvQUD08rnjEVZjRUS9hE4Qwas9e', NULL, '2025-03-25 19:57:01', '2025-03-25 19:57:01', 'client'),
	(53, 'Bekky Mazilu', 'rebeccamazilu2003@icloud.com', NULL, '$2y$10$WJ3QHJwkQNkV/Ti8zdNMp.DvOcuPCJn9k4gsoLkt2VBGkrB27B4ku', NULL, '2025-04-07 18:42:07', '2025-04-07 18:42:07', 'client'),
	(54, 'Gregory House', 'Greg@yahoo.ie', NULL, '$2y$10$WvlVSflRcX89U4HJ7qEfyOd.69GhkFexmHyFEq4sVrzGoLSG9q3zq', NULL, '2025-05-07 12:23:33', '2025-05-07 12:23:33', 'client'),
	(55, 'Cecilia Murphy', 'CeciliaM123@gmail.com', NULL, '$2y$10$1zCgrEm29fjejXpSNkLtWu7hG6aIVhMHjE/6Mtia.xngQSGfBXRb6', NULL, '2025-05-07 13:47:06', '2025-05-07 13:47:06', 'client'),
	(56, 'David Nunez', 'DavidN14@yahoo.com', NULL, '$2y$10$dPm9gMa0sMhYBYBNCsoM1..P5gQsMH/4MDO8yCPA2tJ3uQ4qPZR3i', NULL, '2025-05-07 20:34:12', '2025-05-07 20:34:12', 'client'),
	(57, 'Gemma Louise', 'Gemma@yahoo.ie', NULL, '$2y$10$YYopfqxqguPTp4ajPiCSOOudCgmWXl.HQWnSLduBlQ9YcpHvjEhvi', NULL, '2025-05-08 23:19:31', '2025-05-08 23:19:31', 'client'),
	(58, 'Diana Ross', 'Dianar@yahoo.ie', NULL, '$2y$10$xKaLXTS1yPRY.1irgV8K8uSEYDYnbNwlf2VURa5G9xGpWyy3e3NPK', NULL, '2025-05-12 23:04:27', '2025-05-12 23:04:27', 'client'),
	(59, 'Abel Ikhaguebor', 'abelikhaguebor@gmail.com', NULL, '$2y$10$tTwf.Ic4HEJrPtGz68QY/OXW.HMS3NUT.uadpP9ZblImrPMqbYORe', NULL, '2025-05-13 17:46:16', '2025-05-13 17:46:16', 'client');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for view ntencity.appointmentevent
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `appointmentevent`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointmentevent` AS select appointments.id, concat(client.first_name, " ", client.surname) as title,
Concat(DATE_FORMAT(Booking_Date,'%Y-%m-%d'), "T", Start_Time) as start,
Concat(DATE_FORMAT(Booking_Date,'%Y-%m-%d'), "T", End_Time) as end
from appointments inner join client on 
appointments.client_id = client.id ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
