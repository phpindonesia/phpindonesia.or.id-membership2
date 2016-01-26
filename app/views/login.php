<?php $this->layout('layouts::system') ?>

<div class="full-width-section parallax full-section-bg">
	<div class="container">
		<div class="dt-sc-clear"></div>
		<div class="form-wrapper register">
			<form action="<?php echo $this->pathFor('membership-login'); ?>" method="post" novalidate>

				<?php
				echo $this->insert('sections::flash-message');
				?>

				<h3 class="aligncenter"> <span> <i class="fa fa-user"></i></span> Login Anggota</h3>

				<table style="width: 80%; margin: 0 auto;">
                    <tbody>
                        <tr>
                            <th style="width: 200px;">
                                <label style="font-weight: bold;">Username / Email</label>
                            </th>
                            <td>
                                <input id="username" class="input_full" name="username" required="required" type="text" style="font-size: 15px;" />
                            </td>
                        </tr>

                        <tr>
                            <th style="width: 200px;">
                                <label style="font-weight: bold;">Password</label>
                            </th>
                            <td>
                                <input id="password" class="input_full" name="password" required="required" type="password" style="font-size: 15px;" />
                            </td>
                        </tr>

                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <td>
                                <input value="Login" class="button" type="submit" />
                            </td>
                        </tr>
                    </tbody>
                </table>

			</form>
		</div>
	</div>
</div>

<div class="full-width-section">
	<div class="container">
		<div class="dt-sc-margin70"></div>
		<div class="page_info aligncenter">
			<h4 class="title">Bantuan Login?</h4>
			<p>Jika belum terdaftar sebagai anggota, <a href="<?php echo $this->pathFor('membership-register'); ?>" title="">Daftar Disini</a> menjadi anggota PHP Indonesia.</p>
			<p>Hilang atau lupa password login, silahkan <a href="<?php echo $this->pathFor('membership-password-forgot'); ?>" title="">Reset Password</a> Anda.</p>
		</div>
	</div>
</div>
<div class="dt-sc-margin100"></div>
