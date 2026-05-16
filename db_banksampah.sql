-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2026 at 10:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_banksampah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(10) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
('ADM-002', 'Daoa Suami Zee', 'daoa', '123'),
('ADM-01', 'Administrator', 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `detail_setoran`
--

CREATE TABLE `detail_setoran` (
  `id_detail` bigint NOT NULL,
  `id_setoran` varchar(30) NOT NULL,
  `id_kategori` varchar(10) NOT NULL,
  `berat_kg` float NOT NULL,
  `subtotal_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_setoran`
--

INSERT INTO `detail_setoran` (`id_detail`, `id_setoran`, `id_kategori`, `berat_kg`, `subtotal_harga`) VALUES
(426042800101, 'TRX-S-260428-001', 'ALU-01', 5, 25000),
(426042800102, 'TRX-S-260428-001', 'KER-01', 7, 14000),
(426042900101, 'TRX-S-260429-001', 'ALU-01', 2, 10000),
(426042900102, 'TRX-S-260429-001', 'BES-01', 1, 8000),
(426042900201, 'TRX-S-260429-002', 'KER-01', 1, 2000),
(426042900301, 'TRX-S-260429-003', 'KER-02', 1, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sampah`
--

CREATE TABLE `kategori_sampah` (
  `id_kategori` varchar(10) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `harga_per_kg` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_sampah`
--

INSERT INTO `kategori_sampah` (`id_kategori`, `nama_kategori`, `harga_per_kg`) VALUES
('ALU-01', 'Alumunium', 5000),
('BES-01', 'Besi Padat', 8000),
('KER-01', 'Kertas HVS', 2000),
('KER-02', 'Kertas Koran', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id_nasabah` varchar(20) NOT NULL,
  `nama_nasabah` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `saldo` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`id_nasabah`, `nama_nasabah`, `alamat`, `no_hp`, `password`, `saldo`) VALUES
('NSB-2604-001', 'ilyas', 'bb40', '123', '123', 45500),
('NSB-2605-001', 'Taufik Hidayat', 'bb51', '0981231', '123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penarikan`
--

CREATE TABLE `penarikan` (
  `id_penarikan` varchar(30) NOT NULL,
  `tanggal_tarik` datetime DEFAULT NULL,
  `id_nasabah` varchar(20) NOT NULL,
  `nominal_tarik` int NOT NULL,
  `id_admin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penarikan`
--

INSERT INTO `penarikan` (`id_penarikan`, `tanggal_tarik`, `id_nasabah`, `nominal_tarik`, `id_admin`) VALUES
('TRX-P-260428-001', '2026-04-28 17:11:30', 'NSB-2604-001', 10000, 'ADM-01'),
('TRX-P-260428-002', '2026-04-28 17:15:43', 'NSB-2604-001', 5000, 'ADM-01');

-- --------------------------------------------------------

--
-- Table structure for table `setoran`
--

CREATE TABLE `setoran` (
  `id_setoran` varchar(30) NOT NULL,
  `tanggal_setor` datetime DEFAULT NULL,
  `id_nasabah` varchar(20) NOT NULL,
  `id_admin` varchar(10) NOT NULL,
  `total_seluruh_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `setoran`
--

INSERT INTO `setoran` (`id_setoran`, `tanggal_setor`, `id_nasabah`, `id_admin`, `total_seluruh_harga`) VALUES
('TRX-S-260428-001', '2026-04-28 17:10:30', 'NSB-2604-001', 'ADM-01', 39000),
('TRX-S-260429-001', '2026-04-29 19:39:57', 'NSB-2604-001', 'ADM-01', 18000),
('TRX-S-260429-002', '2026-04-29 19:40:18', 'NSB-2604-001', 'ADM-01', 2000),
('TRX-S-260429-003', '2026-04-29 19:40:25', 'NSB-2604-001', 'ADM-01', 1500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detail_setoran`
--
ALTER TABLE `detail_setoran`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_setoran` (`id_setoran`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_sampah`
--
ALTER TABLE `kategori_sampah`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indexes for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`id_penarikan`),
  ADD KEY `id_nasabah` (`id_nasabah`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `setoran`
--
ALTER TABLE `setoran`
  ADD PRIMARY KEY (`id_setoran`),
  ADD KEY `id_nasabah` (`id_nasabah`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_setoran`
--
ALTER TABLE `detail_setoran`
  ADD CONSTRAINT `detail_setoran_ibfk_1` FOREIGN KEY (`id_setoran`) REFERENCES `setoran` (`id_setoran`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_setoran_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_sampah` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `penarikan_ibfk_1` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id_nasabah`) ON DELETE CASCADE,
  ADD CONSTRAINT `penarikan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Constraints for table `setoran`
--
ALTER TABLE `setoran`
  ADD CONSTRAINT `setoran_ibfk_1` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id_nasabah`) ON DELETE CASCADE,
  ADD CONSTRAINT `setoran_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
