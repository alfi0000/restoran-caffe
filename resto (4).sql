-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Mar 2026 pada 22.36
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
-- Database: `resto`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_meja`
--

CREATE TABLE `cart_meja` (
  `cart_id` int(11) NOT NULL,
  `meja_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart_meja`
--

INSERT INTO `cart_meja` (`cart_id`, `meja_id`, `menu_id`, `qty`, `created_at`) VALUES
(1, 2, 23, 3, '2026-03-03 02:06:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_akses`
--

CREATE TABLE `resto_akses` (
  `akses_id` int(2) NOT NULL,
  `user_username` varchar(30) NOT NULL,
  `kategori_id` int(2) NOT NULL,
  `akses_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_akses`
--

INSERT INTO `resto_akses` (`akses_id`, `user_username`, `kategori_id`, `akses_update`) VALUES
(2, 'dapur', 2, '2019-03-22 22:14:32'),
(4, 'dapur', 3, '2019-03-22 22:15:00'),
(5, 'dapur', 1, '2019-03-22 22:15:03'),
(6, 'kasir', 1, '2019-03-23 13:04:54'),
(7, 'kasir', 2, '2019-03-23 13:04:57'),
(8, 'kasir', 3, '2019-03-23 13:05:01'),
(9, 'kasir', 4, '2019-03-23 13:05:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_contact`
--

CREATE TABLE `resto_contact` (
  `contact_id` int(2) NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_address` text NOT NULL,
  `contact_phone` varchar(15) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_web` varchar(50) DEFAULT NULL,
  `contact_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_contact`
--

INSERT INTO `resto_contact` (`contact_id`, `contact_name`, `contact_address`, `contact_phone`, `contact_email`, `contact_web`, `contact_update`) VALUES
(1, 'RESTO', 'Jl. cot iju bale setuy matamamplam', '+62 853-5802-60', 'alfiikhtihar9@gmail.com', '', '2024-12-05 00:33:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_kategori`
--

CREATE TABLE `resto_kategori` (
  `kategori_id` int(2) NOT NULL,
  `kategori_nama` varchar(50) NOT NULL,
  `kategori_seo` text NOT NULL,
  `kategori_icon` varchar(50) NOT NULL,
  `kategori_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_kategori`
--

INSERT INTO `resto_kategori` (`kategori_id`, `kategori_nama`, `kategori_seo`, `kategori_icon`, `kategori_update`) VALUES
(1, 'HIDANGAN PENUTUP', 'hidangan-penutup', 'po po-salads', '2025-01-01 19:13:47'),
(2, 'HIDANGAN UTAMA', 'hidangan-utama', 'po po-burger', '2025-01-01 19:21:46'),
(3, 'CAMILAN', 'camilan', 'po po-fries', '2025-01-01 19:22:26'),
(4, 'MINUM', 'minum', 'po po-drinks', '2025-01-01 19:17:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_meja`
--

CREATE TABLE `resto_meja` (
  `meja_id` int(11) NOT NULL,
  `meja_nama` varchar(50) NOT NULL,
  `meja_update` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `meja_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_meja`
--

INSERT INTO `resto_meja` (`meja_id`, `meja_nama`, `meja_update`, `meja_status`) VALUES
(1, 'Meja 1', '2026-02-12 11:12:34', 1),
(2, 'Meja 2', '2026-03-04 00:20:23', 0),
(3, 'Meja 3', '2026-03-04 00:14:38', 0),
(4, 'Meja 4', '2026-01-19 11:45:18', 0),
(5, 'Meja 5', '2026-01-21 22:44:56', 1),
(6, 'Meja 6', '2026-01-18 20:26:45', 0),
(7, 'Meja 7', '2026-03-04 00:20:23', 1),
(8, 'Meja 8', '2026-03-02 03:52:55', 1),
(9, 'Meja 9', '2026-02-12 11:14:03', 1),
(10, 'Meja 10', '2026-03-03 04:10:35', 0),
(11, 'MEJA 11', '2026-03-02 01:14:33', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_menu`
--

CREATE TABLE `resto_menu` (
  `menu_id` int(10) NOT NULL,
  `kategori_id` int(2) NOT NULL,
  `stok_menu` int(11) NOT NULL,
  `menu_kode` varchar(5) NOT NULL,
  `menu_nama` varchar(50) NOT NULL,
  `menu_seo` text NOT NULL,
  `menu_deskripsi` text NOT NULL,
  `menu_harga` int(10) NOT NULL DEFAULT 0,
  `menu_waktu` int(2) NOT NULL DEFAULT 0,
  `menu_foto` varchar(100) DEFAULT NULL,
  `menu_jual` int(10) NOT NULL DEFAULT 0,
  `menu_update` datetime NOT NULL,
  `menu_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_menu`
--

INSERT INTO `resto_menu` (`menu_id`, `kategori_id`, `stok_menu`, `menu_kode`, `menu_nama`, `menu_seo`, `menu_deskripsi`, `menu_harga`, `menu_waktu`, `menu_foto`, `menu_jual`, `menu_update`, `menu_kategori`) VALUES
(19, 2, 5, '00019', 'NASI GORENG MAGELANGAN', 'nasi-goreng-magelangan', 'Bosan dengan nasi goreng yang begitu-begitu saja? Coba campur dengan mie agar lebih bervariasi, seperti nasi goreng ala magelang ini. Citarasanya juga lebih unik dengan tambahan kemiri, ebi, dan terasi dalam racikan bumbunya.', 30000, 0, 'Menu_makanan_bimbingan_1768725629.jpg', 0, '2026-01-18 15:41:32', ''),
(20, 2, 5, '00020', 'NASI GORENG KAMPUNG', 'nasi-goreng-kampung', 'Setelah mencobanya, Anda pasti ketagihan! Ini adalah resep yang bagus untuk makan malam keluarga, dan sisa nasi goreng bisa dijadikan bekal makan siang yang enak!', 25000, 0, 'Menu_makanan_nasi-goreng-kampung_1768725879.jpg', 0, '2026-01-18 15:44:39', ''),
(21, 2, 4, '00021', 'MIE GORENG SEAFOOD', 'mie-goreng-seafood', 'Selain nasi, mie juga menjadi salah satu makanan yang digemari di caffe barcode. Terdapat banyak penjual mie yang bisa ditemui, mulai dari level kaki lima hingga level bintang lima. Pada resep kali ini, kreasi mie yang akan dibahas adalah mie goreng seaf...', 27000, 0, 'Menu_makanan_mie-goreng-seafood_1768726648.jpg', 0, '2026-01-18 15:57:28', ''),
(22, 2, 8, '00022', 'NASI LEMAK', 'nasi-lemak', 'nasi lemak', 23000, 0, 'Menu_makanan_nasi-lemak_1768728478.jpg', 0, '2026-01-18 16:27:58', ''),
(23, 2, 1, '00023', 'AYAM BAKAR PEDAS MANIS', 'ayam-bakar-pedas-manis', 'Ayam Bakar Pedas Manis', 15000, 0, 'Menu_makanan_ayam-bakar-pedas-manis_1768728573.jpg', 2, '2026-01-18 16:29:33', ''),
(24, 2, 2, '00024', 'IKAN BAKAR BALE', 'ikan-bakar-bale', 'Ikan bakar bale', 30000, 0, 'Menu_makanan_ikan-bakar-bale_1768728871.jpg', 1, '2026-01-18 16:34:32', ''),
(25, 1, 9, '00025', 'BERRIES', 'berries', 'berries', 17000, 0, 'Menu_makanan_berries_1768729001.jpg', 0, '2026-01-18 16:36:41', ''),
(26, 1, 8, '00026', 'ICE CREAM', 'ice-cream', 'ice cream', 20000, 0, 'Menu_makanan_ice-cream_1768729118.jpg', 1, '2026-01-18 16:38:38', ''),
(27, 1, 15, '00027', 'DONAT', 'donat', 'donat super', 10000, 0, 'Menu_makanan_donat_1768729274.jpg', 0, '2026-01-18 16:41:14', ''),
(28, 1, 17, '00028', 'KENTANG', 'kentang', 'kentang lezat', 17000, 0, 'Menu_makanan_kentang_1768729338.jpg', 0, '2026-01-18 16:42:18', ''),
(29, 1, 12, '00029', 'CHICKEN', 'chicken', 'chicken', 40000, 0, 'Menu_makanan_chicken_1768729437.jpg', 1, '2026-01-18 16:43:57', ''),
(30, 3, 14, '00030', 'TELUR GELUNG', 'telur-gelung', 'telur gelung ori', 7000, 0, 'Menu_makanan_telur-gelung_1768729544.jpg', 0, '2026-01-18 16:45:44', ''),
(31, 3, 7, '00031', 'TELUR GELUNG SUPER', 'telur-gelung-super', 'telur gelung super', 9000, 0, 'Menu_makanan_telur-gelung-super_1768729615.jpg', 1, '2026-01-18 16:46:55', ''),
(32, 3, 13, '00032', 'REMEN', 'remen', 'ramen', 35000, 0, 'Menu_makanan_remen_1768729694.jpg', 0, '2026-01-18 16:48:14', ''),
(33, 3, 10, '00033', 'RAMEN SPESIAL', 'ramen-spesial', 'ramen spesia', 40000, 0, 'Menu_makanan_ramen-spesial_1768729817.jpg', 1, '2026-01-18 16:50:17', ''),
(34, 3, 7, '00034', 'MIE AYAM PRAKTIS', 'mie-ayam-praktis', 'mie ayam praktis', 17000, 0, 'Menu_makanan_mie-ayam-praktis_1768729926.jpg', 0, '2026-01-18 16:52:06', ''),
(35, 4, 4, '00035', 'KOPI SEJARAH', 'kopi-sejarah', 'kopi sejarah', 15000, 0, 'Menu_makanan_kopi-sejarah_1768729998.jpg', 1, '2026-01-18 16:53:18', ''),
(36, 4, 6, '00036', 'KOPI ESPRESSO', 'kopi-espresso', 'kopi espresso', 20000, 0, 'Menu_makanan_kopi-espresso_1768730079.jpg', 0, '2026-01-18 16:54:39', ''),
(37, 4, 8, '00037', 'KOPI KENANGAN', 'kopi-kenangan', 'kopi kenangan', 25000, 0, 'Menu_makanan_kopi-kenangan_1768730147.jpg', 0, '2026-01-18 16:55:48', ''),
(38, 4, 5, '00038', 'KOPI SENJA', 'kopi-senja', 'kopi kenangan', 27000, 0, 'Menu_makanan_kopi-senja_1768730218.jpg', 1, '2026-01-18 16:56:58', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_meta`
--

CREATE TABLE `resto_meta` (
  `meta_id` int(2) NOT NULL,
  `meta_name` varchar(50) NOT NULL COMMENT 'Nama Website',
  `meta_desc` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_author` varchar(100) DEFAULT NULL,
  `meta_developer` varchar(50) DEFAULT NULL,
  `meta_robots` varchar(50) DEFAULT NULL,
  `meta_googlebots` varchar(50) DEFAULT NULL,
  `meta_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_meta`
--

INSERT INTO `resto_meta` (`meta_id`, `meta_name`, `meta_desc`, `meta_keyword`, `meta_author`, `meta_developer`, `meta_robots`, `meta_googlebots`, `meta_update`) VALUES
(1, 'Resto | Digital RestoranMenu', 'Aplikasi Menu DIgital untuk Restoran', 'resto', 'NOKENCODE', 'NOKENCODE', 'index, follow', 'index, follow', '2024-12-04 23:21:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_order`
--

CREATE TABLE `resto_order` (
  `order_id` int(10) NOT NULL,
  `meja_id` int(2) NOT NULL,
  `order_nama` varchar(50) NOT NULL,
  `order_tanggal` date DEFAULT NULL,
  `order_catatan` text DEFAULT NULL,
  `order_qty` int(5) NOT NULL,
  `order_waktu` int(10) NOT NULL DEFAULT 0,
  `order_diskon` int(10) NOT NULL DEFAULT 0,
  `order_total` int(10) NOT NULL DEFAULT 0,
  `order_bayar` int(10) NOT NULL DEFAULT 0,
  `order_kembali` int(10) DEFAULT 0,
  `order_tgl_bayar` date DEFAULT NULL,
  `order_status` int(1) NOT NULL DEFAULT 1 COMMENT '1=Blm Bayar,2=Bayar',
  `user_username` varchar(30) DEFAULT NULL COMMENT 'User Bayar',
  `order_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_order`
--

INSERT INTO `resto_order` (`order_id`, `meja_id`, `order_nama`, `order_tanggal`, `order_catatan`, `order_qty`, `order_waktu`, `order_diskon`, `order_total`, `order_bayar`, `order_kembali`, `order_tgl_bayar`, `order_status`, `user_username`, `order_update`) VALUES
(48, 1, 'AL', '2026-01-18', '', 1, 0, 0, 15000, 15000, 0, '2026-01-18', 2, 'admin', '2026-01-18 20:14:05'),
(49, 2, 'MUHARRAM', '2026-01-18', '', 1, 0, 0, 40000, 40000, 0, '2026-01-18', 2, 'admin', '2026-01-18 20:26:24'),
(50, 4, 'ALFI', '2026-01-18', 'yang enak ya', 1, 0, 0, 30000, 30000, 0, '2026-01-19', 2, 'admin', '2026-01-19 11:45:18'),
(51, 1, 'AL', '2026-01-19', '', 1, 0, 0, 15000, 15000, 0, '2026-02-03', 2, 'admin', '2026-02-03 17:23:14'),
(52, 3, 'ALFI', '2026-01-20', '', 1, 0, 0, 17000, 0, 0, NULL, 1, NULL, '2026-01-20 15:47:56'),
(53, 5, 'ALF', '2026-01-21', '', 1, 0, 0, 15000, 0, 0, NULL, 1, NULL, '2026-01-21 22:44:56'),
(54, 9, 'ILHAM', '2026-02-03', '', 3, 0, 0, 76000, 76000, 0, '2026-02-05', 2, 'admin', '2026-02-05 16:14:12'),
(55, 10, 'WAN', '2026-02-05', '', 1, 0, 0, 15000, 15000, 0, '2026-03-03', 2, 'admin', '2026-03-03 04:10:35'),
(56, 7, 'ALFI', '2026-02-12', '', 1, 0, 0, 20000, 20000, 0, '2026-02-12', 2, 'admin', '2026-02-12 00:39:59'),
(57, 1, 'ALFI', '2026-02-12', '', 2, 0, 0, 42000, 0, 0, NULL, 1, NULL, '2026-02-12 11:12:34'),
(58, 9, 'ALFI', '2026-02-12', '', 1, 0, 0, 40000, 0, 0, NULL, 1, NULL, '2026-02-12 11:14:03'),
(59, 11, 'ULFIA', '2026-03-02', '', 1, 0, 0, 17000, 0, 0, NULL, 1, NULL, '2026-03-02 01:14:33'),
(60, 11, 'YU', '2026-03-02', '', 1, 0, 0, 9000, 0, 0, NULL, 1, NULL, '2026-03-02 02:42:53'),
(61, 11, 'YIYI', '2026-03-02', '', 5, 0, 0, 122000, 0, 0, NULL, 1, NULL, '2026-03-02 03:51:07'),
(62, 8, 'KUKU', '2026-03-02', '', 1, 0, 0, 17000, 0, 0, NULL, 1, NULL, '2026-03-02 03:52:55'),
(63, 2, 'UU', '2026-03-03', '', 1, 0, 0, 9000, 0, 0, NULL, 1, NULL, '2026-03-03 02:35:08'),
(64, 2, 'YT', '2026-03-03', '', 1, 0, 0, 15000, 0, 0, NULL, 1, NULL, '2026-03-03 02:36:14'),
(65, 2, 'TUTU', '2026-03-04', '', 1, 0, 0, 40000, 0, 0, NULL, 1, NULL, '2026-03-04 00:18:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_order_detail`
--

CREATE TABLE `resto_order_detail` (
  `order_detail_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `menu_id` int(10) NOT NULL,
  `order_detail_harga` int(10) NOT NULL DEFAULT 0,
  `order_detail_waktu` int(5) NOT NULL DEFAULT 0,
  `order_detail_qty` int(5) NOT NULL DEFAULT 0,
  `order_detail_subtotal` int(10) NOT NULL DEFAULT 0,
  `order_detail_status` int(1) NOT NULL DEFAULT 1 COMMENT '1=Baru, 2=Selesai',
  `order_detail_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_order_detail`
--

INSERT INTO `resto_order_detail` (`order_detail_id`, `order_id`, `menu_id`, `order_detail_harga`, `order_detail_waktu`, `order_detail_qty`, `order_detail_subtotal`, `order_detail_status`, `order_detail_update`) VALUES
(68, 48, 23, 15000, 0, 1, 15000, 2, '2026-01-18 20:14:05'),
(69, 49, 33, 40000, 0, 1, 40000, 2, '2026-01-18 20:26:24'),
(70, 50, 24, 30000, 0, 1, 30000, 2, '2026-01-19 11:45:18'),
(71, 51, 35, 15000, 0, 1, 15000, 2, '2026-02-03 17:23:14'),
(72, 52, 34, 17000, 0, 1, 17000, 1, '2026-01-20 15:47:56'),
(73, 53, 23, 15000, 0, 1, 15000, 1, '2026-01-21 22:44:56'),
(74, 54, 29, 40000, 0, 1, 40000, 2, '2026-02-05 16:14:12'),
(75, 54, 38, 27000, 0, 1, 27000, 2, '2026-02-05 16:14:12'),
(76, 54, 31, 9000, 0, 1, 9000, 2, '2026-02-05 16:14:12'),
(77, 55, 23, 15000, 0, 1, 15000, 2, '2026-03-03 04:10:35'),
(78, 56, 26, 20000, 0, 1, 20000, 2, '2026-02-12 00:39:59'),
(79, 57, 23, 15000, 0, 1, 15000, 1, '2026-02-12 11:12:34'),
(80, 57, 38, 27000, 0, 1, 27000, 1, '2026-02-12 11:12:34'),
(81, 58, 33, 40000, 0, 1, 40000, 1, '2026-02-12 11:14:03'),
(82, 59, 25, 17000, 0, 1, 17000, 1, '2026-03-02 01:14:33'),
(83, 60, 31, 9000, 0, 1, 9000, 1, '2026-03-02 02:42:53'),
(84, 61, 34, 17000, 0, 1, 17000, 1, '2026-03-02 03:51:07'),
(85, 61, 23, 15000, 0, 1, 15000, 1, '2026-03-02 03:51:07'),
(86, 61, 37, 25000, 0, 1, 25000, 1, '2026-03-02 03:51:07'),
(87, 61, 20, 25000, 0, 1, 25000, 1, '2026-03-02 03:51:07'),
(88, 61, 33, 40000, 0, 1, 40000, 1, '2026-03-02 03:51:07'),
(89, 62, 25, 17000, 0, 1, 17000, 1, '2026-03-02 03:52:55'),
(90, 63, 31, 9000, 0, 1, 9000, 1, '2026-03-03 02:35:08'),
(91, 64, 35, 15000, 0, 1, 15000, 1, '2026-03-03 02:36:14'),
(92, 65, 29, 40000, 0, 1, 40000, 1, '2026-03-04 00:18:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_slider`
--

CREATE TABLE `resto_slider` (
  `slider_id` int(2) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `slider_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_slider`
--

INSERT INTO `resto_slider` (`slider_id`, `slider_image`, `slider_update`) VALUES
(2, 'Slider_1768732680.jpg', '2026-01-18 17:38:01'),
(5, 'Slider_1768730958.jpg', '2026-01-18 17:09:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_social`
--

CREATE TABLE `resto_social` (
  `social_id` int(2) NOT NULL,
  `social_name` varchar(50) NOT NULL,
  `social_class` varchar(50) NOT NULL,
  `social_url` varchar(100) NOT NULL,
  `social_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_social`
--

INSERT INTO `resto_social` (`social_id`, `social_name`, `social_class`, `social_url`, `social_update`) VALUES
(5, 'facebook', 'facebook', 'https://www.facebook.com/', '2026-01-18 19:38:45'),
(6, 'twitter', 'twitter', 'https://x.com/?lang=en-id', '2026-01-18 19:41:19'),
(7, 'instagram', 'instagram', 'https://www.instagram.com/', '2026-01-18 19:42:27'),
(8, 'youtube', 'youtube', 'https://www.youtube.com/', '2026-01-18 19:43:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resto_users`
--

CREATE TABLE `resto_users` (
  `user_username` varchar(30) NOT NULL,
  `user_password` text NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_avatar` varchar(100) DEFAULT NULL,
  `user_status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `user_level` enum('Admin','Bar','Dapur','Kasir','-') NOT NULL DEFAULT '-',
  `user_date_create` datetime NOT NULL,
  `user_date_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `resto_users`
--

INSERT INTO `resto_users` (`user_username`, `user_password`, `user_name`, `user_email`, `user_avatar`, `user_status`, `user_level`, `user_date_create`, `user_date_update`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'ADMINISTRATOR', 'alfiikhtihar@gmail.com', 'Avatar_admin_1542355052.jpg', 'Aktif', 'Admin', '0000-00-00 00:00:00', '2024-12-05 00:36:07'),
('barista', '8cb2237d0679ca88db6464eac60da96345513964', 'BARISTA', 'barista@gmail.com', NULL, 'Aktif', 'Bar', '2025-01-10 09:33:20', '2025-01-10 09:36:06'),
('dapur', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'DAPUR', 'dapur@gmail.com', NULL, 'Aktif', 'Dapur', '2019-03-09 21:52:27', '2026-02-12 11:17:03'),
('kasir', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'KASIR', 'kasir@gmail.com', NULL, 'Aktif', 'Kasir', '2019-03-09 21:52:14', '2026-03-03 04:12:33');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_akses`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_akses` (
`akses_id` int(2)
,`user_username` varchar(30)
,`kategori_id` int(2)
,`akses_update` datetime
,`kategori_nama` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_menu`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_menu` (
`menu_id` int(10)
,`kategori_id` int(2)
,`menu_kode` varchar(5)
,`menu_nama` varchar(50)
,`menu_seo` text
,`menu_deskripsi` text
,`menu_harga` int(10)
,`menu_waktu` int(2)
,`menu_foto` varchar(100)
,`menu_jual` int(10)
,`stok_menu` int(11)
,`menu_update` datetime
,`kategori_nama` varchar(50)
,`kategori_seo` text
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_order`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_order` (
`order_id` int(10)
,`meja_id` int(2)
,`order_nama` varchar(50)
,`order_tanggal` date
,`order_catatan` text
,`order_qty` int(5)
,`order_waktu` int(10)
,`order_diskon` int(10)
,`order_total` int(10)
,`order_bayar` int(10)
,`order_kembali` int(10)
,`order_tgl_bayar` date
,`order_status` int(1)
,`user_username` varchar(30)
,`order_update` datetime
,`meja_nama` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_order_detail`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_order_detail` (
`order_detail_id` int(10)
,`order_id` int(10)
,`menu_id` int(10)
,`order_detail_harga` int(10)
,`order_detail_waktu` int(5)
,`order_detail_qty` int(5)
,`order_detail_subtotal` bigint(21)
,`total_harga` bigint(21)
,`order_detail_status` int(1)
,`order_detail_update` datetime
,`menu_kode` varchar(5)
,`menu_nama` varchar(50)
,`menu_seo` text
,`kategori_id` int(2)
,`menu_kategori` varchar(50)
,`order_status` int(1)
,`order_tanggal` date
,`meja_id` int(11)
,`meja_nama` varchar(50)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_akses`
--
DROP TABLE IF EXISTS `v_akses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_akses`  AS   (select `a`.`akses_id` AS `akses_id`,`a`.`user_username` AS `user_username`,`a`.`kategori_id` AS `kategori_id`,`a`.`akses_update` AS `akses_update`,`k`.`kategori_nama` AS `kategori_nama` from (`resto_akses` `a` join `resto_kategori` `k` on(`a`.`kategori_id` = `k`.`kategori_id`)))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_menu`
--
DROP TABLE IF EXISTS `v_menu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_menu`  AS SELECT `m`.`menu_id` AS `menu_id`, `m`.`kategori_id` AS `kategori_id`, `m`.`menu_kode` AS `menu_kode`, `m`.`menu_nama` AS `menu_nama`, `m`.`menu_seo` AS `menu_seo`, `m`.`menu_deskripsi` AS `menu_deskripsi`, `m`.`menu_harga` AS `menu_harga`, `m`.`menu_waktu` AS `menu_waktu`, `m`.`menu_foto` AS `menu_foto`, `m`.`menu_jual` AS `menu_jual`, `m`.`stok_menu` AS `stok_menu`, `m`.`menu_update` AS `menu_update`, `k`.`kategori_nama` AS `kategori_nama`, `k`.`kategori_seo` AS `kategori_seo` FROM (`resto_menu` `m` join `resto_kategori` `k` on(`m`.`kategori_id` = `k`.`kategori_id`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_order`
--
DROP TABLE IF EXISTS `v_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_order`  AS   (select `o`.`order_id` AS `order_id`,`o`.`meja_id` AS `meja_id`,`o`.`order_nama` AS `order_nama`,`o`.`order_tanggal` AS `order_tanggal`,`o`.`order_catatan` AS `order_catatan`,`o`.`order_qty` AS `order_qty`,`o`.`order_waktu` AS `order_waktu`,`o`.`order_diskon` AS `order_diskon`,`o`.`order_total` AS `order_total`,`o`.`order_bayar` AS `order_bayar`,`o`.`order_kembali` AS `order_kembali`,`o`.`order_tgl_bayar` AS `order_tgl_bayar`,`o`.`order_status` AS `order_status`,`o`.`user_username` AS `user_username`,`o`.`order_update` AS `order_update`,`m`.`meja_nama` AS `meja_nama` from (`resto_order` `o` join `resto_meja` `m` on(`o`.`meja_id` = `m`.`meja_id`)))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_order_detail`
--
DROP TABLE IF EXISTS `v_order_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_order_detail`  AS SELECT `d`.`order_detail_id` AS `order_detail_id`, `d`.`order_id` AS `order_id`, `d`.`menu_id` AS `menu_id`, `d`.`order_detail_harga` AS `order_detail_harga`, `d`.`order_detail_waktu` AS `order_detail_waktu`, `d`.`order_detail_qty` AS `order_detail_qty`, `d`.`order_detail_qty`* `d`.`order_detail_harga` AS `order_detail_subtotal`, `d`.`order_detail_qty`* `d`.`order_detail_harga` AS `total_harga`, `d`.`order_detail_status` AS `order_detail_status`, `d`.`order_detail_update` AS `order_detail_update`, `m`.`menu_kode` AS `menu_kode`, `m`.`menu_nama` AS `menu_nama`, `m`.`menu_seo` AS `menu_seo`, `m`.`kategori_id` AS `kategori_id`, `m`.`menu_kategori` AS `menu_kategori`, `o`.`order_status` AS `order_status`, `o`.`order_tanggal` AS `order_tanggal`, `mj`.`meja_id` AS `meja_id`, `mj`.`meja_nama` AS `meja_nama` FROM (((`resto_order_detail` `d` join `resto_menu` `m` on(`d`.`menu_id` = `m`.`menu_id`)) join `resto_order` `o` on(`d`.`order_id` = `o`.`order_id`)) join `resto_meja` `mj` on(`o`.`meja_id` = `mj`.`meja_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart_meja`
--
ALTER TABLE `cart_meja`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indeks untuk tabel `resto_akses`
--
ALTER TABLE `resto_akses`
  ADD PRIMARY KEY (`akses_id`),
  ADD KEY `user_username` (`user_username`);

--
-- Indeks untuk tabel `resto_contact`
--
ALTER TABLE `resto_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indeks untuk tabel `resto_kategori`
--
ALTER TABLE `resto_kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `resto_meja`
--
ALTER TABLE `resto_meja`
  ADD PRIMARY KEY (`meja_id`);

--
-- Indeks untuk tabel `resto_menu`
--
ALTER TABLE `resto_menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `resto_meta`
--
ALTER TABLE `resto_meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indeks untuk tabel `resto_order`
--
ALTER TABLE `resto_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `resto_order_ibfk_1` (`meja_id`);

--
-- Indeks untuk tabel `resto_order_detail`
--
ALTER TABLE `resto_order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `resto_order_detail_ibfk_1` (`order_id`),
  ADD KEY `resto_order_detail_ibfk_2` (`menu_id`);

--
-- Indeks untuk tabel `resto_slider`
--
ALTER TABLE `resto_slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indeks untuk tabel `resto_social`
--
ALTER TABLE `resto_social`
  ADD PRIMARY KEY (`social_id`);

--
-- Indeks untuk tabel `resto_users`
--
ALTER TABLE `resto_users`
  ADD PRIMARY KEY (`user_username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart_meja`
--
ALTER TABLE `cart_meja`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `resto_akses`
--
ALTER TABLE `resto_akses`
  MODIFY `akses_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `resto_contact`
--
ALTER TABLE `resto_contact`
  MODIFY `contact_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `resto_kategori`
--
ALTER TABLE `resto_kategori`
  MODIFY `kategori_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `resto_meja`
--
ALTER TABLE `resto_meja`
  MODIFY `meja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `resto_menu`
--
ALTER TABLE `resto_menu`
  MODIFY `menu_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `resto_meta`
--
ALTER TABLE `resto_meta`
  MODIFY `meta_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `resto_order`
--
ALTER TABLE `resto_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `resto_order_detail`
--
ALTER TABLE `resto_order_detail`
  MODIFY `order_detail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT untuk tabel `resto_slider`
--
ALTER TABLE `resto_slider`
  MODIFY `slider_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `resto_social`
--
ALTER TABLE `resto_social`
  MODIFY `social_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `resto_akses`
--
ALTER TABLE `resto_akses`
  ADD CONSTRAINT `resto_akses_ibfk_1` FOREIGN KEY (`user_username`) REFERENCES `resto_users` (`user_username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resto_menu`
--
ALTER TABLE `resto_menu`
  ADD CONSTRAINT `resto_menu_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `resto_kategori` (`kategori_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resto_order`
--
ALTER TABLE `resto_order`
  ADD CONSTRAINT `resto_order_ibfk_1` FOREIGN KEY (`meja_id`) REFERENCES `resto_meja` (`meja_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resto_order_detail`
--
ALTER TABLE `resto_order_detail`
  ADD CONSTRAINT `resto_order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `resto_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resto_order_detail_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `resto_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
