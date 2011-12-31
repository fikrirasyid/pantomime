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
	<div id="main" role="main">
            <div class="wrap clearfix">
                <section>
                    <?php get_template_part( 'loop', 'index' ); ?>
                </section>
                <aside>
                    This is aside
                </aside>
            </div><!-- .wrap.clearfix -->        
	</div>
	<footer>
            <div class="wrap clearfix">
                <?php wp_footer(); ?>                
            </div><!-- .wrap.clearfix -->
	</footer>
</div> <!-- #container -->
</body>
</html>
