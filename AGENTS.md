# AGENTS.md — Pengaduan Masyarakat

Community complaint management system built with CodeIgniter 3. UI in Indonesian.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | CodeIgniter 3 (PHP ≥5.3.7) |
| **Database** | MySQL via `mysqli` — database `tary7` |
| **PDF** | `dompdf/dompdf` ^0.8.5, custom wrapper at `application/libraries/Pdf.php` |
| **Frontend** | Bootstrap 4 + SB Admin 2 |

## Stale App

`pengaduan/` is a separate older instance (db `pengaduan_masyarakat_ci`). Do not edit. Root directory is the live one.

Root-level SQL dumps: `tary7.sql`, `tary6.sql`, `backup.sql`.

## Controller Map

```
Auth/       LoginController, LoginPetugasController, RegisterController,
            LogoutController, ChangePasswordController, BlockedController
Admin/      DashboardController, LaporanController, PetugasController, TanggapanController
Masyarakat/ PengaduanController
User/       ProfileController
NotifikasiController (root-level)
Welcome.php → redirects to Auth/LoginController
```

## Pengaduan Status Lifecycle

- `'0'` (pending) → `'proses'` → `'selesai'` or `'tolak'`
- Default for new complaints is `'0'`.
- `TanggapanController::tambah_tanggapan` sets `'proses'` or `'tolak'`.
- `TanggapanController::tanggapan_pengaduan_selesai` sets `'selesai'`.
- `PengaduanController::pengaduan_batal` (hard-delete) only allowed when status is `'0'`.

## Auth & Access Control

**Session:** `files` driver, `ci_session` cookie, 7200s expiry. **CSRF:** enabled (`csrf_test_name`), regenerated every submission. Use `form_open('Controller/method')` to auto-inject the hidden CSRF field. For AJAX POST, read the token from `csrf_test_name` cookie and send as POST param. **Passwords:** `password_hash()` / `password_verify()`.

| Role | Table | Login controller | Session keys | Block condition |
|------|-------|-----------------|---------------|----------------|
| Masyarakat | `masyarakat` | `LoginController` | `username` | `!empty($this->session->userdata('level'))` |
| Petugas | `petugas` | `LoginPetugasController` | `username`, `level` | `!$this->session->userdata('level')` |
| Admin | `petugas` | `LoginPetugasController` | `username`, `level` | `level != 'admin'` |

- `is_logged_in()` checks `username` session key — autoloaded via `auth_helper.php`.
- `masyarakat.username` has no DB unique constraint; `petugas.username` does. App enforces uniqueness across both tables via callback validation in `RegisterController` and `PetugasController`.
- `BlockedController` is the universal unauthorized fallback.
- `NotifikasiController::unread_json` returns JSON `{unread_count, unread[], last_id}`.

### Default Credentials

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin` |
| Petugas | `petugas` | `petugas` |
| Masyarakat | `masyarakat` | `masyarakat` |

## Config Quirks

| Setting | Value | Note |
|---------|-------|------|
| `global_xss_filtering` | `TRUE` | All input XSS-filtered |
| `csrf_regenerate` | `TRUE` | Token changes per POST |
| `composer_autoload` | `'vendor/autoload.php'` | Path relative to `index.php` |
| `encryption_key` | `''` (empty) | Encryption library non-functional |
| `base_url` | Dynamic | Auto-detected from `$_SERVER` |
| `index_page` | `''` | Clean URLs via `.htaccess` |
| `sess_save_path` | `NULL` | Defaults to system temp dir |

## Uploads

- Path: `assets/uploads/`, max 2MB, `jpeg|jpg|png`.
- Filenames encrypted (`encrypt_name = TRUE`).
- Old files deleted on re-upload (`PengaduanController::edit`).

## Notifikasi

`Notifikasi_m` model loaded directly in `backend_topbar_v.php` (not autoloaded). Migration at `database/migrasi_notifikasi.sql`.

| Trigger | Sender | Recipient |
|---------|--------|-----------|
| Masyarakat submits complaint | `masyarakat` | All staff (`untuk_level = 'all'`) |
| Petugas/admin responds (proses/tolak) | `petugas` | Specific masyarakat (`untuk_username`) |
| Petugas/admin marks selesai | `petugas` | Specific masyarakat (`untuk_username`) |

## PDF Library

`application/libraries/Pdf.php` extends `Dompdf\Dompdf`. Two methods:
- `load_view($view, $data)` — render inline
- `download($view, $data)` — force download

Used by `LaporanController` for report generation.

## POST-Only Methods

- `PengaduanController::pengaduan_batal($id)` — rejects non-POST
- `PetugasController::delete($id)` — rejects non-POST

## View Conventions

- Authenticated pages: `backend_head`, `backend_sidebar_v`, `backend_topbar_v`, *content*, `backend_footer_v`, `backend_foot`.
- Login/register pages: `login_head`, *content*, `login_footer`.
- Flashdata messages use Bootstrap 4 alert classes.
- All forms use `form_open('Controller/method')` for CSRF token injection.

## No Tooling

No test runner, linter, typechecker, CI, or pre-commit hooks. `phpunit 4.* || 5.*` in dev deps, zero tests exist.

## Dev Setup

1. Point Apache/XAMPP document root at project root
2. Import `tary7.sql` into MySQL (run `database/migrasi_notifikasi.sql` after if notifikasi table missing)
3. Update credentials in `application/config/database.php` if needed
4. Set `CI_ENV=production` for production
5. Run `composer install` only when adding PHP dependencies
