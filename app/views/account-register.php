<?php $this->layout('layouts::account') ?>

<?php $this->appendJs([
    $this->asset('/asset/js/register.js')
]) ?>

<form action="<?php echo $this->pathFor('membership-register'); ?>" method="post" novalidate class="form-horizontal">
    <h3 class="aligncenter"> <span> <i class="fa fa-user"></i></span> Registrasi Anggota</h3>

    <div class="row">

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="email" class="control-label">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $this->requestParam('email'); ?>" />
                <p class="help-block">
                    <?php echo $this->formShowErrors('email', $validation_errors); ?>
                    Masukkan alamat email yang masih aktif.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $this->requestParam('username'); ?>" />
                <p class="help-block">
                    <?php echo $this->formShowErrors('username', $validation_errors); ?>
                    Masukkan <em>username</em> yang anda inginkan.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $this->requestParam('password'); ?>" />
                <p class="help-block">
                    <?php echo $this->formShowErrors('password', $validation_errors); ?>
                    Masukkan <em>password</em> yang anda inginkan.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="repassword" class="control-label">Konfirmasi Password</label>
                <input type="password" id="repassword" name="repassword" class="form-control" value="<?php echo $this->requestParam('repassword'); ?>" />
                <p class="help-block">
                    <?php echo $this->formShowErrors('repassword', $validation_errors); ?>
                    Konfirmasikan ulang <em>password</em> yang anda masukkan.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="fullname" class="control-label">Nama Lengkap *</label>
                <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $this->requestParam('fullname'); ?>" />
                <p class="help-block">
                    <?php echo $this->formShowErrors('fullname', $validation_errors); ?>
                    Masukkan <em>nama lengkap</em> anda
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="gender-dd" class="control-label">Gender *</label>
                <?php echo $this->formInputSelect('gender_id', ['female' => 'Wanita', 'male' => 'Pria'], [
                    'id' => 'gender-dd',
                    'class' => 'form-control'
                ]); ?>
                <p class="help-block">
                    <?php echo $this->formShowErrors('gender_id', $validation_errors); ?>
                    Gender
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="provinces-dd" class="control-label">Provinsi *</label>
                <?php echo $this->formInputSelect('province_id', $provinces, [
                    'id' => 'provinces-dd',
                    'class' => 'form-control'
                ]); ?>
                <p class="help-block">
                    <?php echo $this->formShowErrors('province_id', $validation_errors); ?>
                    Masukkan <em>propinsi</em> wilayah anda bertempat tinggal.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="cities-dd" class="control-label">Kabupaten / Kota *</label>
                <?php echo $this->formInputSelect('city_id', $cities, [
                    'id' => 'cities-dd',
                    'class' => 'form-control'
                ]); ?>
                <p class="help-block">
                    <?php echo $this->formShowErrors('city_id', $validation_errors); ?>
                    Masukkan <em>kota</em> atau <em>kabupaten</em> wilayah anda bertempat tinggal.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="area" class="control-label">Area Domisili *</label>
                <input type="text" id="area" name="area" class="form-control" value="<?php echo $this->requestParam('area'); ?>" />
                <p class="help-block">
                    <?php echo $this->formShowErrors('area', $validation_errors); ?>
                    Masukkan wilayah <em>domisili, kecamatan, atau desa</em> tempat anda sekarang tinggal.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="job-id" class="control-label">Pekerjaan *</label>
                <?php echo $this->formInputSelect('job_id', $jobs, [
                    'id' => 'job-id',
                    'class' => 'form-control'
                ]); ?>
                <p class="help-block">
                    <?php echo $this->formShowErrors('job_id', $validation_errors); ?>
                    Aktifitas atau pekerjaan anda saat ini.
                </p>
            </div>
        </div>

        <div class="col-xs-10 col-sm-10">
            <div class="form-group">
                <?php if ($gcaptchaEnable == true): ?>
                    <input id="foo-captcha" name="captcha" type="hidden" value="1" />
                    <?php echo $this->formShowErrors('captcha', $validation_errors); ?>
                    <div class="g-recaptcha" style="margin-bottom:10px;" data-sitekey="<?php echo $gcaptchaSitekey; ?>"></div>
                <?php endif; ?>
                <input value="Register" type="submit" class="btn btn-primary" />
            </div>
        </div>

    </div>
</form>
