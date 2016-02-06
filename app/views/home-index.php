<?php
$this->layout('layouts::system');

$this->appendJs([
    $this->asset('/js/regional.js')
]);
$this->appendCss([
    $this->asset('/css/chabibnr.css')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <div class="column dt-sc-one-fourth first">
            <form class="aside-search clearfix" action="<?php echo $this->pathFor('membership-index'); ?>" method="get">
                <h3 class="aside-header">CARI MEMBER</h3>

                <div class="form-group">
                    <label class="control-label">Provinsi</label>
                    <?php echo $this->formInputSelect('province_id', $provinces, [
                        'id' => 'provinces-dd',
                        'class' => 'form-control'
                    ]); ?>
                </div>

                <div class="form-group">
                    <label class="control-label">Kota</label>
                    <?php echo $this->formInputSelect('city_id', $cities, [
                        'id' => 'cities-dd',
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="form-group">
                    <label class="control-label">Area</label>
                    <input type="text" id="area" class="form-control" name="area" value="<?php echo $this->requestBody('area', null, true); ?>"/>
                </div>

                <div class="form-group">
                    <input value="Search" type="submit" class="btn btn-primary" />
                </div>

            </form>
        </div>

        <div class="column dt-sc-three-fourth">
            <?php echo $this->insert('sections::alert'); $i = 0; ?>

            <?php foreach ($members as $member): ?>
                <div class="column dt-sc-one-third<?php echo ($i % 3 == 0) ? ' first' : '' ?>">
                    <div class="card-profile clearfix">
                        <div class="card-profile-header clearfix">
                            <img class="img card-profile-circle" src="<?php echo $this->userPhoto($member['photo'], ['width' => '100', 'height' => '100']) ?>"/>
                            <span class="card-profile-name text-ellipsis"><?php echo $member['fullname']; ?></span>
                            <span class="card-profile-subname text-ellipsis">
                                <span style="color: rgba(191, 222, 255, 0.75);">@</span><?php echo $member['username'] ?>
                            </span>
                        </div>
                        <div class="card-profile-footer clearfix">
                            <p><?php echo $member['province'] ?></p>
                            <p><?php echo $member['city']; ?></p>
                            <a href="<?php echo $this->pathFor('membership-profile', ['username' => $member['username']]); ?>"
                               class="card-profile-action">
                                <i class="fa fa-external-link"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php $i++; echo ($i % 3 == 0) ? '<hr>' : ''; endforeach; ?>

            <div class="pagination" style="text-align:center;">
                <?php // echo $html_view_pager; ?>
            </div>

        </div>
    </div>

</div>

