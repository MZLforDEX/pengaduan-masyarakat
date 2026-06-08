-- Migration: tambah tabel notifikasi ke database tary7
-- Jalankan setelah mengupdate kode

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `id_pengaduan` bigint(16) NOT NULL,
  `dari_username` varchar(25) NOT NULL,
  `untuk_username` varchar(25) DEFAULT NULL,
  `untuk_level` varchar(25) DEFAULT NULL,
  `isi` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_read` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`);

ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
