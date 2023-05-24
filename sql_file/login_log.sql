-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2018 at 11:37 AM
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
(20, 'danish_rafique', '+878109674987425', '2018-08-12 09:32:27', '192.168.0.101', '351893083705999', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
