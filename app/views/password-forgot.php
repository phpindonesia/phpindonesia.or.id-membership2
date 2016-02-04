<?php $this->layout('layouts::account') ?>

<form action="<?php echo $this->pathFor('membership-forgot-password'); ?>" method="post" novalidate>

    <h3 class="aligncenter"> <i class="fa fa-key"></i> Forgot Password</h3>

    <div class="form-group">
        <label for="email" class="control-label">Email *</label>
        <input id="email" class="form-control" name="email" required="required" type="email" value="<?php echo $this->requestBody('email'); ?>" />
        <?php echo $this->formFieldError('email'); ?>
        <p class="help-block">
            Informasi konfirmasi lupa password akan kami kirimkan ke email anda. Demi keamanan
            dan validitas data maka kami tidak langsung mengirimkan password ke email anda. Tetapi,
            mengkonfirmasi terlebih dahulu bahwa anda benar-benar secara sadar telah lupa password.
        </p>
    </div>

    <div class="form-group">
        <?php echo $this->insert('sections::captcha') ?>

        <input value="Confirm" type="submit" class="btn btn-primary" />
    </div>

</form>
