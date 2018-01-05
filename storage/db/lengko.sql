-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2018 at 04:26 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`kode_bahan_baku`, `nama_bahan_baku`, `stok_bahan_baku`, `satuan_bahan_baku`, `tanggal_kadaluarsa_bahan_baku`) VALUES
(1, 'Ayam', 100, 'Pcs', '2018-01-07'),
(2, 'Cabai Hijau', 333, 'Pcs', '2018-01-12');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner`
--

INSERT INTO `kuisioner` (`kode_kuisioner`, `judul_kuisioner`, `isi_kuisioner`, `tanggal_kuisioner`, `waktu_kuisioner`, `status_kuisioner`, `kode_pegawai`) VALUES
(1, 'Restoran', 'Bagaimana pendapat anda mengenai restoran LENGKO?', '2017-11-16', '21:43:33', 1, 'toor'),
(2, 'Pelayanan', 'Bagaimana pelayanan yang diberikan oleh pegawai LENGKO terhadap anda?', '2017-11-17', '15:42:33', 1, 'toor'),
(3, 'Fasilitas', 'Bagaimana pendapat anda mengenai Fasilitas yang terdapat di LENGKO?', '2017-11-17', '15:10:33', 1, 'toor'),
(4, 'Harga', 'Apakah harga makanan dan minuman di LENGKO relatif murah?', '2017-12-03', '19:12:51', 1, 'toor'),
(5, 'Pegawai', 'Apakah kamu suka atau setidaknya tertarik dengan pegawai LENGKO?', '2017-12-19', '23:12:12', 1, 'toor');

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner_detil`
--

CREATE TABLE IF NOT EXISTS `kuisioner_detil` (
`kode_kuisioner_detil` int(10) unsigned NOT NULL,
  `poin_kuisioner_detil` tinyint(1) unsigned NOT NULL,
  `kode_kuisioner_perangkat` int(10) unsigned NOT NULL,
  `kode_kuisioner` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner_detil`
--

INSERT INTO `kuisioner_detil` (`kode_kuisioner_detil`, `poin_kuisioner_detil`, `kode_kuisioner_perangkat`, `kode_kuisioner`) VALUES
(5, 1, 2, 3),
(6, 4, 2, 4),
(7, 0, 2, 5),
(8, 0, 2, 2),
(9, 2, 2, 1),
(10, 1, 3, 3),
(11, 0, 3, 4),
(12, 2, 3, 5),
(13, 2, 3, 2),
(14, 3, 3, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner_perangkat`
--

INSERT INTO `kuisioner_perangkat` (`kode_kuisioner_perangkat`, `pembeli_kuisioner_perangkat`, `pesan_kuisioner_perangkat`, `tanggal_kuisioner_perangkat`, `waktu_kuisioner_perangkat`, `status_kuisioner_perangkat`, `kode_perangkat`) VALUES
(2, 'Kim Jong Un', 'Tadi gw beli baso kenapa ada hiasan matanya?\nUdah pernah keselek rudal nuklir belum?', '2018-01-05', '14:01:47', 1, 'JB001'),
(3, 'Donald Trump', 'Muke gile lu, barusan gw liat si uun lagi di toilet banyak banget body-guard nya. Konspirasi macam apa ini? Tapi emang bener kata bama, baso nya enak!', '2018-01-05', '14:01:29', 1, 'JB001');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `kode_menu` varchar(15) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `jenis_menu` enum('F','D') NOT NULL COMMENT 'F = food, D = drink',
  `harga_menu` int(10) unsigned NOT NULL,
  `deskripsi_menu` text NOT NULL,
  `gambar_menu` varchar(150) NOT NULL,
  `kode_pegawai` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`kode_menu`, `nama_menu`, `jenis_menu`, `harga_menu`, `deskripsi_menu`, `gambar_menu`, `kode_pegawai`) VALUES
('D001', 'Teh Botol Sosro', 'D', 4500, 'Apapun makanannya, minumnya teh botol sosro.', 'teh-botol-sosro.png', 'toor'),
('D002', 'Kopi Hitam', 'D', 2500, '', '', 'rakamp'),
('D003', 'Teh Tarik', 'D', 3500, 'Teh tarik adalah minuman manis berupa teh dicampur susu yang lazim ditemukan di Asia Tenggara, khususnya Malaysia. Minuman ini biasanya dijual oleh para mamak di Malaysia dan Singapura, yang menjadikannya sebagai minuman nasional negara tersebut.', '', 'rakamp'),
('D004', 'Susu Putih', 'D', 3000, '', '', 'rakamp'),
('D005', 'Susu Coklat', 'D', 3000, '', '', 'rakamp'),
('D006', 'Susu Jahe', 'D', 3500, '', '', 'rakamp'),
('D007', 'Susu Teh Madu Jahe', 'D', 12500, 'Uenak tenan', 'susu-teh-madu-jahe.jpg', 'toor'),
('D010', 'Jus Tomat', 'D', 5000, 'Jus tomat adalah minuman yang terbuat dari sari buah tomat', 'img7-jus-tomat.jpg', 'rakamp'),
('D012', 'Jus Melon', 'D', 5000, 'Jus melon adalah minuman yang terbuat dari sari buah melon', 'img6-jus-melon.jpg', 'rakamp'),
('D013', 'Bandrek', 'D', 6000, 'Bandrek adalah minuman tradisional orang Sunda dari Jawa Barat, Indonesia, yang dikonsumsi untuk meningkatkan kehangatan tubuh. Minuman ini biasanya dihidangkan pada cuaca dingin, seperti di kala hujan ataupun malam hari.', 'bandrek.jpg', 'toor'),
('D014', 'Bajigur', 'D', 4500, 'Bajigur adalah minuman tradisional khas masyarakat Sunda dari daerah Jawa Barat, Indonesia. Bahan utamanya adalah gula aren dan santan. Untuk menambah kenikmatan dicampurkan pula sedikit jahe, garam, dan bubuk vanili.', 'bajigur.jpg', 'toor'),
('F001', 'Nasi Lengko Cirebon', 'F', 15000, 'Sega lengko (nasi lengko dalam bahasa Indonesia) adalah makanan khas masyarakat pantai utara (Cirebon, Indramayu, Brebes, Tegal dan sekitarnya). Makanan khas yang sederhana ini sarat akan protein dan serat serta rendah kalori karena bahan-bahan          yang digunakan adalah 100% non-hewani. Bahan-bahannya antara lain: nasi putih (panas-panas lebih baik), tempe goreng, tahu goreng, mentimun (mentah segar, dicacah), tauge (direbus), daun kucai (dipotong kecil-kecil), bawang goreng, bumbu          kacang (seperti bumbu rujak, pedas atau tidak, tergantung selera), dan kecap manis. Dan, umumnya kecap manis yang dipergunakan adalah kecap manis encer, bukan yang kental. Disiramkan ke atas semua bahan.', 'img1-lengko-cirebon.jpg', 'toor'),
('F002', 'Nasi Tutug Oncom', 'F', 7500, 'Nasi Tutug Oncom atau Sangu Tutug Oncom dalam Bahasa Sunda sering disingkat Nasi T.O adalah makanan yang dibuat dari nasi yang diaduk dengan oncom goreng atau bakar. Penyajian makanan ini umumnya dalam keadaan hangat. Secara bahasa, kata tutug dalam Bahasa Sunda artinya menumbuk. Proses aduk-tumbuk nasi dengan oncom ini menjadi nama jenis makanan yang dikenal dengan nama tutug oncom. Nasi tutug oncom menjadimakanan khas Tasikmalaya. Walaupun menjadi makanan khas, tutug oncom dapat dibawa menjadi oleh-oleh karena sekarang sudah tersedia tutug oncom instan yang telah dikemas dan mampu bertahan hingga berbulan-bulan tanpa menggunakan pengawet.', 'img4-nasi-tutug-oncom-tasikmalaya.jpg', 'toor'),
('F003', 'Rendang Padang', 'F', 13000, 'Rendang atau randang adalah masakan daging bercita rasa pedas yang menggunakan campuran dari berbagai bumbu dan rempah-rempah. Masakan ini dihasilkan dari proses memasak yang dipanaskan berulang-ulang dengan santan kelapa. Proses memasaknya memakan waktu berjam-jam (biasanya sekitar empat jam) hingga kering dan berwarna hitam pekat. Dalam suhu ruangan, rendang dapat bertahan hingga berminggu-minggu. Rendang yang dimasak dalam waktu yang lebih singkat dan santannya belum mengering disebut kalio, berwarna coklat terang keemasan.', 'img2-rendang-padang.jpg', 'toor'),
('F004', 'Gudeg Yogyakarta', 'F', 12000, 'Gudeg adalah makanan khas Yogyakarta dan Jawa Tengah yang terbuat dari nangka muda yang dimasak dengan santan. Perlu waktu berjam-jam untuk membuat masakan ini. Warna coklat biasanya dihasilkan oleh daun jati yang dimasak bersamaan. Gudeg dimakan dengan nasi dan disajikan dengan kuah santan kental (areh), ayam kampung, telur, tahu dan sambal goreng krecek.', 'img3-gudeg-yogyakarta.jpg', 'toor'),
('F005', 'Nasi Goreng', 'F', 12000, 'Nasi goreng adalah sebuah makanan berupa nasi yang digoreng dan diaduk dalam minyak goreng atau margarin, biasanya ditambah kecap manis, bawang merah, bawang putih, asam jawa, lada dan bumbu-bumbu lainnya, seperti telur, ayam, dan kerupuk.', 'img11-nasi-goreng.jpg', 'rakamp'),
('F006', 'Nasi Goreng Manis', 'F', 12000, '', '', 'rakamp'),
('F007', 'Magelangan', 'F', 12000, 'Nasi goreng yang dipadukan dengan mie yang kenyal. Bumbu cabai, kemiri, dan rempah-rempah membuat rasanya gurih. Makin enak disantap dengan kerupuk dan acar.', 'img12-magelangan.jpg', 'rakamp'),
('F008', 'Mi Goreng', 'F', 7500, 'Mi goreng berarti "mi yang digoreng" adalah makanan yang populer dan digemari di Indonesia, Malaysia, dan Singapura. Walau cara memasaknya pakai air juga, tetap disebut mi goreng.', 'img12-mie-goreng.jpg', 'rakamp'),
('F011', 'Ayam Betutu', 'F', 15000, 'Ayam', 'ayam-betutu.jpg', 'toor'),
('F012', 'Ayam Goreng Mentega', 'F', 20000, 'Ayam', 'ayam-betutu.jpg', 'toor');

-- --------------------------------------------------------

--
-- Table structure for table `menu_detil`
--

CREATE TABLE IF NOT EXISTS `menu_detil` (
`kode_menu_detil` int(10) unsigned NOT NULL,
  `jumlah_bahan_baku_detil` float NOT NULL,
  `kode_menu` varchar(15) NOT NULL,
  `kode_bahan_baku` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_detil`
--

INSERT INTO `menu_detil` (`kode_menu_detil`, `jumlah_bahan_baku_detil`, `kode_menu`, `kode_bahan_baku`) VALUES
(27, 1, 'F011', 1),
(28, 5, 'F011', 2);

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
('azmi', '$2y$10$EiB4S1rXnTd/BZL.J4eUJe1OdLJGbcCvGBmQSMnHwOZgp3Z8qe17y', 'Azmi Yudista', 'L', 'azmi-yudista.jpg', 'pantry'),
('binsar', '$2y$10$DGSqqJ9tPobQrTFy2pf0ju5kA6PpqfXRQthxJ83b1gyGJmBMPlvpC', 'Binsar Bernandus Silalahi', 'L', 'binsar-bernandus-silalahi.png', 'chef'),
('john', '$2y$10$jXDMU.zxmBoTQrfCYdGvVuON7VEv9laytzWiFCHleSqx0xj/BeO1G', 'John Cena', 'L', 'john-cena.png', 'waiter'),
('rakamp', '$2y$10$b63tb1MDRqWBD0ODRwsVduMaS0Zb5bBqL2cd4b6C1D0isqEM8j8Vy', 'Raka Muhamad Pratama', 'L', 'raka-muhamad-pratama.png', 'cs'),
('toor', '$2y$10$83An5pLgersDP.LxkdHMzeyImkugOfYOnaeuxWT8eHLMTDXLbqNw2', 'Raka Suryaardi Widjaja', 'L', 'raka-suryaardi-widjaja.jpg', 'root'),
('zaki', '$2y$10$rygQqVUgg9YEKpqEoOkY6e/TixLAhgC9/tgfv3EmO0Y0XXC/8YrEq', 'Muhammad Zaki', 'L', 'muhammad-zaki.png', 'cashier');

-- --------------------------------------------------------

--
-- Table structure for table `pemberitahuan`
--

CREATE TABLE IF NOT EXISTS `pemberitahuan` (
`kode_pemberitahuan` int(10) unsigned NOT NULL,
  `isi_pemberitahuan` text NOT NULL,
  `tanggal_pemberitahuan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kode_perangkat` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemberitahuan`
--

INSERT INTO `pemberitahuan` (`kode_pemberitahuan`, `isi_pemberitahuan`, `tanggal_pemberitahuan`, `kode_perangkat`) VALUES
(1, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:25:05', 'JB001'),
(2, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:25:33', 'JB001'),
(3, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:25:50', 'JB001'),
(4, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:27:22', 'JB001'),
(5, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:28:42', 'JB001'),
(6, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:08', 'JB001'),
(7, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:13', 'JB001'),
(8, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:15', 'JB001'),
(9, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:16', 'JB001'),
(10, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:24', 'JB001'),
(11, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:25', 'JB001'),
(12, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:27', 'JB001'),
(13, 'Jomblo 1 membutuhkan bantuan.', '2017-12-19 16:29:28', 'JB001'),
(14, 'Terdapat order baru di perangkat Jomblo 1.', '2017-12-19 16:31:16', 'JB001'),
(15, 'Terdapat order baru di perangkat Jomblo 1.', '2017-12-19 16:36:53', 'JB001'),
(16, 'Pesanan Ujang[Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 16:59:32', 'JB001'),
(17, 'Pesanan #1 [Ujang@Jomblo 1] selesai dibuat.', '2017-12-19 17:10:53', 'JB001'),
(18, 'Transaksi Ujang[Jomblo 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2017-12-19 17:12:16', 'JB001'),
(19, 'Terdapat order baru di perangkat Jomblo 1.', '2017-12-19 17:26:36', 'JB001'),
(20, 'Pesanan [Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 17:26:52', 'JB001'),
(21, 'Pesanan #2 [@Jomblo 1] selesai dibuat.', '2017-12-19 17:27:11', 'JB001'),
(22, 'Pesanan #2 [@Jomblo 1] selesai dibuat.', '2017-12-19 17:31:20', 'JB001'),
(23, 'Transaksi [Jomblo 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2017-12-19 17:31:29', 'JB001'),
(24, 'Terdapat order baru di perangkat Kamboja 2.', '2017-12-19 17:35:25', 'KJ002'),
(25, 'Pesanan Momon[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 17:35:32', 'KJ002'),
(26, 'Terdapat order baru di perangkat Kamboja 2.', '2017-12-19 19:30:48', 'KJ002'),
(27, 'Terdapat order baru di perangkat Kamboja 2.', '2017-12-19 19:32:10', 'KJ002'),
(28, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 19:32:20', 'KJ002'),
(29, 'Terdapat order baru di perangkat Jomblo 1.', '2017-12-19 19:49:34', 'JB001'),
(30, 'Pesanan Mbe[Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 19:49:53', 'JB001'),
(31, 'Pesanan #4 [Monica@Kamboja 2] selesai dibuat.', '2017-12-19 21:08:23', 'KJ002'),
(32, 'Terdapat order baru di perangkat Mawar 1.', '2017-12-19 21:10:17', 'MW001'),
(33, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:11:11', 'MW001'),
(34, 'Pesanan #5 (Ayam Betutu) [Mbe@Jomblo 1] selesai dibuat.', '2017-12-19 21:13:50', 'JB001'),
(35, 'Pesanan #5 [Mbe@Jomblo 1] selesai dibuat.', '2017-12-19 21:14:52', 'JB001'),
(36, 'Pesanan #6 (Bandrek) [@Mawar 1] selesai dibuat.', '2017-12-19 21:16:32', 'MW001'),
(37, 'Pesanan #6 (Ayam Betutu) [@Mawar 1] selesai dibuat.', '2017-12-19 21:17:00', 'MW001'),
(38, 'Pesanan #6 [@Mawar 1] selesai dibuat.', '2017-12-19 21:18:39', 'MW001'),
(39, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 21:20:22', 'KJ002'),
(40, 'Pesanan Mbe[Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:20:33', 'JB001'),
(41, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 21:21:59', 'KJ002'),
(42, 'Pesanan Mbe[Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:24:40', 'JB001'),
(43, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:24:47', 'MW001'),
(44, 'Pesanan Monica[Kamboja 2] sudah dikonfirmasi pelayan.', '2017-12-19 21:25:24', 'KJ002'),
(45, 'Pesanan Mbe[Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:25:45', 'JB001'),
(46, 'Pesanan [Mawar 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:25:52', 'MW001'),
(47, 'Pesanan #4 [Monica@Kamboja 2] selesai dibuat.', '2017-12-19 21:27:47', 'KJ002'),
(48, 'Pesanan #5 [Mbe@Jomblo 1] selesai dibuat.', '2017-12-19 21:28:31', 'JB001'),
(49, 'Pesanan #6 [@Mawar 1] selesai dibuat.', '2017-12-19 21:28:40', 'MW001'),
(50, 'Terdapat order baru di perangkat Jomblo 1.', '2017-12-19 21:52:33', 'JB001'),
(51, 'Pesanan [Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 21:59:10', 'JB001'),
(52, 'Pesanan #7 (Ayam Betutu) [@Jomblo 1] selesai dibuat.', '2017-12-19 21:59:37', 'JB001'),
(53, 'Pesanan #7 (Bandrek) [@Jomblo 1] selesai dibuat.', '2017-12-19 22:00:11', 'JB001'),
(54, 'Pesanan #7 [@Jomblo 1] selesai dibuat.', '2017-12-19 22:00:59', 'JB001'),
(55, 'Pesanan #7 [@Jomblo 1] selesai dibuat.', '2017-12-19 22:40:51', 'JB001'),
(56, 'Pesanan #7 [@Jomblo 1] selesai dibuat.', '2017-12-19 22:42:01', 'JB001'),
(57, 'Transaksi [Jomblo 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2017-12-19 22:42:13', 'JB001'),
(58, 'Pesanan [Jomblo 1] sudah dikonfirmasi pelayan.', '2017-12-19 22:48:32', 'JB001'),
(59, 'Pesanan #7 [@Jomblo 1] selesai dibuat.', '2017-12-19 22:48:45', 'JB001'),
(60, 'Transaksi [Jomblo 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2017-12-19 22:49:08', 'JB001'),
(61, 'Pesanan #7 [@Jomblo 1] selesai dibuat.', '2017-12-19 22:50:53', 'JB001'),
(62, 'Transaksi [Jomblo 1] selesai dilakukan, perangkat bisa digunakan kembali.', '2017-12-19 22:53:04', 'JB001'),
(63, 'Jomblo 1 membutuhkan bantuan.', '2017-12-22 14:46:16', 'JB001'),
(64, 'Jomblo 1 membutuhkan bantuan.', '2017-12-23 08:41:06', 'JB001'),
(65, 'Jomblo 1 membutuhkan bantuan.', '2018-01-01 16:30:14', 'JB001'),
(66, 'Jomblo 1 membutuhkan bantuan.', '2018-01-05 14:28:21', 'JB001'),
(67, 'Jomblo 1 membutuhkan bantuan.', '2018-01-05 14:28:30', 'JB001');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('JB001', '$2y$10$lPip/3jiBe88qS.HtGlEherclon3j.x/FVVmoH0dkMhtfSdTbXVg.', 'Jomblo 1', 1, 1),
('KJ002', '$2y$10$xBGIzJEO9XiqrVplq86Wv.lAyQreSDR8vm2HrlwzLK8O6JnpZSSj.', 'Kamboja 2', 1, 1),
('MW001', '$2y$10$UQ37G9RLcx8Ib7ld3S6oFOfphADDe24fiHY7eWdpeKn1HgYgX0DIu', 'Mawar 1', 2, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detil`
--

CREATE TABLE IF NOT EXISTS `pesanan_detil` (
`kode_pesanan_detil` int(10) unsigned NOT NULL,
  `jumlah_pesanan_detil` smallint(6) unsigned NOT NULL,
  `status_pesanan_detil` enum('P','D') NOT NULL DEFAULT 'P' COMMENT 'P = Process, D = Done',
  `kode_pesanan` int(10) unsigned NOT NULL,
  `kode_menu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
MODIFY `kode_bahan_baku` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `halaman_detil`
--
ALTER TABLE `halaman_detil`
MODIFY `kode_halaman_detil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `kuisioner`
--
ALTER TABLE `kuisioner`
MODIFY `kode_kuisioner` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `kuisioner_detil`
--
ALTER TABLE `kuisioner_detil`
MODIFY `kode_kuisioner_detil` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `kuisioner_perangkat`
--
ALTER TABLE `kuisioner_perangkat`
MODIFY `kode_kuisioner_perangkat` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `menu_detil`
--
ALTER TABLE `menu_detil`
MODIFY `kode_menu_detil` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `pemberitahuan`
--
ALTER TABLE `pemberitahuan`
MODIFY `kode_pemberitahuan` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `pengadaan_bahan_baku`
--
ALTER TABLE `pengadaan_bahan_baku`
MODIFY `kode_pengadaan_bahan_baku` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pengadaan_bahan_baku_detil`
--
ALTER TABLE `pengadaan_bahan_baku_detil`
MODIFY `kode_pengadaan_bahan_baku_detil` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
MODIFY `kode_pesanan` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pesanan_detil`
--
ALTER TABLE `pesanan_detil`
MODIFY `kode_pesanan_detil` int(10) unsigned NOT NULL AUTO_INCREMENT;
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
ADD CONSTRAINT `menu_detil_ibfk_5` FOREIGN KEY (`kode_menu`) REFERENCES `menu` (`kode_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `menu_detil_ibfk_6` FOREIGN KEY (`kode_bahan_baku`) REFERENCES `bahan_baku` (`kode_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE;

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
ADD CONSTRAINT `pesanan_detil_ibfk_4` FOREIGN KEY (`kode_menu`) REFERENCES `menu` (`kode_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pesanan_detil_ibfk_5` FOREIGN KEY (`kode_pesanan`) REFERENCES `pesanan` (`kode_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
