<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="container">
	<header>
            <div class="wrap clearfix">
                <?php pantomime_sitename(); ?>
            </div><!-- .wrap.clearfix -->
	</header>
    <nav class="emboss-dark">
        <div class="wrap clearfix">
            <?php wp_nav_menu(array('theme_location' => 'main_nav')); ?>
        </div><!-- .wrap.clearfix -->
    </nav>