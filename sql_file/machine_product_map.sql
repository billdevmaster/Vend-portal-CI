-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2018 at 02:57 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.28

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
-- Table structure for table `machine_product_map`
--

CREATE TABLE `machine_product_map` (
  `id` int(11) NOT NULL,
  `machine_id` varchar(256) NOT NULL,
  `category_id` varchar(256) NOT NULL,
  `product_id` varchar(256) NOT NULL,
  `product_name` varchar(256) NOT NULL,
  `product_image` varchar(1024) NOT NULL DEFAULT 'ngapp/assets/images/product/thumbnail/no_product.png',
  `product_location` varchar(64) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `machine_product_map`
--

INSERT INTO `machine_product_map` (`id`, `machine_id`, `category_id`, `product_id`, `product_name`, `product_image`, `product_location`, `product_quantity`) VALUES
(57, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '1', 0),
(58, '22', 'erw', '6', '9', 'ngapp/assets/images/product/thumbnail/main-qimg-32e6a32912de2728fae6f2db429e33e3-c.jpg', '2', 0),
(59, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '3', 0),
(60, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '4', 0),
(61, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '5', 0),
(62, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '6', 0),
(63, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '7', 0),
(64, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '8', 0),
(65, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '9', 0),
(66, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '10', 0),
(67, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '11', 0),
(68, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '12', 0),
(69, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '13', 0),
(70, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '14', 0),
(71, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '15', 0),
(72, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '16', 0),
(73, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '17', 0),
(74, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '18', 0),
(75, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '19', 0),
(76, '22', '', '', '', 'ngapp/assets/images/product/thumbnail/no_product.png', '20', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `machine_product_map`
--
ALTER TABLE `machine_product_map`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `machine_product_map`
--
ALTER TABLE `machine_product_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
