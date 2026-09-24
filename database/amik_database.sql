/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.20-12.3.3-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: amikprofil2
-- ------------------------------------------------------
-- Server version	12.3.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `module` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_created_at_action_index` (`created_at`,`action`),
  KEY `activity_logs_module_index` (`module`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES
(1,1,'irham','super_admin','LOGIN','Autentikasi','Test login audit trail','127.0.0.1','Symfony','2026-09-24 00:19:25','2026-09-24 00:19:25'),
(4,NULL,'Sistem / Tamu','guest','SECURITY','Hak Akses','Tes insiden keamanan','127.0.0.1','Symfony','2026-09-24 00:20:06','2026-09-24 00:20:06'),
(5,1,'irham','super_admin','LOGIN','Autentikasi','Pengguna irham (m.irhamauliaq@gmail.com) berhasil login ke sistem sebagai Super Admin','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:155.0) Gecko/20100101 Firefox/155.0','2026-09-24 00:21:17','2026-09-24 00:21:17'),
(6,1,'irham','super_admin','DELETE','Manajemen Pengguna','Menghapus akun: Test User 44269 (testuser44269@test.com) [Role: super_admin]','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:155.0) Gecko/20100101 Firefox/155.0','2026-09-24 00:21:37','2026-09-24 00:21:37'),
(7,1,'irham','super_admin','CREATE','Unit Test','Testing logger service','127.0.0.1','Symfony','2026-09-24 00:23:41','2026-09-24 00:23:41'),
(8,1,'irham','super_admin','LOGIN','Autentikasi','Pengguna irham (m.irhamauliaq@gmail.com) berhasil login ke sistem sebagai Super Admin','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:155.0) Gecko/20100101 Firefox/155.0','2026-09-24 05:01:14','2026-09-24 05:01:14'),
(9,1,'irham','super_admin','CREATE','Unit Test','Testing logger service','127.0.0.1','Symfony','2026-09-24 05:19:40','2026-09-24 05:19:40');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `akreditasis`
--

DROP TABLE IF EXISTS `akreditasis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `akreditasis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `tahun` varchar(255) NOT NULL,
  `peringkat` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akreditasis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `akreditasis` WRITE;
/*!40000 ALTER TABLE `akreditasis` DISABLE KEYS */;
INSERT INTO `akreditasis` VALUES
(1,'Akreditasi Kampus','2021','Baik','2021 - 2026','1779268797_WhatsApp Image 2026-05-12 at 07.00.25.jpeg',1,'2026-05-19 22:26:07','2026-05-20 02:19:57');
/*!40000 ALTER TABLE `akreditasis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `alumni_sections`
--

DROP TABLE IF EXISTS `alumni_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumni_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('tracer_study','dana_abadi') NOT NULL,
  `layout` enum('left_image','right_image') NOT NULL DEFAULT 'left_image',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumni_sections`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `alumni_sections` WRITE;
/*!40000 ALTER TABLE `alumni_sections` DISABLE KEYS */;
INSERT INTO `alumni_sections` VALUES
(1,'Tracer study','Tracer Study AMIK Taruna Probolinggo merupakan program pelacakan alumni yang bertujuan untuk mengetahui perkembangan karir lulusan setelah menyelesaikan pendidikan. Melalui tracer study, kampus dapat memperoleh informasi mengenai pekerjaan alumni, kesesuaian bidang kerja dengan kompetensi yang dipelajari, serta masukan untuk meningkatkan kualitas pendidikan dan kurikulum agar lebih relevan dengan kebutuhan dunia kerja dan industri digital saat ini.','1779304106_WhatsApp Image 2026-05-12 at 07.00.25.jpeg','tracer_study','left_image',1,'2026-05-17 18:39:33','2026-05-20 23:20:39','https://tracerstudy.kemdiktisaintek.go.id/'),
(2,'Dana Abadi','Dana Abadi Alumni AMIK Taruna Probolinggo merupakan program kontribusi dan kepedulian alumni terhadap kemajuan kampus. Program ini bertujuan mendukung pengembangan fasilitas pendidikan, pemberian beasiswa bagi mahasiswa berprestasi maupun kurang mampu, serta membantu berbagai kegiatan akademik dan pengembangan sumber daya di lingkungan kampus. Dana abadi menjadi bentuk sinergi berkelanjutan antara alumni dan institusi untuk menciptakan masa depan pendidikan yang lebih baik.','1779304083_WhatsApp Image 2026-05-12 at 07.04.36.jpeg','dana_abadi','right_image',1,'2026-05-17 18:44:03','2026-06-03 16:05:29','https://tracerstudy.kemdiktisaintek.go.id/');
/*!40000 ALTER TABLE `alumni_sections` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `berita_pmbs`
--

DROP TABLE IF EXISTS `berita_pmbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita_pmbs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `editor` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `isi` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `publish_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_pmbs_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita_pmbs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `berita_pmbs` WRITE;
/*!40000 ALTER TABLE `berita_pmbs` DISABLE KEYS */;
INSERT INTO `berita_pmbs` VALUES
(2,'PMB AMIK Taruna 2026/2027','pmb-amik-taruna-20262027','Fiqri_Rg','Fiqri_Rg','Pengumuman','\"Banyak Pilihan Sampai Bingung?\" PMB AMIK Taruna\r\n\r\nKatanya setelah lulus SMA itu gampang...\r\n\r\nTernyata yang bikin pusing bukan ujiannya. 😭\r\n\r\nTapi...\r\n\r\n📌 Mau kuliah di mana?\r\n📌 Jurusan apa?\r\n📌 Kampus yang bagus yang mana?\r\n📌 Yang dekat apa yang jauh?\r\n📌 Yang murah apa yang mahal?\r\n\r\nBelum daftar aja...\r\nkepalanya udah rapat koordinasi sendiri. 🫠\r\n\r\nTerus mulai buka internet...\r\n\r\n📱 Kampus A bagus\r\n📱 Kampus B keren\r\n📱 Kampus C menarik\r\n📱 Kampus D menjanjikan\r\n\r\nMakin dicari...\r\nmakin bingung. 😭😂\r\n\r\nTenangggg!!!!!\r\n\r\nJangan sampai overthinking\r\nkarena terlalu banyak pilihan.\r\n\r\nKadang yang dibutuhkan bukan pilihan yang banyak...\r\n\r\nTapi pilihan yang tepat. 😎✨\r\n\r\n🎓 Mau belajar IT?\r\n💻 Mau punya skill yang dibutuhkan dunia kerja?\r\n🚀 Mau kuliah dengan biaya bersahabat?\r\n🌱 Mau berkembang di kampus yang nyaman?\r\n\r\nYaudah...\r\n\r\n👉 AMIK Taruna aja.\r\n\r\nBiar nggak pusing milih terus,\r\nyang penting mulai dulu langkah menuju masa depan. 🔥\r\n\r\n📢 Pendaftaran Mahasiswa Baru AMIK Taruna Probolinggo Masih Dibuka!\r\n\r\n🗓️ Jadwal Pendaftaran:\r\n🔹 Gelombang 1: 2 Januari – 8 Juni 2026\r\n🔹 Gelombang 2: 10 Juli – 24 Juli 2026\r\n🔹 Gelombang 3: 27 Juli – 26 Agustus 2026\r\n\r\n📲 Ayo segera daftar sekarang juga!\r\n\r\n💻 Daftar Online:\r\n👉 https://s.id/PMBAmikTaruna\r\n\r\n📍 Daftar Offline:\r\nAMIK Taruna Probolinggo\r\nJl. Raya Leces No. A3, Kec. Leces, Kab. Probolinggo\r\n\r\n📞 Contact Person PMB:\r\n📲 0852 5871 5040 (Dwi Yanto, M.Kom.)\r\n📲 0823 3706 9660 (Ninanesia R., SE, M.ST.)\r\n📲 0853 3161 0757 (Heri Susanto, SE, M.Kom.)\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa.\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna melalui media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: amiktaruna.ac.id\r\n\r\n✨ Banyak pilihan itu bagus, tapi memilih yang tepat itu lebih penting. Yuk kuliah di AMIK Taruna! 🎓🚀\r\n\r\n#PMB2026\r\n#AMIKTarunaProbolinggo\r\n#BanyakPilihanSampaiBingung\r\n#OverthinkingKuliah\r\n#KuliahIT\r\n#AnakSMA\r\n#RecehKampus\r\n#KuliahDuluAja\r\n#GreenCampusGreatFuture\r\n#ATProduction\r\n#BerkaryaUntukMasyarakat\r\n#MengabdiUntukNegeri\r\n#MemberiManfaatUntukBangsa\r\n#KuliahKekinian\r\n#MasaDepanDimulaiHariIni 😆🎓🚀💚',NULL,NULL,'1787447131_Brosur AMIK 2026.pdf','2026-08-23 10:00:00','2026-08-23 08:05:31','2026-08-23 08:05:31');
/*!40000 ALTER TABLE `berita_pmbs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `beritas`
--

DROP TABLE IF EXISTS `beritas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `beritas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `editor` varchar(255) DEFAULT NULL,
  `publish_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori` varchar(100) DEFAULT 'pengumuman',
  PRIMARY KEY (`id`),
  UNIQUE KEY `beritas_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beritas`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `beritas` WRITE;
/*!40000 ALTER TABLE `beritas` DISABLE KEYS */;
INSERT INTO `beritas` VALUES
(21,'Rapat Dosen: Persiapan Perkuliahan Semester Ganjil 2026/2027','Fiqri_Rg','Fiqri_Rg','2026-08-23 08:40:00','rapat-dosen-persiapan-perkuliahan-semester-ganjil-20262027','📸📚 Rapat Dosen: Persiapan Perkuliahan Semester Ganjil 2026/2027 📚📸\r\n\r\nAMIK Taruna melaksanakan Rapat Koordinasi Persiapan Perkuliahan Semester Ganjil Tahun Akademik 2026/2027 sebagai bagian dari persiapan penyelenggaraan kegiatan akademik di semester yang baru. 💚\r\n\r\nKegiatan yang dilaksanakan pada Jumat, 21 Agustus 2026 ini menjadi momentum untuk menyatukan koordinasi dan memastikan kesiapan pelaksanaan perkuliahan agar dapat berjalan dengan baik, tertib, dan optimal. 🤝📚\r\n\r\nDalam rapat tersebut dibahas beberapa agenda penting, di antaranya:\r\n\r\n📌 Sosialisasi Perkuliahan Ganjil 2026/2027\r\nMenyampaikan berbagai hal terkait pelaksanaan perkuliahan pada semester ganjil kepada para dosen.\r\n\r\n📌 Penyusunan RPS Berbasis CPL (OBE)\r\nPersiapan penyusunan Rencana Pembelajaran Semester (RPS) yang mengacu pada Capaian Pembelajaran Lulusan (CPL) dengan pendekatan Outcome-Based Education (OBE).\r\n\r\nMelalui koordinasi ini, AMIK Taruna terus berkomitmen mempersiapkan proses pembelajaran yang terarah, berkualitas, dan selaras dengan kebutuhan akademik serta capaian pembelajaran. 🎓✨\r\n\r\nSemoga seluruh persiapan dapat berjalan lancar dan Semester Ganjil 2026/2027 dapat terlaksana dengan penuh semangat, kolaborasi, dan memberikan pengalaman pembelajaran terbaik bagi seluruh mahasiswa. 💚📖\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa.\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna melalui media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo\r\n#GreenCampusGreatFuture\r\n#RapatDosen\r\n#PersiapanPerkuliahan\r\n#SemesterGanjil2026\r\n#TahunAkademik20262027\r\n#OBE\r\n#CPL\r\n#RPS\r\n#PendidikanBerkualitas\r\n#DiktiSaintekBerdampak\r\n#BerkaryaUntukMasyarakat\r\n#MengabdiUntukNegeri\r\n#MemberiManfaatUntukBangsa\r\n#ATProduction','1787446865_WhatsApp Image 2026-08-22 at 20.29.15.jpeg',NULL,NULL,'2026-08-23 08:01:05','2026-08-23 08:38:55','kegiatan_kampus'),
(22,'Selamat Memperingati Maulid Nabi Muhammad SAW','Fiqri_Rg','Fiqri_Rg','2026-08-25 07:00:00','selamat-memperingati-maulid-nabi-muhammad-saw','🌙✨ Selamat Memperingati Maulid Nabi Muhammad SAW ✨🌙\r\n\r\n12 Rabiul Awal 1448 H menjadi momentum untuk kembali mengenang kelahiran dan keteladanan Nabi Muhammad SAW. 🤍\r\n\r\nMari jadikan peringatan Maulid Nabi sebagai pengingat untuk meneladani akhlak Rasulullah SAW dalam kehidupan sehari-hari—dengan memperkuat keimanan, memperbanyak kebaikan, menjaga persaudaraan, serta senantiasa memberikan manfaat bagi sesama. 🕌📖✨\r\n\r\nSemoga kita senantiasa mendapatkan syafaat Rasulullah SAW dan mampu menjadikan akhlak beliau sebagai inspirasi dalam setiap langkah kehidupan.\r\n\r\nاللهم صل وسلم وبارك على سيدنا محمد وعلى آله وصحبه أجمعين 🤲✨\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa.\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna melalui media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo\r\n#GreenCampusGreatFuture\r\n#MaulidNabi\r\n#MaulidNabiMuhammadSAW\r\n#12RabiulAwal1448H\r\n#NabiMuhammadSAW\r\n#TeladanRasulullah\r\n#BerkaryaUntukMasyarakat\r\n#MengabdiUntukNegeri\r\n#MemberiManfaatUntukBangsa\r\n#DiktiSaintekBerdampak\r\n#ATProduction','1787615600_WhatsApp Image 2026-08-24 at 22.46.53.jpeg',NULL,NULL,'2026-08-25 06:53:20','2026-08-25 06:53:20','kegiatan_kampus'),
(23,'🎓✨ Pengantaran Mahasiswa Magang AMIK Taruna di Instansi Pemerintah Kabupaten Probolinggo ✨🎓','Fiqri_Rg',NULL,'2026-09-09 08:00:00','pengantaran-mahasiswa-magang-amik-taruna-di-instansi-pemerintah-kabupaten-probolinggo','🎓✨ Pengantaran Mahasiswa Magang AMIK Taruna di Instansi Pemerintah Kabupaten Probolinggo ✨🎓\r\n\r\nSebagai bagian dari proses pembelajaran dan pengembangan pengalaman mahasiswa di dunia kerja, AMIK Taruna melaksanakan kegiatan pengantaran mahasiswa magang ke beberapa instansi di lingkungan Pemerintah Kabupaten Probolinggo. 🤝💼\r\n\r\nKegiatan magang menjadi kesempatan bagi mahasiswa untuk mengaplikasikan ilmu yang telah diperoleh selama perkuliahan secara langsung di lingkungan kerja. Tidak hanya menambah pengalaman, magang juga menjadi ruang bagi mahasiswa untuk belajar mengenai kedisiplinan, tanggung jawab, komunikasi, serta profesionalisme. 💻📚✨\r\n\r\nDalam kegiatan ini, mahasiswa AMIK Taruna ditempatkan pada beberapa bagian, yaitu Sekretariat Dewan, Sekretariat Daerah Bagian Protokoler, dan Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Probolinggo. 🏢🚀\r\n\r\nMelalui pengalaman tersebut, mahasiswa diharapkan dapat mengenal lebih dekat bagaimana teknologi informasi dan administrasi diterapkan dalam mendukung pelayanan serta kegiatan pemerintahan. Pengalaman langsung di lapangan tentunya menjadi bekal berharga bagi mahasiswa untuk menghadapi dunia kerja setelah menyelesaikan pendidikan. 🌱💻\r\n\r\nAMIK Taruna terus berkomitmen untuk menghadirkan pembelajaran yang tidak hanya berorientasi pada teori, tetapi juga memberikan kesempatan kepada mahasiswa untuk belajar, beradaptasi, berkarya, dan mengembangkan kompetensi di dunia nyata. 💚✨\r\n\r\nSemoga seluruh mahasiswa yang melaksanakan magang dapat menjalankan tugas dengan penuh tanggung jawab, menjaga nama baik almamater, serta mendapatkan pengalaman dan ilmu baru yang bermanfaat untuk masa depan. Semangat menjalani prosesnya! 💪🎓\r\n\r\n🤝 Terima kasih kepada seluruh instansi Pemerintah Kabupaten Probolinggo yang telah menerima dan memberikan ruang belajar bagi mahasiswa AMIK Taruna. Semoga kerja sama dan sinergi dalam mendukung pengembangan generasi muda terus terjalin dengan baik. 💚\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa. ✨🌱\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna di media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: www.amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #MahasiswaMagang #MagangMahasiswa #PengantaranMagang #KabupatenProbolinggo #SekretariatDewan #SekretariatDaerah #Diskominfo #DuniaKerja #PendidikanTinggi #PengalamanKerja #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction',NULL,NULL,NULL,'2026-09-08 19:56:57','2026-09-08 19:56:57','kegiatan_kampus'),
(24,'📚✨ AMIK Taruna Tetapkan Pedoman Etika dan Tata Perilaku Civitas Akademika ✨📚','Fiqri_Rg','Fiqri_Rg','2026-09-17 08:17:42','amik-taruna-tetapkan-pedoman-etika-dan-tata-perilaku-civitas-akademika','📚✨ AMIK Taruna Tetapkan Pedoman Etika dan Tata Perilaku Civitas Akademika ✨📚\r\n\r\nSebagai bagian dari upaya membangun budaya akademik yang sehat, profesional, berintegritas, dan bertanggung jawab, AMIK Taruna memiliki Pedoman Etika dan Tata Perilaku Civitas Akademika Tahun 2026. 💚\r\nPedoman ini menjadi acuan bagi seluruh civitas akademika dalam menjalankan peran, tanggung jawab, serta berinteraksi di lingkungan kampus maupun di luar kampus.\r\n\r\nPedoman Etika dan Tata Perilaku ini mencakup berbagai aspek penting, di antaranya:\r\n📌 Integritas dan Profesionalisme\r\nSeluruh civitas akademika diharapkan menjunjung tinggi kejujuran, konsistensi antara ucapan dan tindakan, profesionalisme, kedisiplinan, serta tanggung jawab dalam melaksanakan tugas dan kewajibannya.\r\n\r\n📌 Etika Akademik\r\nPedoman mengatur etika dalam pelaksanaan tridharma perguruan tinggi, meliputi pendidikan, penelitian, dan pengabdian kepada masyarakat.\r\nDosen dan tenaga pendidik dituntut menjaga kejujuran akademik, menghindari plagiarisme dan manipulasi data, serta memberikan penilaian secara objektif dan transparan.\r\n\r\nSementara itu, mahasiswa diharapkan menjunjung tinggi kejujuran dalam tugas, ujian, laporan, dan karya ilmiah serta menjaga nama baik institusi di dalam maupun di luar lingkungan kampus. 🎓📖\r\n\r\n📌 Etika dalam Hubungan Sosial dan Organisasi\r\nPedoman juga menekankan pentingnya sikap saling menghormati, empati, komunikasi yang baik, serta penyelesaian perbedaan melalui musyawarah dan dialog.\r\nAMIK Taruna juga berkomitmen menciptakan lingkungan kampus yang aman, inklusif, dan bebas dari diskriminasi, kekerasan, maupun pelecehan.\r\n\r\n📌 Etika Penggunaan Fasilitas dan Sumber Daya Kampus\r\nSeluruh fasilitas dan sumber daya kampus harus digunakan secara bertanggung jawab, efisien, sesuai peruntukan, serta dijaga keamanan, kebersihan, dan kelayakannya.\r\nPenggunaan fasilitas teknologi informasi, jaringan internet, maupun sumber daya keuangan juga harus dilakukan secara aman, transparan, akuntabel, dan sesuai dengan ketentuan institusi.\r\n\r\n📌 Etika Digital dan Media Sosial 💻📱\r\nDi era digital, civitas akademika diharapkan menggunakan teknologi dan media sosial secara etis, bertanggung jawab, dan sesuai dengan hukum yang berlaku.\r\nInformasi yang disampaikan harus jujur dan santun, serta menghindari penyebaran hoaks, ujaran kebencian, konten diskriminatif, cyberbullying, doxing, maupun konten yang dapat merugikan orang lain dan institusi.\r\n\r\nPenggunaan identitas atau atribut AMIK Taruna dalam ruang digital juga harus tetap mencerminkan nilai profesionalisme, integritas, dan etika akademik.\r\n\r\n📌 Penegakan Etika\r\nUntuk memastikan penerapan pedoman berjalan secara konsisten, AMIK Taruna menetapkan mekanisme penegakan etika melalui Komite Etik, pelaporan pelanggaran, proses klarifikasi dan pemeriksaan, rekomendasi sanksi, hingga mekanisme banding.\r\nSelain itu, sosialisasi, pelatihan, dan edukasi etika juga menjadi bagian penting dalam membangun pemahaman seluruh civitas akademika terhadap nilai-nilai yang telah ditetapkan. 🤝📚\r\n\r\nMelalui Pedoman Etika dan Tata Perilaku Civitas Akademika ini, AMIK Taruna berkomitmen membangun lingkungan pendidikan yang inklusif, etis, kolaboratif, profesional, dan berintegritas.\r\n\r\nKarena pendidikan bukan hanya tentang membentuk lulusan yang kompeten secara teknis, tetapi juga membangun karakter yang kuat, bertanggung jawab, dan memiliki nilai moral. 🎓✨\r\nMari bersama-sama memahami, menghormati, dan menerapkan nilai-nilai etika untuk mewujudkan budaya akademik yang lebih baik di lingkungan AMIK Taruna. 💚\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa.\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna melalui media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo\r\n#GreenCampusGreatFuture\r\n#EtikaAkademik\r\n#PedomanEtika\r\n#CivitasAkademika\r\n#Integritas\r\n#Profesionalisme\r\n#BudayaAkademik\r\n#EtikaDigital\r\n#PendidikanBerkualitas\r\n#DiktiSaintekBerdampak\r\n#BerkaryaUntukMasyarakat\r\n#MengabdiUntukNegeri\r\n#MemberiManfaatUntukBangsa\r\n#ATProduction',NULL,'1789607862_Pedoman Etika dan Tata Perilaku Civitas Akademika.pdf',NULL,'2026-09-17 08:17:42','2026-09-17 08:17:42','pengumuman'),
(25,'🎓✨ PRA-PKKMB AMIK TARUNA 2026 ✨🎓','Fiqri_Rg','Fiqri_Rg','2026-09-17 08:33:54','pra-pkkmb-amik-taruna-2026','🎓✨ PRA-PKKMB AMIK TARUNA 2026 ✨🎓\r\n\r\nSelamat datang, calon bagian dari keluarga besar AMIK Taruna! 💚🤍\r\n\r\nMenjelang pelaksanaan Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) AMIK Taruna Tahun Akademik 2026–2027, telah dilaksanakan kegiatan PRA-PKKMB AMIK Taruna 2026 sebagai langkah awal bagi mahasiswa baru untuk mengenal lebih dekat lingkungan kampus, budaya akademik, serta kehidupan sebagai mahasiswa. 🎓📚\r\n\r\nPRA-PKKMB menjadi kesempatan bagi mahasiswa baru untuk mulai beradaptasi dengan suasana perkuliahan, mengenal lingkungan kampus, serta membangun komunikasi dan kebersamaan dengan teman-teman baru. 🤝✨\r\n\r\nMemasuki dunia perguruan tinggi tentu menjadi pengalaman baru. Dari yang sebelumnya memakai seragam sekolah, kini mulai mengenakan identitas sebagai mahasiswa. Ada banyak hal baru yang akan ditemui, mulai dari kegiatan akademik, organisasi, kerja sama tim, hingga berbagai pengalaman yang akan menjadi bagian dari perjalanan selama berkuliah di AMIK Taruna. 💻🚀\r\n\r\nMelalui kegiatan ini, diharapkan mahasiswa baru dapat mempersiapkan diri dengan baik, membangun rasa percaya diri, serta memiliki semangat untuk belajar dan berkembang bersama. Karena perjalanan menjadi mahasiswa bukan hanya tentang mendapatkan ilmu, tetapi juga tentang membangun karakter, mengembangkan potensi, memperluas pengalaman, dan menciptakan karya. 🌱✨\r\n\r\n📣 Selamat datang mahasiswa baru AMIK Taruna Tahun Akademik 2026–2027!\r\n\r\nMari bersiap untuk memulai perjalanan baru, bertemu dengan lingkungan baru, mendapatkan pengalaman baru, dan tentunya menciptakan cerita-cerita baru selama menjadi bagian dari keluarga besar AMIK Taruna. 🎓💚\r\n\r\nKampus baru, teman baru, pengalaman baru, dan cerita baru dimulai dari sini! 🔥✨\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa. ✨🌱\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna di media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: www.amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #PraPKKMB #PKKMBAMIKTaruna #PKKMB2026 #MahasiswaBaru #MahasiswaBaru2026 #TahunAkademik20262027 #KampusBaru #PendidikanTinggi #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction',NULL,NULL,NULL,'2026-09-17 08:33:54','2026-09-17 08:33:54','kegiatan_kampus'),
(26,'🎓✨ PKKMB AMIK TARUNA 2026 – HARI PERTAMA ✨🎓 📚 Mengenal Kampus, Membangun Karakter, dan Memulai Perjalanan Baru','Fiqri_Rg',NULL,'2026-09-19 08:41:44','pkkmb-amik-taruna-2026-hari-pertama-mengenal-kampus-membangun-karakter-dan-memulai-perjalanan-baru','🎓✨ PKKMB AMIK TARUNA 2026 – HARI PERTAMA ✨🎓\r\n📚 Mengenal Kampus, Membangun Karakter, dan Memulai Perjalanan Baru\r\n\r\nHari pertama Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) AMIK Taruna Tahun Akademik 2026–2027 berlangsung dengan penuh semangat dan antusiasme dari para mahasiswa baru. 🎓💚\r\n\r\nKegiatan diawali dengan persiapan dan pembukaan, kemudian dilanjutkan dengan berbagai materi pengenalan yang membantu mahasiswa baru memahami lebih dekat tentang lingkungan dan kehidupan akademik di AMIK Taruna. 🌟📚\r\n\r\nPada sesi Pengenalan Kampus, mahasiswa baru mendapatkan informasi mengenai sejarah singkat, visi dan misi, serta struktur organisasi AMIK Taruna. Materi ini menjadi langkah awal agar mahasiswa memahami identitas, arah, serta tata kelola kampus yang akan menjadi bagian dari perjalanan pendidikan mereka. 🏫✨\r\n\r\nSelanjutnya, mahasiswa mendapatkan pembekalan mengenai Etika dan Budaya Akademik, mulai dari nilai-nilai dasar kehidupan kampus seperti integritas, kejujuran, dan tanggung jawab, hingga cara berinteraksi dengan dosen dan staf, tata cara berpakaian di lingkungan kampus, serta larangan plagiarisme dan sanksinya. 🤝📖\r\n\r\nTidak kalah penting, mahasiswa baru juga mengikuti materi Pengembangan Karakter Mahasiswa yang membahas soft skill dan hard skill, pentingnya keterampilan komunikasi, kepemimpinan, kerja sama tim, serta peran organisasi kemahasiswaan dalam pengembangan diri. 💪🗣️🚀\r\n\r\nKemudian, mahasiswa diperkenalkan dengan Sistem Akademik dan Administrasi, meliputi kalender akademik, sistem SKS dan KRS, tata cara pendaftaran mata kuliah, hingga pengenalan Sistem Informasi Akademik (SIAKAD) sebagai bagian dari aktivitas akademik mahasiswa. 💻📋\r\n\r\nDengan rangkaian materi pada hari pertama ini, diharapkan mahasiswa baru semakin memahami kehidupan kampus, mengetahui hak dan kewajibannya sebagai mahasiswa, serta mampu mempersiapkan diri untuk menjalani proses perkuliahan dengan penuh tanggung jawab. 🌱✨\r\n\r\nHari pertama bukan sekadar kegiatan pengenalan, tetapi menjadi langkah awal untuk membangun karakter, menambah wawasan, dan mempersiapkan mahasiswa AMIK Taruna menjadi pribadi yang aktif, kompeten, dan berintegritas. 💚🎓\r\n\r\n🔥 Selamat mengikuti PKKMB AMIK Taruna 2026!\r\nMari mulai perjalanan baru ini dengan semangat, kebersamaan, dan tekad untuk terus berkembang. 🚀📚\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa. ✨🌱\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna di media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: www.amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #PKKMBAMIKTaruna #PKKMB2026 #PKKMBHariPertama #MahasiswaBaru #MahasiswaBaru2026 #TahunAkademik20262027 #PengenalanKampus #EtikaAkademik #BudayaAkademik #PengembanganKarakter #SIAKAD #KehidupanKampus #PendidikanTinggi #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction','1789782104_DSC00926 (1).jpg',NULL,NULL,'2026-09-19 08:41:44','2026-09-19 08:41:44','kegiatan_kampus'),
(27,'🎓✨ PKKMB AMIK TARUNA 2026 – HARI KEDUA ✨🎓 📚 Menumbuhkan Wawasan Kebangsaan, Karakter, dan Semangat Berprestasi','Fiqri_Rg','Fiqri_Rg','2026-09-19 08:43:36','pkkmb-amik-taruna-2026-hari-kedua-menumbuhkan-wawasan-kebangsaan-karakter-dan-semangat-berprestasi','🎓✨ PKKMB AMIK TARUNA 2026 – HARI KEDUA ✨🎓\r\n📚 Menumbuhkan Wawasan Kebangsaan, Karakter, dan Semangat Berprestasi\r\n\r\nMemasuki hari kedua Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) AMIK Taruna Tahun Akademik 2026–2027, para mahasiswa baru kembali mengikuti rangkaian kegiatan pembekalan dengan penuh semangat dan antusiasme. 💚🎓\r\n\r\nKegiatan diawali dengan review materi Hari Pertama bersama BEM sebagai pengingat sekaligus penguatan kembali berbagai informasi yang telah diterima sebelumnya. Setelah itu, mahasiswa mendapatkan materi Wawasan Kebangsaan dan Bela Negara yang membahas Pancasila dan UUD 1945, peran mahasiswa dalam menjaga keutuhan NKRI, serta toleransi dalam keberagaman. 🇮🇩✨\r\n\r\nSelanjutnya, mahasiswa baru mendapatkan pembekalan mengenai karakter generasi bebas minuman keras dan narkoba bersama Kapolsek. Materi ini menjadi bagian penting dalam membangun kesadaran mahasiswa untuk menjaga diri, menjauhi perilaku yang dapat merugikan masa depan, serta membentuk generasi muda yang bertanggung jawab. 🚫🍺🚭\r\n\r\nSetelah waktu istirahat dan ishoma, kegiatan dilanjutkan dengan materi Profil dan Capaian Lulusan AMIK Taruna yang memberikan gambaran kepada mahasiswa mengenai profil lulusan serta arah pengembangan kompetensi selama menjalani pendidikan di kampus. 💻📚\r\n\r\nTidak kalah menarik, mahasiswa juga mendapatkan materi Karakter Generasi Kreatif dan Inovatif. Di era perkembangan teknologi yang terus bergerak, mahasiswa ditantang untuk tidak hanya memiliki kemampuan akademik, tetapi juga mampu mengembangkan kreativitas, inovasi, serta menghasilkan ide dan karya yang bermanfaat. 💡🚀\r\n\r\nRangkaian kegiatan hari kedua kemudian ditutup dengan persiapan menuju Hari Ketiga PKKMB. 📋✨\r\n\r\nMelalui berbagai materi yang diberikan, PKKMB AMIK Taruna tidak hanya menjadi ajang untuk mengenal lingkungan kampus, tetapi juga menjadi ruang pembekalan bagi mahasiswa baru untuk membangun wawasan kebangsaan, karakter positif, kreativitas, tanggung jawab, serta semangat untuk terus berkembang. 🌱🤝\r\n\r\n🔥 Perjalanan masih berlanjut!\r\nHari demi hari, semakin banyak pengalaman dan wawasan yang didapat. Mari terus ikuti rangkaian PKKMB AMIK Taruna 2026 dengan semangat, antusiasme, dan energi positif! 🎓💚\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa. ✨🌱\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna di media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: www.amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #PKKMBAMIKTaruna #PKKMB2026 #PKKMBHariKedua #MahasiswaBaru #MahasiswaBaru2026 #TahunAkademik20262027 #WawasanKebangsaan #BelaNegara #Pancasila #NKRI #Toleransi #GenerasiKreatif #GenerasiInovatif #KarakterMahasiswa #PendidikanTinggi #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction','1789782216_DSC01160 (1).jpg',NULL,NULL,'2026-09-19 08:43:36','2026-09-19 08:43:36','kegiatan_kampus'),
(28,'“Done Deal! Perpindahan Tugas, Wajah Baru di Tim Humas AMIK Taruna” 🔄🔥','Fiqri_Rg','Fiqri_Rg','2026-09-21 08:30:00','done-deal-perpindahan-tugas-wajah-baru-di-tim-humas-amik-taruna','“Done Deal! Perpindahan Tugas, Wajah Baru di Tim Humas AMIK Taruna” 🔄🔥\r\n\r\nAda yang pindah tugas nih! 👀✨\r\n\r\nBukan pindah kampus,\r\nbukan juga pindah tongkrongan… 😂\r\n\r\nTapi kali ini ada perpindahan tugas di lingkungan AMIK Taruna! 🎓💚\r\n\r\nSebelumnya bertugas sebagai bagian dari\r\nStaf Alumni & Pusat Karir,\r\n\r\nkini Fiqri Romadhonal G, S.Kom. resmi melanjutkan peran sebagai:\r\n📢 Staf Humas, Publikasi & Website AMIK Taruna 💻✨\r\n\r\nPerpindahan tugas ini tentunya menjadi bagian dari dinamika dan pengembangan tim di lingkungan kampus. 🤝\r\n\r\nDengan peran barunya, semoga semakin banyak informasi, kegiatan, dan cerita menarik seputar AMIK Taruna yang bisa dibagikan kepada mahasiswa, alumni, dan masyarakat! 📸📱🔥\r\n\r\nSelamat menjalankan tugas di posisi baru! 👏\r\nSemangat, amanah, dan semakin kreatif! 🚀\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa.\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna melalui media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #AMIKTaruna #DoneDeal #PerpindahanTugas #StafHumas #HumasAMIKTaruna #Publikasi #WebsiteAMIKTaruna #AlumniDanPusatKarir #FiqriRomadhonal #KeluargaAMIKTaruna #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction','1789783387_WhatsApp Image 2026-09-19 at 08.37.34.jpeg',NULL,NULL,'2026-09-19 09:03:07','2026-09-19 09:25:26','pengumuman'),
(29,'“Done Deal! Perpindahan Tugas, Langkah Baru Muhammad Izha di AMIK Taruna” 🔄🔥','Fiqri_Rg','Fiqri_Rg','2026-09-21 08:30:00','done-deal-perpindahan-tugas-langkah-baru-muhammad-izha-di-amik-taruna','“Done Deal! Perpindahan Tugas, Langkah Baru Muhammad Izha di AMIK Taruna” 🔄🔥\r\n\r\nAda yang naik level nih! 👀✨\r\n\r\nBukan pindah kampus,\r\nbukan juga pindah tongkrongan… 😂\r\n\r\nTapi kali ini ada perpindahan tugas di lingkungan AMIK Taruna! 🎓💚\r\n\r\nSebelumnya berstatus sebagai Free Agent AMIK Taruna, kini Muhammad Izha M, A.Md.Kom. resmi melanjutkan langkah sebagai:\r\n\r\n🎓 Staf Alumni & Pusat Karir AMIK Taruna 💼✨\r\n\r\nPerpindahan tugas ini menjadi bagian dari dinamika dan pengembangan tim di lingkungan kampus. 🤝\r\n\r\nDengan peran barunya, semoga Muhammad Izha dapat memberikan kontribusi terbaik dalam mendukung alumni, pengembangan karier, serta berbagai program yang berkaitan dengan dunia kerja dan profesional. 🚀💼\r\n\r\nSelamat menjalankan tugas dan amanah di posisi baru! 👏🔥\r\nSemangat berkarya, terus berkembang, dan berikan yang terbaik untuk AMIK Taruna! 💚\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa.\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna melalui media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #AMIKTaruna #DoneDeal #PerpindahanTugas #MuhammadIzha #StafAlumni #PusatKarir #AlumniAMIKTaruna #PusatKarirAMIKTaruna #KeluargaAMIKTaruna #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction','1789783447_WhatsApp Image 2026-09-19 at 08.41.49.jpeg',NULL,NULL,'2026-09-19 09:04:07','2026-09-19 09:25:38','pengumuman'),
(30,'🎓✨ PKKMB AMIK TARUNA 2026 – HARI KETIGA ✨🎓','Fiqri_Rg','Fiqri_Rg','2026-09-20 21:38:50','pkkmb-amik-taruna-2026-hari-ketiga','🎓✨ PKKMB AMIK TARUNA 2026 – HARI KETIGA ✨🎓\r\n📚 Membangun Kemandirian, Kesadaran, dan Rasa Aman di Lingkungan Kampus\r\n\r\nMemasuki hari ketiga Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) AMIK Taruna Tahun Akademik 2026–2027, para mahasiswa baru kembali mengikuti rangkaian kegiatan pembekalan dengan penuh semangat dan antusiasme. 💚🎓\r\n\r\nKegiatan diawali dengan Review Hari Kedua bersama BEM sebagai penguatan kembali materi dan pengalaman yang telah diperoleh mahasiswa pada hari sebelumnya. 📚✨\r\n\r\nSelanjutnya, mahasiswa mendapatkan materi Administrasi Keuangan yang membahas sistem pembayaran dan keuangan. Materi ini memberikan pemahaman kepada mahasiswa baru mengenai hal-hal yang berkaitan dengan administrasi keuangan selama menjalani kehidupan perkuliahan di AMIK Taruna. 💳📋\r\n\r\nKegiatan kemudian dilanjutkan dengan materi Pencegahan dan Penanganan Kekerasan di Perguruan Tinggi (PPKPT). Materi ini menjadi bagian penting dalam memberikan pemahaman kepada mahasiswa mengenai pentingnya menciptakan lingkungan perguruan tinggi yang aman dan nyaman bagi seluruh warga kampus. 🤝🛡️\r\n\r\nSetelah rangkaian materi, mahasiswa baru mendapatkan waktu istirahat dan ISHOMA bersama BEM sebelum melanjutkan rangkaian kegiatan PKKMB berikutnya. 🌿✨\r\n\r\nMelalui kegiatan hari ketiga ini, mahasiswa tidak hanya mendapatkan pengetahuan mengenai administrasi dan kehidupan kampus, tetapi juga memperoleh pembekalan mengenai pentingnya menjaga lingkungan perguruan tinggi yang aman, nyaman, dan saling menghargai. 💚🎓\r\n\r\nSetiap materi yang diberikan menjadi bagian dari proses mempersiapkan mahasiswa baru agar semakin siap menjalani kehidupan akademik dan menjadi bagian dari keluarga besar AMIK Taruna. 🌱🚀\r\n\r\n🔥 Tiga hari, semakin banyak pengalaman dan wawasan!\r\nMari terus ikuti rangkaian PKKMB AMIK Taruna 2026 dengan semangat, kebersamaan, dan energi positif! 🎓💚\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa. ✨🌱\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna di media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: www.amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #PKKMBAMIKTaruna #PKKMB2026 #PKKMBHariKetiga #MahasiswaBaru #MahasiswaBaru2026 #TahunAkademik20262027 #AdministrasiKeuangan #SistemPembayaran #PPKPT #PencegahanKekerasan #LingkunganKampusAman #BEMAMIKTaruna #PendidikanTinggi #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction','1789915130_DSC01459 (1) (1).jpg',NULL,NULL,'2026-09-20 21:38:50','2026-09-20 21:38:50','kegiatan_kampus'),
(31,'🎓✨ Penutupan PKKMB & Malam Inagurasi AMIK Taruna 2026 ✨🎓','Fiqri_Rg','Fiqri_Rg','2026-09-20 21:44:02','penutupan-pkkmb-malam-inagurasi-amik-taruna-2026','🎓✨ Penutupan PKKMB & Malam Inagurasi AMIK Taruna 2026 ✨🎓\r\n💚 Menutup Rangkaian PKKMB dengan Kebersamaan dan Keceriaan\r\n\r\nRangkaian Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) AMIK Taruna Tahun Akademik 2026–2027 akhirnya sampai pada penghujung kegiatan. Setelah melewati berbagai rangkaian pembekalan, pengenalan kampus, dan kegiatan bersama, mahasiswa baru AMIK Taruna menutup perjalanan PKKMB dengan suasana penuh semangat dan kebersamaan. 🎓✨\r\n\r\nKegiatan diawali dengan persiapan Malam Inagurasi, dilanjutkan dengan Sholat Ashar, kemudian mahasiswa kembali mempersiapkan berbagai rangkaian acara untuk malam yang menjadi salah satu momen spesial dalam PKKMB tahun ini. 🤲💚\r\n\r\nSebelum acara penutupan, turut dilaksanakan penyerahan hadiah bagi para pemenang lomba sebagai bentuk apresiasi atas semangat, kreativitas, dan partisipasi mahasiswa baru selama rangkaian kegiatan PKKMB. 🏆🎁✨\r\n\r\nKemudian, rangkaian PKKMB AMIK Taruna 2026 secara resmi ditutup oleh Direktur AMIK Taruna, Ir. Choirul Anam, M.Kom. 🎓💚 Momen ini menjadi tanda berakhirnya rangkaian pengenalan kehidupan kampus sekaligus awal dari perjalanan baru para mahasiswa sebagai bagian dari keluarga besar AMIK Taruna.\r\n\r\n🌟 Malam Inagurasi 🌟\r\n\r\nMalam semakin meriah dengan berbagai hiburan dan tampilan kreasi mahasiswa baru. 🎤🎶💃🕺 Berbagai kreativitas ditampilkan dalam suasana penuh keceriaan, kebersamaan, dan kekeluargaan.\r\n\r\nMalam Inagurasi menjadi ruang bagi mahasiswa baru untuk menunjukkan bakat dan kreativitas, sekaligus menjadi kesempatan untuk semakin dekat dengan teman-teman dan membangun kenangan indah di awal perjalanan mereka sebagai mahasiswa. ✨💚\r\n\r\nTiga hari penuh kegiatan, pembelajaran, pengalaman, dan kebersamaan akhirnya menjadi sebuah cerita yang akan menjadi bagian dari perjalanan mahasiswa baru AMIK Taruna. Dari mengenal kampus, mengenal lingkungan akademik, membangun karakter, hingga menunjukkan kreativitas, semuanya menjadi langkah awal menuju perjalanan perkuliahan yang baru. 🚀📚\r\n\r\n🎉 Selamat kepada seluruh mahasiswa baru AMIK Taruna Tahun Akademik 2026–2027!\r\n\r\nSelamat datang di keluarga besar AMIK Taruna. Semoga semangat, kebersamaan, kreativitas, dan pengalaman selama PKKMB menjadi bekal untuk menjalani perjalanan perkuliahan dengan penuh semangat dan tanggung jawab. 🎓💚\r\n\r\nPKKMB boleh berakhir, tetapi perjalanan kalian sebagai mahasiswa AMIK Taruna baru saja dimulai! 🔥✨\r\n\r\n🌟 AMIK Taruna 🌟\r\n💚 Green Campus, Great Future\r\n📚 Berkarya untuk Masyarakat, Mengabdi untuk Negeri, Memberi Manfaat untuk Bangsa. ✨🌱\r\n\r\n📲 Ikuti terus informasi dan kegiatan AMIK Taruna di media resmi kami:\r\n🔹 Instagram: @official_amiktarunaprobolinggo\r\n🔹 YouTube: ATP Creativity\r\n🔹 Facebook & TikTok: AMIK Taruna Probolinggo\r\n🔹 Website: www.amiktaruna.ac.id\r\n\r\n#AMIKTarunaProbolinggo #PKKMBAMIKTaruna #PKKMB2026 #PenutupanPKKMB #MalamInagurasi #InagurasiAMIKTaruna #MahasiswaBaru #MahasiswaBaru2026 #TahunAkademik20262027 #KreativitasMahasiswa #BEMAMIKTaruna #Kebersamaan #KeluargaBesarAMIKTaruna #PendidikanTinggi #GreenCampusGreatFuture #BerkaryaUntukMasyarakat #MengabdiUntukNegeri #MemberiManfaatUntukBangsa #DiktiSaintekBerdampak #ATProduction','1789915442_DSC01812 (1).jpg',NULL,NULL,'2026-09-20 21:44:02','2026-09-20 21:44:02','kegiatan_kampus'),
(32,'Sosialisasi & Pedoman Pencegahan Kekerasan Seksual (Satgas PPKS) AMIK Taruna','Humas & Satgas PPKS','Admin Kampus','2026-09-23 20:09:19','pedoman-pencegahan-kekerasan-seksual-satgas-ppks','<p>Dalam rangka mewujudkan lingkungan kampus yang aman, inklusif, bermartabat, dan bebas dari segala bentuk kekerasan seksual, AMIK Taruna resmi menerbitkan Buku Saku Pedoman Pencegahan dan Penanganan Kekerasan Seksual (PPKS) sesuai implementasi Permendikbudristek No. 30 Tahun 2021.</p><p>Pedoman ini memuat hak-hak perlindungan korban, alur pelaporan terenkripsi dan rahasia, mekanisme investigasi independen oleh Satgas, serta pendampingan psikologis dan bantuan pemulihan korban. Seluruh sivitas akademika (mahasiswa, dosen, dan staf kependidikan) dihimbau untuk mempelajari pedoman terlampir.</p>','1780777258_Screenshot (1).png','Pedoman_Satgas_PPKS_AMIK_Taruna.pdf',NULL,'2026-09-23 20:09:19','2026-09-23 20:09:19','ppks');
/*!40000 ALTER TABLE `beritas` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `dosens`
--

DROP TABLE IF EXISTS `dosens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dosens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `bidang_keahlian` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `dosens` WRITE;
/*!40000 ALTER TABLE `dosens` DISABLE KEYS */;
INSERT INTO `dosens` VALUES
(2,'Fiqri Romadhonal Gupron, S.Kom.','Staf SI, Humas & Layanan|Dosen','1779304673_Fiqri.jpg','2026-04-19 19:04:29','2026-09-17 23:29:33','Fiqri Romadhonal Gupron, S.Kom. merupakan akademisi dan praktisi di bidang Teknologi Informasi yang memiliki minat dalam pengembangan sistem informasi, pemrograman web, desain grafis, multimedia, serta kecerdasan buatan. Menempuh pendidikan Diploma III (D3) Program Studi Sistem Informasi di AMIK Taruna dan melanjutkan pendidikan Sarjana (S1) Program Studi Teknologi Informasi di Universitas Nurul Jadid.\r\n\r\nSaat ini, Saya sedang melanjutkan studi Magister (S2) di UIN Maulana Malik Ibrahim Malang dengan fokus pada pengembangan teknologi informasi dan penelitian berbasis data. Selain aktif dalam dunia akademik, Saya juga memiliki pengalaman dalam pengembangan aplikasi berbasis web, desain grafis, multimedia, pengelolaan media digital, serta penelitian di bidang machine learning dan computer vision.\r\n\r\nDengan latar belakang pendidikan dan pengalaman yang dimiliki, Saya berkomitmen untuk terus mengembangkan inovasi teknologi yang dapat memberikan kontribusi bagi dunia pendidikan, industri, dan masyarakat. Kemampuan yang ditekuni meliputi Web Programming, UI/UX Design, Graphic Design, Multimedia Development, Database Management, Artificial Intelligence, serta Data Analytics.\r\n\r\nNama: Fiqri Romadhonal Gupron, S.Kom.\r\nBidang Keahlian: Web Programming, Desain Grafis, Multimedia, Sistem Informasi, Artificial Intelligence, dan Data Analytics\r\n\r\nPendidikan:\r\nD3 Sistem Informasi – AMIK Taruna\r\nS1 Teknologi Informasi – Universitas Nurul Jadid\r\nS2 (sedang ditempuh) – UIN Maulana Malik Ibrahim Malang\r\n\r\nMotto:\r\n\"Belajar, Berkarya, dan Berinovasi untuk memberikan manfaat melalui teknologi.\"',NULL,'fiqrirg57@gmail.com','D3 - Sistem Informasi - AMIK Taruna, S1 - Teknologi Informasi - Universitas Nurul Jadid','WEB Programing, Desain Grafis dan Multimedia','https://www.researchgate.net/publication/399266617_Penerapan_Algoritma_K-Means_Dalam_Menentukan_Kualitas_Satuan_Pendidikan_Berdasarkan_Nilai_Internal_Dan_Eksternal'),
(3,'Lutfiatul badriyah S, Kom.','Staff Pusat Penjaminan Mutu','1779304687_Gambar WhatsApp 2025-01-22 pukul 13.39.09_875cd634.jpg','2026-05-08 09:05:49','2026-05-20 19:48:45',NULL,NULL,NULL,NULL,NULL,NULL),
(4,'Khusnul Arifin, S.Kom.','Staf Administrasi Akademik|Dosen','1779304711_02.jpg','2026-05-08 09:06:47','2026-05-20 19:49:52',NULL,NULL,NULL,NULL,NULL,NULL),
(5,'Heri Darmanto, M.Kom.','Dosen','1779304739_WhatsApp Image 2023-08-09 at 13.32.18.jpeg','2026-05-08 09:07:37','2026-05-20 19:50:51',NULL,NULL,NULL,NULL,NULL,NULL),
(6,'Ir. Choirul Anam, M.Kom.','Direktur AMIK Taruna|Dosen','1779304752_WhatsApp Image 2023-08-09 at 13.36.13.jpeg','2026-05-08 09:09:01','2026-06-01 20:03:03','kabdaksjdb','1234567876543','m.irhamauliaq@gmail.com','an,fbakj','kdsbabsdk','ahvdagjvds'),
(7,'Heri Susanto, S.E., M.Kom.','Ketua Program Studi Sistem Informasi|Ketua UPT Perpustakaan & Kearsipan|Dosen','1779304768_WhatsApp Image 2023-08-04 at 10.31.49.jpeg','2026-05-08 09:12:16','2026-05-20 19:52:30',NULL,NULL,NULL,NULL,NULL,NULL),
(8,'Nur Edy Sabilliat, S.Kom','Dosen','1779304829_WhatsApp Image 2023-08-04 at 05.33.02.jpeg','2026-05-08 09:12:52','2026-05-20 19:59:00',NULL,NULL,NULL,NULL,NULL,NULL),
(9,'Ir. Kariyono, M.T.','Dosen','1779333010_WhatsApp Image 2023-08-04 at 05.26.27.jpeg','2026-05-08 09:15:15','2026-05-20 20:10:10',NULL,NULL,NULL,NULL,NULL,NULL),
(10,'Jamal, S.E., M.Kom.','Wakil Direktur I Bidang Akademik','1779333051_DSC_0081.JPG','2026-05-08 09:18:38','2026-08-14 16:07:11',NULL,NULL,NULL,NULL,NULL,NULL),
(11,'Mudjianto','Staf SI, Humas & Layanan','1779333067_DSC_0073.JPG','2026-05-08 09:21:41','2026-05-20 20:11:07',NULL,NULL,NULL,NULL,NULL,NULL),
(12,'Ir. Bambang Hariyadi, MBA.','Wakil Direktur II Bidang Administrasi & Keuangan|Dosen','1779333081_DSC_0075.JPG','2026-05-08 09:23:10','2026-05-20 20:11:21',NULL,NULL,NULL,NULL,NULL,NULL),
(13,'Dwi Yanto, M.Kom.','Wakil Direktur III Bidang Kemahasiswaan & Alumni|Ketua Unit Kerjasama & Pengembangan Institusi|Dosen','1779333097_DSC_0071.JPG','2026-05-08 09:24:29','2026-05-20 20:11:37',NULL,NULL,NULL,NULL,NULL,NULL),
(14,'Ninanesia Rusdiana, S.E., M.ST.','Kepala Bagian Administrasi Umum & Keuangan|Dosen','1779333114_DSC_0068.JPG','2026-05-08 09:25:21','2026-05-20 20:11:54',NULL,NULL,NULL,NULL,NULL,NULL),
(15,'Lamsadi, S.Si., M.Kom.','Ketua Program Studi Teknologi Informasi|Dosen','1779333134_DSC_0062.JPG','2026-05-08 09:26:25','2026-05-20 20:12:14',NULL,NULL,NULL,NULL,NULL,NULL),
(17,'Kiky Zulkifli, S.Pd., M.Akun.','Ketua Program Studi Sistem Informasi Akuntansi','1779333178_DSC_0040.JPG','2026-05-08 09:28:33','2026-08-14 16:07:33',NULL,NULL,NULL,NULL,NULL,NULL),
(18,'Himmatur Rizal, S.Ag., M.Pd','Ketua Pusat Penjaminan Mutu|Dosen','1781486074_IMG-20260615-WA0001.jpg','2026-05-20 20:14:07','2026-06-15 08:14:34',NULL,NULL,NULL,NULL,NULL,NULL),
(19,'Mohammad Edi, M.Kom.','Kepala Bagian Administrasi Akademik|Dosen',NULL,'2026-05-20 20:20:13','2026-05-20 20:20:13',NULL,NULL,NULL,NULL,NULL,NULL),
(20,'Mutia Syafira Febrianti, S.Kom','Staf Perpustakaan & Kearsipan',NULL,'2026-05-20 20:20:54','2026-05-20 20:20:54',NULL,NULL,NULL,NULL,NULL,NULL),
(21,'Muhammad Izha Mahendra, A.Md.Kom.','Staf Administrasi Umum & Keuangan|Staf Alumni & Pusat Karir','1786698713_Desain tanpa judul.png','2026-05-20 20:21:31','2026-09-17 23:29:52',NULL,NULL,NULL,NULL,NULL,NULL),
(23,'Yusril Firmansyah Akbar, M.E.','Ketua Lembaga Penelitian & Pengabdian Masyarakat','1781492868_Yusril.jpg','2026-05-20 20:22:09','2026-08-14 16:08:02',NULL,NULL,NULL,NULL,NULL,NULL),
(24,'Luluk Khoiriyah, S.S., M.Pd.','Dosen',NULL,'2026-05-20 20:22:27','2026-05-20 20:22:27',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dosens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `faq_prodis`
--

DROP TABLE IF EXISTS `faq_prodis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_prodis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_studi_id` bigint(20) unsigned NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faq_prodis_program_studi_id_foreign` (`program_studi_id`),
  CONSTRAINT `faq_prodis_program_studi_id_foreign` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_prodis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `faq_prodis` WRITE;
/*!40000 ALTER TABLE `faq_prodis` DISABLE KEYS */;
INSERT INTO `faq_prodis` VALUES
(1,2,'Apakah jurusan Sistem informasi bisa jadi web development','Tentu sangat bisa karena di sistem informasi ada kurikulum pengembangan website','2026-06-02 01:48:01','2026-06-02 01:48:01');
/*!40000 ALTER TABLE `faq_prodis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `fasilitas_prodis`
--

DROP TABLE IF EXISTS `fasilitas_prodis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `fasilitas_prodis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_studi_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fasilitas_prodis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `fasilitas_prodis` WRITE;
/*!40000 ALTER TABLE `fasilitas_prodis` DISABLE KEYS */;
INSERT INTO `fasilitas_prodis` VALUES
(1,2,'2026-06-02 01:36:54','2026-06-02 01:36:54','Lab Sistem Informasi','Mempunyai pc yang bangus dan sangat mendukung untuk kegiatan konputasi, pembrograman, serta analisis mahasiswa',NULL);
/*!40000 ALTER TABLE `fasilitas_prodis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `kategoris`
--

DROP TABLE IF EXISTS `kategoris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategoris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `modul` varchar(255) NOT NULL DEFAULT 'berita',
  `warna` varchar(255) DEFAULT 'success',
  `ikon` varchar(255) DEFAULT '?',
  `keterangan` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategoris_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoris`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `kategoris` WRITE;
/*!40000 ALTER TABLE `kategoris` DISABLE KEYS */;
INSERT INTO `kategoris` VALUES
(1,'Pengumuman','pengumuman','berita','success','📢','Informasi dan pemberitahuan resmi kampus',1,1,'2026-09-23 04:50:05','2026-09-23 04:50:05'),
(2,'Pengabdian','pengabdian','berita','primary','🤝','Kegiatan pengabdian kepada masyarakat',2,1,'2026-09-23 04:50:05','2026-09-23 04:50:05'),
(3,'Penelitian','penelitian','berita','warning','🔬','Publikasi dan riset ilmiah kampus',3,1,'2026-09-23 04:50:05','2026-09-23 04:50:05'),
(4,'Kegiatan Kampus','kegiatan_kampus','berita','danger','🎓','Aktivitas dan event kemahasiswaan kampus',4,1,'2026-09-23 04:50:05','2026-09-23 04:50:05'),
(5,'Prestasi Mahasiswa','prestasi','berita','info','🏆','Penghargaan dan capaian prestasi sivitas akademika',5,1,'2026-09-23 04:50:05','2026-09-23 04:50:05'),
(6,'PMB Reguler','pmb-reguler','pmb','info','📝','Informasi pendaftaran mahasiswa baru reguler',6,1,'2026-09-23 04:50:05','2026-09-23 04:50:05'),
(7,'PMB Beasiswa','pmb-beasiswa','pmb','success','🌟','Informasi pendaftaran mahasiswa jalur beasiswa',7,1,'2026-09-23 04:50:06','2026-09-23 04:50:06'),
(8,'Standar Mutu SPMI','spmi-mutu','dokumen','primary','📜','Dokumen standar mutu dan audit internal',8,1,'2026-09-23 04:50:06','2026-09-23 04:50:06'),
(9,'Layanan Akademik','layanan-akademik','layanan','success','💻','Portal dan fasilitas akademik kampus',9,1,'2026-09-23 04:50:06','2026-09-23 04:50:06'),
(11,'Kebijakan & SK Mutu','kebijakan-sk','dokumen','danger','⚖️','SK Direktur, ketetapan, dan kebijakan penjaminan mutu',2,1,'2026-09-23 04:56:49','2026-09-23 04:56:49'),
(12,'Manual & SOP Mutu','manual-sop','dokumen','warning','📋','Manual prosedur operasional standar SPMI',3,1,'2026-09-23 04:56:49','2026-09-23 04:56:49'),
(13,'Laporan AMI & Evaluasi','laporan-ami','dokumen','success','📊','Hasil audit mutu internal dan laporan kepatuhan standar',4,1,'2026-09-23 04:56:49','2026-09-23 04:56:49'),
(14,'Profil Lulusan','profil-lulusan','prodi_dokumen','success','🎓','Dokumen profil kelulusan dan capaian kompetensi prodi',1,1,'2026-09-23 11:23:16','2026-09-23 11:23:16'),
(15,'Pedoman Akademik','pedoman-akademik','prodi_dokumen','primary','📖','Buku pedoman dan panduan perkuliahan akademik program studi',2,1,'2026-09-23 11:23:16','2026-09-23 11:23:16'),
(16,'Kurikulum','kurikulum','prodi_dokumen','warning','📚','Struktur sebaran mata kuliah dan silabus kurikulum',3,1,'2026-09-23 11:23:16','2026-09-23 11:23:16'),
(17,'RPS','rps','prodi_dokumen','danger','📝','Rencana Pembelajaran Semester per mata kuliah prodi',4,1,'2026-09-23 11:23:16','2026-09-23 11:23:16'),
(18,'Layanan & Edukasi PPKS','ppks','berita','danger','🛡️','Publikasi, regulasi dan warta seputar Satgas Pencegahan dan Penanganan Kekerasan Seksual',6,1,'2026-09-23 20:09:03','2026-09-23 20:09:03');
/*!40000 ALTER TABLE `kategoris` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `kritik_sarans`
--

DROP TABLE IF EXISTS `kritik_sarans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kritik_sarans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('baru','dibaca') NOT NULL DEFAULT 'baru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kritik_sarans`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `kritik_sarans` WRITE;
/*!40000 ALTER TABLE `kritik_sarans` DISABLE KEYS */;
INSERT INTO `kritik_sarans` VALUES
(8,'Anonim','anonim@anonim.com','Kritik','Bikin website jangan pakai AI dong, kan banyak mahasiswa yg mampu bikin website professional','baru','2026-06-14 18:25:29','2026-06-14 18:25:29'),
(9,'anonim','anonim@anonim','kritik','Website lumayan, palingan biaya anggaran nya besar ya, manfaatin mahasiswa dong, mending bayar mahasiswa daripada bayar pihak luar.','baru','2026-07-14 21:42:36','2026-07-14 21:42:36');
/*!40000 ALTER TABLE `kritik_sarans` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `layanans`
--

DROP TABLE IF EXISTS `layanans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `layanans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `layanans`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `layanans` WRITE;
/*!40000 ALTER TABLE `layanans` DISABLE KEYS */;
INSERT INTO `layanans` VALUES
(1,'SIAKAD','https://amiktaruna.akademis.ai/','1779304959_siakad.png','info','Sistem informasi akademik \r\n(SIAKAD)','2026-05-06 07:26:47','2026-09-17 08:57:00'),
(2,'PENA MBKM','https://monitoringmbkm.amiktaruna.ac.id/','1779304941_LOGO - YPKK.png','success','Portal PENA MBKM','2026-05-06 08:21:59','2026-05-20 12:22:21'),
(5,'Monitoring TA','https://monitoringtugasakhir.amiktaruna.ac.id/','1779304888_LOGO - YPKK.png',NULL,NULL,'2026-05-08 09:43:46','2026-06-16 23:37:19');
/*!40000 ALTER TABLE `layanans` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lppm`
--

DROP TABLE IF EXISTS `lppm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lppm` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` longtext DEFAULT NULL,
  `jesica_link` varchar(255) DEFAULT NULL,
  `jesica_image` varchar(255) DEFAULT NULL,
  `penelitian_link` varchar(255) DEFAULT NULL,
  `penelitian_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lppm`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lppm` WRITE;
/*!40000 ALTER TABLE `lppm` DISABLE KEYS */;
INSERT INTO `lppm` VALUES
(1,NULL,'https://jessica.amiktaruna.ac.id/',NULL,'https://pengajuanproposalppm.amiktaruna.ac.id/',NULL,'2026-06-09 15:04:54','2026-08-18 21:35:44');
/*!40000 ALTER TABLE `lppm` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lppm_portals`
--

DROP TABLE IF EXISTS `lppm_portals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lppm_portals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `warna` varchar(255) DEFAULT 'success',
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lppm_portals`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lppm_portals` WRITE;
/*!40000 ALTER TABLE `lppm_portals` DISABLE KEYS */;
INSERT INTO `lppm_portals` VALUES
(1,'JESICA','https://jessica.amiktaruna.ac.id/',NULL,'Jurnal Elektronik Sistem Informasi dan Komputer Terapan AMIK Taruna Probolinggo.','success',1,'2026-09-23 04:16:43','2026-09-23 04:16:43'),
(2,'Pengajuan Proposal PPM','https://pengajuanproposalppm.amiktaruna.ac.id/',NULL,'Sistem Informasi Pengajuan Proposal Penelitian dan Pengabdian kepada Masyarakat.','primary',2,'2026-09-23 04:16:43','2026-09-23 04:16:43'),
(3,'anjay kelaz','https://web.whatsapp.com/','1790137491_portal_WhatsApp Image 2026-09-22 at 20.22.36.jpeg','c fkjabdfjkdbkjzbdfkdzj','primary',0,'2026-09-23 04:24:51','2026-09-23 04:24:51');
/*!40000 ALTER TABLE `lppm_portals` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lppms`
--

DROP TABLE IF EXISTS `lppms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lppms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text DEFAULT NULL,
  `jesica_link` varchar(255) DEFAULT NULL,
  `jesica_image` varchar(255) DEFAULT NULL,
  `penelitian_link` varchar(255) DEFAULT NULL,
  `penelitian_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lppms`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lppms` WRITE;
/*!40000 ALTER TABLE `lppms` DISABLE KEYS */;
/*!40000 ALTER TABLE `lppms` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_04_19_161354_create_beritas_table',2),
(5,'2026_04_19_183640_create_visi_misis_table',3),
(6,'2026_04_19_202350_create_dosens_table',4),
(7,'2026_04_19_205957_add_visi_misi_columns_to_visi_misis_table',5),
(8,'2026_04_20_013426_add_deskripsi_to_visi_misis_table',6),
(9,'2026_04_21_071824_add_penulis_to_beritas_table',7),
(10,'2026_05_06_140608_create_layanans_table',8),
(11,'2026_05_07_065128_add_logo_to_layanans_table',9),
(12,'2026_05_07_065532_drop_icon_from_layanans_table',10),
(13,'2026_05_10_042750_create_settings_table',11),
(14,'2026_05_11_041307_create_alumni_sections_table',12),
(15,'2026_05_17_172419_add_kategori_to_beritas_table',13),
(16,'2026_05_18_055327_add_link_to_alumni_sections_table',14),
(17,'2026_05_20_013114_create_akreditasis_table',15),
(18,'2026_05_20_052449_add_judul_to_akreditasis_table',16),
(19,'2026_05_20_192652_add_video_to_beritas_table',17),
(20,'2026_05_26_203433_add_profile_fields_to_dosens_table',18),
(21,'2026_05_28_124704_create_program_studis_table',19),
(22,'2026_05_28_124705_create_profil_lulusans_table',19),
(23,'2026_05_28_124706_create_fasilitas_prodis_table',19),
(24,'2026_05_28_124707_create_faq_prodis_table',20),
(25,'2026_05_28_140957_fix_program_studis_columns',21),
(26,'2026_05_28_141631_repair_program_studis_table',22),
(27,'2026_05_28_142234_add_program_studi_id_to_profil_lulusans',23),
(28,'2026_05_28_142830_repair_relasi_program_studi_tables',24),
(29,'2026_05_28_143317_repair_program_studi_detail_tables',25),
(30,'2026_06_02_143404_create_p_m_b_s_table',26),
(31,'2026_06_02_143405_create_berita_p_m_b_s_table',26),
(32,'2026_06_03_202536_create_ppms_table',27),
(33,'2026_06_03_202538_create_lppms_table',27),
(34,'2026_06_03_204204_create_ppm_table',28),
(35,'2026_06_03_204514_create_lppm_table',28),
(36,'2026_06_04_013814_add_file_pdf_to_beritas_table',29),
(37,'2026_06_04_021021_add_editor_to_beritas_table',30),
(38,'2026_06_04_024335_update_berita_pmbs_table',31),
(39,'2026_06_05_164134_add_publish_at_to_beritas_table',32),
(40,'2026_06_08_092435_create_berita_pmb__table',33),
(41,'2026_06_11_083616_create_kritik_sarans_table',34),
(42,'2026_09_23_090957_add_file_pdf_and_nama_dokumen_to_ppm_table',35),
(43,'2026_09_23_111425_create_lppm_portals_table',36),
(44,'2026_09_23_114607_create_kategoris_table',37),
(45,'2026_09_23_114610_alter_beritas_kategori_to_string',37),
(46,'2026_09_23_115527_create_ppm_dokumens_table',38),
(47,'2026_09_23_182209_create_prodi_dokumens_table',39),
(48,'2026_09_24_030000_create_ppks_laporans_table',40),
(49,'2026_09_24_040814_add_dynamic_fields_to_pmbs_table',41),
(50,'2026_09_24_080000_add_role_and_permissions_to_users_table',42),
(51,'2026_09_24_080001_create_activity_logs_table',42);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pmbs`
--

DROP TABLE IF EXISTS `pmbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pmbs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `subjudul` varchar(255) DEFAULT NULL,
  `deskripsi` longtext NOT NULL,
  `nama_gelombang` varchar(255) DEFAULT NULL,
  `status_gelombang` varchar(255) DEFAULT NULL,
  `periode_gelombang` varchar(255) DEFAULT NULL,
  `kuota_info` varchar(255) DEFAULT NULL,
  `no_whatsapp` varchar(255) DEFAULT NULL,
  `link_portal` varchar(255) DEFAULT NULL,
  `brosur_file` varchar(255) DEFAULT NULL,
  `jalur_pendaftaran` longtext DEFAULT NULL,
  `alur_pendaftaran` longtext DEFAULT NULL,
  `jadwal_gelombang` longtext DEFAULT NULL,
  `persyaratan_berkas` longtext DEFAULT NULL,
  `faq_list` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmbs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pmbs` WRITE;
/*!40000 ALTER TABLE `pmbs` DISABLE KEYS */;
INSERT INTO `pmbs` VALUES
(1,'Penerimaan Mahasiswa Baru AMIK Taruna 2026','Kuliah Vokasi D3 Praktis Siap Kerja di Bidang Teknologi Informasi','Pendaftaran mahasiswa baru tahun akademik 2026/2027 telah dibuka!','Gelombang 2','Sedang Berlangsung','Mei s/d Juli 2026','Tersedia 50 Kuota Beasiswa KIP Kuliah 100% Gratis & Potongan SPP','081234567890','https://drive.google.com/file/d/1s4yrPs_0fvCqmDKyglt-gWZY3_ThVsAs/view?usp=sharing',NULL,'[{\"nama\":\"Beasiswa KIP Kuliah\",\"badge\":\"KUOTA TERBATAS\",\"ikon\":\"fas fa-hand-holding-dollar\",\"deskripsi\":\"Bebas biaya kuliah 100% hingga lulus ditambah subsidi biaya hidup bulanan langsung dari Kemendikbudristek RI.\",\"syarat\":\"Memiliki KIP \\/ KKS \\/ SKTM, Lulusan 2024, 2025, atau 2026, Wawancara & Verifikasi Berkas\"},{\"nama\":\"Jalur Prestasi & Bakat\",\"badge\":\"BEBAS TES\",\"ikon\":\"fas fa-trophy\",\"deskripsi\":\"Bagi siswa berprestasi peringkat kelas, juara kompetisi sains, olahraga, seni, atau penghafal Al-Qur\'an (Tahfidz).\",\"syarat\":\"Potongan biaya pendaftaran, Sertifikat juara minimal kab\\/kota, Bebas ujian seleksi tulis\"},{\"nama\":\"Jalur Reguler (Rapor)\",\"badge\":\"POPULER\",\"ikon\":\"fas fa-file-signature\",\"deskripsi\":\"Pendaftaran fleksibel menggunakan nilai rapor semester 1-5 atau ijazah bagi lulusan SMA\\/SMK\\/MA sederajat.\",\"syarat\":\"Tanpa tes rumit, Proses pengumuman cepat, Pilihan kelas pagi \\/ fleksibel\"},{\"nama\":\"Jalur Karyawan & Kerja\",\"badge\":\"KELAS FLEKSIBEL\",\"ikon\":\"fas fa-briefcase\",\"deskripsi\":\"Didesain khusus untuk pekerja, wiraswasta, atau karyawan yang ingin meningkatkan jenjang karir dan kualifikasi gelar A.Md.\",\"syarat\":\"Waktu kuliah malam \\/ akhir pekan, Biaya dapat diangsur bulanan, Kurikulum praktis aplikatif\"}]','[{\"langkah\":\"1\",\"judul\":\"Buat Akun & Daftar\",\"deskripsi\":\"Buka portal online PMB, buat akun menggunakan nomor WhatsApp dan email aktif, lalu pilih program studi D3 yang diminati.\"},{\"langkah\":\"2\",\"judul\":\"Unggah Dokumen Berkas\",\"deskripsi\":\"Unggah scan ijazah\\/SKL, Kartu Keluarga, pas foto, serta dokumen beasiswa KIP Kuliah atau piagam prestasi (jika ada).\"},{\"langkah\":\"3\",\"judul\":\"Verifikasi & Seleksi\",\"deskripsi\":\"Panitia PMB melakukan verifikasi data dan penilaian rapor\\/tes. Hasil kelulusan akan diumumkan melalui portal & notifikasi WhatsApp.\"},{\"langkah\":\"4\",\"judul\":\"Registrasi & Siap Kuliah\",\"deskripsi\":\"Lakukan registrasi ulang, pengambilan jas almamater, orientasi pengenalan kampus (PKKMB), dan siap mengikuti perkuliahan!\"}]','[{\"nama\":\"Gelombang 1 (Early Bird & Prestasi)\",\"periode\":\"Januari s\\/d April 2026\",\"status\":\"Selesai\",\"keterangan\":\"Potongan khusus SPP dan bebas tes bagi pendaftar awal.\"},{\"nama\":\"Gelombang 2 (Reguler & KIP Kuliah)\",\"periode\":\"Mei s\\/d Juli 2026\",\"status\":\"Sedang Berlangsung\",\"keterangan\":\"Pendaftaran kuota beasiswa KIP Kuliah dan reguler dibuka sekarang!\"},{\"nama\":\"Gelombang 3 (Sisa Kuota \\/ Penutupan)\",\"periode\":\"Agustus s\\/d September 2026\",\"status\":\"Mendatang\",\"keterangan\":\"Pengisian sisa kuota bangku kuliah dan persiapan ospek.\"}]','[{\"judul\":\"Kartu Keluarga (KK) & KTP \\/ Akta Kelahiran\",\"keterangan\":\"Sebagai verifikasi data kependudukan resmi.\",\"ikon\":\"fas fa-id-card\"},{\"judul\":\"Ijazah \\/ SKL \\/ Surat Keterangan Siswa Kelas 12\",\"keterangan\":\"Bagi yang belum lulus dapat menggunakan surat keterangan aktif sekolah.\",\"ikon\":\"fas fa-graduation-cap\"},{\"judul\":\"Pas Foto Formal Terbaru\",\"keterangan\":\"Pas foto resmi ukuran 3x4 \\/ 4x6 latar belakang merah atau biru.\",\"ikon\":\"fas fa-image\"},{\"judul\":\"Kartu KIP \\/ Piagam Prestasi (Khusus Beasiswa)\",\"keterangan\":\"Kartu Indonesia Pintar, KKS, atau sertifikat juara perlombaan.\",\"ikon\":\"fas fa-award\"}]','[{\"tanya\":\"Apakah lulusan SMK non-IT atau SMA IPS bisa mendaftar?\",\"jawab\":\"Tentu saja sangat bisa! Seluruh program studi vokasi D3 di AMIK Taruna dirancang dengan kurikulum dasar dari pengenalan awal (zero to hero). Dosen dan asisten laboratorium akan membimbing mulai dari konsep logika dasar, pemrograman awal, hingga mahir.\"},{\"tanya\":\"Apakah Beasiswa KIP Kuliah benar-benar gratis 100%?\",\"jawab\":\"Ya, benar-benar gratis 100%. Mahasiswa penerima KIP Kuliah di AMIK Taruna dibebaskan dari seluruh biaya kuliah (SPP, praktikum, ujian, dll.) selama 6 semester (3 tahun masa studi D3) dan memperoleh uang saku bantuan biaya hidup bulanan langsung dari rekening pemerintah.\"},{\"tanya\":\"Apakah ijazah D3 AMIK Taruna sah dan bisa digunakan mendaftar CPNS\\/BUMN?\",\"jawab\":\"Sangat sah dan diakui secara nasional. AMIK Taruna beroperasi dengan izin resmi kementerian, seluruh program studi terakreditasi BAN-PT\\/LAM INFOKOM, dan lulusan berhak menyandang gelar resmi Ahli Madya (A.Md.) yang memenuhi syarat formasi CPNS, PPPK, BUMN, perbankan, dan swasta.\"},{\"tanya\":\"Bagaimana jika dokumen ijazah asli belum terbit dari sekolah?\",\"jawab\":\"Calon mahasiswa dapat menggunakan Surat Keterangan Lulus (SKL) atau Surat Keterangan Aktif Siswa Kelas 12 dari pihak sekolah untuk mendaftar terlebih dahulu. Ijazah asli dapat disusulkan saat registrasi ulang.\"}]','2026-06-02 10:20:37','2026-09-23 21:08:54');
/*!40000 ALTER TABLE `pmbs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `ppks_laporans`
--

DROP TABLE IF EXISTS `ppks_laporans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ppks_laporans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_tiket` varchar(255) NOT NULL,
  `is_anonim` tinyint(1) NOT NULL DEFAULT 0,
  `nama_pelapor` varchar(255) DEFAULT NULL,
  `status_pelapor` varchar(255) NOT NULL DEFAULT 'Mahasiswa',
  `no_telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `kategori_kekerasan` varchar(255) NOT NULL,
  `tanggal_kejadian` date DEFAULT NULL,
  `lokasi_kejadian` varchar(255) DEFAULT NULL,
  `nama_terlapor` varchar(255) DEFAULT NULL,
  `kronologi` text NOT NULL,
  `dokumen_bukti` varchar(255) DEFAULT NULL,
  `kebutuhan_pendampingan` varchar(255) DEFAULT NULL,
  `status` enum('baru','ditinjau','investigasi','selesai') NOT NULL DEFAULT 'baru',
  `catatan_petugas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ppks_laporans_kode_tiket_unique` (`kode_tiket`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ppks_laporans`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `ppks_laporans` WRITE;
/*!40000 ALTER TABLE `ppks_laporans` DISABLE KEYS */;
/*!40000 ALTER TABLE `ppks_laporans` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `ppm`
--

DROP TABLE IF EXISTS `ppm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ppm` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` longtext DEFAULT NULL,
  `nama_portal` varchar(255) DEFAULT NULL,
  `link_portal` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `nama_dokumen` varchar(255) DEFAULT NULL,
  `deskripsi_dokumen` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ppm`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `ppm` WRITE;
/*!40000 ALTER TABLE `ppm` DISABLE KEYS */;
INSERT INTO `ppm` VALUES
(1,'Penjaminan Mutu Perguruan Tinggi adalah keseluruhan aktivitas sistematis dan berkelanjutan yang bertujuan untuk memastikan bahwa penyelenggaraan pendidikan (pembelajaran, penelitian, dan pengabdian masyarakat) serta pengelolaan institusi (tata kelola, kemahasiswaan, sumber daya) memenuhi atau melampaui Standar Nasional Pendidikan Tinggi (SN-Dikti) dan Standar Dikti yang ditetapkan oleh BAN-PT atau LAM.','Website Penjaminan Mutu','https://si-jamu.amiktaruna.ac.id/login','1781017207.png','1790130045_rencana-strategis-renstra-kelurahan-kraksaan-wetan-2025-2029.pdf','uji coba saja','vhfgjjgfmvnv','2026-06-09 14:51:32','2026-09-23 02:20:45');
/*!40000 ALTER TABLE `ppm` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `ppm_dokumens`
--

DROP TABLE IF EXISTS `ppm_dokumens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ppm_dokumens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_dokumen` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'spmi-mutu',
  `file_pdf` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ppm_dokumens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `ppm_dokumens` WRITE;
/*!40000 ALTER TABLE `ppm_dokumens` DISABLE KEYS */;
INSERT INTO `ppm_dokumens` VALUES
(1,'uji coba saja','spmi-mutu','1790130045_rencana-strategis-renstra-kelurahan-kraksaan-wetan-2025-2029.pdf','vhfgjjgfmvnv','2025/2026',1,1,'2026-09-23 04:56:49','2026-09-23 04:56:49');
/*!40000 ALTER TABLE `ppm_dokumens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `ppms`
--

DROP TABLE IF EXISTS `ppms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ppms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deskripsi` text DEFAULT NULL,
  `nama_portal` varchar(255) DEFAULT NULL,
  `link_portal` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ppms`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `ppms` WRITE;
/*!40000 ALTER TABLE `ppms` DISABLE KEYS */;
/*!40000 ALTER TABLE `ppms` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `prodi_dokumens`
--

DROP TABLE IF EXISTS `prodi_dokumens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodi_dokumens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_studi_id` bigint(20) unsigned NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'kurikulum',
  `file_dokumen` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prodi_dokumens_program_studi_id_foreign` (`program_studi_id`),
  CONSTRAINT `prodi_dokumens_program_studi_id_foreign` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodi_dokumens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `prodi_dokumens` WRITE;
/*!40000 ALTER TABLE `prodi_dokumens` DISABLE KEYS */;
INSERT INTO `prodi_dokumens` VALUES
(1,2,'Kurikulum MBKM & Vokasi Terapan D3 SI','kurikulum','sample-kurikulum-si.pdf','Struktur kurikulum lengkap 6 semester dengan sebaran mata kuliah vokasi.','2024/2025',1,1,'2026-09-23 11:28:28','2026-09-23 11:28:28'),
(2,2,'RPS Pemrograman Web & Basis Data','rps','sample-rps-si.pdf','Rencana Pembelajaran Semester mata kuliah inti pemrograman dan database.','2024/2025',2,1,'2026-09-23 11:28:28','2026-09-23 11:28:28'),
(3,2,'Buku Pedoman Akademik Mahasiswa Baru SI','pedoman-akademik','sample-pedoman-akademik-si.pdf','Pedoman pelaksanaan perkuliahan, praktikum laboratorium, dan etika akademik.','2024',3,1,'2026-09-23 11:28:28','2026-09-23 11:28:28'),
(4,2,'SK Profil Lulusan & Capaian Pembelajaran (CPL)','profil-lulusan','sample-profil-lulusan-si.pdf','Dokumen penetapan profil lulusan programmer, database administrator, dan IT support.','2024',4,1,'2026-09-23 11:28:28','2026-09-23 11:28:28');
/*!40000 ALTER TABLE `prodi_dokumens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `profil_lulusans`
--

DROP TABLE IF EXISTS `profil_lulusans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `profil_lulusans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `program_studi_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil_lulusans`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `profil_lulusans` WRITE;
/*!40000 ALTER TABLE `profil_lulusans` DISABLE KEYS */;
INSERT INTO `profil_lulusans` VALUES
(1,1,'2026-05-28 07:40:12','2026-05-28 07:40:12',NULL,'Mampu mengembangkan aplikasi modern.'),
(2,2,'2026-06-02 01:15:12','2026-06-02 01:15:12','Software Engginering','Menjadi pembuat perangkat lunak seperti website, aplikasi mobile, dan sfotware PC');
/*!40000 ALTER TABLE `profil_lulusans` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `program_studis`
--

DROP TABLE IF EXISTS `program_studis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_studis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_prodi` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `akreditasi` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `kalender_akademik` varchar(255) DEFAULT NULL,
  `jadwal_semester` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_studis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `program_studis` WRITE;
/*!40000 ALTER TABLE `program_studis` DISABLE KEYS */;
INSERT INTO `program_studis` VALUES
(2,'2026-05-31 12:54:56','2026-06-09 14:42:14','Sistem Informasi','PROGRAM STUDI SISTEM INFORMASI (SI)','Menjadi program studi unggul.','Mencetak lulusan berkualitas.','Baik',NULL,NULL,NULL,'sistem-informasi','Program unggulan bidang teknologi informasi'),
(3,'2026-06-02 05:43:58','2026-06-09 14:41:46','Teknologi Informasi','PROGRAM STUDI TEKNOLOGI INFORMASI (TI)','jkafhjlashfjl',',SDBJABDKBKA','Baik','1780404238_WhatsApp Image 2026-05-12 at 07.04.36.jpeg',NULL,NULL,'teknologi-informasi','teknologi informasi jos jis'),
(4,'2026-06-09 14:39:53','2026-06-09 14:39:53','Sistem Informasi Akuntansi','SITEM INFORMASI AKUNTANSI (SIA)',NULL,NULL,'Baik',NULL,NULL,NULL,'sistem-informasi-akuntansi','JBHKGASFGAJKFHJKAGFJKAGFJKAGFLAGFLDFKJAFJKAGFJLJAFFJA');
/*!40000 ALTER TABLE `program_studis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('mfw79U3LDvgM4B1wLWjjUO8S7yc4fKBrVjDNCHrO',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:155.0) Gecko/20100101 Firefox/155.0','eyJfdG9rZW4iOiJBSEFZMVNGRmVnTXFyaHVXWnpQVFNTRlJBRHVCb3Y3cFVERWJFeTc4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvdXNlcnNcLzJcL2VkaXQiLCJyb3V0ZSI6ImFkbWluLnVzZXJzLmVkaXQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1790228812);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_website` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `hero_judul` varchar(255) DEFAULT NULL,
  `hero_highlight` varchar(255) DEFAULT NULL,
  `hero_subjudul` text DEFAULT NULL,
  `hero_button_1_text` varchar(255) DEFAULT NULL,
  `hero_button_1_link` varchar(255) DEFAULT NULL,
  `hero_button_2_text` varchar(255) DEFAULT NULL,
  `hero_button_2_link` varchar(255) DEFAULT NULL,
  `hero_slide_1` varchar(255) DEFAULT NULL,
  `hero_slide_2` varchar(255) DEFAULT NULL,
  `hero_slide_3` varchar(255) DEFAULT NULL,
  `footer_deskripsi` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `jam_operasional` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'AMIK Taruna','Pendidikan Berkualitas untuk Masa Depan Cerah','1790083410_WhatsApp Image 2026-09-22 at 20.22.36.jpeg','Selamat Datang di AMIK Taruna','Kampus IT Terbaik di Probolinggo','Kampus unggulan dengan kurikulum industri','Info Pendaftaran','https://amiktaruna.ac.id/pmb','Profil Kampus','https://youtu.be/Fl-pzPLCIzY','1779305049_slide1_WhatsApp Image 2026-05-12 at 07.00.25.jpeg','1779305049_slide2_WhatsApp Image 2026-05-12 at 07.04.36.jpeg','1779305049_slide3_WhatsApp Image 2026-05-12 at 07.04.37.jpeg','Kampus vokasi berbasis teknologi dan kewirausahaan','Jl. Raya Leces No. 3A, Leces.','(0335) 421234','humas.amiktarunaprobolinggo@gmail.com','Senin - Jumat, 08:00 - 16:00','https://instagram.com/amiktaruna','https://youtube.com/@amiktaruna','https://tiktok.com/@amiktaruna','https://facebook.com/amiktaruna','2026-05-09 21:56:33','2026-09-22 13:23:30');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'admin',
  `permissions` longtext DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'irham','m.irhamauliaq@gmail.com','super_admin',NULL,NULL,'$2y$12$dgu/TjfwcrJfGMS51wVtVuRvZN7g.LyYF2wWP/vcEAOtvML.wqPTu',NULL,'2026-04-19 09:42:22','2026-04-19 09:42:22'),
(2,'admin','humas.amiktarunaprobolinggo@gmail.com','super_admin',NULL,NULL,'$2y$12$CRTgURmPAcuQGgkfit7BDOCi..IuJVTjDEAJ2Wur3xCa8Tdg3u/cu',NULL,'2026-06-11 03:34:12','2026-06-11 03:34:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `visi_misis`
--

DROP TABLE IF EXISTS `visi_misis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `visi_misis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visi_misis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `visi_misis` WRITE;
/*!40000 ALTER TABLE `visi_misis` DISABLE KEYS */;
INSERT INTO `visi_misis` VALUES
(1,'2026-04-19 14:01:21','2026-06-17 05:42:44','Menjadi perguruan tinggi yang berkualitas di bidang informatika dan komputer, menghasilkan lulusan yang unggul dan mandiri.','1. Menyelenggarakan pendidikan tinggi yang berkualitas dan efisien dalam bidang Sistem Informasi.\r\n2. Menghasilkan lulusan yang beriman dan bertakwa kepada Tuhan Yang Maha Esa.\r\n3. Menghasilkan lulusan yang memiliki keunggulan kompetitif dan mandiri.\r\n4. Menjadi pusat pelayanan persiapan dan pengembangan karir terbaik bagi mahasiswa/alumni.','AMIK Taruna Probolinggo adalah kampus teknologi informasi modern, komprehensif, multi budaya, humanis dengan biaya yang terjangkau. ATP saat ini secara simultan selalu berusaha menjadi salah satu institusi akademik terpercaya bagi seluruh lapisan masyarakat. Memiliki komitmen kuat untuk menjembatani mahasiswa mencapai potensi tertingginya guna menyongsong masa depan cerah.\r\n\r\nAMIK Taruna Probolinggo terbukti telah mampu bersaing dalam skala nasional dengan memenangkan berbagai Program Hibah Kompetisi pengelolaan Perguruan Tinggi dari DIKTI (PHK-A1, PHK-PMP, PHK-K3, PP-PTS). Setiap tahun selalu ada mahasiswa yang mendapatkan beasiswa dari pemerintah berupa Beasiswa PPA dan Beasiswa BBP-PPA.\r\n\r\nTenaga Pengajar di AMIK Taruna Probolinggo merupakan dosen akademisi dan praktisi yang kompeten di bidangnya, berpengalaman lebih dari 20th di dunia industri pada bagian Akuntansi, Keuangan &amp; Pajak, Perancangan dan Pembuatan Aplikasi Bisnis serta ahli di bidang perangkat keras komputer. Siap membimbing dan mengembangkan bakat dan potensi mahasiswa dengan pendekatan teoritis dan praktis.\r\n\r\nLulusan terbaik AMIK Taruna telah terbukti mampu bersaing dan banyak menempati posisi penting di Instansi Pemerintah, BUMN dan di berbagai Instansi Swasta.\r\n\r\nLulusan AMIK Taruna Probolinggo dapat meneruskan ke jenjang pendidikan yang lebih tinggi ke Perguruan Tinggi lain (PTN atau Non PTN) sesuai dengan penyesuaian transfer SKS dan waktu tempuh yang wajar.');
/*!40000 ALTER TABLE `visi_misis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-09-24 19:41:26
