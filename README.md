# E-Commerce Unit Produksi Sekolah

Platform e-commerce dan layanan jasa print berbasis web untuk Unit Produksi (UP) sekolah. Dibangun dengan CodeIgniter 4, Tailwind CSS, dan Preline UI.

## Fitur Utama

**Untuk Customer**
- Registrasi & login (email/password dan Google OAuth)
- Verifikasi email sebelum login
- Katalog produk dengan pencarian, filter kategori, dan sorting
- Keranjang belanja (persist di database untuk user login, sesi untuk tamu)
- Wishlist produk
- Pemesanan dengan validasi stok real-time
- Jasa cetak dokumen (PDF/DOCX/XLSX, maks. 10MB) dengan kalkulasi harga dinamis
- Kode kupon/diskon (persentase maupun nominal)
- Riwayat pesanan dan tracking status
- Ulasan & rating produk
- Notifikasi in-app

**Untuk Admin / Petugas**
- Dashboard analitik (pendapatan, produk terlaris, stok menipis)
- Manajemen produk (CRUD, multi-foto, toggle tampil/sembunyikan)
- Manajemen kategori dan kupon
- Verifikasi pesanan print (jumlah halaman, rekap harga)
- Ekspor laporan ke CSV
- Konfigurasi info toko, jam operasional, dan harga cetak
- Mode maintenance website
- Manajemen akun petugas

**Keamanan**
- Proteksi XSS (`esc()` di seluruh view)
- CSRF token session-based di setiap form POST
- Rate limiting: 5 percobaan login gagal per 10 menit
- Validasi MIME type & rename acak untuk file upload
- `FOR UPDATE` lock pada stok saat checkout (race condition guard)
- Database transaction untuk operasi multi-tabel
- Soft delete untuk produk dan kategori
- Session timeout 2 jam, cookie HTTP-only & Secure

**Otomasi (Cron Job)**
- Auto-cancel pesanan yang belum dibayar setelah 24 jam (stok dikembalikan, kupon direfund)
- Hapus otomatis file print setelah 72 jam pesanan selesai

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Framework | CodeIgniter 4.7.3 |
| PHP | 8.2+ |
| Database | MySQL / MariaDB (InnoDB, utf8mb4) |
| CSS | Tailwind CSS 3.4 |
| Komponen UI | Preline UI 2.0.3 |
| Session Storage | Database (tabel `ci_sessions`) |
| Email | Gmail SMTP (TLS, port 587) |
| Deployment Target | cPanel shared hosting |

---

## Prasyarat

- PHP 8.2+ dengan ekstensi: `intl`, `mbstring`, `openssl`, `json`, `mysqlnd`
- MySQL 5.7+ / MariaDB 10.4+
- Composer 2.x
- Node.js 18+ & npm (untuk build Tailwind CSS)
- XAMPP / Laragon (lokal) atau cPanel (produksi)

---

## Instalasi Lokal

### 1. Clone & Install Dependensi

```bash
cd C:/xampp/htdocs
git clone <repo-url> web-app
cd web-app

composer install
npm install
```

### 2. Konfigurasi Environment

```bash
cp env .env
```

Edit file `.env`:

```ini
CI_ENVIRONMENT = development
app.baseURL = http://localhost/web-app/public/

database.default.hostname = localhost
database.default.database = ecommerce_up
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

encryption.key = <generate dengan: php spark key:generate>

email.SMTPHost = smtp.gmail.com
email.SMTPUser = your-email@gmail.com
email.SMTPPass = your-app-password
email.SMTPPort = 587
```

Untuk Google OAuth (opsional), tambahkan:

```ini
app.googleClientId = <client-id>
app.googleClientSecret = <client-secret>
app.googleRedirectUri = http://localhost/web-app/public/auth/google/callback
```

### 3. Buat Database & Jalankan Migrasi

```bash
# Buat database terlebih dahulu di phpMyAdmin atau CLI
mysql -u root -e "CREATE DATABASE ecommerce_up CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Jalankan migrasi (25 tabel)
php spark migrate

# (Opsional) Seed data awal
php spark db:seed DatabaseSeeder
```

### 4. Build CSS

```bash
# Build sekali
npm run build:css

# Watch mode (development)
npm run watch:css
```

### 5. Generate Encryption Key

```bash
php spark key:generate
```

### 6. Akses Aplikasi

Buka browser: `http://localhost/web-app/public/`

---

## Struktur Direktori

```
web-app/
├── app/
│   ├── Commands/          # CLI commands (cron jobs)
│   ├── Config/            # Konfigurasi app, routes, filter, email
│   ├── Controllers/
│   │   ├── Auth/          # Login, Register, Password reset
│   │   ├── Customer/      # Catalog, Cart, Checkout, Orders, Print, Profile
│   │   └── Admin/         # Dashboard, Products, Orders, Reports, dll.
│   ├── Database/
│   │   └── Migrations/    # 25 file migrasi tabel
│   ├── Filters/           # AuthFilter, AdminOnly, Maintenance
│   ├── Models/            # 14 model (User, Product, Order, Cart, dll.)
│   └── Views/
│       ├── auth/          # Login, register, reset password
│       ├── customer/      # Halaman-halaman customer
│       ├── admin/         # Halaman-halaman admin
│       ├── emails/        # Template email transaksional
│       ├── layouts/       # Layout utama (main, admin, auth, landing)
│       └── partials/      # Navbar, footer, flash messages
├── public/
│   ├── assets/
│   │   ├── css/style.css  # Output Tailwind (jangan edit manual)
│   │   ├── img/           # Gambar produk & hero
│   │   └── js/            # Preline UI & script kustom
│   └── index.php          # Web root (document root diarahkan ke sini)
├── writable/
│   └── uploads/documents/ # File upload cetak (tidak dapat diakses langsung)
├── tailwind.config.js
├── composer.json
└── package.json
```

---

## Cron Job

Setup cron job di server (cPanel → Cron Jobs):

```bash
# Auto-cancel pesanan expired — setiap jam
0 * * * * /usr/bin/php /home/<user>/public_html/spark cancel:expired-orders >> /dev/null 2>&1

# Hapus file print lama — setiap hari pukul 02.00
0 2 * * * /usr/bin/php /home/<user>/public_html/spark clean:print-files >> /dev/null 2>&1
```

---

## Deploy ke cPanel

1. Upload semua file ke `public_html/` (atau subdirektori).
2. Set **document root** ke folder `public/`.
3. Set `CI_ENVIRONMENT = production` di `.env`.
4. Aktifkan `app.forceGlobalSecureRequests = true` (HTTPS wajib).
5. Pastikan folder `writable/` dapat ditulis oleh web server (`chmod 775`).
6. Jalankan migrasi via SSH: `php spark migrate`.
7. Setup cron job seperti di atas.

---

## Role Pengguna

| Role | Akses |
|---|---|
| `customer` | Katalog, cart, checkout, orders, print, profil |
| `petugas` | Semua halaman admin (kecuali manajemen petugas) |
| `admin` | Semua akses termasuk manajemen petugas & konfigurasi toko |

---

## Alur Status Pesanan

```
Pending → Diproses → Selesai
    └──────────────→ Dibatalkan
```

- **Pending**: Pesanan dibuat, menunggu konfirmasi admin.
- **Diproses**: Admin mengkonfirmasi, pesanan sedang disiapkan.
- **Selesai**: Pesanan telah diserahkan ke customer.
- **Dibatalkan**: Dibatalkan oleh customer atau auto-cancel setelah 24 jam tanpa konfirmasi.

---

## Lisensi

Proyek ini dikembangkan untuk keperluan internal Unit Produksi sekolah. Tidak untuk distribusi komersial.
