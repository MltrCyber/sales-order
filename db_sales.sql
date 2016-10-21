-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 21 Okt 2016 pada 10.15
-- Versi Server: 5.6.28-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_sales`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
`id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `satuan` varchar(15) NOT NULL,
  `stok` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode`, `nama`, `harga`, `satuan`, `stok`) VALUES
(1, 'AC-001', 'AC SAMSUNG', 0, '-', 0),
(2, 'KP-002', 'Kipas Angin ', 0, '-', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`id` int(11) NOT NULL,
  `kode` varchar(25) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `cp` varchar(50) NOT NULL,
  `telepon` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_marketing` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `kode`, `nama`, `cp`, `telepon`, `email`, `id_marketing`) VALUES
(1, 'CUST1001', 'PT Makmur', 'Bapak Mahmud', '021982918', 'admin@makmur.co.id', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
`id` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `kode` varchar(15) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `petugas` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `delivery`
--

INSERT INTO `delivery` (`id`, `id_invoice`, `kode`, `tanggal`, `petugas`, `status`) VALUES
(1, 1, '3000012016', '2016-03-03', 'Wahyu', 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inquiry`
--

CREATE TABLE IF NOT EXISTS `inquiry` (
`id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `inquiry`
--

INSERT INTO `inquiry` (`id`, `kode`, `id_customer`, `id_marketing`, `tanggal`, `status`) VALUES
(1, 'INQ1001', 1, 2, '2016-03-01', 'quotation'),
(2, 'INQ1002', 1, 2, '2016-03-02', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inquiry_det`
--

CREATE TABLE IF NOT EXISTS `inquiry_det` (
`id` int(11) NOT NULL,
  `id_inquiry` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `harga` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `inquiry_det`
--

INSERT INTO `inquiry_det` (`id`, `id_inquiry`, `id_barang`, `jumlah`, `harga`) VALUES
(1, 1, 1, 20, 2650000),
(2, 2, 2, 35, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
`id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `id_po` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status_bayar` varchar(50) NOT NULL,
  `jenis_pembayaran` varchar(50) NOT NULL,
  `status` varchar(15) NOT NULL,
  `delivery` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoice`
--

INSERT INTO `invoice` (`id`, `kode`, `id_po`, `tanggal`, `status_bayar`, `jenis_pembayaran`, `status`, `delivery`) VALUES
(1, '4000012016', 1, '2016-03-03', 'lunas', 'tunai', 'approve', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE IF NOT EXISTS `pesan` (
`id` int(11) NOT NULL,
  `pengirim_id` int(11) NOT NULL,
  `penerima_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `isi` text NOT NULL,
  `dibaca` tinyint(1) NOT NULL,
  `pesan_id` int(11) NOT NULL,
  `subjek` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `po`
--

CREATE TABLE IF NOT EXISTS `po` (
`id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `id_quotation` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `invoice` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `po`
--

INSERT INTO `po` (`id`, `kode`, `id_quotation`, `id_marketing`, `id_customer`, `tanggal`, `status`, `invoice`) VALUES
(1, '2000012016', 1, 2, 1, '2016-03-03', 'Approve', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `po_det`
--

CREATE TABLE IF NOT EXISTS `po_det` (
`id` int(11) NOT NULL,
  `id_po` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `harga` bigint(20) NOT NULL,
  `harga_beli` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `po_det`
--

INSERT INTO `po_det` (`id`, `id_po`, `id_barang`, `jumlah`, `harga`, `harga_beli`) VALUES
(1, 1, 1, 20, 2650000, 2500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `quotation`
--

CREATE TABLE IF NOT EXISTS `quotation` (
`id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `id_inquiry` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `quotation`
--

INSERT INTO `quotation` (`id`, `kode`, `id_inquiry`, `tanggal`, `status`) VALUES
(1, '1000002016', 1, '2016-03-02', 'so');

-- --------------------------------------------------------

--
-- Struktur dari tabel `so`
--

CREATE TABLE IF NOT EXISTS `so` (
`id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `id_quotation` int(11) NOT NULL,
  `fee` double NOT NULL,
  `total` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `so`
--

INSERT INTO `so` (`id`, `kode`, `id_quotation`, `fee`, `total`, `tanggal`, `status`) VALUES
(1, 'SOR1001', 1, 5, 53000000, '2016-03-02', 'Po');

-- --------------------------------------------------------

--
-- Struktur dari tabel `target`
--

CREATE TABLE IF NOT EXISTS `target` (
`id` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` varchar(5) NOT NULL,
  `target` bigint(20) NOT NULL,
  `bonus` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `target`
--

INSERT INTO `target` (`id`, `id_marketing`, `bulan`, `tahun`, `target`, `bonus`) VALUES
(1, 2, '03', '2015', 50000000, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `kode` varchar(25) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_tlp` varchar(25) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('marketing','admin') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `kode`, `nama`, `alamat`, `no_tlp`, `username`, `password`, `level`) VALUES
(1, '', '', '', '', 'admin', '8cb2237d0679ca88db6464eac60da96345513964', 'admin'),
(2, 'MAR1001', 'Wahyu', 'Malang', '08563155681', '1001', 'dd01903921ea24941c26a48f2cec24e0bb0e8cc7', 'marketing'),
(3, 'MAR1002', 'Tri', 'Malang', '08563155681', '1002', 'a5b1d7e217aa227d5b2b8a84920780cf637960e2', 'marketing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry_det`
--
ALTER TABLE `inquiry_det`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po_det`
--
ALTER TABLE `po_det`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so`
--
ALTER TABLE `so`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `inquiry_det`
--
ALTER TABLE `inquiry_det`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `po_det`
--
ALTER TABLE `po_det`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `so`
--
ALTER TABLE `so`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `target`
--
ALTER TABLE `target`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
