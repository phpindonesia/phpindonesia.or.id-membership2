<?php $this->layout('layouts::layout-system'); ?>

<?php
$this->append_js(array(
    $this->uri_base_url().'/public/js/app/membership/portfolio-add.js'
));
?>

<section id="primary" class="content-full-width">

	<div class="full-width-section">

		<div class="container" style="margin-top: -70px;">

            <h3 style="border-bottom: 1px #000000 solid;">Add new portfolio item</h3>

            <?php
            echo $this->insert('sections::flash-message');
            ?>

            <form action="<?php echo $this->uri_path_for('membership-portfolio-add'); ?>" method="post" class="checkout" novalidate>

                <table class="form-oprek">
                    <tbody>
                        <tr>
                            <th>
                                <label for="company-name" style="font-weight: bold;">Nama Perusahaan *</label>
                            </th>
                            <td>
                                <input type="text" id="company-name" class="input_full" name="company_name" value="<?php echo $this->fh_default_val('company_name'); ?>" />
                                <?php
                                echo $this->fh_show_errors('company_name', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="industry-id" style="font-weight: bold;">Perusahaan bergerak di Industri *</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('industry_id', $industries, array(
                                    'id' => 'industry-id',
                                    'class' => 'input_full'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('industry_id', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label style="font-weight: bold; display:block;">Mulai bekerja di perusahaan ini</label>
                            </th>
                            <td>
                                <ul class="date-parts">
                                    <li>
                                        <label style="display: block;">Tahun</label>
                                        <?php
                                        echo $this->fh_input_select('start_date_y', $years_range, array(
                                            'id' => 'start-date-y'
                                        ));
                                        ?>

                                        <?php
                                        echo $this->fh_show_errors('start_date_y', $_view_validation_errors_);
                                        ?>
                                    </li>

                                    <li>
                                        <label style="display: block;">Bulan (opsional)</label>
                                        <?php
                                        echo $this->fh_input_select('start_date_m', $months_range, array(
                                            'id' => 'start-date-m'
                                        ));
                                        ?>
                                    </li>

                                    <li>
                                        <label style="display: block;">Tanggal (opsional)</label>
                                        <?php
                                        echo $this->fh_input_select('start_date_d', $days_range, array(
                                            'id' => 'start-date-d'
                                        ));
                                        ?>
                                    </li>

                                </ul>
                                
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label style="font-weight: bold; display:block;">Status bekerja</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('work_status', array('A' => 'Saya masih bekerja di perusahaan ini hingga saat ini', 'R' => 'Saya sudah tidak bekerja lagi di perusahaan ini'), array(
                                    'id' => 'work-status'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('work_status', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr id="akhir-bekerja-block" style="display: none;">
                            <th>
                                <label style="font-weight: bold; display:block;">Akhir bekerja di perusahaan ini</label>
                            </th>

                            <td>
                                
                                <ul class="date-parts">
                                    <li>
                                        <label style="display: block;">Tahun</label>
                                        <?php
                                        echo $this->fh_input_select('end_date_y', $years_range, array(
                                            'id' => 'end-date-y'
                                        ));
                                        ?>
                                    </li>

                                    <li>
                                        <label style="display: block;">Bulan (opsional)</label>
                                        <?php
                                        echo $this->fh_input_select('end_date_m', $months_range, array(
                                            'id' => 'end-date-m'
                                        ));
                                        ?>
                                    </li>

                                    <li>
                                        <label style="display: block;">Tanggal (opsional)</label>
                                        <?php
                                        echo $this->fh_input_select('end_date_d', $days_range, array(
                                            'id' => 'end-date-d'
                                        ));
                                        ?>
                                    </li>
                                </ul>

                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="job-title" style="font-weight: bold;">Posisi dalam pekerjaan (Job title) *</label>
                            </th>
                            <td>
                                <input type="text" id="job-title" class="input_full" name="job_title" value="<?php echo $this->fh_default_val('job_title'); ?>" />
                                <?php
                                echo $this->fh_show_errors('job_title', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="job-desc" style="font-weight: bold;">Deskripsi pekerjaan (Job description) *</label>
                            </th>
                            <td>
                                <textarea id="job-desc" class="input_full" name="job_desc"></textarea>
                                <?php
                                echo $this->fh_show_errors('job_desc', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="career-level-id" style="font-weight: bold;">Level *</label>
                            </th>
                            <td>
                                <?php
                                echo $this->fh_input_select('career_level_id', $career_levels, array(
                                    'id' => 'career-level-id'
                                ));
                                ?>

                                <?php
                                echo $this->fh_show_errors('career_level_id', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <td>
                                <input type="submit" class="button" value="Update Data" />
                                <button type="button" onclick="location.href='<?php echo $this->uri_path_for('membership-profile'); ?>';">Cancel and Back</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>
        </div>

	</div>
</section>
