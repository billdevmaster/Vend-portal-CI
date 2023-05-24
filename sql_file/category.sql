-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2019 at 04:34 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cc2go_adportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` varchar(64) NOT NULL,
  `category_name` varchar(128) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `category_image` varchar(256) NOT NULL,
  `category_image_thumbnail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_id`, `category_name`, `client_id`, `category_image`, `category_image_thumbnail`) VALUES
(12, '10', 'dan', -1, 'ngapp/assets/images/category/original/7ev3aXKxfy8.jpg', 'ngapp/assets/images/category/thumbnail/7ev3aXKxfy8.jpg'),
(13, '20', 'man', -1, 'ngapp/assets/images/category/original/9NxKGTDAZt0.jpg', 'ngapp/assets/images/category/thumbnail/9NxKGTDAZt0.jpg'),
(14, '30', 'fan', -1, 'ngapp/assets/images/category/original/bqafVjHkcAQ.jpg', 'ngapp/assets/images/category/thumbnail/bqafVjHkcAQ.jpg'),
(15, 'brighto_category_1', 'Brighto Category 1', -1, 'ngapp/assets/images/category/original/zlUy_yoKdTU.jpg', 'ngapp/assets/images/category/thumbnail/zlUy_yoKdTU.jpg'),
(16, 'daf', 'fsf', 6, 'ngapp/assets/images/category/original/splash.png', 'ngapp/assets/images/category/thumbnail/splash.png'),
(17, 'sd', 'ds', -1, 'ngapp/assets/images/category/original/buy.png', 'ngapp/assets/images/category/thumbnail/buy.png'),
(18, 'dssf', 'dsafs', 8, 'ngapp/assets/images/category/original/image.png', 'ngapp/assets/images/category/thumbnail/image.png'),
(19, 'vjgsdggds', 'dsassd', 10, 'ngapp/assets/images/category/original/notification_icon.jpg', 'ngapp/assets/images/category/thumbnail/notification_icon.jpg'),
(20, 'red', 'ted', 8, 'ngapp/assets/images/category/original/notification_tray_coloredldpi.png', 'ngapp/assets/images/category/thumbnail/notification_tray_coloredldpi.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
