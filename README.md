# PHP Indonesia - Membership App - Reloaded

### Kebutuhan

- PHP 5.5 keatas.
- HTTP Server, misal NginX or Apache.
- MySQL Server 5.x keatas untuk database utama.

### Instalasi

1. Clone repo ini ke lokal, ambil langsung ke branch `refactory-dev`

   ```
$ git clone https://github.com/phpindonesia/phpindonesia.or.id-membership2 [folder-name]
```

   **NOTE**: Untuk kebutuhan testing, gunakan argumen `--branch [branch-name]` untuk clone branch tertentu saja & argumen `--depth 1` untuk ambil hanya 1 history terakhir saja.

2. Masuk ke directory cloning tadi & install dependency

   ```
$ cd [folder-name] && composer install
```

3. Buat database baru, terserah namanya apa (Misal. `phpid-membership`). Bisa gunakan PHPMyAdmin atau cukup tuliskan di terminal.

   ```bash
$ mysql -u[db-user] -p -e "create database [db-name]"
```

   **NOTE**: sesuaikan `[db-user]` anda, umumnya adalah `root`

4. Import kedua file `.sql` yang ada dalam folder `app/data` secara berurutan ke `[db-name]` yang telah anda buat:

   1. `membership-schema.sql`
   2. `membership-values.sql`

   Dari terminal bisa dilakukan dengan cara

   ```bash
$ mysql -u[db-user] -p [db-name] < app/data/membership-schema.sql app/data/membership-values.sql
```

5. Copy-Paste file `settings.php.disable` didalam folder `app` dan rename menjadi `settings.php` lalu buka dengan editor favorit anda dan sesuaikan isi konfigurasi didalamnya, misal Sublime Text: `subl`.

   ```
$ cp app/settings.php.disable app/settings.php
$ subl -a app/settings.php
```

6. Jika anda menggunakan web server seperti Apache atau NginX, silahkan sesuaikan vhost -nya atau gunakan PHP built in server dan arahkan ke folder `www` sebagai docroot.

   ```
$ php -S  localhost:8088 -t www/
```

7. Terakhir, buka url sesuai dengan konfigurasi lokal server anda. Misal [`http://localhost:8088/`](http://localhost:8088/).

### Struktur Direktori

| Path | Keterangan |
| --- | --- |
| `app/` | Direktori utama aplikasi |
| `app/data/` | Direktori database |
| `app/src/` | Direktori source code aplikasi |
| `app/views/` | Direktori template |
| `www/` | Direktori public |

### Cara berkontribusi:

1. Fork dulu repo ini ke akun anda & clone ke lokal selanjutnya ikuti tahap [installasi](#instalasi) diatas,

   ```
$ git clone git@github.com:[username]/phpindonesia.or.id-membership2
```

2. Buat branch baru, usahakan beri nama sesuai dengan apa yang akan anda lakukan. Misal: `feature-keren` atau `fix-issue-123`,
3. Setelah editing selesai, Push ke remote origin dan kirim Pull Request ke branch `develop`,
4. Jelaskan kontribusi apa yang anda lakukan pada Pull Request tersebut.
