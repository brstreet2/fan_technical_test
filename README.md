# fan_technical_test

Untuk Tes Logika, ada pada folder "Logical Test"
- No. 1 menggunakan PHP
- No. 2 menggunakan Javascript
  
Untuk script test, ada pada folder "fan-technical-test"
- Silahkan lakukan composer install/update menggunakan PHP versi 8.1
- Silahkan buat file .env sendiri, dengan database bernama "fan_practical_test"
- Jika database sudah terbuat, silahkan lakukan migrasi dan seeding database dengan command line:
  1. php artisan migrate
  2. php artisan db:seed
- Jika proses migrasi telah selesai, silahkan install client Laravel Passpot dengan menjalankan cmd berikut: php artisan passport:install


API Docs

Base URL:
http://{base_url_anda}/api/

Endpoint:
POST
/login
Body: 
- username (email sesuai yang ada di database, required)
- password (password sesuai yang ada di database, required)
- client_id (Password grant client yang telah di buat pada instalasi Laravel Passport, defaultnya adalah 2, required)
- client_secret (Password grant client yang telah di buat pada instalasi Laravel Passport, lihat pada database anda, table "oauth_clients", required)
- grant_type (isi "password" sebagai default, required)

GET
/logout
Authorization: Bearer Token (yang di dapat setelah login, required)

POST
/absen
Authorization: Bearer Token (yang di dapat setelah login, required)
Body:
- type (string, required)
- waktu (string, required)

POST
/approve
Authorization: Bearer Token (yang di dapat setelah login, required)
Body:
- id_attendance (integer, required)

GET
/data
Authorization: Bearer Token (yang di dapat setelah login, required)
