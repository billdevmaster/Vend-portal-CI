-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2019 at 05:39 AM
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
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `client_code` varchar(256) NOT NULL,
  `client_name` varchar(256) NOT NULL,
  `client_address` varchar(2048) NOT NULL,
  `client_email` varchar(256) NOT NULL,
  `client_phone` varchar(256) NOT NULL,
  `client_password` varchar(128) NOT NULL,
  `enable_mail_report` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` varchar(256) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `client_code`, `client_name`, `client_address`, `client_email`, `client_phone`, `client_password`, `enable_mail_report`, `created_by`, `created_on`) VALUES
(1, 'danish_rafique', 'Danish Rafique', '10 Danish Rafique', 'danishrafique0154@gmail.com', '4433221100', '$2y$10$Ozn7.s.PVJZtJ3JGgedKoOvy363z7DPonci.tAaIti4JnXKxx1RZW', 1, 'admin', '2019-07-21 06:36:44'),
(2, 'rassick_mento', 'Rassick Mento', '25 Rassick Mento', 'danishrafique227@gmail.com', '3322110099', '$2y$10$lmrBJMepZsLS/ZokEORuJusTfl0fgDiGSLTxXmHtyM0qs3GpCInMq', 1, 'admin', '2019-07-21 06:37:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
