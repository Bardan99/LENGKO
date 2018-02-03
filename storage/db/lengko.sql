-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2018 at 06:47 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lengko`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_harga_pesanan`(IN `kode_pesanan_param` INT(10) UNSIGNED)
    NO SQL
UPDATE pesanan
SET harga_pesanan=
	(SELECT SUM(pesanan_detil.jumlah_pesanan_detil * menu.harga_menu)
    FROM pesanan_detil, menu WHERE pesanan_detil.kode_menu=menu.kode_menu 
    AND pesanan_detil.kode_pesanan=kode_pesanan_param)
WHERE kode_pesanan=kode_pesanan_param$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_stok_bahan_baku`(IN `kode_menu_param` VARCHAR(15), IN `jumlah_pesanan_detil_param` SMALLINT)
    NO SQL
BEGIN  
    DECLARE eof INT DEFAULT FALSE;

    DECLARE kode VARCHAR(15);
    DECLARE jumlah FLOAT;
    
    DECLARE materials CURSOR FOR
        SELECT kode_bahan_baku, jumlah_bahan_baku_detil 
        FROM menu_detil
        WHERE kode_menu=kode_menu_param;    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET eof=TRUE;
    
    OPEN materials;
    
    materials_loop: LOOP
        FETCH materials INTO kode, jumlah;
        
        IF (eof) THEN
            LEAVE materials_loop;
        END IF;
        
        UPDATE bahan_baku
        SET stok_bahan_baku=
        (stok_bahan_baku - (jumlah_pesanan_detil_param * jumlah))
        WHERE kode_bahan_baku=kode;
        
    END LOOP;    
    
    CLOSE materials;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE IF NOT EXISTS `bahan_baku` (
`kode_bahan_baku` int(10) unsigned NOT NULL,
  `nama_bahan_baku` varchar(50) NOT NULL,
  `stok_bahan_baku` float unsigned NOT NULL,
  `satuan_bahan_baku` varchar(10) NOT NULL,
  `tanggal_kadaluarsa_bahan_baku` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`kode_bahan_baku`, `nama_bahan_baku`, `stok_bahan_baku`, `satuan_bahan_baku`, `tanggal_kadaluarsa_bahan_baku`) VALUES
(1, 'Daging Ayam', 100, 'potong', '2017-03-07'),
(2, 'Cabai Hijau', 333, 'pcs', '2017-12-07'),
(3, 'Air Mineral', 754, 'ml', '2018-01-28'),
(4, 'Bandrek Instan', 200, 'pcs', '2018-01-28'),
(5, 'Air Kelapa', 1000, 'ml', '2018-01-28'),
(6, 'Madu', 979, 'ml', '2018-02-23'),
(7, 'Strawberry', 76, 'pcs', '2018-01-31'),
(8, 'Beras Pandan Wangi', 50000, 'gr', '2018-01-31'),
(9, 'Daging Sapi', 10000, 'gr', '2018-01-17'),
(10, 'Kelapa', 1000, 'gr', '2018-01-25'),
(11, 'Coklat', 1000, 'gr', '2018-01-24'),
(12, 'Gula', 985, 'gr', '2018-01-25'),
(13, 'Bawang putih', 1000, 'gr', '2018-12-14'),
(19, 'Bawang merah', 1000, 'gr', '2018-12-14'),
(21, 'Bawang bombai', 1500, 'gr', '2017-12-06'),
(22, 'Kunyit', 1000, 'gr', '2018-12-15'),
(23, 'Jahe', 1000, 'gr', '2018-12-15'),
(24, 'Kencur', 1000, 'gr', '2018-12-15'),
(25, 'Kecap', 1000, 'ml', '2020-01-15'),
(27, 'Timun', 100, 'pcs', '2018-02-18'),
(28, 'Sambal', 500, 'gr', '2018-02-18'),
(29, 'Teh Sariwangi', 200, 'pcs', '2019-02-04'),
(30, 'Kerupuk', 500, 'pcs', '2018-02-18'),
(31, 'Bumbu Kacang', 300, 'pcs', '2018-02-25'),
(32, 'Tempe', 300, 'potong', '2018-02-28'),
(33, 'Tahu', 250, 'potong', '2018-03-25'),
(34, 'Telur Ayam', 50, 'butir', '2018-03-11'),
(35, 'Coca Cola Kaleng', 200, 'kaleng', '2020-04-01'),
(36, 'Fanta Kaleng', 200, 'kaleng', '2020-04-01'),
(37, 'Sprite Kaleng', 200, 'kaleng', '2020-04-01'),
(38, 'Teh Botol Sosro', 200, 'botol', '2020-04-01');

-- --------------------------------------------------------

--
-- Table structure for table `halaman`
--

CREATE TABLE IF NOT EXISTS `halaman` (
  `kode_halaman` varchar(15) NOT NULL,
  `nama_halaman` varchar(50) NOT NULL,
  `ikon_halaman` varchar(25) NOT NULL,
  `urutan_halaman` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `halaman`
--

INSERT INTO `halaman` (`kode_halaman`, `nama_halaman`, `ikon_halaman`, `urutan_halaman`) VALUES
('device', 'Perangkat', 'glyphicon-cog', 2),
('employee', 'Pegawai', 'glyphicon-user', 3),
('home', 'Beranda', 'glyphicon-dashboard', 1),
('logout', 'Keluar', 'glyphicon-off', 10),
('material', 'Bahan Baku', 'glyphicon-hdd', 4),
('menu', 'Menu', 'glyphicon-th-list', 5),
('order', 'Pesanan', 'glyphicon-shopping-cart', 6),
('report', 'Laporan', 'glyphicon-folder-open', 8),
('review', 'Kuisioner', 'glyphicon-heart', 9),
('transaction', 'Transaksi', 'glyphicon-usd', 7);

-- --------------------------------------------------------

--
-- Table structure for table `halaman_detil`
--

CREATE TABLE IF NOT EXISTS `halaman_detil` (
`kode_halaman_detil` int(11) NOT NULL,
  `kode_otoritas` varchar(15) NOT NULL,
  `kode_halaman` varchar(15) NOT NULL,
  `status_halaman_detil` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `halaman_detil`
--

INSERT INTO `halaman_detil` (`kode_halaman_detil`, `kode_otoritas`, `kode_halaman`, `status_halaman_detil`) VALUES
(1, 'waiter', 'home', 1),
(2, 'waiter', 'menu', 1),
(3, 'waiter', 'order', 1),
(4, 'waiter', 'device', 1),
(5, 'waiter', 'logout', 1),
(6, 'chef', 'home', 1),
(8, 'chef', 'order', 1),
(9, 'chef', 'logout', 1),
(10, 'pantry', 'home', 1),
(12, 'pantry', 'material', 1),
(13, 'pantry', 'logout', 1),
(14, 'cashier', 'home', 1),
(15, 'cashier', 'transaction', 1),
(16, 'cashier', 'report', 1),
(18, 'cashier', 'logout', 1),
(19, 'cs', 'home', 1),
(20, 'cs', 'review', 1),
(21, 'cs', 'logout', 1),
(22, 'root', 'home', 1),
(23, 'root', 'device', 1),
(24, 'root', 'employee', 1),
(25, 'root', 'logout', 1),
(26, 'root', 'material', 1),
(27, 'root', 'menu', 1),
(28, 'root', 'order', 1),
(29, 'root', 'report', 1),
(30, 'root', 'review', 1),
(31, 'root', 'transaction', 1),
(32, 'chef', 'material', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner`
--

CREATE TABLE IF NOT EXISTS `kuisioner` (
`kode_kuisioner` int(10) unsigned NOT NULL,
  `judul_kuisioner` varchar(15) NOT NULL,
  `isi_kuisioner` text NOT NULL,
  `tanggal_kuisioner` date NOT NULL,
  `waktu_kuisioner` time NOT NULL,
  `status_kuisioner` tinyint(1) NOT NULL DEFAULT '1',
  `kode_pegawai` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner`
--

INSERT INTO `kuisioner` (`kode_kuisioner`, `judul_kuisioner`, `isi_kuisioner`, `tanggal_kuisioner`, `waktu_kuisioner`, `status_kuisioner`, `kode_pegawai`) VALUES
(1, 'Restoran', 'Bagaimana pendapat anda mengenai restoran LENGKO?', '2017-11-16', '21:43:33', 0, 'toor'),
(2, 'Pelayanan', 'Bagaimana pelayanan yang diberikan oleh pegawai LENGKO terhadap anda?', '2017-11-17', '15:42:33', 1, 'toor'),
(3, 'Fasilitas', 'Bagaimana pendapat anda mengenai Fasilitas yang terdapat di LENGKO?', '2017-11-17', '15:10:33', 1, 'toor'),
(4, 'Harga', 'Apakah harga makanan dan minuman di LENGKO relatif murah?', '2017-12-03', '19:12:51', 1, 'toor'),
(6, 'Tempat Parkiran', 'Apakah di tempat parkiran ada yang jualan krabby petty?', '2018-01-14', '01:01:12', 1, 'rakamp'),
(7, 'Spongebob', 'Lucuan siapa, Spongebob atau Squidward?', '2018-01-14', '01:01:31', 1, 'rakamp');

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner_detil`
--

CREATE TABLE IF NOT EXISTS `kuisioner_detil` (
`kode_kuisioner_detil` int(10) unsigned NOT NULL,
  `poin_kuisioner_detil` tinyint(1) unsigned NOT NULL,
  `kode_kuisioner_perangkat` int(10) unsigned NOT NULL,
  `kode_kuisioner` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner_detil`
--

INSERT INTO `kuisioner_detil` (`kode_kuisioner_detil`, `poin_kuisioner_detil`, `kode_kuisioner_perangkat`, `kode_kuisioner`) VALUES
(22, 4, 5, 3),
(23, 3, 5, 4),
(24, 5, 5, 2),
(25, 1, 5, 7),
(26, 0, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner_perangkat`
--

CREATE TABLE IF NOT EXISTS `kuisioner_perangkat` (
`kode_kuisioner_perangkat` int(10) unsigned NOT NULL,
  `pembeli_kuisioner_perangkat` varchar(50) NOT NULL,
  `pesan_kuisioner_perangkat` text NOT NULL,
  `tanggal_kuisioner_perangkat` date NOT NULL,
  `waktu_kuisioner_perangkat` time NOT NULL,
  `status_kuisioner_perangkat` tinyint(1) NOT NULL DEFAULT '1',
  `kode_perangkat` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner_perangkat`
--

INSERT INTO `kuisioner_perangkat` (`kode_kuisioner_perangkat`, `pembeli_kuisioner_perangkat`, `pesan_kuisioner_perangkat`, `tanggal_kuisioner_perangkat`, `waktu_kuisioner_perangkat`, `status_kuisioner_perangkat`, `kode_perangkat`) VALUES
(5, 'Donald Bebek', 'Rendang padangnya enak, khas padang. Cuma sayang bakso rudalnya udah habis :(', '2018-01-19', '15:01:23', 1, 'KJ002');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`kode_menu` int(10) unsigned NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `jenis_menu` enum('F','D') NOT NULL COMMENT 'F = food, D = drink',
  `harga_menu` int(10) unsigned NOT NULL,
  `deskripsi_menu` text NOT NULL,
  `gambar_menu` varchar(150) NOT NULL,
  `kode_pegawai` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`kode_menu`, `nama_menu`, `jenis_menu`, `harga_menu`, `deskripsi_menu`, `gambar_menu`, `kode_pegawai`) VALUES
(1, 'Nasi Ayam Penyet', 'F', 18000, 'Ayam penyet is Indonesian — more precisely East Javanese cuisine — fried chicken dish consisting of fried chicken that is smashed with the pestle against mortar to make it softer, served with sambal, slices of cucumbers, fried tofu and tempeh.', 'ayam-penyet.jpg', 'conan'),
(2, 'Milk Shake', 'D', 10000, 'Susu kocok adalah minuman dingin dari campuran susu, es krim, dan sirop berperasa yang dikocok hingga berbusa. Selain dikocok dengan blender, susu kocok bisa dibuat dengan memakai gelas pengocok bertutup.', 'milk-shake.jpg', 'conan'),
(3, 'Strawberry Tubruk', 'D', 10000, 'Stroberi atau tepatnya stroberi kebun adalah sebuah varietas stroberi yang paling banyak dikenal di dunia. Seperti spesies lain dalam genus Fragaria, buah ini berada dalam keluarga Rosaceae', 'stroberry-tubruk.jpg', 'conan'),
(4, 'Teh Manis', 'D', 3500, 'Teh manis adalah minuman yang terbuat dari larutan teh yang diberi pemanis, biasanya gula tebu, sebelum minuman ini siap disajikan. Untuk konteks Indonesia, teh manis yang diberi es biasa disebut es teh.', 'teh-manis.jpg', 'conan'),
(7, 'Rendang Padang', 'F', 13500, 'Rendang atau randang adalah masakan dari daging bercita rasa pedas yang menggunakan campuran dari berbagai bumbu dan rempah-rempah. Masakan ini dihasilkan dari proses memasak yang dipanaskan berulang-ulang dengan santan kelapa.', 'rendang-padang.jpg', 'conan'),
(8, 'Nasi Lengko', 'F', 16500, 'Sega lengko adalah makanan khas masyarakat pantai utara. Makanan khas yang sederhana ini sarat akan protein dan serat serta rendah kalori karena bahan-bahan yang digunakan adalah 100% non-hewani.', 'nasi-lengko.jpg', 'conan'),
(9, 'Soto Ayam', 'F', 14500, 'Soto ayam adalah makanan khas Indonesia yang berupa sejenis sup ayam dengan kuah yang berwarna kekuningan. Warna kuning ini dikarenakan oleh kunyit yang digunakan sebagai bumbu. Soto ayam banyak ditemukan di daerah-daerah di Indonesia dan Singapura.', 'soto-ayam.jpg', 'conan'),
(10, 'Sate Ayam', 'F', 15000, 'Sate Ayam adalah makanan khas Indonesia. Sate Ayam dibuat dari daging ayam. Pada umumnya sate ayam dimasak dengan cara dipanggang dengan menggunakan arang dan disajikan dengan pilihan bumbu kacang atau bumbu kecap.', 'sate-ayam.jpg', 'conan'),
(11, 'Nasi Putih', 'F', 7500, 'Nasi adalah beras yang telah direbus. Proses perebusan beras dikenal juga sebagai ''tim''. Penanakan diperlukan untuk membangkitkan aroma nasi dan membuatnya lebih lunak tetapi tetap terjaga konsistensinya.', 'nasi-putih.jpg', 'conan'),
(12, 'Teh Botol Sosro', 'D', 4500, 'Teh Botol Sosro adalah merek teh beraroma melati yang dipasarkan oleh PT. Sinar Sosro. Teh Botol Sosro sangat populer di Indonesia dan kini juga dijual di berbagai negara di luar Indonesia.', 'teh-botol-sosro.jpg', 'conan'),
(13, 'Fanta', 'D', 5000, 'Fanta adalah merek minuman ringan berkarbonasi rasa buah yang diproduksi oleh The Coca-Cola Company. Tersedia lebih dari ratusan pilihan rasa di seluruh dunia. Minuman ini diperkenalkan pertama kali di Jerman pada tahun 1940.', 'fanta.jpg', 'conan'),
(14, 'Coca Cola', 'D', 5000, 'Coca-Cola adalah minuman ringan berkarbonasi yang dijual di toko, restoran, dan mesin penjual di lebih dari 200 negara. Minuman ini diproduksi oleh The Coca-Cola Company asal Atlanta, Georgia, dan sering disebut Coke saja.', 'coca-cola.jpg', 'conan'),
(15, 'Sprite', 'D', 5000, 'Sprite (sebelumnya bernama Fanta Klare Zitrone (Clear Lemon Fanta) di Jerman Barat pada tahun 1959, di Venezuela disebut sebagai "Chinotto") adalah minuman yang tidak berwarna dengan rasa lemon dan jeruk nipis serta bebas kafeina yang diproduksi oleh The Coca-Cola Company dan diluncurkan secara resm', 'sprite.jpg', 'conan');

-- --------------------------------------------------------

--
-- Table structure for table `menu_detil`
--

CREATE TABLE IF NOT EXISTS `menu_detil` (
`kode_menu_detil` int(10) unsigned NOT NULL,
  `jumlah_bahan_baku_detil` float NOT NULL,
  `kode_menu` int(10) unsigned NOT NULL,
  `kode_bahan_baku` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_detil`
--

INSERT INTO `menu_detil` (`kode_menu_detil`, `jumlah_bahan_baku_detil`, `kode_menu`, `kode_bahan_baku`) VALUES
(118, 250, 2, 3),
(119, 20, 2, 6),
(120, 1, 1, 1),
(121, 200, 1, 8),
(122, 20, 1, 28),
(123, 3, 1, 27),
(124, 250, 3, 3),
(125, 5, 3, 7),
(126, 250, 4, 3),
(127, 20, 4, 12),
(128, 1, 4, 29),
(132, 10, 7, 19),
(133, 10, 7, 13),
(134, 1, 7, 2),
(135, 150, 7, 9),
(136, 150, 8, 8),
(137, 1, 8, 31),
(138, 2, 8, 30),
(139, 5, 8, 33),
(140, 5, 8, 32),
(143, 1, 9, 1),
(144, 1, 9, 34),
(145, 1, 10, 31),
(146, 1, 10, 1),
(147, 10, 10, 25),
(148, 3, 10, 27),
(149, 100, 11, 3),
(150, 150, 11, 8),
(151, 1, 14, 35),
(152, 1, 13, 36),
(153, 1, 15, 37),
(154, 1, 12, 38);

-- --------------------------------------------------------

--
-- Table structure for table `otoritas`
--

CREATE TABLE IF NOT EXISTS `otoritas` (
  `kode_otoritas` varchar(15) NOT NULL,
  `nama_otoritas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otoritas`
--

INSERT INTO `otoritas` (`kode_otoritas`, `nama_otoritas`) VALUES
('cashier', 'Kasir'),
('chef', 'Koki'),
('cs', 'Pelayanan Pelanggan'),
('pantry', 'Gudang'),
('root', 'Administrator'),
('waiter', 'Pelayan');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
  `kode_pegawai` varchar(15) NOT NULL,
  `kata_sandi_pegawai` varchar(100) NOT NULL,
  `nama_pegawai` varchar(50) NOT NULL,
  `jenis_kelamin_pegawai` enum('L','P') NOT NULL DEFAULT 'L',
  `gambar_pegawai` varchar(100) NOT NULL,
  `kode_otoritas` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`kode_pegawai`, `kata_sandi_pegawai`, `nama_pegawai`, `jenis_kelamin_pegawai`, `gambar_pegawai`, `kode_otoritas`) VALUES
('azmi', '$2y$10$2Ek5MCjdYMxc9bKboh70DeB2kPBiGP48EHviXqEHkKzu1czuLRRfO', 'Azmi Yudista', 'L', 'azmi-yudista.jpg', 'pantry'),
('binsar', '$2y$10$khX/bOJ46mhfRZSQ3towheZU9zk5PekMKl7OP2Y32kBfSgy6Ff2Ki', 'Binsar Bernandus Silalahi', 'P', 'binsar-bernandus-silalahi.png', 'chef'),
('conan', '$2y$10$5LrQFL0Ag6XD4Lcp5Ut6/ukLUw5H7IRN7dr2CS6E2zQ1CIAm3.BOK', 'Edogawa Conan', 'L', 'edogawa-conan.png', 'root'),
('john', '$2y$10$ibk0IfTORSmZ9Rb3t/bzzuA7fQlWBSlEjhZKHC0sklrcOXxUcwFWm', 'John Cena', 'L', 'john-cena.png', 'waiter'),
('joker', '$2y$10$rndZe1IUssuxA.L61GDMUuJ8Rop4m.xZNxzLpuoKNGM4GcjTzs7bu', 'Joker ', 'L', '', 'root'),
('rakamp', '$2y$10$ETeX9YAQtLeVpucrk8qPzeBJOCMgkHgHB0q/FQ8OW07s/AwzSKTgS', 'Raka Muhamad Pratama', 'L', 'raka-muhamad-pratama.png', 'cs'),
('toor', '$2y$10$EDeS.BEQTQT7JvdnASMIMeuauH/B/wMMW2AFt2FE4zY8XK0LHfQhy', 'Raka Suryaardi Widjaja', 'L', 'raka-suryaardi-widjaja.png', 'root'),
('zaki', '$2y$10$fRhyE1ZLIHVpvbhN2Mgg7elrPIAeMnNu89OZybGTMjg8eSJl1/3D2', 'Muhammad Zaki', 'L', 'muhammad-zaki.png', 'cashier');

-- --------------------------------------------------------

--
-- Table structure for table `pemberitahuan`
--

CREATE TABLE IF NOT EXISTS `pemberitahuan` (
`kode_pemberitahuan` int(10) unsigned NOT NULL,
  `isi_pemberitahuan` text NOT NULL,
  `tanggal_pemberitahuan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kode_perangkat` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemberitahuan`
--

INSERT INTO `pemberitahuan` (`kode_pemberitahuan`, `isi_pemberitahuan`, `tanggal_pemberitahuan`, `kode_perangkat`) VALUES
(24, 'Terdapat order baru di perangkat Kamboja 2.', '2017-12-19 17:35:25', 'KJ002'),
(25, 'Pesanan Momon[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 17:35:32', 'KJ002'),
(26, 'Terdapat order baru di perangkat Kamboja 2.', '2017-12-19 19:30:48', 'KJ002'),
(27, 'Terdapat order baru di perangkat Kamboja 2.', '2017-12-19 19:32:10', 'KJ002'),
(28, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 19:32:20', 'KJ002'),
(31, 'Pesanan #4 [Monica@Kamboja 2] selesai dibuat.', '2017-12-19 21:08:23', 'KJ002'),
(32, 'Terdapat order baru di perangkat Mawar 1.', '2017-12-19 21:10:17', 'MW001'),
(33, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:11:11', 'MW001'),
(36, 'Pesanan #6 (Bandrek) [@Mawar 1] selesai dibuat.', '2017-12-19 21:16:32', 'MW001'),
(37, 'Pesanan #6 (Ayam Betutu) [@Mawar 1] selesai dibuat.', '2017-12-19 21:17:00', 'MW001'),
(38, 'Pesanan #6 [@Mawar 1] selesai dibuat.', '2017-12-19 21:18:39', 'MW001'),
(39, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 21:20:22', 'KJ002'),
(41, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 21:21:59', 'KJ002'),
(43, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:24:47', 'MW001'),
(44, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 21:25:24', 'KJ002'),
(46, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:25:52', 'MW001'),
(47, 'Pesanan #4 [Monica@Kamboja 2] selesai dibuat.', '2017-12-19 21:27:47', 'KJ002'),
(49, 'Pesanan #6 [@Mawar 1] selesai dibuat.', '2017-12-19 21:28:40', 'MW001'),
(69, 'Kamboja 2 membutuhkan bantuan.', '2018-01-11 16:33:19', 'KJ002'),
(71, 'Terdapat order baru di perangkat Mawar 1.', '2018-01-13 17:23:20', 'MW001'),
(73, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2018-01-13 17:23:55', 'MW001'),
(75, 'Pesanan #2 [@Mawar 1] selesai dibuat.', '2018-01-13 17:24:14', 'MW001'),
(77, 'Transaksi [Mawar 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2018-01-13 17:25:19', 'MW001'),
(82, 'Terdapat order baru di perangkat Mawar 1.', '2018-01-14 01:34:07', 'MW001'),
(83, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2018-01-14 01:37:15', 'MW001'),
(84, 'Pesanan #4 [@Mawar 1] selesai dibuat.', '2018-01-14 01:38:46', 'MW001'),
(85, 'Transaksi [Mawar 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2018-01-14 01:41:23', 'MW001'),
(92, 'Terdapat order baru di perangkat Kamboja 1.', '2018-01-14 09:58:01', 'KJ001'),
(93, 'Pesanan [Kamboja 1] sudah dikonfirmasi pelayan.', '2018-01-14 09:58:22', 'KJ001'),
(94, 'Pesanan #6 [@Kamboja 1] selesai dibuat.', '2018-01-14 09:59:49', 'KJ001'),
(95, 'Transaksi [Kamboja 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2018-01-14 10:00:42', 'KJ001');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan_bahan_baku`
--

CREATE TABLE IF NOT EXISTS `pengadaan_bahan_baku` (
`kode_pengadaan_bahan_baku` int(10) unsigned NOT NULL,
  `subjek_pengadaan_bahan_baku` varchar(50) NOT NULL,
  `tanggal_pengadaan_bahan_baku` date NOT NULL,
  `waktu_pengadaan_bahan_baku` time NOT NULL,
  `catatan_pengadaan_bahan_baku` text NOT NULL,
  `status_pengadaan_bahan_baku` tinyint(1) DEFAULT '0',
  `kode_pegawai` varchar(15) NOT NULL,
  `kode_prioritas` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadaan_bahan_baku`
--

INSERT INTO `pengadaan_bahan_baku` (`kode_pengadaan_bahan_baku`, `subjek_pengadaan_bahan_baku`, `tanggal_pengadaan_bahan_baku`, `waktu_pengadaan_bahan_baku`, `catatan_pengadaan_bahan_baku`, `status_pengadaan_bahan_baku`, `kode_pegawai`, `kode_prioritas`) VALUES
(1, 'Pengajuan_satu', '2018-01-13', '15:01:07', 'Cepetan', -1, 'binsar', '2'),
(2, 'pengajuan_dua', '2018-01-13', '15:01:20', 'Cepetan', -1, 'binsar', '2'),
(3, 'Pengajuan_satu', '2018-01-13', '16:01:44', 'Cepetan', -1, 'binsar', '1'),
(4, 'Pengajuan_dua', '2018-01-13', '16:01:01', 'Cepetan', 1, 'binsar', '2'),
(5, 'Pengajuan_tiga', '2018-01-13', '16:01:55', 'Cepetan', 1, 'binsar', '0'),
(6, 'Pengajuan Minuman Baru', '2018-01-19', '15:01:05', 'Pengajuan Minuman Baru', 1, 'binsar', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaan_bahan_baku_detil`
--

CREATE TABLE IF NOT EXISTS `pengadaan_bahan_baku_detil` (
`kode_pengadaan_bahan_baku_detil` int(10) unsigned NOT NULL,
  `nama_bahan_baku` varchar(50) NOT NULL,
  `jumlah_bahan_baku` float unsigned NOT NULL,
  `satuan_bahan_baku` varchar(10) NOT NULL,
  `kode_pengadaan_bahan_baku` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengadaan_bahan_baku_detil`
--

INSERT INTO `pengadaan_bahan_baku_detil` (`kode_pengadaan_bahan_baku_detil`, `nama_bahan_baku`, `jumlah_bahan_baku`, `satuan_bahan_baku`, `kode_pengadaan_bahan_baku`) VALUES
(1, 'Ayam', 0, '', 1),
(2, 'Air Mineral', 0, '', 1),
(3, 'Bandrek Instan', 0, '', 1),
(4, 'Madu', 0, '', 1),
(5, 'Cabai Hijau', 0, '', 2),
(6, 'Air Mineral', 0, '', 2),
(7, 'Ayam', 0, '', 3),
(8, 'Air Mineral', 0, '', 3),
(9, 'Bandrek Instan', 0, '', 3),
(10, 'Cabai Hijau', 0, '', 3),
(11, 'Cabai Hijau', 0, '', 4),
(12, 'Ayam', 1000, 'gr', 4),
(13, 'Air Kelapa', 1000, 'gr', 5),
(14, 'Air Mineral', 5000, 'liter', 5),
(15, 'Bandrek Instan', 1000, 'liter', 5),
(16, 'Cabai Hijau', 1000, 'gr', 5),
(17, 'Madu', 1000, 'gr', 5),
(18, 'Coca Cola Kaleng', 200, 'kaleng', 6),
(19, 'Fanta Kaleng', 200, 'kaleng', 6),
(20, 'Sprite Kaleng', 200, 'kaleng', 6),
(21, 'Teh Botol Sosro', 200, 'botol', 6);

-- --------------------------------------------------------

--
-- Table structure for table `perangkat`
--

CREATE TABLE IF NOT EXISTS `perangkat` (
  `kode_perangkat` varchar(15) NOT NULL,
  `kata_sandi_perangkat` varchar(150) NOT NULL,
  `nama_perangkat` varchar(50) NOT NULL,
  `jumlah_kursi_perangkat` tinyint(3) unsigned NOT NULL,
  `status_perangkat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perangkat`
--

INSERT INTO `perangkat` (`kode_perangkat`, `kata_sandi_perangkat`, `nama_perangkat`, `jumlah_kursi_perangkat`, `status_perangkat`) VALUES
('AG001', '$2y$10$Fvq3uy06q5tK/.Ic6KWVPeAzBgL58u1L7oeD39gcO9zkCtbLBXN9W', 'Anggrek 1', 6, 0),
('AG002', '$2y$10$BN6VLdDDydNWio6VtxPvQO.RIgaIBoOWdH9TpDc/Zgg/aerrR7Ueq', 'Anggrek 2', 6, 0),
('JB001', '$2y$10$JL7UuE.XMM1Lndd9godjMeoOhVzxvBshTTw..cjxP2k8g91X4t5ge', 'Jomblo 1', 1, 1),
('JB002', '$2y$10$RKHZ1BDa3hLXrJIoYBeVXOQC1HFeLdkVczYmZ98nvLLHv0AyQ931S', 'Jomblo 2', 1, 1),
('JB003', '$2y$10$2IayHDJEVVB3.B5NSWn/BOHDTAWNM0120eFAPOR.84g/4hOn.l2XO', 'Jomblo 3', 1, 0),
('KJ001', '$2y$10$np7QjOjygHid1TLglRt4zewykPkuGsiExEJor4wNTndbp1sc7PG5.', 'Kamboja 1', 3, 1),
('KJ002', '$2y$10$xBGIzJEO9XiqrVplq86Wv.lAyQreSDR8vm2HrlwzLK8O6JnpZSSj.', 'Kamboja 2', 3, 1),
('MW001', '$2y$10$UQ37G9RLcx8Ib7ld3S6oFOfphADDe24fiHY7eWdpeKn1HgYgX0DIu', 'Mawar 1', 2, 1),
('MW002', '$2y$10$usTyzQS9ALM/2m4LehLYXOBMURAvKLhs6rPxyvnAvRXd8oq9o7u.q', 'Mawar 2', 2, 0),
('TL001', '$2y$10$HarE/poujEt2jXzIb2KsGOCpxA8Heai2MyTj8.z7b1ic5poLcHFDK', 'Tulip 1', 5, 0),
('TL002', '$2y$10$A5LiueefDMBlRNFX4tAKg.i2svTaLVIdWSVQvY29xP/scaspYNvYe', 'Tulip 2', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE IF NOT EXISTS `pesanan` (
`kode_pesanan` int(10) unsigned NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `waktu_pesanan` time NOT NULL,
  `pembeli_pesanan` varchar(50) NOT NULL,
  `catatan_pesanan` text NOT NULL,
  `harga_pesanan` int(10) unsigned NOT NULL DEFAULT '0',
  `tunai_pesanan` int(10) unsigned NOT NULL DEFAULT '0',
  `status_pesanan` enum('C','P','T','D') NOT NULL DEFAULT 'C' COMMENT 'C = Confirmation, P = Process, T = Transaction, D = Done',
  `kode_pegawai` varchar(15) DEFAULT NULL,
  `kode_perangkat` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`kode_pesanan`, `tanggal_pesanan`, `waktu_pesanan`, `pembeli_pesanan`, `catatan_pesanan`, `harga_pesanan`, `tunai_pesanan`, `status_pesanan`, `kode_pegawai`, `kode_perangkat`) VALUES
(2, '2018-01-13', '17:01:20', '', '', 10000, 11000, 'D', 'conan', 'MW001'),
(4, '2018-01-14', '01:01:07', '', '', 30000, 30000, 'D', 'conan', 'MW001'),
(6, '2018-01-14', '09:01:01', '', '', 100000, 150000, 'D', 'conan', 'KJ001');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detil`
--

CREATE TABLE IF NOT EXISTS `pesanan_detil` (
`kode_pesanan_detil` int(10) unsigned NOT NULL,
  `jumlah_pesanan_detil` smallint(6) unsigned NOT NULL,
  `status_pesanan_detil` enum('P','D') NOT NULL DEFAULT 'P' COMMENT 'P = Process, D = Done',
  `kode_pesanan` int(10) unsigned NOT NULL,
  `kode_menu` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan_detil`
--

INSERT INTO `pesanan_detil` (`kode_pesanan_detil`, `jumlah_pesanan_detil`, `status_pesanan_detil`, `kode_pesanan`, `kode_menu`) VALUES
(2, 1, 'D', 2, 3),
(4, 3, 'D', 4, 3),
(8, 10, 'D', 6, 3);

--
-- Triggers `pesanan_detil`
--
DELIMITER //
CREATE TRIGGER `PESANAN_DETIL_AFTER_INSERT` AFTER INSERT ON `pesanan_detil`
 FOR EACH ROW BEGIN
    CALL update_harga_pesanan(new.kode_pesanan);
    CALL update_stok_bahan_baku(new.kode_menu, new.jumlah_pesanan_detil);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `prioritas`
--

CREATE TABLE IF NOT EXISTS `prioritas` (
  `kode_prioritas` varchar(15) NOT NULL,
  `nama_prioritas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prioritas`
--

INSERT INTO `prioritas` (`kode_prioritas`, `nama_prioritas`) VALUES
('0', 'Tinggi'),
('1', 'Sedang'),
('2', 'Rendah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
 ADD PRIMARY KEY (`kode_bahan_baku`);

--
-- Indexes for table `halaman`
--
ALTER TABLE `halaman`
 ADD PRIMARY KEY (`kode_halaman`);

--
-- Indexes for table `halaman_detil`
--
ALTER TABLE `halaman_detil`
 ADD PRIMARY KEY (`kode_halaman_detil`), ADD KEY `kode_otoritas` (`kode_otoritas`,`kode_halaman`), ADD KEY `kode_halaman` (`kode_halaman`);

--
-- Indexes for table `kuisioner`
--
ALTER TABLE `kuisioner`
 ADD PRIMARY KEY (`kode_kuisioner`), ADD UNIQUE KEY `judul_kuisioner` (`judul_kuisioner`), ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `kuisioner_detil`
--
ALTER TABLE `kuisioner_detil`
 ADD PRIMARY KEY (`kode_kuisioner_detil`), ADD KEY `kode_kuisioner` (`kode_kuisioner`,`kode_kuisioner_perangkat`), ADD KEY `kode_kuisioner_perangkat` (`kode_kuisioner_perangkat`);

--
-- Indexes for table `kuisioner_perangkat`
--
ALTER TABLE `kuisioner_perangkat`
 ADD PRIMARY KEY (`kode_kuisioner_perangkat`), ADD KEY `kode_perangkat` (`kode_perangkat`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`kode_menu`), ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `menu_detil`
--
ALTER TABLE `menu_detil`
 ADD PRIMARY KEY (`kode_menu_detil`), ADD UNIQUE KEY `kode_menu_2` (`kode_menu`,`kode_bahan_baku`), ADD KEY `kode_bahan_baku` (`kode_bahan_baku`,`kode_menu`), ADD KEY `kode_menu` (`kode_menu`);

--
-- Indexes for table `otoritas`
--
ALTER TABLE `otoritas`
 ADD PRIMARY KEY (`kode_otoritas`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
 ADD PRIMARY KEY (`kode_pegawai`), ADD KEY `kode_otoritas` (`kode_otoritas`);

--
-- Indexes for table `pemberitahuan`
--
ALTER TABLE `pemberitahuan`
 ADD PRIMARY KEY (`kode_pemberitahuan`), ADD KEY `kode_perangkat` (`kode_perangkat`);

--
-- Indexes for table `pengadaan_bahan_baku`
--
ALTER TABLE `pengadaan_bahan_baku`
 ADD PRIMARY KEY (`kode_pengadaan_bahan_baku`), ADD KEY `kode_prioritas` (`kode_prioritas`), ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `pengadaan_bahan_baku_detil`
--
ALTER TABLE `pengadaan_bahan_baku_detil`
 ADD PRIMARY KEY (`kode_pengadaan_bahan_baku_detil`), ADD KEY `kode_pengadaan_bahan_baku` (`kode_pengadaan_bahan_baku`);

--
-- Indexes for table `perangkat`
--
ALTER TABLE `perangkat`
 ADD PRIMARY KEY (`kode_perangkat`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
 ADD PRIMARY KEY (`kode_pesanan`), ADD KEY `kode_pegawai` (`kode_pegawai`), ADD KEY `kode_perangkat` (`kode_perangkat`);

--
-- Indexes for table `pesanan_detil`
--
ALTER TABLE `pesanan_detil`
 ADD PRIMARY KEY (`kode_pesanan_detil`), ADD KEY `kode_menu` (`kode_menu`), ADD KEY `kode_pesanan_2` (`kode_pesanan`);

--
-- Indexes for table `prioritas`
--
ALTER TABLE `prioritas`
 ADD PRIMARY KEY (`kode_prioritas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
MODIFY `kode_bahan_baku` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `halaman_detil`
--
ALTER TABLE `halaman_detil`
MODIFY `kode_halaman_detil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `kuisioner`
--
ALTER TABLE `kuisioner`
MODIFY `kode_kuisioner` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `kuisioner_detil`
--
ALTER TABLE `kuisioner_detil`
MODIFY `kode_kuisioner_detil` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `kuisioner_perangkat`
--
ALTER TABLE `kuisioner_perangkat`
MODIFY `kode_kuisioner_perangkat` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `kode_menu` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `menu_detil`
--
ALTER TABLE `menu_detil`
MODIFY `kode_menu_detil` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT for table `pemberitahuan`
--
ALTER TABLE `pemberitahuan`
MODIFY `kode_pemberitahuan` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `pengadaan_bahan_baku`
--
ALTER TABLE `pengadaan_bahan_baku`
MODIFY `kode_pengadaan_bahan_baku` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pengadaan_bahan_baku_detil`
--
ALTER TABLE `pengadaan_bahan_baku_detil`
MODIFY `kode_pengadaan_bahan_baku_detil` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
MODIFY `kode_pesanan` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pesanan_detil`
--
ALTER TABLE `pesanan_detil`
MODIFY `kode_pesanan_detil` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `halaman_detil`
--
ALTER TABLE `halaman_detil`
ADD CONSTRAINT `halaman_detil_ibfk_1` FOREIGN KEY (`kode_otoritas`) REFERENCES `otoritas` (`kode_otoritas`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `halaman_detil_ibfk_2` FOREIGN KEY (`kode_halaman`) REFERENCES `halaman` (`kode_halaman`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `kuisioner`
--
ALTER TABLE `kuisioner`
ADD CONSTRAINT `kuisioner_ibfk_1` FOREIGN KEY (`kode_pegawai`) REFERENCES `pegawai` (`kode_pegawai`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `kuisioner_detil`
--
ALTER TABLE `kuisioner_detil`
ADD CONSTRAINT `kuisioner_detil_ibfk_2` FOREIGN KEY (`kode_kuisioner_perangkat`) REFERENCES `kuisioner_perangkat` (`kode_kuisioner_perangkat`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `kuisioner_detil_ibfk_3` FOREIGN KEY (`kode_kuisioner`) REFERENCES `kuisioner` (`kode_kuisioner`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisioner_perangkat`
--
ALTER TABLE `kuisioner_perangkat`
ADD CONSTRAINT `kuisioner_perangkat_ibfk_1` FOREIGN KEY (`kode_perangkat`) REFERENCES `perangkat` (`kode_perangkat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`kode_pegawai`) REFERENCES `pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_detil`
--
ALTER TABLE `menu_detil`
ADD CONSTRAINT `menu_detil_ibfk_6` FOREIGN KEY (`kode_bahan_baku`) REFERENCES `bahan_baku` (`kode_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `menu_detil_ibfk_7` FOREIGN KEY (`kode_menu`) REFERENCES `menu` (`kode_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`kode_otoritas`) REFERENCES `otoritas` (`kode_otoritas`) ON UPDATE CASCADE;

--
-- Constraints for table `pemberitahuan`
--
ALTER TABLE `pemberitahuan`
ADD CONSTRAINT `pemberitahuan_ibfk_1` FOREIGN KEY (`kode_perangkat`) REFERENCES `perangkat` (`kode_perangkat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengadaan_bahan_baku`
--
ALTER TABLE `pengadaan_bahan_baku`
ADD CONSTRAINT `pengadaan_bahan_baku_ibfk_2` FOREIGN KEY (`kode_pegawai`) REFERENCES `pegawai` (`kode_pegawai`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `pengadaan_bahan_baku_ibfk_3` FOREIGN KEY (`kode_prioritas`) REFERENCES `prioritas` (`kode_prioritas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengadaan_bahan_baku_detil`
--
ALTER TABLE `pengadaan_bahan_baku_detil`
ADD CONSTRAINT `pengadaan_bahan_baku_detil_ibfk_1` FOREIGN KEY (`kode_pengadaan_bahan_baku`) REFERENCES `pengadaan_bahan_baku` (`kode_pengadaan_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
ADD CONSTRAINT `pesanan_ibfk_3` FOREIGN KEY (`kode_pegawai`) REFERENCES `pegawai` (`kode_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pesanan_ibfk_4` FOREIGN KEY (`kode_perangkat`) REFERENCES `perangkat` (`kode_perangkat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan_detil`
--
ALTER TABLE `pesanan_detil`
ADD CONSTRAINT `pesanan_detil_ibfk_5` FOREIGN KEY (`kode_pesanan`) REFERENCES `pesanan` (`kode_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pesanan_detil_ibfk_6` FOREIGN KEY (`kode_menu`) REFERENCES `menu` (`kode_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
