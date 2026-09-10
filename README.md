# WebGIS Analisis Konsumsi BBM Pickup K-06

## 1. Identitas Project

- *Nama:* Ryan Adiputra Darmawan
- *Kode CaAs:* 2671
- *Kendaraan:* Pickup Boks (Kode K-06)
- *Jalur:* Serang – Cilegon
- *Jenis BBM:* Biosolar
- *Harga BBM:* Rp6.800/liter
- *Standar efisiensi:* 9,0 km/liter

## 2. Deskripsi Project

WebGIS ini merupakan aplikasi WebGIS interaktif untuk memvisualisasikan perjalanan kendaraan Pickup K-06 pada jalur Serang–Cilegon dan menganalisis konsumsi bahan bakar berdasarkan data GPS dan data ringkasan konsumsi BBM.

Project dibuat untuk *Tugas Minggu 5 – Sistem Informasi Geografis (WebGIS)*.

Aplikasi menampilkan rute perjalanan, titik awal dan akhir, informasi perjalanan, filter perjalanan, serta hasil analisis jarak, konsumsi BBM, biaya, efisiensi, dan potensi pemborosan bahan bakar.

## 3. Tujuan

1. Memvisualisasikan data perjalanan kendaraan dalam bentuk peta interaktif.
2. Menampilkan rute perjalanan berdasarkan data GPS yang telah diolah.
3. Menampilkan titik awal dan titik akhir setiap perjalanan.
4. Menampilkan informasi perjalanan melalui popup.
5. Menyediakan filter perjalanan.
6. Menampilkan informasi jarak dan konsumsi BBM.
7. Menghitung biaya konsumsi BBM.
8. Membandingkan efisiensi aktual dengan standar acuan.
9. Mengidentifikasi potensi pemborosan BBM.

## 4. Teknologi yang Digunakan

- *Laravel* – framework utama aplikasi web.
- *PHP* – bahasa pemrograman backend.
- *Blade* – template engine Laravel.
- *HTML & CSS* – struktur dan tampilan halaman.
- *JavaScript* – interaksi, pengambilan data, filter, dan visualisasi.
- *Leaflet.js* – pemetaan dan visualisasi data spasial.
- *Chart.js* – visualisasi data.
- *CSV* – penyimpanan data GPS mentah.
- *GeoJSON* – penyimpanan data rute dan titik perjalanan.
- *JSON* – penyimpanan data ringkasan.
- *GitHub* – repository source code dan dokumentasi.
- *Railway* – deployment aplikasi secara online.

## 5. Dataset

Seluruh dataset utama berada pada folder public/data/.

### gps_mentah.csv

Berisi data GPS mentah kendaraan. Dataset memiliki *283 titik pengamatan GPS* dan digunakan sebagai data dasar perjalanan.

### rute.geojson

Berisi data spasial berupa garis rute perjalanan. Dataset memiliki *3 fitur garis rute* dan digunakan sebagai layer rute pada peta.

### titik_ujung.geojson

Berisi titik awal dan titik akhir perjalanan. Dataset memiliki *6 penanda titik awal dan akhir*.

### ringkasan.json

Berisi ringkasan statistik konsumsi BBM yang digunakan untuk mengisi informasi analisis pada dashboard.

## 6. Preprocessing Data

Data GPS yang digunakan disusun dan diolah menjadi data yang sesuai untuk kebutuhan WebGIS.

Tahapan pengolahan secara umum:

1. Membaca data GPS mentah.
2. Menyusun data perjalanan.
3. Membentuk data rute perjalanan.
4. Menentukan titik awal dan titik akhir perjalanan.
5. Menyimpan rute dalam format GeoJSON.
6. Menyimpan titik perjalanan dalam format GeoJSON.
7. Menyusun ringkasan konsumsi BBM dalam format JSON.
8. Menempatkan data hasil pengolahan pada public/data/.

## 7. Struktur Project

text
webgis-pickup-k06/
├── app/
│   └── Http/
│       └── Controllers/
│           └── WebGisController.php
├── public/
│   ├── data/
│   │   ├── gps_mentah.csv
│   │   ├── rute.geojson
│   │   ├── titik_ujung.geojson
│   │   └── ringkasan.json
│   └── vendor/
├── resources/
│   └── views/
│       └── webgis.blade.php
├── routes/
│   └── web.php
├── tests/
│   └── Feature/
│       └── WebGisFeatureTest.php
├── composer.json
├── package.json
├── vite.config.js
└── README.md


## 8. Dokumentasi Kodingan

### app/Http/Controllers/WebGisController.php

Controller backend Laravel yang menangani penyediaan data untuk WebGIS, termasuk data ringkasan, rute, titik awal/akhir, dan GPS mentah.

### resources/views/webgis.blade.php

Halaman utama WebGIS. File ini berisi tampilan dashboard, kartu informasi, filter perjalanan, peta Leaflet, layer rute, titik awal/akhir, popup, legenda, serta JavaScript untuk mengambil dan menampilkan data.

### routes/web.php

Mengatur route halaman WebGIS dan endpoint API yang digunakan frontend.

### public/data/gps_mentah.csv

Sumber data GPS mentah kendaraan.

### public/data/rute.geojson

Data spasial garis rute yang ditampilkan sebagai layer pada peta.

### public/data/titik_ujung.geojson

Data spasial titik awal dan titik akhir perjalanan.

### public/data/ringkasan.json

Sumber data ringkasan statistik konsumsi BBM pada dashboard.

### tests/Feature/WebGisFeatureTest.php

File pengujian fitur WebGIS untuk memastikan halaman dan informasi penting dapat diproses dan ditampilkan sesuai kebutuhan.

## 9. Endpoint API

| Endpoint | Fungsi |
|---|---|
| /api/ringkasan | Mengambil data ringkasan konsumsi BBM |
| /api/geojson/rute | Mengambil data rute perjalanan |
| /api/geojson/titik-ujung | Mengambil titik awal dan akhir perjalanan |
| /api/gps-mentah | Mengambil data GPS mentah |

Endpoint digunakan oleh JavaScript pada frontend untuk mengambil data dari backend.

## 10. Alur Kerja Aplikasi

text
Data GPS Mentah
      ↓
Preprocessing Data
      ↓
Rute + Titik Perjalanan + Ringkasan
      ↓
public/data/
      ↓
Laravel Controller
      ↓
Endpoint API
      ↓
JavaScript Frontend
      ↓
Leaflet.js / Dashboard
      ↓
WebGIS


Data spasial ditampilkan pada peta, sedangkan data ringkasan digunakan untuk menampilkan informasi analisis BBM.

## 11. Fitur WebGIS

### Peta Interaktif

Menampilkan informasi spasial perjalanan kendaraan.

### Layer Rute

Menampilkan garis rute perjalanan menggunakan Leaflet.js.

### Titik Awal dan Akhir

Menampilkan marker lokasi awal dan akhir perjalanan.

### Popup

Menampilkan informasi ketika layer rute dipilih.

### Filter Perjalanan

Memungkinkan pengguna memilih perjalanan yang ingin ditampilkan.

### Dashboard Analisis BBM

Menampilkan total jarak, total BBM, biaya BBM, efisiensi aktual, potensi BBM boros, dan biaya pemborosan.

### Visualisasi Data

Chart.js digunakan untuk membantu menampilkan data secara visual.

### Parameter Kendaraan

Menampilkan jenis kendaraan, kode kendaraan, jenis BBM, harga BBM, dan standar efisiensi.

## 12. Hasil Analisis

| Parameter | Hasil |
|---|---:|
| Total jarak | 85,6 km |
| Total konsumsi BBM | 10,3 liter |
| Total biaya BBM | Rp69.923 |
| Efisiensi aktual | 8,31 km/liter |
| Standar acuan | 9,0 km/liter |
| Potensi BBM boros | 0,8 liter |
| Potensi biaya pemborosan | Rp5.234 |

Efisiensi aktual sebesar *8,31 km/liter* dibandingkan dengan standar acuan *9,0 km/liter*.

Dashboard juga menampilkan estimasi potensi pemborosan BBM berdasarkan standar acuan yang digunakan.

## 13. Tampilan yang Dihasilkan

WebGIS menampilkan:

- Informasi identitas kendaraan.
- Jalur perjalanan.
- Total jarak.
- Total BBM.
- Total biaya BBM.
- Efisiensi aktual.
- Potensi BBM boros.
- Potensi biaya pemborosan.
- Filter perjalanan.
- Peta rute.
- Titik awal dan akhir.
- Popup informasi.
- Legenda peta.

## 14. Cara Menjalankan Project Secara Lokal

### Persyaratan

Pastikan sudah tersedia:

- PHP
- Composer
- Node.js
- NPM
- Laravel

### Clone Repository

bash
git clone https://github.com/RyanAdiputra05/webgis-pickup-k06.git
cd webgis-pickup-k06


### Install Dependency

bash
composer install
npm install


### Menyiapkan Environment

Buat file .env berdasarkan .env.example.

Kemudian jalankan:

bash
php artisan key:generate


### Menjalankan Aplikasi

bash
php artisan serve


Kemudian buka alamat lokal yang diberikan Laravel pada browser.

## 15. Pengujian

Pengujian fitur terdapat pada:

text
tests/Feature/WebGisFeatureTest.php


Pengujian digunakan untuk memastikan halaman dan informasi utama WebGIS dapat diproses sesuai kebutuhan.

Pemeriksaan melalui browser juga dilakukan untuk memastikan halaman, dashboard, peta, layer rute, popup, filter, dan informasi analisis dapat digunakan.

## 16. Deployment

Project dideploy menggunakan Railway agar dapat diakses secara online.

### Repository GitHub

https://github.com/RyanAdiputra05/webgis-pickup-k06

### WebGIS Live

https://webgis-pickup-k06-production-2917.up.railway.app

## 17. Keterbatasan Data

Hasil analisis bergantung pada data GPS dan data konsumsi BBM yang tersedia.

Hasil dapat dipengaruhi oleh:

- kualitas dan kelengkapan data GPS;
- kondisi kendaraan;
- kondisi perjalanan;
- kondisi lalu lintas;
- perbedaan kondisi aktual dengan standar acuan;
- keterbatasan jumlah perjalanan pada dataset.

Oleh karena itu, hasil analisis merupakan gambaran berdasarkan dataset yang digunakan dalam project.

## 18. Catatan Pengembangan

Project ini menggunakan data yang telah disiapkan dan diolah untuk kebutuhan Tugas Minggu 5.

Data spasial menggunakan GeoJSON agar dapat dibaca dan divisualisasikan dengan mudah pada peta Leaflet.

Pemisahan data menjadi CSV, GeoJSON, dan JSON membuat data mentah, data spasial, dan data ringkasan dapat digunakan sesuai kebutuhan masing-masing bagian aplikasi.

## 19. Kesimpulan

WebGIS Analisis Konsumsi BBM Pickup K-06 menggabungkan data GPS, data spasial, dan data konsumsi bahan bakar ke dalam aplikasi WebGIS interaktif.

Laravel digunakan sebagai framework utama, Leaflet.js digunakan untuk pemetaan, Chart.js untuk visualisasi, sedangkan CSV, GeoJSON, dan JSON digunakan sebagai sumber data.

Aplikasi memungkinkan pengguna melihat rute perjalanan Pickup K-06 pada jalur Serang–Cilegon, titik perjalanan, filter perjalanan, serta hasil analisis jarak, konsumsi BBM, biaya, efisiensi, dan potensi pemborosan.

## 20. Repository

Source code dan dokumentasi project tersedia di:

https://github.com/RyanAdiputra05/webgis-pickup-k06
