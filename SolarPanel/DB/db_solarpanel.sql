-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Bulan Mei 2025 pada 07.47
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_solarpanel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_irradiasi`
--

CREATE TABLE `data_irradiasi` (
  `id` int(11) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kab_kota` varchar(150) NOT NULL,
  `irradiasi_bulanan` decimal(10,7) NOT NULL,
  `orientasi` char(1) NOT NULL,
  `kemiringan` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_irradiasi`
--

INSERT INTO `data_irradiasi` (`id`, `provinsi`, `kab_kota`, `irradiasi_bulanan`, `orientasi`, `kemiringan`) VALUES
(1, 'Nanggroe Aceh Darussalam', 'Lhoksukon, Aceh Utara', 157.9861000, 'S', 5.03),
(2, 'Nanggroe Aceh Darussalam', 'Seunagan, Nagan Raya', 149.0758000, 'S', 4.23),
(3, 'Nanggroe Aceh Darussalam', 'Kluet Utara, Aceh Selatan', 141.6867000, 'S', 3.12),
(4, 'Sumatera Utara', 'Gido, Nias', 136.3589000, 'S', 1.12),
(5, 'Sumatera Utara', 'Medan Tuntungan, Medan', 145.2383000, 'S', 3.52),
(6, 'Sumatera Utara', 'Padang Bolak, Padang Lawas Utara', 140.3822000, 'S', 1.51),
(7, 'Sumatera Selatan', 'Muara Enim, Muara Enim', 154.2344000, 'U', 3.65),
(8, 'Sumatera Selatan', 'Keluang, Musi Banyuasin', 149.0825000, 'U', 2.59),
(9, 'Sumatera Selatan', 'Cengal, Ogan Komering Ilir', 152.2700000, 'U', 3.54),
(10, 'Sumatera Barat', 'Kinali, Pasaman Barat', 147.2822000, 'U', 0.07),
(11, 'Sumatera Barat', 'Sangir Batang Hari, Solok Selatan', 134.0892000, 'U', 1.43),
(12, 'Sumatera Barat', 'Siberut Selatan, Kepulauan Mentawai', 154.1494000, 'U', 1.57),
(13, 'Bengkulu', 'Lubuk Pinang, Mukomuko', 145.1403000, 'U', 2.42),
(14, 'Bengkulu', 'Bingin Kuning, Lebong', 147.4828000, 'U', 3.16),
(15, 'Bengkulu', 'Luas, Kaur', 145.8933000, 'U', 4.56),
(16, 'Riau', 'Tanah Putih, Rokan Hilir', 138.0483000, 'S', 1.47),
(17, 'Riau', 'Tampan, Pekanbaru', 138.8558000, 'S', 0.54),
(18, 'Riau', 'Kuala Indragiri, Indragiri Hilir', 140.8419000, 'U', 0.31),
(19, 'Kepulauan Riau', 'Lingga, Lingga', 154.5369000, 'U', 0.16),
(20, 'Jambi', 'Pangkalan Jambu, Merangin', 141.9872000, 'U', 2.14),
(21, 'Jambi', 'Sumay, Tebo', 143.1858000, 'U', 1.38),
(22, 'Jambi', 'Sungai Gelam, Muaro Jambi', 141.8864000, 'U', 1.69),
(23, 'Lampung', 'Semaka, Tanggamus', 146.0553000, 'U', 5.42),
(24, 'Lampung', 'Tulang Bawang Udik, Tulang Bawang Barat', 147.6764000, 'U', 4.43),
(25, 'Lampung', 'Waway Karya, Lampung Timur', 158.7464000, 'U', 5.12),
(26, 'Kepulauan Bangka Belitung', 'Pangkalan Baru, Bangka Tengah', 147.9817000, 'U', 2.16),
(27, 'Kepulauan Bangka Belitung', 'Tanjung Pandan, Belitung', 162.0019000, 'U', 2.74),
(28, 'Kalimantan Barat', 'Teriak, Bengkayang', 139.5642000, 'S', 0.79),
(29, 'Kalimantan Barat', 'Sungai Tebelian, Sintang', 141.1319000, 'U', 0.16),
(30, 'Kalimantan Timur', 'Long Bagun, Mahakam Ulu', 137.9722000, 'S', 0.55),
(31, 'Kalimantan Timur', 'Samarinda Seberang, Samarinda', 153.0531000, 'U', 0.53),
(32, 'Kalimantan Selatan', 'Martapura, Banjar', 144.4033000, 'U', 3.31),
(33, 'Kalimantan Tengah', 'Mentawa Baru Ketapang, Kotawaringin Timur', 147.7203000, 'S', 2.54),
(34, 'Kalimantan Tengah', 'Murung, Murung Raya', 139.6094000, 'U', 0.66),
(35, 'Kalimantan Utara', 'Mentarang, Malinau', 142.8703000, 'S', 3.57),
(36, 'Banten', 'Cimanggu, Pandeglang', 158.9333000, 'U', 6.70),
(37, 'Banten', 'Sobang, Lebak', 145.7122000, 'U', 6.66),
(38, 'DKI Jakarta', 'Senen, Jakarta Pusat', 164.0225000, 'U', 6.17),
(39, 'Jawa Barat', 'Curugkembar, Sukabumi', 152.1975000, 'U', 7.21),
(40, 'Jawa Barat', 'Baleendah, Bandung', 141.9381000, 'U', 7.00),
(41, 'Jawa Barat', 'Pamanukan, Subang', 160.8556000, 'U', 6.28),
(42, 'Jawa Barat', 'Sidamulih, Pangandaran', 188.5650000, 'U', 7.64),
(43, 'Jawa Barat', 'Lemahwungkuk, Cirebon', 161.5083000, 'U', 6.73),
(44, 'Jawa Tengah', 'Taman, Pemalang', 153.8983000, 'U', 6.89),
(45, 'Jawa Tengah', 'Gandrungmangu, Cilacap', 143.4967000, 'U', 7.52),
(46, 'Jawa Tengah', 'Wonosalam, Demak', 163.4681000, 'U', 6.93),
(47, 'Jawa Tengah', 'Sarang, Rembang', 171.9631000, 'U', 6.72),
(48, 'DI Yogyakarta', 'Imogiri, Bantul', 160.3211000, 'U', 7.94),
(49, 'Jawa Timur', 'Kota Sumenep, Sumenep', 178.1436000, 'U', 7.01),
(50, 'Jawa Timur', 'Panarukan, Situbondo', 163.1917000, 'U', 7.69),
(51, 'Jawa Timur', 'Selopuro, Blitar', 153.7919000, 'U', 8.15),
(52, 'Jawa Timur', 'Loceret, Nganjuk', 151.6789000, 'U', 7.65),
(53, 'Jawa Timur', 'Sukodadi, Lamongan', 164.2081000, 'U', 7.09),
(54, 'Bali', 'Payangan, Gianyar', 170.5219000, 'U', 8.43),
(55, 'Nusa Tenggara Timur', 'Fatuleu Barat, Kupang', 172.2300000, 'U', 9.91),
(56, 'Nusa Tenggara Timur', 'Ndoso, Manggarai Barat', 166.9622000, 'U', 8.48),
(57, 'Nusa Tenggara Barat', 'Sandubaya, Mataram', 176.9433000, 'U', 8.58),
(58, 'Nusa Tenggara Barat', 'Empang, Sumbawa', 184.1750000, 'U', 8.77),
(59, 'Gorontalo', 'Atinggola, Gorontalo Utara', 166.4258000, 'S', 0.90),
(60, 'Gorontalo', 'Popayato, Pohuwato', 165.2550000, 'S', 0.51),
(61, 'Sulawesi Barat', 'Dapurang, Pasangkayu', 137.4669000, 'U', 1.71),
(62, 'Sulawesi Barat', 'Sumarorong, Mamasa', 145.6181000, 'U', 3.11),
(63, 'Sulawesi Tengah', 'Basidondo, Toli Toli', 156.0319000, 'S', 0.72),
(64, 'Sulawesi Tengah', 'Dolo, Sigi', 138.5992000, 'U', 1.04),
(65, 'Sulawesi Tengah', 'Toili Barat, Banggai', 152.0819000, 'U', 1.28),
(66, 'Sulawesi Utara', 'Paal Dua, Manado', 164.6108000, 'S', 1.49),
(67, 'Sulawesi Utara', 'Dumoga Timur, Bolaang Mongondow', 155.2172000, 'S', 0.60),
(68, 'Sulawesi Tenggara', 'Batu Putih, Kolaka Utara', 148.2825000, 'U', 3.09),
(69, 'Sulawesi Tenggara', 'Laeya, Konawe Selatan', 165.1494000, 'U', 4.32),
(70, 'Sulawesi Tenggara', 'Murhum, Bau Bau', 160.6172000, 'U', 5.47),
(71, 'Sulawesi Selatan', 'Mappedeceng, Luwu Utara', 148.2336000, 'U', 2.46),
(72, 'Sulawesi Selatan', 'Panca Lautang, Sidenreng Rappang', 158.0269000, 'U', 4.05),
(73, 'Sulawesi Selatan', 'Ujung Loe, Bulukumba', 165.0153000, 'U', 5.42),
(74, 'Maluku Utara', 'Galela Barat, Halmahera Utara', 163.0958000, 'S', 1.84),
(75, 'Maluku Utara', 'Wasile, Halmahera Timur', 153.0436000, 'S', 1.00),
(76, 'Maluku Utara', 'Bacan, Halmahera Selatan', 155.0814000, 'U', 0.58),
(77, 'Maluku', 'Teluk Ambon, Ambon', 160.4475000, 'U', 3.67),
(78, 'Maluku', 'Seram Timur, Seram Bagian Timur', 161.8328000, 'U', 3.83),
(79, 'Maluku', 'Aru Selatan, Kepulauan Aru', 148.7894000, 'U', 6.16),
(80, 'Maluku', 'Tanimbar Selatan, Kepulauan Tanimbar', 170.3678000, 'U', 7.69),
(81, 'Papua Barat', 'Teluk Arguni, Kaimana', 137.8558000, 'U', 3.08),
(82, 'Papua Barat', 'Bintuni, Teluk Bintuni', 150.5853000, 'U', 2.11),
(83, 'Papua', 'Abepura, Jayapura', 149.7478000, 'U', 2.62),
(84, 'Papua', 'Kepulauan Ambai, Kepulauan Yapen', 138.7500000, 'U', 1.93),
(85, 'Papua Tengah', 'Kamu, Dogiyai', 125.4897000, 'U', 4.01),
(86, 'Papua Tengah', 'Mulia, Puncak Jaya', 118.1367000, 'U', 3.70),
(87, 'Papua Tengah', 'Mimika Barat Jauh, Mimika', 124.0539000, 'U', 4.21),
(88, 'Papua Pegunungan', 'Iniye, Nduga', 91.1631000, 'U', 4.33),
(89, 'Papua Pegunungan', 'Iwur, Pegunungan Bintang', 122.1556000, 'U', 5.13),
(90, 'Papua Selatan', 'Naukenjerai, Merauke', 151.7433000, 'U', 5.54),
(91, 'Papua Selatan', 'Agats, Asmat', 132.2878000, 'U', 5.54),
(92, 'Papua Barat Daya', 'Misool Selatan, Raja Ampat', 158.6500000, 'U', 1.95),
(93, 'Papua Barat Daya', 'Sorong Manoi, Sorong', 140.4839000, 'U', 0.87);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_user`
--

INSERT INTO `data_user` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'kiki', 'kiki@gmail.com', '$2y$10$h5zFOUqyPsjPV0qLbhRad.W9o5H4HvnH32otyjd50rNKBBl89obqG', 'admin'),
(2, 'user', 'user@gmail.com', '$2y$10$ReTYaskePxfl0cElaXVNQeQGu3n6FOIYWfPGZENQZblvYcdkrwCam', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perhitungan`
--

CREATE TABLE `perhitungan` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `konfigurasi` varchar(20) DEFAULT NULL,
  `kebutuhan` float DEFAULT NULL,
  `wp` int(11) DEFAULT NULL,
  `kapasitas_baterai` int(11) DEFAULT NULL,
  `kapasitas_inverter` int(11) DEFAULT NULL,
  `jumlah_panel_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`jumlah_panel_json`)),
  `luas_panel_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`luas_panel_json`)),
  `jumlah_baterai_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`jumlah_baterai_json`)),
  `estimasi_harga_panel_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `jumlah_inverter_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perhitungan`
--

INSERT INTO `perhitungan` (`id`, `username`, `lokasi`, `konfigurasi`, `kebutuhan`, `wp`, `kapasitas_baterai`, `kapasitas_inverter`, `jumlah_panel_json`, `luas_panel_json`, `jumlah_baterai_json`, `estimasi_harga_panel_json`, `jumlah_inverter_json`, `waktu`) VALUES
(1, 'user', 'Cimanggu, Pandeglang', 'off-grid', 10, 3031, 6382, 7, '[[\"Poli\",38,19,13,\"X\",\"X\"],[\"Mono\",31,16,\"X\",7,5],[\"Bifacial\",26,13,\"X\",6,4]]', '[[\"Poli\",\"27.83 m²\",\"27.93 m²\",\"21.15 m²\",\"X\",\"X\"],[\"Mono\",\"20.09 m²\",\"20.43 m²\",\"X\",\"15.46 m²\",\"13.06 m²\"],[\"Bifacial\",\"18.59 m²\",\"17.75 m²\",\"X\",\"18.56 m²\",\"17.47 m²\"]]', '[[12,50,11,\"Rp. 13.090.000\"],[12,100,6,\"Rp. 11.100.000\"],[12,200,3,\"Rp. 10.785.000\"],[12,300,2,\"Rp. 26.100.000\"],[24,100,3,\"Rp. 8.064.000\"],[48,200,1,\"Rp. 7.562.000\"]]', '[[\"Poli\",\"Rp. 55.100.000\",\"Rp. 57.000.000\",\"Rp. 56.550.000\",\"X\",\"X\"],[\"Mono\",\"Rp. 21.700.000\",\"Rp. 22.400.000\",\"X\",\"Rp. 16.485.000\",\"Rp. 19.490.000\"],[\"Bifacial\",\"Rp. 57.200.000\",\"Rp. 49.400.000\",\"X\",\"Rp. 45.000.000\",\"Rp. 42.000.000\"]]', '[[\"1.5 kW\",5,\"Rp. 7.750.000\"],[\"2 kW\",4,\"Rp. 11.200.000\"],[\"3 kW\",3,\"Rp. 14.700.000\"],[\"7 kW\",1,\"Rp. 10.000.000\"]]', '2025-05-14 09:05:44'),
(2, 'user', 'Cimanggu, Pandeglang', 'hybrid', 10, 1819, 3830, 4, '[[\"Poli\",23,12,8,\"X\",\"X\"],[\"Mono\",19,10,\"X\",4,3],[\"Bifacial\",16,8,\"X\",4,3]]', '[[\"Poli\",\"16.85 m²\",\"17.64 m²\",\"13.02 m²\",\"X\",\"X\"],[\"Mono\",\"12.31 m²\",\"12.77 m²\",\"X\",\"8.84 m²\",\"7.84 m²\"],[\"Bifacial\",\"11.44 m²\",\"10.92 m²\",\"X\",\"12.38 m²\",\"13.10 m²\"]]', '[[12,50,7,\"Rp. 8.330.000\"],[12,100,4,\"Rp. 7.400.000\"],[12,200,2,\"Rp. 7.190.000\"],[12,300,2,\"Rp. 26.100.000\"],[24,100,2,\"Rp. 5.376.000\"],[48,200,1,\"Rp. 7.562.000\"]]', '[[\"Poli\",\"Rp. 33.350.000\",\"Rp. 36.000.000\",\"Rp. 34.800.000\",\"X\",\"X\"],[\"Mono\",\"Rp. 13.300.000\",\"Rp. 14.000.000\",\"X\",\"Rp. 9.420.000\",\"Rp. 11.694.000\"],[\"Bifacial\",\"Rp. 35.200.000\",\"Rp. 30.400.000\",\"X\",\"Rp. 30.000.000\",\"Rp. 31.500.000\"]]', '[[\"1.5 kW\",3,\"Rp. 4.650.000\"],[\"2 kW\",2,\"Rp. 5.600.000\"],[\"3 kW\",2,\"Rp. 9.800.000\"],[\"7 kW\",1,\"Rp. 10.000.000\"]]', '2025-05-14 09:55:41'),
(3, 'user', 'Cimanggu, Pandeglang', 'on-grid', 10, 1819, 3830, 4, '[[\"Poli\",23,12,8,\"X\",\"X\"],[\"Mono\",19,10,\"X\",4,3],[\"Bifacial\",16,8,\"X\",4,3]]', '[[\"Poli\",\"16.85 m²\",\"17.64 m²\",\"13.02 m²\",\"X\",\"X\"],[\"Mono\",\"12.31 m²\",\"12.77 m²\",\"X\",\"8.84 m²\",\"7.84 m²\"],[\"Bifacial\",\"11.44 m²\",\"10.92 m²\",\"X\",\"12.38 m²\",\"13.10 m²\"]]', '[[12,50,7,\"Rp. 8.330.000\"],[12,100,4,\"Rp. 7.400.000\"],[12,200,2,\"Rp. 7.190.000\"],[12,300,2,\"Rp. 26.100.000\"],[24,100,2,\"Rp. 5.376.000\"],[48,200,1,\"Rp. 7.562.000\"]]', '[[\"Poli\",\"Rp. 33.350.000\",\"Rp. 36.000.000\",\"Rp. 34.800.000\",\"X\",\"X\"],[\"Mono\",\"Rp. 13.300.000\",\"Rp. 14.000.000\",\"X\",\"Rp. 9.420.000\",\"Rp. 11.694.000\"],[\"Bifacial\",\"Rp. 35.200.000\",\"Rp. 30.400.000\",\"X\",\"Rp. 30.000.000\",\"Rp. 31.500.000\"]]', '[[\"1.5 kW\",3,\"Rp. 4.650.000\"],[\"2 kW\",2,\"Rp. 5.600.000\"],[\"3 kW\",2,\"Rp. 9.800.000\"],[\"7 kW\",1,\"Rp. 10.000.000\"]]', '2025-05-14 09:59:30'),
(4, 'user', 'Cimanggu, Pandeglang', 'hybrid', 10, 1819, 3830, 4, '[[\"Poli\",23,12,8,\"X\",\"X\"],[\"Mono\",19,10,\"X\",4,3],[\"Bifacial\",16,8,\"X\",4,3]]', '[[\"Poli\",\"16.85 m²\",\"17.64 m²\",\"13.02 m²\",\"X\",\"X\"],[\"Mono\",\"12.31 m²\",\"12.77 m²\",\"X\",\"8.84 m²\",\"7.84 m²\"],[\"Bifacial\",\"11.44 m²\",\"10.92 m²\",\"X\",\"12.38 m²\",\"13.10 m²\"]]', '[[12,50,7,\"Rp. 8.330.000\"],[12,100,4,\"Rp. 7.400.000\"],[12,200,2,\"Rp. 7.190.000\"],[12,300,2,\"Rp. 26.100.000\"],[24,100,2,\"Rp. 5.376.000\"],[48,200,1,\"Rp. 7.562.000\"]]', '[[\"Poli\",\"Rp. 33.350.000\",\"Rp. 36.000.000\",\"Rp. 34.800.000\",\"X\",\"X\"],[\"Mono\",\"Rp. 13.300.000\",\"Rp. 14.000.000\",\"X\",\"Rp. 9.420.000\",\"Rp. 11.694.000\"],[\"Bifacial\",\"Rp. 35.200.000\",\"Rp. 30.400.000\",\"X\",\"Rp. 30.000.000\",\"Rp. 31.500.000\"]]', '[[\"1.5 kW\",3,\"Rp. 4.650.000\"],[\"2 kW\",2,\"Rp. 5.600.000\"],[\"3 kW\",2,\"Rp. 9.800.000\"],[\"7 kW\",1,\"Rp. 10.000.000\"]]', '2025-05-14 09:59:38'),
(5, 'user', 'Cimanggu, Pandeglang', 'off-grid', 24, 7273, 15312, 15, '[[\"Poli\",91,46,31,\"X\",\"X\"],[\"Mono\",73,37,\"X\",15,11],[\"Bifacial\",61,31,\"X\",13,9]]', '[[\"Poli\",\"66.65 m²\",\"67.62 m²\",\"50.43 m²\",\"X\",\"X\"],[\"Mono\",\"47.30 m²\",\"47.23 m²\",\"X\",\"33.14 m²\",\"28.74 m²\"],[\"Bifacial\",\"43.61 m²\",\"42.31 m²\",\"X\",\"40.22 m²\",\"39.31 m²\"]]', '[[12,50,26,\"Rp. 30.940.000\"],[12,100,13,\"Rp. 24.050.000\"],[12,200,7,\"Rp. 25.165.000\"],[12,300,5,\"Rp. 65.250.000\"],[24,100,7,\"Rp. 18.816.000\"],[48,200,2,\"Rp. 15.124.000\"]]', '[[\"Poli\",\"Rp. 131.950.000\",\"Rp. 138.000.000\",\"Rp. 134.850.000\",\"X\",\"X\"],[\"Mono\",\"Rp. 51.100.000\",\"Rp. 51.800.000\",\"X\",\"Rp. 35.325.000\",\"Rp. 42.878.000\"],[\"Bifacial\",\"Rp. 134.200.000\",\"Rp. 117.800.000\",\"X\",\"Rp. 97.500.000\",\"Rp. 94.500.000\"]]', '[[\"1.5 kW\",10,\"Rp. 15.500.000\"],[\"2 kW\",8,\"Rp. 22.400.000\"],[\"3 kW\",5,\"Rp. 24.500.000\"],[\"7 kW\",3,\"Rp. 30.000.000\"]]', '2025-05-17 05:33:55');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_irradiasi`
--
ALTER TABLE `data_irradiasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_irradiasi`
--
ALTER TABLE `data_irradiasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `perhitungan`
--
ALTER TABLE `perhitungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
