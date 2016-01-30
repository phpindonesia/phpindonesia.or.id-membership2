<?php
$this->layout('layouts::system');

$this->appendJs([
    $this->asset('/js/jquery.popupoverlay.js'),
    $this->pathFor('membership-account-javascript'),
    $this->asset('/js/portfolio-add.js'),
    $this->asset('/js/skill-add.js')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <div style="margin-bottom: 70px; padding: 0; margin-top: -60px;">
            <?php echo $this->insert('sections::alert') ?>
        </div>

        <div class="column dt-sc-two-fifth first">

            <div class="dt-sc-team">

                <div class="image">
                    <img src="<?php echo $this->userPhoto($member['photo'], ['width' => '180', 'height' => '180']) ?>" alt="user avatar" style="width: 180px; height: 180px;" />
                </div>

                <div class="team-details">
                    <h6><?php echo filter_var(trim($member['fullname']), FILTER_SANITIZE_STRING); ?></h6>
                    <br />

                    <ul class="dt-sc-social-icons">
                        <?php foreach ($member_socmeds as $socmed_item): ?>

                            <li style="margin-right: 5px; padding: 3px; border: 1px #DDDDDD solid;">
                                <a style="border: none; font: inherit;" href="<?php echo $socmed_item['account_url'] ?>">
                                    <span class="fa <?php echo $socmedias[$socmed_item['socmed_type']][1]; ?>"></span>
                                    <?php echo !empty($socmed_item['account_name']) ? $socmed_item['account_name'] : $_SESSION['MembershipAuth']['username'] ?>
                                </a>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

        </div>

        <div class="column dt-sc-three-fifth">

            <div class="entry-body" style="margin-top: -25px; margin-bottom: 25px;">
                <a href="<?php echo $this->pathFor('membership-account-edit'); ?>" class="button" style="color: blue;">Update Basic Profile</a>
                <a href="<?php echo $this->pathFor('membership-portfolio-add'); ?>" class="button" style="color: blue;">Add Portfolios</a>
                <a href="<?php echo $this->pathFor('membership-skills-add'); ?>" class="button" style="color: blue;">Add Skills</a>
            </div>

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
                                    <td>: <?php echo filter_var(trim(ucfirst($member['gender'])), FILTER_SANITIZE_STRING); ?></td>
                                </tr>

                                <tr>
                                    <td style="width:200px; font-weight: bold;">Email</td>
                                    <td>: <?php echo $_SESSION['MembershipAuth']['email']; ?></td>
                                </tr>

                                <tr>
                                    <td style="width:200px; font-weight: bold;">Phone</td>
                                    <td>: <?php echo filter_var(trim($member['contact_phone']), FILTER_SANITIZE_STRING); ?></td>
                                </tr>

                                <tr>
                                    <td style="width:200px; font-weight: bold;">Tempat, Tanggal Lahir</td>
                                    <td>
                                        :
                                        <?php
                                        echo $member['birth_place'] == null ? '-' : filter_var(trim(ucfirst($member['birth_place'])), FILTER_SANITIZE_STRING);
                                        echo ' , ';
                                        echo $member['birth_date'] == null ? '-' : filter_var(trim($member['birth_date']), FILTER_SANITIZE_STRING);
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:200px; font-weight: bold;">Identitas</td>
                                    <td>
                                        :
                                        <?php
                                        echo $member['identity_type'] == null ? '-' : filter_var(trim($member['identity_type']), FILTER_SANITIZE_STRING);
                                        echo ' : ';
                                        echo $member['identity_number'] == null ? '-' : filter_var(trim($member['identity_number']), FILTER_SANITIZE_STRING);
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:200px; font-weight: bold;">Domisili</td>
                                    <td>
                                        :
                                        <?php
                                        echo $member['area'] == '' ? '-' : filter_var(trim(ucwords($member['area'])), FILTER_SANITIZE_STRING);
                                        echo ' , ';
                                        echo filter_var(trim($member['city']), FILTER_SANITIZE_STRING);
                                        echo ' , ';
                                        echo filter_var(trim($member['province']), FILTER_SANITIZE_STRING)
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:200px; font-weight: bold;">Pekerjaan</td>
                                    <td>
                                        :
                                        <?php echo ucfirst($member['job_id']); ?>
                                    </td>
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

        <div class="table-responsive" style="margin-bottom: 25px;">
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

                        <td><a href="<?php echo $this->pathFor('membership-portfolio-edit', array('id' => $item_portfolio['member_portfolio_id'])); ?>" title="Edit item portfolio ini"><i class="fa fa-edit"></i> Edit</a></td>
                    </tr>

                    <?php
                    $num++;
                    endforeach;
                    ?>
                </tbody>

            </table>
        </div>

        <h3>Skills</h3>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="font-weight: bold;">#</th>
                        <th style="font-weight: bold;">Skill Global</th>
                        <th style="font-weight: bold;">Skill Spesific</th>
                        <th style="font-weight: bold; text-align: center;">Self Assesment</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $num_skill = 1;
                    foreach ($member_skills as $item_skill):
                    ?>
                    <tr>
                        <td>
                            <?php echo $num_skill; ?>
                        </td>

                        <td>
                            <?php echo $item_skill['skill_parent_name']; ?>
                        </td>

                        <td>
                            <?php echo $item_skill['skill_name']; ?>
                        </td>

                        <td style="text-align: center;">
                            <?php echo $item_skill['skill_self_assesment']; ?>
                        </td>

                        <td>
                            <?php
                            $unique = md5($num_skill.$item_skill['member_skill_id']);
                            ?>
                            <form action="<?php echo $this->pathFor('membership-skills-delete', array('id' => $item_skill['member_skill_id'])); ?>" name="post_<?php echo $unique; ?>" id="post_<?php echo $unique; ?>" style="display:none;" method="post"><input autocomplete="off" name="_method" value="POST" type="hidden"></form>
                            <a href="#" onclick="if (confirm('Delete this skill item?')) { document.post_<?php echo $unique; ?>.submit(); } event.returnValue = false; return false;"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php
                    $num_skill++;
                    endforeach;
                    ?>

                </tbody>
            </table>

    </div>

</div>

<div class="dt-sc-margin50"></div>

<!-- PORTFOLIO & SKILL ADD SECTION -->
<div id="portfolio-popup" class="well" style="background-color: #FFFFFF;">

    <?php echo $this->insert('sections::portfolio-add') ?>

    <div style="position: absolute; top: 5px; right: 5px;">
        <button class="portfolio-popup-close">Close [X]</button>
    </div>
</div>

<div id="skill-popup" class="well" style="background-color: #FFFFFF;">

    <?php echo $this->insert('sections::skill-add') ?>

    <div style="position: absolute; top: 5px; right: 5px;">
        <button class="skill-popup-close">Close [X]</button>
    </div>
</div>
