-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/01/2025 às 21:55
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atendebem_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adms`
--

CREATE TABLE `adms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `adms`
--

INSERT INTO `adms` (`id`, `user_id`, `active`, `created_at`, `updated_at`) VALUES
(2, 11, 1, '2025-01-26 04:45:42', '2025-01-26 04:45:42'),
(4, 127, 1, '2025-01-31 18:40:21', '2025-01-31 18:40:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `attendants`
--

CREATE TABLE `attendants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_administrator_fk` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `attendants`
--

INSERT INTO `attendants` (`id`, `id_administrator_fk`, `user_id`, `active`, `created_at`, `updated_at`) VALUES
(2, 2, 12, 1, '2025-01-26 04:55:00', '2025-01-26 04:55:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `reason_for_consultation` varchar(255) NOT NULL,
  `symptoms` text NOT NULL,
  `date_time` datetime NOT NULL,
  `prescribed_medication` varchar(255) DEFAULT NULL,
  `medical_recommendations` text DEFAULT NULL,
  `doctor_observations` text DEFAULT NULL,
  `performed_procedures` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `consultations`
--

INSERT INTO `consultations` (`id`, `patient_id`, `reason_for_consultation`, `symptoms`, `date_time`, `prescribed_medication`, `medical_recommendations`, `doctor_observations`, `performed_procedures`, `diagnosis`, `additional_notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'dor no cabelo', 'dor de cabelo', '2025-01-26 02:26:56', 'gardenal', 'amarrar', 'loukura acumulada', 'lobotomia', 'doente', 'mantenha distancia', '2025-01-26 05:27:12', '2025-01-26 05:27:12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_administrator_fk` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `crm` varchar(10) NOT NULL,
  `specialty` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `doctors`
--

INSERT INTO `doctors` (`id`, `id_administrator_fk`, `user_id`, `crm`, `specialty`, `active`, `created_at`, `updated_at`) VALUES
(2, 2, 14, 'CRM89880', 'Otorrino', 1, '2025-01-26 05:21:43', '2025-01-26 05:21:43'),
(72, 2, 120, 'CRM0040', 'Curandeira e Shinigame', 1, '2025-01-30 16:24:29', '2025-01-30 16:24:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
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
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(84, '0001_01_01_000000_create_users_table', 1),
(85, '0001_01_01_000001_create_cache_table', 1),
(86, '0001_01_01_000002_create_jobs_table', 1),
(87, '2024_12_28_173532_create_personal_access_tokens_table', 1),
(88, '2025_01_01_154203_create_adms_table', 1),
(89, '2025_01_01_154804_create_attendants_table', 1),
(90, '2025_01_01_155843_create_nurses_table', 1),
(91, '2025_01_01_160257_create_doctors_table', 1),
(92, '2025_01_02_153741_create_patients_table', 1),
(93, '2025_01_02_160240_create_consultations_table', 1),
(94, '2025_01_05_000537_add_columns_to_patients_table', 1),
(95, '2025_01_18_235113_add_last_used_at_to_personal_access_tokens', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nurses`
--

CREATE TABLE `nurses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_administrator_fk` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coren` varchar(255) NOT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `nurses`
--

INSERT INTO `nurses` (`id`, `id_administrator_fk`, `user_id`, `coren`, `specialty`, `active`, `created_at`, `updated_at`) VALUES
(2, 2, 13, '123456789', NULL, 1, '2025-01-26 04:58:30', '2025-01-26 04:58:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `emergency_phone` varchar(255) DEFAULT NULL,
  `sugery_history` varchar(255) DEFAULT NULL,
  `allergy` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `blood_pressure` varchar(255) DEFAULT NULL,
  `heart_rate` int(11) DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `oxygen_saturation` int(11) DEFAULT NULL,
  `temperature` double DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `responsible_name` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bleeding` int(11) NOT NULL DEFAULT 0,
  `difficulty_breathing` int(11) NOT NULL DEFAULT 0,
  `edema` int(11) NOT NULL DEFAULT 0,
  `nausea` int(11) NOT NULL DEFAULT 0,
  `vomiting` int(11) NOT NULL DEFAULT 0,
  `flag_triage` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `emergency_phone`, `sugery_history`, `allergy`, `blood_type`, `blood_pressure`, `heart_rate`, `respiratory_rate`, `oxygen_saturation`, `temperature`, `chief_complaint`, `responsible_name`, `emergency_contact`, `created_at`, `updated_at`, `bleeding`, `difficulty_breathing`, `edema`, `nausea`, `vomiting`, `flag_triage`) VALUES
(5, 124, '11987654321', 'Corte profundo tratado anteriormente', 'Nenhuma conhecida', 'O+', '120', 72, 16, 98, 36.8, 'Ferimentos após batalha', 'Kisuke Urahara', NULL, '2025-01-31 04:56:43', '2025-01-31 04:56:43', 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `abilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`abilities`)),
  `expires_at` timestamp NULL DEFAULT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `name`, `token`, `abilities`, `expires_at`, `tokenable_type`, `tokenable_id`, `created_at`, `updated_at`, `last_used_at`) VALUES
(6, 'Token-Valido', 'c4db3233216a8e2104a40783c4549c57dd4ec0b7371b36a27199d5ab5d462cb6', '[\"*\"]', NULL, 'App\\Models\\User', 4, '2025-01-26 04:07:43', '2025-01-26 04:41:27', '2025-01-26 04:41:27'),
(259, 'Token-Valido', '3fed0cbc0b26425055caa9514cc34cdeea3a2d7722684b1f4e3eb5a0a9ae7d72', '[\"*\"]', NULL, 'App\\Models\\User', 14, '2025-01-30 03:14:03', '2025-01-31 20:52:48', '2025-01-31 20:52:48'),
(260, 'Token-Valido', '8f1276364622c20e2e8d03c70441da1987da388a4bfa154f090fb3281edc950e', '[\"*\"]', NULL, 'App\\Models\\User', 14, '2025-01-30 03:14:44', '2025-01-30 03:14:44', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('099LiIrbc4P0dfoxbdxaJ2Hh8FuIYdnGBAXrWL9O', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ01PSXJqQ0hvRXlmNHhTYUdJT0V4enBMVjc1d2FGZEVIckF4N0VrSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738209645),
('bVIDxGABtk9IJxTYu1v68gq0gSXII74d4Xpduwpr', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWFXRzZaSjM3SFRpbXRzalFJVmdBNXR2THlRaXFvbWVJdFlKR0w0RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738285231),
('RUhUFyDgW1YVdivx5E0WShoc8HHHCl1ZFG2js8xF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjlMcmJBUE9xUGRFY2hxN2Q1N0hrMWRRNTBiRTYxWUMzREhwYWRTaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738045817),
('Sc8Okt2FgBWAuPap5d9McH1EtWM4bDHqTVuEfvyP', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkp5ZE9vOTVGaFUwMmI1cFBiSUVXMmk4YmRJRFhscXBENEdDR25sNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738297691),
('yOYTPO8hgocEY3hRzogvHYucSz02xYAyaScdChYq', NULL, '127.0.0.1', 'PostmanRuntime/7.43.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVRSajZ3RUd4dzJ1Q0lZaThhc3h5a3JqdlBPZTBXSFNabWhvWjlkUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738251836);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `block` varchar(255) DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `flag` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `cpf`, `sex`, `birth`, `photo`, `place_of_birth`, `city`, `neighborhood`, `street`, `block`, `apartment`, `role`, `age`, `flag`, `created_at`, `updated_at`) VALUES
(11, 'Mateo Block IV', 'teste@admin.com', '2025-01-26 04:45:40', '$2y$12$mkjVVFWwWCMgF07k2gM8wu0jiFzlbVlsL1xg8GrOJEl37yXz4T.f2', '(570) 697-1497', '816.923.031-13', 'male', '2016-10-22', 'https://via.placeholder.com/640x480.png/00eebb?text=vitae', 'Port Catherine', 'Lavadaland', 'placeat', 'Stanton Lights', '12177', 'corporis', 'admin', 62, 0, '2025-01-26 04:45:41', '2025-01-26 04:45:41'),
(12, 'Maisson Leal da Silva', 'teste@atendente.com', NULL, '$2y$12$sfTYPOGzhSlhYLEeE1iey.p/DSgIou.TzrrdK4VLln.NaH.7Xj.Qa', '539999999999', '04266130074', 'masculino', '1995-12-25', NULL, 'Pelotas', 'Pelotas', 'Fragata', 'Irmao', '167', '106', 'attendant', 29, 0, '2025-01-26 04:55:00', '2025-01-26 04:55:00'),
(13, 'Luciane de Almeida Rodrigues', 'teste@enfe.com', NULL, '$2y$12$Wt9dEX6qLLNMvCppg81YQOIiAFOxv9Mzfw8lOJgqD3jwJ7/FDnUNu', '55555555555', '04266130078', 'feminino', '1992-05-08', NULL, 'Pelotas', 'Pelotas', 'Fragata', 'Irmao', '167', '106', 'nurse', 32, 0, '2025-01-26 04:58:30', '2025-01-26 04:58:30'),
(14, 'Manuelle Rodrigues', 'teste@doutora.com', NULL, '$2y$12$Vk9bZPG2/Fw6LT4MdZ/o0.JypNLbm4CL/0GzY.eV6b1jUL0dPwUai', '5399999999', '44444444444', 'feminino', '2000-09-23', NULL, 'Pelotas', 'Pelotas', 'Fragata', 'Irmao', '167', '106', 'doctor', 24, 0, '2025-01-26 05:21:43', '2025-01-30 03:14:03'),
(120, 'Retsu Unohana', 'unohana@gotei13.com', NULL, '$2y$12$G0EeNH8X72fGz8f17chJ2.Q1R451w8dIYLHg7aQHGgVljvwbb42ki', '0000500000', '04255189654', 'feminino', '1950-12-12', NULL, 'Soul Society', 'Seireitei', '4ª Divisão', 'Quartel-General', '1', 'Sala', 'doctor', 74, 0, '2025-01-30 16:24:29', '2025-01-30 16:24:55'),
(124, 'Ichigo Kurosaki', 'ichigo.kurosaki@karakura.jp', NULL, '$2y$12$X.wOVMoRz2AAKxBzr4btluBQsizSKJJzzV0AT3VNegZ5h8P1P2REG', '9012345678', '12345678900', 'masculino', '1989-07-15', NULL, 'Karakura, Japão', 'Karakura', 'Centro', 'Rua Shinigami', '12B', '202', 'Shinigami Substituto', 35, 1, '2025-01-31 04:55:32', '2025-01-31 04:56:43'),
(127, 'Byakuya Kuchiki', 'byakuya.kuchiki@bleach.com', NULL, '$2y$12$HdBymNasB7S0DzBqGUFVB.ukIUe8rhIgIosk8Onk6nPfuywFfgO7K', '811234567890', NULL, 'male', '1980-01-01', 'https://example.com/images/byakuya.jpg', 'Rukongai', 'Seireitei', 'Noble District', 'Kuchiki Manor', '1', '5', 'Captain', 45, 0, '2025-01-31 18:40:21', '2025-01-31 18:40:21');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adms`
--
ALTER TABLE `adms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adms_user_id_foreign` (`user_id`);

--
-- Índices de tabela `attendants`
--
ALTER TABLE `attendants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendants_id_administrator_fk_foreign` (`id_administrator_fk`),
  ADD KEY `attendants_user_id_foreign` (`user_id`);

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_id_administrator_fk_foreign` (`id_administrator_fk`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nurses_coren_unique` (`coren`),
  ADD KEY `nurses_id_administrator_fk_foreign` (`id_administrator_fk`),
  ADD KEY `nurses_user_id_foreign` (`user_id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_cpf_unique` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adms`
--
ALTER TABLE `adms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `attendants`
--
ALTER TABLE `attendants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de tabela `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `adms`
--
ALTER TABLE `adms`
  ADD CONSTRAINT `adms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `attendants`
--
ALTER TABLE `attendants`
  ADD CONSTRAINT `attendants_id_administrator_fk_foreign` FOREIGN KEY (`id_administrator_fk`) REFERENCES `adms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_id_administrator_fk_foreign` FOREIGN KEY (`id_administrator_fk`) REFERENCES `adms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_id_administrator_fk_foreign` FOREIGN KEY (`id_administrator_fk`) REFERENCES `adms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nurses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
