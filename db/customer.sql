-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2023 at 03:52 AM
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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `phone`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Jimmy Stephens', 'jimmys@gmail.com', '212-711-6542', 327, '2008-01-20 12:33:53', 925, 591),
(2, 'Xu Yuning', 'yuningxu@outlook.com', '(151) 836 6890', 645, '2008-01-22 09:32:36', 1, 294),
(3, 'Ishikawa Seiko', 'seiko10@gmail.com', '52-726-9446', 70, '2002-10-04 22:07:40', 490, 428),
(4, 'Yu Rui', 'yu1209@icloud.com', '28-508-6142', 878, '2001-11-26 22:40:02', 825, 59),
(5, 'Ng Kwok Wing', 'ng614@yahoo.com', '5410 092723', 42, '2003-09-11 02:54:49', 381, 300),
(6, 'Yamazaki Hana', 'hyamazaki@icloud.com', '66-361-8541', 307, '2004-08-12 19:43:16', 426, 544),
(7, 'Shen Ziyi', 'zshen@yahoo.com', '133-6775-9499', 960, '2012-02-28 11:27:54', 444, 191),
(8, 'Otsuka Ryota', 'ryoto@gmail.com', '70-9750-0285', 64, '2020-08-19 12:12:23', 467, 818),
(9, 'Ma Wai San', 'mawaisan2018@gmail.com', '148-4745-2193', 553, '2003-07-08 04:39:04', 612, 429),
(10, 'Hayashi Hikaru', 'hikaruha@icloud.com', '10-273-4083', 940, '2007-08-27 03:31:41', 22, 754);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
