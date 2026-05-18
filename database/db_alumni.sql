-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Bulan Mei 2026 pada 17.06
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_alumni`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `angkatan` int(11) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `instagram` varchar(50) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status_alumni` varchar(50) DEFAULT NULL,
  `tempat_kerja` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alumni`
--

INSERT INTO `alumni` (`id_alumni`, `nama`, `angkatan`, `jurusan`, `email`, `instagram`, `telepon`, `alamat`, `password`, `status_alumni`, `tempat_kerja`) VALUES
(48, 'dani', 2027, 'Rekayasa Perangkat Lunak', 'dani1223@gmail.com', 'dani_@', '086473562347', 'adalah', '$2y$10$k/RGVPxNhltw0vLLi6BCoerhuOfB2iFXUeQ.2ULrVtvAS4nb2..Le', 'Kuliah', 'mana aja bisa'),
(49, 'aguss', 2025, 'Rekayasa Perangkat Lunak', 'agus@gmail.com', 'agus@', '086473650247', 'itulah', '$2y$10$qJ/oWh/rUZKDGIdR7d.I4eAbhj75Sui.GSUuLAIkyoqAAICVKi/uu', 'Wirausaha', 'agus komputer'),
(50, 'syamil', 2016, 'Rekayasa Perangkat Lunak', 'syamil123@gmail.com', 'syamil@', '083873775483', 'pringsewu', '$2y$10$UFVJ/Wg.YAX88k8CaiKEO.w2YRvwMnot8IeU66tv3uSYsQBQ4fxGy', 'Kuliah', 'UNILA'),
(51, 'yoel', 2026, 'Rekayasa Perangkat Lunak', 'yoel@gmail.com', 'yoel_@', '086475338564', 'tataan', '$2y$10$vkT/gWIkNb5HiTptLmt/p.3bvja7ryaghkeZs7LHHh0kCDmhc.DnC', 'Mencari Kerja', ''),
(52, 'firza', 2024, 'Teknik Jaringan Akses Telekomunikasi', 'firza@gmail.com', 'firza@', '08642648537', 'tataan', '$2y$10$fM82gVyDJj3d7so51iYAkO3Zd1VZV2XbgCLldyyppKK8abDLZt82m', 'Mencari Kerja', ''),
(53, 'yani', 2020, 'Teknik Komputer Jaringan', 'yani123@gmail.com', 'yani@', '086473526473', 'lampung', '$2y$10$WPjT4Ai3VgqQf2r51VsWh.ytRZJKYTMQeSyVLl..Ld/z23DQ2xwHi', 'Kuliah', 'teknokrat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(5, 'superuser', '$2y$10$kVRySTvWKYOHwBS/dktMzOzbwZAFiq3N4N29Q2j4RuZqgIbGapVsG', 'user'),
(7, 'superadminn', '$2y$10$/10gNhatyW6r5dUoLWR7X.AxItCaC4owscSFdyugwHWag6fQgexdW', 'admin'),
(30, 'dani', '$2y$10$k/RGVPxNhltw0vLLi6BCoerhuOfB2iFXUeQ.2ULrVtvAS4nb2..Le', 'alumni'),
(31, 'aguss', '$2y$10$IpleOyZFSm3n4jZfgPt54usodCe36D5D.uqsrkV0f0HFen.LNoJd6', 'alumni'),
(32, 'syamil', '$2y$10$UFVJ/Wg.YAX88k8CaiKEO.w2YRvwMnot8IeU66tv3uSYsQBQ4fxGy', 'alumni'),
(33, 'yoel', '$2y$10$vkT/gWIkNb5HiTptLmt/p.3bvja7ryaghkeZs7LHHh0kCDmhc.DnC', 'alumni'),
(34, 'firza', '$2y$10$fM82gVyDJj3d7so51iYAkO3Zd1VZV2XbgCLldyyppKK8abDLZt82m', 'alumni'),
(35, 'yani', '$2y$10$WPjT4Ai3VgqQf2r51VsWh.ytRZJKYTMQeSyVLl..Ld/z23DQ2xwHi', 'alumni');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
