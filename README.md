# 🚀 Aplikasi Log Harian Pegawai

Aplikasi ini digunakan untuk mencatat log harian kegiatan pegawai, melakukan verifikasi oleh atasan langsung, serta monitoring dalam bentuk kalender.

## 🚀 Fitur Utama

- Autentikasi & Registrasi menggunakan Laravel Breeze
- Pemilihan bidang saat registrasi (Staff Keuangan / Staff Operasional)
- Penetapan **Role otomatis** berdasarkan pilihan
- Manajemen role dan permission menggunakan [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
- Middleware untuk pembatasan akses berdasarkan role

- ## 🧰 Teknologi yang Digunakan

- Laravel 12
- Spatie Laravel Permission
- Tailwind CSS
- Blade Template
- Flowbite
- Breeze

- ## 📦 Instalasi

```bash
git clone https://github.com/andiajisaputra3/wps_intern_andi_aji_saputra.git
cd nama-repo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
composer run dev
```

## 👤 Akun Login Default (Seeder)

Setelah menjalankan `php artisan db:seed`, kamu dapat menggunakan akun berikut untuk login sesuai role-nya:

| Role                | Nama                          | Email                          | Password   |
|---------------------|-------------------------------|--------------------------------|------------|
| Admin               | Jhon Doe                      | `admin@gmail.com`              | `password` |
| Direktur            | Andi Aji Saputra              | `direktur@gmail.com`           | `password` |
| Manager Operasional | Maulana Achmad Aminullah      | `manageroperasional@gmail.com` | `password` |
| Manager Keuangan    | Taufik Irawan                 | `managerkeuangan@gmail.com`    | `password` |
| Staff Operasional   | Bagus Setiawan                | `staffoperasional@gmail.com`   | `password` |
| Staff Keuangan      | Ilham Taufik                  | `staffkeuangan@gmail.com`      | `password` |

💡 **Catatan:**  
Setiap user sudah otomatis memiliki role dan atasan masing-masing sesuai struktur organisasi.
