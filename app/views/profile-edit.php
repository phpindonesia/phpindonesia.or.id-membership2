<?php $this->layout('layouts::system') ?>

<?php
$this->appendJs(array(
    $this->baseUrl().'/asset/js/jquery.inputmask.bundle.js',
    $this->baseUrl().'/asset/js/app/membership/profile-edit.js'
));
?>

<section id="primary" class="content-full-width">

    <div class="full-width-section">

        <div class="container" style="margin-top: -70px;">

            <h3 style="border-bottom: 1px #000000 solid;">Update My Basic Profile</h3>

            <?php echo $this->insert('sections::flash-message'); ?>

            <form action="<?php echo $this->pathFor('membership-profile-edit'); ?>" method="post" enctype="multipart/form-data" class="checkout" novalidate>

                <div class="left-col-oprek">

                    <table>
                        <tbody>
                            <tr>
                                <th>
                                    <label for="fullname" style="font-weight: bold;">Nama Lengkap *</label>
                                </th>
                                <td>
                                    <input type="text" class="input_full" id="fullname" name="fullname" value="<?php echo $this->requestParam('fullname', $member['fullname']); ?>" />
                                    <?php echo $this->formShowErrors('fullname', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="email" style="font-weight: bold;">Email *</label>
                                </th>
                                <td>
                                    <input type="text" class="input_full" id="email" name="email" value="<?php echo $this->requestParam('email', $_SESSION['MembershipAuth']['email']); ?>" />
                                    <?php echo $this->formShowErrors('email', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="contact_phone" style="font-weight: bold;">Telepon</label>
                                </th>
                                <td>
                                    <input type="text" class="input_full" id="contact_phone" name="contact_phone" value="<?php echo $this->requestParam('contact_phone', $member['contact_phone']); ?>" />
                                    <?php echo $this->formShowErrors('contact_phone', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="province_id" style="font-weight: bold;">Provinsi *</label>
                                </th>
                                <td>
                                    <?php
                                    echo $this->formInputSelect('province_id', $provinces, array(
                                        'default'    => $member['province_id'],
                                        'id'         => 'provinces-dd',
                                        'class'      => 'input_full'
                                    ));
                                    ?>

                                    <?php echo $this->formShowErrors('province_id', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="city_id" style="font-weight: bold;">Kabupaten / Kota Domisili *</label>
                                </th>
                                <td>
                                    <?php
                                    echo $this->formInputSelect('city_id', $cities, array(
                                        'default'    => $member['city_id'],
                                        'id'         => 'cities-dd',
                                        'class'      => 'input_full'
                                    ));
                                    ?>

                                    <?php echo $this->formShowErrors('city_id', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="area" style="font-weight: bold;">Area *</label>
                                </th>
                                <td>
                                    <input type="text" class="input_full" id="area" name="area" value="<?php echo $this->requestParam('area', $member['area']); ?>" />
                                    <?php echo $this->formShowErrors('area', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="job-id" style="font-weight: bold;">Pekerjaan *</label>
                                </th>
                                <td>
                                    <?php
                                    echo $this->formInputSelect('job_id', $jobs, array(
                                        'default'    => $member['job_id'],
                                        'id'         => 'job-id',
                                        'class'      => 'input_full'
                                    ));
                                    ?>

                                    <?php echo $this->formShowErrors('job_id', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="identity_type" style="font-weight: bold;">Jenis Identitas</label>
                                </th>

                                <td>
                                <?php
                                echo $this->formInputSelect('identity_type', $identity_types, array(
                                    'default'    => $member['identity_type'],
                                    'id'         => 'identity_type',
                                    'class'      => 'input_full'
                                ));
                                ?>
                                <?php echo $this->formShowErrors('identity_type', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="identity_number" style="font-weight: bold;">Nomer Identitas</label>
                                </th>

                                <td>
                                    <input type="text" class="input_full" id="identity_number" name="identity_number" value="<?php echo $this->requestParam('identity_number', $member['identity_number']); ?>" />
                                    <?php echo $this->formShowErrors('identity_number', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="birth_place" style="font-weight: bold;">Tempat Lahir</label>
                                </th>

                                <td>
                                    <input type="text" class="input_full" id="birth_place" name="birth_place" value="<?php echo $this->requestParam('birth_place', $member['birth_place']); ?>" />
                                    <?php echo $this->formShowErrors('birth_place', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="birth-date" style="font-weight: bold;">Tanggal Lahir</label>
                                </th>

                                <td>
                                    <input type="text" class="input_full" id="birth-date" name="birth_date" value="<?php echo $member['birth_date']; ?>" />
                                    <?php echo $this->formShowErrors('birth_date', $validation_errors); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <label for="religion_id" style="font-weight: bold;">Religi</label>
                                </th>

                                <td>
                                <?php
                                echo $this->formInputSelect('religion_id', $religions, array(
                                    'default'    => $member['religion_id'],
                                    'id'         => 'religion-dd',
                                    'class'      => 'input_full'
                                ));
                                ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>

                <div class="right-col-oprek">
                    <fieldset>
                        <legend>Photo Profile</legend>
                        <div class="dt-sc-team">
                            <div class="image">
                                <img id="img-photo-profile" src="<?php echo $this->userPhoto($member['photo'], ['width' => '180', 'height' => '180']) ?>" alt="user avatar" style="width: 180px; height: 180px;" />
                            </div>

                            <div style="clear: both;">
                                <p>Update Photo Profile</p>
                                <input type="file" name="photo" id="photo-profile" />
                            </div>

                        </div>
                    </fieldset>
                    <?php echo $this->formShowErrors('photo', $validation_errors); ?>

                    <fieldset>
                        <legend>Social Medias</legend>

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
                                    $ii = 0;
                                    foreach ($members_socmeds as $socmed):
                                    ?>

                                    <tr id="socmed-item<?php echo $ii; ?>">
                                        <td>
                                            <?php echo $socmedias[$socmed['socmed_type']][0] ?>
                                            <input class="socmed-type" type="hidden" name="socmeds[<?php echo $ii; ?>][socmed_type]" value="<?php echo $socmed['socmed_type']; ?>" />
                                        </td>

                                        <td>
                                            <input type="text" name="socmeds[<?php echo $ii; ?>][account_name]" value="<?php echo $socmed['account_name']; ?>" placeholder="BUKAN FULLNAME. Contoh: @phpindonesia - for twitter, princessyahrini for instagram" />
                                        </td>

                                        <td>
                                            <input type="text" name="socmeds[<?php echo $ii; ?>][account_url]" value="<?php echo $socmed['account_url']; ?>" placeholder="Contoh: https://www.facebook.com/profile.php?id=12345678 - Jika sosmed tidak memiliki fitur nickname seperti twitter." />
                                        </td>

                                        <td style="font-size: 1.5em">
                                            <a href="javascript:delete_socmed('socmed-item<?php echo $ii; ?>')" title="Delete this socmed item">x</a>
                                        </td>

                                    </tr>

                                    <?php
                                    $ii++;
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

                        <?php
                        if (isset($_POST['socmeds'])):
                            foreach ((array) $_POST['socmeds'] as $i => $item):
                                echo $this->formShowErrors("socmeds.{$i}.socmed_type", $validation_errors);
                                echo $this->formShowErrors("socmeds.{$i}.account_name", $validation_errors);
                                echo $this->formShowErrors("socmeds.{$i}.account_url", $validation_errors);
                            endforeach;
                        endif;
                        ?>

                        <fieldset>
                            <legend>Tambah Informasi Social Media</legend>

                            <table>
                                <tbody>
                                    <tr>
                                        <th>
                                            <label for="identity_type" style="font-weight: bold;">Jenis Social Media</label>
                                        </th>

                                        <td>

                                            <?php
                                            echo $this->formInputSelect('socmed_type',
                                                array_combine(array_keys($socmedias), \Cake\Utility\Hash::extract($socmedias, '{s}.0')),
                                                array('id' => 'meds-dd', 'class' => 'input_full')
                                            );
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            <label for="socmed-account-name" style="font-weight: bold;">Account Name</label>
                                        </th>

                                        <td>
                                            <input type="text" class="input_full" id="socmed-account-name" />
                                            <p style="color: #EA7120; font-size: 0.8em;">BUKAN FULLNAME.</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            <label for="socmed-account-url" style="font-weight: bold;">Account Url</label>
                                        </th>

                                        <td>
                                            <input type="text" class="input_full" id="socmed-account-url" />
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <button id="add-socmed" type="button" class="button">Add new</button>

                            <div id="delete-collections"></div>


                        </fieldset>

                    </fieldset>

                </div>

                <div style="clear: both; margin-bottom: 25px; background-color:#478BCA; padding: 10px;">
                    <input value="Update Data" type="submit">
                    <button type="button" onclick="location.href='/apps/membership/profile';">Cancel and Back</button>
                </div>

            </form>

        </div>

    </div>

</section>
