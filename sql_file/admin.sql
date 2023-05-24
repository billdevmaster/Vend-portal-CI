-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2019 at 09:44 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `mobilenumber` varchar(20) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `organization` varchar(128) NOT NULL,
  `emailid` varchar(128) NOT NULL,
  `role` varchar(128) NOT NULL,
  `upt_no` varchar(256) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `password` varchar(128) NOT NULL,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `mobilenumber`, `firstname`, `lastname`, `organization`, `emailid`, `role`, `upt_no`, `client_id`, `password`, `is_activated`) VALUES
(1, '1234567890', 'admin', 'admin', '', 'admin@admin.admin', '', '+878101234567890', -1, '$2y$10$hHikCADCBDa.xuoy3L2vZ.kVFGekqUkR0y0r7nNHWilMCpbmnFmeu', 1),
(2, '7845963210', 'Warren', 'Buffet', '', 'warren@buffet.com', '', '+878107845963210', -1, '$2y$10$jwxtFDF99TbNYptcBw8yH.dTAdoRGxAkzdmeQgCOYzRe98.vTwY8m', 1),
(3, '1478523690', 'dan2', 'dan3', 'dan1', 'dan4@ju.st', 'Machine Product Manager', '+878101478523690', -1, '$2y$10$tUYeUbOubSSl517JybqhB.Zds6gXwNna3J9zp6xDm5Z8p4llvr56q', 1),
(4, '7412589630', 'sdsd', 'dssds', 'dsdsds', 'undefined', 'Ad Manager', '+878107412589630', -1, '$2y$10$TMtte8aSWdasfsYYxNatveyRatabf1Ee.E1gxvqXYUZkvjK3cQkgq', 1),
(5, '9564323232', 'ffghgd', 'fdg', 'assa', 'danish@gmail.com', 'Machine Product Manager', '+878109564323232', -1, '$2y$10$D2WTheEKrmUj9AkVe6gY5OOClOZSn7IBRrJ34KYqRXjwIfFbB8vou', 1),
(6, '0145236970', 'xcxcx', 'cxxcx', 'zxzxcxc', 'cas@hxhx.dsjds', 'Ad Manager', '+878100145236970', -1, '$2y$10$8.TgGSacLxEVoImOH92dWOtVjNbCIziP.8MTMIH2p0hAt5rAwYix6', 1),
(7, '0987654321', 'man', 'fan', 'sdasdasd', 'man@fan.com', 'Ad Manager', '+878100987654321', -1, '$2y$10$A3PSWm7YOiSbRGBIRFz6UOTI.5QaqR9fwTvjlEjENTJnw.a5oI1bK', 1),
(8, '8796541200', 'Rassick', 'Mento', '', 'men@ki.ng', 'CLIENT', '+878108796541200', 6, '$2y$10$/WRUWmfIUGYgOBJF/dXuauZJHeDGvV3e4XBXfAE./IdvbOMCoTBhq', 1),
(9, '12345678901', 'Client', 'Dan', '', 'admin@admin.admina', 'Client', '+8781012345678901', 7, '$2y$10$trurpEV8nAAqSotT3ayjIuNDgDIM5T2OMNb.rbYPttmKZ1fKBnSVu', 0),
(10, '3322116655', 'i', 'hop', '', 'i@hop.co', 'Client', '+878103322116655', 8, '$2y$10$Tt7dzSkx4c537gOIB4NOIemIC0jLus5k21jFiRHm2ua7sZAaSvPx2', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
