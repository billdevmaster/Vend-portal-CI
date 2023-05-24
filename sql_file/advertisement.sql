-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2019 at 10:58 PM
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
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `ads_path` varchar(1024) NOT NULL,
  `ads_thumbnail` varchar(1024) NOT NULL,
  `ads_filetype` varchar(1024) NOT NULL,
  `ads_position` varchar(1024) NOT NULL,
  `id` int(11) NOT NULL,
  `ads_name` varchar(256) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `ads_machine_name` varchar(256) NOT NULL,
  `ads_machine_id` varchar(256) NOT NULL,
  `ads_resolution` varchar(256) DEFAULT NULL,
  `ads_starts` datetime NOT NULL,
  `ads_ends` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`ads_path`, `ads_thumbnail`, `ads_filetype`, `ads_position`, `id`, `ads_name`, `client_id`, `ads_machine_name`, `ads_machine_id`, `ads_resolution`, `ads_starts`, `ads_ends`) VALUES
('coke_zero.mp4', '', 'Video', 'Screensaver', 10, 'dan', -1, '', '', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('coke_zero.mp4', '', 'Video', 'Homescreen', 15, 'kiujhg', -1, 'Hyena', '', '.mp4 file, Max File size 2 MB,Landscape , Width * Height ( 720 * 480 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('coke_zero.mp4', '', 'Video', 'Screensaver', 16, '1', -1, 'Hyena', '', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('nike_lunar.mp4', '', 'Video', 'Screensaver', 17, '2', -1, 'Hyena', '', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('pepsi_lime.mp4', '', 'Video', 'Screensaver', 18, '3', -1, 'Hyena', '', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('coke_zero.mp4', '', 'Image', 'Screensaver', 19, 'dsd', -1, 'Adelaide', '', '.jpg file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '2018-08-08 14:14:00', '2018-08-26 20:20:00'),
('SampleVideo_1280x720_1mb.mp4', '', 'Video', 'Homescreen', 21, 'adssffsd', -1, 'Hyena', '', '.mp4 file, Max File size 20 MB,Landscape , Width * Height ( 720 * 480 )', '2018-12-06 00:00:00', '2019-04-06 00:00:00'),
('bcf.mp4', '', 'Video', 'Screensaver', 23, 'sfd', -1, 'Adelaide', '', '.mp4 file, Max File size 20 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('sodastream.mp4', '', 'Video', 'Screensaver', 24, 'sg', -1, 'Brisbane', '', '.mp4 file, Max File size 20 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('puma_screen.mp4', '', 'Video', 'Screensaver', 25, 'sdssd', -1, 'Hyena5', '6', '.mp4 file, Max File size 20 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('SampleVideo_1280x720_1mb.mp4', '', 'Video', 'Screensaver', 26, 'test', -1, 'Asset Single - Perth', '1', '.mp4 file, Max File size 10 MB,Potrait , Width * Height ( 480 * 720 )', '2019-08-09 00:00:00', '2019-08-10 00:00:00'),
('SampleVideo_1280x720_1mb.mp4', '', 'Video', 'On Selection of Product - Aquafina', 27, 'Kash', 2, 'Asset Single - Perth', '1', '.mp4 file, Max File size 10 MB,Landscape , Width * Height ( 720 * 480 )', '2019-08-16 00:00:00', '2019-08-31 00:00:00'),
('leh.mp4', '', 'Image', 'On Selection of Category - Biscuit', 28, 'yes', 1, 'Asset Multiple - Darwin', '2', '.jpg file, Max File size 10 MB,Landscape , Width * Height ( 720 * 480 )', '2019-08-02 00:00:00', '2019-08-17 00:00:00'),
('leh.mp4', '', 'Video', 'On Selection of Category - Bread', 29, 'bgr', 1, 'Asset Multiple - Darwin', '2', '.mp4 file, Max File size 10 MB,Landscape , Width * Height ( 720 * 480 )', '2019-08-16 00:00:00', '2019-08-24 00:00:00'),
('leh.mp4', '', 'Video', 'On Selection of Category - Biscuit', 30, 'aza', 1, 'Asset Multiple - Darwin', '2', '.mp4 file, Max File size 10 MB,Landscape , Width * Height ( 720 * 480 )', '2019-08-15 00:00:00', '2019-08-30 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
