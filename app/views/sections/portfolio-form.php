<table class="form-oprek">
    <tbody>
        <tr>
            <th>
                <label for="company-name" style="font-weight: bold;">Nama Perusahaan *</label>
            </th>
            <td>
                <input type="text" id="company-name" class="input_full" name="company_name" value="<?php echo $this->requestBody('company_name', $portfolio ? $portfolio['company_name'] : null) ?>" />
                <?php echo $this->formFieldError('company_name') ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="industry-id" style="font-weight: bold;">Perusahaan bergerak di Industri *</label>
            </th>
            <td>
                <?php echo $this->formInputSelect('industry_id', $industries, [
                    'id' => 'industry-id',
                    'class' => 'input_full',
                    'default' => $portfolio ? $portfolio['industry_id'] : null
                ]) ?>

                <?php echo $this->formFieldError('industry_id') ?>
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
                        <?php echo $this->formInputSelect('start_date_y', years_range(), [
                            'id' => 'start-date-y',
                            'default' => $portfolio ? $portfolio['start_date_y'] : null
                        ]) ?>
                        <?php echo $this->formFieldError('start_date_y') ?>
                    </li>

                    <li>
                        <label style="display: block;">Bulan (opsional)</label>
                        <?php echo $this->formInputSelect('start_date_m', months_range(), [
                            'id' => 'start-date-m',
                            'default' => $portfolio ? $portfolio['start_date_m'] : null
                        ]) ?>
                    </li>

                    <li>
                        <label style="display: block;">Tanggal (opsional)</label>
                        <?php echo $this->formInputSelect('start_date_d', days_range(), [
                            'id' => 'start-date-d',
                            'default' => $portfolio ? $portfolio['start_date_d'] : null
                        ]) ?>
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
                    ['id' => 'work-status', 'default' => $portfolio ? $portfolio['work_status'] : null]
                ) ?>

                <?php echo $this->formFieldError('work_status') ?>
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
                        <?php echo $this->formInputSelect('end_date_y', years_range(), [
                            'id' => 'end-date-y',
                            'default' => $portfolio ? $portfolio['end_date_y'] : null
                        ]) ?>
                    </li>

                    <li>
                        <label style="display: block;">Bulan (opsional)</label>
                        <?php echo $this->formInputSelect('end_date_m', months_range(), [
                            'id' => 'end-date-m',
                            'default' => $portfolio ? $portfolio['end_date_m'] : null
                        ]) ?>
                    </li>

                    <li>
                        <label style="display: block;">Tanggal (opsional)</label>
                        <?php echo $this->formInputSelect('end_date_d', days_range(), [
                            'id' => 'end-date-d',
                            'default' => $portfolio ? $portfolio['end_date_d'] : null
                        ]) ?>
                    </li>
                </ul>

            </td>
        </tr>

        <tr>
            <th>
                <label for="job-title" style="font-weight: bold;">Posisi dalam pekerjaan (Job title) *</label>
            </th>
            <td>
                <input type="text" id="job-title" class="input_full" name="job_title" value="<?php echo $this->requestBody('job_title', $portfolio ? $portfolio['job_title'] : null) ?>" />
                <?php echo $this->formFieldError('job_title') ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="job-desc" style="font-weight: bold;">Deskripsi pekerjaan (Job description) *</label>
            </th>
            <td>
                <textarea id="job-desc" class="input_full" name="job_desc"><?php echo $this->requestBody('job_desc', $portfolio ? $portfolio['job_desc'] : null) ?></textarea>
                <?php echo $this->formFieldError('job_desc') ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="career-level-id" style="font-weight: bold;">Level *</label>
            </th>
            <td>
                <?php echo $this->formInputSelect('career_level_id', $career_levels, [
                    'default' => $portfolio ? $portfolio['career_level_id'] : null,
                    'id' => 'career-level-id',
                ]) ?>
                <?php echo $this->formFieldError('career_level_id') ?>
            </td>
        </tr>

        <tr>
            <th>
                &nbsp;
            </th>
            <td>
            <?php if ($portfolio): ?>
                <input type="submit" class="button" value="Update Data" />
                <button type="button" onclick="location.href='<?php echo $this->pathFor('membership-account'); ?>';">Cancel and Back</button>
            <?php else: ?>
                <input type="submit" class="button" value="Add Portfolio" />
            <?php endif ?>
            </td>
        </tr>
    </tbody>
</table>
