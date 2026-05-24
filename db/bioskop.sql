-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 04:49 AM
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
-- Database: `bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_admin`
--

CREATE TABLE `aktivitas_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktivitas_admin`
--

INSERT INTO `aktivitas_admin` (`id`, `deskripsi`, `waktu`) VALUES
(1, 'Admin menambahkan film baru: Top Gun: Maverick', '2025-08-14 11:17:27'),
(2, 'Admin menambahkan jadwal tayang film Top Gun: Maverick', '2025-08-14 11:18:27'),
(3, 'Admin menghapus studio \'Studio 2\'', '2025-08-14 11:18:51'),
(4, 'Admin menambahkan film baru: Sore: Istri dari Masa Depan', '2025-08-14 13:41:13'),
(5, 'Admin menambahkan studio \'2\' dengan status aktif', '2025-08-14 13:41:27'),
(6, 'Admin menambahkan jadwal tayang film Sore: Istri dari Masa Depan', '2025-08-14 13:41:52'),
(7, 'Admin menghapus studio \'Studio 1\'', '2025-08-17 09:03:51'),
(8, 'Admin menghapus studio \'2\'', '2025-08-17 09:03:55'),
(9, 'Admin menghapus film dengan ID 4', '2025-08-17 09:04:09'),
(10, 'Admin menghapus film dengan ID 3', '2025-08-17 09:04:13'),
(11, 'Admin menambahkan film baru: Avengers: Endgame', '2025-08-17 10:46:28'),
(12, 'Admin menambahkan studio \'Studio 1\' dengan status aktif', '2025-08-17 10:46:58'),
(13, 'Admin menghapus studio \'Studio 1\'', '2025-08-17 10:47:25'),
(14, 'Admin menambahkan studio \'1\' dengan status aktif', '2025-08-17 10:47:32'),
(15, 'Admin menambahkan jadwal tayang film Avengers: Endgame', '2025-08-17 10:47:52'),
(16, 'Admin menambahkan studio \'2\' dengan status tidak', '2025-08-17 10:49:44'),
(17, 'Admin menambahkan film baru: Sore: Istri dari Masa Depan', '2025-08-22 03:00:43'),
(18, 'Admin menghapus studio \'2\'', '2025-08-22 03:01:06'),
(19, 'Admin menambahkan studio \'2\' dengan status aktif', '2025-08-22 03:01:15'),
(20, 'Admin menambahkan jadwal tayang film Sore: Istri dari Masa Depan', '2025-08-22 03:01:46'),
(21, 'Admin menambahkan film baru: Top Gun: Maverick', '2025-08-22 03:45:37'),
(22, 'Admin menambahkan studio \'3\' dengan status aktif', '2025-08-22 03:46:19'),
(23, 'Admin menambahkan jadwal tayang film Top Gun: Maverick', '2025-08-22 03:46:57'),
(24, 'Admin menambahkan jadwal tayang film Sore: Istri dari Masa Depan', '2025-08-22 03:49:22'),
(25, 'Admin menambahkan studio \'3\' dengan status aktif', '2025-08-22 04:00:17'),
(26, 'Admin menambahkan jadwal tayang film Avengers: Endgame', '2025-08-22 04:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(150) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `durasi` smallint(5) UNSIGNED NOT NULL,
  `poster` varchar(300) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `judul`, `genre`, `durasi`, `poster`, `created_at`) VALUES
(5, 'Avengers: Endgame', 'Laga/Fiksi Ilmiah', 180, '1755427588_download (1).jpeg', '2025-08-17 10:46:28'),
(6, 'Sore: Istri dari Masa Depan', 'Drama, Romantis', 120, '1755831643_download.jpeg', '2025-08-22 03:00:43'),
(7, 'Top Gun: Maverick', 'Laga/Petualangan', 123, '1755834337_MV5BMDBkZDNjMWEtOTdmMi00NmExLTg5MmMtNTFlYTJlNWY5YTdmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', '2025-08-22 03:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_tayang`
--

CREATE TABLE `jadwal_tayang` (
  `id` int(10) UNSIGNED NOT NULL,
  `film_id` int(10) UNSIGNED NOT NULL,
  `studio_id` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_tayang`
--

INSERT INTO `jadwal_tayang` (`id`, `film_id`, `studio_id`, `tanggal`, `jam`, `created_at`) VALUES
(6, 5, 5, '2025-08-18', '19:47:00', '2025-08-17 10:47:52'),
(7, 6, 7, '2025-08-22', '11:01:00', '2025-08-22 03:01:46'),
(8, 7, 8, '2025-08-22', '11:46:00', '2025-08-22 03:46:57'),
(9, 6, 8, '2025-08-22', '11:46:00', '2025-08-22 03:49:22'),
(10, 5, 9, '2025-08-22', '11:00:00', '2025-08-22 04:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `jadwal_tayang_id` int(10) UNSIGNED NOT NULL,
  `nomor_kursi` varchar(10) NOT NULL,
  `waktu_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `user_id`, `jadwal_tayang_id`, `nomor_kursi`, `waktu_pesan`) VALUES
(4, 2, 6, 'A1', '2025-08-17 10:49:09'),
(5, 2, 6, 'E5', '2025-08-17 10:50:02'),
(6, 2, 6, 'A2', '2025-08-20 08:49:37'),
(7, 2, 6, 'F6', '2025-08-22 02:53:23'),
(8, 2, 7, 'A1', '2025-08-22 03:04:24'),
(9, 2, 8, 'A1', '2025-08-22 03:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_studio` varchar(80) NOT NULL,
  `jumlah_kursi` smallint(5) UNSIGNED NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id`, `nama_studio`, `jumlah_kursi`, `status`, `created_at`) VALUES
(5, '1', 180, 'aktif', '2025-08-17 10:47:32'),
(7, '2', 60, 'aktif', '2025-08-22 03:01:15'),
(8, '3', 60, 'aktif', '2025-08-22 03:46:19'),
(9, '3', 1000, 'aktif', '2025-08-22 04:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','penonton') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin', '2025-08-14 10:48:18'),
(2, 'ridho', 'ridho300805', 'penonton', '2025-08-14 10:48:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_admin`
--
ALTER TABLE `aktivitas_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_tayang`
--
ALTER TABLE `jadwal_tayang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_jt_tanggal` (`tanggal`),
  ADD KEY `idx_jt_film` (`film_id`),
  ADD KEY `idx_jt_studio` (`studio_id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_kursi_per_jadwal` (`jadwal_tayang_id`,`nomor_kursi`),
  ADD KEY `idx_pemesanan_user` (`user_id`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_admin`
--
ALTER TABLE `aktivitas_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_tayang`
--
ALTER TABLE `jadwal_tayang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_tayang`
--
ALTER TABLE `jadwal_tayang`
  ADD CONSTRAINT `fk_jt_film` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_jt_studio` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `fk_ps_jadwal` FOREIGN KEY (`jadwal_tayang_id`) REFERENCES `jadwal_tayang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ps_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
