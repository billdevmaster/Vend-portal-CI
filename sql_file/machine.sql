-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2019 at 06:36 AM
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
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `id` int(11) NOT NULL,
  `machine_username` varchar(255) NOT NULL,
  `machine_upt_no` varchar(255) NOT NULL,
  `machine_name` varchar(256) NOT NULL,
  `machine_client_id` int(11) NOT NULL,
  `machine_mode` int(11) NOT NULL DEFAULT '1',
  `machine_advertisement_mode` int(11) NOT NULL DEFAULT '1',
  `machine_is_game_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `machine_game` int(11) NOT NULL DEFAULT '1',
  `machine_info_button_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `machine_screensaver_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `machine_volume_control_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `machine_wheel_chair_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `machine_is_asset_tracking` tinyint(1) NOT NULL DEFAULT '1',
  `machine_is_advertisement_reporting` tinyint(1) NOT NULL DEFAULT '0',
  `machine_is_feed_enabled` tinyint(1) NOT NULL,
  `machine_row` int(11) NOT NULL,
  `machine_column` int(11) NOT NULL,
  `machine_address` varchar(256) NOT NULL,
  `machine_latitude` double NOT NULL,
  `machine_longitude` double NOT NULL,
  `machine_is_single_category` tinyint(1) NOT NULL,
  `machine_token` varchar(512) NOT NULL,
  `machine_helpline_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `machine_helpline` varchar(512) NOT NULL DEFAULT 'Please call (028) 197-2733 for technical support',
  `machine_customer_care_number` varchar(128) NOT NULL DEFAULT '(028) 197-2733'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`id`, `machine_username`, `machine_upt_no`, `machine_name`, `machine_client_id`, `machine_mode`, `machine_advertisement_mode`, `machine_is_game_enabled`, `machine_game`, `machine_info_button_enabled`, `machine_screensaver_enabled`, `machine_volume_control_enabled`, `machine_wheel_chair_enabled`, `machine_is_asset_tracking`, `machine_is_advertisement_reporting`, `machine_is_feed_enabled`, `machine_row`, `machine_column`, `machine_address`, `machine_latitude`, `machine_longitude`, `machine_is_single_category`, `machine_token`, `machine_helpline_enabled`, `machine_helpline`, `machine_customer_care_number`) VALUES
(1, 'asset_single', '+878109988776655', 'Asset Single - Perth', 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 1, 3, 10, '10 Asset Single', -31.95, 115.86, 1, '', 0, 'Please call (028) 197-2733 for technical support', '(028) 197-2733'),
(2, 'asset_multiple', '+878108877665544', 'Asset Multiple - Darwin', 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 10, '10 Darwin Street', -12.45, 130.85, 0, '', 1, 'Please call (028) 197-2733 for technical support', '(028) 197-2733'),
(3, 'normal_single', '+878107766554433', 'Normal Single', 1, 3, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 3, 10, '10 Sydney Street', -33.87, 151.21, 1, '', 1, 'Please call (028) 197-2733 for technical support', '(028) 197-2733'),
(4, 'normal_multiple', '+878106655443322', 'Normal Multiple - Brisbane', 1, 1, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 2, 10, '10 Brisbane', -27.47, 153.02, 0, '', 0, 'Please call (028) 197-2733 for technical support', '(028) 197-2733');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
