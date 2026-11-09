# Pesantren Al-Ihsan

Sistem informasi pesantren modern berbasis Laravel 12 untuk mengelola santri, akademik, keuangan, asrama, kesehatan, dan operasional lembaga pendidikan.

## Fitur utama

- Manajemen data santri
- Master data kelas dan jurusan
- Kehadiran santri harian
- Nilai akademik
- Tagihan dan pembayaran
- Asrama santri
- Rekam medis dan kesehatan
- Dashboard laporan ringkasan
- Manajemen pengguna dan role akses
- Landing page institusi dan portal admin

## Teknologi

- Laravel 12
- PHP 8.3
- MySQL 8
- Tailwind CSS
- Vite
- Pest / Laravel test suite

## Persyaratan

- PHP 8.3+
- Composer
- MySQL / MariaDB
- Node.js dan npm
- Laravel CLI

## Setup lokal

1. Salin file environment:
   ```bash
   cp .env.example .env
   ```
2. Konfigurasi database di file `.env` sesuai setup lokal Anda.
3. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate
   ```
4. Install dependency frontend:
   ```bash
   npm install
   ```
5. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```
6. Untuk frontend build dev:
   ```bash
   npm run dev
   ```

## Verifikasi

Jalankan tes untuk memastikan seluruh modul berjalan:

```bash
php artisan test
```

## Produksi: hardening & deployment checklist

Sebelum deploy ke server produksi, pastikan checklist berikut telah dipenuhi:

1. Salin `.env.example` menjadi `.env` dan isi nilai sensitif seperti `APP_KEY`, `DB_*`, `MAIL_*`, dan `APP_URL`.
2. Pastikan `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` memakai HTTPS, dan `SESSION_SECURE_COOKIE=true`.
3. Generate APP key:
   ```bash
   php artisan key:generate
   ```
4. Jalankan cache produksi:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```
5. Set queue worker dan scheduler di server production.
6. Jalankan backup database secara terjadwal dengan script PowerShell di `scripts/backup-database.ps1`.
7. Aktifkan HTTPS, firewall, dan sertifikat TLS valid.
8. Pastikan `storage` dan `bootstrap/cache` writable oleh web server.
9. Pastikan `public/storage` tersinkron dengan `php artisan storage:link`.
10. Uji login, role admin, form submit, dan export data pada server yang benar-benar production.

## Struktur umum

- `app/` — logika aplikasi, model, controller, middleware
- `database/` — migration dan database schema
- `resources/views/` — UI halaman landing, admin, auth
- `routes/` — route aplikasi
- `public/` — aset publik seperti logo dan favicon
- `tests/` — test fitur aplikasi

## Catatan

Proyek ini telah dibuat sebagai sistem pesantren digital yang siap untuk demo, pengelolaan operasional, serta pengembangan lebih lanjut ke tahap produksi.


