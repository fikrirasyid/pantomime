<?php
    // No post found, baby
    if (!have_posts()) :
?>

<?php
    endif;
    
    // Got post(s) to display
    while ( have_posts() ) : the_post();
        pantomime_content();
    endwhile;