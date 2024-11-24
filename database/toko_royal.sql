-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2024 at 01:30 PM
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
-- Database: `toko_royal`
--

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id` int NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `product_id` int NOT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `harga_awal` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `total_harga_awal` decimal(10,2) DEFAULT NULL,
  `total_harga_jual` decimal(10,2) DEFAULT NULL,
  `laba` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status` enum('pending','confirmed','batal') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodact`
--

CREATE TABLE `prodact` (
  `id` int NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga` int NOT NULL,
  `harga_awal` int NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` enum('SEMBAKO','JAJANAN','SABUN','MINUMAN','BUMBU DAPUR') NOT NULL,
  `stok` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prodact`
--

INSERT INTO `prodact` (`id`, `nama_barang`, `harga`, `harga_awal`, `gambar`, `deskripsi`, `kategori`, `stok`) VALUES
(21, 'Beras Sovia', 90000, 80000, 'beras.png', 'Beras Sovia dikenal sebagai beras premium dengan tekstur pulen dan aroma yang khas.', 'SEMBAKO', 0),
(22, 'Gula Pasir', 13500, 10000, 'gula pasir2.png', 'Gula Pasir murni yang sempurna untuk manisan dan kue.', 'SEMBAKO', 0),
(23, 'Beras Bunga Premium', 80000, 75000, 'berasbungapremium-removebg-preview.png', 'Beras bunga yang memiliki aroma yang harum rasa yang lembut.', 'SEMBAKO', 0),
(24, 'Telur Ayam', 27000, 25000, 'telurayam.png', 'Telur Ayam segar dari peternakan lokal', 'SEMBAKO', 0),
(25, 'Telur Bebek', 51000, 40000, 'telur_bebek_1tre-removebg-preview.png', 'Telur Bebek segar dari peternakan lokal', 'SEMBAKO', 9699),
(26, 'Telur Ayam Kampung', 38000, 30000, 'telurayam_kampung1kg-removebg-preview.png', 'Telur Ayam Kampung segar dari peternakan lokal', 'SEMBAKO', 9800),
(27, 'Beras Kantil', 77000, 70000, 'beraskantil-removebg-preview.png', 'Beras Kantil memiliki butiran panjang dan aroma yang wangi dengan rasa yang cenderung manis.', 'SEMBAKO', 2438),
(28, 'Beras Rojo Lele', 83000, 80000, 'berasrojolele-removebg-preview.png', 'Beras Rojo lele ini memiliki karakteristik yang pulen dan sedikit lengket yang menambah cita rasa legit.', 'SEMBAKO', 2000),
(29, 'Beras Medium', 60000, 55000, 'berasmedium-removebg-preview.png', 'Beras Medium memiliki tekstur yang sedang, tidak terlalu pulen', 'SEMBAKO', 1666),
(30, 'Mentega Anchor', 21000, 18000, 'anchor.png', 'Mentega Anchor memiliki rasa creamy dan milky, khas dari susu sapi.', 'SEMBAKO', 2078),
(31, 'Minyak Goreng Bimoli', 38000, 30000, 'bimoli2ltr-removebg-preview.png', 'Minyak Bimoli memiliki rasa yang lembut dan sedikit nutty.', 'SEMBAKO', 298),
(32, 'Minyak Goreng SunCo', 22000, 0, 'mingor2ltr-removebg-preview.png', 'Minyak SunCo memiliki rasa yang cenderung netral dan tidak menggangu rasa asli makanan.', 'SEMBAKO', 212),
(33, 'Minyak Goreng Sabrina', 20000, 0, 'sabrina2ltr-removebg-preview.png', 'Minyak Sabrina menawarkan rasa yang bersih dan ringan, ideal untuk berbagai masakan.', 'SEMBAKO', 290),
(34, 'Minyak Goreng Fortune 5L', 13500, 10000, 'fortune5ltr-removebg-preview.png', 'Minyak Fortune menghasilkan tekstur yang renyah saat digoreng.', 'SEMBAKO', 6000),
(35, 'Tepung Segitiga Biru', 12000, 0, 'segitigabiru1kg-removebg-preview.png', 'Tepung terigu serba guna yang memiliki tekstur halus dan mengandung protein tinggi.', 'SEMBAKO', 199),
(36, 'Tepung Cakra Kembar', 16000, 0, 'cakrakembar1kg-removebg-preview.png', 'Tepung terigu yang berkualitas tinggi dengan kadar protein 13,5%.', 'SEMBAKO', 231),
(37, 'Tepung Sania', 18000, 0, 'saniatepung1kg-removebg-preview.png', 'Tepung terigu serba guna dengan rasa netral, ideal untuk berbagai jenis makanan', 'SEMBAKO', 200),
(38, 'Gula Merah / Gula Jawa', 16000, 0, 'gulamerah_gljawa_1kg-removebg-preview.png', 'Gula Merah mempunyai rasa yang manis khas dan lembut', 'SEMBAKO', 700),
(39, 'Gula Halus Claris', 8000, 0, 'gulaclarishalus500gr-removebg-preview.png', 'Gula Halus Claris mempunyai tekstur yang lembut dan lumer di mulut.', 'SEMBAKO', 999),
(40, 'Gula Batu Tawon', 56000, 50000, 'gulabatucaptawon-removebg-preview.png', 'Gula Batu Tawon memiliki rasa yang manis dan mudah larut.', 'SEMBAKO', 9500),
(41, 'Choki - Choki', 18000, 0, 'choki4.png', 'Snack choklat berbentuk stick yang mudah dibawa kemana - mana', 'JAJANAN', 0),
(42, 'Nextar Coklat Isi 12', 20000, 0, 'nextar1.png', 'Biskuit renyah dengan cream yang menggoda memiliki rasa coklat', 'JAJANAN', 0),
(43, 'Tanggo Wafer', 2000, 0, 'tanggo-removebg-preview.png', 'Wafer renyah dengan cream dengan aneka rasa', 'JAJANAN', 1000),
(44, 'Sari Gandum Sandwich', 2000, 0, 'sarigandum-removebg-preview.png', 'Biskuit memiliki tekstur renyah diluar dan lembut didalam, diisi dengan cream coklat dan susu', 'JAJANAN', 2000),
(45, 'Sari Roti', 5000, 0, 'sari_roti_5rb-removebg-preview.png', 'Memiliki rasa yang lembut, manis dengan tekstur yang empuk dan kenyal', 'JAJANAN', 2000),
(46, 'Roti Aoka Sandwich', 2000, 0, 'roti_aoka-removebg-preview.png', 'Roti lembut yang diisi dengan selai manis', 'JAJANAN', 1900),
(47, 'Pocky Stick', 4000, 0, 'pockybox-removebg-preview.png', 'Biskuit stick yang dilapisi dengan berbagai rasa', 'JAJANAN', 0),
(48, 'Biskuit Malkist', 5000, 0, 'malkist-removebg-preview.png', 'Snack biskuit berisi cream manis yang disukai anak - anak', 'JAJANAN', 700),
(49, 'Biskuit Hello Panda', 9000, 0, 'helopandabox-removebg-preview.png', 'Biskuit berbentuk panda yang diisi cream tersedia berbagai macam rasa', 'JAJANAN', 560),
(50, 'Biskuit Good Time', 2000, 0, 'goodtime-removebg-preview.png', 'Biskuit renyah yang sering disajikan sebagai cemilan dengan rasa coklat yang lezat', 'JAJANAN', 1000),
(51, 'Wafer Dilan', 2000, 500, 'dilan1990-removebg-preview.png', 'Wafer kenangan dilan dan milea enak banget', 'JAJANAN', 273),
(52, 'Wafer Beng-Beng', 2000, 0, 'beng_beng_mini-removebg-preview.png', 'Wafer dengan rasa manis, gurih dan renyah dimulut', 'JAJANAN', 1000),
(53, 'Roti Aoka Gulung', 2500, 0, 'aoka_gulung-removebg-preview.png', 'Roti yang memiliki rasa manis dan lembut dengan tekstur yang kenyal', 'JAJANAN', 997),
(54, 'Biskuit Roma Kelapa', 8500, 0, '2.ROMA-COCONUT-BISCUIT-300G-removebg-preview.png', 'Biskuit dengan rasa kelapa yang khas, menawarkan kombinasi renyah dan manis', 'JAJANAN', 350),
(55, 'Sirup ABC', 15000, 0, 'abc-removebg-preview.png', 'sirup dengan aneka rasa', 'MINUMAN', 400),
(56, 'Sirup Marjan', 23000, 0, 'marjan-removebg-preview.png', 'Sirup manis cocok saat berbuka puasa', 'MINUMAN', 430),
(57, 'Sirup Tjampolai', 35000, 0, 'tjampolai-removebg-preview.png', 'Sirup khas Cirebon dengan berbagai rasa yang lezat', 'MINUMAN', 260),
(58, 'Susu Ultra Milk', 8500, 0, 'ultramilk-removebg-preview.png', 'Susu sehat tinggi protein untuk anak-anak dan dewasa', 'MINUMAN', 3040),
(59, 'Susu Bear Brand', 10000, 0, 'beruang-removebg-preview.png', 'Susu steril berkualitas tinggi', 'MINUMAN', 2990),
(60, 'Susu Real Good', 2500, 0, 'realgood-removebg-preview.png', 'Susu beraneka rasa yang baik untuk anak anak', 'MINUMAN', 2571),
(61, 'Susu Yakult', 2500, 0, 'yakult-removebg-preview.png', 'Susu yang mengandung bakteri baik cocok untuk pencernaan', 'MINUMAN', 3650),
(62, 'Teh Pucuk', 4000, 0, 'PUCUK-removebg-preview.png', 'Minuman Teh dengan rasa yang khas dan segar', 'MINUMAN', 1200),
(63, 'Teh Kotak', 5000, 0, 'kotak-removebg-preview.png', 'Minuman Teh dengan berkualitas tinggi', 'MINUMAN', 2110),
(64, 'Shampoo Clear', 32500, 0, 'clear-removebg-preview.png', 'Membersihkan kulit kepala dari ketombe', 'SABUN', 399),
(65, 'CloseUp', 16000, 0, 'close160-removebg-preview.png', 'Membuat nafas segar sepanjang hari', 'SABUN', 2469),
(66, 'Shampoo Dove Renceng', 10000, 0, 'dove_saset-removebg-preview.png', 'Mencegah rambut rontok,  membuat rambut kuat', 'SABUN', 231),
(67, 'Pewangi Downy', 49400, 0, 'downy-removebg-preview.png', 'Memberikan aroma wangi sepanjang hari', 'SABUN', 213),
(68, 'Shampoo Emeron', 23499, 0, 'emeron-removebg-preview.png', 'Memberikan kelembapan dan nutrisi pada rambut yang membuat rambut berkilau', 'SABUN', 3211),
(69, 'Formula', 13499, 0, 'formula-removebg-preview.png', 'Perlindungan gigi yang optimal, mencegah kerusakan dan menjaga kesegaran napas sepanjang hari', 'SABUN', 3222),
(70, 'Garnier Man', 28999, 0, 'garnierman-removebg-preview.png', 'Mengatasi kotoran diwajah, menghilangkan minyak berlebih dan membuat muka segar sepanjang hari', 'SABUN', 2321),
(71, 'Garnier ', 22300, 0, 'garnier-removebg-preview.png', 'Menghilangkan komedo, mengatasi minyak berlebih dan membuat muka segar', 'SABUN', 2341),
(72, 'Giv Cair 450ML', 16000, 0, 'givcair_450ml-removebg-preview.png', 'Menghilangkan keringat berlebih, menghilangkan bau badan dan membuat badan harum sepanjang hari', 'SABUN', 210),
(73, 'Kahf', 32499, 0, 'kahf-removebg-preview.png', 'Mengandung bahan alami, memberikan kelembapan dan membersihkan hingga ke pori-pori', 'SABUN', 3245),
(74, 'LifeBoy', 4000, 0, 'lifeboy-removebg-preview.png', 'Memberikan perlindungan dari kuman, menjaga kebersihan tangan dan tubuh', 'SABUN', 1000),
(75, 'LifeBoy Cair 500 ML', 20000, 0, 'lifecair500ml-removebg-preview.png', 'Membunuh 99% kuman, menghilangkan bau badan dan membuat badan harum sepanjang hari', 'SABUN', 200),
(76, 'Sabun Mandi LUX', 17000, 0, 'lux-removebg-preview.png', 'Memberikan kelembapan dan sensasi segar setelah mandi', 'SABUN', 343),
(77, 'Molto Pewangi Pakaian', 10000, 0, 'molto-removebg-preview.png', 'Membuat pakaian wangi tanpa merusak warna dan serat pakaian', 'SABUN', 1000),
(78, 'Pepsodents 75g', 5000, 0, 'peps75g-removebg-preview.png', 'Perlindungan pada gigi dari kerusakan dan gigi berlubang, membuat nafas segar sepanjang hari', 'SABUN', 232),
(79, 'SoKlin Liquid', 5000, 0, 'soklin-removebg-preview.png', 'Membunuh kuman pada pakaian dan membersihkan noda yang membandel', 'SABUN', 211),
(80, 'Sunlight', 5000, 0, 'sunlight-removebg-preview.png', 'Menghilangkan lemak membandel dengan sekali usap, membuat piring dan gelas tampak berkilau', 'SABUN', 3222),
(81, 'Sunsilk Renceng / Saset', 10000, 0, 'sunsulk_renceng-removebg-preview.png', 'Menghilangkan ketombe basah, dan membuat rambut tampak berkilau sepanjang hari', 'SABUN', 233),
(82, 'Wardah Sabun Cuci Muka', 30499, 0, 'wardah-removebg-preview.png', 'Mengandung bahan alami yang lembut di kulit, cocok untuk semua jenis kulit', 'SABUN', 2000),
(83, 'Kecap ABC 600ml', 25499, 0, 'abc600ml-removebg-preview.png', 'Kecap manis dengan rasa khas, cocok untuk berbagai masakan', 'BUMBU DAPUR', 319),
(84, 'Saos ABC Extra Pedas 335ml', 20000, 0, 'ABC-Extra-Pedas-Saos-Sambal-335ml-removebg-preview.png', 'Saos sambal pedas yang menggugah selera, ideal untuk hidangan pedas', 'BUMBU DAPUR', 321),
(85, 'AJI NOMOTO Penyedap Rasa', 15000, 0, 'ajinomoto-removebg-preview.png', 'Penyedap rasa untuk menambah cita rasa masakan Anda', 'BUMBU DAPUR', 321),
(86, 'Kecap Asin 58 135ml', 12000, 0, 'asin58_135ml-removebg-preview.png', 'Kecap asin dengan rasa yang khas, sempurna untuk menambah cita rasa', 'BUMBU DAPUR', 222),
(87, 'Kecap Asin MENJANGAN 140ml', 12000, 0, 'asinmenjangan140ml-removebg-preview.png', 'Kecap asin premium yang cocok untuk berbagai hidangan', 'BUMBU DAPUR', 211),
(88, 'Kecap Bangau 135ml', 12000, 0, 'bangau135ml-removebg-preview.png', 'Kecap manis dengan rasa yang pas, ideal untuk masakan sehari-hari', 'BUMBU DAPUR', 211),
(89, 'Garam Dapur Cap KAPAL', 5000, 0, 'capkapalgaram-removebg-preview.png', 'Garam dapur berkualitas, cocok untuk memasak', 'BUMBU DAPUR', 400),
(90, 'Garam Dapur Cap DAUN', 5000, 0, 'garam_capdaun-removebg-preview.png', 'Garam dapur dengan kualitas terbaik, memberikan rasa yang pas', 'BUMBU DAPUR', 322),
(91, 'Garam Dapur Cap SEGITIGA EMAS', 5000, 0, 'garamsegitiga-removebg-preview.png', 'Garam dapur yang sempurna untuk segala masakan', 'BUMBU DAPUR', 211),
(92, 'Saos Sambal INDOFOOD PEDAS 135ml', 20000, 0, 'indofood_pedas-removebg-preview.png', 'Saos sambal pedas yang nikmat, ideal untuk menemani makanan', 'BUMBU DAPUR', 111),
(93, 'Masako Kaldu Ayam Saset', 10000, 0, 'masako-removebg-preview.png', 'Kaldu bubuk untuk menambah rasa gurih pada masakan', 'BUMBU DAPUR', 288),
(94, 'Royko Ayam / Sapi Sachet', 10000, 0, 'roykoayamsapi-removebg-preview.png', 'Penyedap rasa dalam bentuk sachet untuk masakan Anda', 'BUMBU DAPUR', 276),
(95, 'Saos Tomat Kemasan Plastik 450g', 15000, 0, 'saos_tomat_450g.png', 'Saos tomat segar untuk hidangan pasta dan makanan lainnya', 'BUMBU DAPUR', 232),
(96, 'SASA Penyedap Rasa Saset', 10000, 0, 'sasa-removebg-preview.png', 'Penyedap rasa yang praktis dan mudah digunakan\r\n', 'BUMBU DAPUR', 211),
(97, 'Kecap Sedap 135ml', 12300, 0, 'sedap-removebg-preview.png', 'Kecap manis yang nikmat untuk menambah cita rasa masakan', 'BUMBU DAPUR', 3211),
(98, 'Saori Saos Tiram / Teriyaki 135ml', 25000, 0, 'tiramteriyaki_135ml-removebg-preview.png', 'Saos tiram dan teriyaki yang kaya rasa, sempurna untuk masakan Asia', 'BUMBU DAPUR', 344),
(99, 'Minyak Wijen ABC 195ml', 30000, 0, 'wijen195ml-removebg-preview.png', 'Minyak wijen berkualitas tinggi, ideal untuk menumis\r\n', 'BUMBU DAPUR', 222),
(100, 'KARA Santan Kelapa Kemasan', 15000, 0, 'kara3.png', 'Santan kelapa yang kental dan lezat, cocok untuk masakan tradisional', 'BUMBU DAPUR', 213);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int NOT NULL,
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `reply_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('admin','customer') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomor_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `alamat`, `nomor_hp`) VALUES
(1, 'Admin', 'admin', '$2y$10$wmZNRURKR1n5HXmTMdyai.3rKQVKK9wnXlNgIGJ4dQKisXJP4qHSS', 'admin', 'Tuban\nKec. Tuban\nKabupaten Tuban\nJawa Timur', '085806429735'),
(3, 'Aninda Puspita Sari', 'Aninda', '$2y$10$A01xvQFJdHj9QrrquwV15e4fMZaZnyfwd/cRo6X6gQ8v2N3WW/kBi', 'customer', 'Kuningan, Pasawahan, Desa Pasawahan, Jawa Barat, Indonesia', '085806429733'),
(12, 'Siti Muzaeni', 'Siti', '$2y$10$qs1PjO7bn19ZiSL2h9Ijde9lcNrLGWO8D4gY5kw.HdYWeJbFKoYxO', 'customer', 'Tuban\nKec. Tuban\nKabupaten Tuban\nJawa Timur', '085887374673'),
(13, 'Audry Viola', 'Audry', '$2y$10$pjdUGyxH1byfDCzntwiC2O/lGS/wCsiwenT3ui88mGJ8X9fWwr1Ki', 'customer', 'Kec. Palimanan Kabupaten Cirebon Jawa Barat', '086573637367'),
(14, 'Nurul Khotimah', 'Nurul', '$2y$10$PJQl5/bv0SAQhEx62G2Ca.L.luaVRbpefjs.8vd.YGePO/HNIpBCa', 'customer', 'Kec. Gebang Kabupaten Cirebon Jawa Barat', '086573637367'),
(15, 'Adji Dwi Cipta Teja Kusuma', 'Kathur', '$2y$10$6N.XidZ6tk4TipIG3u71duu9vEO8qQUGK6L1aHexK2wLWKZKhIOxO', 'customer', 'Tuban Kec. Tuban Kabupaten Tuban Jawa Timur', '085806429735');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_details_ibfk_2` (`product_id`);

--
-- Indexes for table `prodact`
--
ALTER TABLE `prodact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_komen` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `prodact`
--
ALTER TABLE `prodact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `prodact` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `prodact` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `ulasan` (`id`),
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `fk_komen` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
