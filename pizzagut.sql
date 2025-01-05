-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jan 2025 pada 15.13
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzagut`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `password`, `email`) VALUES
(0, 'rian', '$2y$10$a9Sb1JqQgHPjzWE22UYvgeCbRmujoqO0TGP/hEvdpf0DVD0iXO4rC', 'rian@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkout`
--

CREATE TABLE `checkout` (
  `id_checkout` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `id_menu` int(11) NOT NULL,
  `status` enum('pending','confirmed','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `checkout`
--

INSERT INTO `checkout` (`id_checkout`, `id_user`, `id_admin`, `alamat`, `jumlah`, `harga`, `id_menu`, `status`, `created_at`) VALUES
(4, 9, NULL, 'dikos', 1, 50000, 1, 'pending', '2025-01-03 15:11:04'),
(7, 9, NULL, 'dikos', 5, 300000, 2, 'confirmed', '2025-01-03 15:19:12'),
(8, 12, 0, '', 1, 60000, 2, 'confirmed', '2025-01-04 23:43:16'),
(9, 12, 0, '', 1, 5000, 3, 'rejected', '2025-01-04 23:43:16'),
(10, 9, 0, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 07:54:00'),
(11, 9, 0, 'dikos', 1, 60000, 2, 'confirmed', '2025-01-05 07:54:00'),
(12, 9, 0, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 07:54:00'),
(13, 9, 0, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 07:57:15'),
(14, 9, 0, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 07:58:29'),
(15, 9, 0, 'dikos', 1, 60000, 2, 'confirmed', '2025-01-05 07:58:29'),
(16, 9, 0, 'dikos', 1, 5000, 3, 'rejected', '2025-01-05 08:00:34'),
(17, 9, NULL, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 08:27:03'),
(18, 9, NULL, 'dikos', 1, 10000, 4, 'confirmed', '2025-01-05 08:27:03'),
(19, 9, NULL, 'dikos', 1, 60000, 2, 'confirmed', '2025-01-05 08:36:38'),
(20, 9, NULL, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 08:36:38'),
(21, 9, 0, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 08:51:37'),
(22, 9, 0, 'dikos', 1, 60000, 2, 'confirmed', '2025-01-05 08:51:37'),
(23, 9, 0, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 08:51:37'),
(24, 9, 0, 'dikos', 1, 10000, 4, 'confirmed', '2025-01-05 08:51:37'),
(25, 9, NULL, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 09:11:33'),
(26, 9, NULL, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 10:19:43'),
(27, 9, NULL, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 10:20:37'),
(28, 9, NULL, 'dikos', 1, 60000, 2, 'confirmed', '2025-01-05 10:20:37'),
(29, 9, NULL, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 10:20:37'),
(30, 9, NULL, 'dikos', 1, 5000, 3, 'rejected', '2025-01-05 10:23:20'),
(31, 9, NULL, 'dikos', 1, 60000, 2, 'rejected', '2025-01-05 10:23:20'),
(32, 9, NULL, 'dikos', 1, 50000, 1, 'confirmed', '2025-01-05 10:29:17'),
(33, 9, NULL, 'dikos', 3, 180000, 2, 'confirmed', '2025-01-05 10:29:17'),
(34, 9, NULL, 'dikos', 1, 5000, 3, 'confirmed', '2025-01-05 10:29:17'),
(35, 9, NULL, 'dikos', 1, 10000, 4, 'confirmed', '2025-01-05 10:29:17'),
(36, 9, 0, 'dikos', 1, 60000, 2, 'rejected', '2025-01-05 11:13:38'),
(37, 9, 0, 'dikos', 1, 50000, 1, 'rejected', '2025-01-05 11:13:38'),
(38, 9, 0, 'dikos', 1, 60000, 2, 'confirmed', '2025-01-05 11:14:38'),
(39, 9, 0, 'dikos', 2, 10000, 3, 'confirmed', '2025-01-05 11:14:38'),
(40, 12, NULL, '', 2, 120000, 2, 'confirmed', '2025-01-05 12:59:38'),
(41, 12, NULL, '', 1, 5000, 3, 'confirmed', '2025-01-05 12:59:38');

--
-- Trigger `checkout`
--
DELIMITER $$
CREATE TRIGGER `after_checkout_confirm` AFTER UPDATE ON `checkout` FOR EACH ROW BEGIN
    IF NEW.status = 'confirmed' AND OLD.status = 'pending' THEN
        INSERT INTO transaksi (id_user, id_admin)
        VALUES (NEW.id_user, NEW.id_admin);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `deskripsi`, `type`, `image_path`) VALUES
(1, 'Pizza Pepperoni', 50000, 'A mouthwatering symphony of zesty pepperoni atop a blanket of melted cheese, delivering a slice of flavor heaven.', 'food', '../asset/pizza-jpeg 2.png'),
(2, 'Special Sausage Pizza', 60000, 'A special sausage pizza with premium toppings for a flavorful experience.', 'food', '../asset/pizza2.jpg'),
(3, 'Ice Tea', 5000, 'Our high-quality black tea is brewed to perfection, then chilled to provide a refreshing and soothing sensation. Experience the rich aroma of tea and its classic deliciousness.', 'drink', '../asset/esteh.jpg'),
(4, 'Lemon Tea', 10000, 'A refreshing combination of rich black tea and fresh lemon juice. The natural sweetness of the tea blends perfectly with the tangy sourness of the lemon, creating a unique and unforgettable flavor.', 'drink', '../asset/esteh2.jpg\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `id_admin`, `tanggal_transaksi`) VALUES
(1, 9, NULL, '2025-01-05 10:31:41'),
(2, 9, NULL, '2025-01-05 10:31:41'),
(3, 9, NULL, '2025-01-05 10:31:41'),
(4, 9, NULL, '2025-01-05 10:31:41'),
(5, 9, 0, '2025-01-05 12:22:29'),
(6, 9, 0, '2025-01-05 12:22:29'),
(7, 12, NULL, '2025-01-05 12:59:47'),
(8, 12, NULL, '2025-01-05 12:59:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` text NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `password`, `nomor_telepon`, `email`, `alamat`, `reset_token`, `reset_expires`) VALUES
(2, 'Test User', '$2y$10$9aja8dvnEWFS4', '1234567890', 'test@test.com', '', NULL, NULL),
(3, 'Test User', '$2y$10$qnBOkcsrt5dWJ', '1234567890', 'test@test.com', '', NULL, NULL),
(4, 'asdadsa', '$2y$10$tBuANhDonIVhY', '12312312', 'fly5onxz@gmail.com', '', NULL, NULL),
(5, 'asdadsa', '$2y$10$wR/86SCusIoVo', '12312312', 'fly5onxz@gmail.com', '', NULL, NULL),
(6, 'rian', '$2y$10$kjR20WMFfShvU', '089', 'adada@gmail.com', '', NULL, NULL),
(7, 'subhanyuslia', '$2y$10$ksFAINX1mfNHn', '089812312312', 'fly10onx@gmail.com', '', NULL, NULL),
(9, 'soy', '$2y$10$.OyVid9dJhv9pwbYTNJzTuKOWNMdnnrGGg/DT0HbcLGCWLCa0vi4S', '111111111111', 'fly7onx@gmail.com', 'dikos', '0df8c8b564fcbad84c0ee055bdcac6e31d64792d9b789093fd4cf9fb7f98ac80', '2025-01-05 07:31:54'),
(10, 'hanif', '$2y$10$iGpZqqvQF6q1yykxAqWaPuwSaGVNXU/scFILQXKdtII7sdSb8Qgge', '12121121121212', 'yuuki@gmail.com', '', NULL, NULL),
(11, 'hanif', '$2y$10$UV1sFiDc8kZydeDvJ4ny1Opq8zS6ZjiLZERFLbBCNK/5uf0c4zAD2', '12312312`', 'yuuki@gmail.com', '', NULL, NULL),
(12, 'testing', '$2y$10$5d/djWy7NoUatupD9Xx6vOwFy7p4/.bjAt6PX4a8.0r4b0CSbaWU2', '1234567890123', 'testing123@gmail.com', '', NULL, NULL),
(13, 'subhanyuslia', '$2y$10$BkSB5ZW0olAu1FHAlawX.OtwSMrnhOv01E1Qstq9W7k4TLcgBu3CC', '089690834793', 'subhanyuslia@gmail.com', 'kruwet', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id_checkout`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id_checkout` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `checkout_ibfk_3` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
