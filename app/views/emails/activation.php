<p>Haayy <?php echo $this->e($fullname) ?> ^_^,</p>

<p>Pada tanggal: <?php echo $this->e($regDate) ?>, Anda telah melakukan submission untuk menjadi member pada sistem membership PHP Indonesia dan anda adalah pemilik akun email <a href="mailto:<?php echo $this->e($email) ?>"><?php echo $this->e($email) ?></a>.</p>

<p>Demi keamanan dan validitas data, maka kami mewajibkan setiap registrant untuk melakukan aktivasi account melalui email.</p>

<p>Maka dari itu, anda dapat mengaktifkan account anda melalui akses url aktivasi berikut: <a href="<?php echo $this->e($activationUrl) ?>"><?php echo $this->e($activationUrl) ?></a>.<br>
Url activation ini akan expired pada: <?php echo $this->e($activationExp) ?></p>

<p>Jika anda tidak pernah merasa melakukan submission, maka anda dapat mengabaikan email ini.<br>
Anda dapat melaporkannya kepada kami melalui email: <a href="mailto:report@phpindonesia.or.id">report@phpindonesia.or.id</a></p>

<p>Terima kasih ^_^</p>
