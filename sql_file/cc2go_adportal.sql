-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2018 at 01:03 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `mobilenumber` varchar(20) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `emailid` varchar(128) NOT NULL,
  `upt_no` varchar(256) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `mobilenumber`, `firstname`, `lastname`, `emailid`, `upt_no`, `password`) VALUES
(0, '1234567890', 'admin', 'admin', 'admin@admin.admin', '+878101234567890', '$2y$10$hHikCADCBDa.xuoy3L2vZ.kVFGekqUkR0y0r7nNHWilMCpbmnFmeu'),
(0, '7845963210', 'Warren', 'Buffet', 'warren@buffet.com', '+878107845963210', '$2y$10$jwxtFDF99TbNYptcBw8yH.dTAdoRGxAkzdmeQgCOYzRe98.vTwY8m');

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
  `ads_machine_name` varchar(256) NOT NULL,
  `ads_resolution` varchar(256) DEFAULT NULL,
  `ads_starts` datetime NOT NULL,
  `ads_ends` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`ads_path`, `ads_thumbnail`, `ads_filetype`, `ads_position`, `id`, `ads_name`, `ads_machine_name`, `ads_resolution`, `ads_starts`, `ads_ends`) VALUES
('coke_zero.mp4', '', 'Video', 'Screensaver', 10, 'dan', '', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('coke_zero.mp4', '', 'Video', 'Homescreen', 15, 'kiujhg', 'Melbourne', '.mp4 file, Max File size 2 MB,Landscape , Width * Height ( 720 * 480 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('coke_zero.mp4', '', 'Video', 'Screensaver', 16, '1', 'Melbourne', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('nike_lunar.mp4', '', 'Video', 'Screensaver', 17, '2', 'Melbourne', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('pepsi_lime.mp4', '', 'Video', 'Screensaver', 18, '3', 'Melbourne', '.mp4 file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('coke_zero.mp4', '', 'Image', 'Screensaver', 19, 'dsd', 'Adelaide', '.jpg file, Max File size 2 MB,Potrait , Width * Height ( 480 * 720 )', '2018-08-08 14:14:00', '2018-08-26 20:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` varchar(64) NOT NULL,
  `category_name` varchar(128) NOT NULL,
  `category_image` varchar(256) NOT NULL,
  `category_image_thumbnail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_id`, `category_name`, `category_image`, `category_image_thumbnail`) VALUES
(9, '2', '2', 'ngapp/assets/images/category/original/DSC_0020_th.jpg', 'ngapp/assets/images/category/thumbnail/DSC_0020_th.jpg'),
(10, '3', '5', 'ngapp/assets/images/category/original/DSC_4399.jpg', 'ngapp/assets/images/category/thumbnail/DSC_4399.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `upt_no` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(255) NOT NULL,
  `device_imei_number` varchar(128) NOT NULL,
  `terms_and_condition_accepted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`id`, `username`, `upt_no`, `time`, `ip_address`, `device_imei_number`, `terms_and_condition_accepted`) VALUES
(4, 'danish_rafique', '+878109674987425', '2018-08-11 10:43:17', '192.168.0.105', '', 1),
(5, 'danish_rafique', '+878109674987425', '2018-08-11 13:04:57', '192.168.0.105', '', 1),
(6, 'danish_rafique', '+878109674987425', '2018-08-11 13:29:31', '192.168.0.106', '', 1),
(7, 'danish_rafique', '+878109674987425', '2018-08-11 13:30:00', '192.168.0.106', '', 1),
(8, 'danish_rafique', '+878109674987425', '2018-08-12 07:31:33', '192.168.0.102', '', 1),
(9, 'danish_rafique', '+878109674987425', '2018-08-12 07:32:05', '192.168.0.102', '', 1),
(10, 'danish_rafique', '+878109674987425', '2018-08-12 07:33:17', '192.168.0.102', '', 1),
(11, 'danish_rafique', '+878109674987425', '2018-08-12 07:49:44', '192.168.0.102', '145', 1),
(12, 'danish_rafique', '+878109674987425', '2018-08-12 07:54:08', '192.168.0.101', '351893083705999', 1),
(13, 'danish_rafique', '+878109674987425', '2018-08-12 07:54:28', '192.168.0.101', '351893083705999', 1),
(14, 'danish_rafique', '+878109674987425', '2018-08-12 08:12:02', '192.168.0.102', '145', 1),
(15, 'sdsd', '+878107845123690', '2018-08-12 08:15:11', '192.168.0.102', '145', 1),
(16, 'danish_rafique', '+878109674987425', '2018-08-12 08:21:02', '192.168.0.101', '351893083705999', 1),
(17, 'danish_rafique', '+878109674987425', '2018-08-12 09:08:49', '192.168.0.101', '351893083705999', 1),
(18, 'danish_rafique', '+878109674987425', '2018-08-12 09:13:36', '192.168.0.101', '351893083705999', 1),
(19, 'danish_rafique', '+878109674987425', '2018-08-12 09:30:17', '192.168.0.101', '351893083705999', 1),
(20, 'danish_rafique', '+878109674987425', '2018-08-12 09:32:27', '192.168.0.101', '351893083705999', 1),
(21, 'danish_rafique', '+878109674987425', '2018-08-12 09:48:53', '192.168.0.101', '351893083705999', 1),
(22, 'danish_rafique', '+878109674987425', '2018-08-12 10:08:42', '192.168.0.101', '351893083705999', 1),
(23, 'danish_rafique', '+878109674987425', '2018-08-12 10:21:42', '192.168.0.101', '351893083705999', 1),
(24, 'danish_rafique', '+878109674987425', '2018-08-12 10:27:15', '192.168.0.101', '351893083705999', 1),
(25, 'danish_rafique', '+878109674987425', '2018-08-12 10:32:05', '192.168.0.101', '351893083705999', 1),
(26, 'danish_rafique', '+878109674987425', '2018-08-12 10:34:22', '192.168.0.101', '351893083705999', 1),
(27, 'danish_rafique', '+878109674987425', '2018-08-12 10:44:33', '192.168.0.101', '351893083705999', 1),
(28, 'danish_rafique', '+878109674987425', '2018-08-12 10:58:21', '192.168.0.101', '351893083705999', 1),
(29, 'danish_rafique', '+878109674987425', '2018-08-12 11:03:53', '192.168.0.101', '351893083705999', 1),
(30, 'danish_rafique', '+878109674987425', '2018-08-12 11:04:41', '192.168.0.101', '351893083705999', 1),
(31, 'danish_rafique', '+878109674987425', '2018-08-12 11:07:20', '192.168.0.101', '351893083705999', 1),
(32, 'danish_rafique', '+878109674987425', '2018-08-12 11:09:17', '192.168.0.101', '351893083705999', 1);

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `id` int(11) NOT NULL,
  `machine_username` varchar(255) NOT NULL,
  `machine_upt_no` varchar(255) NOT NULL,
  `machine_name` varchar(256) NOT NULL,
  `machine_latitude` double NOT NULL,
  `machine_longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`id`, `machine_username`, `machine_upt_no`, `machine_name`, `machine_latitude`, `machine_longitude`) VALUES
(1, '', '', 'Melbourne', -37.8136, 144.9631),
(2, '', '', 'Adelaide', -34.9285, 138.6007),
(3, '', '', 'Brisbane', -27.4698, 153.0251),
(4, 'danish_rafique', '+878109674987425', '50', 15.23, 14.2),
(5, 'obaiz', '+878107412589630', '56', 25.36, 65.36),
(6, 'danish_rafique', '+878109674987425', 'Hyena', 26.53, -87.2);

-- --------------------------------------------------------

--
-- Table structure for table `machine_assign_category`
--

CREATE TABLE `machine_assign_category` (
  `id` int(11) NOT NULL,
  `machine_id` varchar(256) NOT NULL,
  `category_id` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `machine_assign_category`
--

INSERT INTO `machine_assign_category` (`id`, `machine_id`, `category_id`) VALUES
(1, '6', '2'),
(2, '6', '3'),
(3, '10', '10');

-- --------------------------------------------------------

--
-- Table structure for table `machine_assign_product`
--

CREATE TABLE `machine_assign_product` (
  `id` int(11) NOT NULL,
  `machine_id` varchar(256) NOT NULL,
  `category_id` varchar(256) NOT NULL,
  `product_id` varchar(256) NOT NULL,
  `product_location` varchar(64) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `machine_assign_product`
--

INSERT INTO `machine_assign_product` (`id`, `machine_id`, `category_id`, `product_id`, `product_location`, `product_quantity`) VALUES
(1, '6', '2', '22', '101', 10),
(2, '6', '2', '11', '102', 20),
(3, '6', '2', '33', '103', 30),
(4, '6', '3', '44', '401', 40),
(5, '5', '5', '5', '5', 5);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_category_id` varchar(255) NOT NULL,
  `product_category_name` varchar(255) NOT NULL,
  `product_price` double(10,2) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image_thumbnail` varchar(255) NOT NULL,
  `product_more_info_image` varchar(255) NOT NULL,
  `product_more_info_image_thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_id`, `product_name`, `product_category_id`, `product_category_name`, `product_price`, `product_description`, `product_image`, `product_image_thumbnail`, `product_more_info_image`, `product_more_info_image_thumbnail`) VALUES
(2, '22', '22', '2', '2', 22.00, '22', 'ngapp/assets/images/product/original/DSC_2174.jpg', 'ngapp/assets/images/product/thumbnail/DSC_2174.jpg', 'ngapp/assets/images/product/original/DSC_8125.jpg', 'ngapp/assets/images/product/original/DSC_8125.jpg'),
(3, '11', '11', '2', '2', 11.00, '11', 'ngapp/assets/images/product/original/DSC_0261.jpg', 'ngapp/assets/images/product/thumbnail/DSC_0261.jpg', 'ngapp/assets/images/product/original/DSC_2174_th.jpg', 'ngapp/assets/images/product/original/DSC_2174_th.jpg'),
(4, '33', '33', '2', '2', 33.00, '33', 'ngapp/assets/images/product/original/DSC_0934_th.jpg', 'ngapp/assets/images/product/thumbnail/DSC_0934_th.jpg', 'ngapp/assets/images/product/original/DSC_2940_th.jpg', 'ngapp/assets/images/product/original/DSC_2940_th.jpg'),
(5, '44', '44', '3', '5', 44.00, '44', 'ngapp/assets/images/product/original/DSC_0339.jpg', 'ngapp/assets/images/product/thumbnail/DSC_0339.jpg', 'ngapp/assets/images/product/original/DSC_0348_th.jpg', 'ngapp/assets/images/product/original/DSC_0348_th.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `mobilenumber` varchar(20) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `emailid` varchar(128) NOT NULL,
  `upt_no` varchar(256) DEFAULT NULL,
  `token` varchar(1024) NOT NULL,
  `password` varchar(128) NOT NULL,
  `id` int(11) NOT NULL,
  `activated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deactivated` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`mobilenumber`, `firstname`, `lastname`, `username`, `emailid`, `upt_no`, `token`, `password`, `id`, `activated_on`, `last_updated`, `is_deactivated`) VALUES
('9674987425', 'Danish', 'Rafique', 'danish_rafique', 'dan@raf.com', '+878109674987425', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9rZXkiOiJkYW5pc2hfcmFmaXF1ZSIsImlhdCI6MTUzNDA3MjE1NywiZXhwIjoxNTM0MDkwMTU3fQ.AnrSxso5xPe9xzuo0LALnofOverBBh1UQp1jDwUa6ts', '$2y$10$WmI5gTQA2uVgBD5A4fFd4.zMBVjnGHBqjzTerzzsJZUp2yf6gpwV6', 3, '2018-08-11 15:21:53', '2018-08-12 11:09:17', '0'),
('7412589630', 'obaiz', 'ali', 'obaiz', 'a@jsjc.coo', '+878107412589630', '', '$2y$10$xG8S8/Ly57eLPHEaqAFwZOZoDEAj4/yTCWK87tAu5RBY0pAaoVRam', 5, '2018-08-11 18:26:27', '2018-08-11 12:56:27', '0'),
('7845123690', 'sdds', 'sdsdds', 'sdsd', 'ss@sdds.sdds', '+878107845123690', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9rZXkiOiJzZHNkIiwiaWF0IjoxNTM0MDYxNzExLCJleHAiOjE1MzQwNzk3MTF9.X4JcbeLrMbOUtL42CP_O_HIxuboPqIcpuUQVrq8fJcM', '$2y$10$svyj6oq.hUlMJstQtZz9O.PzQHhdGIqISM2Tfy4DPwZNFdtse1leu', 6, '2018-08-11 18:27:32', '2018-08-12 08:15:11', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_assign_category`
--
ALTER TABLE `machine_assign_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_assign_product`
--
ALTER TABLE `machine_assign_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`mobilenumber`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `machine_assign_category`
--
ALTER TABLE `machine_assign_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `machine_assign_product`
--
ALTER TABLE `machine_assign_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
