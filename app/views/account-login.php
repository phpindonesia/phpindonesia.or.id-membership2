<?php $this->layout('layouts::account') ?>

<form action="<?php echo $this->pathFor('membership-login'); ?>" method="post" novalidate class="form-horizontal">
    <h3 class="aligncenter"> <span> <i class="fa fa-user"></i></span> Login Anggota</h3>

    <div class="row">

        <div class="col-xs-10 col-sm-5">
            <div class="form-group">
                <label for="username" class="control-label">Username / Email</label>
                <input id="username" class="form-control" name="username" required="required" type="text" value="<?php echo $this->requestParam('username'); ?>" />
            </div>
        </div>

        <div class="col-xs-10 col-sm-5">
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input id="password" class="form-control" name="password" required="required" type="text" value="<?php echo $this->requestParam('password'); ?>" />
            </div>
        </div>

        <div class="col-xs-10 col-sm-10">
            <div class="form-group">
                <input value="Login" type="submit" class="btn btn-primary" />
            </div>
        </div>

    </div>
</form>
