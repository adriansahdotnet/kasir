-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2019 at 12:36 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukom`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `level` varchar(30) NOT NULL,
  `status` varchar(55) NOT NULL,
  `tgl` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `nama`, `username`, `password`, `level`, `status`, `tgl`) VALUES
(1, 'Administrator', 'admin', '$2y$10$3nMcofiQSK/zeqwaU7P2Ueie/xgaR9w5MCf171ib9LyFnCl1jo6BC', 'admin', 'On', '11 Sep 2019');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(250) NOT NULL,
  `nama_barang` varchar(1000) NOT NULL,
  `kategori` varchar(1000) NOT NULL,
  `jenis_satuan` varchar(30) NOT NULL,
  `harga_pokok` bigint(20) NOT NULL,
  `harga_eceran` bigint(20) NOT NULL,
  `jumlah_stok` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `kategori`, `jenis_satuan`, `harga_pokok`, `harga_eceran`, `jumlah_stok`) VALUES
(3, 'BG000037611', 'Kopiko inin enak', 'Minuman', 'Kotak', 10000, 12000, 0),
(4, '6576485376735454', 'Beras', 'Minuman', 'Kaleng', 10000, 12000, 48),
(10, 'BG000013217', 'Rumah Mewah', 'Minuman', 'Lusin', 50000, 60000, 100);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_pembelian` varchar(250) NOT NULL,
  `uang_tunai` varchar(250) NOT NULL,
  `total_bayar` varchar(200) NOT NULL,
  `tanggal` varchar(30) NOT NULL,
  `kasir` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `id_pembelian`, `uang_tunai`, `total_bayar`, `tanggal`, `kasir`) VALUES
(1, '1568544946230', '50000', '48000', '15 Sep 2019 17:57:04', 'admin'),
(2, '1568558927571', '11000', '10000', '15 Sep 2019 21:49:03', 'admin'),
(3, '156859588672', '25000', '20000', '16 Sep 2019 8:06:37', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `id_pembelian` varchar(250) NOT NULL,
  `kode_barang` varchar(250) NOT NULL,
  `nama_barang` varchar(1000) NOT NULL,
  `jumlah` varchar(30) NOT NULL,
  `harga_eceran` varchar(55) NOT NULL,
  `total` varchar(250) NOT NULL,
  `tanggal` varchar(250) NOT NULL,
  `priode` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `id_pembelian`, `kode_barang`, `nama_barang`, `jumlah`, `harga_eceran`, `total`, `tanggal`, `priode`) VALUES
(1, '1568544946230', '6576485376735454', 'Beras', '1', '12000', '12000', '18 Apr 2019 17:57:04', 'Sep 2019'),
(2, '1568544946230', '6576485376735454', 'Beras', '1', '12000', '12000', '15 Sep 2019 17:57:04', 'Sep 2019'),
(3, '1568544946230', '6576485376735454', 'Beras', '1', '12000', '12000', '15 Sep 2019 17:57:04', 'Sep 2019'),
(4, '1568544946230', '6576485376735454', 'Beras', '1', '12000', '12000', '15 Sep 2019 17:57:04', 'Sep 2020'),
(5, '1568558927571', 'BG000013217', 'Pop Mie', '1', '10000', '10000', '15 Sep 2019 21:49:03', 'Sep 2019'),
(6, '156859588672', 'BG000013217', 'Pop Mie', '2', '10000', '20000', '16 Sep 2019 8:06:37', 'Sep 2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
