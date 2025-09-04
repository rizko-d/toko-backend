# Laravel Toko Online Backend

Backend aplikasi toko online yang dibangun menggunakan Laravel dan PostgreSQL.  
Berisi fitur dasar e-commerce seperti user authentication, katalog produk, manajemen order, sistem pembayaran sederhana, dan dashboard admin untuk kelola produk serta tracking order.

---

## Fitur

- User Authentication (Register, Login, Logout, Profile)
- Katalog Produk dengan fitur pencarian dan filter kategori
- Manajemen Order (Checkout produk, tracking order, pembatalan order)
- Sistem Pembayaran sederhana (dengan metode manual)
- Dashboard Admin (CRUD produk, melihat daftar dan detail order, update status order)
- Penggunaan PostgreSQL sebagai database

---

## Teknologi

- PHP 8.x
- Laravel 12.x Framework
- PostgreSQL Database
- Sanctum untuk API Token Authentication
- Composer untuk dependency management

---

## Instalasi

1. Clone repository:
   ```
   git clone https://github.com/username/laravel-toko-online.git
   cd laravel-toko-online
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Copy file `.env.example` ke `.env` dan sesuaikan konfigurasi database PostgreSQL:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=toko_online
   DB_USERNAME=postgres
   DB_PASSWORD=your_password
   ```

4. Generate aplikasi key:
   ```
   php artisan key:generate
   ```

5. Jalankan migrasi dan seeding data awal:
   ```
   php artisan migrate --seed
   ```

6. Buat symbolic link storage (untuk akses upload file jika ada):
   ```
   php artisan storage:link
   ```

7. Jalankan development server:
   ```
   php artisan serve
   ```

---

## Penggunaan API

### Register  
`POST /api/register`  
Body JSON:
```
{
  "name": "Test User",
  "email": "testuser@example.com",
  "password": "password",
  "password_confirmation": "password",
  "phone": "081234567890"
}
```

### Login  
`POST /api/login`  
Body JSON:
```
{
  "email": "testuser@example.com",
  "password": "password"
}
```

> Gunakan token Bearer yang diterima untuk mengakses endpoint protected lainnya.

---

## Testing dengan Postman

Folder `postman_collection.json` berisi collection API untuk pengujian dengan Postman.

---

## Kontribusi

Kontribusi sangat dipersilakan baik berupa perbaikan bug, penambahan fitur, atau dokumentasi.

---

## License

Project ini menggunakan lisensi MIT — lihat file LICENSE untuk detail.

---

Dibuat oleh Rizko Febri Raachmayadi

https://github.com/rizko-d

```

