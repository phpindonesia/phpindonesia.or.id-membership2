<?php $this->layout('layouts::layout-system'); ?>

<div class="full-width-section parallax full-section-bg">
	<div class="container">
		<div class="dt-sc-clear"></div>                            
		<div class="form-wrapper register" style="margin-top: -170px;">

			<form action="<?php echo $this->uri_path_for('membership-forgot-password'); ?>" method="post" novalidate>
				<?php
				echo $this->insert('sections::flash-message');
				?>

				<h3 class="aligncenter"> <span> <i class="fa fa-key"></i></span> Forgot Password</h3>

				<div>
					<label style="font-weight: bold;">Email</label>
					<input id="email" name="email" type="text" value="<?php echo $this->fh_default_val('email'); ?>" />
					<?php echo $this->fh_show_errors('email', $_view_validation_errors_); ?>

					<p>
						Informasi konfirmasi lupa password akan kami kirimkan ke email anda. Demi keamanan 
						dan validitas data maka kami tidak langsung mengirimkan password ke email anda. Tetapi,
						mengkonfirmasi terlebih dahulu bahwa anda benar-benar secara sadar telah lupa password.
					</p>
				</div>

				<div class="clearfix">
					<input value="Confirm" class="button" type="submit" />
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
			<h4 class="title">Bantuan Login?</h4>
			<p>Jika belum terdaftar sebagai anggota, <a href="<?php echo $this->uri_path_for('membership-register'); ?>" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.</p>
		</div>
	</div>
</div>
<div class="dt-sc-margin100"></div>