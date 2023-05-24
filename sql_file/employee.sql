-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2019 at 09:03 AM
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
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `mobile_number` varchar(13) NOT NULL,
  `job_number` varchar(20) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
  `group_id` int(10) NOT NULL,
  `group_name` varchar(256) NOT NULL,
  `account_created_by` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `mobile_number`, `job_number`, `employee_id`, `client_id`, `group_id`, `group_name`, `account_created_by`, `created_at`) VALUES
(1, 'Employee', 'One', '11223344', '22222', '11111', -1, 1, 'Manager', 'admin', '2019-07-21 06:45:59'),
(2, 'Employee', 'Two', '1122334455', '44444', '33333', -1, 2, 'Assistant', 'admin', '2019-07-21 06:46:24'),
(3, 'Employee', 'Three', '4455667788', '66666', '55555', -1, -1, '', 'admin', '2019-07-21 07:49:45'),
(4, 'Jamyang', 'Tsering', '9874654653', '9875', '5002', 1, 1, 'Manager', 'admin', '2019-08-07 03:20:45'),
(5, 'Tsering', 'Nyagal', '7485748512', '1548', '3200', 2, 5, 'Employee', 'Rassick', '2019-08-07 03:22:12'),
(6, 'Tehseen', 'Poonawala', '8745987456', '98738', '10000', 1, 6, 'Minister of Food', 'admin', '2019-08-07 04:06:43'),
(7, 'Yuan', 'Flow', '8528528520', '52100', '96350', 2, 5, 'Employee', 'Rassick', '2019-08-07 04:57:25'),
(8, 'Dogra', 'Singh', '7410032100', '85200', '96300', 2, 7, 'Kashmir', 'Rassick', '2019-08-07 04:58:01'),
(9, 'Your', 'Ony', '80023015000', '50003', '10210', -1, -1, '', 'admin', '2019-08-07 05:05:56'),
(10, 'Sincere', 'Judge', '98000014520', '15000', '123600', 2, -1, '', 'Rassick', '2019-08-07 05:08:56'),
(11, 'John', 'Doe', '9876543210', '100', '1000', -1, 1, 'Manager', 'admin', '2019-08-10 15:36:30'),
(12, 'Jane', 'Down', '9876543201', '200', '1001', -1, 2, 'Assistant', 'admin', '2019-08-10 15:36:30'),
(13, 'John', 'Doe', '9876543210', '241', '1034', -1, 1, 'Manager', 'admin', '2019-08-10 18:26:00'),
(14, 'Jane', 'Down', '9876543201', '210', '1045', -1, 2, 'Assistant', 'admin', '2019-08-10 18:26:00'),
(15, 'John', 'Doe', '9876543210', '1203', '5214', 1, 1, 'Manager', 'Danish', '2019-08-10 18:27:03'),
(16, 'Jane', 'Down', '9876543201', '7485', '6523', 1, 2, 'Assistant', 'Danish', '2019-08-10 18:27:03'),
(17, 'Tes', 'Kick', '7788995544', '12345', '12345', 1, 6, 'Minister of Food', 'Danish', '2019-08-13 20:35:32'),
(19, 'pol', 'saw', '7418529630', '14520', '14520', 1, 6, 'Minister of Food', 'admin', '2019-08-13 20:50:17'),
(20, 'iorn', 'lki', '7896541230', '14520', '14520', 2, 8, 'sdds', 'admin', '2019-08-13 20:50:39'),
(21, 'secr', 'rer', '887744556630', '14520', '14520', 1, 6, 'Minister of Food', 'admin', '2019-08-13 20:51:06'),
(22, 'iol', 'oil', '4455663322', '14520', '14520', 1, 6, 'Minister of Food', 'admin', '2019-08-13 20:53:19'),
(23, 'uyt', 'ukk', '4455663322', '14520', '145201', 1, 6, 'Minister of Food', 'admin', '2019-08-13 20:55:12'),
(24, 'fds', 'dfs', '554411223', '14520', '145201', 2, 7, 'Kashmir', 'admin', '2019-08-13 20:55:32'),
(25, '423', '435', '342', '234', '234', 1, -1, '', 'admin', '2019-08-13 20:58:34'),
(26, 'dan', 'kil', '4433665599', '562', '1256', 1, 6, 'Minister of Food', 'Danish', '2019-08-17 07:01:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
