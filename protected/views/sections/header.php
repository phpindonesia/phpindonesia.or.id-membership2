<div class="top-bar">
	<div class="container">
		<ul class="top-menu">
			<li><i class="fa fa-home"></i> Bersama Berkarya Berjaya</li>
			<li><i class="fa fa-envelope"></i> info<span>[at]</span>phpindonesia.or.id</li>
		</ul>

		<div class="top-right">
			<span>Social Media PHP Indonesia</span>
			<ul class="dt-sc-social-icons">
				<li><a href="https://www.facebook.com/groups/35688476100" title="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<li><a href="https://www.twitter.com/php_indonesia" title="twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
				<li><a href="http://www.youtube.com/user/OurPHPIndonesia" title="youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
			</ul>
		</div>
	</div>
</div>

<div id="header-wrapper">
	<header class="header">
		<div class="container">
			<div id="logo">
				<a href="http://www.phpindonesia.or.id" title="PHP Indonesia"><img src="<?php echo $this->uri_base_url().'/public/images/logo.png'; ?>" alt="PHP Indonesia" height="57" /></a>
			</div>

			<div id="menu-container">
				<nav id="main-menu">
					<div id="dt-menu-toggle" class="dt-menu-toggle">
						Menu <span class="dt-menu-toggle-icon"></span>
					</div>

					<ul class="menu">
						<li><a href="http://www.phpindonesia.or.id/./">Home</a></li>
						<li class="menu-item-simple-parent"><a href="http://www.phpindonesia.or.id/pages/tentang-kami">Tentang Kami</a>
							<ul class="sub-menu">
								<li><a href="http://www.phpindonesia.or.id/pages/sejarah">Sejarah</a></li>
								<li><a href="http://www.phpindonesia.or.id/pages/struktur-organisasi">Struktur Organisasi</a></li>
								<li><a href="http://www.phpindonesia.or.id/pages/kepengurusan">Kepengurusan</a></li>
							</ul><a class="dt-menu-expand">+</a>
						</li>

						<li class="menu-item-simple-parent">
							<a href="http://www.phpindonesia.or.id/pages/program-kerja">Program Kerja</a>
							<ul class="sub-menu">
								<li><a href="http://www.phpindonesia.or.id/pages/program-kerja-nasional">Nasional</a></li>
								<li><a href="http://www.phpindonesia.or.id/pages/program-kerja-daerah">Daerah</a></li>
							</ul>
							<a class="dt-menu-expand">+</a>
						</li>

						<li class="menu-item-simple-parent">
							<a href="http://www.phpindonesia.or.id/pages/ad-art">Dokumen</a>
							<ul class="sub-menu">
								<li><a href="http://www.phpindonesia.or.id/pages/ad-art">AD/ART</a></li>
								<li><a href="http://www.phpindonesia.or.id/pages/surat-keputusan">Surat Keputusan</a></li>
								<li><a href="http://www.phpindonesia.or.id/listevent">Event</a></li>
							</ul>
							<a class="dt-menu-expand">+</a>
						</li>

						<li class="menu-item-simple-parent">
							<a href="http://www.phpindonesia.or.id/album">Galeri</a>
							<ul class="sub-menu">
								<li><a href="http://www.phpindonesia.or.id/album">Photo</a></li>
								<li><a href="http://www.phpindonesia.or.id/valbum">Video</a></li>
							</ul>
							<a class="dt-menu-expand">+</a>
						</li>

						<?php if (!isset($_SESSION['MembershipAuth'])): ?>
						<li class="menu-item-simple-parent">
							<a href="<?=$this->uri_path_for('membership-index')?>">Anggota</a>
							<ul class="sub-menu">
								<li><a href="<?=$this->uri_path_for('membership-login')?>">Login</a></li>
								<li><a href="<?=$this->uri_path_for('membership-register')?>">Register</a></li>
								<li><a href="<?=$this->uri_path_for('membership-forgot-password')?>">Forgot Password</a></li>
							</ul>
						</li>
						<?php endif ?>

						<li><a href="http://www.phpindonesia.or.id/contact">Kontak</a></li>

						<?php
						if (isset($_SESSION['MembershipAuth'])):
						?>
						<li class="menu-item-simple-parent">
						    <a href="<?php echo $this->uri_path_for('membership-profile'); ?>" style="text-decoration: underline; color:#478BCA;">

						    	<?php
						    	if ($_SESSION['MembershipAuth']['photo'] == '' || $_SESSION['MembershipAuth']['photo'] == null):
						    	?>

						    	<img style="display: block; position: absolute; right: -40px; bottom: 21px; width: 40px; height: 40px;" src="<?php echo $this->uri_base_url().'/public/images/team.png'; ?>" alt="" />

						    	<?php
						    	else:
						    	?>

						        <img style="display: block; position: absolute; right: -40px; bottom: 21px; width: 40px; height: 40px;" src="<?php echo $this->uri_base_url().'/public/files/photoprofile/'.$_SESSION['MembershipAuth']['photo']; ?>" alt="" />

						        <?php
						        endif;
						        ?>

						    	<?php
						    	echo '( '.$_SESSION['MembershipAuth']['username'].' )';
						    	?>
						    </a>
						    <ul class="sub-menu">
						    	<li><a href="<?php echo $this->uri_path_for('membership-profile'); ?>">My Membership Area</a></li>
								<li><a href="<?php echo $this->uri_path_for('membership-update-password'); ?>">Update Password</a></li>
								<li><a href="<?php echo $this->uri_path_for('membership-logout'); ?>">Logout</a></li>
							</ul>
						</li>
						<?php
						endif;
						?>
					</ul>
				</nav>
			</div>
		</div>
	</header>
</div>
