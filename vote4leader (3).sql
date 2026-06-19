-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2026 at 03:21 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vote4leader`
--

-- --------------------------------------------------------

--
-- Table structure for table `calon`
--

CREATE TABLE `calon` (
  `idCalon` int(11) NOT NULL,
  `namaCalon` varchar(150) NOT NULL,
  `kodJawatan` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tarikhDaftar` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calon`
--

INSERT INTO `calon` (`idCalon`, `namaCalon`, `kodJawatan`, `gambar`, `tarikhDaftar`, `status`) VALUES
(10, 'Fauzi Husin', 1, 'fauzi.png', '2026-06-16 08:53:28', 'aktif'),
(11, 'Nur Aisyah', 1, 'nur.png', '2026-06-16 08:53:28', 'aktif'),
(12, 'Zainab', 2, 'zainab.png', '2026-06-16 08:53:28', 'aktif'),
(13, 'Siti Aminah', 2, 'siti.png', '2026-06-16 08:53:28', 'aktif'),
(14, 'Nurul Syafiqah', 3, 'nurul.png', '2026-06-16 08:53:29', 'aktif'),
(15, 'Lee Hui Ling', 3, 'lee.png', '2026-06-16 08:53:29', 'aktif'),
(16, 'Aiman Hakim', 4, 'aiman.png', '2026-06-16 08:53:29', 'aktif'),
(17, 'Shalini Kumar', 4, 'shalini.png', '2026-06-16 08:53:29', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `jawatan`
--

CREATE TABLE `jawatan` (
  `kodJawatan` int(11) NOT NULL,
  `namaJawatan` varchar(100) NOT NULL,
  `penerangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawatan`
--

INSERT INTO `jawatan` (`kodJawatan`, `namaJawatan`, `penerangan`) VALUES
(1, 'Pengerusi', ''),
(2, 'Timbalan Pengerusi', ''),
(3, 'Setiausaha', ''),
(4, 'Bendahari', '');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `noKP` varchar(20) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jenisPengguna` varchar(20) NOT NULL DEFAULT 'pengundi',
  `katalaluan` varchar(255) DEFAULT NULL,
  `tarikhDaftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`noKP`, `nama`, `jenisPengguna`, `katalaluan`, `tarikhDaftar`) VALUES
('090321100363', 'dif', 'pengundi', '123456', '2026-06-15 12:30:19'),
('090321100364', 'twes', 'pengundi', '123456', '2026-06-16 09:10:36'),
('123456356789', 'dif', 'pengundi', '123456', '2026-06-15 12:48:29'),
('123456789101', 'abu hakim', 'pengundi', '123456', '2026-06-15 12:46:27'),
('154536454536', 'dif', 'pengundi', '123456', '2026-06-16 09:05:09'),
('222222222222', 'Ahmad Ali', 'pengundi', 'pass123', '2026-05-11 12:21:43'),
('333333333333', 'Siti Nurhaliza', 'pengundi', 'pass12', '2026-05-11 12:21:43'),
('admin', 'admin', 'admin', 'admin', '2026-06-15 11:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `undi`
--

CREATE TABLE `undi` (
  `idUndi` int(11) NOT NULL,
  `idCalon` int(11) NOT NULL,
  `noKPPengundi` varchar(20) NOT NULL,
  `tarikhUndi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`idCalon`);

--
-- Indexes for table `jawatan`
--
ALTER TABLE `jawatan`
  ADD PRIMARY KEY (`kodJawatan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`noKP`);

--
-- Indexes for table `undi`
--
ALTER TABLE `undi`
  ADD PRIMARY KEY (`idUndi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calon`
--
ALTER TABLE `calon`
  MODIFY `idCalon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jawatan`
--
ALTER TABLE `jawatan`
  MODIFY `kodJawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `undi`
--
ALTER TABLE `undi`
  MODIFY `idUndi` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
