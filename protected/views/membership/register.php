 <?php
$this->layout('layouts::layout-system');
?>

<?php
$this->append_js(array(
  $this->uri_base_url().'/public/js/app/membership/register.js'
));
?>

<section id="primary" class="content-full-width">
	<div class="full-width-section">
		<div class="container" style="margin-top: -50px;">

			<h3> <span> <i class="fa fa-user"></i></span> Registrasi Anggota</h3>
			<?php echo $this->insert('sections::flash-message'); ?>

			<form action="<?php echo $this->uri_path_for('membership-register'); ?>" method="post" novalidate class="form-horizontal">
				<div class="row">
					
					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
							<label for="email" class="control-label">Alamat Email</label>
							<input type="email" id="email" name="email" class="form-control" value="<?php echo $this->fh_default_val('email'); ?>" />
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('email', $_view_validation_errors_); ?>
								Masukkan alamat email yang masih aktif.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
							<label for="username" class="control-label">Username</label>
							<input type="text" id="username" name="username" class="form-control" value="<?php echo $this->fh_default_val('username'); ?>" />
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('username', $_view_validation_errors_); ?>
								Masukkan <em>username</em> yang anda inginkan.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
							<label for="password" class="control-label">Password</label>
							<input type="password" id="password" name="password" class="form-control" value="<?php echo $this->fh_default_val('password'); ?>" />
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('password', $_view_validation_errors_); ?>
								Masukkan <em>password</em> yang anda inginkan.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
							<label for="repassword" class="control-label">Konfirmasi Password</label>
							<input type="password" id="repassword" name="repassword" class="form-control" value="<?php echo $this->fh_default_val('repassword'); ?>" />
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('repassword', $_view_validation_errors_); ?>
								Konfirmasikan ulang <em>password</em> yang anda masukkan.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
							<label for="fullname" class="control-label">Nama Lengkap *</label>
							<input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $this->fh_default_val('fullname'); ?>" />
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('fullname', $_view_validation_errors_); ?>
								Masukkan <em>nama lengkap</em> anda
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
	                        <label for="gender-dd" class="control-label">Gender *</label>
	                        <?php
	                        echo $this->fh_input_select('gender_id', array('female' => 'Wanita', 'male' => 'Pria'), array(
	                        	'id' => 'gender-dd',
	                        	'class' => 'form-control'
	                        ));
	                        ?>
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('gender_id', $_view_validation_errors_); ?>
								Gender
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
	                        <label for="provinces-dd" class="control-label">Provinsi *</label>
	                        <?php echo $this->fh_input_select('province_id', $provinces, array(
		                        	'id' => 'provinces-dd',
		                        	'class' => 'form-control'
		                        ));
	                        ?>
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('province_id', $_view_validation_errors_); ?>
								Masukkan <em>propinsi</em> wilayah anda bertempat tinggal.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
	                        <label for="cities-dd" class="control-label">Kabupaten / Kota *</label>
	                        <?php
	                        echo $this->fh_input_select('city_id', $cities, array(
	                        	'id' => 'cities-dd',
	                        	'class' => 'form-control'
	                        ));
	                        ?>
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('city_id', $_view_validation_errors_); ?>
								Masukkan <em>kota</em> atau <em>kabupaten</em> wilayah anda bertempat tinggal.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
							<label for="area" class="control-label">Area Domisili *</label>
							<input type="text" id="area" name="area" class="form-control" value="<?php echo $this->fh_default_val('area'); ?>" />
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('area', $_view_validation_errors_); ?>
								Masukkan wilayah <em>domisili, kecamatan, atau desa</em> tempat anda sekarang tinggal.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-5">
						<div class="form-group">
	                        <label for="job-id" class="control-label">Pekerjaan *</label>
	                        <?php
	                        echo $this->fh_input_select('job_id', $jobs, array(
	                        	'id' => 'job-id',
	                        	'class' => 'form-control'
	                        ));
	                        ?>
							<p class="help-block">
	                        	<?php echo $this->fh_show_errors('job_id', $_view_validation_errors_); ?>
								Aktifitas atau pekerjaan anda saat ini.
							</p>
						</div>
					</div>

					<div class="col-xs-10 col-sm-10">
						<div class="form-group">
                            <?php if ($use_captcha == true): ?>
	                            <input id="foo-captcha" name="captcha" type="hidden" value="1" />
	                            <?php echo $this->fh_show_errors('captcha', $_view_validation_errors_); ?>
	                            <div class="g-recaptcha" style="margin-bottom:10px;" data-sitekey="<?php echo $gcaptcha_site_key; ?>"></div>
                            <?php endif; ?>
                            <input value="Register" type="submit" />
						</div>
					</div>

				</div>
		    </form>

		</div> <!-- container -->
	</div> <!-- full width section -->

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

</section> <!-- section primary -->
