# phpindonesia.or.id-membership2
PHP Indonesia - Membership Application - Reloaded

Platform:

1. PHP
2. MariaDB / MySQL

Cara Install:

1. Clone repository ini di direktori document root anda. Contoh: C:\xampp\htdocs atau /var/www
2. Create database dengan nama bebas. Contoh: `dev-spirit`.
3. Import file database struktur `dev-spirit.sql`
4. Copy file `settings.php.disable` lalu rename hasil copy nya menjadi bernama `settings.php`. File `settings.php.disable` jangan dihapus atau di-rename.
5. Edit nilai-nilai di settings.php sesuai kebutuhan.
6. Buat direktori `files/photoprofile` di dalam direktori `public/` .
7. Akses app dengan alamat berikut: `http://localhost/phpindonesia.or.id-membership2/apps/membership`

Jika app ini diinstall di virtual host, maka akses dengan alamat: `http://virtual.host.anda/apps/membership` 

Cara berkontribusi:

1. Forking repository ini
2. Lakukan semua perubahan - perubahan di branch `development`
3. Hanya menerima pull-request ke branch `development` saja.
