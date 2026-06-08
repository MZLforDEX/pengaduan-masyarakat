# Analisis Alur Sistem Pengaduan Masyarakat (Laporan Rinci)

Dokumen ini disusun secara formal untuk kebutuhan penulisan laporan proyek, Laporan Kerja Praktek (KP/PKL), Tugas Akhir (TA), atau Skripsi. Alur sistem ini menjelaskan detail teknis dari arsitektur backend, sistem keamanan, kontrol akses (autentikasi), hingga siklus hidup data (*data lifecycle*) di dalam sistem.

---

## 1. Arsitektur Sistem & Kontrol Akses (Security & Auth)

Sistem ini dibangun menggunakan framework **CodeIgniter 3** dengan pembagian hak akses (role) yang ketat melalui sesi (*session*).

### A. Tabel Pengguna & Validasi Kredensial
Sistem mendistribusikan data pengguna ke dalam dua tabel terpisah di database MySQL `tary7`:
*   **Masyarakat**: Disimpan di tabel `masyarakat` dengan kolom kunci utama `nik`.
*   **Petugas & Admin**: Disimpan di tabel `petugas` dengan kolom kunci utama `id_petugas` dan pembeda level melalui kolom `level` (`admin` / `petugas`).

| Peran (Role) | Tabel Database | Pengendali (Controller) Login | Kunci Sesi (Session Keys) | Kondisi Blokir Akses (Unauthorized) |
| :--- | :--- | :--- | :--- | :--- |
| **Masyarakat** | `masyarakat` | `LoginController` | `username` | Jika level session tidak kosong (`!empty(level)`) |
| **Petugas** | `petugas` | `LoginPetugasController` | `username`, `level` | Jika level session kosong (`!level`) |
| **Admin** | `petugas` | `LoginPetugasController` | `username`, `level` | Jika level session bukan `'admin'` |

Setiap akses halaman autentikasi divalidasi oleh fungsi `is_logged_in()` yang terdaftar dalam berkas pembantu `auth_helper.php`. Pengguna yang tidak memiliki wewenang akan secara otomatis diarahkan ke `BlockedController` (halaman akses ditolak).

### B. Mekanisme Keamanan Sistem
1.  **Enkripsi Kata Sandi**: Penguncian kata sandi menggunakan fungsi bawaan PHP `password_hash()` pada saat registrasi dan divalidasi dengan `password_verify()` saat login.
2.  **Proteksi CSRF (Cross-Site Request Forgery)**: Diaktifkan secara global melalui konfigurasi `$config['csrf_regenerate'] = TRUE`. Token CSRF (`csrf_test_name`) berganti pada setiap pengiriman formulir POST. Formulir dibuat menggunakan fungsi `form_open()` untuk menyuntikkan token tersembunyi secara otomatis.
3.  **Penyaringan XSS Global**: Diaktifkan melalui `$config['global_xss_filtering'] = TRUE` guna mensterilkan seluruh input data dari skrip berbahaya.
4.  **Validasi Unik Lintas Tabel**: Meskipun kolom `username` pada tabel `masyarakat` secara fisik tidak memiliki indeks *unique constraint* di skema basis data, sistem menerapkan aturan keunikan *username* secara dinamis di tingkat aplikasi. Validasi ini diproses melalui fungsi callback pada validator form di `RegisterController` (pendaftaran masyarakat) dan `PetugasController` (pembuatan akun petugas oleh admin).

---

## 2. Alur Kerja Registrasi & Login

### A. Alur Registrasi Masyarakat
1.  Masyarakat mengakses halaman registrasi (`RegisterController`).
2.  Masyarakat memasukkan data berupa **NIK, Nama, Username, Password, dan Nomor Telepon**.
3.  Sistem melakukan validasi formulir:
    *   Memastikan semua kolom terisi dengan benar.
    *   Memeriksa apakah `username` yang dimasukkan sudah digunakan oleh pengguna lain di tabel `masyarakat` maupun tabel `petugas`.
4.  Jika validasi gagal, sistem mengembalikan pengguna ke halaman registrasi dengan pesan error.
5.  Jika validasi sukses, kata sandi dienkripsi menggunakan `password_hash()` dengan algoritma *default* bcrypt.
6.  Sistem menyimpan data ke tabel `masyarakat` dan menampilkan pesan sukses (flashdata), kemudian mengarahkan pengguna ke halaman Login.

### B. Alur Login Pengguna
1.  Pengguna mengakses halaman login yang sesuai:
    *   `LoginController` untuk Masyarakat.
    *   `LoginPetugasController` untuk Admin dan Petugas.
2.  Pengguna menginput `username` dan `password`.
3.  Sistem memverifikasi akun:
    *   Untuk masyarakat: Mencari baris data di tabel `masyarakat` berdasarkan `username`.
    *   Untuk petugas/admin: Mencari baris data di tabel `petugas` berdasarkan `username`.
4.  Sistem mencocokkan kata sandi menggunakan `password_verify()`.
5.  Jika kredensial valid, sistem membuat sesi aktif (*session storage*) dengan masa kedaluwarsa 2 jam (7200 detik).
6.  Pengguna diarahkan ke halaman Dashboard masing-masing peran.

---

## 3. Alur Kerja Pengelolaan Pengaduan (Citizen Flow)

Siklus hidup pengaduan diawali dari laporan yang dikirimkan oleh Masyarakat.

```
[Masyarakat Kirim Laporan] 
         │
         ▼
[Status: '0' (Pending)] ──(Bisa Diedit / Dibatalkan oleh Masyarakat)
         │
         ├──────────────────────────┐
         ▼ (Oleh Petugas)            ▼ (Oleh Petugas)
[Status: 'proses']          [Status: 'tolak']
         │                          │
         ▼ (Oleh Petugas)            ▼
[Status: 'selesai']         [Pengaduan Berakhir]
```

### A. Proses Pembuatan Pengaduan
1.  Masyarakat masuk ke menu Pengaduan (`PengaduanController/index`).
2.  Masyarakat mengisi formulir **Isi Laporan** dan mengunggah **Foto Bukti**.
3.  Sistem memproses berkas foto melalui library `Upload` dengan ketentuan:
    *   Direktori penyimpanan: `assets/uploads/`
    *   Format berkas yang diizinkan: `jpeg`, `jpg`, dan `png`.
    *   Ukuran maksimal berkas: 2 Megabyte (2048 KB).
    *   Enkripsi nama file diaktifkan (`encrypt_name = TRUE`) untuk menghindari nama berkas duplikat dan menutupi nama berkas asli dari celah keamanan.
4.  Jika unggahan foto gagal, proses dihentikan dan sistem menampilkan pesan peringatan.
5.  Jika berhasil, data disimpan ke tabel `pengaduan` dengan nilai default kolom `status` adalah `'0'` (Pending).
6.  Sistem memicu pembuatan notifikasi baru di database melalui `Notifikasi_m->create()`:
    *   `dari_username` = Username pengirim (Masyarakat).
    *   `untuk_level` = `'all'` (ditujukan kepada seluruh jajaran admin dan petugas).
    *   `isi` = `"Pengaduan baru dari [Nama Masyarakat]"`
7.  Masyarakat menerima konfirmasi sukses.

### B. Proses Pembatalan & Modifikasi Laporan
*   **Pembatalan (Hapus)**: 
    Masyarakat dapat membatalkan pengaduan melalui fungsi `pengaduan_batal($id)`. Metode ini wajib dikirim via metode request **POST**. Sistem akan melakukan pengecekan:
    *   Apakah pengaduan tersebut benar milik NIK masyarakat yang sedang login.
    *   Apakah kolom `status` pengaduan masih bernilai `'0'`.
    *   Jika terpenuhi, sistem menghapus rekaman di tabel `pengaduan`, menghapus berkas foto terkait dari folder penyimpanan server (`unlink()`), dan memperbarui halaman.
*   **Modifikasi (Edit)**: 
    Masyarakat dapat mengubah isi laporan atau mengganti foto bukti melalui fungsi `edit($id)`. Sama halnya dengan pembatalan, pengaduan hanya bisa diedit jika statusnya masih `'0'`. Jika masyarakat mengunggah foto baru, sistem secara otomatis menghapus file foto yang lama di server sebelum menyimpan nama foto baru.

---

## 4. Alur Kerja Pemrosesan & Tanggapan (Staff/Admin Flow)

### A. Memberikan Tanggapan Awal (Proses / Tolak)
1.  Petugas atau Admin masuk ke Panel Tanggapan (`TanggapanController`).
2.  Sistem memuat daftar pengaduan dari database yang berstatus `'0'`.
3.  Petugas memilih salah satu laporan dan membuka formulir detail tanggapan.
4.  Petugas mengisi **Isi Tanggapan** dan memilih tindak lanjut status:
    *   **Proses**: Digunakan jika laporan diterima dan segera ditindaklanjuti.
    *   **Tolak**: Digunakan jika laporan tidak valid atau tidak memenuhi syarat.
5.  Sistem menyimpan data ke tabel `tanggapan` yang mencatat tanggal tanggapan, isi tanggapan, serta ID petugas yang menangani.
6.  Sistem memperbarui kolom `status` di tabel `pengaduan` menjadi `'proses'` atau `'tolak'`.
7.  Sistem memicu pembuatan notifikasi khusus:
    *   `dari_username` = Username Petugas.
    *   `untuk_username` = Username Masyarakat (pemilik laporan).
    *   `isi` = `"Pengaduan Anda sedang diproses"` ATAU `"Pengaduan Anda ditolak"`.

### B. Menyelesaikan Laporan (Mark as Selesai)
1.  Untuk laporan yang berstatus `'proses'`, setelah pekerjaan lapangan selesai dilakukan, Petugas/Admin dapat menandai laporan tersebut sebagai rampung melalui fungsi `tanggapan_pengaduan_selesai()`.
2.  Sistem mengubah kolom `status` pada tabel `pengaduan` menjadi `'selesai'`.
3.  Sistem memicu pembuatan notifikasi akhir ke masyarakat:
    *   `dari_username` = Username Petugas.
    *   `untuk_username` = Username Masyarakat.
    *   `isi` = `"Pengaduan Anda telah selesai diproses"`.

---

## 5. Alur Kerja Pembuatan Laporan PDF (Khusus Admin)

1.  Admin mengakses menu Laporan (`LaporanController`).
2.  Admin menentukan filter data (jika ada) dan menekan tombol cetak/ekspor.
3.  Sistem memanggil model `Pengaduan_m` untuk mengambil data pengaduan beserta tanggapan terkait dari database.
4.  Sistem memuat berkas template view laporan dan memasukkan data tersebut ke dalamnya.
5.  Sistem memanggil library kustom `application/libraries/Pdf.php` yang memperluas fungsionalitas engine **Dompdf**:
    *   Sistem dapat memanggil fungsi `load_view($view, $data)` untuk menampilkan dokumen PDF langsung pada tab browser pengguna (*inline stream*).
    *   Sistem dapat memanggil fungsi `download($view, $data)` untuk memaksa peramban mengunduh berkas laporan dalam format PDF secara instan.

---

## 6. Alur Sistem Notifikasi Real-Time (Polling JSON)

Sistem notifikasi pada aplikasi ini berjalan secara asinkron di bagian atas halaman (*topbar* / `backend_topbar_v.php`):
1.  Model `Notifikasi_m` tidak dimuat secara global melalui autoload, melainkan dipanggil secara langsung di view navigasi atas.
2.  Script JavaScript pada halaman dashboard melakukan pemanggilan AJAX secara berkala (*polling*) ke fungsi `NotifikasiController::unread_json`.
3.  Sistem merespons dengan format JSON yang berisi:
    *   `unread_count` (jumlah notifikasi yang belum dibaca).
    *   `unread` (array objek notifikasi yang berisi pengirim, pesan, url tujuan, dan waktu pembuatan).
    *   `last_id` (ID notifikasi terakhir untuk pembanding status).
4.  Notifikasi ditampilkan pada lonceng notifikasi di antarmuka web, memudahkan komunikasi dua arah antara masyarakat dan aparatur petugas.
