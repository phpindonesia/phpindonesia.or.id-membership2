<?php $this->layout('layouts::layout-system'); ?>

<section id="primary" class="content-full-width">

	<div class="full-width-section" style="margin-bottom: 50px;">

		<div class="container" style="margin-top: -70px;">

            <h3 class="aligncenter"> <span> <i class="fa fa-key"></i></span> Update Password</h3>

            <?php
            echo $this->insert('sections::flash-message');
            ?>

            <form action="<?php echo $this->uri_path_for('membership-update-password'); ?>" method="post" novalidate>

                <table style="width: 70%; margin: 0 auto;">
                    <tbody>
                        <tr>
                            <th>
                                <label for="oldpassword" style="font-weight: bold;">Old Password *</label>
                            </th>
                            <td>
                                <input id="oldpassword" class="input_full" name="oldpassword" type="password" value="<?php echo $this->fh_default_val('oldpassword'); ?>" />
                                <?php
                                echo $this->fh_show_errors('oldpassword', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="password" style="font-weight: bold;">New Password *</label>
                            </th>
                            <td>
                                <input id="password" class="input_full" name="password" type="password" value="<?php echo $this->fh_default_val('password'); ?>" />
                                <?php echo $this->fh_show_errors('password', $_view_validation_errors_); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="repassword" style="font-weight: bold;">Retype New Password *</label>
                            </th>
                            <td>
                                <input id="repassword" class="input_full" name="repassword" type="password" value="<?php echo $this->fh_default_val('repassword'); ?>" />
                                <?php
                                echo $this->fh_show_errors('repassword', $_view_validation_errors_);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <td>
                            	<input value="Update" type="submit" />
                                <button type="button" onclick="location.href='<?php echo $this->uri_path_for('membership-profile'); ?>';">Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>
        </div>

	</div>

</section>
