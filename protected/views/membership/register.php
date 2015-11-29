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

		<div class="container" style="margin-top: -70px;">

            <h3 class="aligncenter"> <span> <i class="fa fa-user"></i></span> Registrasi Anggota</h3>

            <?php
            echo $this->insert('sections::flash-message');
            ?>

            <form action="<?php echo $this->uri_path_for('membership-register'); ?>" method="post" novalidate>

                <table class="form-oprek">
                    <tbody>
                        <tr>
                            <th>
                                <label for="email" style="font-weight: bold;">Email *</label>
                            </th>
                            <td>
                            	<input id="email" class="input_full" name="email" type="email" value="<?php echo $this->fh_default_val('email'); ?>" />
                            	<?php
                            	echo $this->fh_show_errors('email', $_view_validation_errors_);
                            	?>
                            </td>

                            <th>
                                <label for="username" style="font-weight: bold;">Username *</label>
                            </th>
                            <td>
                            	<input id="username" class="input_full" name="username" type="text" value="<?php echo $this->fh_default_val('username'); ?>" />
                            	<?php
                            	echo $this->fh_show_errors('username', $_view_validation_errors_);
                            	?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="password" style="font-weight: bold;">Password *</label>
                            </th>
                            <td>
                                <input id="password" class="input_full" name="password" type="password" value="<?php echo $this->fh_default_val('password'); ?>" />
                                <?php
                                echo $this->fh_show_errors('password', $_view_validation_errors_);
                                ?>
                            </td>

                            <th>
                                <label for="repassword" style="font-weight: bold;">Ketik ulang password *</label>
                            </th>
                            <td>
                                <input id="repassword" class="input_full" name="repassword" type="password" value="<?php echo $this->fh_default_val('repassword'); ?>" />
                                <?php
                                echo $this->fh_show_errors('repassword', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="provinces-dd" style="font-weight: bold;">Provinsi *</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('province_id', $provinces, array(
                                	'id' => 'provinces-dd',
                                	'class' => 'input_full'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('province_id', $_view_validation_errors_);
                                ?>
                            </td>

                            <th>
                                <label for="cities-dd" style="font-weight: bold;">Kabupaten / Kota *</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('city_id', $cities, array(
                                	'id' => 'cities-dd',
                                	'class' => 'input_full'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('city_id', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="fullname" style="font-weight: bold;">Nama Lengkap *</label>
                            </th>
                            <td>
                                <input id="fullname" class="input_full" name="fullname" type="text" value="<?php echo $this->fh_default_val('fullname'); ?>" />
                                <?php
                                echo $this->fh_show_errors('fullname', $_view_validation_errors_);
                                ?>
                            </td>

                            <th>
                                <label for="gender-dd" style="font-weight: bold;">Gender *</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('gender_id', array('female' => 'Wanita', 'male' => 'Pria'), array(
                                	'id' => 'gender-dd',
                                	'class' => 'input_full'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('gender_id', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="job-id" style="font-weight: bold;">Pekerjaan *</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('job_id', $jobs, array(
                                	'id' => 'job-id',
                                	'class' => 'input_full'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('job_id', $_view_validation_errors_);
                                ?>
                            </td>

                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="area" style="font-weight: bold;">Area Domisili *</label>
                            </th>
                            <td>
                                <input id="area" class="input_full" name="area" type="text" value="<?php echo $this->fh_default_val('area'); ?>" placeholder="Area Domisili. Contoh format: Nama Kelurahan, Nama Kecamatan atau Nama Daerah Tempat Tinggal, Nama Kota Madya" />
                                <?php
                                echo $this->fh_show_errors('area', $_view_validation_errors_);
                                ?>
                            </td>

                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>

                    </tbody>
                </table>

                <table class="form-oprek">
                    <tbody>
                        <tr>
                            <td>
                                &nbsp;
                            </td>

                            <td>
                                <?php
                                if ($use_captcha == true):
                                ?>
                                
                                <input id="foo-captcha" name="captcha" type="hidden" value="1" />
                                <?php echo $this->fh_show_errors('captcha', $_view_validation_errors_); ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo $gcaptcha_site_key; ?>"></div>
                                
                                <?php
                                endif;
                                ?>

                                <input value="Register" type="submit" />
                            </td>

                            <td>
                                &nbsp;
                            </td>

                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>
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

</section>
