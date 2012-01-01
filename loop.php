<?php
    // No post found, baby
    if (!have_posts()) :
?>
    <article>
        <h1 class="title"><?php _e( "Wait a sec: You're Lost", "pantomime" ); ?></h1>
        <div class="content">
            <p><?php _e( "I'm sorry to say this but the page you are trying to access is not exist.", 'pantomime' ); ?></p>
            <p><?php _e( "You want to go back to the <a href='". get_bloginfo('url') ."'>homepage</a>, perhaps?.", 'pantomime' );?></p>
        </div>
    </article>
<?php
    endif;
    
    // Got post(s) to display
    while ( have_posts() ) : the_post();
        pantomime_content();
    endwhile;