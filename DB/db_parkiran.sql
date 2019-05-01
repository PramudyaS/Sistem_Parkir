-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2018 at 04:04 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_parkiran`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_parkiran`
-- (See below for the actual view)
--
CREATE TABLE `laporan_parkiran` (
`id` int(10) unsigned
,`plat_nomor` varchar(7)
,`jenis_kendaraan` varchar(255)
,`jam_masuk` time
,`jam_keluar` time
,`tgl_masuk` date
,`tgl_keluar` date
,`total` int(50)
,`bayar` int(50)
,`kembalian` int(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2018_06_19_081552_create_parkir_masuk_table', 1),
(13, '2018_06_19_120219_create_tarif', 1),
(14, '2018_06_24_064828_stok__parkir', 2);

-- --------------------------------------------------------

--
-- Table structure for table `parkir_keluar`
--

CREATE TABLE `parkir_keluar` (
  `id` int(10) NOT NULL,
  `plat_nomor` varchar(7) NOT NULL,
  `jenis_kendaraan` varchar(20) NOT NULL,
  `jam_keluar` time NOT NULL,
  `tgl_keluar` date NOT NULL,
  `total` int(50) NOT NULL,
  `bayar` int(50) NOT NULL,
  `kembalian` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parkir_keluar`
--

INSERT INTO `parkir_keluar` (`id`, `plat_nomor`, `jenis_kendaraan`, `jam_keluar`, `tgl_keluar`, `total`, `bayar`, `kembalian`) VALUES
(1, 'F2022HY', 'Motor', '08:52:33', '2018-06-28', 1000, 5000, 4000),
(2, 'B4568ED', 'Mobil', '08:50:41', '2018-06-28', 2000, 5000, 3000),
(4, 'B2000JJ', 'Motor', '11:37:35', '2018-06-28', 1000, 5000, 4000);

--
-- Triggers `parkir_keluar`
--
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `parkir_keluar` FOR EACH ROW BEGIN
UPDATE stok_parkir 
SET stok = stok + 1
WHERE jenis_kendaraan = New.jenis_kendaraan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `parkir_masuk`
--

CREATE TABLE `parkir_masuk` (
  `id` int(10) UNSIGNED NOT NULL,
  `plat_nomor` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `jenis_kendaraan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jam_masuk` time NOT NULL,
  `tgl_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parkir_masuk`
--

INSERT INTO `parkir_masuk` (`id`, `plat_nomor`, `jenis_kendaraan`, `jam_masuk`, `tgl_masuk`) VALUES
(1, 'F2022HY', 'Motor', '08:46:41', '2018-06-28'),
(2, 'B4568ED', 'Mobil', '08:47:31', '2018-06-28'),
(3, 'F3386DD', 'Motor', '08:53:09', '2018-06-28'),
(4, 'B2000JJ', 'Motor', '11:37:09', '2018-06-28');

--
-- Triggers `parkir_masuk`
--
DELIMITER $$
CREATE TRIGGER `kurang_stok` AFTER INSERT ON `parkir_masuk` FOR EACH ROW BEGIN
UPDATE stok_parkir 
SET stok = stok - 1
WHERE jenis_kendaraan = New.jenis_kendaraan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_parkir`
--

CREATE TABLE `stok_parkir` (
  `id` int(10) UNSIGNED NOT NULL,
  `stok` int(11) NOT NULL,
  `jenis_kendaraan` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stok_parkir`
--

INSERT INTO `stok_parkir` (`id`, `stok`, `jenis_kendaraan`) VALUES
(1, 48, 'Mobil'),
(2, 48, 'Motor');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id` int(10) UNSIGNED NOT NULL,
  `tarif` int(11) NOT NULL,
  `jenis_kendaraan` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id`, `tarif`, `jenis_kendaraan`) VALUES
(2, 2000, 'Mobil'),
(6, 1000, 'Motor'),
(7, 2000, 'Bus');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_user`, `no_telp`, `email`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pramudya Saputra', '083811991964', 'pramudyasaputra89@gmail.com', '$2y$10$/fF2uIMop5TNHE0CmpEGiOw3QLJ/849LSDF1v9vEjz2gHLbTqFRme', 'Manager', 'Knd4asbe0qSJk8HGDdOWLx89NwiD65BoEwGlo6lmZ6nECOPKEesEgVJMxnWz', '2018-06-22 00:56:41', '2018-06-22 00:56:41'),
(2, 'Nugraha Putra', '081384862659', 'nugraha@gmail.com', '$2y$10$sLdv/gj3grGgNEYSHZ8Rz.rZmHLEZSp4QSBFfvOnEyo52AmtjeLNO', 'Kasir', 'o4yf0GxGcSzE0JxCfkx7JcoQzA4HDDJPBk0raPsu2RRUA7vL4LBFhK6RCmAb', '2018-06-25 15:57:53', '2018-06-27 21:38:37'),
(3, 'Didin Sudrajat', '081212222999', 'didin@gmail.com', '$2y$10$BvXdv4ItNtbCuRzxeyRj..DXe5lW5fXZRnbJ3kvEG6X43Z4S5P/5e', 'Kasir', NULL, '2018-06-27 06:08:08', '2018-06-27 06:08:08');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_parkiran`
-- (See below for the actual view)
--
CREATE TABLE `v_parkiran` (
`id` int(10) unsigned
,`plat_nomor` varchar(7)
,`jenis_kendaraan` varchar(255)
,`tgl_masuk` date
,`tgl_keluar` date
,`total` int(50)
,`bayar` int(50)
,`kembalian` int(50)
);

-- --------------------------------------------------------

--
-- Structure for view `laporan_parkiran`
--
DROP TABLE IF EXISTS `laporan_parkiran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_parkiran`  AS  select `parkir_masuk`.`id` AS `id`,`parkir_masuk`.`plat_nomor` AS `plat_nomor`,`parkir_masuk`.`jenis_kendaraan` AS `jenis_kendaraan`,`parkir_masuk`.`jam_masuk` AS `jam_masuk`,`parkir_keluar`.`jam_keluar` AS `jam_keluar`,`parkir_masuk`.`tgl_masuk` AS `tgl_masuk`,`parkir_keluar`.`tgl_keluar` AS `tgl_keluar`,`parkir_keluar`.`total` AS `total`,`parkir_keluar`.`bayar` AS `bayar`,`parkir_keluar`.`kembalian` AS `kembalian` from (`parkir_masuk` join `parkir_keluar` on((`parkir_masuk`.`id` = `parkir_keluar`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_parkiran`
--
DROP TABLE IF EXISTS `v_parkiran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_parkiran`  AS  select `parkir_masuk`.`id` AS `id`,`parkir_masuk`.`plat_nomor` AS `plat_nomor`,`parkir_masuk`.`jenis_kendaraan` AS `jenis_kendaraan`,`parkir_masuk`.`tgl_masuk` AS `tgl_masuk`,`parkir_keluar`.`tgl_keluar` AS `tgl_keluar`,`parkir_keluar`.`total` AS `total`,`parkir_keluar`.`bayar` AS `bayar`,`parkir_keluar`.`kembalian` AS `kembalian` from (`parkir_masuk` join `parkir_keluar` on((`parkir_masuk`.`id` = `parkir_keluar`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkir_keluar`
--
ALTER TABLE `parkir_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkir_masuk`
--
ALTER TABLE `parkir_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `stok_parkir`
--
ALTER TABLE `stok_parkir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `parkir_masuk`
--
ALTER TABLE `parkir_masuk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `stok_parkir`
--
ALTER TABLE `stok_parkir`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
