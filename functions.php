<?php

/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Page Meta
 * 
 */
function pantomime_pagemeta(){
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1">	

	<?php if (is_home()) { ?>
		<meta name="description" content="<?php bloginfo('description'); ?>" />
	<?php } ?>

	<meta name="robots" content="noodp,noydir" />
	
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="Shortcut Icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
	
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' );}

}
add_action('wp_head', 'pantomime_pagemeta', 10);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Webpage Title
 * 
 */
function pantomime_title(){
	echo '<title>';
	if 	( is_home() )			{ bloginfo("name"); echo (' | '); bloginfo('description'); }
	elseif	( is_single() )			{ wp_title(''); }
	elseif	( is_page() || is_paged() ) 	{ bloginfo('name'); wp_title('|'); }
	elseif	( is_archive() )		{ _e('Archive for ', 'pantomime'); wp_title(''); }			
	elseif	( is_author() )			{ wp_title(__(' | Post written by ', 'pantomime'));	} 
	elseif	( is_search() )			{ echo __('Search results for "', 'pantomime') . $s . '"'; }
	elseif	( is_404() )			{ _e('Four-oh-Four', 'pantomime'); } 
	else 					{ _e('Are You Lost?', 'pantomime'); }
	echo '</title>';
}
add_action('wp_head', 'pantomime_title', 20);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Default Stylesheet
 * 
 */
function pantomime_stylesheet(){
	wp_register_style('pantomime-style', get_bloginfo('template_directory') . '/css/style.css', array(), false, 'screen');
	wp_enqueue_style('pantomime-style');	
}
add_action('wp_head', 'pantomime_stylesheet', 30);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Default Javascript
 * 
 */
function pantomime_javascript(){
	wp_deregister_script('jquery');
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', array(), false, false);
	wp_enqueue_script('jquery');	
}
add_action('wp_head', 'pantomime_javascript', 40);