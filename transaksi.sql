-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 03:01 AM
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
-- Database: `financefutsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `fDate` date DEFAULT NULL,
  `fType` enum('masuk','keluar') DEFAULT NULL,
  `fAmount` decimal(10,2) DEFAULT NULL,
  `fDesc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `fDate`, `fType`, `fAmount`, `fDesc`) VALUES
(2, '2025-01-03', 'masuk', 110.00, 'Kutip Duit'),
(3, '2025-01-04', 'keluar', 80.00, 'Tempah Court Abeeden'),
(4, '2025-01-07', 'masuk', 130.00, 'Collect duit'),
(5, '2025-01-20', 'keluar', 80.00, 'Tempah Court Futsal Abedeen'),
(6, '2025-01-20', 'keluar', 80.00, 'Beli Bola'),
(7, '2025-01-27', 'masuk', 120.00, 'Collect Duit'),
(8, '2025-02-03', 'keluar', 80.00, 'Tempah Court Futsal Abedeen'),
(9, '2025-02-05', 'masuk', 110.00, 'Collect Duit'),
(10, '2025-02-18', 'keluar', 80.00, 'Tempah Court Futsal Abedeen'),
(11, '2025-02-18', 'masuk', 20.00, 'Collect duit player game sebelum'),
(12, '2025-02-24', 'keluar', 80.00, 'Tempah Court Abeeden'),
(13, '2025-03-04', 'masuk', 150.00, 'Collect Duit'),
(14, '2025-04-22', 'keluar', 80.00, 'Tempah Court Abeeden'),
(15, '2025-04-25', 'masuk', 96.80, 'Collect duit'),
(16, '2025-04-29', 'keluar', 60.00, 'Tempah Court MPS'),
(17, '2025-05-02', 'masuk', 90.00, 'Collect duit RM5 seorang'),
(18, '2025-05-02', 'keluar', 15.80, 'Beli air untuk team'),
(19, '2025-05-13', 'keluar', 80.00, 'Tempah Court Abedeen'),
(20, '2025-05-15', 'masuk', 78.00, 'Collect duit RM10*5 + RM8*4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
