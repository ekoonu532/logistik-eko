# Sistem Logistik - Aplikasi Inventaris Barang

Sistem Logistik adalah aplikasi berbasis web yang dibangun menggunakan Laravel untuk mengelola inventaris barang, pencatatan barang masuk dan keluar, serta monitoring stok secara real-time.

## 📋 Fitur

- 🔐 Autentikasi user (login, register)
- 📊 Dashboard dengan statistik dan grafik
- 📦 Manajemen data barang
- 📥 Pencatatan barang masuk
- 📤 Pencatatan barang keluar
- 📊 Monitoring stok barang secara real-time
- 📱 Responsive design untuk berbagai ukuran layar

## 🔧 Teknologi yang Digunakan

- **Framework**: Laravel 12.x
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Chart.js
- **Additional Libraries**: DataTables, jQuery

## 🚀 Instalasi

### Prasyarat

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. Clone repository
   ```bash
   git clone https://github.com/username/logistik-eko.git
   cd logistik-eko
   ```

2. Install dependency PHP
   ```bash
   composer install
   ```

3. Install dependency JavaScript
   ```bash
   npm install
   npm run dev
   ```

4. Salin file .env.example menjadi .env
   ```bash
   cp .env.example .env
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Konfigurasi database di file .env
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_logisti_eko
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Jalankan migrasi dan seeder
   ```bash
   php artisan migrate --seed
   ```

8. Jalankan web server
   ```bash
   php artisan serve
   ```

9. Akses aplikasi di browser: `http://localhost:8000`

### Akun Default

- Email: admin@example.com
- Password: password

## 📝 Alur Kerja Aplikasi

### Alur Pencatatan Barang Masuk
1. Admin memilih barang dari daftar barang
2. Memasukkan jumlah, asal, dan tanggal masuk
3. Sistem otomatis generate no_barang_masuk
4. Sistem menambahkan stok barang yang dipilih
5. Data barang masuk disimpan ke database

### Alur Pencatatan Barang Keluar
1. Admin memilih barang dari daftar barang dengan stok > 0
2. Memasukkan jumlah, tujuan, dan tanggal keluar
3. Sistem memvalidasi apakah stok mencukupi
4. Sistem otomatis generate no_barang_keluar
5. Sistem mengurangi stok barang yang dipilih
6. Data barang keluar disimpan ke database

## 📊 Struktur Database

### Tabel Barang (barangs)
- id (primary key)
- kode_barang (unique)
- nama_barang
- stok
- deskripsi
- created_at, updated_at

### Tabel Barang Masuk (barang_masuks)
- id (primary key)
- no_barang_masuk (unique)
- barang_id (foreign key ke tabel barangs)
- kode_barang
- quantity
- origin (asal barang)
- tanggal_masuk
- created_at, updated_at

### Tabel Barang Keluar (barang_keluars)
- id (primary key)
- no_barang_keluar (unique)
- barang_id (foreign key ke tabel barangs)
- kode_barang
- quantity
- destination (tujuan barang)
- tanggal_keluar
- created_at, updated_at

## 📃 Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](LICENSE).

## 📧 Kontak

Jika Anda memiliki pertanyaan atau saran, silakan hubungi:
- Email: echojelan5@gmail.com
- GitHub: [ekoonu532](https://github.com/ekoonu532)
