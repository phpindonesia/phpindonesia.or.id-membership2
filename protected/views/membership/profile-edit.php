<?php $this->layout('layouts::layout-system');?>

<?php
$this->append_js(array(
      $this->uri_base_url() . '/public/js/jquery.inputmask.bundle.js',
      $this->uri_base_url() . '/public/js/app/membership/profile-edit.js'
));
?>

<section id="primary" class="content-full-width">

    <div class="full-width-section">

        <div class="container" style="margin-top: -70px;">

            <div class="dt-sc-hr-invisible-small"></div>

            <div class="woocommerce" style="padding:0px 30px;">

                <h3>Update My Basic Profile</h3>
                <form action="<?php echo $this->uri_path_for('membership-profile-edit');?>" method="post" enctype="multipart/form-data" class="checkout" novalidate>

                    <?php echo $this->insert('sections::flash-message');?>
                    <div class="col2-set" id="customer_details">

                        <div class="col-1">

                            <div class="form-row form-row-wide">
                                <label for="fullname" style="font-weight: bold;">Nama Lengkap *</label>
                                <input type="text" id="fullname" name="fullname" value="<?php
                                echo $this->fh_default_val('fullname', $member['fullname']);
                                ?>" />
                                       <?php
                                       echo $this->fh_show_errors('fullname', $_view_validation_errors_);
                                       ?>
                            </div>

                            <div class="form-row form-row-wide">
                                <label for="email" style="font-weight: bold;">Email *</label>
                                <input type="text" id="email" name="email" value="<?php
                                echo $this->fh_default_val('email', $_SESSION['MembershipAuth']['email']);
                                ?>" />
                                       <?php
                                       echo $this->fh_show_errors('email', $_view_validation_errors_);
                                       ?>
                            </div>

                            <div class="form-row form-row-wide">
                                <label for="contact_phone" style="font-weight: bold;">Telepon</label>
                                <input type="text" id="contact_phone" name="contact_phone" value="<?php
                                echo $this->fh_default_val('contact_phone', $member['contact_phone']);
                                ?>" />
                                       <?php
                                       echo $this->fh_show_errors('contact_phone', $_view_validation_errors_);
                                       ?>
                            </div>

                            <div class="form-row form-row-wide" style="margin-top:25px;">
                                <label for="province_id" style="font-weight: bold;">Provinsi *</label>
                                <div class="selection-box">
                                    <?php
                                    echo $this->fh_input_select('province_id', $provinces,
                                                                array(
                                          'default' => $member['province_id'],
                                          'id'      => 'provinces-dd'
                                    ));
                                    ?>
                                    <?php
                                    echo $this->fh_show_errors('province_id', $_view_validation_errors_);
                                    ?>
                                </div>
                            </div>

                            <div class="form-row form-row-wide" style="margin-top:25px;">
                                <label for="city_id" style="font-weight: bold;">Kabupaten / Kota Domisili *</label>
                                <div class="selection-box">
                                    <?php
                                    echo $this->fh_input_select('city_id', $cities,
                                                                array(
                                          'default' => $member['city_id'],
                                          'id'      => 'cities-dd'
                                    ));
                                    ?>
                                    <?php
                                    echo $this->fh_show_errors('city_id', $_view_validation_errors_);
                                    ?>
                                </div>
                            </div>

                            <div class="form-row form-row-wide" style="margin-top:25px;">
                                <label for="area" style="font-weight: bold;">Area *</label>
                                <input type="text" id="area" name="area" value="<?php
                                echo $this->fh_default_val('area', $member['area']);
                                ?>" />
                                       <?php
                                       echo $this->fh_show_errors('area', $_view_validation_errors_);
                                       ?>
                            </div>

                            <div class="form-row form-row-wide" style="margin-top:25px;">
                                <label for="job-id" style="font-weight: bold;">Pekerjaan *</label>
                                <div class="selection-box">
                                    <?php
                                    echo $this->fh_input_select('job_id', $jobs,
                                                                array(
                                          'default' => $member['job_id'],
                                          'id'      => 'job-id'
                                    ));
                                    ?>
                                    <?php
                                    echo $this->fh_show_errors('job_id', $_view_validation_errors_);
                                    ?>
                                </div>
                            </div>

                            <div class="form-row form-row-wide">
                                <label for="identity_type" style="font-weight: bold;">Jenis Identitas</label>
                                <div class="selection-box">
                                    <?php
                                    echo $this->fh_input_select('identity_type', $identity_types,
                                                                array(
                                          'default' => $member['identity_type'],
                                          'id'      => 'identity_type',
                                    ));
                                    ?>
                                </div>
                                <?php
                                echo $this->fh_show_errors('identity_type', $_view_validation_errors_);
                                ?>
                            </div>

                            <div class="form-row form-row-wide">
                                <label for="identity_number" style="font-weight: bold;">Nomer Identitas</label>
                                <input type="text" id="identity_number" name="identity_number" value="<?php
                                echo $this->fh_default_val('identity_number', $member['identity_number']);
                                ?>" />
                                       <?php
                                       echo $this->fh_show_errors('identity_number', $_view_validation_errors_);
                                       ?>
                            </div>

                            <div class="form-row form-row-wide">
                                <label for="birth_place" style="font-weight: bold;">Tempat Lahir</label>
                                <input type="text" id="birth_place" name="birth_place" value="<?php
                                echo $this->fh_default_val('birth_place', $member['birth_place']);
                                ?>" />
                                       <?php
                                       echo $this->fh_show_errors('birth_place', $_view_validation_errors_);
                                       ?>
                            </div>

                            <div class="form-row form-row-wide" style="margin-top:24px;">
                                <label for="birth-date" style="font-weight: bold;">Tanggal Lahir</label>
                                <input type="text" id="birth-date" name="birth_date" value="<?php echo $member['birth_date'];?>" />
                                <?php
                                echo $this->fh_show_errors('birth_date', $_view_validation_errors_);
                                ?>
                            </div>

                            <div class="form-row form-row-wide">
                                <label for="religion_id" style="font-weight: bold;">Religi</label>
                                <div class="selection-box">
                                    <?php
                                    echo $this->fh_input_select('religion_id', $religions,
                                                                array(
                                          'default' => $member['religion_id'],
                                          'id'      => 'religion-dd'
                                    ));
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="col-2">

                            <fieldset>
                                <legend>Photo Profile</legend>
                                <div class="dt-sc-team">
                                    <div class="image">
                                        <?php
                                        if ($member['photo'] == '' || $member['photo'] == null):
                                            ?>
                                            <img id="img-photo-profile" src="<?php echo $this->uri_base_url() . '/public/images/team.png';?>" alt="" style="width: 180px; height: 180px;" />
                                            <?php
                                        else:
                                            ?>
                                            <img id="img-photo-profile" src="<?php echo $this->uri_base_url() . '/public/files/photoprofile/' . $member['photo'];?>" alt="" style="width: 180px; height: 180px;" />
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                    <div style="clear: both;">
                                        <p>Update Photo Profile</p>
                                        <input type="file" name="photo" id="photo-profile" />
                                    </div>
                                </div>
                            </fieldset>
                            <?php
                            echo $this->fh_show_errors('photo', $_view_validation_errors_);
                            ?>

                            <fieldset>
                                <legend>Social Medias</legend>
                                <div class="form-row form-row-wide">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Media Name</th>
                                                <th>Account Name</th>
                                                <th>Account Url</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>

                                        <tbody id="socmed-rows">
                                            <?php
                                            if ($members_socmeds):
                                                foreach ($members_socmeds as $ii => $socmed):
                                                    if ($socmed['deleted'] != 'Y'):
                                                        ?>
                                                        <tr id="socmed-item<?php echo $ii;?>">
                                                            <td style="padding-top: 35px;">
                                                                <?php echo $socmedias[$socmed['socmed_type']];?>
                                                                <input class="db-row-id" type="hidden" name="socmeds[<?php echo $ii;?>][member_socmed_id]" value="<?php echo $socmed['member_socmed_id'];?>" />
                                                                <input class="socmed-type" type="hidden" name="socmeds[<?php echo $ii;?>][socmed_type]" value="<?php echo $socmed['socmed_type'];?>" />
                                                            </td>

                                                            <td>
                                                                <input type="text" name="socmeds[<?php echo $ii;?>][account_name]" value="<?php echo $socmed['account_name'];?>" placeholder="BUKAN FULLNAME. Contoh: @phpindonesia - for twitter, princessyahrini for instagram" />
                                                            </td>

                                                            <td>
                                                                <input type="text" name="socmeds[<?php echo $ii;?>][account_url]" value="<?php echo $socmed['account_url'];?>" placeholder="Contoh: https://www.facebook.com/profile.php?id=12345678 - Jika sosmed tidak memiliki fitur nickname seperti twitter." />
                                                            </td>

                                                            <td style="padding-top: 25px; font-size: 1.5em">
                                                                <a href="javascript:delete_socmed('socmed-item<?php echo $ii;?>')" title="Delete this socmed item">x</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    endif;
                                                endforeach;
                                            else:
                                                ?>
                                                <tr class="empty-row">
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                </tr>
                                            <?php
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                                if (isset($_POST['socmeds']) && !empty($_POST['socmeds'])):
                                    foreach ($_POST['socmeds'] as $i => $item):
                                        echo $this->fh_show_errors("socmeds.{$i}.socmed_type",
                                                                   $_view_validation_errors_);
                                        echo $this->fh_show_errors("socmeds.{$i}.account_name",
                                                                   $_view_validation_errors_);
                                        echo $this->fh_show_errors("socmeds.{$i}.account_url",
                                                                   $_view_validation_errors_);
                                    endforeach;
                                endif;
                                ?>

                                <fieldset>
                                    <legend>Tambah Informasi Social Media</legend>
                                    <div class="form-row form-row-wide">
                                        <label for="meds-dd" style="font-weight: bold;">Jenis Social Media</label>
                                        <div class="selection-box">
                                            <?php
                                            echo $this->fh_input_select('socmed_type', $socmedias,
                                                                        array('id' => 'meds-dd',));
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-row form-row-wide" style="margin-top:24px;">
                                        <label for="socmed-account-name" style="font-weight: bold;">Account Name</label>
                                        <input type="text" id="socmed-account-name" />
                                        <p style="color: #EA7120; font-size: 0.8em;">BUKAN FULLNAME. Contoh: <span style="text-decoration: underline; font-weight: bold;">@phpindonesia</span> - for twitter, <span style="text-decoration: underline; font-weight: bold;">princessyahrini</span> for instagram. Isikan account name (nickname) Jika sosmed memiliki fitur account name (nickname) dan isian account URL boleh dikosongan.</p>
                                    </div>

                                    <div class="form-row form-row-wide" style="margin-top:24px;">
                                        <label for="socmed-account-url" style="font-weight: bold;">Account Url</label>
                                        <input type="text" id="socmed-account-url" />
                                        <p style="color: #EA7120; font-size: 0.8em;">Contoh: <span style="text-decoration: underline; font-weight: bold;">https://www.facebook.com/profile.php?id=12345678</span> - Jika sosmed tidak memiliki fitur nickname seperti twitter atau instagram. Isikan account URL jika sosmed tidak punya fitur account name (nickname) dan isian account name (nickname) boleh dikosongkan.</p>
                                    </div>

                                    <div id="delete-collections"></div>

                                    <div class="form-row form-row-wide" style="margin-top:24px;">
                                        <button id="add-socmed" type="button" class="button">Add new</button>
                                    </div>
                                </fieldset>

                            </fieldset>

                        </div>

                    </div>

                    <div class="dt-sc-margin50"></div>
                    <p style="float: left;">
                        <button type="button" onclick="location.href = '<?php echo $this->uri_path_for('membership-profile');?>';" class="button" style="color:#fff;">Cancel and Back</button>
                        <input type="submit" class="button" value="Update Data" style="color:#fff; margin-right: 25px;" />
                    </p>
                    <div class="dt-sc-margin50"></div>

                </form>

            </div>

        </div>
        <div class="dt-sc-hr-invisible-small"></div>
    </div>
</section>