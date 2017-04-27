<?php $this->layout('layouts::account') ?>

<form action="<?php echo $this->pathFor('membership-account-reactivation'); ?>" method="post" novalidate>

    <h3 class="aligncenter"> <i class="fa fa-key"></i> Account Reactivation</h3>

    <div class="form-group">
        <label for="email" class="control-label">Email *</label>
        <input id="email" class="form-control" name="email" required="required" type="email" value="<?php echo $this->requestBody('email'); ?>" />
        <p class="help-block">
            <?php echo $this->formFieldError('email'); ?>
            Account Reactivation adalah tool untuk mengajukan permintaan pengiriman ulang email aktivasi account.
            Berhubung kondisi resources server kami yang serba terbatas, maka pengiriman email konfirmasi aktivasi akan sering terlambat.
            Jika dalam waktu 2 hari anda belum juga mendapatkan email konfirmasi aktivasi, maka silahkan gunakan tool ini untuk meminta dikirim ulang
            email konfirmasi untuk aktivasi account.
        </p>
    </div>

    <div class="form-group">
        <?php echo $this->insert('sections::captcha') ?>

        <input value="Submit" type="submit" class="btn btn-primary" />
    </div>

</form>
