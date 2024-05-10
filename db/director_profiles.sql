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
-- Table structure for table `director_profiles`
--

CREATE TABLE `director_profiles` (
  `id` int NOT NULL,
  `name` varchar(80) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `designation_id` int NOT NULL,
  `description` text NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `director_profiles`
--

INSERT INTO `director_profiles` (`id`, `name`, `phone`, `email`, `designation_id`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Md Raihan Hossin Raju', '01740387029', 'raihanraju007@gmail.com', 1, 'First Description', 1, '2023-01-01 13:07:00', 1, '2023-01-02 10:50:46'),
(3, 'Check Update phone number', '01611654007', 'raihanraju007@gmail.com', 2, 'svxbfgdfh', 1, '2023-01-01 14:35:48', 1, '2023-01-02 10:49:26'),
(4, 'Md Raihan Hossin', '12345678989', 'raihanraju007@gmail.com', 1, 'dgdbxhbfbfbf', 1, '2023-01-01 15:20:27', 1, '2023-01-02 09:14:51'),
(5, 'Check Profile', '01234567891', 'raihanraju007@gmail.com', 1, 'dgbdff', 1, '2023-01-02 09:13:29', NULL, NULL),
(6, 'Shamim', '01309606987', 'shamim@gmail.com', 2, 'fgvxfgxf', 1, '2023-01-02 10:48:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `director_profiles`
--
ALTER TABLE `director_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `director_profiles`
--
ALTER TABLE `director_profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
