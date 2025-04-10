-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Feb 2023 pada 09.59
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umbks`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_admin`
--

CREATE TABLE `m_admin` (
  `id` int(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','guru','siswa') NOT NULL,
  `kon_id` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_admin`
--

INSERT INTO `m_admin` (`id`, `username`, `password`, `level`, `kon_id`) VALUES
(1, 'admin@admin.com', 'd3942dce589a8baf879be01b717184712b119a72', 'admin', 0),
(3, '2022', 'e575dccc71140754dd85beda5965b6a358150309', 'guru', 1),
(894, '1235', 'ac1ab23d6288711be64a25bf13432baf1e60b2bd', 'siswa', 7),
(893, '1234', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'siswa', 6),
(891, '2226812', '1878b7df193e47c23aa9a98c2d93eb975f7458df', 'siswa', 3),
(890, '2226645', 'a4fd24a15cbfc4da3e839215965147efc3425171', 'siswa', 4),
(889, '2220250', 'e0630b7bd861f59bf14103318e84a039ce6c0708', 'siswa', 2),
(895, '2220149', 'd11423452b7a6a09017137ce3b5266cc89e1d6f2', 'siswa', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_guru`
--

CREATE TABLE `m_guru` (
  `id` int(6) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_guru`
--

INSERT INTO `m_guru` (`id`, `nip`, `nama`) VALUES
(1, '2022', 'Herwan Prayitno, S. Pd.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jurusan`
--

CREATE TABLE `m_jurusan` (
  `id` int(6) NOT NULL,
  `jurusan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_jurusan`
--

INSERT INTO `m_jurusan` (`id`, `jurusan`) VALUES
(2, 'IPA'),
(5, 'UMUM'),
(6, 'IPS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kelas`
--

CREATE TABLE `m_kelas` (
  `id` int(6) NOT NULL,
  `kelas` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_kelas`
--

INSERT INTO `m_kelas` (`id`, `kelas`) VALUES
(1, 'X'),
(3, 'XI'),
(4, 'XII');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_lembaga`
--

CREATE TABLE `m_lembaga` (
  `lembaga_id` varchar(100) NOT NULL,
  `lembaga_jenjang` varchar(255) DEFAULT NULL,
  `lembaga_nsm` varchar(12) DEFAULT NULL,
  `lembaga_npsn` varchar(8) DEFAULT NULL,
  `lembaga_tahun` int(4) DEFAULT NULL,
  `lembaga_profile` varchar(255) DEFAULT NULL,
  `lembaga_alamat` text DEFAULT NULL,
  `lembaga_web` varchar(100) DEFAULT NULL,
  `lembaga_email` varchar(100) DEFAULT NULL,
  `lembaga_foto` varchar(255) DEFAULT NULL,
  `lembaga_ttd` varchar(255) DEFAULT NULL,
  `lembaga_kota` varchar(100) DEFAULT NULL,
  `lembaga_telp` varchar(20) DEFAULT NULL,
  `lembaga_pimpinan` varchar(255) DEFAULT NULL,
  `lembaga_pimpinan_nip` varchar(255) DEFAULT NULL,
  `lembaga_status` varchar(10) DEFAULT NULL,
  `tahunajaran_id` int(4) DEFAULT NULL,
  `semester_id` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_lembaga`
--

INSERT INTO `m_lembaga` (`lembaga_id`, `lembaga_jenjang`, `lembaga_nsm`, `lembaga_npsn`, `lembaga_tahun`, `lembaga_profile`, `lembaga_alamat`, `lembaga_web`, `lembaga_email`, `lembaga_foto`, `lembaga_ttd`, `lembaga_kota`, `lembaga_telp`, `lembaga_pimpinan`, `lembaga_pimpinan_nip`, `lembaga_status`, `tahunajaran_id`, `semester_id`) VALUES
('cntQ8KvHF7tH9nkpii4yP6fG1VhNmi9nZbiQsbpTn34JIEXKaGLIDkNCwfIvXJvnCtB3U39aMtD1f44WSVQ', 'MA', '141135120019', '30594640', 2022, 'MA BUSTANUL ARIFIN', 'Jl. Bawean nomor 106, Glugur - Lor - Pokaan', 'www.sman1pokaan.sch.id', 'office@sman1pokaan.sch.id', '22022023155615.png', '11122022213151.png', 'Pokaan', '081444561479', 'Achmad Hadi, S. Ag.', '198810262006041007', 'aktif', 2022, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_mapel`
--

CREATE TABLE `m_mapel` (
  `id` int(6) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_mapel`
--

INSERT INTO `m_mapel` (`id`, `nama`) VALUES
(1, 'SKI'),
(2, 'Alquran Hadist'),
(3, 'Akidah Akhlak'),
(4, 'Fiqih'),
(5, 'Pkn'),
(6, 'Bahasa Indonesia'),
(7, 'Bahasa Inggris'),
(8, 'Bahasa Arab'),
(9, 'Sejarah Indonesia'),
(10, 'Matematika Wajib'),
(11, 'Prakarya'),
(12, 'Seni Budaya'),
(13, 'Penjaskes'),
(14, 'Matematika (P)'),
(15, 'Fisika (P)'),
(16, 'Kimia (P)'),
(17, 'Biologi (P)'),
(18, 'Ekonomi (P)'),
(19, 'Geografi (P)'),
(20, 'Sosiologi (P)'),
(21, 'Sejarah (P)'),
(22, 'Informatika (LM)'),
(23, 'Ekonomi (LM)'),
(24, 'Biologi (LM)');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_ruang`
--

CREATE TABLE `m_ruang` (
  `ruang_id` int(11) NOT NULL,
  `ruang_nama` varchar(255) DEFAULT NULL,
  `ruang_server` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_ruang`
--

INSERT INTO `m_ruang` (`ruang_id`, `ruang_nama`, `ruang_server`) VALUES
(1, 'Ruang 1', 'P30112022 - AF5'),
(2, 'Ruang 2', 'P30112022 - AF3'),
(4, 'Ruang 3', 'P30112022 - AF4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_setting`
--

CREATE TABLE `m_setting` (
  `settings_id` int(11) NOT NULL,
  `lembaga_id` varchar(255) DEFAULT NULL,
  `aplikasi_nama` varchar(255) DEFAULT NULL,
  `aplikasi_versi` varchar(255) DEFAULT NULL,
  `ujian_nama` varchar(255) DEFAULT NULL,
  `ujian_tanggal` varchar(255) DEFAULT NULL,
  `ujian_nilai` tinyint(1) DEFAULT NULL,
  `ujian_opsi` int(1) DEFAULT NULL,
  `settings_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_setting`
--

INSERT INTO `m_setting` (`settings_id`, `lembaga_id`, `aplikasi_nama`, `aplikasi_versi`, `ujian_nama`, `ujian_tanggal`, `ujian_nilai`, `ujian_opsi`, `settings_status`) VALUES
(1, 'cntQ8KvHF7tH9nkpii4yP6fG1VhNmi9nZbiQsbpTn34JIEXKaGLIDkNCwfIvXJvnCtB3U39aMtD1f44WSVQ', 'AUMadrasah CBT', '5.0', 'PENILAIAN AKHIR SEMESTER (PAS)', 'Jepara, 28 Nopember 2022', 1, 5, 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_siswa`
--

CREATE TABLE `m_siswa` (
  `id` int(6) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nopes` varchar(255) DEFAULT NULL,
  `nim` varchar(50) DEFAULT NULL,
  `sandi` varchar(255) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `id_jurusan` varchar(100) DEFAULT NULL,
  `id_ruang` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `m_siswa`
--

INSERT INTO `m_siswa` (`id`, `nama`, `nopes`, `nim`, `sandi`, `jurusan`, `id_jurusan`, `id_ruang`) VALUES
(1, 'FADLAN FAIRUS', '2210551', '2220149', '2220149', 'X', 'IPA', NULL),
(2, 'FADLI FIRDAUS', '2210552', '2220250', '2220250', 'X', 'IPA', NULL),
(3, 'SANTI NOER HOLIFA', '2211551', '2226812', '2226812', 'XI', 'IPA', NULL),
(4, 'MUHAMMAD AKMAL ANAS', '2212551', '2226645', '2226645', 'XII', 'IPA', NULL),
(6, 'ARIF RAHMAN HAKIM', '202201011994', '1234', '1234', 'X', 'IPA', NULL),
(7, 'Akhmad Yasin Saputra', '202201011999', '1235', '1235', 'X', 'IPA', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_soal`
--

CREATE TABLE `m_soal` (
  `id` int(6) NOT NULL,
  `id_guru` int(6) NOT NULL,
  `id_mapel` int(6) NOT NULL,
  `id_kelas` int(6) NOT NULL,
  `bobot` int(2) DEFAULT NULL,
  `file` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipe_file` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jenis_soal` enum('multiple','quick','essay') COLLATE utf8_unicode_ci DEFAULT NULL,
  `soal` longtext CHARACTER SET utf8 DEFAULT NULL,
  `opsi_a` longtext CHARACTER SET utf8 DEFAULT NULL,
  `opsi_b` longtext CHARACTER SET utf8 DEFAULT NULL,
  `opsi_c` longtext CHARACTER SET utf8 DEFAULT NULL,
  `opsi_d` longtext CHARACTER SET utf8 DEFAULT NULL,
  `opsi_e` longtext CHARACTER SET utf8 DEFAULT NULL,
  `jawaban` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `jml_benar` int(6) DEFAULT NULL,
  `jml_salah` int(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `m_soal`
--

INSERT INTO `m_soal` (`id`, `id_guru`, `id_mapel`, `id_kelas`, `bobot`, `file`, `tipe_file`, `jenis_soal`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `jawaban`, `tgl_input`, `jml_benar`, `jml_salah`) VALUES
(1, 1, 3, 1, 1, NULL, NULL, 'multiple', '<p>Sebelum diterima kerja di sebuah perusahaan, biasanya kamu akan diminta untuk melakukan sejumlah tes, salah satunya psikotes. Nah, untuk mempersiapkan diri, kamu bisa mulai membaca-baca atau latihan mengerjakan tes psikotes online.</p>\r\n', '#####<p>opsi A.1</p>\r\n', '#####<p>opsi B.1</p>\r\n', '#####<p>opsi C.1</p>\r\n', '#####<p>opsi D.1</p>\r\n', '#####<p>opsi E.1</p>\r\n', 'A', '2022-12-04 01:19:21', 6, 21),
(2, 1, 3, 1, 1, NULL, NULL, 'multiple', '<p>Sebelum diterima kerja di sebuah perusahaan, biasanya kamu akan diminta untuk melakukan sejumlah tes, salah satunya psikotes. Nah, untuk mempersiapkan diri, kamu bisa mulai membaca-baca atau latihan mengerjakan tes psikotes online.</p>\r\n', '#####<p>opsi A.2</p>\r\n', '#####<p>opsi B.2</p>\r\n', '#####<p>opsi C.2</p>\r\n', '#####<p>opsi D.2</p>\r\n', '#####<p>opsi E.2</p>\r\n', 'A', '2022-12-04 01:19:14', 3, 24),
(3, 1, 3, 1, 4, NULL, NULL, 'multiple', '<p>Sebelum diterima kerja di sebuah perusahaan, biasanya kamu akan diminta untuk melakukan sejumlah tes, salah satunya psikotes. Nah, untuk mempersiapkan diri, kamu bisa mulai membaca-baca atau latihan mengerjakan tes psikotes online.</p>\r\n', '#####<p>opsi A.3</p>\r\n', '#####<p>opsi B.3</p>\r\n', '#####<p>opsi C.3</p>\r\n', '#####<p>opsi D.3</p>\r\n', '#####<p>opsi E.3</p>\r\n', 'A', '2022-12-04 01:19:06', 22, 5),
(4, 1, 3, 1, 4, NULL, NULL, 'multiple', '<p>Dalam tes ini, seseorang dihadapkan pada soal-soal berbentuk gambar atau tulisan yang tersedia dalam enam kotak. Kemudian peserta yang mengerjakan soal diminta melanjutkan gambar tersebut dengan ilustrasi yang terpikir oleh mereka. Ini digunakan untuk menilai seberapa kreatif dan dinamis pola pikir seseorang.</p>\r\n', '#####<p>opsi A.4</p>\r\n', '#####<p>opsi B.4</p>\r\n', '#####<p>opsi C.4</p>\r\n', '#####<p>opsi D.4</p>\r\n', '#####<p>opsi E.4</p>\r\n', 'A', '2022-12-04 01:13:34', 5, 22),
(5, 1, 3, 1, 5, NULL, NULL, 'multiple', '<p>Dalam tes ini, seseorang dihadapkan pada soal-soal berbentuk gambar atau tulisan yang tersedia dalam enam kotak. Kemudian peserta yang mengerjakan soal diminta melanjutkan gambar tersebut dengan ilustrasi yang terpikir oleh mereka. Ini digunakan untuk menilai seberapa kreatif dan dinamis pola pikir seseorang.</p>\r\n', '#####<p>opsi A.5</p>\r\n', '#####<p>opsi B.5</p>\r\n', '#####<p>opsi C.5</p>\r\n', '#####<p>opsi D.5</p>\r\n', '#####<p>opsi E.5</p>\r\n', 'A', '2022-12-04 01:13:22', 21, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_guru_mapel`
--

CREATE TABLE `tr_guru_mapel` (
  `id` int(6) NOT NULL,
  `id_guru` int(6) NOT NULL,
  `id_mapel` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_guru_mapel`
--

INSERT INTO `tr_guru_mapel` (`id`, `id_guru`, `id_mapel`) VALUES
(1, 1, 3),
(2, 1, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_guru_tes`
--

CREATE TABLE `tr_guru_tes` (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_guru` int(6) NOT NULL,
  `id_mapel` int(6) NOT NULL,
  `nama_ujian` varchar(200) NOT NULL,
  `jumlah_soal` int(6) NOT NULL,
  `kelas` varchar(200) NOT NULL,
  `jurusan` varchar(200) NOT NULL,
  `waktu` int(6) NOT NULL,
  `waktu_submit` int(6) NOT NULL,
  `jenis` enum('acak','set') NOT NULL,
  `detil_jenis` varchar(500) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `terlambat` datetime NOT NULL,
  `token` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_guru_tes`
--

INSERT INTO `tr_guru_tes` (`id`, `id_guru`, `id_mapel`, `nama_ujian`, `jumlah_soal`, `kelas`, `jurusan`, `waktu`, `waktu_submit`, `jenis`, `detil_jenis`, `tgl_mulai`, `terlambat`, `token`) VALUES
('387249156', 1, 3, 'GLADI BERSIH', 5, 'X', 'IPA', 90, 89, 'acak', '', '2022-12-11 20:58:00', '2022-12-31 21:04:00', 'FEGRH');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_ikut_ujian`
--

CREATE TABLE `tr_ikut_ujian` (
  `id` int(6) NOT NULL,
  `id_tes` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(6) NOT NULL,
  `list_soal` longtext DEFAULT NULL,
  `list_jawaban` longtext DEFAULT NULL,
  `jml_benar` int(6) DEFAULT NULL,
  `nilai` decimal(10,2) DEFAULT NULL,
  `nilai_bobot` decimal(10,2) DEFAULT NULL,
  `tgl_mulai` datetime DEFAULT NULL,
  `tgl_selesai` datetime DEFAULT NULL,
  `tgl_submit` datetime DEFAULT NULL,
  `status` enum('Y','N') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tr_ikut_ujian`
--

INSERT INTO `tr_ikut_ujian` (`id`, `id_tes`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `tgl_submit`, `status`) VALUES
(33, '387249156', 7, '5,1,3,4,2', '5:A:N,1:A:N,3:A:N,4:A:N,2:A:N', 5, '100.00', '100.00', '2022-12-18 20:13:17', '2022-12-18 21:43:17', '2022-12-18 20:14:17', 'N');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `m_admin`
--
ALTER TABLE `m_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kon_id` (`kon_id`);

--
-- Indeks untuk tabel `m_guru`
--
ALTER TABLE `m_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_jurusan`
--
ALTER TABLE `m_jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_lembaga`
--
ALTER TABLE `m_lembaga`
  ADD PRIMARY KEY (`lembaga_id`);

--
-- Indeks untuk tabel `m_mapel`
--
ALTER TABLE `m_mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_ruang`
--
ALTER TABLE `m_ruang`
  ADD PRIMARY KEY (`ruang_id`);

--
-- Indeks untuk tabel `m_setting`
--
ALTER TABLE `m_setting`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indeks untuk tabel `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_soal`
--
ALTER TABLE `m_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tr_guru_mapel`
--
ALTER TABLE `tr_guru_mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indeks untuk tabel `tr_guru_tes`
--
ALTER TABLE `tr_guru_tes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indeks untuk tabel `tr_ikut_ujian`
--
ALTER TABLE `tr_ikut_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tes` (`id_tes`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `m_admin`
--
ALTER TABLE `m_admin`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=896;

--
-- AUTO_INCREMENT untuk tabel `m_guru`
--
ALTER TABLE `m_guru`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `m_jurusan`
--
ALTER TABLE `m_jurusan`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `m_mapel`
--
ALTER TABLE `m_mapel`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `m_ruang`
--
ALTER TABLE `m_ruang`
  MODIFY `ruang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `m_setting`
--
ALTER TABLE `m_setting`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `m_siswa`
--
ALTER TABLE `m_siswa`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `m_soal`
--
ALTER TABLE `m_soal`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tr_guru_mapel`
--
ALTER TABLE `tr_guru_mapel`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tr_ikut_ujian`
--
ALTER TABLE `tr_ikut_ujian`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
