-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 21, 2019 at 05:53 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `chefs`
--

DROP TABLE IF EXISTS `chefs`;
CREATE TABLE IF NOT EXISTS `chefs` (
  `chefID` int(11) NOT NULL AUTO_INCREMENT,
  `chefName` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `serverCode` varchar(6) NOT NULL,
  PRIMARY KEY (`chefID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chefs`
--

INSERT INTO `chefs` (`chefID`, `chefName`, `password`, `serverCode`) VALUES
(1, 'Gordon', 'fries1234', '111222');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `ingredient_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ingredient_name` varchar(255) NOT NULL,
  `ingredient_stock` float UNSIGNED NOT NULL,
  `ingredient_minimum_stock` float UNSIGNED NOT NULL,
  `ingredient_unit_type` varchar(255) NOT NULL,
  PRIMARY KEY (`ingredient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `ingredient_name`, `ingredient_stock`, `ingredient_minimum_stock`, `ingredient_unit_type`) VALUES
(1, 'Pepsi', 45345500000000, 2000, 'mLs'),
(2, 'Coke', 29999500, 2000, 'mLs'),
(3, 'Iced Tea', 29999500, 2000, 'mLs'),
(4, 'Water', 30000000, 2000, 'mLs'),
(5, 'Shredded Cheddar Cheese', 4.5, 2, 'bags'),
(6, 'Corn Chips', 70, 4, 'bags'),
(7, 'French Fries', 519.25, 4, 'lbs'),
(8, 'Gravy', 230, 4, 'mLs'),
(9, 'Cheese Curds', 74, 6, 'cups'),
(10, 'Hamburger Buns', 30, 12, 'buns'),
(11, 'Hamburgers', 34, 10, 'hamburgers'),
(12, 'Cheese Slices', 38, 10, 'slices'),
(13, 'Mushrooms', 39.75, 10, 'cups'),
(14, 'Bacon', 557, 10, 'pieces');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `item_name`, `category_id`) VALUES
(1, 'Pepsi', 1),
(2, 'Nachos', 2),
(3, 'Regular Hamburger', 3),
(4, 'Cheeseburger', 3),
(5, 'Mushroom Burger', 3),
(6, 'Bacon Burger', 3),
(7, 'Coke', 1),
(8, 'Iced Tea', 1),
(9, 'Water', 1),
(10, 'Poutine', 2),
(15, 'French Fries', 1),
(14, 'Cheese Bread', 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_categories`
--

DROP TABLE IF EXISTS `menu_item_categories`;
CREATE TABLE IF NOT EXISTS `menu_item_categories` (
  `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_item_categories`
--

INSERT INTO `menu_item_categories` (`category_id`, `category_name`) VALUES
(1, 'Drinks'),
(2, 'Appetizers'),
(3, 'Hamburgers'),
(4, 'Pizza');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

DROP TABLE IF EXISTS `ordered_items`;
CREATE TABLE IF NOT EXISTS `ordered_items` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_complete` tinyint(1) NOT NULL,
  KEY `item_id` (`item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` (`order_id`, `item_id`, `item_complete`) VALUES
(20, 9, 1),
(20, 5, 1),
(20, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `order_complete` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `section_id`, `order_complete`) VALUES
(20, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `item_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  KEY `item_id` (`item_id`),
  KEY `ingredient_id` (`ingredient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`item_id`, `ingredient_id`, `amount`) VALUES
(1, 1, 500),
(7, 2, 500),
(8, 3, 500),
(9, 4, 0),
(2, 5, 0.5),
(2, 6, 1),
(10, 7, 0.25),
(10, 8, 400),
(10, 9, 2),
(3, 10, 1),
(3, 11, 1),
(4, 10, 1),
(4, 11, 1),
(4, 12, 1),
(5, 10, 1),
(5, 11, 1),
(5, 13, 0.25),
(6, 10, 1),
(6, 11, 1),
(6, 14, 3),
(12, 5, 0.25),
(12, 6, 0.5),
(12, 7, 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `section_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`) VALUES
(1),
(2),
(3),
(4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
