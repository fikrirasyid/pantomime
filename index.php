<?php get_header(); ?>
	<div id="main" role="main">
            <div class="wrap clearfix">
                <section>
                    <?php
                        pantomime_template_title($s);
                        get_template_part( 'loop', 'index' );
                        pagenavi();
                    ?>
                </section>
                <aside class="emboss widget-wrap">
                    <ul id="sidebar-main"><?php dynamic_sidebar( 'main-sidebar' ); ?></ul>
                </aside>
            </div><!-- .wrap.clearfix -->        
	</div>
<?php get_footer(); ?>