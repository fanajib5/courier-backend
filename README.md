<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang courier-backend

Ini adalah contoh proyek API untuk keperluan tes pemrograman dengan menggunakan Laravel. Proyek ini hanya mempunyai satu modul courier dengan fitur CRUD yang tanpa menggunakan view/front end.

## Keterangan versi

Proyek ini dibangun pada _OS Windows 11_ dengan detail versi sebagai berikut:

- PHP 8.2 (via Laragon)
- Laravel 10
- MySQL 5.7.33 (via Laragon)

## Dokumentasi API

Dokumentasi proyek ini ada pada bagian [Wiki - Dokumentasi](https://github.com/fanajib5/courier-backend/wiki/Dokumentasi)

## Instalasi

Buka di cmd atau aplikasi terminal dan arahkan ke folder ini. Kemudian, jalankan perintah berikut:

Install dependensi Laravel melalui Composer dengan perintah,

```bash
composer install
```

Salin ```.env.example``` menjadi ```.env``` dengan perintah,

```bash
cp .env.example .env
```

Buat ```APP_KEY``` proyek dengan perintah,

```bash
php artisan key:generate
```

Silakan membuat database MySQL terlebih dahulu dan jika mengikuti proyek ini, maka gunakan ```courier_backend``` sebagai nama database. Kemudian sesuaikan detail autentikasi koneksi MySQL Anda.

Lakukan migrasi model ```Courier``` dengna perintah,

```bash
php artisan migrate
```

Jalankan seeder untuk model ```Courier``` dengan perintah berikut,

```bash
php artisan db:seed --class=CourierTableSeeder
```

Selesai! Jalankan aplikasi melalui _built-in webserver_ dengan perintah,

```bash
php artisan serve
```

## Route API

Proyek ini menggunakan route untuk fitur CRUD antara lain

| Nama Route | Request Method | Endpoint                 | Hasil                                                      |
|------------|----------------|--------------------------|------------------------------------------------------------|
| index      | GET            | ```/api/couriers```      | menampilkan daftar seluruh item ```courier```                     |
| show       | GET            | ```/api/couriers/{id}``` | mengembalikan item ```courier``` pada ```id``` yang cocok |
| store      | POST           | ```/api/couriers```      | membuat item ```courier``` yang baru                       |
| update     | PUT            | ```/api/couriers/{id}``` | memperbarui data ```courier``` pada ```id``` yang cocok   |
| destroy    | DELETE         | ```/api/courers/{id}```     | menghapus item ```courier``` pada ```id``` yang cocok     |

### Parameter query

Pada endpoint ```/api/couriers``` bisa ditambahkan maing-masing parameter dan tanpa digabungkan satu sama lain. Parameter tersebut yaitu,

- ```pageSize=[int]``` untuk mengaktifkan pagination pada luarannya.
- ```sort=-DOJ``` atau ```sort=-dateofjoined``` untuk penyortiran data ```courier``` secara menurun (Descending / ```DESC```). Sedangkan ```sort=DOJ``` atau ```sort=dateofjoined``` adalah penyortiran data secara naik (Ascending / ```ASC```).
- ```search=[nama courier]``` untuk mencari nama ```courier``` yang diinginkan.
- ```level=[int,int,...]``` untuk filter data ```courier``` dengan level yang diinginkan.

### Hapus data courier

Adapun data ```courier``` akan dihapus secara permanen dan tidak menggunakan _flag_ atau metode _soft delete_.

## Pengujian

Proyek ini sudah ditambahkan pengujian menggunakan [PEST](https://pestphp.com/) dengan hasil terbaru seperti berikut,

<img src="https://cdn.statically.io/gh/fanajib5/media-faiq/main/media/unit-testing-in-courier-backend-by-pest.webp"  width="75%">

### Menjalankan pengujian

Pada file ```composer.json``` sudah diubah agar PEST dapat dieksekusi melalui perintah composer _script_ seperti berikut

- ```composer test``` untuk eksekusi pengujian saja.
- ```composer test-coverage``` untuk eksekusi pengujian dengan _code coverage_.
- ```composer test-coverage-html``` untuk menyimpan laporan _code coverage_ dalam format HTML ke direktori tertentu.

## License

Proyek ini dibuat oleh [Faiq Najib](https://github.com/fanajib5).

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

