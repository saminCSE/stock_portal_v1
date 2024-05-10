-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2023 at 03:53 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shebatrade`
--

-- --------------------------------------------------------

--
-- Table structure for table `watchlists`
--

CREATE TABLE `watchlists` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `instrument_id` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `watchlists`
--

INSERT INTO `watchlists` (`id`, `customer_id`, `instrument_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 30258, 28, '2022-09-26 10:30:05', 245, '2002-04-27 00:13:11'),
(2, 1, 30253, 708, '2012-11-05 11:33:17', 417, '2018-10-25 23:03:42'),
(3, 1, 30254, 500, '2006-03-08 01:52:49', 829, '2017-09-10 00:59:30'),
(4, 2, 30255, 108, '2011-06-15 12:08:01', 250, '2019-08-26 03:51:49'),
(5, 2, 229, 291, '2006-05-11 20:44:40', 687, '2021-09-15 00:45:03'),
(6, 2, 230, 491, '2011-07-23 10:52:57', 595, '2022-04-17 00:52:32'),
(7, 2, 231, 352, '2000-12-02 18:23:14', 211, '2015-08-03 16:03:41'),
(8, 1, 232, 772, '2009-05-11 08:22:31', 372, '2003-05-26 15:01:34'),
(9, 3, 235, 596, '2008-05-21 05:19:12', 242, '2001-05-13 06:12:32'),
(10, 3, 347, 946, '2022-07-01 09:14:06', 527, '2000-11-24 13:44:22'),
(11, 1, 30258, 1, '2023-01-25 18:27:18', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `watchlists`
--
ALTER TABLE `watchlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `watchlists`
--
ALTER TABLE `watchlists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
