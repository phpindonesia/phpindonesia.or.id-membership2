<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="robots" content="index, follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>PHP Indonesia | Membership</title>

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic|Open+Sans:400,300,600,700,300italic,400italic,600italic,700italic">
    <link rel="stylesheet" href="http://www.phpindonesia.or.id/po-content/phpindo/style.css">
    <link rel="stylesheet" href="http://www.phpindonesia.or.id/po-content/phpindo/shortcodes.css">
    <link rel="stylesheet" href="http://www.phpindonesia.or.id/po-content/phpindo/skins/blue/style.css">
    <link rel="stylesheet" href="<?php echo $this->asset('/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('/css/font-awesome.css') ?>">
    <link rel="stylesheet" href="http://www.phpindonesia.or.id/po-content/phpindo/css/meanmenu.css">
    <link rel="stylesheet" href="http://www.phpindonesia.or.id/po-content/phpindo/css/animations.css">

    <?php if (isset($base_css)): foreach ($base_css as $css): ?>
        <link rel="stylesheet" href="<?php echo $css ?>">
    <?php endforeach; endif; ?>

    <link rel="shortcut icon" href="http://www.phpindonesia.or.id/favicon.png" type="image/png">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="/js/html5shiv.js"></script>
        <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>

<body data-baseurl="<?php echo $this->baseUrl() ?>">
    <div class="wrapper">
        <div class="inner-wrapper">

            <?php echo $this->insert('sections::header') ?>

            <div id="main">
                <div class="breadcrumb-wrapper type2">
                    <div class="container">
                        <div class="main-title">
                            <h1><?php echo $this->e($page_title); ?></h1>
                            <div class="breadcrumb">
                                <a href="http://www.phpindonesia.or.id/">Home</a>
                                <span class="fa fa-angle-right"></span>
                                <a href="<?php echo $this->pathFor('membership-index'); ?>"><?php echo $this->e($page_title); ?></a>
                                <span class="fa fa-angle-right"></span>
                                <span class="current"><?php echo $this->e($sub_page_title); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="primary" class="content-full-width">
                    <?php echo $this->section('content') ?>

                    <div class="dt-sc-margin70"></div>
                </section>
            </div>

            <footer id="footer">
                <?php echo $this->insert('sections::footer') ?>
            </footer>

        </div>
    </div>

    <script src="http://www.phpindonesia.or.id/po-content/phpindo/js/jquery-1.10.2.min.js"></script>
    <script src="http://www.phpindonesia.or.id/po-content/phpindo/js/jquery-migrate.min.js"></script>
    <script src="http://www.phpindonesia.or.id/po-content/phpindo/js/twitter/jquery.tweet.min.js"></script>
    <script src="http://www.phpindonesia.or.id/po-content/phpindo/js/plugins.js"></script>
    <script src="http://www.phpindonesia.or.id/po-content/phpindo/js/okzoom.min.js"></script>
    <script src="http://www.phpindonesia.or.id/po-content/phpindo/js/custom.js"></script>
    <script src="<?php echo $this->asset('/js/jquery.formalize.min.js') ?>"></script>

    <script src="<?php echo $this->asset('/js/membership.js') ?>"></script>

    <?php if (isset($base_js)): foreach ($base_js as $js): ?>
        <script src="<?php echo $js ?>"></script>
    <?php endforeach; endif; ?>

</body>
</html>
