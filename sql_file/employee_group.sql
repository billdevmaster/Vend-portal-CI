-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2019 at 08:20 AM
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
-- Table structure for table `employee_group`
--

CREATE TABLE `employee_group` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `group_name` varchar(256) NOT NULL,
  `created_by` varchar(256) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_group`
--

INSERT INTO `employee_group` (`id`, `client_id`, `group_name`, `created_by`, `created_at`) VALUES
(1, -1, 'Manager', 'admin', '2019-03-23 13:49:17'),
(2, -1, 'Assistant', 'admin', '2019-03-23 13:51:05'),
(5, 2, 'Employee', 'admin', '2019-07-21 10:01:02'),
(6, 1, 'Minister of Food', 'admin', '2019-08-07 04:06:12'),
(7, 2, 'Kashmir', 'Rassick', '2019-08-07 04:57:39'),
(8, 2, 'sdds', 'Rassick', '2019-08-07 05:09:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_group`
--
ALTER TABLE `employee_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_group`
--
ALTER TABLE `employee_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
