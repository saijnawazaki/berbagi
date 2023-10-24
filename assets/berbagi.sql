-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.31 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table berbagi.book
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `book_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.book: 0 rows
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`book_id`, `user_id`, `book_title`, `created_at`) VALUES
    (4, 1, 'testasdsad', 1654762673),
    (3, 1, 'test44', 1654762646),
    (2, 1, 'test2', 1654762576),
    (1, 1, 'test2', 1654762381),
    (5, 1, 'tessssDXG', 1654762842);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;

-- Dumping structure for table berbagi.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int NOT NULL,
  `book_id` int NOT NULL DEFAULT '0',
  `restaurant_id` int NOT NULL DEFAULT '0',
  `invoice_date` int NOT NULL DEFAULT '0',
  `tax_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `delivery_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `adjustment_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `other_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `platform_id` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.invoice: 0 rows
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` (`invoice_id`, `book_id`, `restaurant_id`, `invoice_date`, `tax_amount`, `discount_amount`, `delivery_amount`, `adjustment_amount`, `other_amount`, `platform_id`, `created_by`, `created_at`) VALUES
    (1, 5, 1, 1655830800, 10.00, 20.00, 30.00, 50.00, 40.00, 2, 1, 1656043026);
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;

-- Dumping structure for table berbagi.invoice_details
CREATE TABLE IF NOT EXISTS `invoice_details` (
  `id_id` int NOT NULL,
  `invoice_id` int NOT NULL DEFAULT '0',
  `rm_id` int NOT NULL DEFAULT '0',
  `qty` int NOT NULL DEFAULT '0',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.invoice_details: 0 rows
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
INSERT INTO `invoice_details` (`id_id`, `invoice_id`, `rm_id`, `qty`, `price`) VALUES
    (2, 1, 4, 2, 18000.00),
    (1, 1, 4, 1, 22000.55);
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;

-- Dumping structure for table berbagi.payment
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int NOT NULL,
  `book_id` int NOT NULL DEFAULT '0',
  `payment_date` int NOT NULL DEFAULT '0',
  `payment_type_id` int NOT NULL DEFAULT '0',
  `person_id` int NOT NULL DEFAULT '0',
  `amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `status_id` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.payment: 0 rows
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` (`payment_id`, `book_id`, `payment_date`, `payment_type_id`, `person_id`, `amount`, `remarks`, `status_id`, `created_by`, `created_at`) VALUES
    (1, 5, 1661533200, 1, 1, 12.00, '12', 1, 1, 1661594475);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;

-- Dumping structure for table berbagi.person
CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int NOT NULL,
  `person_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `initial_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  `status_id` int NOT NULL DEFAULT '0',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.person: 0 rows
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` (`person_id`, `person_name`, `initial_name`, `created_by`, `created_at`, `status_id`, `remarks`) VALUES
    (2, 'Ayano Tateyama', 'AY', 1, 1655351523, 1, ''),
    (1, 'Julianto', 'JU', 1, 1655351327, 1, '');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;

-- Dumping structure for table berbagi.personal_report_share
CREATE TABLE IF NOT EXISTS `personal_report_share` (
  `token_code` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `maneger_person_id` int NOT NULL DEFAULT '0',
  `person_id` int NOT NULL DEFAULT '0',
  `token_exp_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`token_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.personal_report_share: 0 rows
/*!40000 ALTER TABLE `personal_report_share` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_report_share` ENABLE KEYS */;

-- Dumping structure for table berbagi.platform
CREATE TABLE IF NOT EXISTS `platform` (
  `platform_id` int NOT NULL,
  `platform_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`platform_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.platform: 0 rows
/*!40000 ALTER TABLE `platform` DISABLE KEYS */;
INSERT INTO `platform` (`platform_id`, `platform_name`) VALUES
    (4, 'Shopee'),
    (3, 'Gojek'),
    (2, 'Grab'),
    (1, 'Offline');
/*!40000 ALTER TABLE `platform` ENABLE KEYS */;

-- Dumping structure for table berbagi.restaurant
CREATE TABLE IF NOT EXISTS `restaurant` (
  `restaurant_id` int NOT NULL,
  `restaurant_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  `modified_by` int NOT NULL DEFAULT '0',
  `modified_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`restaurant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.restaurant: 0 rows
/*!40000 ALTER TABLE `restaurant` DISABLE KEYS */;
INSERT INTO `restaurant` (`restaurant_id`, `restaurant_name`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
    (2, 'Res45', 1, 1654849758, 1, 1654852228),
    (1, 'Res1DXX', 1, 1654849692, 1, 1654852304);
/*!40000 ALTER TABLE `restaurant` ENABLE KEYS */;

-- Dumping structure for table berbagi.restaurant_menu
CREATE TABLE IF NOT EXISTS `restaurant_menu` (
  `rm_id` int NOT NULL,
  `restaurant_id` int NOT NULL DEFAULT '0',
  `rm_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  `modified_by` int NOT NULL DEFAULT '0',
  `modified_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`rm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.restaurant_menu: 0 rows
/*!40000 ALTER TABLE `restaurant_menu` DISABLE KEYS */;
INSERT INTO `restaurant_menu` (`rm_id`, `restaurant_id`, `rm_name`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
    (3, 1, 'Nasi Ayam Bakar 1', 1, 1655351471, 1, 1655351475),
    (2, 2, 'Soto Mie', 1, 1655351444, 1, 1655351448),
    (1, 2, 'Nasi Goreng Spesial 2', 1, 1655349532, 1, 1655350244),
    (4, 1, 'Nasi Goreng Bakar', 1, 1655351489, 1, 1655351493);
/*!40000 ALTER TABLE `restaurant_menu` ENABLE KEYS */;

-- Dumping structure for table berbagi.restaurant_menu_tag
CREATE TABLE IF NOT EXISTS `restaurant_menu_tag` (
  `rm_id` int NOT NULL,
  `tag_id` int NOT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`rm_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.restaurant_menu_tag: 0 rows
/*!40000 ALTER TABLE `restaurant_menu_tag` DISABLE KEYS */;
INSERT INTO `restaurant_menu_tag` (`rm_id`, `tag_id`, `created_by`, `created_at`) VALUES
    (4, 6, 1, 1655351493),
    (4, 2, 1, 1655351493),
    (3, 5, 1, 1655351475),
    (3, 2, 1, 1655351475),
    (2, 4, 1, 1655351448),
    (2, 3, 1, 1655351448),
    (1, 1, 1, 1655350244),
    (1, 2, 1, 1655350244);
/*!40000 ALTER TABLE `restaurant_menu_tag` ENABLE KEYS */;

-- Dumping structure for table berbagi.split_bill
CREATE TABLE IF NOT EXISTS `split_bill` (
  `sb_id` int NOT NULL,
  `invoice_id` int NOT NULL DEFAULT '0',
  `sb_date` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`sb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.split_bill: 0 rows
/*!40000 ALTER TABLE `split_bill` DISABLE KEYS */;
INSERT INTO `split_bill` (`sb_id`, `invoice_id`, `sb_date`, `created_by`, `created_at`) VALUES
    (1, 1, 1660064400, 1, 1661247831);
/*!40000 ALTER TABLE `split_bill` ENABLE KEYS */;

-- Dumping structure for table berbagi.split_bill_details
CREATE TABLE IF NOT EXISTS `split_bill_details` (
  `sbd_id` int NOT NULL,
  `sb_id` int NOT NULL DEFAULT '0',
  `person_id` int NOT NULL DEFAULT '0',
  `item_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `delivery_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `other_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `adjustment_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`sbd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.split_bill_details: 0 rows
/*!40000 ALTER TABLE `split_bill_details` DISABLE KEYS */;
INSERT INTO `split_bill_details` (`sbd_id`, `sb_id`, `person_id`, `item_amount`, `tax_amount`, `discount_amount`, `delivery_amount`, `other_amount`, `adjustment_amount`, `remarks`) VALUES
    (2, 1, 1, 10000.00, 5.00, 10.00, 15.00, 20.00, -20.00, 'Test 2'),
    (1, 1, 2, 18000.00, 5.00, 10.00, 15.00, 20.00, 10.00, 'Test 1');
/*!40000 ALTER TABLE `split_bill_details` ENABLE KEYS */;

-- Dumping structure for table berbagi.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int NOT NULL,
  `tag_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created_by` int NOT NULL DEFAULT '0',
  `created_at` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_name` (`tag_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.tag: 0 rows
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`tag_id`, `tag_name`, `created_by`, `created_at`) VALUES
    (4, 'mie', 1, 1655351444),
    (3, 'soto', 1, 1655351444),
    (2, 'nasi', 1, 1655350156),
    (1, 'nasi goreng', 1, 1655349532),
    (5, 'ayam', 1, 1655351472),
    (6, 'bakar', 1, 1655351489);
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Dumping structure for table berbagi.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `role_id` int NOT NULL DEFAULT '0',
  `status_id` int NOT NULL DEFAULT '0',
  `display_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `person_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table berbagi.user: 0 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `password`, `role_id`, `status_id`, `display_name`, `person_id`) VALUES
    (1, 'admin', '$2y$10$7211IFrUa2xgUybaLnafxeZfutUMtPbLf4tt9jRxFGgVRTIgcsiCe', 2, 1, 'Administrator', 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
