-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2019 at 07:00 AM
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
-- Table structure for table `sale_report`
--

CREATE TABLE `sale_report` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(256) NOT NULL,
  `product_id` varchar(256) NOT NULL,
  `product_name` varchar(256) NOT NULL,
  `product_price` varchar(256) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `machine_id` int(11) NOT NULL,
  `machine_name` varchar(256) NOT NULL,
  `timestamp` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_report`
--

INSERT INTO `sale_report` (`id`, `transaction_id`, `product_id`, `product_name`, `product_price`, `client_id`, `machine_id`, `machine_name`, `timestamp`) VALUES
(1, '1103318', 'fanta', 'Fanta Strawberry', '10.00', -1, 1, 'Asset Single - Perth', '2019-07-21 12:25:03'),
(2, '2431549', 'fanta', 'Fanta Strawberry', '10.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-21 12:30:31'),
(3, '2481677', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-21 12:31:21'),
(4, '4553373', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 4, 'Normal Multiple - Brisbane', '2019-07-21 13:05:53'),
(5, '4572463', 'fanta', 'Fanta Strawberry', '10.00', -1, 4, 'Normal Multiple - Brisbane', '2019-07-21 13:06:12'),
(6, '2460387', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 09:51:00'),
(7, '2772185', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 09:56:12'),
(8, '2069272', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 10:01:09'),
(9, '2205472', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 10:03:25'),
(10, '2917507', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 20:48:37'),
(11, '2050848', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 20:50:50'),
(12, '2087876', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 20:51:27'),
(13, '2111988', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 20:51:51'),
(14, '2323606', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 20:55:23'),
(15, '2975524', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:22:55'),
(16, '2209001', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:26:49'),
(17, '2435550', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:30:35'),
(18, '2548440', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:32:28'),
(19, '2715136', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:35:15'),
(20, '2880080', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:38:00'),
(21, '2527135', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:48:47'),
(22, '2551671', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:49:11'),
(23, '2616781', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:50:16'),
(24, '2808343', 'fanta_licchi', 'Fanta Licchi', '11.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:53:28'),
(25, '2146169', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:59:06'),
(26, '2168499', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 2, 'Asset Multiple - Darwin', '2019-07-25 21:59:28'),
(27, '3061979', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 3, 'Normal Single', '2019-07-28 11:54:21'),
(28, '4167768', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 4, 'Normal Multiple - Brisbane', '2019-07-28 11:56:07'),
(29, '4817812', 'fanta_licchi', 'Fanta Licchi', '11.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:00:17'),
(30, '4875915', 'fanta_licchi', 'Fanta Licchi', '11.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:01:15'),
(31, '4898933', 'lays_american', 'Lays American Cream and Onion', '14.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:01:38'),
(32, '4012369', 'fanta_licchi', 'Fanta Licchi', '11.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:03:32'),
(33, '4070007', 'fanta', 'Fanta Strawberry', '10.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:04:30'),
(34, '4343879', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:09:03'),
(35, '4374116', 'fanta', 'Fanta Strawberry', '10.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:09:34'),
(36, '4509991', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:11:49'),
(37, '4533667', 'fanta', 'Fanta Strawberry', '10.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:12:13'),
(38, '4589491', 'fanta_licchi', 'Fanta Licchi', '11.00', -1, 4, 'Normal Multiple - Brisbane', '2019-08-03 12:13:09'),
(39, '3758874', 'fanta_angur', 'Fanta Angur', '12.00', -1, 3, 'Normal Single', '2019-08-11 00:15:58'),
(40, '1963297', 'fanta_angur', 'Fanta Angur', '12.00', -1, 1, 'Asset Single - Perth', '2019-08-11 00:19:23'),
(41, '3567001', 'lays_magic_masala', 'Lays Magic Masala', '13.00', -1, 3, 'Normal Single', '2019-08-17 08:59:27'),
(42, '3618880', 'fanta_licchi', 'Fanta Licchi', '11.00', -1, 3, 'Normal Single', '2019-08-17 09:00:18'),
(43, '3971682', 'lays_magic_masala', 'Lays Magic Masala', '13.00', 1, 3, 'Normal Single', '2019-08-17 10:29:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sale_report`
--
ALTER TABLE `sale_report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sale_report`
--
ALTER TABLE `sale_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
