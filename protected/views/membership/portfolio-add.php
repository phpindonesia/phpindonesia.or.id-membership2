<?php $this->layout('layouts::layout-system'); ?>

<?php
$this->append_js(array(
    $this->uri_base_url().'/public/js/app/membership/portfolio-add.js'
));
?>

<section id="primary" class="content-full-width">

	<div class="full-width-section">

		<div class="container" style="margin-top: -70px;">

			<div class="dt-sc-hr-invisible-small"></div>

			<div class="woocommerce" style="padding:0px 30px;">

				<h3>Add new portfolio item</h3>

				<form action="<?php echo $this->uri_path_for('membership-portfolio-add'); ?>" method="post" class="checkout" novalidate>

					<?php
					echo $this->insert('sections::flash-message');
					?>

					<div class="form-row form-row-wide">
						<label for="company-name" style="font-weight: bold;">Nama Perusahaan *</label>
						<input type="text" id="company-name" name="company_name" value="<?php echo $this->fh_default_val('company_name'); ?>" />
						<?php echo $this->fh_show_errors('company_name', $_view_validation_errors_); ?>
					</div>

					<div class="form-row form-row-wide">
						<label for="industry-id" style="font-weight: bold;">Perusahaan bergerak di Industri *</label>
						<?php
                        echo $this->fh_input_select('industry_id', $industries, array(
                            'id' => 'industry-id'
                        ));
                        ?>

						<?php echo $this->fh_show_errors('industry_id', $_view_validation_errors_); ?>
					</div>

					<div class="form-row form-row-wide">
						<label style="font-weight: bold; display:block;">Mulai bekerja di perusahaan ini</label>

						<label style="display: inline;">Tahun</label>
                        <?php
                        echo $this->fh_input_select('start_date_y', $years_range, array(
                            'id' => 'start-date-y',
                            'style' => 'display: inline; width: 100px;'
                        ));
                        ?>
                        <?php echo $this->fh_show_errors('start_date_y', $_view_validation_errors_); ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <label style="display: inline;">Bulan (opsional)</label>
                        <?php
                        echo $this->fh_input_select('start_date_m', $months_range, array(
                            'id' => 'start-date-m',
                            'style' => 'display: inline; width: 250px;'
                        ));
                        ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <label style="display: inline;">Tanggal (opsional)</label>
                        <?php
                        echo $this->fh_input_select('start_date_d', $days_range, array(
                            'id' => 'start-date-d',
                            'style' => 'display: inline; width: 100px;'
                        ));
                        ?>

                        <br /><br />

                        <label style="display: inline;">Status bekerja</label>
                        <?php
                        echo $this->fh_input_select('work_status', array('A' => 'Saya masih bekerja di perusahaan ini hingga saat ini', 'R' => 'Saya sudah tidak bekerja lagi di perusahaan ini'), array(
                            'id' => 'work-status',
                            'style' => 'display: inline; width: 350px;'
                        ));
                        ?>
                        <?php echo $this->fh_show_errors('work_status', $_view_validation_errors_); ?>
					</div>

                    <div id="akhir-bekerja-block" style="display: none;" class="form-row form-row-wide">
                        <label style="font-weight: bold; display:block;">Akhir bekerja di perusahaan ini</label>

                        <label style="display: inline;">Tahun</label>
                        <?php
                        echo $this->fh_input_select('end_date_y', $years_range, array(
                            'id' => 'end-date-y',
                            'style' => 'display: inline; width: 100px;'
                        ));
                        ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <label style="display: inline;">Bulan (opsional)</label>
                        <?php
                        echo $this->fh_input_select('end_date_m', $months_range, array(
                            'id' => 'end-date-m',
                            'style' => 'display: inline; width: 250px;'
                        ));
                        ?>

                        &nbsp;&nbsp;&nbsp;&nbsp;

                        <label style="display: inline;">Tanggal (opsional)</label>
                        <?php
                        echo $this->fh_input_select('end_date_d', $days_range, array(
                            'id' => 'end-date-d',
                            'style' => 'display: inline; width: 100px;'
                        ));
                        ?>
                    </div>

                    <div class="form-row form-row-wide" style="margin-top:10px;">
                        <label for="job-title" style="font-weight: bold;">Posisi dalam pekerjaan (Job title) *</label>
                        <input type="text" id="job-title" name="job_title" value="<?php echo $this->fh_default_val('job_title'); ?>" />
                        <?php echo $this->fh_show_errors('job_title', $_view_validation_errors_); ?>
                    </div>

                    <div class="form-row form-row-wide">
                        <label for="job-desc" style="font-weight: bold;">Deskripsi pekerjaan (Job description) *</label>
                        <input type="text" id="job-desc" name="job_desc" value="<?php echo $this->fh_default_val('job_desc'); ?>" />
                        <?php echo $this->fh_show_errors('job_desc', $_view_validation_errors_); ?>
                    </div>

                    <div class="form-row form-row-wide">
                        <label for="career-level-id" style="font-weight: bold;">Level *</label>
                        <?php
                        echo $this->fh_input_select('career_level_id', $career_levels, array(
                            'id' => 'career-level-id'
                        ));
                        ?>

                        <?php echo $this->fh_show_errors('career_level_id', $_view_validation_errors_); ?>
                    </div>


					<div class="dt-sc-margin50"></div>

					<p style="float: left;">
						<button type="button" onclick="location.href='<?php echo $this->uri_path_for('membership-profile'); ?>';" class="button" style="color:#fff;">Cancel and Back</button>
						<input type="submit" class="button" value="Update Data" style="color:#fff; margin-right: 25px;" />
					</p>

					<div class="dt-sc-margin50"></div>

				</form>

			</div>

		</div>
		<div class="dt-sc-hr-invisible-small"></div>
	</div>
</section>
