<?php $this->layout('layouts::layout-system'); ?>

<div class="full-width-section">
	<div class="container">

		<div class="column dt-sc-two-fifth first">

			<div class="dt-sc-team">
				<div class="image">
					<?php
					if ($member['photo'] == '' || $member['photo'] == null):
					?>

					<img src="<?php echo $this->uri_base_url().'/public/images/team.png'; ?>" alt="" />

					<?php
					else:
					?>

					<img src="<?php echo $this->uri_base_url().'/public/files/photoprofile/'.$member['photo']; ?>" alt="" style="width: 180px; height: 180px;" />

					<?php
					endif;
					?>
				</div>

				<div class="team-details">
					<h6><?php echo $member['fullname']; ?></h6>

					<br />

					<ul class="dt-sc-social-icons">
						<?php
						foreach ($member_socmeds as $socmed_item):
						?>

						<li style="margin-right: 5px; padding: 3px; border: 1px #DDDDDD solid;">
							<span class="fa <?php echo $socmedias_logo[$socmed_item['socmed_type']]; ?>"></span>
							<?php echo $socmed_item['account_name']; ?>
						</li>

						<?php
						endforeach;
						?>
					</ul>
				</div>

			</div>

		</div>

		<div class="column dt-sc-three-fifth">
			<article class="blog-post">
				<div class="entry-body">
					<div class="table-responsive">

						<table class="table table-hover">
							<tbody>
								<tr>
									<td style="width:200px; font-weight: bold;">Nama Lengkap</td>
									<td>: <?php echo ($member['fullname'] == '' ? '-' : $member['fullname']); ?></td>
								</tr>

								<tr>
									<td style="width:200px; font-weight: bold;">Gender</td>
									<td>: <?php echo ($member['gender'] == '' ? '-' : $member['gender']); ?></td>
								</tr>

								<tr>
									<td style="width:200px; font-weight: bold;">Daerah Kelahiran</td>
									<td>: <?php echo ($member['birth_place'] == '' ? '-' : $member['birth_place']); ?></td>
								</tr>

								<tr>
									<td style="width:200px; font-weight: bold;">Domisili</td>
									<td>: <?php echo $member['province'].', '.$member['city'].', '.$member['area']; ?></td>
								</tr>

							</tbody>
						</table>

					</div>
				</div>
			</article>
		</div>
	</div>

	<div class="dt-sc-margin50"></div>

	<div class="container">
		<p align="center"><a href="<?php echo $this->uri_path_for('membership-index'); ?>" class="button" style="color:#fff;">Back To Membership Page</a></p>
	</div>

	<div class="dt-sc-margin50"></div>
</div>

<div class="dt-sc-margin50"></div>