-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 08:47 AM
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
  `noCalon` int(11) NOT NULL,
  `namaCalon` varchar(150) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kodJawatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calon`
--

INSERT INTO `calon` (`noCalon`, `namaCalon`, `gambar`, `kodJawatan`) VALUES
(1, 'Muhammad Faiz', '20260629_070725_9741.png', 1),
(2, 'Tan Mei Ling', '20260629_070950_7934.png', 1),
(3, 'Rajesh Kumar', '20260629_071421_5988.png', 2),
(4, 'Nur Aisyah', '20260629_071035_8862.png', 2),
(5, 'Aiman Hakim', 'aiman.png', 3),
(6, 'Shalini Kumar', 'shalini.png', 3),
(7, 'Nurul Syafiqah', 'nurul.png', 4),
(8, 'Lee Hui Ling', 'lee.png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `jawatan`
--

CREATE TABLE `jawatan` (
  `kodJawatan` int(11) NOT NULL,
  `namaJawatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawatan`
--

INSERT INTO `jawatan` (`kodJawatan`, `namaJawatan`) VALUES
(1, 'Pengerusi'),
(2, 'Timbalan Pengerusi'),
(3, 'Setiausaha'),
(4, 'Bendahari');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `noKP` varchar(20) NOT NULL,
  `namaPengguna` varchar(150) NOT NULL,
  `katalaluan` varchar(255) NOT NULL,
  `StatusPengguna` varchar(20) NOT NULL DEFAULT 'pengundi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`noKP`, `namaPengguna`, `katalaluan`, `StatusPengguna`) VALUES
('090321100363', 'hadif', '123456', 'pengundi'),
('222222222222', 'Ahmad Ali', 'pass123', 'pengundi'),
('333333333333', 'Siti Nurhaliza', 'pass123', 'pengundi'),
('admin', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `undian`
--

CREATE TABLE `undian` (
  `idUndian` int(11) NOT NULL,
  `noKP` varchar(20) NOT NULL,
  `noCalon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`noCalon`),
  ADD KEY `fk_calon_jawatan` (`kodJawatan`);

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
-- Indexes for table `undian`
--
ALTER TABLE `undian`
  ADD PRIMARY KEY (`idUndian`),
  ADD KEY `fk_undian_pengguna` (`noKP`),
  ADD KEY `fk_undian_calon` (`noCalon`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calon`
--
ALTER TABLE `calon`
  MODIFY `noCalon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jawatan`
--
ALTER TABLE `jawatan`
  MODIFY `kodJawatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `undian`
--
ALTER TABLE `undian`
  MODIFY `idUndian` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calon`
--
ALTER TABLE `calon`
  ADD CONSTRAINT `fk_calon_jawatan` FOREIGN KEY (`kodJawatan`) REFERENCES `jawatan` (`kodJawatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `undian`
--
ALTER TABLE `undian`
  ADD CONSTRAINT `fk_undian_calon` FOREIGN KEY (`noCalon`) REFERENCES `calon` (`noCalon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_undian_pengguna` FOREIGN KEY (`noKP`) REFERENCES `pengguna` (`noKP`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
