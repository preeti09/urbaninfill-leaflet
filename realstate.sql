-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2019 at 07:07 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realstate`
--

-- --------------------------------------------------------

--
-- Table structure for table `mailertemplate`
--

CREATE TABLE `mailertemplate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mailertemplate`
--

INSERT INTO `mailertemplate` (`id`, `content`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hello ,\r\nthis is testing.', 'first_template', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_11_115254_create_roles_table', 1),
(4, '2019_04_11_115329_create_role_user_table', 1),
(5, '2019_04_12_111439_add_notes_to_users_table', 1),
(6, '2019_04_26_132455_create_save_property_table', 1),
(7, '2019_04_28_082128_add_resttime_to_users_table', 1),
(8, '2019_06_18_212425_add_rest_to_users_table', 1),
(9, '2019_07_03_134416_create_mailertemplate_table', 1),
(10, '2019_07_06_093800_add_logo_companyname_to_users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `save_property`
--

CREATE TABLE `save_property` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `line1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `save_property`
--

INSERT INTO `save_property` (`id`, `user_id`, `line1`, `line2`, `created_at`, `updated_at`) VALUES
(1, 1, '4523%20N%20HAIGHT%20AVE', 'PORTLAND,%20OR%2097217', '2019-09-24 23:48:15', '2019-09-24 23:48:15'),
(2, 1, '4550%20N%20INTERSTATE%20AVE', 'PORTLAND,%20OR%2097217', '2019-09-25 00:18:10', '2019-09-25 00:18:10'),
(3, 1, '4615%20N%20MONTANA%20AVE', 'PORTLAND,%20OR%2097217', '2019-09-25 00:20:26', '2019-09-25 00:20:26'),
(5, 2, '4728%20N%20GANTENBEIN%20AVE', 'PORTLAND,%20OR%2097217', '2019-09-25 01:21:23', '2019-09-25 01:21:23'),
(6, 2, '4828%20N%20MICHIGAN%20AVE', 'PORTLAND,%20OR%2097217', '2019-09-25 01:33:21', '2019-09-25 01:33:21'),
(7, 2, '928%20N%20HUMBOLDT%20ST', 'PORTLAND,%20OR%2097217', '2019-09-25 01:37:52', '2019-09-25 01:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PhoneNumber` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resttime` int(11) DEFAULT NULL,
  `savedcount` int(11) NOT NULL DEFAULT 0,
  `Historicresttime` int(11) DEFAULT NULL,
  `Historicsavedcount` int(11) NOT NULL DEFAULT 0,
  `HistoricTotalSaveCount` int(11) NOT NULL DEFAULT 0,
  `HistoricFirstDate` datetime DEFAULT NULL,
  `IsHistoricRest` tinyint(1) NOT NULL DEFAULT 1,
  `Vacantresttime` int(11) DEFAULT NULL,
  `Vacantsavedcount` int(11) NOT NULL DEFAULT 0,
  `VacantTotalSaveCount` int(11) NOT NULL DEFAULT 0,
  `VacantFirstDate` datetime DEFAULT NULL,
  `IsVacantRest` tinyint(1) NOT NULL DEFAULT 1,
  `Addressresttime` int(11) DEFAULT NULL,
  `Addresssavedcount` int(11) NOT NULL DEFAULT 0,
  `AddressTotalSaveCount` int(11) NOT NULL DEFAULT 0,
  `AddressFirstDate` datetime DEFAULT NULL,
  `IsAddressRest` tinyint(1) NOT NULL DEFAULT 1,
  `Personresttime` int(11) DEFAULT NULL,
  `Personsavedcount` int(11) NOT NULL DEFAULT 0,
  `PersonTotalSaveCount` int(11) NOT NULL DEFAULT 0,
  `PersonFirstDate` datetime DEFAULT NULL,
  `IsPersonRest` tinyint(1) NOT NULL DEFAULT 1,
  `TotalSaveCount` int(11) NOT NULL DEFAULT 0,
  `SavedPropertyFirstDate` datetime DEFAULT NULL,
  `IsSavedPropertyRest` tinyint(1) NOT NULL DEFAULT 1,
  `companyname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `notes`, `PhoneNumber`, `Address`, `resttime`, `savedcount`, `Historicresttime`, `Historicsavedcount`, `HistoricTotalSaveCount`, `HistoricFirstDate`, `IsHistoricRest`, `Vacantresttime`, `Vacantsavedcount`, `VacantTotalSaveCount`, `VacantFirstDate`, `IsVacantRest`, `Addressresttime`, `Addresssavedcount`, `AddressTotalSaveCount`, `AddressFirstDate`, `IsAddressRest`, `Personresttime`, `Personsavedcount`, `PersonTotalSaveCount`, `PersonFirstDate`, `IsPersonRest`, `TotalSaveCount`, `SavedPropertyFirstDate`, `IsSavedPropertyRest`, `companyname`, `logo`) VALUES
(1, 'bhavana', 'bhavana@amwebtech.com', NULL, '$2y$10$Ofb6EpVnuRjSSfSkBvF9Yuflh5psMJXYb7WCu0lEOovAPolA7AKX2', 'M9j2DGMSVPF8QBs2dkDZduHgCw0Lm8B57xxOqbYwuwJJuTqTOlfJ17YBLmbp', '2019-09-24 03:53:59', '2019-10-08 23:33:10', NULL, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, 1, NULL, 0, 0, NULL, 1, NULL, 0, 0, NULL, 1, NULL, 0, 0, NULL, 1, 0, NULL, 1, NULL, NULL),
(2, 'bhavana', 'bhavana@gmail.com', NULL, '$2y$10$urC0SIep5TEaKkZlow5nNe32QEzoBY19.gZsJOy.DTUbf2TxUCoC6', 'yOgG5YXrLWgnLjibrk9T1S6TjCzyDiwuSaTfIFk9k8irrx2IQqpoFlUAllFS', '2019-09-25 00:32:45', '2019-09-25 03:10:26', NULL, NULL, NULL, NULL, 50, NULL, 10, 0, '2019-09-25 06:25:08', 0, NULL, 0, 0, NULL, 1, NULL, 0, 0, NULL, 1, NULL, 0, 0, NULL, 1, 50, NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mailertemplate`
--
ALTER TABLE `mailertemplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `save_property`
--
ALTER TABLE `save_property`
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
-- AUTO_INCREMENT for table `mailertemplate`
--
ALTER TABLE `mailertemplate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `save_property`
--
ALTER TABLE `save_property`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
