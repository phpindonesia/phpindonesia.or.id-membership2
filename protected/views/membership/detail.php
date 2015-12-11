<?php $this->layout('layouts::layout-system'); ?>

<div class="full-width-section">
	<div class="container">

		<div class="column dt-sc-two-fifth first">

			<div class="dt-sc-team">

				<div class="image">
                    <img src="<?php echo $this->uri_user_photo($member['photo'], ['width' => '180', 'height' => '180']) ?>" alt="" />
				</div>

				<div class="team-details">
					<h6><?php echo filter_var(trim($member['fullname'])); ?></h6>

					<br />

					<ul class="dt-sc-social-icons">
						<?php
						foreach ($member_socmeds as $socmed_item):
							?>

							<li style="margin-right: 5px; padding: 3px; border: 1px #DDDDDD solid;">
								<a style="border: none; font: inherit;" href="<?php echo $socmed_item['account_url'] ?>">
									<span class="fa <?php echo $socmedias[$socmed_item['socmed_type']][1]; ?>"></span>
									<?php echo !empty($socmed_item['account_name']) ? $socmed_item['account_name'] : $_SESSION['MembershipAuth']['username'] ?>
								</a>
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
									<td>: <?php echo filter_var(trim($member['fullname']), FILTER_SANITIZE_STRING); ?></td>
								</tr>

								<tr>
									<td style="width:200px; font-weight: bold;">Gender</td>
									<td>: <?php echo ucfirst($member['gender']); ?></td>
								</tr>

								<tr>
									<td style="width:200px; font-weight: bold;">Daerah Kelahiran</td>
									<td>: <?php echo ucfirst($member['birth_place']); ?></td>
								</tr>

								<tr>
									<td style="width:200px; font-weight: bold;">Domisili</td>
									<td>: <?php echo $member['province'].', '.$member['city'].', '.filter_var(trim($member['area']), FILTER_SANITIZE_STRING); ?></td>
								</tr>

							</tbody>
						</table>

					</div>
				</div>
			</article>
		</div>
	</div>

	<div class="container">
		<h3>Portfolios</h3>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="font-weight: bold;">#</th>
                        <th style="font-weight: bold;">Nama Tempat Bekerja</th>
                        <th style="font-weight: bold;">Industri / Sektor</th>
                        <th style="font-weight: bold;">Periode Kerja</th>
                        <th style="font-weight: bold;">Posisi Pekerjaan (Job title)</th>
                        <th style="font-weight: bold;">Deskripsi Pekerjaan (Job desc)</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $num = 1;
                    foreach ($member_portfolios as $item_portfolio):
                    ?>

                    <tr>
                        <td>
                            <?php
                            echo $num;
                            ?>
                        </td>

                        <td>
                            <?php
                            echo filter_var(trim($item_portfolio['company_name']),FILTER_SANITIZE_STRING);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo filter_var(trim($item_portfolio['industry_name']), FILTER_SANITIZE_STRING);
                            ?>
                        </td>

                        <td>
                            <?php
                            $periode_str = '';

                            // Start
                            if ($item_portfolio['start_date_d'] != null) {
                                $periode_str .= $item_portfolio['start_date_d'].' ';
                            }

                            if ($item_portfolio['start_date_m'] != null) {
                                $periode_str .= $months[$item_portfolio['start_date_m']].' ';
                            }

                            if ($item_portfolio['start_date_y'] != null) {
                                $periode_str .= filter_var(trim($item_portfolio['start_date_y']), FILTER_SANITIZE_STRING);
                            }

                            if ($item_portfolio['work_status'] == 'R') {
                                $periode_str .= ' s/d ';
                                // End
                                if ($item_portfolio['end_date_d'] != null) {
                                    $periode_str .= $item_portfolio['end_date_d'].' ';
                                }

                                if ($item_portfolio['end_date_m'] != null) {
                                    $periode_str .= $months[$item_portfolio['end_date_m']].' ';
                                }

                                if ($item_portfolio['end_date_y'] != null) {
                                    $periode_str .= $item_portfolio['end_date_y'];
                                }

                            } else {
                                $periode_str .= ' s/d Sekarang';
                            }

                            echo filter_var(trim($periode_str), FILTER_SANITIZE_STRING);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo filter_var(trim($item_portfolio['job_title']), FILTER_SANITIZE_STRING);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo filter_var(trim($item_portfolio['job_desc']), FILTER_SANITIZE_STRING);
                            ?>
                        </td>
                    </tr>

                    <?php
                    $num++;
                    endforeach;
                    ?>
                </tbody>

            </table>
        </div>
	</div>

	<div class="dt-sc-margin50"></div>

	<div class="container">
		<p align="center"><a href="<?php echo $this->uri_path_for('membership-index'); ?>" class="button" style="color:#fff;">Back To Membership Page</a></p>
	</div>

	<div class="dt-sc-margin50"></div>
</div>

<div class="dt-sc-margin50"></div>