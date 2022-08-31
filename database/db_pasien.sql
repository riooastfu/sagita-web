-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2022 at 08:42 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pasien`
--

-- --------------------------------------------------------

--
-- Table structure for table `anak`
--

DROP TABLE IF EXISTS `anak`;
CREATE TABLE IF NOT EXISTS `anak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_anak` varchar(50) NOT NULL,
  `id_ibu` int(11) NOT NULL,
  `jenis_kelamin` varchar(5) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `akta_lahir` text DEFAULT NULL,
  `validasi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anak`
--

INSERT INTO `anak` (`id`, `nama_anak`, `id_ibu`, `jenis_kelamin`, `tgl_lahir`, `akta_lahir`, `validasi`) VALUES
(1, 'jonathan', 1, 'L', '2020-07-14', NULL, NULL),
(2, 'Aleza', 1, 'P', '2020-05-11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_testing`
--

DROP TABLE IF EXISTS `data_testing`;
CREATE TABLE IF NOT EXISTS `data_testing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `umur` int(3) DEFAULT NULL,
  `berat` decimal(3,1) DEFAULT NULL,
  `jk` varchar(2) DEFAULT NULL,
  `tinggi` int(3) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_training`
--

DROP TABLE IF EXISTS `data_training`;
CREATE TABLE IF NOT EXISTS `data_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `umur` int(3) DEFAULT NULL,
  `berat` decimal(3,1) DEFAULT NULL,
  `jk` varchar(2) DEFAULT NULL,
  `tinggi` int(3) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_upload`
--

DROP TABLE IF EXISTS `data_upload`;
CREATE TABLE IF NOT EXISTS `data_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_file` varchar(255) DEFAULT NULL,
  `tanggal_upload` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ibu`
--

DROP TABLE IF EXISTS `ibu`;
CREATE TABLE IF NOT EXISTS `ibu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ibu` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `validasi` tinyint(1) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ibu`
--

INSERT INTO `ibu` (`id`, `nama_ibu`, `email`, `password`, `validasi`, `disabled`) VALUES
(1, 'Ibu Pertiwi', 'pertiwi@email.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengecekan`
--

DROP TABLE IF EXISTS `pengecekan`;
CREATE TABLE IF NOT EXISTS `pengecekan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_anak` int(11) NOT NULL,
  `berat_badan` decimal(5,2) NOT NULL,
  `tinggi_badan` int(3) NOT NULL,
  `usia` int(2) DEFAULT NULL,
  `tanggal_check` date DEFAULT NULL,
  `indeks_massa` decimal(5,2) DEFAULT NULL,
  `status_gizi` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='tabel untuk menyimpan data gizi per pasien';

--
-- Dumping data for table `pengecekan`
--

INSERT INTO `pengecekan` (`id`, `id_anak`, `berat_badan`, `tinggi_badan`, `usia`, `tanggal_check`, `indeks_massa`, `status_gizi`) VALUES
(1, 1, '40.00', 120, 26, '2022-07-10', '27.78', 'Gizi Normal');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$BYFY/vc1wZ9e.VxCf2TY5.ZLdynNc1vS1dYLUtVVHpsQHEDxTsgJq', 1, 1, 1576903028),
(2, 'user', 'user@gmail.com', '$2y$10$BYFY/vc1wZ9e.VxCf2TY5.ZLdynNc1vS1dYLUtVVHpsQHEDxTsgJq', 2, 1, 1653403107);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
