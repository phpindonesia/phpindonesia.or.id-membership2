<?php 
$this->layout('layouts::system'); 

$this->appendCss([
    $this->asset('/css/profile.css')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <div class="dt-sc-clear"></div>

        <div class="column dt-sc-two-fifth first">

            <div class="dt-sc-team">

                <div class="image">
                    <img src="<?php echo $this->userPhoto($member['photo'], ['width' => '180', 'height' => '180']) ?>" alt="" />
                </div>

                <div class="team-details">
                    <h6><?php echo $this->e($member['fullname']) ?></h6>

                    <br />

                    <ul class="dt-sc-social-icons">
                        <?php foreach ($member_socmeds as $socmed_item): ?>

                            <li style="margin-right: 5px; padding: 3px; border: 1px #DDDDDD solid;">
                                <a style="border: none; font: inherit;" href="<?php echo $socmed_item['account_url'] ?>">
                                    <span class="fa <?php echo $socmedias[$socmed_item['socmed_type']][1]; ?>"></span>
                                    <?php echo !empty($socmed_item['account_name']) ? $socmed_item['account_name'] : strtolower($member['fullname']) ?>
                                </a>
                            </li>

                        <?php endforeach; ?>
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
                                    <td>: <?php echo $this->e($member['fullname']) ?></td>
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
                                    <td>: <?php echo $member['province'].', '.$member['city'].', '.$this->e($member['area']); ?></td>
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
                    <?php $num = 1; foreach ($member_portfolios as $item_portfolio): ?>

                    <tr>
                        <td>
                            <?php echo $num; ?>
                        </td>

                        <td>
                            <?php echo $this->e($item_portfolio['company_name']) ?>
                        </td>

                        <td>
                            <?php echo $this->e($item_portfolio['industry_name']); ?>
                        </td>

                        <td>
                            <?php
                            $periode_str = '';
                            $months = months();

                            // Start
                            if ($item_portfolio['start_date_d'] != null) {
                                $periode_str .= $item_portfolio['start_date_d'].' ';
                            }

                            if ($item_portfolio['start_date_m'] != null) {
                                $periode_str .= $months[$item_portfolio['start_date_m']].' ';
                            }

                            if ($item_portfolio['start_date_y'] != null) {
                                $periode_str .= $this->e($item_portfolio['start_date_y']);
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

                            echo $this->e($periode_str);
                            ?>
                        </td>

                        <td>
                            <?php echo $this->e($item_portfolio['job_title']) ?>
                        </td>

                        <td>
                            <?php echo $this->e($item_portfolio['job_desc']) ?>
                        </td>
                    </tr>

                    <?php $num++; endforeach; ?>
                </tbody>

            </table>
        </div>

        <!-- SKILL BLOCK START -->
        <h3>Skills</h3>
        <div class="row box-list width-85">
            <ul>
                <?php $num_skill = 1; foreach ($member_skills as $item_skill): ?>
                <li class="">
                    <div class="skill-name">
                        <?php echo $item_skill['skill_name']; ?>
                    </div>
                     <div class="block va-middle">
                        <span class="block font-11 text-grey">Skill Level</span>
                        <span class="block skill-level center">
                            <?php echo $item_skill['skill_self_assesment']; ?>
                        </span>
                    </div>
                </li>
                <?php $num_skill++; endforeach; ?>
            </ul>
        </div>
        <!-- SKILL BLOCK END -->

    </div>

    <div class="dt-sc-margin50"></div>

    <div class="container">
        <p align="center">
            <a href="<?php echo $this->pathFor('membership-index'); ?>" class="button" style="color:#fff;">Back To Membership Page</a>
        </p>
    </div>

    <div class="dt-sc-margin50"></div>
</div>
