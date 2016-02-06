<?php
$this->layout('layouts::system');

$this->appendJs([
    $this->asset('/js/portfolio.js')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <h3 style="border-bottom: 1px #000000 solid;">Add new portfolio item</h3>

        <?php echo $this->insert('sections::alert') ?>

        <form action="<?php echo $this->pathFor('membership-portfolios-create'); ?>" method="post" class="checkout" novalidate>
            <?php echo $this->insert('sections::portfolio-form', ['portfolio' => false]) ?>
        </form>

    </div>
</div>
