<h1 align="center">PROJECT_SCM</h1>

<p align="center">
  <strong>Sistem Manajemen Rantai Pasok Digital untuk UMKM Agroindustri</strong><br>
  Studi Kasus: Rumah Organik Jember (ROJEMBER) – Keripik Pisang Organik
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-ff2d20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Status-Akademik-blue?style=for-the-badge" alt="Status">
  <img src="https://img.shields.io/badge/Universitas%20Jember-2025-green?style=for-the-badge" alt="Tahun">
</p>

## Dosen Pengampu
- Tri Agustina Nugrahani, S.Kom., M.Kom.
- Karina Nine Amalia, S.Kom., M.Kom.

## Disusun Oleh (Kelompok C)
- Shilvira Nueltasari (230910202071)
- Aji Mahameru Firjatullah (232410101032)
- Aurizal Ardiyanto (232410101086)
- Muchamad Habib Alwi (232410101092)

## Tentang Proyek

PROJECT_SCM adalah rancangan sistem **Supply Chain Management (SCM)** berbasis web untuk **Rumah Organik Jember (ROJEMBER)**, UMKM pengolah keripik pisang organik. Sistem ini mengatasi masalah utama seperti pasokan pisang tidak stabil (dari Kalibaru & Silo karena cuaca/musim), pencatatan manual rawan error, tidak adanya database pemasok, dan kurangnya pelaporan digital.

Menggunakan **Weighted Moving Average (WMA)** untuk prediksi bahan baku, serta fitur dashboard dan laporan otomatis, ini menjadi langkah awal digitalisasi UMKM agroindustri.

## 🎯 Tujuan Utama
1. Membuat rancangan SCM sederhana untuk pantau bahan baku, produksi, dan distribusi
2. Bantu owner tentukan waktu beli bahan baku optimal
3. Kurangi kesalahan pencatatan & tingkatkan efisiensi distribusi
4. Jadi fondasi digitalisasi operasional ROJEMBER

## Manfaat
- Pahami integrasi SCM di UMKM
- Solusi praktis rantai pasok efisien & terukur
- Dorong adaptasi teknologi bisnis lokal

## ✨ Fitur Utama
- Dashboard Stok: Ringkasan real-time bahan & produk
- Manajemen Akun: Role-based (Owner/Koordinator)
- Manajemen Pemasok: Database + riwayat
- Manajemen Bahan Baku & Gudang: Otomatis masuk-keluar
- Manajemen Produksi: Jadwal & update stok otomatis
- Manajemen Distribusi: Tracking status pengiriman
- Laporan Otomatis: Produksi & distribusi
- Peramalan WMA: Prediksi bahan (cocok data terbatas & musiman)


## 🛠️ Teknologi Stack

| Kategori          | Teknologi                          |
|-------------------|------------------------------------|
| Framework         | Laravel (PHP 8+)                   |
| Database          | MySQL                              |
| Frontend          | HTML5, CSS3, JavaScript, Bootstrap |
| Peramalan         | Weighted Moving Average (WMA)      |
| Environment       | Laragon / XAMPP                    |
| Dependency        | Composer                           |
| Arsitektur        | MVC Pattern                        |

## 🚀 Instalasi (Jika Kode Sudah Diimplementasikan)
1. Clone repo  
   ```bash
   git clone https://github.com/AsepBensin12k/PROJECT_SCM.git
   cd PROJECT_SCM
2. Install dependencies
   ```bash
   composer install
3. Setup environment 
   ```bash
   cp .env.example .env
   php artisan key:generate
4. Database Configuration  
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=rojember_scm
    DB_USERNAME=root
    DB_PASSWORD=
5. Migration & Seeder 
   ```bash
    php artisan migrate --seed
    php artisan storage:link
6. Run server  
   ```bash
    php artisan serve


---

## 📄 Lisensi
Proyek akademik UTS SCM 2025 – Universitas Jember.
Modifikasi/komersial butuh izin tim & institusi.
© 2025 Kelompok C – Sistem Informasi – Universitas Jember

## 🙏 Acknowledgments

- **ROJEMBER** - Inspirasi studi kasus
- **Universitas Jember & Dosen Pengampu** - Institusi pendukung
- **Laravel Community** - Framework dan dokumentasi
- **Kelompok C** - Developer dan kontributor

---

---

<div align="center">
  <h3>🌾 Digitalisasi Rantai Pasok UMKM Pangan Berkelanjutan 🌾</h3>
  <p>Dibuat oleh Kelompok C - FASILKOM 2025</p>
  
  <p>
    <img src="https://img.shields.io/github/stars/AsepBensin12k/totaCom?style=social" alt="GitHub stars">
    <img src="https://img.shields.io/github/forks/AsepBensin12k/totaCom?style=social" alt="GitHub forks">
    <img src="https://img.shields.io/github/watchers/AsepBensin12k/totaCom?style=social" alt="GitHub watchers">
  </p>
</div>

---
