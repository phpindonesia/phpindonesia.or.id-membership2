<?php $this->layout('layouts::account') ?>

<form action="<?php echo $this->pathFor('membership-login'); ?>" method="post" novalidate class="form-horizontal">
    <h3 class="aligncenter"> <i class="fa fa-user"></i> Login Anggota</h3>

    <div class="form-group">
        <label for="username" class="control-label">Username / Email</label>
        <input id="username" class="form-control" name="username" required="required" type="text" value="<?php echo $this->requestParam('username'); ?>" />
    </div>

    <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input id="password" class="form-control" name="password" required="required" type="text" value="<?php echo $this->requestParam('password'); ?>" />
    </div>

    <div class="form-group">
        <input value="Login" type="submit" class="btn btn-primary" />
    </div>

</form>
