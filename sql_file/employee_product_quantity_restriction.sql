-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2019 at 08:52 PM
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
-- Table structure for table `employee_product_quantity_restriction`
--

CREATE TABLE `employee_product_quantity_restriction` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `employee_id` int(11) NOT NULL,
  `product_id` varchar(256) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_by` varchar(256) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_product_quantity_restriction`
--

INSERT INTO `employee_product_quantity_restriction` (`id`, `client_id`, `employee_id`, `product_id`, `quantity`, `added_by`, `added_on`) VALUES
(7, 1, 5002, 'brown_bread', 10, 'admin', '2019-08-10 14:44:18'),
(8, 1, 10000, 'brown_bread', 20, 'admin', '2019-08-10 14:44:29'),
(11, 2, 123600, 'aquafina', 233, 'Rassick', '2019-08-10 14:45:41'),
(12, 2, 96300, 'bisleri', 244, 'Rassick', '2019-08-10 14:45:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_product_quantity_restriction`
--
ALTER TABLE `employee_product_quantity_restriction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_product_quantity_restriction`
--
ALTER TABLE `employee_product_quantity_restriction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
