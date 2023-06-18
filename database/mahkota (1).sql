-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2023 pada 06.17
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mahkota`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `license`
--

CREATE TABLE `license` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(50) NOT NULL,
  `icon` text NOT NULL,
  `minus` varchar(1) NOT NULL DEFAULT 'Y',
  `idtoko` varchar(20) NOT NULL,
  `printer` text NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `license`
--

INSERT INTO `license` (`id`, `nama`, `alamat`, `telp`, `icon`, `minus`, `idtoko`, `printer`, `password`) VALUES
(1, 'Mahkota Pontianak', 'Jln. Patimura 71D', '-', '1684200121_LOGO.png', 'Y', '', 'undefined', 'undefined');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbjual`
--

CREATE TABLE `tbjual` (
  `id` varchar(100) NOT NULL,
  `kodecanvas` varchar(100) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idkonsumen` int(11) NOT NULL,
  `idsales` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `subtotal` double NOT NULL,
  `diskon` double NOT NULL,
  `grandtotal` double NOT NULL,
  `cash` double NOT NULL,
  `status_antar` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbjual`
--

INSERT INTO `tbjual` (`id`, `kodecanvas`, `iduser`, `idkonsumen`, `idsales`, `tanggal`, `subtotal`, `diskon`, `grandtotal`, `cash`, `status_antar`, `created_at`, `updated_at`) VALUES
('J-20230418-1-1-00001', '', 1, 1, '', '2023-04-18', 9000, 0, 9000, 1, 'disiapkan', '2023-04-18 11:52:46', '2023-04-18 11:52:46'),
('J-20230516-1-1-00002', '', 1, 10, '', '2023-05-16', 9000, 0, 9000, 1, 'disiapkan', '2023-05-16 01:23:52', '2023-05-16 01:23:52'),
('J-20230612-1-1-00003', '', 1, 1, '', '2023-06-11', 2000, 0, 2000, 1, 'disiapkan', '2023-06-11 17:24:30', '2023-06-11 17:24:30'),
('J-20230612-1-1-00004', '', 1, 9, '', '2023-06-11', 7000, 0, 7000, 1, 'selesai', '2023-06-11 17:24:38', '2023-06-11 17:25:09'),
('J-20230612-1-1-00005', '', 1, 1, '', '2023-06-11', 2000, 0, 2000, 1, 'selesai', '2023-06-11 17:24:50', '2023-06-11 17:25:06'),
('J-20230612-1-11-00006', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:15', '2023-06-12 02:57:15'),
('J-20230612-1-11-00007', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:17', '2023-06-12 02:57:17'),
('J-20230612-1-11-00008', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:18', '2023-06-12 02:57:18'),
('J-20230612-1-11-00009', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:18', '2023-06-12 02:57:18'),
('J-20230612-1-11-00010', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:18', '2023-06-12 02:57:18'),
('J-20230612-1-11-00011', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:20', '2023-06-12 02:57:20'),
('J-20230612-1-11-00012', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:21', '2023-06-12 02:57:21'),
('J-20230612-1-11-00013', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:21', '2023-06-12 02:57:21'),
('J-20230612-1-11-00014', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:21', '2023-06-12 02:57:21'),
('J-20230612-1-11-00015', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:22', '2023-06-12 02:57:22'),
('J-20230612-1-11-00016', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:22', '2023-06-12 02:57:22'),
('J-20230612-1-11-00017', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:22', '2023-06-12 02:57:22'),
('J-20230612-1-11-00018', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:22', '2023-06-12 02:57:22'),
('J-20230612-1-11-00019', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:23', '2023-06-12 02:57:23'),
('J-20230612-1-11-00020', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:23', '2023-06-12 02:57:23'),
('J-20230612-1-11-00021', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:23', '2023-06-12 02:57:23'),
('J-20230612-1-11-00022', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:57:23', '2023-06-12 02:57:23'),
('J-20230612-1-11-00023', '', 0, 11, '', '2023-06-12', 9500, 0, 9500, 0, 'disiapkan', '2023-06-12 02:58:51', '2023-06-12 02:58:51'),
('J-20230612-1-11-00024', '', 0, 11, '', '2023-06-12', 7500, 0, 7500, 0, 'disiapkan', '2023-06-12 03:02:34', '2023-06-12 03:02:34'),
('J-20230612-1-11-00025', '', 0, 11, '', '2023-06-12', 4000, 0, 4000, 0, 'disiapkan', '2023-06-12 03:02:43', '2023-06-12 03:02:43'),
('J-20230612-1-11-00026', '', 0, 11, '', '2023-06-12', 2500, 0, 2500, 0, 'disiapkan', '2023-06-12 03:03:06', '2023-06-12 03:03:06'),
('J-20230612-1-11-00027', '', 11, 1, '', '2023-06-12', 2000, 20, 1980, 1, 'disiapkan', '2023-06-12 03:09:40', '2023-06-12 03:09:40'),
('J-20230612-1-11-00028', '', 11, 1, '', '2023-06-12', 2000, 200, 1600, 1, 'diantar', '2023-06-12 03:24:38', '2023-06-12 03:24:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbjualdetil`
--

CREATE TABLE `tbjualdetil` (
  `id` int(11) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `harga` double NOT NULL,
  `diskon` int(11) NOT NULL COMMENT 'persen diskon',
  `jlhdiskon` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbjualdetil`
--

INSERT INTO `tbjualdetil` (`id`, `idjual`, `idmenu`, `jumlah`, `harga`, `diskon`, `jlhdiskon`, `subtotal`, `total`, `note`, `created_at`, `updated_at`) VALUES
(1, 'J-20230418-1-1-00001', 37, '1', 9000, 0, 0, 9000, 9000, '', '2023-04-18 11:52:46', '2023-04-18 11:52:46'),
(2, 'J-20230516-1-1-00002', 37, '1', 9000, 0, 0, 9000, 9000, '', '2023-05-16 01:23:52', '2023-05-16 01:23:52'),
(3, 'J-20230612-1-1-00003', 40, '1', 2000, 0, 0, 2000, 2000, '', '2023-06-11 17:24:30', '2023-06-11 17:24:30'),
(4, 'J-20230612-1-1-00004', 41, '1', 7000, 0, 0, 7000, 7000, '', '2023-06-11 17:24:38', '2023-06-11 17:24:38'),
(5, 'J-20230612-1-1-00005', 40, '1', 2000, 0, 0, 2000, 2000, '', '2023-06-11 17:24:50', '2023-06-11 17:24:50'),
(6, 'J-20230612-1-11-00023', 39, '1', 2500, 0, 0, 2500, 2500, '-', '2023-06-12 02:58:51', '2023-06-12 02:58:51'),
(7, 'J-20230612-1-11-00023', 41, '1', 7000, 0, 0, 7000, 7000, '-', '2023-06-12 02:58:51', '2023-06-12 02:58:51'),
(8, 'J-20230612-1-11-00024', 39, '3', 2500, 0, 0, 7500, 7500, '-', '2023-06-12 03:02:34', '2023-06-12 03:02:34'),
(9, 'J-20230612-1-11-00025', 40, '2', 2000, 0, 0, 4000, 4000, '-', '2023-06-12 03:02:43', '2023-06-12 03:02:43'),
(10, 'J-20230612-1-11-00026', 39, '1', 2500, 0, 0, 2500, 2500, '-', '2023-06-12 03:03:06', '2023-06-12 03:03:06'),
(11, 'J-20230612-1-11-00027', 40, '1', 2000, 1, 20, 2000, 1980, '', '2023-06-12 03:09:40', '2023-06-12 03:09:40'),
(12, 'J-20230612-1-11-00028', 40, '1', 2000, 10, 200, 2000, 1800, '', '2023-06-12 03:24:38', '2023-06-12 03:24:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkaryawan`
--

CREATE TABLE `tbkaryawan` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `pekerjaan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkas`
--

CREATE TABLE `tbkas` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkategori`
--

CREATE TABLE `tbkategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tipe` int(11) NOT NULL,
  `id_printer` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkeranjang`
--

CREATE TABLE `tbkeranjang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(200) NOT NULL,
  `subtotal` decimal(65,0) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkonsumen`
--

CREATE TABLE `tbkonsumen` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbkonsumen`
--

INSERT INTO `tbkonsumen` (`id`, `nama`, `alamat`, `no_hp`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Natanael', 'nurul huda 3688', '081347748346', 'MTIzNDU2', '2023-01-20 22:31:38', '2023-02-17 14:43:49'),
(9, 'PAO', 'NURUL HUDA NO.76', '085156310036', 'am9zaHVhMTkyOA==', '2023-02-28 09:49:55', '2023-02-28 09:49:55'),
(10, 'Josh', 'purwosari 3 no 23', '08123111', 'MTIzNDU2', '2023-04-28 14:25:24', '2023-04-28 14:25:24'),
(11, 'aceng', 'serdam', '058852555663', 'MTIzNDU2', '2023-06-12 09:53:56', '2023-06-12 09:53:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblogsmenu`
--

CREATE TABLE `tblogsmenu` (
  `id` int(11) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `kategori` enum('masuk','keluar') NOT NULL,
  `iduser` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tblogsmenu`
--

INSERT INTO `tblogsmenu` (`id`, `idmenu`, `jumlah`, `kategori`, `iduser`, `created_at`, `updated_at`) VALUES
(1, 37, 1, 'keluar', 1, '2023-04-18 11:52:46', '2023-04-18 11:52:46'),
(2, 37, 1, 'keluar', 1, '2023-05-16 01:23:52', '2023-05-16 01:23:52'),
(3, 40, 1, 'keluar', 1, '2023-06-11 17:24:30', '2023-06-11 17:24:30'),
(4, 41, 1, 'keluar', 1, '2023-06-11 17:24:38', '2023-06-11 17:24:38'),
(5, 40, 1, 'keluar', 1, '2023-06-11 17:24:50', '2023-06-11 17:24:50'),
(6, 40, 10, 'masuk', 11, '2023-06-12 02:57:50', '2023-06-12 02:57:50'),
(7, 41, 20, 'masuk', 11, '2023-06-12 02:58:09', '2023-06-12 02:58:09'),
(8, 39, 10, 'masuk', 11, '2023-06-12 02:58:49', '2023-06-12 02:58:49'),
(9, 39, 1, 'keluar', 0, '2023-06-12 02:58:51', '2023-06-12 02:58:51'),
(10, 41, 1, 'keluar', 0, '2023-06-12 02:58:51', '2023-06-12 02:58:51'),
(11, 39, 3, 'keluar', 0, '2023-06-12 03:02:34', '2023-06-12 03:02:34'),
(12, 40, 2, 'keluar', 0, '2023-06-12 03:02:43', '2023-06-12 03:02:43'),
(13, 39, 1, 'keluar', 0, '2023-06-12 03:03:06', '2023-06-12 03:03:06'),
(14, 40, 1, 'keluar', 11, '2023-06-12 03:09:40', '2023-06-12 03:09:40'),
(15, 40, 1, 'keluar', 11, '2023-06-12 03:24:38', '2023-06-12 03:24:38'),
(16, 40, 20, 'masuk', 1, '2023-06-12 03:34:36', '2023-06-12 03:34:36'),
(17, 40, -5, 'keluar', 1, '2023-06-12 03:34:50', '2023-06-12 03:34:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpembelian`
--

CREATE TABLE `tbpembelian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pembelian` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_user_approve` bigint(20) DEFAULT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `biaya_lainnya` double DEFAULT 0,
  `desc_biaya_lainnya` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `grandtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbpembelian`
--

INSERT INTO `tbpembelian` (`id`, `id_pembelian`, `id_user`, `id_user_approve`, `id_supplier`, `status`, `tanggal`, `biaya_lainnya`, `desc_biaya_lainnya`, `subtotal`, `diskon`, `pajak`, `grandtotal`, `created_at`, `updated_at`) VALUES
(1, 'B-20230121-2-1-00001', 1, 1, 2, 'Pembelian', '2023-01-21', 0, NULL, 9000, 0, 0, 9000, '2023-01-21 08:50:53', '2023-01-21 08:51:10'),
(2, 'B-20230121-2-1-00002', 1, 1, 2, 'Pembelian', '2023-01-21', 0, NULL, 90000, 0, 0, 90000, '2023-01-21 08:54:45', '2023-01-21 08:54:52'),
(3, 'B-20230216-1-2-00003', 2, 2, 2, 'Pembelian', '2023-02-16', 0, NULL, 50000, 0, 0, 50000, '2023-02-16 16:58:49', '2023-02-16 16:59:14'),
(4, 'B-20230405-1-1-00004', 1, NULL, 2, 'PO Pembelian', '2023-04-05', 0, NULL, 7000, 0, 0, 7000, '2023-04-05 06:36:18', '2023-04-05 06:36:18'),
(5, 'B-20230612-1-11-00005', 11, NULL, 3, 'PO Pembelian', '2023-06-12', 0, NULL, 7000, 700, 0, 6300, '2023-06-12 03:21:57', '2023-06-12 03:21:57'),
(6, 'B-20230612-1-11-00006', 11, NULL, 3, 'PO Pembelian', '2023-06-12', 0, NULL, 35000, 3500, 0, 31500, '2023-06-12 03:22:45', '2023-06-12 03:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpembeliandetil`
--

CREATE TABLE `tbpembeliandetil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pembelian` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menu` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `jlhdiskon` double NOT NULL,
  `jlhpajak` decimal(10,0) NOT NULL,
  `subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbpembeliandetil`
--

INSERT INTO `tbpembeliandetil` (`id`, `id_pembelian`, `id_menu`, `jumlah`, `harga`, `diskon`, `pajak`, `jlhdiskon`, `jlhpajak`, `subtotal`, `created_at`, `updated_at`) VALUES
(2, 'B-20230121-2-1-00001', 14, 1, 9000, 0, 0, 0, '0', 9000, '2023-01-21 08:51:10', '2023-01-21 08:51:10'),
(4, 'B-20230121-2-1-00002', 14, 1, 90000, 0, 0, 0, '0', 90000, '2023-01-21 08:54:52', '2023-01-21 08:54:52'),
(6, 'B-20230216-1-2-00003', 22, 5, 10000, 0, 0, 0, '0', 50000, '2023-02-16 16:59:14', '2023-02-16 16:59:14'),
(7, 'B-20230405-1-1-00004', 34, 1, 7000, 0, 0, 0, '0', 7000, '2023-04-05 06:36:18', '2023-04-05 06:36:18'),
(8, 'B-20230612-1-11-00005', 40, 1, 7000, 10, 0, 700, '0', 6300, '2023-06-12 03:21:57', '2023-06-12 03:21:57'),
(9, 'B-20230612-1-11-00006', 41, 7, 5000, 10, 0, 3500, '0', 31500, '2023-06-12 03:22:45', '2023-06-12 03:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbproduk`
--

CREATE TABLE `tbproduk` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(191) NOT NULL DEFAULT '0',
  `nama` text NOT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `img_url` text DEFAULT NULL,
  `harga_beli` double NOT NULL DEFAULT 0,
  `harga_dk` double NOT NULL DEFAULT 0,
  `satuan` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbproduk`
--

INSERT INTO `tbproduk` (`id`, `kode_barang`, `nama`, `deskripsi`, `img_url`, `harga_beli`, `harga_dk`, `satuan`, `kategori`, `jumlah`, `created_at`, `updated_at`) VALUES
(39, 'BRG01', 'Pulpen Vokus JOYKO BP-338', 'ukuran produk : panjang 14.1 cm x diameter 1cm ; warna : hitam ; tip : 0.7 mm ; 100 % Original', 'Screenshot_1.png', 0, 2500, 'Pcs', 'Alat Tulis', '5', '2023-06-11 17:17:39', '2023-06-12 03:03:06'),
(40, 'BRG02', 'Penghapus Mini JOYKO BP-40', 'menghapus dengan bersih ; warna putih ; merk : joyko', 'Screenshot_2.png', 0, 2000, 'Pcs', 'Alat Tulis', '19', '2023-06-11 17:18:48', '2023-06-12 03:34:50'),
(41, 'BRG03', 'Tip Ex Cair Joyko JK-01', 'warna kombinasi merah putih  ; ukuran produk : panjang 9cm x lebar 3.9 cm ; cairan mudah kering ; type : Jk - 01', 'Screenshot_3.png', 0, 7000, 'Pcs', 'Alat Tulis', '18', '2023-06-11 17:19:55', '2023-06-12 02:58:51'),
(42, 'BRG04', 'Pulpen Standard AE7 Hitam 0.5mm', '100% Original ; cocok untuk sekolah, kantor dll ; warna hitam', 'Screenshot_4.png', 0, 2000, 'Pcs', 'Alat Tulis', '0', '2023-06-11 17:21:19', '2023-06-11 17:37:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbsatuan`
--

CREATE TABLE `tbsatuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbsatuan`
--

INSERT INTO `tbsatuan` (`id_satuan`, `satuan`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', '2020-09-24 18:20:43', '2021-01-06 15:59:42'),
(2, 'Kotak', '2023-06-11 17:35:08', '2023-06-11 17:35:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbsupplier`
--

CREATE TABLE `tbsupplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbsupplier`
--

INSERT INTO `tbsupplier` (`id`, `nama`, `kontak`, `alamat`, `deskripsi`, `aktif`, `created_at`, `updated_at`) VALUES
(2, 'joshua', '085156310036', 'purwosari 3 no 23', 'supplier penggaris', 'Active', '2023-01-20 15:30:47', '2023-06-11 17:35:37'),
(3, 'Doni', '0285566222', 'Serdam', 'Supplier Pen', 'Active', '2023-06-11 17:35:24', '2023-06-11 17:35:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbuser`
--

CREATE TABLE `tbuser` (
  `iduser` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbuser`
--

INSERT INTO `tbuser` (`iduser`, `username`, `password`, `status`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'am9zaHVh', 'Admin', 'Admin', '2018-02-15 13:53:30', '2023-05-09 03:43:13'),
(2, 'test', 'MTIzNDU2', 'Admin', 'admin', '2022-10-27 08:41:04', '2023-04-14 16:34:06'),
(8, 'joshua', 'MTIzNDU2', 'Karyawan', 'joshua', '2023-04-28 07:27:43', '2023-04-28 07:27:43'),
(10, 'a', 'YQ==', 'Kasir', 'a', '2023-06-12 03:27:46', '2023-06-12 03:27:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tempjualdetil`
--

CREATE TABLE `tempjualdetil` (
  `id` int(11) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `kodecanvas` varchar(100) NOT NULL,
  `idkonsumen` int(11) NOT NULL,
  `idsales` varchar(100) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `pajak` int(11) NOT NULL,
  `jlhpajak` double NOT NULL,
  `diskon` int(11) NOT NULL,
  `jlhdiskon` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tempjualdetil`
--

INSERT INTO `tempjualdetil` (`id`, `idjual`, `kodecanvas`, `idkonsumen`, `idsales`, `idmenu`, `iduser`, `jumlah`, `harga`, `pajak`, `jlhpajak`, `diskon`, `jlhdiskon`, `subtotal`, `total`, `note`, `created_at`, `updated_at`) VALUES
(8, 'J-20230208-1-1-00002', '', 1, '', 27, 1, 1, 10000, 0, 0, 0, 0, 10000, 10000, '', '2023-02-08 09:07:08', '2023-02-08 09:07:08'),
(16, 'J-20230216-1-2-00001', '', 1, '', 23, 2, 1, 1, 0, 0, 0, 0, 1, 1, '', '2023-02-16 16:15:19', '2023-02-16 16:15:19'),
(22, 'J-20230228-120-1-00011', '', 1, '', 26, 1, 1, 111, 0, 0, 0, 0, 111, 111, '', '2023-02-28 03:45:23', '2023-02-28 03:45:23'),
(26, 'J-20230428-1-1-00002', '', 8, '', 37, 1, 1, 9000, 0, 0, 0, 0, 9000, 9000, '', '2023-04-28 07:23:39', '2023-04-28 07:23:39'),
(37, 'J-20230612-1-11-00028', '', 1, '', 40, 11, 1, 2000, 0, 0, 10, 200, 2000, 1800, '', '2023-06-12 03:25:44', '2023-06-12 03:25:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temppembeliandetil`
--

CREATE TABLE `temppembeliandetil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pembelian` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menu` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `jlhdiskon` double NOT NULL,
  `jlhpajak` decimal(10,0) NOT NULL,
  `subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `temppembeliandetil`
--

INSERT INTO `temppembeliandetil` (`id`, `id_pembelian`, `id_menu`, `jumlah`, `harga`, `diskon`, `pajak`, `jlhdiskon`, `jlhpajak`, `subtotal`, `created_at`, `updated_at`) VALUES
(6, 'B-20230121-2-1-00003', 14, 1, 90000, 0, 0, 0, '0', 90000, '2023-01-21 08:56:47', '2023-01-21 08:56:47'),
(20, 'B-20230405-1-1-00004', 34, 1, 7000, 0, 0, 0, '0', 7000, '2023-06-12 02:45:23', '2023-06-12 02:45:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trashjual`
--

CREATE TABLE `trashjual` (
  `id` varchar(100) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idkaryawan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` varchar(20) DEFAULT '2',
  `meja` varchar(100) NOT NULL,
  `subtotal` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `grandtotal` double NOT NULL,
  `cash` double NOT NULL,
  `kembalian` double NOT NULL,
  `alasan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trashjual`
--

INSERT INTO `trashjual` (`id`, `iduser`, `idkaryawan`, `tanggal`, `shift`, `meja`, `subtotal`, `diskon`, `pajak`, `grandtotal`, `cash`, `kembalian`, `alasan`, `created_at`, `updated_at`) VALUES
('J-20221019-6-1-00001', 1, 0, '2022-10-19', '1', '', 35000, 0, 0, 35000, 0, 0, 'fiktif', '2022-10-21 06:57:10', '2022-10-21 06:57:10'),
('J-20221021-73-1-00003', 1, 0, '2022-10-21', '1', '', 80000, 0, 0, 76000, 0, 0, '', '2022-10-27 07:47:38', '2022-10-27 07:47:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trashjualdetil`
--

CREATE TABLE `trashjualdetil` (
  `id` int(11) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `pajak` int(11) NOT NULL,
  `jlhpajak` double NOT NULL,
  `diskon` int(11) NOT NULL,
  `jlhdiskon` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trashjualdetil`
--

INSERT INTO `trashjualdetil` (`id`, `idjual`, `idmenu`, `iduser`, `jumlah`, `harga`, `pajak`, `jlhpajak`, `diskon`, `jlhdiskon`, `subtotal`, `total`, `created_at`, `updated_at`) VALUES
(1, 'J-20221019-6-1-00001', 2365, 1, 1, 35000, 0, 0, 0, 0, 35000, 35000, '2022-10-21 06:57:10', '2022-10-21 06:57:10'),
(2, 'J-20221021-73-1-00003', 2106, 1, 1, 60000, 0, 0, 0, 0, 60000, 60000, '2022-10-27 07:47:38', '2022-10-27 07:47:38'),
(3, 'J-20221021-73-1-00003', 990, 1, 1, 20000, 0, 0, 20, 4000, 20000, 16000, '2022-10-27 07:47:38', '2022-10-27 07:47:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbjual`
--
ALTER TABLE `tbjual`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbjualdetil`
--
ALTER TABLE `tbjualdetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkaryawan`
--
ALTER TABLE `tbkaryawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkas`
--
ALTER TABLE `tbkas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkategori`
--
ALTER TABLE `tbkategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tbkeranjang`
--
ALTER TABLE `tbkeranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkonsumen`
--
ALTER TABLE `tbkonsumen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblogsmenu`
--
ALTER TABLE `tblogsmenu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbpembelian`
--
ALTER TABLE `tbpembelian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembelian_inventories_id_pembelian_unique` (`id_pembelian`);

--
-- Indeks untuk tabel `tbpembeliandetil`
--
ALTER TABLE `tbpembeliandetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbproduk`
--
ALTER TABLE `tbproduk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbsatuan`
--
ALTER TABLE `tbsatuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `tbsupplier`
--
ALTER TABLE `tbsupplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `tempjualdetil`
--
ALTER TABLE `tempjualdetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temppembeliandetil`
--
ALTER TABLE `temppembeliandetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trashjual`
--
ALTER TABLE `trashjual`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trashjualdetil`
--
ALTER TABLE `trashjualdetil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbjualdetil`
--
ALTER TABLE `tbjualdetil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbkaryawan`
--
ALTER TABLE `tbkaryawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkas`
--
ALTER TABLE `tbkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkategori`
--
ALTER TABLE `tbkategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkeranjang`
--
ALTER TABLE `tbkeranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbkonsumen`
--
ALTER TABLE `tbkonsumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tblogsmenu`
--
ALTER TABLE `tblogsmenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tbpembelian`
--
ALTER TABLE `tbpembelian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbpembeliandetil`
--
ALTER TABLE `tbpembeliandetil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbproduk`
--
ALTER TABLE `tbproduk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `tbsatuan`
--
ALTER TABLE `tbsatuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbsupplier`
--
ALTER TABLE `tbsupplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tempjualdetil`
--
ALTER TABLE `tempjualdetil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `temppembeliandetil`
--
ALTER TABLE `temppembeliandetil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `trashjualdetil`
--
ALTER TABLE `trashjualdetil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
