<?php $this->layout('layouts::account') ?>

<form action="<?php echo $this->pathFor('membership-account-password-update'); ?>" method="post" novalidate>
    <?php echo $this->formInputMethod('PUT') ?>

    <h3 class="aligncenter"> <i class="fa fa-key"></i> Update Password</h3>

    <div class="form-group">
        <label for="oldpassword" class="control-label">Old Password *</label>
        <input id="oldpassword" class="form-control" name="oldpassword" required="required" type="password" value="<?php echo $this->requestBody('oldpassword'); ?>" />
        <?php echo $this->formFieldError('oldpassword'); ?>
    </div>

    <div class="form-group">
        <label for="password" class="control-label">New Password *</label>
        <input id="password" class="form-control" name="password" required="required" type="password" value="<?php echo $this->requestBody('password'); ?>" />
        <?php echo $this->formFieldError('password'); ?>
    </div>

    <div class="form-group">
        <label for="repassword" class="control-label">Retype New Password *</label>
        <input id="repassword" class="form-control" name="repassword" required="required" type="password" value="<?php echo $this->requestBody('repassword'); ?>" />
        <?php echo $this->formFieldError('repassword'); ?>
    </div>

    <div class="form-group">
        <?php echo $this->insert('sections::captcha') ?>

        <input value="Update" type="submit" class="btn btn-primary" />
    </div>

</form>
