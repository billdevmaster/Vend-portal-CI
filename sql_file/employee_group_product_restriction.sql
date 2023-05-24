-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2019 at 08:19 AM
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
-- Table structure for table `employee_group_product_restriction`
--

CREATE TABLE `employee_group_product_restriction` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(256) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `product_id` varchar(256) NOT NULL,
  `product_name` varchar(256) NOT NULL,
  `product_image` varchar(256) NOT NULL,
  `added_by` varchar(256) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_group_product_restriction`
--

INSERT INTO `employee_group_product_restriction` (`id`, `group_id`, `group_name`, `client_id`, `product_id`, `product_name`, `product_image`, `added_by`, `added_on`) VALUES
(1, 2, 'Assistant', -1, 'fanta', 'Fanta Strawberry', 'ngapp/assets/images/product/original/00049000026207_main.jpg', 'admin', '2019-08-07 05:10:09'),
(2, 6, 'Minister of Food', 1, 'brown_bread', 'Brown Bread', 'ngapp/assets/images/product/original/1519403490085.jpeg', 'admin', '2019-08-07 05:49:54'),
(4, 8, 'sdds', 2, 'aquafina', 'Aquafina', 'ngapp/assets/images/product/original/aquafina-mineral-water-500x500.jpg', 'admin', '2019-08-07 05:57:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_group_product_restriction`
--
ALTER TABLE `employee_group_product_restriction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_group_product_restriction`
--
ALTER TABLE `employee_group_product_restriction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
