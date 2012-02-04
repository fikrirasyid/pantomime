<?php
/*
Template Name: One Column
*/
?>

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
            </div><!-- .wrap.clearfix -->        
	</div>
<?php get_footer(); ?>