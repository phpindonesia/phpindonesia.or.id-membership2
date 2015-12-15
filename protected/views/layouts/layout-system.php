<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="robots" content="index, follow"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<title>PHP Indonesia | Membership</title>

	<link href="<?php echo $this->uri_base_url().'/public/css/style.css?v='.time(); ?>" rel="stylesheet">
	<link href="<?php echo $this->uri_base_url().'/public/css/bootstrap.css' ?>" rel="stylesheet">
	<link id="shortcodes-css" rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/shortcodes.css'; ?>" type="text/css" media="all"/>
	<link id="layer-slider" rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/layerslider.css'; ?>" media="all"/>
	<link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/prettyPhoto.css'; ?>" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/animations.css'; ?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/responsive.css'; ?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/meanmenu.css'; ?>" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/font-awesome.min.css'; ?>" type="text/css" />
<<<<<<< HEAD
<<<<<<< 7edac41c9c42601461d9840d3667ac87d8b14901
    <link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/formalize.css?v='.time(); ?>" />
	<link rel="stylesheet" href="<?php echo $this->uri_base_url().'/public/css/responsive2.css'; ?>" type="text/css" media="all" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" type="text/css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" type="text/css" />
=======
>>>>>>> Add Bootstrap grid system
=======

	<link rel="shortcut icon" href="<?php echo $this->uri_base_url().'/public/images/favicon.png'; ?>" type="image/png">

>>>>>>> 0d49ae36e92a477cbb134cf782a787e49c18f4e5
	<?php
	if (isset($layout_use_captcha) && $layout_use_captcha == true):
	?>
	<script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>
	<?php
	endif;
	?>

	<?php
	if (isset($_view_css_)):
		foreach ($_view_css_ as $css):
			echo '<link href="'.$css.'" rel="stylesheet">';
			echo "\n";
		endforeach;
	endif;     
	?>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="<?php echo $this->uri_base_url().'/js/html5shiv.js'; ?>"></script>
	<script src="<?php echo $this->uri_base_url().'/js/respond.min.js'; ?>"></script>
	<![endif]-->
</head>

<body>
<div class="wrapper">
	<div class="inner-wrapper">

		<?php
		echo $this->insert('sections::header');
		?>

		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1><?php echo $this->e($page_title); ?></h1>
                        <div class="breadcrumb">
                            <a href="http://www.phpindonesia.or.id/./">Home</a>
                            <span class="fa fa-angle-right"></span>
							<a href="<?php echo $this->uri_path_for('membership-index'); ?>"><?php echo $this->e($page_title); ?></a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current"><?php echo $this->e($sub_page_title); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dt-sc-margin100"></div>

			<section id="primary" class="content-full-width">
				<?php
				echo $this->section('content');
				?>
			</section>
		</div>

		<footer id="footer">
			<?php
			echo $this->insert('sections::footer');
			?>
		</footer>

	</div>
</div>

<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/jquery-1.10.2.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/jquery-migrate.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/twitter/jquery.tweet.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/plugins.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/jquery.formalize.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/okzoom.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/custom.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/jquery.formalize.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo $this->uri_base_url().'/public/js/app/app.js?='.time(); ?>"></script>

<script type="text/javascript">
<?php echo "_base_url_ = '".$this->uri_base_url()."';\n"; ?>
</script>

<?php
if (isset($_view_js_)):
    foreach ($_view_js_ as $js):
        echo '<script src="'.$js.'?v='.time().'"></script>';
        echo "\n";
    endforeach;
endif;     
?>

</body>
</html>