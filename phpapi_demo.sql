-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2022 at 03:33 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpapi_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `category_id`, `created`, `modified`) VALUES
(1, 'Samsung Washing Machine', 'its best machine', 35000, 6, '2022-05-02 15:11:07', '2022-05-31 12:12:26'),
(3, 'Galaxy S4', 'Galaxy S4 Model is Awesome', 400, 3, '2022-06-01 01:12:26', '2022-05-31 12:12:26'),
(5, 'Dell Laptop', 'My business partner.', 319, 2, '2022-06-01 01:13:45', '2022-05-30 21:13:39'),
(6, 'Nokia Tab 10.1', 'Good tablet.', 239, 2, '2022-06-01 01:14:13', '2022-05-30 21:14:08'),
(7, 'Apple Watch', 'My sports watch.', 299, 1, '2022-06-01 01:18:36', '2022-05-30 21:18:31'),
(8, 'Smart Watch', 'The coolest smart watch!', 300, 2, '2022-06-06 17:10:01', '2022-06-05 13:09:51'),
(9, 'Rolex Watch', 'Luxury watch.', 15000, 1, '2022-01-11 15:46:02', '2022-01-11 10:46:02'),
(10, 'HP Laptop', 'Pavilion', 319, 2, '2022-06-01 01:13:45', '2022-05-30 21:13:39'),
(11, 'LG Washing Machine', 'its best machine', 35000, 6, '2022-05-02 15:11:54', '2022-05-02 12:25:42'),
(12, 'Yeti MIC', 'its best mic', 15000, 4, '2022-05-02 14:29:20', '2022-05-02 12:29:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
