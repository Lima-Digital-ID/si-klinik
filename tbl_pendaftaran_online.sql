-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Okt 2021 pada 05.26
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
-- Struktur dari tabel `tbl_pendaftaran_online`
--

CREATE TABLE `tbl_pendaftaran_online` (
  `id_pendaftaran` int(3) NOT NULL,
  `id_dokter` int(3) NOT NULL,
  `nama_lengkap` varchar(120) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `golongan_darah` varchar(2) NOT NULL,
  `status_menikah` varchar(20) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` varchar(120) NOT NULL,
  `kabupaten` varchar(30) NOT NULL,
  `rt` varchar(3) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `nama_orang_tua_atau_istri` varchar(30) NOT NULL,
  `nomer_telepon` varchar(20) NOT NULL,
  `tipe_periksa` enum('1','2','3','4','5','6') CHARACTER SET latin1 NOT NULL COMMENT '1 = Periksa Medis, 2 = Imunisasi Anak, 3 = Kontrol Kehamilan, 4 = Periksa Gigi, 5 = Periksa Jasa, 6 = Periksa LAB',
  `dtm_crt` datetime NOT NULL DEFAULT current_timestamp(),
  `dtm_upd` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pendaftaran_online`
--

INSERT INTO `tbl_pendaftaran_online` (`id_pendaftaran`, `id_dokter`, `nama_lengkap`, `nik`, `tanggal_lahir`, `golongan_darah`, `status_menikah`, `pekerjaan`, `alamat`, `kabupaten`, `rt`, `rw`, `nama_orang_tua_atau_istri`, `nomer_telepon`, `tipe_periksa`, `dtm_crt`, `dtm_upd`) VALUES
(12, 10, 'Galih', '351108', '2021-12-31', 'A', 'Menikah', 'Mahasiswa', 'asd', 'Bondowoso', '1', '2', 'Agus', '0848', '6', '2021-10-26 14:03:43', '2021-10-26 14:03:43'),
(13, 4, 'Sabi', '351108', '2021-12-31', 'AB', 'Menikah', 'Mahasiswa', 'asd', 'Bondowoso', '1', '2', 'Agus', '0848', '1', '2021-10-26 14:04:17', '2021-10-26 14:04:17');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_pendaftaran_online`
--
ALTER TABLE `tbl_pendaftaran_online`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_pendaftaran_online`
--
ALTER TABLE `tbl_pendaftaran_online`
  MODIFY `id_pendaftaran` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
