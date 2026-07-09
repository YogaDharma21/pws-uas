-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2026 at 10:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int NOT NULL,
  `id_pesanan` int NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES
(1, 1, 1, 1, 21500000.00, 21500000.00),
(2, 2, 1, 1, 21500000.00, 21500000.00),
(3, 3, 2, 1, 1.00, 1.00),
(4, 4, 2, 1, 1.00, 1.00),
(5, 5, 1, 1, 21500000.00, 21500000.00),
(6, 5, 2, 1, 1.00, 1.00),
(7, 6, 2, 1, 1.00, 1.00),
(8, 7, 2, 1, 1.00, 1.00),
(9, 8, 2, 1, 1.00, 1.00),
(10, 9, 2, 1, 1.00, 1.00),
(11, 10, 2, 1, 1.00, 1.00),
(12, 11, 2, 1, 1.00, 1.00),
(13, 12, 2, 1, 1.00, 1.00),
(14, 13, 2, 1, 1.00, 1.00),
(15, 14, 2, 1, 1.00, 1.00),
(16, 15, 2, 1, 1.00, 1.00),
(17, 16, 2, 2, 1.00, 2.00),
(18, 17, 2, 3, 1.00, 3.00),
(19, 18, 2, 3, 1.00, 3.00),
(20, 19, 2, 3, 1.00, 3.00);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Laptop'),
(2, 'Handphone'),
(3, 'Headset');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal_pesanan` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_harga` decimal(12,2) NOT NULL,
  `status_pesanan` enum('Pending','Diproses','Dikirim','Selesai','Dibatalkan') DEFAULT 'Pending',
  `status_pembayaran` enum('Pending','Paid','Expired','Cancelled') DEFAULT 'Pending',
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `midtrans_order_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `tanggal_pesanan`, `total_harga`, `status_pesanan`, `status_pembayaran`, `metode_pembayaran`, `midtrans_order_id`) VALUES
(1, 2, '2026-07-02 07:49:55', 21500000.00, 'Selesai', 'Paid', NULL, NULL),
(2, 2, '2026-07-05 18:06:11', 21500000.00, 'Diproses', 'Paid', 'credit_card', 'TZN-1783245971'),
(3, 1, '2026-07-06 12:05:51', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783310751'),
(4, 1, '2026-07-06 12:07:45', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783310865'),
(5, 1, '2026-07-06 12:08:16', 21500001.00, 'Pending', 'Pending', NULL, 'TZN-1783310896'),
(6, 1, '2026-07-06 12:08:28', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783310908'),
(7, 1, '2026-07-06 12:08:46', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783310926'),
(8, 1, '2026-07-06 12:08:58', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783310938'),
(9, 1, '2026-07-06 17:14:52', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329292'),
(10, 1, '2026-07-06 17:15:42', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329342'),
(11, 1, '2026-07-06 17:16:02', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329362'),
(12, 1, '2026-07-06 17:16:11', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329371'),
(13, 1, '2026-07-06 17:17:14', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329434'),
(14, 1, '2026-07-06 17:17:49', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329469'),
(15, 1, '2026-07-06 17:18:20', 1.00, 'Pending', 'Pending', NULL, 'TZN-1783329500'),
(16, 1, '2026-07-06 17:19:08', 2.00, 'Pending', 'Pending', NULL, 'TZN-1783329548'),
(17, 1, '2026-07-06 17:19:20', 3.00, 'Pending', 'Pending', NULL, 'TZN-1783329560'),
(18, 1, '2026-07-06 17:19:43', 3.00, 'Pending', 'Pending', NULL, 'TZN-1783329583'),
(19, 1, '2026-07-06 17:21:13', 3.00, 'Diproses', 'Paid', 'bank_transfer', 'TZN-1783329673');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `id_kategori` int NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`, `created_at`) VALUES
(1, 1, 'Ace Predator Helios Neo 16', 'Intel Core i7-14700HX | 16GB/1TB| Garansi Resmi Acer Indonesia', 21500000.00, 2, '6a4a35733f782.jpg', '2026-07-01 13:06:27'),
(2, 1, 'ASUS TUF Gaming A15', 'AMD Ryzen™ 7 7445HS |16GB 512GB | NVIDIA® GeForce RTX™ 3050', 15999000.00, 5, '6a4e6bbdcf73e.jpg', '2026-07-05 10:33:40'),
(3, 1, 'IdeaPad Slim 3', 'AMD Ryzen 7 7730U | 16GB 1TB |Integrated AMD Radeon™ Graphics', 6500000.00, 7, '6a4e6d33335ea.jpg', '2026-07-08 15:30:59'),
(4, 2, 'POCO X6 Pro 5G', 'MediaTek Dimensity 8300-Ultra |5.100 mAh | 12GB 512GB', 5700000.00, 10, '6a4e6e09465d7.jpg', '2026-07-08 15:34:33'),
(6, 3, 'HyperX Cloud III', '-', 1200000.00, 3, '6a4e7474cb558.jpg', '2026-07-08 16:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `id_role` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `nama`, `email`, `password`, `no_hp`, `alamat`, `created_at`) VALUES
(1, 1, 'admin', 'komangrizkyy1@gmail.com', '$2y$10$/7vlO0tNYr8iag5tZvIQ0.d0pmIVS.EIR28cRJHENOiAgUxw5OioC', '081333444111', 'jalan batukaru', '2026-06-29 11:03:20'),
(2, 2, 'rizky', 'komangrizky336@gmail.com', '$2y$10$U7d/D3xqysToc01v3qZ.6.w4FVLp.CZUI0nLqmkP5YCZerps.o0Qa', '081345123123', 'jln batukaru', '2026-06-30 10:57:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nama_role` (`nama_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
