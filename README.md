# 📁 Arsip Surat Digital — Kantor Desa Teluk Kapuas

Aplikasi **Arsip Surat Digital** adalah sistem manajemen arsip surat masuk dan surat keluar berbasis web yang dikembangkan khusus untuk kebutuhan administrasi desa. Dibangun dengan teknologi modern menggunakan **Laravel 12**, **Livewire 4**, dan **Tailwind CSS 4**, aplikasi ini menyediakan antarmuka yang responsif, interaktif, dan mudah digunakan untuk mengelola dokumen-dokumen penting kantor desa secara efisien dan terstruktur.

---

## ✨ Fitur Utama

| Modul | Deskripsi |
|-------|-----------|
| **🔐 Autentikasi** | Login, logout, lupa password, dan reset password dengan fitur riwayat aktivitas otomatis. |
| **📊 Dashboard** | Tampilan ringkasan statistik surat masuk, surat keluar, jenis surat, dan aktivitas terkini secara real-time. |
| **📥 Surat Masuk** | Kelola surat masuk lengkap dengan fitur tambah, edit, detail, hapus (soft delete), unggah file, dan filter pencarian. |
| **📤 Surat Keluar** | Kelola surat keluar dengan fitur yang sama lengkapnya seperti surat masuk. |
| **🏷️ Jenis Surat** | Pengelompokan dan manajemen kategori jenis surat untuk klasifikasi dokumen. |
| **🖼️ Galeri Surat** | Tampilan galeri visual dari seluruh dokumen surat yang telah diarsipkan. |
| **📑 Laporan** | Generasi laporan arsip surat untuk kebutuhan evaluasi dan pelaporan administrasi. |
| **👤 Manajemen Pengguna** | Pengaturan akun pengguna sistem dengan informasi jabatan dan foto profil. |
| **📜 Riwayat Aktivitas** | Pencatatan log aktivitas pengguna (login, logout, reset password, CRUD) secara otomatis. |

---

## 🛠️ Teknologi & Dependensi

### Backend
| Paket | Versi | Keterangan |
|-------|-------|------------|
| PHP | `^8.2` | Bahasa pemrograman server-side |
| Laravel Framework | `^12.0` | Framework PHP utama |
| Livewire | `^4.2` | Library full-stack framework untuk komponen dinamis tanpa JavaScript tambahan |
| Laravel Tinker | `^2.10.1` | REPL interaktif untuk Laravel |

### Frontend
| Paket | Versi | Keterangan |
|-------|-------|------------|
| Tailwind CSS | `^4.2.2` | Framework CSS utility-first |
| Vite | `^7.0.7` | Build tool dan dev server |
| Laravel Vite Plugin | `^2.0.0` | Integrasi Vite untuk Laravel |
| Axios | `^1.11.0` | HTTP client untuk request asynchronous |

### Development & Testing
| Paket | Versi | Keterangan |
|-------|-------|------------|
| PHPUnit | `^11.5.50` | Framework unit testing |
| Faker | `^1.23` | Generator data dummy untuk testing |
| Laravel Pint | `^1.24` | PHP code style fixer |
| Laravel Sail | `^1.41` | Docker development environment |
| Mockery | `^1.6` | Mocking framework untuk testing |
| Collision | `^8.6` | Error handler dengan tampilan yang lebih baik |

---

## 📋 Prasyarat Sistem

Sebelum melakukan instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

- **PHP** >= 8.2 dengan ekstensi: `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- **Composer** >= 2.6
- **Node.js** >= 18.0 & **NPM** >= 9.0
- **Database Server**: MySQL >= 8.0 / MariaDB >= 10.6 / PostgreSQL >= 14 / SQLite 3
- **Web Server**: Apache/Nginx (dengan mod_rewrite enabled untuk Apache)

---

## 🚀 Tata Cara Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di lingkungan lokal Anda.

### 1. Clone Repository

```bash
git clone https://github.com/username/arsip-surat-desa.git
cd arsip-surat-desa
```

> **Catatan:** Ganti `https://github.com/username/arsip-surat-desa.git` dengan URL repository yang sesungguhnya.

### 2. Instal Dependensi PHP

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Kemudian generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_surat_desa
DB_USERNAME=root
DB_PASSWORD=
```

> Untuk **SQLite**, cukup buat file kosong `database/database.sqlite` dan atur `DB_CONNECTION=sqlite`.

### 5. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat seluruh tabel database dan mengisi data awal (default user, jenis surat, serta data dummy surat masuk dan keluar).

### 6. Buat Symbolic Link Storage

Aplikasi ini menggunakan fitur unggah file (surat digital). Jalankan perintah berikut untuk membuat symbolic link:

```bash
php artisan storage:link
```

### 7. Instal Dependensi Node.js & Build Asset

```bash
npm install
npm run build
```

---

## ▶️ Menjalankan Aplikasi

### Mode Development

Gunakan perintah berikut untuk menjalankan aplikasi dalam mode pengembangan (menggunakan Laravel Vite dev server):

```bash
composer run dev
```

Perintah di atas akan menjalankan secara bersamaan:
- PHP Development Server (`php artisan serve`)
- Queue Listener (`php artisan queue:listen`)
- Laravel Pail Log Viewer (`php artisan pail`)
- Vite Dev Server (`npm run dev`)

Akses aplikasi melalui: **http://localhost:8000**

### Mode Production

Pastikan asset telah di-build untuk production:

```bash
npm run build
```

Kemudian konfigurasikan web server (Apache/Nginx) Anda untuk mengarahkan document root ke folder `public/`.

---

## 🔑 Akun Default

Setelah menjalankan seeder (`php artisan db:seed`), Anda dapat login menggunakan salah satu akun berikut:

| Username | Password | Jabatan |
|----------|----------|---------|
| `kepala_desa` | `password123` | Kepala Desa |
| `sekdes` | `password123` | Sekretaris Desa |
| `admin` | `password123` | Operator Sistem |

---

## 🗄️ Struktur Database

| Tabel | Keterangan |
|-------|------------|
| `users` | Data pengguna sistem (admin, kepala desa, sekretaris) |
| `jenis_surat` | Master data kategori jenis surat |
| `surat_masuk` | Data arsip surat masuk dengan soft delete |
| `surat_keluar` | Data arsip surat keluar dengan soft delete |
| `riwayat_aktivitas` | Log aktivitas pengguna sistem |
| `password_reset_tokens` | Token untuk fitur reset password |
| `jobs` | Queue jobs (Laravel default) |

---

## 🧪 Testing

Untuk menjalankan suite pengujian aplikasi:

```bash
composer run test
```

Perintah ini akan menjalankan seluruh test case menggunakan PHPUnit.

---

## 📂 Struktur Folder Penting

```
arsip-surat-desa/
├── app/
│   ├── Http/Controllers/    # Controller aplikasi
│   ├── Livewire/            # Komponen Livewire (Admin & Auth)
│   ├── Models/              # Eloquent Models
│   └── Helpers/             # Helper functions
├── database/
│   ├── migrations/          # File migrasi database
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates & Livewire views
│   ├── css/                 # Stylesheet (Tailwind)
│   └── js/                  # JavaScript (Vite entry)
├── routes/
│   └── web.php              # Route definitions
├── public/                  # Document root (index.php, assets)
├── storage/
│   └── app/public/          # File uploads (surat digital)
├── composer.json            # PHP dependencies
├── package.json             # Node.js dependencies
└── vite.config.js           # Vite configuration
```

---

## 📝 Perintah Artisan & Composer yang Tersedia

| Perintah | Keterangan |
|----------|------------|
| `composer run setup` | Setup lengkap otomatis (install, env, key, migrate, npm install, build) |
| `composer run dev` | Jalankan development server dengan concurrent processes |
| `composer run test` | Jalankan PHPUnit tests |
| `php artisan migrate:fresh --seed` | Reset database dan isi ulang dengan data awal |
| `php artisan serve` | Jalankan PHP built-in development server |

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Jika Anda menemukan bug atau ingin menambahkan fitur, silakan buat **Issue** atau **Pull Request**.

---

<p align="center">
  Dibuat dengan ❤️ untuk Kantor Desa Teluk Kapuas
</p>

