# Sistem Pengaduan Masyarakat (SIPMAS) - CodeIgniter 3

Aplikasi Community Complaint Management System (Sistem Pengelolaan Pengaduan Masyarakat) berbasis web yang dirancang untuk mempermudah komunikasi dan pelaporan keluhan dari masyarakat kepada instansi berwenang secara transparan dan teratur.

Aplikasi ini dibangun menggunakan framework **CodeIgniter 3**, basis data **MySQL**, dan template dashboard **SB Admin 2** berbasis **Bootstrap 4**.

---

## 🚀 Fitur Utama

Sistem ini memisahkan fungsionalitas berdasarkan 3 peran utama (**Masyarakat**, **Petugas**, dan **Admin**):

### 1. Peran Masyarakat (Citizen Role)
*   **Dashboard Statistik**: Ringkasan data pengaduan personal (Total Aduan, Pending, Proses, Selesai) dilengkapi diagram lingkaran (*Doughnut Chart*) interaktif.
*   **Tulis Pengaduan**: Membuat aduan baru secara instan dengan input laporan teks dan unggah foto bukti (Maksimal 2MB, format JPG/JPEG/PNG).
*   **Kelola Pengaduan**: Mengedit isi laporan atau membatalkan (hapus) pengaduan secara mandiri selama status pengaduan masih **Pending (0)**.
*   **Kotak Notifikasi**: Menerima pembaruan status aduan (*Real-Time*) secara asinkron lengkap dengan *pop-up Browser Notification*.

### 2. Peran Petugas (Staff Role)
*   **Dashboard Overview**: Monitoring total statistik laporan masuk dari seluruh masyarakat secara real-time.
*   **Verifikasi & Tanggapan**: Memproses laporan masuk untuk ditandai sebagai **Proses** (diterima) atau **Tolak** (ditolak) disertai penulisan umpan balik (deskripsi tanggapan).
*   **Penyelesaian Laporan**: Menandai laporan yang sedang diproses sebagai **Selesai** setelah keluhan di lapangan berhasil diatasi.
*   **Kotak Notifikasi**: Menerima pemberitahuan push instan setiap kali ada masyarakat yang mengirimkan pengaduan baru.

### 3. Peran Administrator (Admin Role)
*   **Semua Fitur Petugas**: Memiliki hak penuh untuk memverifikasi dan menanggapi laporan.
*   **Manajemen Petugas (CRUD)**: Mendaftarkan akun petugas atau administrator baru ke dalam sistem dengan validasi keunikan username.
*   **Generate Laporan PDF**: Mengekspor data pengaduan masyarakat ke dokumen PDF formal menggunakan integrasi engine **Dompdf** (dapat diunduh langsung atau dilihat inline di browser).

---

## 🛠️ Spesifikasi Teknologi

| Layer | Teknologi |
|---|---|
| **Framework PHP** | CodeIgniter 3.1.11+ (Mendukung PHP $\ge$ 5.3.7 hingga PHP 7.4) |
| **Basis Data** | MySQL (Koneksi via driver `mysqli`) |
| **PDF Renderer** | Dompdf ^0.8.5 (Wrapper kustom di `application/libraries/Pdf.php`) |
| **Frontend UI** | Bootstrap 4 + SB Admin 2 Dashboard Template |
| **Ikon & Font** | FontAwesome 5 Free & Google Fonts (Outfit, Plus Jakarta Sans) |
| **Visualisasi Data** | Chart.js (Doughnut Chart rendering) |

---

## 🔒 Fitur Keamanan (Security Stack)

Sistem ini dikonfigurasi dengan standar keamanan web berikut:
1.  **Pengamanan Sandi**: Kata sandi dienkripsi menggunakan hashing dinamis `password_hash()` dengan algoritma Bcrypt bawaan PHP dan dicocokkan dengan `password_verify()`.
2.  **Proteksi CSRF (Cross-Site Request Forgery)**: Token CSRF (`csrf_test_name`) diaktifkan secara global dan diregenerasi pada setiap pengiriman formulir POST untuk mencegah serangan pemalsuan request.
3.  **Penyaringan XSS Global**: Semua data masukan GET, POST, dan COOKIE disaring secara otomatis dari potensi injeksi skrip berbahaya (*Cross-Site Scripting*).
4.  **Enkripsi Unggahan**: Nama berkas foto yang diunggah oleh masyarakat akan dienkripsi secara acak (`encrypt_name = TRUE`) demi menghindari tabrakan nama file dan menutupi nama file asli di server.

---

## 📂 Peta Pengendali (Controller Map)

Sistem dikemas dengan struktur direktori controller yang terbagi rapi berdasarkan otorisasi peran:

```
application/controllers/
├── Auth/
│   ├── LoginController.php          # Login khusus masyarakat
│   ├── LoginPetugasController.php   # Login admin & petugas
│   ├── RegisterController.php       # Registrasi akun masyarakat
│   ├── LogoutController.php         # Penanganan keluar dari sistem
│   ├── ChangePasswordController.php # Halaman ganti password pengguna
│   └── BlockedController.php        # Halaman fallback akses ditolak
├── Admin/
│   ├── DashboardController.php      # Dashboard statistik admin & petugas
│   ├── TanggapanController.php      # Pemrosesan status pengaduan & input tanggapan
│   ├── PetugasController.php        # Manajemen CRUD petugas
│   └── LaporanController.php        # Ekspor laporan ke PDF via Dompdf
├── Masyarakat/
│   ├── DashboardController.php      # Dashboard statistik masyarakat
│   └── PengaduanController.php      # Pembuatan, edit, dan pembatalan aduan
├── User/
│   └── ProfileController.php        # Halaman kelola profil saya
├── NotifikasiController.php         # API Polling JSON notifikasi real-time
└── Welcome.php                      # Root controller (Redirect otomatis ke login)
```

---

## ⚙️ Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan proyek di server lokal (XAMPP / Apache):

### 1. Unduh / Clone Repositori
Tempatkan direktori proyek ini ke dalam folder root server lokal Anda (misalnya `C:\xampp\htdocs\` untuk pengguna XAMPP).

### 2. Konfigurasi Basis Data
1.  Buka aplikasi basis data Anda (seperti phpMyAdmin).
2.  Buat database baru dengan nama **`tary7`**.
3.  Impor berkas dump SQL utama: **`tary7.sql`**.
4.  Jalankan migrasi tambahan untuk tabel notifikasi dengan mengimpor berkas: **`database/migrasi_notifikasi.sql`**.

### 3. Pengaturan Kredensial Database
Sesuaikan konfigurasi koneksi basis data Anda (username & password MySQL) pada berkas:
📂 `application/config/database.php`

```php
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',        // ganti dengan username database Anda
    'password' => '',            // ganti dengan password database Anda
    'database' => 'tary7',
    'dbdriver' => 'mysqli',
    ...
);
```

### 4. Menjalankan Aplikasi
*   Pastikan modul **Apache** dan **MySQL** pada control panel XAMPP Anda dalam keadaan aktif.
*   Buka browser Anda dan akses tautan lokal:
    `http://localhost/pengaduan2/`

---

## 🔑 Akun Kredensial Bawaan (Default)

Gunakan akun di bawah ini untuk menguji fungsionalitas masing-masing peran pada sistem setelah instalasi:

| Peran (Role) | Username | Password |
|---|---|---|
| **Administrator** | `admin` | `admin` |
| **Petugas** | `petugas` | `petugas` |
| **Masyarakat** | `masyarakat` | `masyarakat` |
