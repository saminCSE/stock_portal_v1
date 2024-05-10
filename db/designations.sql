-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2023 at 06:44 AM
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
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation_status` tinyint NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `designation_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Software Engineer', 1, 1, '2022-12-27 14:52:31', NULL, NULL),
(4, 'System Analyst', 0, 1, '2022-12-27 15:57:06', NULL, NULL),
(5, 'Check Update', 0, 1, '2022-12-27 16:11:30', 1, '2022-12-27 16:55:46'),
(6, 'Yello', 1, 1, '2023-01-02 10:53:32', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
