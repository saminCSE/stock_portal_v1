-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2022 at 07:55 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sheba_trade`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `id_admin_group` tinyint(3) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `passwd` varchar(70) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login_time` datetime NOT NULL,
  `status` enum('ACTIVE','INACTIVE','PENDING') NOT NULL DEFAULT 'INACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_group`
--

CREATE TABLE `admin_group` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `name_bengali` varchar(100) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_name_bengali` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_name_bengali` varchar(100) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `spouse_name_bengali` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `national_id` varchar(50) DEFAULT NULL,
  `dob_id` varchar(25) DEFAULT NULL,
  `marital_status_id` tinyint(4) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `blood_group_id` int(11) DEFAULT NULL,
  `religion_id` int(11) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `prl_date` date DEFAULT NULL,
  `retired_date` date DEFAULT NULL,
  `passport` varchar(30) DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `home_district_id` int(11) DEFAULT NULL,
  `recruitment_type` varchar(30) DEFAULT NULL,
  `quota` varchar(40) DEFAULT NULL,
  `first_joining_date` date DEFAULT NULL,
  `first_joining_office_id` int(11) DEFAULT NULL,
  `first_joining_designation_id` int(11) DEFAULT NULL,
  `first_joining_grade` int(11) DEFAULT NULL,
  `present_office_joining_date` date DEFAULT NULL,
  `present_office_id` int(11) DEFAULT NULL,
  `present_grade` int(11) DEFAULT NULL,
  `scale_id` int(11) DEFAULT NULL,
  `present_designation_id` varchar(100) DEFAULT NULL,
  `additional_responsibility` int(11) DEFAULT NULL,
  `employee_type_id` int(11) DEFAULT NULL,
  `employee_status` int(11) DEFAULT NULL,
  `job_permanent_date` date DEFAULT NULL,
  `absorption_date` date DEFAULT NULL,
  `absorption_project_first_joining_date` date DEFAULT NULL,
  `absorption_project_name` varchar(100) DEFAULT NULL,
  `deputation_date` date DEFAULT NULL,
  `deputation_from` varchar(100) DEFAULT NULL,
  `deputation_to` varchar(100) DEFAULT NULL,
  `deputation_position` varchar(100) DEFAULT NULL,
  `per_address` mediumtext,
  `per_post_office` varchar(100) DEFAULT NULL,
  `per_district_id` int(11) DEFAULT NULL,
  `per_upazila_id` int(11) DEFAULT NULL,
  `present_address` mediumtext,
  `present_post_office` varchar(100) DEFAULT NULL,
  `present_district_id` int(11) DEFAULT NULL,
  `present_upazila_id` int(11) DEFAULT NULL,
  `present_post_code` varchar(10) DEFAULT NULL,
  `per_post_code` varchar(10) DEFAULT NULL,
  `department_id` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `employee_id`, `code`, `name`, `name_bengali`, `father_name`, `father_name_bengali`, `mother_name`, `mother_name_bengali`, `spouse_name`, `spouse_name_bengali`, `photo`, `signature`, `birth_date`, `national_id`, `dob_id`, `marital_status_id`, `gender_id`, `blood_group_id`, `religion_id`, `phone`, `mobile`, `email`, `prl_date`, `retired_date`, `passport`, `tin`, `home_district_id`, `recruitment_type`, `quota`, `first_joining_date`, `first_joining_office_id`, `first_joining_designation_id`, `first_joining_grade`, `present_office_joining_date`, `present_office_id`, `present_grade`, `scale_id`, `present_designation_id`, `additional_responsibility`, `employee_type_id`, `employee_status`, `job_permanent_date`, `absorption_date`, `absorption_project_first_joining_date`, `absorption_project_name`, `deputation_date`, `deputation_from`, `deputation_to`, `deputation_position`, `per_address`, `per_post_office`, `per_district_id`, `per_upazila_id`, `present_address`, `present_post_office`, `present_district_id`, `present_upazila_id`, `present_post_code`, `per_post_code`, `department_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'adfa001', NULL, 'Md. Aminir rahman', 'Md. Aminur rahman', 'Md. Siddiquer rahman', 'Md. Siddiquer rahman', 'Khodeza begum', 'Khodeza begum', 'Shahnaz Sharmin', 'Shahnaz Sharmin', '333497_819453Rectangle_525_7.png', '227586_1637150794.png', '1989-01-01', '6767457457474', NULL, 2, 1, 2, 1, '016740985047', '016740985047', 'amin1993@hotmail.com', '2021-08-31', '2021-08-31', '', '', 1, '0', 'no', '2021-06-01', 0, 0, 0, '1970-01-01', 0, 10, 10, '4', NULL, 1, 1, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 0, 0, '', '', 0, 0, '', '', 1, NULL, '2021-08-09 15:28:55', '2021-08-09 03:28:55'),
(2, 16, '22200', NULL, 'Golam Zakaria', 'গোলাম জাকারিয়া', 'Golam Zakaria', 'গোলাম জাকারিয়া', 'Golam Zakaria', 'গোলাম জাকারিয়া', 'Golam Zakaria', 'গোলাম জাকারিয়া', '319038_669205mobarakweeding.jpeg', NULL, '1995-01-01', '6767457457474', NULL, 1, 1, 1, 1, '016740985047', '016740985047', 'zakaria.novo@gmail.com', '2021-09-30', '2021-09-21', '345435345345345', '768969696986796', 1, '0', 'no', '2019-01-01', 0, 0, 0, '1970-01-01', 0, 9, 21, '3', NULL, 1, 1, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', 'Dhaka', 'গোলাম জাকারিয়া', 0, 0, 'Dhaka', 'গোলাম জাকারিয়া', 0, 0, '1212', '1212', 2, NULL, '2021-09-19 08:01:14', '2021-09-18 20:01:14'),
(3, 15, 'asdfas110', NULL, 'Mobarak hossen', 'mobarak', 'aslam miah', 'aslam miah', 'karkuler nessa', 'karkulre nessa', 'sharmin', 'sharmin', '510024_510225Rectangle_525_2.png', '357382_363161_381675Rectangle_525_2.png', '1979-01-01', '22222222222', '', 2, 1, 1, 1, '01882447362', '01882447362', '', '2030-12-01', '2030-12-01', '', '333333', 18, '0', 'ff', '2021-11-01', 0, 0, 0, '1970-01-01', 0, 1, 16, '6', 7, 1, 1, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', 'dhaka', 'cumilla post office', 0, 0, 'dhaka', 'dhaka post office', 0, 0, '1200', '1300', 3, NULL, '2021-11-16 11:55:31', '2021-11-15 23:55:31'),
(4, 13, '100100', NULL, 'Mobarak Hossen', 'mboarak', 'aslam miah', 'alsdkj', 'lkjsalkdjf', 'lkjsakldjf', '', '', '338985_133280Rectangle_525_5.png', '923679_271794_607159Rectangle_525_5.png', '2016-02-04', 'lklsakjdflk', NULL, 0, 1, 0, 0, '01882447362', '01882447362', 'mobarakhossen2013@gmail.com', '2074-02-03', '2075-02-03', '', '', 0, '0', NULL, '2021-11-01', 0, 0, 0, '1970-01-01', 0, 16, NULL, '', NULL, 1, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', 'sdfa', '', 0, 0, 'sdfas', '', 0, 0, '', '', 1, NULL, '2021-11-16 16:20:16', '2021-11-16 04:20:16'),
(5, 17, 'Are001', NULL, 'Ekramul Haque', 'Ekramul Haque', '', '', '', '', '', '', '351694_970066Ekramul_Haque_Picture.jpg', NULL, '2021-11-02', '', NULL, 2, 1, 0, 0, '+8801758871165', '', 'ekramul.haque@arena.com.bd', '2021-11-17', '2021-11-17', '', '', 0, '0', NULL, '2021-07-01', 0, 0, 0, '1970-01-01', 0, 0, NULL, '', NULL, 0, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 0, 0, '', '', 0, 0, '', '', 2, NULL, '2021-11-17 12:11:57', '2021-11-17 00:11:57'),
(6, 18, '50001', NULL, 'Arena', 'Arena', 'Arena', 'Arena', 'Arena', 'Arena', '', '', '326954_596672', NULL, '2021-11-10', '97897576754653', NULL, 0, 1, 0, 1, '016740985044', '016740985048', 'amin955@gmail.com', '2079-11-09', '2080-11-09', '', '', 1, '0', NULL, '2020-01-22', 0, 0, 0, '1970-01-01', 0, 0, NULL, '', NULL, 1, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 1, 0, '', '', 1, 0, '', '', 2, NULL, '2021-11-17 16:31:19', '2021-11-17 04:31:19'),
(7, 19, '5009', NULL, 'Arena-2', 'Arena-2', 'Arena-2', 'Arena-2', 'Arena-2', 'Arena-2', '', '', '658222_771359AminPassportsize.jpg', NULL, '2021-11-03', '64564645765865', NULL, 0, 1, 0, 1, '016740985047', '016740985047', 'amin95@gmail.com', '2079-11-02', '2080-11-02', '34534535', '', 1, '0', NULL, '2021-11-01', 0, 0, 0, '1970-01-01', 0, 2, NULL, '', NULL, 1, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '1212', 0, 0, '', '1212', 0, 0, '', '', 2, NULL, '2021-11-17 17:28:39', '2021-11-17 05:28:39'),
(8, 20, 'em007', NULL, 'Arena-3', 'Arena-3', 'Arena-3', 'Arena-3', 'Arena-3', 'Arena-3', 'Arena-3', 'Arena-3', '218918_694016AminPassportsize.jpg', '251180_1637233413.jpg', '1973-01-01', '3424234234234', NULL, 1, 2, 6, 1, '016740985049', '016740985049', 'amin953@gmail.com', '2030-12-31', '2031-12-31', '53435434', '654645645654', 1, '0', 'other', '1984-01-01', 0, 0, 0, '1970-01-01', 0, 2, 18, '6', NULL, 1, 1, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', 'arena-3', '1212', 1, 147, 'arena-3', '1212', 1, 147, '1212', '1212', 1, NULL, '2021-11-18 17:01:33', '2021-11-18 05:01:33'),
(9, 25, 'Arena001', NULL, 'Nabarun Debnath', 'নবারুণ দেবনাথ', 'Amit Shah', 'Amit Shah', '', '', '', '', '846465_483853', '768584_307466_985808', '2021-12-05', '', NULL, 0, 0, 0, 0, '', '', '', '2079-12-04', '2080-12-04', '', '', 0, '0', NULL, '2021-11-25', 0, 0, 0, '1970-01-01', 0, 0, NULL, '', NULL, 0, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 0, 0, '', '', 0, 0, '', '', 1, NULL, '2021-11-19 14:40:05', '2021-11-19 02:40:05'),
(10, 23, 'ARENA00001', NULL, 'Raju', 'রাজু', 'Amit Shah', 'Amit Shah', 'Most.Robeya Khatun', 'রাবেয়া', '', '', '659615_2602944244243685_drdummydemocartoonhumanfacepngtransparent.png', '700896_401750_400514', '2021-11-01', '19957610563000061', NULL, 0, 1, 0, 1, '+8801758871165', '+8801758871165', 'ekramul.haque@arena.com.bd', '2079-10-31', '2080-10-31', '', '', 2, '0', NULL, '2021-06-01', 0, 0, 0, '1970-01-01', 0, 0, NULL, '', NULL, 0, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 2, 0, '', '', 2, 0, '', '', 1, NULL, '2021-11-19 15:09:32', '2021-11-19 03:09:32'),
(11, 24, 'ARENA00003', NULL, 'Humayun Kabir', '', 'Md. Nabab Ali', '', '', '', '', '', '352436_8677264244243685_drdummydemocartoonhumanfacepngtransparent.png', '386294_265617_959964', '2021-01-06', '', NULL, 0, 0, 0, 0, '', '', '', '2079-01-05', '2080-01-05', '', '', 0, '0', NULL, '2019-01-14', 0, 0, 0, '1970-01-01', 0, 11, NULL, '', NULL, 0, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 0, 0, '', '', 0, 0, '', '', 3, NULL, '2021-11-19 15:15:06', '2021-11-19 03:15:06'),
(12, 22, 'ARENA00005', NULL, 'Fahima Sultana Choity', '', '', '', '', '', '', '', '297200_2025404244243685_drdummydemocartoonhumanfacepngtransparent.png', '352835_738229_759415', '2021-01-01', '19957610563000061', '3333333333333333333', 2, 0, 0, 0, '', '', '', '2078-12-31', '2079-12-31', '', '', 0, '0', NULL, '2015-12-29', 0, 0, 0, '1970-01-01', 0, 11, NULL, '', NULL, 0, 0, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', '', '', 0, 0, '', '', 0, 0, '', '', 3, NULL, '2021-11-19 15:17:31', '2021-11-19 03:17:31'),
(13, 12, 'asdfasfa', NULL, 'sdfa', 'sfasfa', 'sadfasf', 'asdfasf', 'asdfasf', 'sfdsafas', 'sdfasfa', 'sadfasfas', '915908_885044BangabandhuSheikhMujiburRahmanNovoTheatre770x420.jpg', '433440_745085_129248', '2021-11-01', 'sdfasf', NULL, 1, 1, 6, 1, 'sadfas', 'asdfasf', 'sadfasfa', '2079-10-31', '2080-10-31', 'ssadfsafas', '', 17, '0', 'ff', '2021-11-01', 0, 0, 0, '1970-01-01', 0, 2, 335, '7', NULL, 1, 1, '1970-01-01', '1970-01-01', '1970-01-01', '', '1970-01-01', '', '', '', 'sdfasfa', 'safa', 3, 160, 'sdfasfa', 'sadfasfa', 2, 156, 'fasfa', 'sadfas', 1, NULL, '2021-11-23 12:01:59', '2021-11-23 00:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `designation_id` varchar(40) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `module_link` varchar(100) NOT NULL,
  `order` tinyint(4) NOT NULL,
  `status` enum('PUBLISH','UNPUBLISH') NOT NULL,
  `icon` varchar(50) NOT NULL,
  `icon_color` varchar(20) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active , 0= deactive',
  `orderno` tinyint(1) NOT NULL DEFAULT '0',
  `project_no` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1= laravel, 2= codeigniter\r\n',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `slug`, `icon_id`, `parent_id`, `is_active`, `orderno`, `project_no`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Global Setting', NULL, 'fas fa-tools', 0, 1, 2, 1, NULL, 1, NULL, '2021-07-08 01:09:02'),
(3, 'Office', 'office', NULL, 2, 1, 1, 1, NULL, 1, NULL, '2021-07-08 03:12:04'),
(4, 'Store', 'storesetup', NULL, 2, 1, 1, 1, NULL, 1, NULL, '2021-07-08 03:12:40'),
(5, 'Vendor', 'vendor', NULL, 2, 1, 3, 1, NULL, 1, NULL, '2021-07-08 03:13:16'),
(6, 'Measurment Unit', 'measurmentunit', NULL, 2, 1, 4, 1, NULL, 1, NULL, '2021-07-08 03:13:53'),
(7, 'Location', 'location', NULL, 2, 0, 6, 1, NULL, 1, NULL, '2021-11-07 23:45:47'),
(8, 'Item Type', 'itemtype', NULL, 2, 1, 6, 1, NULL, 1, NULL, '2021-07-08 03:14:52'),
(9, 'Item Category', 'itemcategory', NULL, 2, 1, 7, 1, NULL, 1, NULL, '2021-07-08 03:15:19'),
(10, 'Item', 'item', NULL, 2, 1, 8, 1, NULL, 1, NULL, '2021-07-08 03:11:17'),
(11, 'Purchase', 'purchase.index', 'fab fa-palfed', 0, 1, 3, 1, NULL, 1, NULL, '2021-07-08 01:01:18'),
(12, 'Acquisition', 'acquisition.index', 'fab fa-palfed', 0, 1, 4, 1, NULL, 1, NULL, '2021-07-07 20:30:13'),
(13, 'Stock', 'stock.index', 'fab fa-palfed', 0, 1, 5, 1, NULL, 1, NULL, '2021-07-07 20:31:46'),
(14, 'Current Inventory', 'inventory/currentinventory', NULL, 13, 1, 1, 1, NULL, 1, NULL, '2021-07-14 06:50:54'),
(15, 'Stock', 'stock', NULL, 13, 1, 2, 1, NULL, 1, NULL, '2021-07-08 03:20:48'),
(16, 'Stock Adjustment', 'stockadjust.index', 'fab fa-palfed', 0, 1, 6, 1, NULL, 1, NULL, '2021-07-07 20:35:39'),
(17, 'Stock Adjust Add', 'stockadjust', NULL, 16, 1, 1, 1, NULL, 1, NULL, '2021-07-08 03:23:08'),
(18, 'Stock Adjust List', 'stockadjust', NULL, 16, 1, 2, 1, NULL, 1, NULL, '2021-07-08 03:22:52'),
(19, 'Item Issue', 'itemissue.index', 'fab fa-palfed', 0, 0, 7, 1, NULL, 1, NULL, '2021-11-19 04:21:08'),
(20, 'Item Issue', 'itemissue', NULL, 19, 0, 1, 1, NULL, 1, NULL, '2021-11-19 04:20:14'),
(21, 'Employee Management', NULL, 'fab fa-palfed', 0, 1, 13, 2, 1, 1, '2021-07-06 03:08:27', '2021-07-07 21:01:22'),
(23, 'Employee List', 'employee_management', NULL, 21, 1, 2, 2, 1, 1, '2021-07-06 03:11:05', '2021-07-07 02:33:14'),
(24, 'Employee Add', 'employee_management/add_employee', NULL, 21, 1, 1, 2, 1, 1, '2021-07-06 03:21:12', '2021-07-07 02:32:52'),
(25, 'Employee Education', 'brief_management/education_view', 'fab fa-palfed', 0, 1, 14, 2, 1, 1, '2021-07-07 02:36:10', '2021-07-07 21:01:52'),
(26, 'Add education', 'brief_management/add', NULL, 25, 1, 1, 2, 1, NULL, '2021-07-07 02:36:57', '2021-07-07 02:36:57'),
(27, 'Employee Education List', 'brief_management', NULL, 25, 1, 2, 2, 1, NULL, '2021-07-07 02:37:28', '2021-07-07 02:37:28'),
(28, 'Training', 'brief_description/training_view', 'fab fa-palfed', 0, 1, 15, 2, 1, 1, '2021-07-07 02:38:16', '2021-07-07 21:10:00'),
(29, 'Add Training', 'brief_description/add', NULL, 28, 1, 1, 2, 1, NULL, '2021-07-07 02:38:52', '2021-07-07 02:38:52'),
(30, 'Employee Training List', 'brief_description', NULL, 28, 1, 2, 2, 1, NULL, '2021-07-07 02:39:28', '2021-07-07 02:39:28'),
(31, 'Employee Children', 'brief_description_children/view_children', 'fab fa-palfed', 0, 1, 16, 2, 1, 1, '2021-07-07 02:40:04', '2021-07-07 21:10:35'),
(32, 'Add Children', 'brief_description_children/add', NULL, 31, 1, 1, 2, 1, NULL, '2021-07-07 02:40:42', '2021-07-07 02:40:42'),
(33, 'Children List', 'brief_description_children', NULL, 31, 1, 2, 2, 1, NULL, '2021-07-07 02:41:20', '2021-07-07 02:41:20'),
(34, 'Document Management', 'brief_doc_management/view_document', 'fab fa-palfed', 0, 1, 17, 2, 1, 1, '2021-07-07 02:42:08', '2021-07-07 21:11:15'),
(35, 'Document Add', 'brief_doc_management/add', NULL, 34, 1, 1, 2, 1, NULL, '2021-07-07 02:42:43', '2021-07-07 02:42:43'),
(36, 'Document List', 'brief_doc_management', NULL, 34, 1, 2, 2, 1, NULL, '2021-07-07 02:43:30', '2021-07-07 02:43:30'),
(37, 'Dashboard', NULL, 'fab fa-palfed', 0, 1, 1, 1, 1, 1, '2021-07-07 20:23:01', '2021-07-08 04:21:51'),
(38, 'Scale', 'scale', NULL, 2, 1, 8, 1, 1, 1, '2021-07-07 20:27:36', '2021-07-08 03:08:52'),
(39, 'Purchase', 'purchase', NULL, 11, 1, 1, 1, 1, 1, '2021-07-07 20:29:24', '2021-07-08 03:16:38'),
(40, 'Acquisition', 'acquisition', NULL, 12, 1, 1, 1, 1, 1, '2021-07-07 20:31:15', '2021-07-08 03:18:32'),
(41, 'Notify Item', 'stock/notify', NULL, 13, 1, 3, 1, 1, 1, '2021-07-07 20:33:19', '2021-07-14 18:01:49'),
(42, 'User Management', NULL, 'fab fa-palfed', 0, 1, 8, 1, 1, NULL, '2021-07-07 20:37:28', '2021-07-07 20:37:28'),
(43, 'User', 'user', NULL, 42, 1, 1, 1, 1, 1, '2021-07-07 20:37:50', '2021-07-13 23:12:28'),
(44, 'Salary Setup', NULL, 'fab fa-palfed', 0, 1, 8, 1, 1, NULL, '2021-07-07 20:38:25', '2021-07-07 20:38:25'),
(45, 'Promotion', 'promotion', NULL, 44, 1, 1, 1, 1, 1, '2021-07-07 20:38:47', '2021-07-08 03:25:12'),
(46, 'List of salary', 'salarysetup', NULL, 44, 1, 2, 1, 1, 1, '2021-07-07 20:39:14', '2021-07-08 03:26:13'),
(47, 'Change Salary Setup', 'salarysetup', NULL, 44, 1, 3, 1, 1, 1, '2021-07-07 20:41:29', '2021-07-08 03:25:48'),
(48, 'Loan', NULL, 'fab fa-palfed', 0, 1, 9, 1, 1, NULL, '2021-07-07 20:41:52', '2021-07-07 20:41:52'),
(49, 'Loan', 'loan', NULL, 48, 1, 1, 1, 1, 1, '2021-07-07 20:42:20', '2021-07-08 03:26:55'),
(50, 'Opening Recovery Balance', 'openbalancerecovery', NULL, 48, 1, 2, 1, 1, 1, '2021-07-07 20:42:46', '2021-07-08 03:27:35'),
(51, 'Salary', NULL, 'fab fa-palfed', 0, 1, 10, 1, 1, NULL, '2021-07-07 20:43:15', '2021-07-07 20:43:15'),
(52, 'Generate Salary', 'salary', NULL, 51, 1, 1, 1, 1, 1, '2021-07-07 20:44:03', '2021-07-08 03:28:50'),
(53, 'Salalry List', 'salary', NULL, 51, 1, 2, 1, 1, 1, '2021-07-07 20:44:34', '2021-07-08 03:29:28'),
(54, 'Salalry Print', 'salaryprint', NULL, 51, 1, 3, 1, 1, 1, '2021-07-07 20:45:09', '2021-07-11 20:02:25'),
(55, 'Salalry Slip', 'salaryslip', NULL, 51, 1, 4, 1, 1, 1, '2021-07-07 20:46:21', '2021-07-11 20:07:32'),
(56, 'Leave', NULL, 'fab fa-palfed', 0, 1, 11, 1, 1, NULL, '2021-07-07 20:47:10', '2021-07-07 20:47:10'),
(57, 'Basic Setup', 'leavesetup', NULL, 56, 1, 1, 1, 1, 1, '2021-07-07 20:47:50', '2021-07-08 03:32:34'),
(58, 'Leave Request', 'leaverequest', NULL, 56, 1, 2, 1, 1, 1, '2021-07-07 20:49:26', '2021-07-08 03:33:32'),
(59, 'Request List', 'leaverequest', NULL, 56, 1, 3, 1, 1, 1, '2021-07-07 20:50:08', '2021-07-08 03:34:26'),
(60, 'Request Approval', 'leaveapproved', NULL, 56, 1, 4, 1, 1, 1, '2021-07-07 20:50:43', '2021-07-08 03:34:53'),
(61, 'Leave History', 'leaverequest', NULL, 56, 1, 5, 1, 1, 1, '2021-07-07 20:51:21', '2021-07-08 03:35:22'),
(62, 'Task', NULL, 'fab fa-palfed', 0, 1, 12, 1, 1, NULL, '2021-07-07 20:51:55', '2021-07-07 20:51:55'),
(63, 'Task Create', 'task/create', NULL, 62, 1, 1, 1, 1, 1, '2021-07-07 20:52:41', '2021-07-11 20:51:58'),
(64, 'Task List', 'task', NULL, 62, 1, 2, 1, 1, 1, '2021-07-07 20:53:22', '2021-07-08 03:36:52'),
(65, 'Task Assign', 'taskassign', NULL, 62, 1, 3, 1, 1, 1, '2021-07-07 20:54:29', '2021-07-08 03:37:23'),
(66, 'My Task', 'mytaskassign', NULL, 62, 1, 4, 1, 1, 1, '2021-07-07 20:55:09', '2021-07-08 03:37:44'),
(67, 'Task Report', 'taskassign', NULL, 62, 1, 5, 1, 1, 1, '2021-07-07 20:55:45', '2021-07-08 03:38:03'),
(68, 'Menu', NULL, 'fab fa-palfed', 0, 1, 18, 1, 1, NULL, '2021-07-08 01:22:07', '2021-07-08 01:22:07'),
(69, 'Menu Add', 'menu/create', NULL, 68, 1, 1, 1, 1, 1, '2021-07-08 01:22:52', '2021-07-11 20:52:21'),
(70, 'Menu List', 'menu', NULL, 68, 1, 2, 1, 1, 1, '2021-07-08 01:23:27', '2021-07-08 04:21:11'),
(71, 'Role Menu Add', 'rolemenu/create', NULL, 68, 1, 3, 1, 1, 1, '2021-07-08 01:23:53', '2021-07-13 23:03:14'),
(72, 'Role Menu List', 'rolemenu', NULL, 68, 1, 4, 1, 1, 1, '2021-07-08 01:24:18', '2021-07-13 23:02:58'),
(73, 'Permission', NULL, 'fab fa-palfed', 0, 1, 19, 1, 1, NULL, '2021-07-18 21:27:41', '2021-07-18 21:27:41'),
(74, 'Permission Label', 'permissionlabel', NULL, 73, 1, 1, 1, 1, NULL, '2021-07-18 21:28:41', '2021-07-18 21:28:41'),
(75, 'Role Permission', 'permissionrole', NULL, 73, 1, 2, 1, 1, NULL, '2021-07-18 21:29:41', '2021-07-18 21:29:41'),
(76, 'Monthly Allotment', 'monthlyallotment/create', NULL, 2, 1, 9, 1, 1, 1, '2021-11-08 22:36:54', '2021-11-09 07:00:42'),
(77, 'Report', NULL, 'fab fa-palfed', 0, 1, 20, 1, 1, 1, '2021-11-09 07:46:55', '2021-11-09 07:53:27'),
(78, 'Current Inventory', 'report/currentinventory', NULL, 77, 1, 1, 1, 1, 1, '2021-11-09 07:47:58', '2021-11-09 23:28:33'),
(79, 'Challan Report', 'report/challan', NULL, 77, 1, 2, 1, 1, 1, '2021-11-09 07:48:32', '2021-11-09 23:21:05'),
(80, 'Item Requisition', NULL, 'fab fa-palfed', 0, 1, 7, 1, 1, NULL, '2021-11-10 00:38:59', '2021-11-10 00:38:59'),
(81, 'Requisition Add', 'itemrequisition/create', 'fab fa-palfed', 80, 1, 2, 1, 1, 1, '2021-11-10 00:53:45', '2021-11-10 01:27:43'),
(82, 'Requisition List', 'itemrequisition', NULL, 80, 1, 1, 1, 1, NULL, '2021-11-10 00:55:58', '2021-11-10 00:55:58'),
(83, 'Item Issue to Staff', NULL, 'fab fa-palfed', 0, 1, 7, 1, 1, 1, '2021-11-10 00:56:50', '2021-11-19 04:21:58'),
(84, 'Item Issue to List', 'itemissueemp', NULL, 83, 1, 1, 1, 1, 1, '2021-11-10 00:58:00', '2021-11-19 04:53:14'),
(85, 'Item Issue Add', 'itemissueemp/create', NULL, 83, 0, 2, 1, 1, 1, '2021-11-10 01:02:06', '2021-11-16 08:30:21'),
(86, 'Designation', 'designation', NULL, 2, 1, 10, 1, 1, NULL, '2021-11-16 03:41:20', '2021-11-16 03:41:20'),
(87, 'Abroad Tour', NULL, 'fab fa-palfed', 0, 1, 17, 1, 1, NULL, '2021-12-30 06:34:46', '2021-12-30 06:34:46'),
(88, 'Abroad Tour Add', 'abroadtour/create', NULL, 87, 1, 1, 1, 1, 1, '2021-12-30 06:35:35', '2021-12-30 06:40:36'),
(89, 'Abroad Tour List', 'abroadtour', NULL, 87, 1, 2, 1, 1, 1, '2021-12-30 06:36:16', '2021-12-30 06:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_04_27_042057_create_settings_table', 2),
(5, '2021_04_28_091611_create_tokens_table', 3),
(7, '2021_04_28_093010_create_token_statistics_table', 4),
(8, '2021_05_02_061002_create_vendors_table', 5),
(10, '2021_05_02_061839_create_locations_table', 6),
(11, '2021_05_02_070230_create_items_table', 7),
(12, '2021_05_03_072154_added_table_vendor_created_updateby', 8),
(13, '2021_05_04_090721_create_purchases_table', 9),
(14, '2021_05_04_090743_create_purchase_items_table', 10),
(15, '2021_05_11_051907_create_acquisition_table', 11),
(17, '2021_05_11_060706_create_acquisition_items_table', 12),
(18, '2021_05_12_044057_create_acquisition_invoices_table', 13),
(19, '2021_05_12_100106_create_stocks_table', 14),
(20, '2021_05_12_105416_create_stock_histories_table', 15),
(22, '2021_05_16_093738_added_acquisition_items_serial_number', 16),
(23, '2021_05_19_090442_alter_acquisition_items_is_stock', 17),
(24, '2021_05_20_085838_create_stock_adjusts_table', 18),
(25, '2021_05_20_095348_alter_stock_adjust_approved_datetime', 19),
(26, '2021_05_23_101037_create_item_issues_table', 20),
(27, '2021_05_23_111311_create_item_issue_contents_table', 21),
(29, '2021_05_24_052958_alter_items_is_serial_no', 23),
(30, '2021_05_25_051824_alter_item_issue_contents_serial_no', 24),
(31, '2021_05_25_054234_alter_acquisition_items_is_assign', 25),
(32, '2021_05_26_070013_alter_item_issues_sote_id', 26),
(33, '2021_05_26_094500_create_transfer_orders_table', 27),
(34, '2021_05_26_115310_alter_item_issue_remarks', 28),
(35, '2021_05_26_131025_create_stock_details_table', 29),
(36, '2021_06_01_072816_create_menus_table', 30),
(37, '2021_06_01_073337_create_permission_tables', 30),
(38, '2021_06_01_082940_create_role_menus_table', 31),
(39, '2021_06_02_114825_alter_users_role_id', 32),
(40, '2021_06_10_085752_alter_users_status', 33),
(41, '2021_06_14_060448_alter_role_active_status', 34),
(42, '2021_06_14_093827_create_scales_table', 35),
(43, '2021_06_15_090125_create_promotions_table', 36),
(44, '2021_06_17_053704_create_salary_setups_table', 37),
(45, '2021_06_20_054418_create_employee_loan_balances_table', 38),
(46, '2021_06_21_071225_create_salary_summaries_table', 39),
(47, '2021_06_21_090303_create_salary_details_table', 40),
(48, '2021_06_21_101556_alter_users_office_id', 41),
(50, '2021_06_22_060931_alter_salary_summary_office_id', 42),
(51, '2021_06_24_052840_create_leave_requests_table', 43),
(52, '2021_06_27_060634_create_task_types_table', 44),
(53, '2021_06_27_060929_create_tasks_table', 45),
(54, '2021_06_27_061315_create_task_assigns_table', 46),
(55, '2021_06_28_040317_alter_items_notify_number', 47),
(57, '2021_06_28_061446_alter_users_store_id', 48),
(58, '2021_07_04_042706_alter_item_categorys_type_id', 49),
(62, '2021_07_19_060158_alter_item_monthly_max_issue', 50),
(63, '2021_07_19_065103_alter_item_issue_issue_date', 50),
(64, '2021_11_09_060311_create_grade_allotments_table', 50),
(65, '2021_11_09_062658_alter_grade_allotment_change_grade_id', 51),
(66, '2021_11_09_132022_alter_items_allotment_type', 52),
(69, '2021_11_10_083258_create_item_requisitions_table', 53),
(70, '2021_11_10_094229_create_item_requisition_contents_table', 53);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(1, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25);

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text,
  `active_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1= active , 0 = deactive',
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `name`, `phone`, `email`, `address`, `active_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'test', NULL, 'amin1993@hotmail.com', 'test', 1, 1, '2021-08-09 05:09:53', NULL, '2021-08-09 05:09:53'),
(2, 'Bangabandhu Sheikh Mujibur Rahman Novo Theatre', '880-1674985047', 'amin95@gmail.com', 'Dhaka', 1, 1, '2021-08-12 02:39:58', NULL, '2021-08-12 02:39:58'),
(7, 'Arena Phone Bd Ltd', '+8801758871165', 'ekramul.haque@arena.com.bd', 'Dhaka Gulshan', 1, 1, '2021-11-16 22:31:05', NULL, '2021-11-16 22:31:05'),
(8, 'mobarak hossen', '01882447362', 'mobarakhossen2013@gmail.com', 'dhaka', 1, 1, '2021-11-16 23:02:28', NULL, '2021-11-16 23:02:28'),
(9, 'Ad65', '+8801758871165', 'ekramulcsediu2016@gmail.com', 'Mohakhali', 1, 1, '2021-11-17 07:26:49', 1, '2021-11-17 01:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `label_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'office list', 'office list', 'web', NULL, '2021-11-17 07:05:29'),
(3, 'office delete', 'office delete', 'web', NULL, '2021-11-17 07:12:39'),
(4, 'office show', 'office show', 'web', NULL, '2021-11-17 07:08:34'),
(9, 'vendor list', 'vendor list', 'web', NULL, '2021-11-17 07:11:36'),
(10, 'vendor create', 'vendor create', 'web', NULL, '2021-11-17 07:11:53'),
(11, 'vendor delete', 'vendor delete', 'web', NULL, '2021-11-17 07:12:15'),
(12, 'vendor show', 'vendor show', 'web', NULL, '2021-11-17 07:12:58'),
(13, 'measurmentunit list', 'measurmentunit list', 'web', NULL, '2021-11-17 07:13:24'),
(14, 'measurmentunit create', 'measurmentunit create', 'web', NULL, '2021-11-17 07:13:41'),
(15, 'measurmentunit delete', 'measurmentunit delete', 'web', NULL, '2021-11-17 07:13:58'),
(16, 'measurmentunit show', 'measurmentunit show', 'web', NULL, '2021-11-17 07:14:42'),
(17, 'location list', 'location list', 'web', NULL, '2021-11-17 07:15:40'),
(18, 'location create', 'location create', 'web', NULL, '2021-11-17 07:16:00'),
(19, 'location delete', 'location delete', 'web', NULL, '2021-11-17 07:16:17'),
(20, 'location show', 'location show', 'web', NULL, '2021-11-17 07:16:33'),
(21, 'itemtype list', 'itemtype list', 'web', NULL, '2021-11-17 07:16:59'),
(22, 'itemtype create', 'itemtype create', 'web', NULL, '2021-11-17 07:17:22'),
(23, 'itemtype delete', 'itemtype delete', 'web', NULL, '2021-11-17 07:17:39'),
(24, 'itemtype show', 'itemtype show', 'web', NULL, '2021-11-17 07:18:00'),
(25, 'itemcategory list', 'itemcategory list', 'web', NULL, '2021-11-17 07:18:22'),
(26, 'itemcategory create', 'itemcategory create', 'web', NULL, '2021-11-17 07:18:40'),
(27, 'itemcategory delete', 'itemcategory delete', 'web', NULL, '2021-11-17 07:19:06'),
(28, 'itemcategory show', 'itemcategory show', 'web', NULL, '2021-11-17 07:19:32'),
(29, 'item list', 'item list', 'web', NULL, '2021-11-17 07:19:52'),
(30, 'item create', 'item create', 'web', NULL, '2021-11-17 07:20:12'),
(31, 'item delete', 'item delete', 'web', NULL, '2021-11-17 07:20:38'),
(32, 'item show', 'item show', 'web', NULL, '2021-11-17 07:20:55'),
(33, 'purchase list', 'purchase list', 'web', NULL, '2021-11-17 07:21:16'),
(34, 'purchase create', 'purchase create', 'web', NULL, '2021-11-17 07:21:38'),
(35, 'purchase delete', 'purchase delete', 'web', NULL, '2021-11-17 07:21:56'),
(36, 'purchase show', 'purchase show', 'web', NULL, '2021-11-17 07:25:05'),
(37, 'purchase details-purchase', 'purchase details-purchase', 'web', NULL, '2021-11-17 07:25:36'),
(38, 'acquisition list', 'acquisition list', 'web', NULL, '2021-11-17 07:25:55'),
(39, 'acquisition create', 'acquisition create', 'web', NULL, '2021-11-17 07:26:12'),
(40, 'acquisition delete', 'acquisition delete', 'web', NULL, '2021-11-17 07:26:36'),
(41, 'acquisition show', 'acquisition show', 'web', NULL, '2021-11-17 07:26:58'),
(42, 'acquisition details-acquisition', 'acquisition details-acquisition', 'web', NULL, '2021-11-17 07:27:20'),
(43, 'inventory list', 'inventory list', 'web', NULL, '2021-11-17 07:27:38'),
(44, 'inventory search-inventory', 'inventory search-inventory', 'web', NULL, '2021-11-17 07:28:02'),
(45, 'stock list', 'stock list', 'web', NULL, '2021-11-17 07:28:22'),
(46, 'stock create', 'stock create', 'web', NULL, '2021-11-17 07:29:04'),
(47, 'stock delete', 'stock delete', 'web', NULL, '2021-11-17 07:29:26'),
(48, 'stock show', 'stock show', 'web', NULL, '2021-11-17 07:29:51'),
(49, 'stockadjust list', 'stockadjust list', 'web', NULL, '2021-11-17 07:30:13'),
(50, 'stockadjust create', 'stockadjust create', 'web', NULL, '2021-11-17 07:30:36'),
(51, 'stockadjust delete', 'stockadjust delete', 'web', NULL, '2021-11-17 07:31:00'),
(52, 'stockadjust show', 'stockadjust show', 'web', NULL, '2021-11-17 07:31:18'),
(54, 'itemissue list', 'itemissue list', 'web', NULL, '2021-11-17 07:32:06'),
(55, 'itemissue create', 'itemissue create', 'web', NULL, '2021-11-17 07:32:26'),
(56, 'itemissue delete', 'itemissue delete', 'web', NULL, '2021-11-17 07:32:52'),
(57, 'itemissue show', 'itemissue show', 'web', NULL, '2021-11-17 07:33:52'),
(58, 'purchase edit', 'purchase edit', 'web', NULL, '2021-11-17 07:34:13'),
(59, 'purchase.searchItem', 'purchase.searchItem', '', NULL, '2021-11-17 07:34:54'),
(60, 'purchase.deletePurchaseItem', 'purchase.deletePurchaseItem', '', NULL, '2021-11-17 07:35:19'),
(61, 'purchase.DetailsPurchaseInfo', 'purchase.DetailsPurchaseInfo', 'web', NULL, '2021-11-17 07:35:38'),
(62, 'purchase.getPurhcaseItem', 'purchase.getPurhcaseItem', 'web', NULL, '2021-11-17 07:36:04'),
(63, 'acquisition.deleteAcquisitionItem', 'acquisition.deleteAcquisitionItem', 'web', NULL, '2021-11-17 07:36:32'),
(64, 'acquisition.DetailsAcquisitionInfo', 'acquisition.DetailsAcquisitionInfo', 'web', NULL, '2021-11-17 07:37:06'),
(65, 'acquisition.getItemFilter', 'acquisition.getItemFilter', 'web', NULL, '2021-11-17 07:37:26'),
(66, 'inventory.currentInventory', 'inventory.currentInventory', 'web', NULL, '2021-11-17 07:40:29'),
(67, 'inventory.searchCurrentInventory', 'inventory.searchCurrentInventory', 'web', NULL, '2021-11-17 07:40:47'),
(68, 'stockadjust.approval', 'stockadjust.approval', 'web', NULL, '2021-11-17 07:41:35'),
(69, 'itemissue.getItemSerialNo', 'itemissue.getItemSerialNo', 'web', NULL, '2021-11-17 07:42:00'),
(70, 'itemissue.deleteItemIssueContent', 'itemissue.deleteItemIssueContent', 'web', NULL, '2021-11-17 07:45:59'),
(71, 'office edit', 'office edit', 'web', NULL, '2021-11-17 07:48:08'),
(72, 'storesetup list', 'storesetup list', 'web', NULL, '2021-11-17 08:20:38'),
(73, 'storesetup create', 'storesetup create', 'web', NULL, '2021-11-17 08:21:25'),
(74, 'storesetup delete', 'storesetup delete', 'web', NULL, '2021-11-17 08:21:48'),
(75, 'storesetup show', 'storesetup show', 'web', NULL, '2021-11-17 08:22:24'),
(76, 'storesetup edit', 'storesetup edit', 'web', NULL, '2021-11-17 08:22:52'),
(77, 'vendor edit', 'vendor edit', 'web', NULL, '2021-11-17 08:23:12'),
(79, 'measurmentunit edit', 'measurmentunit edit', 'web', NULL, '2021-11-17 08:23:40'),
(80, 'location edit', 'location edit', 'web', NULL, '2021-11-17 08:24:11'),
(81, 'itemtype edit', 'itemtype edit', 'web', NULL, '2021-11-17 08:24:45'),
(82, 'itemcategory edit', 'itemcategory edit', 'web', NULL, '2021-11-17 08:26:12'),
(83, 'item edit', 'item edit', 'web', NULL, '2021-11-17 08:26:43'),
(84, 'acquisition edit', 'acquisition edit', 'web', NULL, '2021-11-17 08:27:05'),
(85, 'stockadjust edit', 'stockadjust edit', 'web', NULL, '2021-11-17 08:30:04'),
(86, 'office create', 'office create', 'web', NULL, '2021-11-17 08:30:28'),
(87, 'user list', 'user list', 'web', NULL, '2021-11-17 08:31:24'),
(88, 'user create', 'user create', 'web', NULL, '2021-11-17 08:31:47'),
(89, 'user delete', 'user delete', 'web', NULL, '2021-11-17 08:32:06'),
(90, 'user show', 'user show', 'web', NULL, '2021-11-17 08:32:22'),
(91, 'user edit', 'user edit', 'web', NULL, '2021-11-17 08:32:52'),
(92, 'promotion list', 'promotion list', 'web', NULL, '2021-11-17 08:33:16'),
(93, 'promotion create', NULL, 'web', NULL, NULL),
(94, 'promotion delete', NULL, 'web', NULL, NULL),
(95, 'promotion show', NULL, 'web', NULL, NULL),
(96, 'promotion edit', NULL, 'web', NULL, NULL),
(97, 'salarysetup list', NULL, 'web', NULL, NULL),
(98, 'salarysetup create', NULL, 'web', NULL, NULL),
(99, 'salarysetup delete', NULL, 'web', NULL, NULL),
(100, 'salarysetup show', NULL, 'web', NULL, NULL),
(101, 'salarysetup edit', NULL, 'web', NULL, NULL),
(102, 'loan list', NULL, 'web', NULL, NULL),
(103, 'loan create', NULL, 'web', NULL, NULL),
(104, 'loan delete', NULL, 'web', NULL, NULL),
(105, 'loan show', NULL, 'web', NULL, NULL),
(106, 'loan edit', NULL, 'web', NULL, NULL),
(107, 'openbalancerecovery list', NULL, 'web', NULL, NULL),
(108, 'openbalancerecovery create', NULL, 'web', NULL, NULL),
(109, 'openbalancerecovery delete', NULL, 'web', NULL, NULL),
(110, 'openbalancerecovery show', NULL, 'web', NULL, NULL),
(111, 'openbalancerecovery edit', NULL, 'web', NULL, NULL),
(112, 'salary list', NULL, 'web', NULL, NULL),
(113, 'salary create', NULL, 'web', NULL, NULL),
(114, 'salary delete', NULL, 'web', NULL, NULL),
(115, 'salary show', NULL, 'web', NULL, NULL),
(116, 'salary edit', NULL, 'web', NULL, NULL),
(117, 'salary.salaryPrint', NULL, 'web', NULL, NULL),
(118, 'salary.salarySlip', NULL, 'web', NULL, NULL),
(119, 'leavesetup list', NULL, 'web', NULL, NULL),
(120, 'leavesetup create', NULL, 'web', NULL, NULL),
(121, 'leavesetup delete', NULL, 'web', NULL, NULL),
(122, 'leavesetup show', NULL, 'web', NULL, NULL),
(123, 'leavesetup edit', NULL, 'web', NULL, NULL),
(124, 'leaverequest list', NULL, 'web', NULL, NULL),
(125, 'leaverequest create', NULL, 'web', NULL, NULL),
(126, 'leaverequest delete', NULL, 'web', NULL, NULL),
(127, 'leaverequest show', NULL, 'web', NULL, NULL),
(128, 'leaverequest edit', NULL, 'web', NULL, NULL),
(129, 'leaveapproved list', NULL, 'web', NULL, NULL),
(130, 'leaveapproved create', NULL, 'web', NULL, NULL),
(131, 'leaveapproved delete', NULL, 'web', NULL, NULL),
(132, 'leaveapproved show', NULL, 'web', NULL, NULL),
(133, 'leaveapproved edit', NULL, 'web', NULL, NULL),
(134, 'leaverequest.leavehistory', NULL, 'web', NULL, NULL),
(135, 'task list', NULL, 'web', NULL, NULL),
(136, 'task create', NULL, 'web', NULL, NULL),
(137, 'task delete', NULL, 'web', NULL, NULL),
(138, 'task show', NULL, 'web', NULL, NULL),
(139, 'task edit', NULL, 'web', NULL, NULL),
(140, 'taskassign list', NULL, 'web', NULL, NULL),
(141, 'taskassign create', NULL, 'web', NULL, NULL),
(142, 'taskassign delete', NULL, 'web', NULL, NULL),
(143, 'taskassign show', NULL, 'web', NULL, NULL),
(144, 'taskassign edit', NULL, 'web', NULL, NULL),
(145, 'mytaskassign list', NULL, 'web', NULL, NULL),
(146, 'mytaskassign create', NULL, 'web', NULL, NULL),
(147, 'mytaskassign delete', NULL, 'web', NULL, NULL),
(148, 'mytaskassign show', NULL, 'web', NULL, NULL),
(149, 'mytaskassign edit', NULL, 'web', NULL, NULL),
(150, 'mytaskassign.search', NULL, 'web', NULL, NULL),
(151, 'mytaskassign.statusChange', NULL, 'web', NULL, NULL),
(152, 'taskassign.taskreport', NULL, 'web', '2021-07-12 02:37:14', NULL),
(153, 'menu list', 'menu list', 'web', NULL, '2021-11-17 08:37:13'),
(154, 'menu create', 'menu create', 'web', NULL, '2021-11-17 08:37:36'),
(155, 'menu delete', 'menu delete', 'web', NULL, '2021-11-17 08:38:20'),
(156, 'menu show', 'menu show', 'web', NULL, '2021-11-17 08:38:40'),
(157, 'menu edit', 'menu edit', 'web', NULL, '2021-11-17 08:39:04'),
(159, 'rolemenu list', 'rolemenu list', 'web', NULL, '2021-11-17 08:39:26'),
(160, 'rolemenu create', 'rolemenu create', 'web', NULL, '2021-11-17 08:39:48'),
(161, 'rolemenu delete', 'rolemenu delete', 'web', NULL, '2021-11-17 08:40:09'),
(162, 'rolemenu show', 'rolemenu show', 'web', NULL, '2021-11-17 08:40:50'),
(163, 'rolemenu edit', 'rolemenu edit', 'web', NULL, '2021-11-17 08:41:13'),
(164, 'employee_management/add_employee', 'Add employee', 'web', NULL, '2021-11-17 08:43:12'),
(165, 'employee_management/edit', 'edit employee', 'web', NULL, '2021-11-17 08:43:40'),
(166, 'employee_management/del', 'delete employee', 'web', NULL, '2021-11-17 08:44:12'),
(167, 'employee_management', 'employee list', 'web', NULL, '2021-11-17 08:45:04'),
(168, 'brief_management/add', 'employee education add', 'web', NULL, '2021-11-18 02:31:21'),
(169, 'brief_management/edit', 'employee education edit', 'web', '2021-07-12 03:36:13', '2021-11-18 02:30:40'),
(170, 'brief_doc_management/add', 'employee document add', 'web', NULL, '2021-11-18 02:29:14'),
(171, 'brief_doc_management/edit', 'employee document edit', 'web', NULL, '2021-11-18 02:28:40'),
(172, 'brief_doc_management/del', 'employee document delete', 'web', NULL, '2021-11-18 02:27:51'),
(173, 'brief_doc_management', 'employee document list', 'web', NULL, '2021-11-18 02:27:12'),
(174, 'brief_description_children/add', 'employee children add', 'web', NULL, '2021-11-18 01:02:54'),
(175, 'brief_description_children/edit', 'employee children edit', 'web', NULL, '2021-11-18 01:02:32'),
(176, 'brief_description_children/del', 'employee children delete', 'web', NULL, '2021-11-18 01:02:08'),
(177, 'brief_description_children', 'employee children List', 'web', NULL, '2021-11-18 01:01:28'),
(178, 'brief_description/add', 'employee training add', 'web', NULL, '2021-11-18 07:59:59'),
(179, 'brief_description/edit', 'employee training edit', 'web', NULL, '2021-11-18 07:59:31'),
(180, 'brief_description/del', 'employee training delete', 'web', NULL, '2021-11-18 07:58:27'),
(181, 'brief_description', 'employee training list', 'web', NULL, '2021-11-18 07:57:56'),
(182, 'brief_management/del', 'education delete', 'web', NULL, '2021-11-18 00:58:55'),
(183, 'brief_management', 'education list', 'web', NULL, '2021-11-18 00:58:32'),
(184, 'scale list', 'scale list', 'web', NULL, '2021-11-17 07:01:34'),
(185, 'scale create', 'scale create', 'web', NULL, '2021-11-17 06:58:50'),
(186, 'scale delete', 'scale delete', 'web', NULL, '2021-11-17 06:22:24'),
(187, 'scale show', 'scale show', 'web', NULL, '2021-11-17 06:21:56'),
(188, 'scale edit', 'scale edit', 'web', NULL, '2021-11-17 06:21:30'),
(189, 'stock.notify', 'Stock Notify', 'web', NULL, '2021-10-19 06:30:19'),
(190, 'permissionlabel list', 'Permission Label List', 'web', '2021-07-18 22:00:18', '2021-07-18 22:00:18'),
(191, 'permissionlabel create', 'Permission Label Create', 'web', '2021-07-18 22:00:46', '2021-07-18 22:00:46'),
(192, 'permissionlabel delete', 'Permission Label Delete', 'web', '2021-07-18 22:01:10', '2021-07-18 22:01:10'),
(193, 'permissionlabel show', 'Permission Label Show', 'web', '2021-07-18 22:01:32', '2021-07-18 22:01:32'),
(194, 'permissionlabel edit', 'Permission Label Edit', 'web', '2021-07-18 22:01:52', '2021-07-18 22:01:52'),
(195, 'permissionrole list', 'Permission Role list', 'web', '2021-07-18 22:02:18', '2021-07-18 22:02:18'),
(196, 'permissionrole show', 'Permission Label show', 'web', '2021-07-18 22:02:45', '2021-07-18 22:02:45'),
(197, 'permissionrole create', 'permission role create', 'web', '2021-07-18 22:03:22', '2021-07-18 22:03:22'),
(198, 'permissionrole delete', 'Permission role delete', 'web', '2021-07-18 22:03:55', '2021-07-18 22:03:55'),
(199, 'permissionrole edit', 'permission role edit', 'web', '2021-07-18 22:04:15', '2021-07-18 22:04:15'),
(200, 'office_all_data', 'Office all data', 'web', '2021-07-17 21:22:20', '2021-07-17 21:22:20'),
(204, 'monthlyallotment create', 'Monthly Allotment Add', 'web', '2021-11-08 22:54:17', '2021-11-08 22:54:17'),
(205, 'monthlyallotment edit', 'Monthly Allotment edit', 'web', '2021-11-08 22:54:50', '2021-11-08 22:54:50'),
(206, 'monthlyallotment delete', 'Monthly Allotment delete', 'web', '2021-11-08 22:55:12', '2021-11-08 22:55:12'),
(207, 'monthlyallotment show', 'Monthly Allotment show', 'web', '2021-11-08 22:55:38', '2021-11-08 22:55:38'),
(208, 'monthlyallotment list', 'Monthly Allotment List', 'web', '2021-11-08 22:57:21', '2021-11-08 22:57:21'),
(209, 'report.currentInventory', 'Report Current Inventory', 'web', '2021-11-09 23:25:17', '2021-11-09 23:25:17'),
(210, 'report.challan', 'Report Challan', 'web', '2021-11-09 23:25:42', '2021-11-09 23:25:42'),
(211, 'itemrequisition create', 'Item Requestion add', 'web', '2021-11-10 01:18:37', '2021-11-10 01:30:52'),
(212, 'itemrequisition edit', 'Item Requestion Edit', 'web', '2021-11-10 01:18:58', '2021-11-10 01:18:58'),
(213, 'itemrequisition delete', 'Item Requestion delete', 'web', '2021-11-10 01:19:19', '2021-11-10 01:19:19'),
(214, 'itemrequisition list', 'Item Requestion list', 'web', '2021-11-10 01:19:40', '2021-11-10 01:19:40'),
(215, 'itemrequisition show', 'Item Requestion show', 'web', '2021-11-10 01:19:59', '2021-11-10 01:19:59'),
(216, 'itemissueemp create', 'Item Issue Staff Add', 'web', '2021-11-10 01:20:57', '2021-11-10 01:31:12'),
(217, 'itemissueemp edit', 'Item Issue Staff Edit', 'web', '2021-11-10 01:21:21', '2021-11-10 01:21:21'),
(218, 'itemissueemp delete', 'Item Issue Staff delete', 'web', '2021-11-10 01:21:49', '2021-11-10 01:21:49'),
(219, 'itemissueemp show', 'Item Issue Staff Show', 'web', '2021-11-10 01:22:15', '2021-11-10 01:22:15'),
(220, 'itemissueemp list', 'Item Issue Staff List', 'web', '2021-11-10 01:22:47', '2021-11-10 01:22:47'),
(221, 'itemissueemp.requisitionprint', 'Requisition Print', 'web', '2021-11-15 06:21:47', '2021-11-15 06:25:25'),
(222, 'designation show', 'Designation details', 'web', '2021-11-16 03:42:51', '2021-11-16 03:43:34'),
(223, 'designation create', 'designation create', 'web', '2021-11-16 03:43:20', '2021-11-16 03:43:20'),
(224, 'designation edit', 'designation edit', 'web', '2021-11-16 03:43:52', '2021-11-16 03:43:52'),
(225, 'designation delete', 'designation delete', 'web', '2021-11-16 03:44:13', '2021-11-16 03:44:13'),
(226, 'designation list', 'designation list', 'web', '2021-11-16 03:48:46', '2021-11-16 03:48:46'),
(227, 'stock_notity_alert', 'Stock Notify alert show', 'web', '2021-11-19 03:51:59', '2021-11-19 03:51:59'),
(228, 'abroadtour create', 'Abroad Tour Add', 'web', '2021-12-30 06:44:43', '2021-12-30 06:45:28'),
(229, 'abroadtour edit', 'Abroad Tour Edit', 'web', '2021-12-30 06:45:50', '2021-12-30 06:45:50'),
(230, 'abroadtour delete', 'Abroad Tour Delete', 'web', '2021-12-30 06:46:14', '2021-12-30 06:46:14'),
(231, 'abroadtour list', 'Abroad Tour list', 'web', '2021-12-30 06:46:35', '2021-12-30 06:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1= active , 0= deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `active_status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', 1, NULL, NULL),
(2, 'Admin', 'web', 1, NULL, NULL),
(3, 'Store Keeper', 'web', 1, NULL, NULL),
(4, 'General User', 'web', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(3, 2),
(4, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2),
(141, 2),
(142, 2),
(143, 2),
(144, 2),
(145, 2),
(146, 2),
(147, 2),
(148, 2),
(149, 2),
(150, 2),
(151, 2),
(152, 2),
(153, 2),
(154, 2),
(155, 2),
(156, 2),
(157, 2),
(159, 2),
(160, 2),
(161, 2),
(162, 2),
(163, 2),
(164, 2),
(165, 2),
(166, 2),
(167, 2),
(168, 2),
(169, 2),
(170, 2),
(171, 2),
(172, 2),
(173, 2),
(174, 2),
(175, 2),
(176, 2),
(177, 2),
(178, 2),
(179, 2),
(180, 2),
(181, 2),
(182, 2),
(183, 2),
(184, 2),
(185, 2),
(186, 2),
(187, 2),
(188, 2),
(189, 2),
(190, 2),
(191, 2),
(192, 2),
(193, 2),
(194, 2),
(195, 2),
(196, 2),
(197, 2),
(198, 2),
(199, 2),
(200, 2),
(204, 2),
(205, 2),
(206, 2),
(207, 2),
(208, 2),
(209, 2),
(210, 2),
(211, 2),
(212, 2),
(213, 2),
(214, 2),
(215, 2),
(216, 2),
(217, 2),
(218, 2),
(219, 2),
(220, 2),
(221, 2),
(222, 2),
(223, 2),
(224, 2),
(225, 2),
(226, 2),
(227, 2),
(228, 2),
(229, 2),
(230, 2),
(231, 2),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(77, 3),
(79, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(87, 3),
(90, 3),
(91, 3),
(167, 3),
(168, 3),
(169, 3),
(170, 3),
(171, 3),
(172, 3),
(173, 3),
(174, 3),
(175, 3),
(176, 3),
(177, 3),
(178, 3),
(179, 3),
(180, 3),
(181, 3),
(182, 3),
(183, 3),
(189, 3),
(204, 3),
(205, 3),
(206, 3),
(207, 3),
(208, 3),
(209, 3),
(210, 3),
(211, 3),
(212, 3),
(213, 3),
(214, 3),
(215, 3),
(216, 3),
(217, 3),
(218, 3),
(219, 3),
(220, 3),
(221, 3),
(165, 4),
(167, 4),
(168, 4),
(169, 4),
(170, 4),
(171, 4),
(172, 4),
(173, 4),
(174, 4),
(175, 4),
(176, 4),
(177, 4),
(178, 4),
(179, 4),
(180, 4),
(181, 4),
(182, 4),
(183, 4),
(211, 4),
(212, 4),
(213, 4),
(214, 4),
(215, 4);

-- --------------------------------------------------------

--
-- Table structure for table `role_menus`
--

CREATE TABLE `role_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_menus`
--

INSERT INTO `role_menus` (`id`, `role_id`, `menu_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(106, 1, 12, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(107, 1, 21, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(108, 1, 24, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(109, 1, 2, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(110, 1, 9, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(111, 1, 14, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(112, 1, 17, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(113, 1, 18, 1, NULL, '2021-07-07 01:50:55', '2021-07-07 01:50:55'),
(704, 4, 37, 1, NULL, '2021-11-17 06:50:36', '2021-11-17 06:50:36'),
(705, 4, 34, 1, NULL, '2021-11-17 06:50:36', '2021-11-17 06:50:36'),
(706, 4, 35, 1, NULL, '2021-11-17 06:50:36', '2021-11-17 06:50:36'),
(707, 4, 36, 1, NULL, '2021-11-17 06:50:36', '2021-11-17 06:50:36'),
(708, 4, 31, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(709, 4, 32, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(710, 4, 33, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(711, 4, 25, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(712, 4, 26, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(713, 4, 27, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(714, 4, 21, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(715, 4, 23, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(716, 4, 80, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(717, 4, 81, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(718, 4, 82, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(719, 4, 28, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(720, 4, 29, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(721, 4, 30, 1, NULL, '2021-11-17 06:50:37', '2021-11-17 06:50:37'),
(722, 3, 12, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(723, 3, 40, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(724, 3, 37, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(725, 3, 34, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(726, 3, 35, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(727, 3, 36, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(728, 3, 31, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(729, 3, 32, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(730, 3, 33, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(731, 3, 25, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(732, 3, 26, 1, NULL, '2021-11-18 03:32:03', '2021-11-18 03:32:03'),
(733, 3, 27, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(734, 3, 21, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(735, 3, 24, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(736, 3, 23, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(737, 3, 2, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(738, 3, 10, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(739, 3, 9, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(740, 3, 8, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(741, 3, 6, 1, NULL, '2021-11-18 03:32:04', '2021-11-18 03:32:04'),
(742, 3, 76, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(743, 3, 4, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(744, 3, 5, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(745, 3, 83, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(746, 3, 84, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(747, 3, 80, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(748, 3, 81, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(749, 3, 82, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(750, 3, 11, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(751, 3, 39, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(752, 3, 77, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(753, 3, 79, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(754, 3, 78, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(755, 3, 13, 1, NULL, '2021-11-18 03:32:05', '2021-11-18 03:32:05'),
(756, 3, 14, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(757, 3, 41, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(758, 3, 15, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(759, 3, 16, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(760, 3, 17, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(761, 3, 18, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(762, 3, 28, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(763, 3, 29, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(764, 3, 30, 1, NULL, '2021-11-18 03:32:06', '2021-11-18 03:32:06'),
(765, 2, 87, 1, NULL, '2021-12-30 06:37:09', '2021-12-30 06:37:09'),
(766, 2, 88, 1, NULL, '2021-12-30 06:37:09', '2021-12-30 06:37:09'),
(767, 2, 89, 1, NULL, '2021-12-30 06:37:09', '2021-12-30 06:37:09'),
(768, 2, 12, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(769, 2, 40, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(770, 2, 37, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(771, 2, 34, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(772, 2, 35, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(773, 2, 36, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(774, 2, 31, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(775, 2, 32, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(776, 2, 33, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(777, 2, 25, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(778, 2, 26, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(779, 2, 27, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(780, 2, 21, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(781, 2, 24, 1, NULL, '2021-12-30 06:37:10', '2021-12-30 06:37:10'),
(782, 2, 23, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(783, 2, 2, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(784, 2, 86, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(785, 2, 10, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(786, 2, 9, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(787, 2, 8, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(788, 2, 6, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(789, 2, 76, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(790, 2, 3, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(791, 2, 38, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(792, 2, 4, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(793, 2, 5, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(794, 2, 83, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(795, 2, 84, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(796, 2, 80, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(797, 2, 81, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(798, 2, 82, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(799, 2, 56, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(800, 2, 57, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(801, 2, 61, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(802, 2, 58, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(803, 2, 60, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(804, 2, 59, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(805, 2, 48, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(806, 2, 49, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(807, 2, 50, 1, NULL, '2021-12-30 06:37:11', '2021-12-30 06:37:11'),
(808, 2, 68, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(809, 2, 69, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(810, 2, 70, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(811, 2, 71, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(812, 2, 72, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(813, 2, 73, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(814, 2, 74, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(815, 2, 75, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(816, 2, 11, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(817, 2, 39, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(818, 2, 77, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(819, 2, 79, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(820, 2, 78, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(821, 2, 51, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(822, 2, 52, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(823, 2, 53, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(824, 2, 54, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(825, 2, 55, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(826, 2, 44, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(827, 2, 47, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(828, 2, 46, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(829, 2, 45, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(830, 2, 13, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(831, 2, 14, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(832, 2, 41, 1, NULL, '2021-12-30 06:37:12', '2021-12-30 06:37:12'),
(833, 2, 15, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(834, 2, 16, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(835, 2, 17, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(836, 2, 18, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(837, 2, 62, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(838, 2, 66, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(839, 2, 65, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(840, 2, 63, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(841, 2, 64, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(842, 2, 67, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(843, 2, 28, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(844, 2, 29, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(845, 2, 30, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(846, 2, 42, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13'),
(847, 2, 43, 1, NULL, '2021-12-30 06:37:13', '2021-12-30 06:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_to` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_visitor_count` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `brand_name`, `address`, `phone`, `email`, `mail_to`, `logo`, `favicon`, `fb_link`, `twitter_link`, `youtube_link`, `instagram_link`, `service_day`, `service_time`, `is_visitor_count`, `created_at`, `updated_at`) VALUES
(1, 'RHM Group', 'Dhaka', '01882447362', 'mobarakhossen2013@gmail.com', 'mobarakhossen2013@gmail.com', '/uploads/settings/logo.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `office_id` bigint(20) NOT NULL,
  `store_location` text,
  `contact_person` varchar(80) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `code`, `name`, `office_id`, `store_location`, `contact_person`, `phone`, `email`, `active_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'E5F2HU', 'Test-store', 1, 'Dhaka', 'amin', '016740985047', 'amin1993@hotmail.com', 1, 1, '2021-08-09 05:10:32', NULL, '2021-08-09 05:10:32'),
(2, 'DHK-01', 'Dhaka Office Store', 2, 'Dhaka', 'Md. Zakaria', '016740985047', 'amin95@gmail.com', 1, 1, '2021-08-12 02:41:01', NULL, '2021-08-12 02:41:01'),
(3, 'Are001', 'Arena Phone Store', 7, 'Dhaka Gulshan', 'Ekramul Haque', '+8801758871165', 'ekramul.haque@arena.com.bd', 1, 1, '2021-11-16 22:33:13', 1, '2021-11-16 22:34:08'),
(4, 'Ad001', 'Ad65', 9, 'Mohakhali', 'Amirul', '01882447362', 'ekramulcsediu2016@gmail.com', 1, 1, '2021-11-17 01:24:42', 1, '2021-12-29 05:48:41'),
(5, 'Ad65-001', 'Ad65-001', 9, 'dhaka', NULL, '01882447362', NULL, 1, 1, '2021-12-29 05:49:17', 1, '2021-12-29 13:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'API token',
  `api_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `name`, `description`, `api_token`, `limit`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Md. Aminur rahman', '', 'e2590ebfcb0197500fe9c38c7a646893d8c08e7871b54536118636e561e77ad4', 1, NULL, '2021-11-19 00:05:19', '2021-11-19 00:05:19'),
(2, 1, 'Md. Aminur rahman', '', '1775436db51ef0eee03ebb429de5645dfd8ffe501845fe5f167a318e55ce0c5a', 1, NULL, '2021-11-19 00:08:21', '2021-11-19 00:08:21'),
(3, 1, 'Md. Aminur rahman', '', '905901d2d9f1cf5f0125dc0712a2e2bea061e4724b1fd51af1502d4b90c504ad', 1, NULL, '2021-11-19 00:20:00', '2021-11-19 00:20:00'),
(4, 1, 'Md. Aminur rahman', '', '41ef2a532586ddaec6ebdd08b897587484bd7820d1c766c167e71be7f4b6c0ac', 1, NULL, '2021-11-19 00:20:29', '2021-11-19 00:20:29'),
(5, 1, 'Md. Aminur rahman', '', '6d1b6c079173e97f8e8546400951159b877b7b30b90a2784e283f0ce8cdf3315', 1, NULL, '2021-11-19 00:22:32', '2021-11-19 00:22:32'),
(6, 1, 'Md. Aminur rahman', '', '7c7c5d6d7b87f1fbba15b0e0ed0352c829768fd7628a8e9efc58c68bccda5cf8', 1, NULL, '2021-11-19 00:23:44', '2021-11-19 00:23:44'),
(7, 1, 'Md. Aminur rahman', '', '81bb72fd97144131a5141620fe8badb852060042ff3c52c176d0e1507df8fa0a', 1, NULL, '2021-11-19 00:24:32', '2021-11-19 00:24:32'),
(8, 1, 'Md. Aminur rahman', '', '508564c9a37f28cfcef6cf63a3ea2bbd94d86b143f71afe871769f4e45dd642c', 1, NULL, '2021-11-19 00:26:02', '2021-11-19 00:26:02'),
(9, 20, 'Arena-3', '', '224606137d31411bbfa69f404863e6bf05d5d4984a67f7e57c9097fbb7b563d8', 1, NULL, '2021-11-19 00:26:25', '2021-11-19 00:26:25'),
(10, 21, 'arena-4', '', '507619dba25aee2a215a68ab00ec2e1b1d907ddf9a7a7e249fa9e32370c624ef', 1, NULL, '2021-11-19 00:26:28', '2021-11-19 00:26:28'),
(11, 20, 'Arena-3', '', '41e4f03e448ebc3b37228f75b186b05014a45bd43041fa7fe13adb453f9939a4', 1, NULL, '2021-11-19 00:27:35', '2021-11-19 00:27:35'),
(12, 25, 'Nabarun Debnath', '', 'da8f88189ba37bc8a0a71f37b34d4ae5ffd39200a18ac003b06d69c7131edb84', 1, NULL, '2021-11-19 00:49:38', '2021-11-19 00:49:38'),
(13, 1, 'Md. Aminur rahman', '', '52d59442e4333b5d85e6ba75232855efb509ee573476a64f167bec31933f689f', 1, NULL, '2021-11-19 00:50:56', '2021-11-19 00:50:56'),
(14, 1, 'Md. Aminur rahman', '', '0de83741fe4cf7d24c830b63d8b768503e1541c093ba36c89df6192d28a4d2e0', 1, NULL, '2021-11-19 00:52:19', '2021-11-19 00:52:19'),
(15, 1, 'Md. Aminur rahman', '', '8433d1d8673da98c1c10faf51fb0f7577ec75e2c3fad3646e41a2173db9cc860', 1, NULL, '2021-11-19 00:52:28', '2021-11-19 00:52:28'),
(16, 22, 'Fahima Sultana Choity', '', '06025d029133217673dda91b307d3f9e274dd27e45ab7dce343eb6b6039f6993', 1, NULL, '2021-11-19 03:47:59', '2021-11-19 03:47:59'),
(17, 1, 'Md. Aminur rahman', '', 'd045ca09da1c681f02b910afdba904e1f9f2af902998df44d57bcc7661fd377d', 1, NULL, '2021-11-19 04:04:40', '2021-11-19 04:04:40'),
(18, 1, 'Md. Aminur rahman', '', '8ec744e6bbdc8e111a0e0b677a93820a7daaaac567df707ef8a09319385114be', 1, NULL, '2021-11-19 04:19:17', '2021-11-19 04:19:17'),
(19, 25, 'Nabarun Debnath', '', 'b5a3110d2e00e19d23136a83a4895d83a0ccb89e06f806694589c5b7fd9657a6', 1, NULL, '2021-11-19 04:58:30', '2021-11-19 04:58:30'),
(20, 25, 'Nabarun Debnath', '', '3f6f9e169bfe1154acc996f180208dc4f18284392c37edb5c2ce534d12f886c1', 1, NULL, '2021-11-19 04:59:42', '2021-11-19 04:59:42'),
(21, 25, 'Nabarun Debnath', '', '8a5da76c5ea4248d604fab31e3e5d8e1e47508e9f45909f6fe60369e466227a9', 1, NULL, '2021-11-19 05:01:18', '2021-11-19 05:01:18'),
(22, 1, 'Md. Aminur rahman', '', '25816f0edeec3afc520172519cd98f5a7f24c968c82f0ff4a6c834898bcbd89d', 1, NULL, '2021-11-19 05:15:42', '2021-11-19 05:15:42'),
(23, 1, 'Md. Aminur rahman', '', '285e8f7825b3daee605db3aec1cf8a3f5f7bb540fbe2770d5bfdcb2b54909881', 1, NULL, '2021-11-19 11:44:04', '2021-11-19 11:44:04'),
(24, 1, 'Md. Aminur rahman', '', '6d0187732a12487561592b97d0cf7e59885e9168adf36699a6022b8286f21128', 1, NULL, '2021-11-20 07:00:49', '2021-11-20 07:00:49'),
(25, 1, 'Md. Aminur rahman', '', 'db0d4e44312050c07c5782c337a94990bdbcfd7abe3d6487b5991cb2b6190a95', 1, NULL, '2021-11-20 19:14:31', '2021-11-20 19:14:31'),
(26, 1, 'Md. Aminur rahman', '', '4861ede46569096dac8b46afc7d7f79955a39eeca97d0cf8654fb64cf9ef9124', 1, NULL, '2021-11-21 22:37:24', '2021-11-21 22:37:24'),
(27, 1, 'Md. Aminur rahman', '', 'cbf55ce8e1a41c022aa484987c0d7cfd4f53851e6f0b38bd852a5d64d566743f', 1, NULL, '2021-11-22 23:27:24', '2021-11-22 23:27:24'),
(28, 1, 'Md. Aminur rahman', '', 'adaad47a19b2c57eda551fe0d30f543fbd540d1acdaf6eca51de8b442d23be51', 1, NULL, '2021-12-23 06:00:17', '2021-12-23 06:00:17'),
(29, 1, 'Md. Aminur rahman', '', '2678f07e2e2641b129c5f2dfd2bad56cde986d2181518b68705dcb15c70760c4', 1, NULL, '2021-12-29 05:25:27', '2021-12-29 05:25:27'),
(30, 12, 'aminur', '', '7f5f7df5f6ee5ea51382516d51bb7d3ad9e950681b64fe9f53a2949a109e86a1', 1, NULL, '2021-12-29 11:04:31', '2021-12-29 11:04:31'),
(31, 13, 'Irfan', '', 'b25185c21438f1df872a2ba31458adc2dd76caa48230f9158c3faebf4ea2277c', 1, NULL, '2021-12-29 11:04:51', '2021-12-29 11:04:51'),
(32, 22, 'Fahima Sultana Choity', '', '61638a4fc1a7b95443b5ab6c17401d47c90e8593286ba9db4c839936f24d0a4a', 1, NULL, '2021-12-29 11:05:53', '2021-12-29 11:05:53'),
(33, 1, 'Md. Aminur rahman', '', '6e1fa22f2000161ce68908999ae0d2275d7883860a44fb4bb57d807013011476', 1, NULL, '2021-12-29 11:13:55', '2021-12-29 11:13:55'),
(34, 21, 'arena-4', '', '6d51862943855f0b882395407671dfe0f7335eda15b433c0ea16acedd213d830', 1, NULL, '2021-12-29 12:09:09', '2021-12-29 12:09:09'),
(35, 22, 'Fahima Sultana Choity', '', '582e0d65f4a42b21f5020c6584c9a36b28488bc25de3991b184b1aa1afa07a8c', 1, NULL, '2021-12-29 12:10:45', '2021-12-29 12:10:45'),
(36, 1, 'Md. Aminur rahman', '', '14624b7e186a4261b899778c8b87669a1576e1e754d6f62405e5ff150207f0b6', 1, NULL, '2021-12-29 12:50:07', '2021-12-29 12:50:07'),
(37, 24, 'Humayun Kabir', '', '1ef722f5acbca974bfbc4d15d5e17ab654271e2572753914cdbc51c5da52acd9', 1, NULL, '2021-12-29 13:16:20', '2021-12-29 13:16:20'),
(38, 1, 'Md. Aminur rahman', '', '8c307dd74c870ec98597f00fc670089815e4fb1877be72286e6a51db68ffab8e', 1, NULL, '2021-12-30 05:43:04', '2021-12-30 05:43:04'),
(39, 1, 'Md. Aminur rahman', '', '9e432bf98e8bdb394358144d0eae9779d30a2e114c1313c4f834c3239abe7316', 1, NULL, '2022-01-02 06:33:59', '2022-01-02 06:33:59'),
(40, 1, 'Md. Aminur rahman', '', '2130a4d57d7ee37e52b700b1b1010b6deee89ecdb653f4a4c2847fb199a14672', 1, NULL, '2022-02-06 13:20:44', '2022-02-06 13:20:44'),
(41, 1, 'Md. Aminur rahman', '', '4e48293bb3a931c95a59c53627f587194959b933c1ea46e87b1b2b0c0c8421b8', 1, NULL, '2022-02-06 13:28:22', '2022-02-06 13:28:22'),
(42, 1, 'Md. Aminur rahman', '', 'bebc549de06c0e777734561b0478c9a21d94980da4aa5ec8708aff294709bd41', 1, NULL, '2022-02-06 13:32:38', '2022-02-06 13:32:38'),
(43, 1, 'Md. Aminur rahman', '', 'a18ec230657ce19299e8de3faba916ca4714461d14d55f8b7424ffc154a5a95a', 1, NULL, '2022-02-06 13:55:50', '2022-02-06 13:55:50'),
(44, 1, 'Md. Aminur rahman', '', '5a1a4cbabb7a1ba94df76630e343b6928943573d9922006e77e8624eea3151b9', 1, NULL, '2022-02-07 04:30:27', '2022-02-07 04:30:27'),
(45, 1, 'Md. Aminur rahman', '', 'f135518443e64343996f04149b73906a2f3c60d39f4f28281a65751ee1d5c989', 1, NULL, '2022-02-08 04:04:38', '2022-02-08 04:04:38'),
(46, 1, 'Md. Aminur rahman', '', '217264bd94eb296c8358f9354916ec913cab271f995d11ff4a4b487dddea18c9', 1, NULL, '2022-03-01 11:49:36', '2022-03-01 11:49:36'),
(47, 1, 'Md. Aminur rahman', '', 'b7fbe0bfae42b3f33d5b2b97e480c1fe76ae068e4eb1b4d2a45d3511038143c8', 1, NULL, '2022-03-02 05:09:19', '2022-03-02 05:09:19'),
(48, 1, 'Md. Aminur rahman', '', 'ecbb6e1e81c02135eea2a911e208e4d8cf50f480da277bae61bc3e842fd9e054', 1, NULL, '2022-04-10 07:27:44', '2022-04-10 07:27:44'),
(49, 1, 'Md. Aminur rahman', '', '636007e1820a8b87b691ce20151e418d8db4c8a8621d48da30bb8ad061f70dec', 1, NULL, '2022-04-24 05:05:02', '2022-04-24 05:05:02'),
(50, 1, 'Md. Aminur rahman', '', '5c11c1edd6e80064a6ea79f922a1e8ff8deb28162e1ca65d9798699623aade37', 1, NULL, '2022-04-25 09:14:58', '2022-04-25 09:14:58'),
(51, 1, 'Md. Aminur rahman', '', '4dbd95d0672115359749a43a674632acb9a0af939450130522846920dafb681b', 1, NULL, '2022-04-26 04:48:43', '2022-04-26 04:48:43'),
(52, 1, 'Md. Aminur rahman', '', 'e6041e72730a2c6acb5348df15e98e1f19b19c917601b600c6e6088be7333b8a', 1, NULL, '2022-04-26 08:26:58', '2022-04-26 08:26:58'),
(53, 1, 'Md. Aminur rahman', '', 'e0f4bb531130efd5a05ab5df3775c4895ff2f3b524415c3a9e1ab8f6325f5b6e', 1, NULL, '2022-04-26 11:37:30', '2022-04-26 11:37:30'),
(54, 1, 'Md. Aminur rahman', '', '514cf1d31c482d8a0fbe05104542e7ee671e9760cfd2be61bdc6a7e6c3a32947', 1, NULL, '2022-05-10 08:28:15', '2022-05-10 08:28:15'),
(55, 1, 'Md. Aminur rahman', '', '88709ed100404fc6caa2cebf161abf5468c06cebf0587a7a75f3f7f84c86109d', 1, NULL, '2022-05-10 11:00:58', '2022-05-10 11:00:58'),
(56, 1, 'Md. Aminur rahman', '', 'b25a4ca8e880b2aeae76ec973b825898625b96999aee5e149af851a2f9e58fc2', 1, NULL, '2022-05-11 10:50:47', '2022-05-11 10:50:47'),
(57, 1, 'Md. Aminur rahman', '', 'ab90bbef5e40d180b62c31ec4b067cd662d0cd4d80f94b7fa8c8d174f943955d', 1, NULL, '2022-05-11 11:12:15', '2022-05-11 11:12:15'),
(58, 1, 'Md. Aminur rahman', '', '1b7eede63ab5a720f4a0acc153551a43c9cf5b1f4add2ec3bec901c6bb587f0d', 1, NULL, '2022-05-12 04:35:12', '2022-05-12 04:35:12'),
(59, 1, 'Md. Aminur rahman', '', '251544f26b73e01d0153dcc62d69d0b270ca96ac0dead2c1478f2cc2754b5a26', 1, NULL, '2022-05-12 09:20:53', '2022-05-12 09:20:53'),
(60, 1, 'Md. Aminur rahman', '', '39ae3103bf862a2d61292b5f8331f9a33b01b21dadf9b4b290216ddb86bee747', 1, NULL, '2022-05-12 09:50:59', '2022-05-12 09:50:59'),
(61, 1, 'Md. Aminur rahman', '', 'dacc463c496a405eeb0024587e2f2bd6f27f5aa3a716213e13f834cd52151366', 1, NULL, '2022-08-29 06:21:03', '2022-08-29 06:21:03'),
(62, 1, 'Md. Aminur rahman', '', '774e07786324af2bf6404289ec1a473c0c07268c52d0ff5d8cb40c58c09d6025', 1, NULL, '2022-08-29 06:47:20', '2022-08-29 06:47:20'),
(63, 1, 'Md. Aminur rahman', '', '31981eb428d645ad810f60a756324b8375aceefc7fcfeeb0c401a384e487c7ae', 1, NULL, '2022-08-29 06:55:18', '2022-08-29 06:55:18'),
(64, 1, 'Md. Aminur rahman', '', '6c726252e78adc6788c7b1ffa1aaf698d65f73bb892f62cac964c11c9edc2717', 1, NULL, '2022-08-29 07:52:37', '2022-08-29 07:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `token_statistics`
--

CREATE TABLE `token_statistics` (
  `date` bigint(20) UNSIGNED NOT NULL,
  `token_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `request` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1= active , 0= deactive',
  `store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `office_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `active_status`, `store_id`, `created_at`, `updated_at`, `role_id`, `office_id`) VALUES
(1, 'Md. Aminur rahman', 'amin95', 'mobarak@yahoo.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-04-26 11:03:39', '2021-08-17 23:16:59', 2, 2),
(12, 'aminur', 'aminur95', 'amin95@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 1, '2021-08-09 05:12:56', '2021-08-09 05:12:56', 4, 1),
(13, 'Irfan', 'irfanur', 'rabby.friend@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-08-09 06:20:32', '2021-11-16 04:21:02', 4, 2),
(14, 'Type-test', 'type-test', 'rabby.friend1@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, NULL, '2021-08-09 06:25:30', '2021-08-09 06:25:30', 4, 1),
(15, 'Md. azahar', 'hello', 'amin1995@hotmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-08-09 06:26:53', '2021-11-16 00:04:23', 4, 2),
(16, 'Zakaria', 'zakaria', 'zakaria.novo@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-08-12 02:20:42', '2022-05-12 09:31:30', 3, 2),
(17, 'Ekramul Haque', 'ekramul', 'ekramul.haque@arena.com.bd', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 3, '2021-11-17 00:02:47', '2021-11-18 06:26:15', 3, 7),
(18, 'Arena-1', 'Arena-1', 'amin955@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-17 04:09:52', '2021-11-17 04:36:07', 4, 2),
(19, 'Arena-2', 'Arena-2', 'amin951@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-17 05:03:06', '2021-11-17 05:03:06', 4, 2),
(20, 'Arena-3', 'Arena-3', 'amin953@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, NULL, '2021-11-18 04:37:48', '2021-11-22 06:22:11', 4, 2),
(21, 'arena-4', 'arena-4', 'amin954@gmail.com', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-18 06:29:31', '2021-11-18 06:29:31', 3, 2),
(22, 'Fahima Sultana Choity', 'Fahima', 'hr@arena.com.bd', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-19 00:45:24', '2021-11-19 03:11:25', 3, 2),
(23, 'Iman Azom Raju', 'Raju', 'qc@arena.com.bd', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-19 00:46:18', '2021-11-19 03:11:55', 4, 2),
(24, 'Humayun Kabir', 'Humayun', 'humayun.kabir@arena.com.bd', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-19 00:47:13', '2021-11-19 03:12:07', 2, 2),
(25, 'Nabarun Debnath', 'Nabarun', 'network@arena.com.bd', NULL, '$2y$10$P3Mn0YuXuQsf3NUbvZWW3egaDkHcXh3FE1s1CFr/GZexjmAyOLsx2', NULL, 1, 2, '2021-11-19 00:48:52', '2021-11-19 03:12:19', 4, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `firstname` (`firstname`);

--
-- Indexes for table `admin_group`
--
ALTER TABLE `admin_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_menus_role_id_foreign` (`role_id`),
  ADD KEY `role_menus_menu_id_foreign` (`menu_id`),
  ADD KEY `role_menus_created_by_foreign` (`created_by`),
  ADD KEY `role_menus_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_tbl_name` (`name`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tokens_api_token_unique` (`api_token`),
  ADD KEY `tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `token_statistics`
--
ALTER TABLE `token_statistics`
  ADD KEY `token_statistics_date_index` (`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_store_id_foreign` (`store_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_group`
--
ALTER TABLE `admin_group`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=848;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD CONSTRAINT `role_menus_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_menus_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_menus_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
