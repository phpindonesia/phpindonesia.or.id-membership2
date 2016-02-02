# PHP Indonesia - Membership Application - Reloaded

## Kebutuhan

- PHP 5.5 keatas.
- HTTP Server, misal NginX or Apache.
- MySQL Server 5.x keatas untuk database utama.

## Instalasi

Cukup clone repositori ini, ke direktori lokal anda

```bash
$ git clone git@github.com/username/repo --depth 1 phpid-membership
$ cd phpid-membership
```

Buat database baru, terserah namanya apa (Misal. `phpid-membership`). Bisa gunakan PHPMyAdmin atau cukup tuliskan di terminal.

```bash
$ mysql -uroot -p create database [db-name]
```

Import kedua file `.sql` yang ada dalam folder `app/data` ke database yang telah anda buat:

1. `membership-schema.sql`
2. `membership-values.sql`

Copy-Paste file `settings.php.disable` dan rename menjadi `settings.php` lalu sesuaikan isi konfigurasi didalamnya.

Terakhir, buka url sesuai dengan konfigurasi lokal server anda. Misal [`http://localhost/phpid-membership`](http://localhost/phpid-membership).

# Cara berkontribusi:

1. Fork dan Clone repositori ini,
2. Buat branch baru, usahakan beri nama sesuai dengan apa yang akan anda lakukan. Misal: `feature-keren` atau `fix-issue-123`,
3. Setelah editing selesai, Push dan kirim Pull Request ke branch `development`,
4. Jelaskan kontribusi apa yang anda lakukan pada Pull Request tersebut.
