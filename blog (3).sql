-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 09:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `role` varchar(250) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `status` int(255) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `role`, `password`, `status`, `created_at`, `updated_at`) VALUES
(2, 'admin@gmail.com', 'admin', '$2y$10$ELhL0.CxMf4SrJgx69vmceD5lIKg45rDj/YbdzuDCOVNv/m.4BxNa', 0, '2024-04-22 13:03:43', '2024-04-22 13:03:43'),
(3, 'hr.pronto@gmail.com', 'hr', '$2y$10$ELhL0.CxMf4SrJgx69vmceD5lIKg45rDj/YbdzuDCOVNv/m.4BxNa', 0, '2024-04-22 13:03:43', '2024-04-22 13:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendence_times`
--

CREATE TABLE `employee_attendence_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` tinyint(4) NOT NULL DEFAULT 0,
  `in_time` timestamp NULL DEFAULT NULL,
  `out_time` timestamp NULL DEFAULT NULL,
  `total_hours` varchar(255) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_attendence_times`
--

INSERT INTO `employee_attendence_times` (`id`, `user_id`, `in_time`, `out_time`, `total_hours`, `created_at`, `updated_at`) VALUES
(45, 5, '2024-04-22 12:04:35', '2024-04-22 12:21:38', '00:17', '2024-04-22 12:04:35', '2024-04-22 12:21:38'),
(46, 5, '2024-04-23 07:46:46', '2024-04-23 07:46:46', '0', '2024-04-23 07:46:46', '2024-04-23 07:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `employeleaves`
--

CREATE TABLE `employeleaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` tinyint(4) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `reason` longtext NOT NULL,
  `feedback` longtext NOT NULL DEFAULT '',
  `leave_status` int(250) NOT NULL DEFAULT 0 COMMENT '1=hr , 2=tL',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1= accept , 2= reject ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employeleaves`
--

INSERT INTO `employeleaves` (`id`, `user_id`, `title`, `date`, `reason`, `feedback`, `leave_status`, `status`, `created_at`, `updated_at`) VALUES
(14, 5, 'urgent work', '04/14/2024', 'urgent work', 'rejected', 0, 2, '2024-04-12 00:48:49', '2024-04-22 12:32:59'),
(15, 5, 'sick leave', '04/23/2024', 'sick leave', 'ffff', 0, 2, '2024-04-22 05:20:18', '2024-04-22 11:27:41'),
(16, 5, 'urgent work leave', '04/23/2024', 'urgent work leave', 'leave rejected', 0, 1, '2024-04-22 11:24:09', '2024-04-22 11:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_15_073249_create_employeleaves_table', 2),
(6, '2024_02_15_074004_create_employeleaves_table', 3),
(7, '2024_02_15_075817_create_employeleaves_table', 4),
(8, '2024_04_15_064036_employee_attendence_time', 5),
(9, '2024_04_15_064522_create_employee_attendence_times_table', 6),
(10, '2024_04_25_105329_create_project_managements_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_managements`
--

CREATE TABLE `project_managements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `total_hours` varchar(255) DEFAULT NULL,
  `payment` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_managements`
--

INSERT INTO `project_managements` (`id`, `project_name`, `client_name`, `total_hours`, `payment`, `created_at`, `updated_at`) VALUES
(2, 'tatas', 'tatas', '111', '100', '2024-04-25 06:19:20', '2024-04-25 06:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(250) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'himanshu', 'himanshu@gmail.com', '7988142524', '1713509813_662215b50f7dd.jpg', NULL, '$2y$10$YLwO6Z8PN3PbYbep15BSjOqS1.afb/S6RgU2lTAPwnnSBPXFiRJpC', NULL, '2024-02-13 01:33:35', '2024-04-19 07:35:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_attendence_times`
--
ALTER TABLE `employee_attendence_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeleaves`
--
ALTER TABLE `employeleaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `project_managements`
--
ALTER TABLE `project_managements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_attendence_times`
--
ALTER TABLE `employee_attendence_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `employeleaves`
--
ALTER TABLE `employeleaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_managements`
--
ALTER TABLE `project_managements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
