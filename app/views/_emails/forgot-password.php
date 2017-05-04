<p>Haayy <?php echo $this->e($fullname) ?> ^_^,</p>

<p>Anda adalah pemilik akun dengan email <?php echo $this->e($email) ?>, dan anda telah melakukan permintaan perubahan password pada tanggal: <?php echo $this->e($reqDate) ?>, karena anda lupa dengan password anda.</p>

<p>Kami butuh konfirmasi anda untuk memastikan bahwa anda memang benar-benar telah melakukan permintaan perubahan password sesuai kehendak anda.</p>

<p>Jika permintaan perubahan password ini memang sesuai dengan kehendak anda, maka silahkan klik link <a href="<?php echo $this->baseUrl($resetUrl) ?>"><?php echo $this->baseUrl($resetUrl) ?></a> untuk melakukan konfirmasi.</p>

<p>Jika permintaan perubahan password ini bukan kehendak anda, maka email ini bisa diabaikan saja atau Anda dapat melaporkannya kepada kami melalui email <a href="mailto:report@phpindonesia.or.id">report@phpindonesia.or.id</a></p>

<p>Batas waktu 2 jam dari sekarang untuk melakukan konfirmasi, dan url konfirmasi diatas akan kadaluarsa pada: <?php echo $this->e($resetExp) ?></p>

<p>Terima kasih ^_^</p>
