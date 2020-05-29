<?php
	if(is_single()){
		the_post();
		$cate = get_the_category();
		$categoria = $cate[0]->term_id;
		$idd = get_the_ID();
		wp_redirect("/?cat=".$categoria."#obra-".$idd);
	}

	// TRAE CONFIGURACIONES DE PLANTILLA
	global $options;
	foreach ($options as $value) {
    		if (get_settings( $value['id'] ) === FALSE) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_settings( $value['id'] );
		}
	}
?>
<!doctype html>
<html lang="es" class="no-js">
<head>

  <meta charset="utf-8">

  <!-- www.phpied.com/conditional-comments-block-downloads/ -->
  <!--[if IE]><![endif]-->

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php wp_title( '|', true, 'right' ); bloginfo('title'); ?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>">


  <!--  Mobile Viewport Fix
        j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag
  device-width : Occupy full width of the screen in its current orientation
  initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
  maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
  -->
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">


  <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <!-- <link rel="apple-touch-icon" href="/apple-touch-icon.png"> -->


  <!-- CSS : implied media="all" -->
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css">

  <!-- For the less-enabled mobile browsers like Opera Mini -->
  <link rel="stylesheet" media="handheld" href="<?php bloginfo('stylesheet_directory'); ?>/css/handheld.css?v=1">


  <!-- GOOGLE FONTS -->

  <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>


  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="<?php bloginfo('stylesheet_directory'); ?>/js/modernizr-1.5.min.js"></script>

	<?php
		wp_enqueue_script( 'jquery' );
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		wp_head();

	?>
</head>

<!--[if lt IE 7 ]> <body <?php body_class('ie6'); ?>> <![endif]-->
<!--[if IE 7 ]>    <body <?php body_class('ie7'); ?>> <![endif]-->
<!--[if IE 8 ]>    <body <?php body_class('ie8'); ?>> <![endif]-->
<!--[if IE 9 ]>    <body <?php body_class('ie9'); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body <?php body_class(); ?>> <!--<![endif]-->

  <div id="container">
    <header>
	<h1 id="montyme" class="off"><?php bloginfo("name"); ?></h1>
	<address id="contacto" class="clearfix ">
		<?php echo(stripslashes(get_option("monty_contacto",'default'))); ?>
	</address>
    </header>
    <nav>
    	<?php wp_nav_menu('main'); ?>
    </nav>

	<!-- <span class="lang">
		<a href="#en">English</a>
	</span> -->
