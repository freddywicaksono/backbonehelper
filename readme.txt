1. Buat database baru di mysql, beri nama latihan
2. Import file tabel mahasiswa (mahasiswa.sql) ke dalam database latihan
3. Update konfigurasi database di file .env
4. Install library ke dalam project untuk dapat membaca file .env
   composer require vlucas/phpdotenv
   menghasilkan sebuah folder dengan nama vendor
5. Download folder assets: 
   https://bestfile.io/vkV6QlBjyGq6IGU/file
   ekstrak dan copy ke root direktori aplikasi

Aplikasi untuk menggenerate script bisa diakses di : http://localhost/[nama_folder_project]/auto

6. Buat folder db, didalamnya buat file dgn nama: database.php
   generate script lewat menu : DB Connection
7. Buat folder Models
   Generate script untuk masing-masing tabel, beri nama sesuai nama tabel dengan nama file diawali huruf besar
   cth: tabel: mahasiswa, nama file modelnya: Mahasiswa.js
8. Buat folder Controllers
   Generate script untuk masing-masing tabel, beri nama sesuai nama tabel dengan nama file diawali huruf besar
   cth: tabel mahasiswa, nama file controllernya: Mahasiswa.php
9. Buat folder sesuai nama tabelnya
   cth: folder mahasiswa
   di dalam folder tersebut buatlah file: action.php 
   generate script untuk action.php lewat menu: Class Action
   buatlah file index.php
   generate script untuk index.php lewat menu: Class View > Compass Template
10. Testing aplikasi:
   http://localhost/[folder]/mahasiswa

