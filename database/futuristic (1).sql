-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 03:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `futuristic`
--

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_08_114853_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', 'ad5e058e3975a5594affc7cf836c1f88846642be219bda067855780ae6c5a37c', '[\"*\"]', NULL, NULL, '2024-03-24 08:43:45', '2024-03-24 08:43:45'),
(2, 'App\\Models\\User', 1, 'auth_token', 'd1394c142fdd27c97d57cd57a1abbce208681cc4268d1a1d60f0449a9b8889f7', '[\"*\"]', NULL, NULL, '2024-03-24 09:13:28', '2024-03-24 09:13:28'),
(3, 'App\\Models\\User', 1, 'auth_token', '6180fc81c84d2aefa9f04b7dd6964932948b8f4d3ea519a53288516caa2fb43f', '[\"*\"]', NULL, NULL, '2024-03-24 09:21:31', '2024-03-24 09:21:31'),
(4, 'App\\Models\\User', 2, 'auth_token', '92879897084e611bc97feebbb746265c62635722aa1dbba11a72f9ae716d5ed2', '[\"*\"]', NULL, NULL, '2024-03-24 09:23:22', '2024-03-24 09:23:22'),
(5, 'App\\Models\\User', 1, 'auth_token', '8c6d464a52064f42cf7386eb321420d011a9738ac6e8bf790c71803f0c3ffe04', '[\"*\"]', NULL, NULL, '2024-03-25 10:07:39', '2024-03-25 10:07:39'),
(6, 'App\\Models\\User', 1, 'auth_token', 'c2c8aca2625041c9fabe3b2abe614018e17f4611e6abfa78f33c268154b97082', '[\"*\"]', NULL, NULL, '2024-03-25 10:32:42', '2024-03-25 10:32:42'),
(7, 'App\\Models\\User', 1, 'auth_token', '9b066d175dcbb5498bb8879739e299c7dadafd0c23e5a2e6f246341f9c03a461', '[\"*\"]', '2024-03-25 12:42:38', NULL, '2024-03-25 12:19:40', '2024-03-25 12:42:38'),
(8, 'App\\Models\\User', 2, 'auth_token', '161522ad20a75f0025fb5cd8a459058116b018061e96770aef0afce9a0098499', '[\"*\"]', '2024-03-25 13:00:16', NULL, '2024-03-25 12:48:13', '2024-03-25 13:00:16'),
(9, 'App\\Models\\User', 2, 'auth_token', '2dd3226e59fd85921a4778ac47c73630a16a575fc58338acc993216acc93f193', '[\"*\"]', NULL, NULL, '2024-03-25 13:18:12', '2024-03-25 13:18:12'),
(10, 'App\\Models\\User', 2, 'auth_token', '76b7e710984fc2d2e1214efb7f0823835fc785f391433e8772c999cafb5dd508', '[\"*\"]', NULL, NULL, '2024-03-25 13:18:25', '2024-03-25 13:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birthDay` int(11) NOT NULL,
  `birthMonth` varchar(255) NOT NULL,
  `birthYear` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `isOnline` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `profileImage` text NOT NULL,
  `coverImage` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `surname`, `othername`, `username`, `email`, `phone`, `password`, `gender`, `birthDay`, `birthMonth`, `birthYear`, `address`, `state`, `country`, `isOnline`, `isActive`, `email_verified_at`, `profileImage`, `coverImage`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abdulhammed', 'Ridwan Adio', 'adioridwan', 'adioridwan7841@gmail.com', 0, '$2y$10$cPuYd/58L2wbKSg7YopUEe7KHnID8//.DDlFU82o4xb/iccUT4R8K', 'male', 30, 'September', 1991, NULL, NULL, NULL, 0, 1, NULL, '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"49.5\" stroke=\"#03A9F4\" stroke-width=\"1\" fill=\"#03A9F4\" /><text font-size=\"48\" fill=\"#FFFFFF\" x=\"50%\" y=\"50%\" dy=\".1em\" style=\"line-height:1\" alignment-baseline=\"middle\" text-anchor=\"middle\" dominant-baseline=\"central\">AR</text></svg>', NULL, NULL, NULL, '2024-03-25 12:19:40', '2024-03-25 12:19:40'),
(2, 'Abdulhammed', 'Ridwan Adio', 'adioridwan', 'adioridwan784@gmail.com', 0, '$2y$10$meSW9ie3dAJdBGzIWYThcueS3p1UiSTk.80bj/uWWjatMpdT4mG5y', 'male', 30, 'September', 1991, NULL, NULL, NULL, 0, 1, '2024-03-25 12:59:44', '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"49.5\" stroke=\"#03A9F4\" stroke-width=\"1\" fill=\"#03A9F4\" /><text font-size=\"48\" fill=\"#FFFFFF\" x=\"50%\" y=\"50%\" dy=\".1em\" style=\"line-height:1\" alignment-baseline=\"middle\" text-anchor=\"middle\" dominant-baseline=\"central\">AR</text></svg>', NULL, NULL, NULL, '2024-03-25 12:48:13', '2024-03-25 13:18:25');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
