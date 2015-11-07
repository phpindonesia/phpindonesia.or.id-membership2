<?php
$this->layout('layouts::layout-system');
?>

<?php
$this->append_js(array(
    $this->uri_base_url().'/public/js/app/membership/register.js'
));
?>

<div class="full-width-section parallax full-section-bg">
	<div class="container">
		<div class="dt-sc-clear"></div>
		<div class="form-wrapper register" style="margin-top: -150px;">
			<form action="<?php echo $this->uri_path_for('membership-register'); ?>" method="post" novalidate>

				<?php
				echo $this->insert('sections::flash-message');
				?>

				<h3 class="aligncenter"> <span> <i class="fa fa-user"></i></span> Registrasi Anggota</h3>

				<div class="dt-sc-one-half column first">
					<label for="email" style="font-weight: bold;">Email *</label>
					<input id="email" name="email" type="email" value="<?php echo $this->fh_default_val('email'); ?>" />
					<?php echo $this->fh_show_errors('email', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column">
					<label for="username" style="font-weight: bold;">Username *</label>
					<input id="username" name="username" type="text" value="<?php echo $this->fh_default_val('username'); ?>" />
					<?php echo $this->fh_show_errors('username', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column first">
					<label for="password" style="font-weight: bold;">Password *</label>
					<input id="password" name="password" type="password" value="<?php echo $this->fh_default_val('password'); ?>" />
					<?php echo $this->fh_show_errors('password', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column">
					<label for="repassword" style="font-weight: bold;">Ketik ulang password *</label>
					<input id="repassword" name="repassword" type="password" value="<?php echo $this->fh_default_val('repassword'); ?>" />
					<?php echo $this->fh_show_errors('repassword', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column first">
					<label for="provinces-dd" style="font-weight: bold;">Provinsi *</label>

					<?php
					echo $this->fh_input_select('province_id', $provinces, array(
						'id' => 'provinces-dd'
					));
					?>

					<?php echo $this->fh_show_errors('province_id', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column">
					<label for="cities-dd" style="font-weight: bold;">Kabupaten / Kota *</label>

					<?php
					echo $this->fh_input_select('city_id', $cities, array(
						'id' => 'cities-dd'
					));
					?>

					<?php echo $this->fh_show_errors('city_id', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column first">
					<label for="fullname" style="font-weight: bold;">Nama Lengkap *</label>
					<input id="fullname" name="fullname" type="text" value="<?php echo $this->fh_default_val('fullname'); ?>" />
					<?php echo $this->fh_show_errors('fullname', $_view_validation_errors_); ?>
				</div>

				<div class="dt-sc-one-half column">
					<label for="gender-dd" style="font-weight: bold;">Gender *</label>

					<?php
					echo $this->fh_input_select('gender_id', array('female' => 'Wanita', 'male' => 'Pria'), array(
						'id' => 'gender-dd'
					));
					?>

					<?php echo $this->fh_show_errors('gender_id', $_view_validation_errors_); ?>
				</div>

				<div class="clearfix" style="clear: both;">
					<label for="job-id" style="font-weight: bold;">Pekerjaan *</label>
					<?php
					echo $this->fh_input_select('job_id', $jobs, array(
						'id' => 'job-id'
					));
					?>

					<?php echo $this->fh_show_errors('job_id', $_view_validation_errors_); ?>
				</div>

				<div class="clearfix" style="clear: both;">
					<label for="area" style="font-weight: bold;">Area Domisili *</label>
					<input id="area" name="area" type="text" value="<?php echo $this->fh_default_val('area'); ?>" placeholder="Area Domisili. Contoh format: Nama Kelurahan, Nama Kecamatan atau Nama Daerah Tempat Tinggal, Nama Kota Madya" />
					<?php echo $this->fh_show_errors('area', $_view_validation_errors_); ?>
				</div>

				<div class="clearfix" style="clear: both;">
					<input value="Register" class="button" type="submit" />
				</div>

				<?php
				if ($use_captcha == true):
				?>
			    <input id="foo-captcha" name="captcha" type="hidden" value="1" />
			    <?php echo $this->fh_show_errors('captcha', $_view_validation_errors_); ?>
				<div class="g-recaptcha" data-sitekey="<?php echo $gcaptcha_site_key; ?>"></div>
				<?php
				endif;
				?>

			</form>
		</div>
	</div>
</div>

<div class="full-width-section">
	<div class="container">
		<div class="dt-sc-margin70"></div>
		<div class="page_info aligncenter">
			<p>Sudah pernah terdaftar menjadi anggota PHP Indonesia, silahkan <a href="<?php echo $this->uri_path_for('membership-login'); ?>" title="">Login Disini</a>.</p>
						<p>Hilang atau lupa password login, silahkan <a href="<?php echo $this->uri_path_for('membership-forgot-password'); ?>" title="">Reset Password</a> Anda.</p>
		</div>
	</div>
</div>
<div class="dt-sc-margin100"></div>
