-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2019 at 08:50 PM
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
-- Table structure for table `employee_transaction`
--

CREATE TABLE `employee_transaction` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(256) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `employee_id` int(20) NOT NULL,
  `employee_full_name` varchar(256) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `machine_id` int(11) NOT NULL,
  `machine_name` varchar(256) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_transaction`
--

INSERT INTO `employee_transaction` (`id`, `transaction_id`, `client_id`, `employee_id`, `employee_full_name`, `product_id`, `product_name`, `machine_id`, `machine_name`, `timestamp`) VALUES
(11, '2111963', 1, 33333, 'Employee Two', 'lays_american', 'Lays American Cream and Onion', 2, 'Asset Multiple - Darwin', '2019-08-10 14:56:04'),
(12, '2323558', 1, 11111, 'Employee One', 'lays_american', 'Lays American Cream and Onion', 2, 'Asset Multiple - Darwin', '2019-08-10 14:56:08'),
(13, '2975483', 1, 33333, 'Employee Two', 'lays_american', 'Lays American Cream and Onion', 2, 'Asset Multiple - Darwin', '2019-07-10 14:56:12'),
(16, '2548407', 2, 33333, 'Employee Two', 'lays_american', 'Lays American Cream and Onion', 2, 'Asset Multiple - Darwin', '2019-07-10 14:56:16'),
(25, '1963250', 2, 3200, 'Tsering Nyagal', 'fanta_angur', 'Fanta Angur', 1, 'Asset Single - Perth', '2019-08-10 18:49:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_transaction`
--
ALTER TABLE `employee_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_transaction`
--
ALTER TABLE `employee_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
