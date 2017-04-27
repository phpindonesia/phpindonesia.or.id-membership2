<?php $this->layout('layouts::system') ?>

<div class="full-width-section parallax full-section-bg">
    <div class="container">
        <div class="dt-sc-clear"></div>

        <div class="form-wrapper clearfix">
            <?php echo $this->insert('sections::alert') ?>

            <?php echo $this->section('content') ?>
        </div>
    </div>
</div>

<?php if (isset($helpTitle)): ?>
    <div class="full-width-section">
        <div class="container">
            <div class="dt-sc-margin70"></div>

            <div class="page_info aligncenter">
                <h4 class="title"><?php echo $helpTitle ?></h4>
                <p><?php echo implode('</p><p>', $helpContent) ?></p>
            </div>
        </div>
    </div>
<?php endif ?>
