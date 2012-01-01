<?php
/*
 * --------------------------------------------------------------------------------------------------------------------------------
 * THEME OPTIONS FRAMEWORK
 * 
 * Made based on Devin Price's Option Framework Theme
 * http://wptheming.com/options-framework-theme/
 *
*/
if ( !function_exists( 'optionsframework_init' ) ) {
    define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
    define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
    
    require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * WordPress Native Custom Image Header
 *
 */
function pantomime_custom_image_header(){
	define( 'HEADER_TEXTCOLOR', 'FFFFFF' );
	define( 'HEADER_IMAGE', '' ); // Leaving empty for random image rotation.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'pantomime_header_image_width', 960 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'pantomime_header_image_height', 400 ) );
	add_custom_image_header( 'pantomime_header_style', 'pantomime_admin_header_style', 'pantomime_admin_header_image' );	
}
add_action('after_setup_theme', 'pantomime_custom_image_header', 5); 

function pantomime_header_style(){
	?>
	<style type="text/css">
		header .wrap{
			background: url('<?php echo get_header_image(); ?>');			
		}
		<?php if ( 'blank' == get_header_textcolor() ) : ?>
		#sitename-wrap{
			display:none;
		}
		<?php elseif ( HEADER_TEXTCOLOR != get_header_textcolor() ) : ?>
		#sitename-wrap,
		#sitename-wrap a{
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
		<?php endif; ?>		
	</style>
	<?php
}

function pantomime_admin_header_style(){
	?>
	<style type="text/css">

	#sitename-wrap{
	    width:400px;
	    margin:150px 40px;
	    float:left;
	    font: 15px "Helvetica Neue", Helvetica, Arial, sans-serif;
	}
	
	#pantomime-title,
	#sitename-wrap p{
	    margin:0; padding:0;
	    float:left; width:100%;
	    text-shadow:0 -1px 0 #000;
	}
	
	#pantomime-title{
	    font-weight:bold;
	    font-size:60px;
	    line-height:1;
	}
	
	#sitename-wrap p{
	    font-size:20px;
	}
	
	#sitename-wrap,
	#pantomime-title{
	    color:#fff;
	}
	
	.appearance_page_custom-header #pantomime-header{
		display:block;
		width:960px; height:400px;
		background:url('<?php echo get_header_image(); ?>');
	}
	
	<?php if ( 'blank' == get_header_textcolor() ) : ?>
	#sitename-wrap{
		display:none;
	}
	<?php elseif ( HEADER_TEXTCOLOR != get_header_textcolor() ) : ?>
	#pantomime-header #sitename-wrap,
	#pantomime-title{
		color: #<?php echo get_header_textcolor(); ?> !important;
	}
	<?php endif; ?>			
	</style>
<?php
}

function pantomime_admin_header_image(){
	?>
	
	<div id="pantomime-header">
		<div id="sitename-wrap">
			<h2 id="pantomime-title"><?php bloginfo('name'); ?></h2>
			<p><?php bloginfo('description'); ?></p>
		</div>
	</div>
	
	<?php
	
}

register_default_headers( array(
		'dancers' => array(
			'url' => '%s/images/headers/dancers.jpg',
			'thumbnail_url' => '%s/images/headers/dancers-thumb.jpg',
			'description' => __( 'Dancers', 'pantomime' )
		),
		'dslr' => array(
			'url' => '%s/images/headers/dslr.jpg',
			'thumbnail_url' => '%s/images/headers/dslr-thumb.jpg',
			'description' => __( 'DSLR', 'pantomime' )
		),
		'photographer' => array(
			'url' => '%s/images/headers/photographer.jpg',
			'thumbnail_url' => '%s/images/headers/photographer-thumb.jpg',
			'description' => __( 'Photographer', 'pantomime' )
		)
	) );





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Registering Custom Menus
 *
 */
function pantomime_register_menu(){
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'main_nav' => 'Main Navigation'
			)
		);
	}	
}
add_action( 'after_setup_theme', 'pantomime_register_menu' );






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
add_action('wp_head', 'pantomime_pagemeta', 0);





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
add_action('wp_head', 'pantomime_title', 3);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Default Stylesheet
 * 
 */
function pantomime_stylesheet(){
	wp_register_style('pantomime-style', get_bloginfo('template_directory') . '/css/style.css', array(), false, 'screen');
	wp_enqueue_style('pantomime-style');	
}
add_action('wp_head', 'pantomime_stylesheet', 5);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Default Javascript
 * 
 */
function pantomime_javascript(){
	/*
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', array(), false, false );
	*/
	wp_enqueue_script( 'jquery' );
	
	?>
	<script type="text/javascript">
		//<![CDATA[
			jQuery(document).ready(function($){
				$('nav li').hover(
					function(){ $(this).addClass('hovered').children('ul').fadeIn(); },
					function(){ $(this).removeClass('hovered').children('ul').fadeOut(); }
				);
			});
		//]]>
	</script>
	<?php
}
add_action('wp_head', 'pantomime_javascript', 10);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Sitename
 * for the sake of SEO, make sure that there is only one headin 1 per page
 * 
 */
function pantomime_sitename(){
	if (is_home()){
		$heading_tag = 'h1';
		$copy = get_bloginfo( "name" );	
	} else {
		$heading_tag = 'h2';
		$copy = '<a href="'. get_bloginfo( "url" ) .'" class="emboss-dark">'. get_bloginfo( "name" ) .'</a>';
	}

	echo '
		<div id="sitename-wrap" class="emboss-dark">
			<'. $heading_tag .' id="sitename">'. $copy .'</'. $heading_tag .'>
			<p>'. get_bloginfo( "description" ) .'</p>
		</div>
	';
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Content
 * 
 */
function pantomime_content(){
	?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if( is_single() ): ?>
                <h1 class="title"><?php the_title(); ?></h1>
		<?php else: ?>
                <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>		
		<?php endif;?>

                <p class="meta">
                    <?php _e( 'Written by', 'pantomime' ); ?> <span class="fn"><?php the_author_link(); ?></span>
                    <?php _e( 'on ', 'pantomime' ); ?> <span class="date"><?php the_date(); ?></span>
                    <?php _e( 'filed under ', 'pantomime' ); ?> <span class="categories"><?php the_category(', '); ?></span>
                    <?php _e( 'and tagged with', 'pantomime' ); ?> <span class="tags"><?php the_tags(''); ?></span>
                </p>
		<?php do_action('pantomime_before_content')?>
                <div class="content"><?php the_content(__( 'Read More', 'pantomime' )); ?></div>
		<?php do_action('pantomime_after_content'); ?>
        </article>	
	<?
	do_action('pantomime_after_article');
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Share Buttons
 * 
 */
function pantomime_share_buttons(){
	if ( is_single() ) :
	?>
	<div class="share-buttons clearfix">
		<div class="item">
			<strong><?php _e('Share This: ', 'pantomime'); ?></strong>
		</div>
		<div class="item">
			<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $share_link; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=95&amp;action=like&amp;font&amp;colorscheme=light&amp;height=20" scrolling="no" frameborder="0" style="border:none;" allowTransparency="true"></iframe>                			
		</div>
		<div class="item">
			<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>                
		</div>
		<div class="item">
			<!-- Place this tag where you want the +1 button to render -->
			<g:plusone annotation="inline" width="50"></g:plusone>
			
			<!-- Place this render call where appropriate -->
			<script type="text/javascript">
			(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
			</script>                   
		</div>		
	</div>
	<?php
	endif;
}
add_action('pantomime_after_content', 'pantomime_share_buttons');





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Author Box on article page
 * 
 */
function pantomime_author_box(){
	if ( is_single() ) :
	// Get the author email -> for Gravatar
	$author_email = get_the_author_meta('user_email');
		
	// Get the author description
	$author_description = get_the_author_meta('description');	
	?>

	<div id="author-box" class="emboss">
		<h4 class="section-title"><?php _e('About The Author', 'pantomime'); ?></h4>
		<?php
			echo get_avatar($author_email, 50, '');
			echo '<p>' . get_the_author_link() . ' - ' . $author_description . '</p>';
		?>
	</div>
	
	<?php
	endif;
}
add_action('pantomime_after_article', 'pantomime_author_box', 10);	





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Comment
 * 
 */
add_filter('get_comments_number', 'pantomime_comment_count', 0);
function pantomime_comment_count( $count ) {
	global $id;
	$comments_by_type = &separate_comments(get_comments('post_id=' . $id));
	return count($comments_by_type['comment']);
}

function pantomime_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="comment-<?php comment_ID(); ?>">
		<?php comment_author_link(); ?>
		<span><?php comment_date('d m y'); ?></span>
	<?php
}

function pantomime_comment_item($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">	
		<div id="div-comment-<?php comment_ID() ?>" class="comment-wrap">
			<div class="comment-wrap-inside clearfix">
				<div class="comment-avatar">
					<?php echo get_avatar($comment, 50, ''); ?>
				</div>
				<div class="comment-content">
					<p class="comment-author"><strong><?php comment_author_link(); ?></strong></p>
                                        <p class="comment-date"><?php printf( get_comment_time('d F Y')) ?><?php edit_comment_link(__('| Edit', 'pantomime'),'  ','') ?></p>
					<?php if ($comment->comment_approved == '0') : ?>
					<p><em><?php _e('Your comment will appear after being approved by admin.', 'pantomime') ?></em> </p>
					<?php endif; ?>
					<div class="content">
                                            <?php comment_text() ?>
                                        </div>
					<?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'pantomime'), 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>
		</div><!-- .comment-wrap -->
	<?php
}

function pantomime_comment(){
	if (is_single() || is_page()){
		comments_template('', true);		
	}
}
add_action('pantomime_after_article', 'pantomime_comment', 50);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Register Sidebar
 * 
 */
function pantomime_register_sidebar(){
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'pantomime' ),
		'id' => 'main-sidebar',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	) );	
}
add_action( 'widgets_init', 'pantomime_register_sidebar' );


/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Footer Credit
 * 
 */
function pantomime_credit(){
	echo '<p id="footer-credit">';
	_e('<a href="http://outstando.com/pantomime/">Pantomime Theme</a>. Designed &amp; Code-crafted in Bandung, Indonesia', 'pantomime');
	echo '</p>';
}
add_action('wp_footer', 'pantomime_credit', 10);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Count Number of Queries
 * 
 */
function pantomime_num_queries(){
	echo '<p id="footer-num-queries">';
	_e('Generated from '. get_num_queries() .' queries in '. timer_stop(0,3) .' seconds.', 'pantomime');
	echo '</p>';
}
add_action('wp_footer', 'pantomime_num_queries', 20);