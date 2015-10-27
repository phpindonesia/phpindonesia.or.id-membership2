<?php $this->layout('layouts::layout-system'); ?>

<div class="full-width-section parallax full-section-bg">
	<div class="container">
		<div class="dt-sc-clear"></div>                            
		<div class="form-wrapper register" style="margin-top: -150px;">
			<form action="<?php echo $this->uri_path_for('membership-update-password'); ?>" method="post" novalidate>

				<?php
				echo $this->insert('sections::flash-message');
				?>

				<h3 class="aligncenter"> <span> <i class="fa fa-key"></i></span> Update Password</h3>

				<div>
					<label for="oldpassword" style="font-weight: bold;">Old Password</label>
					<input id="oldpassword" name="oldpassword" type="password" value="<?php echo $this->fh_default_val('oldpassword'); ?>" />
					<?php echo $this->fh_show_errors('oldpassword', $_view_validation_errors_); ?>
				</div>

				<div>
					<label for="password" style="font-weight: bold;">New Password</label>
					<input id="password" name="password" type="password" value="<?php echo $this->fh_default_val('password'); ?>" />
					<?php echo $this->fh_show_errors('password', $_view_validation_errors_); ?>
				</div>

				<div>
					<label for="repassword" style="font-weight: bold;">Retype New Password</label>
					<input id="repassword" name="repassword" type="password" value="<?php echo $this->fh_default_val('repassword'); ?>" />
					<?php echo $this->fh_show_errors('repassword', $_view_validation_errors_); ?>
				</div>

				<div class="clearfix">
					<button type="button" onclick="location.href='<?php echo $this->uri_path_for('membership-profile'); ?>';" class="button" style="color:#fff; margin-left: 10px;">Cancel</button>
					<input value="Update" class="button" type="submit" />
				</div>
				
			</form>
		</div>
	</div>
</div>
