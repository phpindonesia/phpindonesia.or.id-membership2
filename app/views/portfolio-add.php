<?php
$this->layout('layouts::system');

$this->appendJs([
    $this->asset('/js/portfolio-add.js')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <h3 style="border-bottom: 1px #000000 solid;">Add new portfolio item</h3>

        <?php echo $this->insert('sections::alert') ?>

        <form action="<?php echo $this->pathFor('membership-portfolio-add'); ?>" method="post" class="checkout" novalidate>

            <table class="form-oprek">
                <tbody>
                    <tr>
                        <th>
                            <label for="company-name" style="font-weight: bold;">Nama Perusahaan *</label>
                        </th>
                        <td>
                            <input type="text" id="company-name" class="input_full" name="company_name" value="<?php echo $this->requestParam('company_name'); ?>" />
                            <?php echo $this->formShowErrors('company_name', $validation_errors); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="industry-id" style="font-weight: bold;">Perusahaan bergerak di Industri *</label>
                        </th>
                        <td>
                            <?php echo $this->formInputSelect('industry_id', $industries, [
                                'id' => 'industry-id',
                                'class' => 'input_full'
                            ]) ?>

                            <?php echo $this->formShowErrors('industry_id', $validation_errors); ?>
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
                                    <?php echo $this->formInputSelect('start_date_y', $years_range, ['id' => 'start-date-y']) ?>
                                    <?php echo $this->formShowErrors('start_date_y', $validation_errors); ?>
                                </li>

                                <li>
                                    <label style="display: block;">Bulan (opsional)</label>
                                    <?php echo $this->formInputSelect('start_date_m', $months_range, ['id' => 'start-date-m']) ?>
                                </li>

                                <li>
                                    <label style="display: block;">Tanggal (opsional)</label>
                                    <?php echo $this->formInputSelect('start_date_d', $days_range, ['id' => 'start-date-d']);
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
                            <?php echo $this->formInputSelect(
                                'work_status',
                                ['A' => 'Saya masih bekerja di perusahaan ini hingga saat ini', 'R' => 'Saya sudah tidak bekerja lagi di perusahaan ini'],
                                ['id' => 'work-status']
                            ) ?>

                            <?php echo $this->formShowErrors('work_status', $validation_errors); ?>
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
                                    <?php echo $this->formInputSelect('end_date_y', $years_range, ['id' => 'end-date-y']); ?>
                                </li>

                                <li>
                                    <label style="display: block;">Bulan (opsional)</label>
                                    <?php echo $this->formInputSelect('end_date_m', $months_range, ['id' => 'end-date-m']); ?>
                                </li>

                                <li>
                                    <label style="display: block;">Tanggal (opsional)</label>
                                    <?php echo $this->formInputSelect('end_date_d', $days_range, ['id' => 'end-date-d']); ?>
                                </li>
                            </ul>

                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="job-title" style="font-weight: bold;">Posisi dalam pekerjaan (Job title) *</label>
                        </th>
                        <td>
                            <input type="text" id="job-title" class="input_full" name="job_title" value="<?php echo $this->requestParam('job_title'); ?>" />
                            <?php echo $this->formShowErrors('job_title', $validation_errors); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="job-desc" style="font-weight: bold;">Deskripsi pekerjaan (Job description) *</label>
                        </th>
                        <td>
                            <textarea id="job-desc" class="input_full" name="job_desc"></textarea>
                            <?php echo $this->formShowErrors('job_desc', $validation_errors); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <label for="career-level-id" style="font-weight: bold;">Level *</label>
                        </th>
                        <td>
                            <?php echo $this->formInputSelect('career_level_id', $career_levels, ['id' => 'career-level-id']) ?>
                            <?php echo $this->formShowErrors('career_level_id', $validation_errors); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            &nbsp;
                        </th>
                        <td>
                            <input type="submit" class="button" value="Update Data" />
                            <button type="button" onclick="location.href='<?php echo $this->pathFor('membership-account'); ?>';">Cancel and Back</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>

</div>
