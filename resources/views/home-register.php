<?php
$this->layout('layouts::account');

$this->appendJs([
    $this->asset('/js/regional.js')
]);
?>

<form action="<?php echo $this->pathFor('membership-register'); ?>" method="post" novalidate class="form-horizontal">
    <h3 class="aligncenter"> <i class="fa fa-user"></i> Registrasi Anggota</h3>

    <div class="form-group">
        <label for="email" class="control-label">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo $this->requestBody('email'); ?>" />
        <?php echo $this->formFieldError('email'); ?>
        <p class="help-block">
            Masukkan alamat email yang masih aktif.
        </p>
    </div>

    <div class="form-group">
        <label for="username" class="control-label">Username</label>
        <input type="text" id="username" name="username" class="form-control" value="<?php echo $this->requestBody('username'); ?>" />
        <?php echo $this->formFieldError('username'); ?>
        <p class="help-block">
            Masukkan <em>username</em> yang anda inginkan.
        </p>
    </div>

    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" value="<?php echo $this->requestBody('password'); ?>" />
        <?php echo $this->formFieldError('password'); ?>
        <p class="help-block">
            Masukkan <em>password</em> yang anda inginkan.
        </p>
    </div>

    <div class="form-group">
        <label for="repassword" class="control-label">Konfirmasi Password</label>
        <input type="password" id="repassword" name="repassword" class="form-control" value="<?php echo $this->requestBody('repassword'); ?>" />
        <?php echo $this->formFieldError('repassword'); ?>
        <p class="help-block">
            Konfirmasikan ulang <em>password</em> yang anda masukkan.
        </p>
    </div>

    <div class="form-group">
        <label for="fullname" class="control-label">Nama Lengkap *</label>
        <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $this->requestBody('fullname'); ?>" />
        <?php echo $this->formFieldError('fullname'); ?>
        <p class="help-block">
            Masukkan <em>nama lengkap</em> anda
        </p>
    </div>

    <div class="form-group">
        <label for="gender-dd" class="control-label">Gender *</label>
        <?php echo $this->formInputSelect('gender_id', ['female' => 'Wanita', 'male' => 'Pria'], [
            'id' => 'gender-dd',
            'class' => 'form-control'
        ]); ?>
        <?php echo $this->formFieldError('gender_id'); ?>
        <p class="help-block">
            Gender
        </p>
    </div>

    <div class="form-group">
        <label for="provinces-dd" class="control-label">Provinsi *</label>
        <?php echo $this->formInputSelect('province_id', $provinces, [
            'id' => 'provinces-dd',
            'class' => 'form-control'
        ]); ?>
        <?php echo $this->formFieldError('province_id'); ?>
        <p class="help-block">
            Masukkan <em>propinsi</em> wilayah anda bertempat tinggal.
        </p>
    </div>

    <div class="form-group">
        <label for="cities-dd" class="control-label">Kabupaten / Kota *</label>
        <?php echo $this->formInputSelect('city_id', $cities, [
            'id' => 'cities-dd',
            'class' => 'form-control'
        ]); ?>
        <?php echo $this->formFieldError('city_id'); ?>
        <p class="help-block">
            Masukkan <em>kota</em> atau <em>kabupaten</em> wilayah anda bertempat tinggal.
        </p>
    </div>

    <div class="form-group">
        <label for="area" class="control-label">Area Domisili *</label>
        <input type="text" id="area" name="area" class="form-control" value="<?php echo $this->requestBody('area'); ?>" />
        <?php echo $this->formFieldError('area'); ?>
        <p class="help-block">
            Masukkan wilayah <em>domisili, kecamatan, atau desa</em> tempat anda sekarang tinggal.
        </p>
    </div>

    <div class="form-group">
        <label for="job-id" class="control-label">Pekerjaan *</label>
        <?php echo $this->formInputSelect('job_id', $jobs, [
            'id' => 'job-id',
            'class' => 'form-control'
        ]); ?>
        <?php echo $this->formFieldError('job_id'); ?>
        <p class="help-block">
            Aktifitas atau pekerjaan anda saat ini.
        </p>
    </div>

    <div class="form-group">
        <?php echo $this->insert('sections::captcha') ?>

        <input value="Register" type="submit" class="btn btn-primary" />
    </div>

</form>
