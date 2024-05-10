-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2023 at 06:43 AM
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
-- Table structure for table `company_board_of_directors`
--

CREATE TABLE `company_board_of_directors` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `directors_profiles_id` int NOT NULL,
  `designation_id` int NOT NULL,
  `share_percentage` decimal(10,0) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `company_board_of_directors`
--

INSERT INTO `company_board_of_directors` (`id`, `company_id`, `directors_profiles_id`, `designation_id`, `share_percentage`, `start_date`, `end_date`, `email`, `phone`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(3, 39, 6, 1, '10', '2023-01-03 00:00:00', '2023-01-03 00:00:00', 'raihanraju007@gmail.com', '01740387029', 1, '2023-01-03 11:30:18', NULL, NULL),
(4, 143, 3, 6, '10', '2023-01-03 00:00:00', '2023-01-03 00:00:00', 'raihanraju007@gmail.com', '01719534042', 1, '2023-01-03 11:53:54', NULL, NULL),
(5, 232, 5, 1, '1611654007', '2023-01-03 00:00:00', '2023-01-07 00:00:00', 'raihanraju007@gmail.com', '01611654007', 1, '2023-01-03 11:54:36', 1, '2023-01-03 12:37:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_board_of_directors`
--
ALTER TABLE `company_board_of_directors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_board_of_directors`
--
ALTER TABLE `company_board_of_directors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
