-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 07:24 PM
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
-- Database: `blockchain_stok`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model`, `model_id`, `description`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'delete', 'User', 4, 'Menghapus user: putras', '{\"id\":4,\"name\":\"putras\",\"email\":\"eko12345@gmail.com\",\"role\":\"anggota\",\"created_at\":\"2025-12-11T05:25:18.000000Z\",\"updated_at\":\"2025-12-11T05:25:18.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 08:40:58', '2026-01-10 08:40:58'),
(2, 1, 'create', 'User', 6, 'Membuat user baru: fatan', NULL, '{\"name\":\"fatan\",\"email\":\"123@gmail.com\",\"role\":\"anggota\",\"updated_at\":\"2026-01-15T12:02:12.000000Z\",\"created_at\":\"2026-01-15T12:02:12.000000Z\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 05:02:12', '2026-01-15 05:02:12'),
(3, 1, 'update', 'User', 6, 'Mengupdate user: fatan dan fatih', '{\"id\":6,\"name\":\"fatan\",\"email\":\"123@gmail.com\",\"role\":\"anggota\",\"created_at\":\"2026-01-15T12:02:12.000000Z\",\"updated_at\":\"2026-01-15T12:02:12.000000Z\"}', '{\"id\":6,\"name\":\"fatan dan fatih\",\"email\":\"123@gmail.com\",\"role\":\"anggota\",\"created_at\":\"2026-01-15T12:02:12.000000Z\",\"updated_at\":\"2026-01-15T12:06:10.000000Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 05:06:10', '2026-01-15 05:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stok_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` enum('create','update','delete') NOT NULL,
  `data` text NOT NULL,
  `previous_hash` varchar(64) NOT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `stok_id`, `action`, `data`, `previous_hash`, `hash`, `is_valid`, `created_at`, `updated_at`) VALUES
(1, 95, 'create', '{\"keuangan_id\":56,\"nama_barang\":\"singkong\",\"jumlah\":2,\"satuan\":\"Kg\",\"jenis\":\"pemasukan\",\"harga\":\"2\",\"total_uang\":4,\"actor\":\"eko saputtra\"}', '0', '7da091ffb224ec8b439dc0455739c4a045ca62a69817cd79a2306264b367bc9c', 1, '2026-01-09 06:46:55', '2026-01-10 08:29:35'),
(2, 96, 'create', '{\"keuangan_id\":57,\"nama_barang\":\"3\",\"jumlah\":2940,\"satuan\":\"Kg\",\"jenis\":\"pemasukan\",\"harga\":\"3\",\"total_uang\":8820,\"actor\":\"eko saputtra\"}', '7da091ffb224ec8b439dc0455739c4a045ca62a69817cd79a2306264b367bc9c', 'aaea393e2355798325c42695a06b6ca6230bf5445591668cce24bc956463c3b6', 1, '2026-01-09 06:47:50', '2026-01-10 08:29:35'),
(3, 97, 'create', '{\"keuangan_id\":58,\"nama_barang\":\"singkong\",\"jumlah\":3000,\"satuan\":\"Kg\",\"jenis\":\"pengeluaran\",\"harga\":\"3\",\"total_uang\":9000,\"actor\":\"eko saputtra\"}', 'aaea393e2355798325c42695a06b6ca6230bf5445591668cce24bc956463c3b6', 'bc0bd4d68e7fa29fd335304708c9b0e97b35860c5788cf406e6448512f9b1857', 1, '2026-01-09 06:53:08', '2026-01-10 08:29:35'),
(4, 98, 'create', '{\"keuangan_id\":59,\"nama_barang\":\"singkong\",\"jumlah\":1,\"satuan\":\"Kg\",\"jenis\":\"pengeluaran\",\"harga\":\"1\",\"total_uang\":1,\"actor\":\"eko saputtra\"}', 'bc0bd4d68e7fa29fd335304708c9b0e97b35860c5788cf406e6448512f9b1857', '59765ed3925b17376f4fbd114dd0a642082898763b004b3696043373567ee5a2', 1, '2026-01-09 10:12:49', '2026-01-10 08:29:35'),
(5, 99, 'create', '{\"keuangan_id\":60,\"nama_barang\":\"eko\",\"jumlah\":1,\"satuan\":\"Kg\",\"jenis\":\"pengeluaran\",\"harga\":\"1\",\"total_uang\":1,\"actor\":\"eko saputtra\"}', '59765ed3925b17376f4fbd114dd0a642082898763b004b3696043373567ee5a2', 'a4ec50ffc557f0a1a87548de3d701f0a6d3b505b90bec6c855431cc911514510', 1, '2026-01-09 10:13:20', '2026-01-10 08:29:35'),
(6, 103, 'create', '{\"actor\":\"eko saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":64,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', 'a4ec50ffc557f0a1a87548de3d701f0a6d3b505b90bec6c855431cc911514510', 'd3be305f4c6242106aa2fe13516e4fb58bd0ae048f7951d8b72af238bbda5548', 1, '2026-01-09 10:27:42', '2026-01-10 08:29:35'),
(7, 104, 'create', '{\"actor\":\"eko saputtra\",\"harga\":\"1\",\"jenis\":\"pengeluaran\",\"jumlah\":1000,\"keuangan_id\":65,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1000}', 'd3be305f4c6242106aa2fe13516e4fb58bd0ae048f7951d8b72af238bbda5548', '34b7ef6ab2e0423b01815e758472f79d80e117ae61f073af9334bbbd9282ab2d', 1, '2026-01-09 10:29:11', '2026-01-10 08:29:35'),
(8, 105, 'create', '{\"actor\":\"eko saputtra\",\"harga\":\"3000\",\"jenis\":\"pemasukan\",\"jumlah\":3000,\"keuangan_id\":66,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":9000000}', '34b7ef6ab2e0423b01815e758472f79d80e117ae61f073af9334bbbd9282ab2d', 'c5a18d0fa913fdfabce0bdf4ad534d3e1e7eba7e2c15253242315af2c6d3878b', 1, '2026-01-09 16:49:00', '2026-01-10 08:29:35'),
(9, 106, 'create', '{\"actor\":\"kadek aja\",\"harga\":\"5000\",\"jenis\":\"pemasukan\",\"jumlah\":900,\"keuangan_id\":67,\"nama_barang\":\"pupuk\",\"satuan\":\"Kg\",\"total_uang\":4500000}', 'c5a18d0fa913fdfabce0bdf4ad534d3e1e7eba7e2c15253242315af2c6d3878b', '97fb93f3d0fc7e321fdde3894c612ca799ab7b792515ffeba20365f950d7ae62', 1, '2026-01-10 05:16:41', '2026-01-10 08:29:35'),
(10, 107, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":68,\"nama_barang\":\"1\",\"satuan\":\"Kg\",\"total_uang\":1}', '97fb93f3d0fc7e321fdde3894c612ca799ab7b792515ffeba20365f950d7ae62', 'b9cd5226c972019cc76761a5411c08eb82872d3e0c8b4d6e86ea77d4d4d7e963', 1, '2026-01-10 07:25:36', '2026-01-10 08:29:35'),
(11, 108, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":69,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', 'b9cd5226c972019cc76761a5411c08eb82872d3e0c8b4d6e86ea77d4d4d7e963', 'f55d997586c134e875a2c5c6032b91e7951a3169f320b6bd1faa726129507876', 1, '2026-01-10 07:26:35', '2026-01-10 08:29:35'),
(12, 109, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":70,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', 'f55d997586c134e875a2c5c6032b91e7951a3169f320b6bd1faa726129507876', 'b8702a62e9bd5aebbcccd3dc1ffe3348d9be6699f0ed855db912d54e8e0da3ac', 1, '2026-01-10 07:28:43', '2026-01-10 08:29:35'),
(13, 110, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":71,\"nama_barang\":\"eko\",\"satuan\":\"Kg\",\"total_uang\":1}', 'b8702a62e9bd5aebbcccd3dc1ffe3348d9be6699f0ed855db912d54e8e0da3ac', 'a810b6047539b6f771597d8e370e2dac5e300e45d89382fccc4aa7db2c9c5518', 1, '2026-01-10 07:29:46', '2026-01-10 08:29:35'),
(14, 111, 'create', '{\"actor\":\"saputtra\",\"harga\":\"5000\",\"jenis\":\"pengeluaran\",\"jumlah\":1000,\"keuangan_id\":72,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":5000000}', 'a810b6047539b6f771597d8e370e2dac5e300e45d89382fccc4aa7db2c9c5518', '0772d6aa304e570a9e9c33d2e84f5d3e68088d130357395431abfaeffedf951b', 1, '2026-01-10 07:32:44', '2026-01-10 08:29:35'),
(15, 112, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":73,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', '0772d6aa304e570a9e9c33d2e84f5d3e68088d130357395431abfaeffedf951b', '873d06720803671d717b9c9a3d5c408ccc53405e0b4d07c638ea3f08e3e30787', 1, '2026-01-10 08:12:14', '2026-01-10 08:29:35'),
(16, 113, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":74,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', '873d06720803671d717b9c9a3d5c408ccc53405e0b4d07c638ea3f08e3e30787', '0d6686e2aa731b8f8de0bbfc7fae3dc614e557bb2041f0bc36521b2989e5f345', 1, '2026-01-10 08:21:32', '2026-01-10 08:29:35'),
(17, 114, 'create', '{\"actor\":\"saputtra\",\"harga\":\"3000\",\"jenis\":\"pemasukan\",\"jumlah\":1000,\"keuangan_id\":75,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":3000000}', '0d6686e2aa731b8f8de0bbfc7fae3dc614e557bb2041f0bc36521b2989e5f345', '835b7c588185c03c70a6bbea7caef1cc4fdbb4ecf5c06b960c30389cd0262d40', 1, '2026-01-10 08:28:10', '2026-01-10 08:29:35'),
(18, 115, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":76,\"nama_barang\":\"1\",\"satuan\":\"Kg\",\"total_uang\":1}', '835b7c588185c03c70a6bbea7caef1cc4fdbb4ecf5c06b960c30389cd0262d40', '2b61c17403d6837780d9cd253b4b54bf564ce9e9ec4839c48fbbbaa12ff7cb1b', 1, '2026-01-10 08:30:35', '2026-01-10 08:30:35'),
(19, 116, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":77,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', '2b61c17403d6837780d9cd253b4b54bf564ce9e9ec4839c48fbbbaa12ff7cb1b', 'cdd4adf8c959338331d74f4d453e46d7611e9cf81c9941755cd175b7691e174a', 1, '2026-01-10 08:38:34', '2026-01-10 08:38:34'),
(20, 117, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1000,\"keuangan_id\":78,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1000}', 'cdd4adf8c959338331d74f4d453e46d7611e9cf81c9941755cd175b7691e174a', '459bfe34f6a4f064310c29b16fec64079f3be0e882435804892706837087946e', 1, '2026-01-10 09:09:45', '2026-01-10 09:09:45'),
(21, 118, 'create', '{\"actor\":\"saputtra\",\"harga\":\"3000\",\"jenis\":\"pemasukan\",\"jumlah\":1000,\"keuangan_id\":79,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":3000000}', '459bfe34f6a4f064310c29b16fec64079f3be0e882435804892706837087946e', '34d281ee4a667792536d9b4d124dc9410a20d89d877ee58fc1e38acfa3b304b1', 1, '2026-01-10 09:16:26', '2026-01-10 09:16:26'),
(22, 119, 'create', '{\"actor\":\"saputtra\",\"harga\":\"2\",\"jenis\":\"pemasukan\",\"jumlah\":2,\"keuangan_id\":80,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":4}', '34d281ee4a667792536d9b4d124dc9410a20d89d877ee58fc1e38acfa3b304b1', 'b3567d13a61126cc93c9858e31693b2edf1528530d86114a343e2dc4a81d15be', 1, '2026-01-15 03:41:12', '2026-01-15 03:41:12'),
(23, 120, 'create', '{\"actor\":\"saputtra\",\"harga\":\"1\",\"jenis\":\"pemasukan\",\"jumlah\":1,\"keuangan_id\":81,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":1}', 'b3567d13a61126cc93c9858e31693b2edf1528530d86114a343e2dc4a81d15be', '6803b5e64df781efcc17ed16a11381df2d91a4263b0a0715c7ac8685bd740b04', 1, '2026-01-15 05:48:51', '2026-01-15 05:48:51'),
(24, 121, 'create', '{\"actor\":\"saputtra\",\"harga\":\"3000\",\"jenis\":\"pemasukan\",\"jumlah\":900,\"keuangan_id\":82,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":2700000}', '6803b5e64df781efcc17ed16a11381df2d91a4263b0a0715c7ac8685bd740b04', '094d4658d601b98377001a9349d0000eb33cf4dcd0ddbb31a0c57e3ece776109', 1, '2026-01-18 05:26:56', '2026-01-18 05:26:56'),
(25, 122, 'create', '{\"actor\":\"saputtra\",\"harga\":\"3000\",\"jenis\":\"pengeluaran\",\"jumlah\":3000,\"keuangan_id\":83,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":9000000}', '094d4658d601b98377001a9349d0000eb33cf4dcd0ddbb31a0c57e3ece776109', '7b42c3fea96371bfc917122950d8779fdb058cce14e787c2b7206cf8e68348f8', 1, '2026-01-18 05:35:05', '2026-01-18 05:35:05'),
(26, 123, 'create', '{\"actor\":\"saputtra\",\"harga\":\"5000\",\"jenis\":\"pemasukan\",\"jumlah\":100,\"keuangan_id\":84,\"nama_barang\":\"Singkong A\",\"satuan\":\"Kg\",\"total_uang\":500000}', '7b42c3fea96371bfc917122950d8779fdb058cce14e787c2b7206cf8e68348f8', '332c62e79941961b34e95cb4fcc6cf880835a0ea2798b44f3b0ddc557a3e6f7d', 1, '2026-01-22 12:09:44', '2026-01-22 12:09:44'),
(27, 124, 'create', '{\"actor\":\"saputtra\",\"harga\":\"5000\",\"jenis\":\"pemasukan\",\"jumlah\":1000,\"keuangan_id\":85,\"nama_barang\":\"singkong B\",\"satuan\":\"Kg\",\"total_uang\":5000000}', '332c62e79941961b34e95cb4fcc6cf880835a0ea2798b44f3b0ddc557a3e6f7d', '346c364d03f8c22c991ea9706e65c5bd8f4fb573247be39222007716c6e59ecb', 1, '2026-01-22 12:12:21', '2026-01-22 12:12:21'),
(28, 125, 'create', '{\"actor\":\"saputtra\",\"harga\":\"5000\",\"jenis\":\"pemasukan\",\"jumlah\":90,\"keuangan_id\":86,\"nama_barang\":\"singkong C\",\"satuan\":\"Kg\",\"total_uang\":450000}', '346c364d03f8c22c991ea9706e65c5bd8f4fb573247be39222007716c6e59ecb', '65cf4839ef7e8bfbd94598c8a1085cdd8c09148761ae5ddcb51bfe35a605a2da', 1, '2026-01-22 12:13:52', '2026-01-22 12:13:52'),
(29, 126, 'create', '{\"actor\":\"saputtra\",\"harga\":\"5000\",\"jenis\":\"pengeluaran\",\"jumlah\":50,\"keuangan_id\":87,\"nama_barang\":\"singkong di jual\",\"satuan\":\"Kg\",\"total_uang\":250000}', '65cf4839ef7e8bfbd94598c8a1085cdd8c09148761ae5ddcb51bfe35a605a2da', '6b7fc3355b607a1ccdba00a1f1b36e9a36ed2dc799649ecc73ae46d60af81e96', 1, '2026-01-22 12:15:27', '2026-01-22 12:15:27'),
(30, 127, 'create', '{\"actor\":\"saputtra\",\"harga\":\"5000\",\"jenis\":\"pemasukan\",\"jumlah\":100,\"keuangan_id\":88,\"nama_barang\":\"singkong\",\"satuan\":\"Kg\",\"total_uang\":500000}', '6b7fc3355b607a1ccdba00a1f1b36e9a36ed2dc799649ecc73ae46d60af81e96', '8cd2736b566b6882afd0c59c2095db13dda1d942192ab139d5476130a5db990c', 1, '2026-01-22 12:20:15', '2026-01-22 12:20:15');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan`
--

CREATE TABLE `keuangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stok_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis` enum('pemasukan','pengeluaran') NOT NULL,
  `jumlah_asli` decimal(12,2) NOT NULL COMMENT 'Jumlah sebelum potongan (kg)',
  `potongan_persen` decimal(5,2) DEFAULT 0.00 COMMENT 'Potongan kualitas (%)',
  `jumlah_bersih` decimal(12,2) NOT NULL COMMENT 'Jumlah setelah potongan (kg)',
  `harga` decimal(12,2) NOT NULL COMMENT 'Harga per kg',
  `total_uang` decimal(14,2) NOT NULL COMMENT 'jumlah_bersih × harga',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keuangan`
--

INSERT INTO `keuangan` (`id`, `stok_id`, `jenis`, `jumlah_asli`, `potongan_persen`, `jumlah_bersih`, `harga`, `total_uang`, `keterangan`, `created_at`, `updated_at`) VALUES
(46, 85, 'pemasukan', 1.00, 0.00, 1000.00, 3000.00, 3000000.00, 'Pemasukan singkong', '2025-01-09 05:36:19', '2025-01-09 06:00:49'),
(48, 87, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 06:03:27', '2026-01-09 06:03:27'),
(49, 88, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 06:25:34', '2026-01-09 06:25:34'),
(52, 91, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 06:35:53', '2026-01-09 06:35:53'),
(53, 92, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 06:40:33', '2026-01-09 06:40:33'),
(54, 93, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 06:43:26', '2026-01-09 06:43:26'),
(55, 94, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 06:44:31', '2026-01-09 06:44:31'),
(56, 95, 'pemasukan', 2.00, 0.00, 2.00, 2.00, 4.00, 'Pemasukan singkong', '2026-01-09 06:46:55', '2026-01-09 06:46:55'),
(57, 96, 'pemasukan', 3.00, 2.00, 2940.00, 3.00, 8820.00, 'Pemasukan 3', '2026-01-09 06:47:50', '2026-01-09 06:47:50'),
(58, 97, 'pengeluaran', 3.00, 0.00, 3000.00, 3.00, 9000.00, 'Pengeluaran singkong', '2026-01-09 06:53:08', '2026-01-09 06:53:08'),
(59, 98, 'pengeluaran', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pengeluaran singkong', '2026-01-09 10:12:49', '2026-01-09 10:12:49'),
(60, 99, 'pengeluaran', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pengeluaran eko', '2026-01-09 10:13:20', '2026-01-09 10:13:20'),
(64, 103, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-09 10:27:42', '2026-01-09 10:27:42'),
(65, 104, 'pengeluaran', 1.00, 0.00, 1000.00, 1.00, 1000.00, 'Pengeluaran singkong', '2026-01-09 10:29:11', '2026-01-09 10:29:11'),
(66, 105, 'pemasukan', 3.00, 0.00, 3000.00, 3000.00, 9000000.00, 'Pemasukan singkong', '2026-01-09 16:49:00', '2026-01-09 16:49:00'),
(67, 106, 'pemasukan', 1.00, 10.00, 900.00, 5000.00, 4500000.00, 'Pemasukan pupuk', '2026-01-10 05:16:41', '2026-01-10 05:16:41'),
(68, 107, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan 1', '2026-01-10 07:25:36', '2026-01-10 07:25:36'),
(69, 108, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-10 07:26:35', '2026-01-10 07:26:35'),
(70, 109, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-10 07:28:43', '2026-01-10 07:28:43'),
(71, 110, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan eko', '2026-01-10 07:29:46', '2026-01-10 07:29:46'),
(72, 111, 'pengeluaran', 1.00, 0.00, 1000.00, 5000.00, 5000000.00, 'Pengeluaran singkong', '2026-01-10 07:32:44', '2026-01-10 07:32:44'),
(73, 112, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-10 08:12:14', '2026-01-10 08:12:14'),
(74, 113, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-10 08:21:32', '2026-01-10 08:21:32'),
(75, 114, 'pemasukan', 1.00, 0.00, 1000.00, 3000.00, 3000000.00, 'Pemasukan singkong', '2026-01-10 08:28:10', '2026-01-10 08:28:10'),
(76, 115, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan 1', '2026-01-10 08:30:35', '2026-01-10 08:30:35'),
(77, 116, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-10 08:38:34', '2026-01-10 08:38:34'),
(78, 117, 'pemasukan', 1.00, 0.00, 1000.00, 1.00, 1000.00, 'Pemasukan singkong', '2026-01-10 09:09:45', '2026-01-10 09:09:45'),
(79, 118, 'pemasukan', 1.00, 0.00, 1000.00, 3000.00, 3000000.00, 'Pemasukan singkong', '2026-01-10 09:16:26', '2026-01-10 09:16:26'),
(80, 119, 'pemasukan', 2.00, 0.00, 2.00, 2.00, 4.00, 'Pemasukan singkong', '2026-01-15 03:41:12', '2026-01-15 03:41:12'),
(81, 120, 'pemasukan', 1.00, 0.00, 1.00, 1.00, 1.00, 'Pemasukan singkong', '2026-01-15 05:48:51', '2026-01-15 05:48:51'),
(82, 121, 'pemasukan', 1.00, 10.00, 900.00, 3000.00, 2700000.00, 'Pemasukan singkong', '2026-01-18 05:26:56', '2026-01-18 05:26:56'),
(83, 122, 'pengeluaran', 3.00, 0.00, 3000.00, 3000.00, 9000000.00, 'Pengeluaran singkong', '2026-01-18 05:35:05', '2026-01-18 05:35:05'),
(84, 123, 'pemasukan', 100.00, 0.00, 100.00, 5000.00, 500000.00, 'Pemasukan Singkong A', '2026-01-22 12:09:44', '2026-01-22 12:09:44'),
(85, 124, 'pemasukan', 1.00, 0.00, 1000.00, 5000.00, 5000000.00, 'Pemasukan singkong B', '2026-01-22 12:12:21', '2026-01-22 12:12:21'),
(86, 125, 'pemasukan', 1.00, 10.00, 90.00, 5000.00, 450000.00, 'Pemasukan singkong C', '2026-01-22 12:13:52', '2026-01-22 12:13:52'),
(87, 126, 'pengeluaran', 50.00, 0.00, 50.00, 5000.00, 250000.00, 'Pengeluaran singkong di jual', '2026-01-22 12:15:27', '2026-01-22 12:15:27'),
(88, 127, 'pemasukan', 100.00, 0.00, 100.00, 5000.00, 500000.00, 'Pemasukan singkong', '2026-01-22 12:20:15', '2026-01-22 12:20:15');

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
(1, '2025_09_01_092526_create_users_table', 1),
(2, '2025_09_01_092527_create_keuangan_table', 1),
(3, '2025_09_01_092527_create_stok_table', 1),
(4, '2025_09_01_092529_create_blockchain_logs_table', 1),
(5, '2025_09_02_142917_create_blocks_table', 2),
(6, '2025_11_12_100329_create_cache_table', 3),
(7, '2025_01_10_000000_add_jenis_to_stok_table', 4),
(8, '2025_01_10_100000_add_is_valid_to_blocks_table', 4),
(9, '2026_01_10_150000_create_activity_logs_table', 5),
(10, '2026_01_10_151000_create_settings_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'Kelompok Tani Singkong mesuji', 'string', '2026-01-10 08:17:24', '2026-01-10 08:37:52'),
(2, 'app_description', 'Sistem Manajemen Stok Singkong Berbasis Blockchain', 'string', '2026-01-10 08:17:24', '2026-01-10 08:17:24'),
(3, 'contact_email', 'info@singkong.com', 'string', '2026-01-10 08:17:24', '2026-01-10 08:17:24'),
(4, 'contact_phone', '08123456789', 'string', '2026-01-10 08:17:24', '2026-01-10 08:17:24'),
(5, 'address', 'Jl. Singkong No. 123', 'string', '2026-01-10 08:17:24', '2026-01-10 08:37:52'),
(6, 'min_stock_alert', '1', 'string', '2026-01-10 08:17:24', '2026-01-11 23:42:01'),
(7, 'enable_notifications', '1', 'string', '2026-01-10 08:17:24', '2026-01-10 08:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah_asli` int(11) DEFAULT NULL,
  `potongan_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `jumlah` decimal(12,2) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `satuan_asli` varchar(50) NOT NULL DEFAULT 'kg',
  `harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `jenis` enum('pemasukan','pengeluaran') NOT NULL DEFAULT 'pemasukan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id`, `nama_barang`, `jumlah_asli`, `potongan_persen`, `jumlah`, `satuan`, `satuan_asli`, `harga`, `jenis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(85, 'singkong', NULL, 0.00, 1000.00, 'kg', 'ton', 3000.00, 'pemasukan', '2026-01-09 05:36:19', '2026-01-09 06:00:49', NULL),
(87, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 06:03:27', '2026-01-09 06:03:27', NULL),
(88, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 06:25:34', '2026-01-09 06:25:34', NULL),
(91, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 06:35:52', '2026-01-09 06:35:52', NULL),
(92, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 06:40:33', '2026-01-09 06:40:33', NULL),
(93, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 06:43:26', '2026-01-09 06:43:26', NULL),
(94, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 06:44:31', '2026-01-09 06:44:31', NULL),
(95, 'singkong', NULL, 0.00, 2.00, 'kg', 'kg', 2.00, 'pemasukan', '2026-01-09 06:46:55', '2026-01-09 06:46:55', NULL),
(96, '3', NULL, 0.00, 2940.00, 'kg', 'ton', 3.00, 'pemasukan', '2026-01-09 06:47:50', '2026-01-09 06:47:50', NULL),
(97, 'singkong', NULL, 0.00, -3000.00, 'kg', 'ton', 3.00, 'pemasukan', '2026-01-09 06:53:08', '2026-01-09 06:53:08', NULL),
(98, 'singkong', NULL, 0.00, -1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 10:12:49', '2026-01-09 10:12:49', NULL),
(99, 'eko', NULL, 0.00, -1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 10:13:20', '2026-01-09 10:13:20', NULL),
(103, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-09 10:27:42', '2026-01-09 10:27:42', NULL),
(104, 'singkong', NULL, 0.00, -1000.00, 'kg', 'ton', 1.00, 'pengeluaran', '2026-01-09 10:29:11', '2026-01-09 10:29:11', NULL),
(105, 'singkong', NULL, 0.00, 3000.00, 'kg', 'ton', 3000.00, 'pemasukan', '2026-01-09 16:48:59', '2026-01-09 16:48:59', NULL),
(106, 'pupuk', NULL, 0.00, 900.00, 'kg', 'ton', 5000.00, 'pemasukan', '2026-01-10 05:16:41', '2026-01-10 05:16:41', NULL),
(107, '1', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 07:25:36', '2026-01-10 07:25:36', NULL),
(108, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 07:26:35', '2026-01-10 07:26:35', NULL),
(109, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 07:28:43', '2026-01-10 07:28:43', NULL),
(110, 'eko', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 07:29:46', '2026-01-10 07:29:46', NULL),
(111, 'singkong', NULL, 0.00, -1000.00, 'kg', 'ton', 5000.00, 'pengeluaran', '2026-01-10 07:32:44', '2026-01-10 07:32:44', NULL),
(112, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 08:12:14', '2026-01-10 08:12:14', NULL),
(113, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 08:21:32', '2026-01-10 08:21:32', NULL),
(114, 'singkong', NULL, 0.00, 1000.00, 'kg', 'ton', 3000.00, 'pemasukan', '2026-01-10 08:28:10', '2026-01-10 08:28:10', NULL),
(115, '1', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 08:30:35', '2026-01-10 08:30:35', NULL),
(116, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-10 08:38:34', '2026-01-10 08:38:34', NULL),
(117, 'singkong', NULL, 0.00, 1000.00, 'kg', 'ton', 1.00, 'pemasukan', '2026-01-10 09:09:45', '2026-01-10 09:09:45', NULL),
(118, 'singkong', NULL, 0.00, 1000.00, 'kg', 'ton', 3000.00, 'pemasukan', '2026-01-10 09:16:26', '2026-01-10 09:16:26', NULL),
(119, 'singkong', NULL, 0.00, 2.00, 'kg', 'kg', 2.00, 'pemasukan', '2026-01-15 03:41:12', '2026-01-15 03:41:12', NULL),
(120, 'singkong', NULL, 0.00, 1.00, 'kg', 'kg', 1.00, 'pemasukan', '2026-01-15 05:48:51', '2026-01-15 05:48:51', NULL),
(121, 'singkong', NULL, 0.00, 900.00, 'kg', 'ton', 3000.00, 'pemasukan', '2026-01-18 05:26:56', '2026-01-18 05:26:56', NULL),
(122, 'singkong', NULL, 0.00, -3000.00, 'kg', 'ton', 3000.00, 'pengeluaran', '2026-01-18 05:35:05', '2026-01-18 05:35:05', NULL),
(123, 'Singkong A', NULL, 0.00, 100.00, 'kg', 'kg', 5000.00, 'pemasukan', '2026-01-22 12:09:44', '2026-01-22 12:09:44', NULL),
(124, 'singkong B', NULL, 0.00, 1000.00, 'kg', 'ton', 5000.00, 'pemasukan', '2026-01-22 12:12:21', '2026-01-22 12:12:21', NULL),
(125, 'singkong C', NULL, 0.00, 90.00, 'kg', 'kuintal', 5000.00, 'pemasukan', '2026-01-22 12:13:52', '2026-01-22 12:13:52', NULL),
(126, 'singkong di jual', NULL, 0.00, -50.00, 'kg', 'kg', 5000.00, 'pengeluaran', '2026-01-22 12:15:27', '2026-01-22 12:15:27', NULL),
(127, 'singkong', NULL, 0.00, 100.00, 'kg', 'kg', 5000.00, 'pemasukan', '2026-01-22 12:20:15', '2026-01-22 12:20:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','anggota') DEFAULT 'anggota',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'saputtra', 'eko@gmail.com', '$2y$12$xTQsh2qwW6y.OiWKW9xNS.ZwW31K/1yZMVhrd9llavQJs4sx7Mv4y', 'admin', '2025-09-02 08:44:12', '2026-01-09 17:21:23'),
(2, 'eko saputtra', 'ekoo@gmail.com', '$2y$12$0et6k1elZUDGB0fpjU1Iyu21hhb1asJYv3AGGodn9bgv7.Zzlus16', 'anggota', '2025-09-15 12:27:57', '2025-09-15 12:27:57'),
(3, 'mantap', 'eko123@gmail.com', '$2y$12$GwFZhjKHPYaVYCPvMDVkY..pJJYgK7blWYvCs4HIxs8j8zdAAD.Ju', 'anggota', '2025-11-24 10:42:44', '2025-11-24 10:42:44'),
(5, 'kadek aja', 'kadek@gmail.com', '$2y$12$3iYL1bAJCYv1E8ioTzkHnOQoTi8bDaHIKCvPianymvReJ4yIuS6Sa', 'anggota', '2026-01-10 05:14:56', '2026-01-10 05:15:59'),
(6, 'fatan dan fatih', '123@gmail.com', '$2y$12$5qNxIEurhVi6km8wSQa/QuiNmjOupUnW3ymuUnJME3I5tl7NxP.cK', 'anggota', '2026-01-15 05:02:12', '2026-01-15 05:06:10'),
(7, 'kadek', 'Ikadek@gmail.com', '$2y$12$TNlzRNULZQXHQ9aqbH0e3OqXuyFt.7KLUsTL0LikGjGJQs2Ty8kO6', 'anggota', '2026-01-22 11:55:05', '2026-01-22 12:04:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blocks_stok_id_foreign` (`stok_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `keuangan`
--
ALTER TABLE `keuangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_stok` (`stok_id`),
  ADD KEY `idx_jenis` (`jenis`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `keuangan`
--
ALTER TABLE `keuangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_stok_id_foreign` FOREIGN KEY (`stok_id`) REFERENCES `stok` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
