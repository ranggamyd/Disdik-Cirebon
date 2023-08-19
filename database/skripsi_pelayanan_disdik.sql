-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Agu 2023 pada 10.49
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi_pelayanan_disdik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pendidikan`
--

CREATE TABLE `kategori_pendidikan` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_pendidikan`
--

INSERT INTO `kategori_pendidikan` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'non formal', 'kjasd', '2023-07-25 22:08:06', '2023-07-25 22:12:33'),
(2, 'Formal', 'Kategori Pendidikan Formal', '2023-07-30 12:41:57', '2023-07-30 12:41:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2023_07_26_034215_create_kategori_pendidikan_table', 2),
(4, '2023_07_26_070329_create_pendidikan_table', 3),
(13, '2023_07_26_074808_create_persyaratan_table', 4),
(14, '2023_07_26_120726_create_permohonan_table', 4),
(15, '2023_07_26_135120_create_permohonan_detail_table', 5),
(16, '2023_08_03_132515_create_user_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(10) UNSIGNED NOT NULL,
  `nama_pendidikan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendidikan`
--

INSERT INTO `pendidikan` (`id_pendidikan`, `nama_pendidikan`, `singkatan`, `id_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Sekolah Dasar', 'SD', 2, 'asdasdsad', '2023-07-26 00:22:32', '2023-07-30 12:42:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan`
--

CREATE TABLE `permohonan` (
  `id_permohonan` int(10) UNSIGNED NOT NULL,
  `no_pendaftaran` int(11) NOT NULL,
  `nama_yayasan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua_yayasan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pendidikan` int(11) NOT NULL,
  `nama_pendidikan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kepala_pendidikan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Tertunda','Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permohonan`
--

INSERT INTO `permohonan` (`id_permohonan`, `no_pendaftaran`, `nama_yayasan`, `nama_ketua_yayasan`, `no_telp`, `email`, `alamat`, `id_pendidikan`, `nama_pendidikan`, `nama_kepala_pendidikan`, `status`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 37599712, 'asda', 'asdsa', '082316425264', 'rohimwahyudin@gmail.com', 'Jl Pelandakan No. 67', 1, 'Sekolah Dasar', 'sadsad', 'Diterima', NULL, '2023-07-27 05:13:44', '2023-07-27 08:35:23'),
(2, 87588612, 'Yayasan Gratia', 'Stefanus', '087623726372', 'stefanus@gmail.com', 'Jl Harapan', 1, 'SD Terang Bangsa', 'Yogi', 'Tertunda', NULL, '2023-07-30 12:45:02', '2023-07-30 12:45:02'),
(3, 32694241, 'Yayasan Gratia', 'Stefanus', '087623726372', 'stefanus@gmail.com', 'Jl Harapan', 1, 'SD Terang Bangsa', 'Yogi', 'Tertunda', NULL, '2023-07-30 12:45:56', '2023-07-30 12:45:56'),
(4, 97839612, 'Yayasan Gratia', 'Stefanus', '082316425264', 'stefanus@gmail.com', 'Jl Pelandakan No. 67', 1, 'SD Terang Bangsa', 'Yogi', 'Tertunda', NULL, '2023-08-03 08:35:11', '2023-08-03 08:35:11'),
(5, 62372146, 'Yayasan Gratia', 'Stefanus', '082316425264', 'stefanus@gmail.com', 'Jl Pelandakan No. 67', 1, 'SD Terang Bangsa', 'Yogi', 'Tertunda', 2, '2023-08-03 08:35:34', '2023-08-03 08:35:34'),
(6, 78490611, 'Yayasan Gratia', 'Stefanus', '087623726372', 'stefanus@gmail.com', 'Jl Pelandakan No. 67', 1, 'SD Terang Bangsa', 'Yogi', 'Tertunda', 2, '2023-08-03 08:45:06', '2023-08-03 08:45:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permohonan_detail`
--

CREATE TABLE `permohonan_detail` (
  `id_detail` int(10) UNSIGNED NOT NULL,
  `id_permohonan` int(11) NOT NULL,
  `id_persyaratan` int(11) NOT NULL,
  `response` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permohonan_detail`
--

INSERT INTO `permohonan_detail` (`id_detail`, `id_permohonan`, `id_persyaratan`, `response`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'asadsad', '2023-07-27 05:13:44', '2023-07-27 05:13:44'),
(2, 1, 2, 'zxcxzc', '2023-07-27 05:13:44', '2023-07-27 05:13:44'),
(3, 1, 3, '20230727121344_Test Dokumen.pdf', '2023-07-27 05:13:44', '2023-07-27 05:13:44'),
(4, 2, 1, 'test', '2023-07-30 12:45:02', '2023-07-30 12:45:02'),
(5, 2, 2, 'test', '2023-07-30 12:45:02', '2023-07-30 12:45:02'),
(6, 2, 3, '20230730074502_Test Dokumen.pdf', '2023-07-30 12:45:03', '2023-07-30 12:45:03'),
(7, 3, 1, 'test', '2023-07-30 12:45:56', '2023-07-30 12:45:56'),
(8, 3, 2, 'test', '2023-07-30 12:45:56', '2023-07-30 12:45:56'),
(9, 3, 3, '20230730074556_Test Dokumen.pdf', '2023-07-30 12:45:56', '2023-07-30 12:45:56'),
(10, 5, 1, 'test 1', '2023-08-03 08:35:34', '2023-08-03 08:35:34'),
(11, 5, 2, 'zxcxzc', '2023-08-03 08:35:34', '2023-08-03 08:35:34'),
(12, 5, 4, 'SD Tipe 3', '2023-08-03 08:35:34', '2023-08-03 08:35:34'),
(13, 6, 1, 'asadsad', '2023-08-03 08:45:06', '2023-08-03 08:45:06'),
(14, 6, 2, 'test 2', '2023-08-03 08:45:06', '2023-08-03 08:45:06'),
(15, 6, 4, 'SD Tipe 4', '2023-08-03 08:45:06', '2023-08-03 08:45:06'),
(16, 6, 3, '20230803034506_Test Dokumen.pdf', '2023-08-03 08:45:06', '2023-08-03 08:45:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id_persyaratan` int(10) UNSIGNED NOT NULL,
  `nama_persyaratan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pendidikan` int(11) NOT NULL,
  `tipe_input` enum('File upload','Text input','Multiple choise') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `opsi_multiple` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `persyaratan`
--

INSERT INTO `persyaratan` (`id_persyaratan`, `nama_persyaratan`, `id_pendidikan`, `tipe_input`, `is_required`, `opsi_multiple`, `created_at`, `updated_at`) VALUES
(1, 'Test Input Text', 1, 'Text input', 1, NULL, '2023-07-26 09:18:11', '2023-07-26 09:18:11'),
(2, 'Test 2', 1, 'Text input', 1, NULL, '2023-07-26 09:18:25', '2023-07-26 21:39:02'),
(3, 'Test File Input', 1, 'File upload', 1, NULL, '2023-07-26 09:18:37', '2023-07-26 09:21:39'),
(4, 'Jenis', 1, 'Multiple choise', 1, 'SD Tipe 1\r\nSD Tipe 2\r\nSD Tipe 3\r\nSD Tipe 4', '2023-08-03 07:22:00', '2023-08-03 07:26:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', 'pass', 'Admin', '2023-08-03 06:37:59', '2023-08-03 06:37:59'),
(2, 'Rohim', 'rohim@gmail.com', 'rohim@gmail.com', 'pass', 'Pemohon', '2023-08-03 06:46:36', '2023-08-03 06:46:36');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori_pendidikan`
--
ALTER TABLE `kategori_pendidikan`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indeks untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  ADD PRIMARY KEY (`id_permohonan`);

--
-- Indeks untuk tabel `permohonan_detail`
--
ALTER TABLE `permohonan_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indeks untuk tabel `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`id_persyaratan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori_pendidikan`
--
ALTER TABLE `kategori_pendidikan`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id_permohonan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `permohonan_detail`
--
ALTER TABLE `permohonan_detail`
  MODIFY `id_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `persyaratan`
--
ALTER TABLE `persyaratan`
  MODIFY `id_persyaratan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
