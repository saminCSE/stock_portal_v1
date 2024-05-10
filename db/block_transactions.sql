-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2023 at 06:46 AM
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
-- Table structure for table `block_transactions`
--

CREATE TABLE `block_transactions` (
  `id` int NOT NULL,
  `instrument_id` int NOT NULL,
  `quantity` int NOT NULL,
  `value` decimal(10,5) NOT NULL,
  `trades` int NOT NULL,
  `max_price` decimal(10,5) NOT NULL,
  `min_price` decimal(10,5) NOT NULL,
  `transaction_date` date NOT NULL,
  `created_by` int UNSIGNED NOT NULL,
  `updated_by` int UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `block_transactions`
--

INSERT INTO `block_transactions` (`id`, `instrument_id`, `quantity`, `value`, `trades`, `max_price`, `min_price`, `transaction_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 124, '123.45600', 124, '1234.00000', '130.20000', '2022-11-30', 1, 1, '2022-11-30 15:47:07', '2022-11-30 15:48:41'),
(3, 30001, 123, '123.45600', 123, '123.44000', '123.00000', '2022-12-01', 1, 0, '2022-12-01 10:58:29', NULL),
(4, 30035, 123, '123.45600', 123, '123.44000', '140.40000', '2022-12-01', 1, 0, '2022-12-01 11:03:56', NULL),
(5, 157, 123, '123.45600', 123, '123.44000', '140.40000', '2022-12-01', 1, 0, '2022-12-01 11:04:23', NULL),
(6, 4, 233, '444.00000', 55, '666.00000', '777.00000', '2022-12-05', 1, 0, '2022-12-05 13:08:32', NULL),
(7, 513, 33, '44.00000', 43, '66.09900', '34.89990', '2022-12-05', 1, 0, '2022-12-05 15:04:38', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block_transactions`
--
ALTER TABLE `block_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block_transactions`
--
ALTER TABLE `block_transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
