<?php $this->layout('layouts::layout-system'); ?>

<?php
$this->append_js(array(
    $this->uri_base_url().'/public/js/app/membership/index.js'
));
?>

<section id="primary" class="content-full-width">
	<div class="full-width-section">			

		<div class="container" style="margin-top: -50px;">

			<div style="margin: 0; padding: 0; margin-top: -20px;">
				<?php
				echo $this->insert('sections::flash-message');
				?>
		    </div>

			<h2 class="aligncenter">Anggota PHP Indonesia</h2>

			<div class="woocommerce" style="padding:0px 30px; margin-bottom: -50px;">
				<form name="searchform" method="get" class="checkout" action="<?php echo $this->uri_path_for('membership-index'); ?>">
					<div class="col2-set" id="customer_details">

						<div class="col-1">

							<div class="form-row form-row-first" style="width: 100%;">
								<label for="provinces-dd" style="font-weight: bold;">Provinsi</label>
								<div class="selection-box">
								<?php
								echo $this->fh_input_select('province_id', $provinces, array(
									'id' => 'provinces-dd'
								));
								?>
								</div>
							</div>

							<div class="form-row form-row-wide">
								<label for="area" style="font-weight: bold;">Area</label>
								<input type="text" id="area" name="area" value="<?php echo $this->fh_default_val('area', null, true); ?>" />
							</div>

						</div>

						<div class="col-2">

							<div class="form-row form-row-first" style="width: 100%;">
								<label for="cities-dd" style="font-weight: bold;">Kabupaten / Kota</label>
								<div class="selection-box">
								<?php
								echo $this->fh_input_select('city_id', $cities, array(
									'id' => 'cities-dd'
								));
								?>
								</div>
							</div>

							<div class="form-row form-row-wide">
								<label>&nbsp;</label>
								<input value="Search" type="submit" />
							</div>

						</div>
					</div>

				</form><hr />
			</div>
			
			<?php
			$no = 1;
			foreach($members as $member):
			?>

			<?php
			if ($no%4 == 1):
			?>

			<div class="dt-sc-hr-invisible-small"></div>

			<?php
			endif;
			?>

			<div class="column dt-sc-one-fourth <?php echo ($no == '1' || $no%4 == 1 ? 'first' : ''); ?>">

				<div class="dt-sc-team">
					<div class="image">
						<img src="<?php echo $this->uri_user_photo($member['photo'], ['width' => '140', 'height' => '140']) ?>" alt="" style="width: 140px; height: 140px;" />
					</div>

					<div class="team-details">
						<h6><a href="<?php echo $this->uri_path_for('membership-detail', array('name' => $member['username'])); ?>"><?php echo $member['fullname']; ?></a></h6>

						<p>
							<?php echo $member['province'].', '.$member['city']; ?>
						</p>

					</div>

				</div>

			</div>

			<?php
			$no++;
			endforeach;
			?>
			
			<p>&nbsp;</p>

			<div class="pagination" style="text-align:center;">
			<?php
			echo $html_view_pager;
			?>
			</div>

		</div>

		<div class="dt-sc-hr-invisible-small"></div>
		<div class="dt-sc-margin50"></div>
	</div>
</section>