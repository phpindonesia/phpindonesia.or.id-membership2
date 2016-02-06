<?php
$this->layout('layouts::system');

$this->appendJs([
    $this->asset('/js/portfolio.js')
]);
?>

<div class="dt-sc-margin70"></div>

<div class="full-width-section">
    <div class="container">

        <h3 style="border-bottom: 1px #000000 solid;">Edit Portfolio Item</h3>

        <?php echo $this->insert('sections::alert') ?>

        <form action="<?php echo $this->pathFor('membership-portfolios-update', ['id' => $portfolio['member_portfolio_id']]); ?>" method="post" class="checkout" novalidate>
            <input type="hidden" name="member_portfolio_id" value="<?php echo $portfolio['member_portfolio_id']; ?>" />

            <?php echo $this->formInputMethod('PUT') ?>
            <?php echo $this->insert('sections::portfolio-form', ['portfolio' => $portfolio]) ?>
        </form>

    </div>
</div>
