-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Nov 2021 pada 10.12
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `primtech_siklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alkes_periksa_lab`
--

CREATE TABLE `alkes_periksa_lab` (
  `id` int(11) NOT NULL,
  `no_sampel` varchar(30) NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `jml_barang` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alkes_periksa_lab`
--

INSERT INTO `alkes_periksa_lab` (`id`, `no_sampel`, `kode_barang`, `jml_barang`) VALUES
(1, '000353/20211115/000238', 'BRG123', 13);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alkes_periksa_lab`
--
ALTER TABLE `alkes_periksa_lab`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alkes_periksa_lab`
--
ALTER TABLE `alkes_periksa_lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
