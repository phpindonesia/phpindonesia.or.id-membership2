<?php $this->layout('layouts::account') ?>

<form action="<?php echo $this->pathFor('membership-login'); ?>" method="post" novalidate class="form-horizontal">
    <h3 class="aligncenter"> <i class="fa fa-user"></i> Login Anggota</h3>

    <div class="form-group">
        <label for="login" class="control-label">Username / Email</label>
        <input id="login" class="form-control" name="login" required="required" type="text" value="<?php echo $this->requestBody('login'); ?>" />
        <?php echo $this->formFieldError('login') ?>
    </div>

    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input id="password" class="form-control" name="password" required="required" type="password" value="<?php echo $this->requestBody('password'); ?>" />
        <?php echo $this->formFieldError('password') ?>
    </div>

    <div class="form-group">
        <input value="Login" type="submit" class="btn btn-primary" />
    </div>

</form>
