-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2019 at 04:34 PM
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
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '-1',
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

INSERT INTO `product` (`id`, `product_id`, `product_name`, `client_id`, `product_price`, `product_description`, `product_image`, `product_image_thumbnail`, `product_more_info_image`, `product_more_info_image_thumbnail`) VALUES
(10, '201', 'Layss', -1, 10.00, 'Bugles', 'ngapp/assets/images/product/original/uQnE4aFW4-U.jpg', 'ngapp/assets/images/product/thumbnail/uQnE4aFW4-U.jpg', 'ngapp/assets/images/product/original/WoW8eN5SCrc.jpg', 'ngapp/assets/images/product/thumbnail/WoW8eN5SCrc.jpg'),
(11, '202', 'Pringles', -1, 20.00, 'Sour Cream', 'ngapp/assets/images/product/original/pringles.jpg', 'ngapp/assets/images/product/thumbnail/pringles.jpg', 'ngapp/assets/images/product/original/pringles.jpg', 'ngapp/assets/images/product/thumbnail/pringles.jpg'),
(12, '203', 'Thums Up', -1, 35.00, '500ml', 'ngapp/assets/images/product/original/ThumsUp.jpg', 'ngapp/assets/images/product/thumbnail/ThumsUp.jpg', 'ngapp/assets/images/product/original/ThumsUp.jpg', 'ngapp/assets/images/product/thumbnail/ThumsUp.jpg'),
(13, '204', 'GoodDay Biscuit', -1, 25.00, 'Cashew', 'ngapp/assets/images/product/original/goodday-cashew.png', 'ngapp/assets/images/product/thumbnail/goodday-cashew.png', 'ngapp/assets/images/product/original/goodday-cashew.png', 'ngapp/assets/images/product/thumbnail/goodday-cashew.png'),
(17, 'brighto_product_1', 'Brighto Product 1', -1, 108.00, 'Brighto Product 1', 'ngapp/assets/images/product/original/YhM7-myr4qM.jpg', 'ngapp/assets/images/product/thumbnail/YhM7-myr4qM.jpg', 'ngapp/assets/images/product/original/xWR-NhkdaE0.jpg', 'ngapp/assets/images/product/thumbnail/xWR-NhkdaE0.jpg'),
(18, '806', 'Brighto Product Todays Deal', -1, 250.00, 'Brighto Product Smart Pants Description', 'ngapp/assets/images/product/original/vzIjllDiXFQ.jpg', 'ngapp/assets/images/product/thumbnail/vzIjllDiXFQ.jpg', 'ngapp/assets/images/product/original/saN1NMklUH0.jpg', 'ngapp/assets/images/product/thumbnail/saN1NMklUH0.jpg'),
(19, '7', '8', 1, 10.00, 'slmmsl', 'ngapp/assets/images/product/original/notification_tray_coloredldpi.png', 'ngapp/assets/images/product/thumbnail/notification_tray_coloredldpi.png', 'ngapp/assets/images/product/original/notification_tray_bwldpi.png', 'ngapp/assets/images/product/thumbnail/notification_tray_bwldpi.png'),
(20, 'a', 'sd', -1, 23.00, 'dfg', 'ngapp/assets/images/product/original/download.png', 'ngapp/assets/images/product/thumbnail/download.png', 'ngapp/assets/images/product/original/splash.png', 'ngapp/assets/images/product/thumbnail/splash.png'),
(21, 'dsafs', 'dfsdfss', 8, 52.00, 'jbkjsdbkjds', 'ngapp/assets/images/product/original/Screenshot_20181207-073333.png', 'ngapp/assets/images/product/thumbnail/Screenshot_20181207-073333.png', 'ngapp/assets/images/product/original/Webp.net-resizeimage (1).png', 'ngapp/assets/images/product/thumbnail/Webp.net-resizeimage (1).png'),
(22, 'dvsdsdfs', 'addade', 8, 99999999.99, 'adsdcdada', 'ngapp/assets/images/product/original/Screenshot_20181207-073400.png', 'ngapp/assets/images/product/thumbnail/Screenshot_20181207-073400.png', 'ngapp/assets/images/product/original/download.png', 'ngapp/assets/images/product/thumbnail/download.png'),
(23, 'tdst', 'huhasihsa', 10, 12.00, 'kmas;as', 'ngapp/assets/images/product/original/image.png', 'ngapp/assets/images/product/thumbnail/image.png', 'ngapp/assets/images/product/original/Screenshot_20181207-073344.png', 'ngapp/assets/images/product/thumbnail/Screenshot_20181207-073344.png'),
(24, 'asadds', 'dsads', 8, 34234.00, 'dfdg', 'ngapp/assets/images/product/original/buy.png', 'ngapp/assets/images/product/thumbnail/buy.png', 'ngapp/assets/images/product/original/buy.png', 'ngapp/assets/images/product/thumbnail/buy.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
