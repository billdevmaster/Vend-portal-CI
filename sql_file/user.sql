-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2019 at 04:31 PM
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
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `activated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '-1',
  `is_deactivated` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`mobilenumber`, `firstname`, `lastname`, `username`, `emailid`, `upt_no`, `token`, `password`, `id`, `client_id`, `activated_on`, `last_updated`, `status`, `is_deactivated`) VALUES
('9988776655', 'Asset', 'Single', 'asset_single', 'asset@single.com', '+878109988776655', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9rZXkiOiJhc3NldF9zaW5nbGUiLCJpYXQiOjE1NjU0NjI4NjEsImV4cCI6MTU2NTQ4MDg2MX0.mp4z5tRsuEc5cRKSWOOu3X8baq4jj993UtE2qsYer4o', '$2y$10$XsEGdLjPB3mCHBxDqPVDcOksXCB7FY0f89yFfOeGRwux1h1pMC4am', 1, -1, '2019-07-21 11:51:10', '2019-08-10 18:47:41', 1, '0'),
('8877665544', 'Asset', 'Multiple', 'asset_multiple', 'asset@multiple.com', '+878108877665544', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9rZXkiOiJhc3NldF9tdWx0aXBsZSIsImlhdCI6MTU2NTQ2MjAwNiwiZXhwIjoxNTY1NDgwMDA2fQ.NuDL1MQ8zhmvMvhzIyNXI9oBaZnod8SMxgb0e640FUM', '$2y$10$Zf5vz57HWMJgsZpN7sNhVudSjNuOSs8aADFeksEGi7UcRdyqOUqhK', 2, -1, '2019-07-21 11:51:41', '2019-08-10 18:33:26', 1, '0'),
('7766554433', 'normal', 'single', 'normal_single', 'normal@single.com', '+878107766554433', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9rZXkiOiJub3JtYWxfc2luZ2xlIiwiaWF0IjoxNTY2MDE3OTQyLCJleHAiOjE1NjYwMzU5NDJ9.CnULeEJM38qsPv0MjbEqxjqy1tpbIhjA-hOdCcoNXe8', '$2y$10$5yLBSdJlR/QZpDmJi0xICO/o77XIyia0lTdsH3Z0MvBYtF3xSVM4e', 3, -1, '2019-07-21 11:52:20', '2019-08-17 04:59:02', 1, '0'),
('6655443322', 'normal', 'multiple', 'normal_multiple', 'normal@multiple.com', '+878106655443322', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9rZXkiOiJub3JtYWxfbXVsdGlwbGUiLCJpYXQiOjE1NjQ4MTM1NjUsImV4cCI6MTU2NDgzMTU2NX0.zEb30TIMHlCYDDkhapukKX01Q2ymHf50nZyM6MbqtkM', '$2y$10$hF1HlT8zVdRt2g474c2EQuf4DXKXpNQHV3WhYh4kyH0MjtKP/9mly', 4, -1, '2019-07-21 11:52:51', '2019-08-03 06:26:05', 1, '0'),
('5599112244', 'Pankaj', 'Tripathi', 'pankaj', 'pankaj@tripathi.com', '+878105599112244', '', '$2y$10$n6cC6p5rKn7MdKS4mw/rQ.Byp1DmMpTK7vTGnaHL4WoVv4snK1Rlu', 5, -1, '2019-08-17 11:42:08', '2019-08-17 06:13:19', 0, '0'),
('1122448866', 'Nawazuddin', 'Siddique', 'nawaz', 'nawaz@uddin.com', '+878101122448866', '', '$2y$10$7WNI9/3m8oUnw4.aOdUaeu8evYjRxP4DMxygyMhiphxcPUg6KLori', 6, -1, '2019-08-17 11:45:01', '2019-08-17 06:15:19', 0, '0'),
('77569841230', 'Akash', 'Banerjee', 'akash', 'akash@banerjee.com', '+8781077569841230', '', '$2y$10$rSXLqvd5oUk/AbPXU/3iKOmfLXIyeoM3mGL0sGDoQQm8wZ/as66be', 7, 1, '2019-08-17 12:06:24', '2019-08-17 06:45:35', 1, '0'),
('3322556611', 'Desh', 'Bhakht', 'desh', 'desh@bhakht.com', '+878103322556611', '', '$2y$10$o22MMgAiAtEfmNLL0tu5kuUM7Fsp1TlntFSTcto/As6BbirxurxNK', 8, 2, '2019-08-17 12:07:08', '2019-08-17 06:49:08', 1, '0'),
('8844556622', 'Narendra', 'Modi', 'modi', 'modi@narendra.com', '+878108844556622', '', '$2y$10$hUlnzB0vxvMLIfu0XGruK.bDQkpHmPS27DtPnlQvdp9ZUQXXkRwoS', 9, 1, '2019-08-17 12:08:20', '2019-08-17 06:38:29', 0, '0'),
('9988776655', 'Ian', 'Bose', 'ian', 'ian@bose.com', '+878109988776655', '', '$2y$10$OmhTPTIvq32fzvBWtI4q7.4Rcwq9eknpj02fU4xBMydXCtCB.9d6.', 10, 1, '2019-08-18 19:55:15', '2019-08-18 14:26:09', 1, '0'),
('9988776655', 'Ian', 'Bose', 'bose', 'ian@bose.com', '+878109988776655', '', '$2y$10$5KQKZEVwEZ1NrvgYZ6HEpeaTQI3B6ZbOY6HxmLzU5XATDCp6xmghS', 11, 1, '2019-08-18 19:55:50', '2019-08-18 14:26:11', 1, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
