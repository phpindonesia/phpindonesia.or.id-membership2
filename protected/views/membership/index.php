<?php $this->layout('layouts::layout-system'); ?>

<?php
$this->append_js(array(
    $this->uri_base_url() . '/public/js/app/membership/index.js'
));
$this->append_css(array(
    $this->uri_base_url() . '/public/css/chabibnr.css'
));
?>
<section id="primary" class="content-full-width">

    <div class="full-width-section">

        <div class="container bootstrap" style="margin-top: -70px;">
            <div class="row">
                <div class="col-md-3">
                    <form class="aside-search" action="<?php echo $this->uri_path_for('membership-index'); ?>"
                          method="get">
                        <h3 class="aside-header">CARI MEMBER</h3>
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <label class="aside-label">Provinsi</label>
                                <?php
                                echo $this->fh_input_select('province_id', $provinces, array(
                                    'id' => 'provinces-dd',
                                    'class' => 'aside-input'
                                ));
                                ?>
                            </div>
                            <div class="col-md-12 col-sm-6">
                                <label class="aside-label">Kota</label>
                                <?php
                                echo $this->fh_input_select('city_id', $cities, array(
                                    'id' => 'cities-dd',
                                    'class' => 'aside-input'
                                ));
                                ?>
                            </div>
                        </div>

                        <label class="aside-label">Area</label>
                        <input type="text" id="area" class="aside-input" name="area"
                               value="<?php echo $this->fh_default_val('area', null, true); ?>"/>

                        <div>
                            <button type="submit" class="aside-submit">Search</button>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <?php
                        echo $this->insert('sections::flash-message');
                        ?>

                        <?php foreach ($members as $member): ?>
                            <div class="col-md-4 col-xs-12 col-sm-6">
                                <div class="card-profile">
                                    <div class="card-profile-header">
                                        <img class="card-profile-circle"
                                             src="<?php echo $this->uri_user_photo($member['photo'], ['width' => '100', 'height' => '100']) ?>"/>
                                        <span class="card-profile-name text-ellipsis"><?php echo $member['fullname']; ?></span>
                                        <span class="card-profile-subname text-ellipsis">
                                            <span style="color: rgba(191, 222, 255, 0.75);">@</span><?php echo $member['username'] ?>
                                        </span>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-profile-footer">
                                        <div><?php echo $member['province'] ?></div>
                                        <div><?php echo $member['city']; ?></div>
                                        <a href="<?php echo $this->uri_path_for('membership-detail', array('name' => $member['username'])); ?>"
                                           class="card-profile-action">
                                            <i class="fa fa-external-link"></i>
                                        </a>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pagination" style="text-align:center;">
                        <?php
                        echo $html_view_pager;
                        ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

</section>
