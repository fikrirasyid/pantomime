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
	
	<?php if ( of_get_option( 'pantomime_favicon' ) == true && of_get_option( 'pantomime_favicon' ) != '' ) : ?>
	<link rel="Shortcut Icon" href="<?php echo of_get_option( 'pantomime_favicon' ); ?>" type="image/x-icon" />	
	<?php else: ?>
	<link rel="Shortcut Icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
	<?php endif; ?>
	
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
 * Added from Theme Init
 * Last modified by Fikri Rasyid (fikrirasyid@gmail.com) on February 4, 2012
 * 
 */
function pantomime_stylesheet(){
	wp_register_style('pantomime-style', get_bloginfo('template_directory') . '/css/style.css', array(), false, 'screen');
	wp_register_style('pantomime-one-column-style', get_bloginfo('template_directory') . '/css/style-one-column.css', array(), false, 'screen');
	
	wp_enqueue_style('pantomime-style');
	if (is_page_template( 'temp-one-column.php' )){
			wp_enqueue_style('pantomime-one-column-style');		
	}
}
add_action('wp_head', 'pantomime_stylesheet', 5);


// Adding stylesheet for content editor
add_editor_style('/css/pantomime-editor-style.css?' . time());




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
 * Google Webfont for Headings
 *
 */
function pantomime_custom_headings(){
    if ( of_get_option( 'pantomime_heading_typography', '' ) != '' && of_get_option('pantomime_heading_typography', '') != 'Default' ){
	$printed_typography = str_replace( "+", " ", of_get_option( 'pantomime_heading_typography', '' ) );
	?>
	<link href='http://fonts.googleapis.com/css?family=<?php echo of_get_option( 'pantomime_heading_typography', '' ); ?>' rel='stylesheet' type='text/css'>
	<style type="text/css">
		h1, h2, h3, h4, h5, h6{
			font-family: '<?php echo $printed_typography; ?>';
		}
	</style>	
	<?php
    }
}
add_action('wp_head', 'pantomime_custom_headings', 6);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Color Scheme
 *
 */
function pantomime_color_scheme(){ ?>
	
	<style type="text/css">
		/* Link */
		a{
		    color:<?php echo of_get_option( 'pantomime_link_color', '#666666' ); ?>;
		}
		
		a:hover,
		article a:hover{
		    color:<?php echo of_get_option( 'pantomime_link_color_hover', '#BD0000' ); ?>;
		}
		
		.title,
		.title a{
		    color:<?php echo of_get_option( 'pantomime_title_color', '#000000' ); ?>;
		}
		
		.meta a,
		.content a,
		#archive-title span{
		    color:<?php echo of_get_option( 'pantomime_content_link_color', '#AFAFAF' ); ?>;
		}	
	</style>
	
	<?php
}
add_action('wp_head', 'pantomime_color_scheme', 8);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Custom Scripts fetched from theme options
 *
 */
/* Allow <script> tag to be embedded in theme option's textarea */
add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'tp_sanitize_textarea' );
}
 
function tp_sanitize_textarea($input) {
    global $allowedposttags;
      $custom_allowedtags["script"] = array();
      $custom_allowedtags["style"] = array();
      
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}

function pantomime_custom_script_head(){
	echo of_get_option('pantomime_custom_script_head', '');
}
add_action('wp_head', 'pantomime_custom_script_head', 7);

function pantomime_custom_script_foot(){
	echo of_get_option('pantomime_custom_script_foot', '');
}
add_action('wp_footer', 'pantomime_custom_script_foot', 5);







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
 * Custom title for different page type
 * 
 */
function pantomime_template_title($s){
	if (is_category()) { ?>
		<h1 id="archive-title"><?php _e( 'Posts categorized into ', 'pantomime' ); ?> <span><?php echo single_cat_title(); ?></span> :</h1>			
	<?php } elseif (is_tag()) { ?>
		<h1 id="archive-title"><?php _e( 'Posts tagged with ', 'pantomime' ); ?> <span><?php echo single_tag_title(); ?></span> :</h1>
	<?php } elseif (is_search()) { ?>
		<h1 id="archive-title"><?php _e( 'Search results for ', 'pantomime' ); ?> <span><?php echo $s ?></span> :</h1>
	<?php } elseif (is_archive()  ) { ?>
		<h1 id="archive-title"><?php _e( 'Posts published on', 'pantomime' ); ?> <span><?php wp_title(''); ?></span></h1>
	<?php }

}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Custom Text / Anything Before & After Content on Single View
 * 
 */
function pantomime_custom_text_before_content(){
	if ( is_single() ) :
		echo of_get_option( 'pantomime_before_content', '' );
	endif;
}
add_action( 'pantomime_before_content', 'pantomime_custom_text_before_content', 5); 

function pantomime_custom_text_after_content(){
	if ( is_single() ) :
		echo of_get_option( 'pantomime_after_content', '' );	
	endif;
}
add_action( 'pantomime_after_content', 'pantomime_custom_text_after_content', 5); 





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
add_action('pantomime_after_content', 'pantomime_share_buttons', 10);





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
 * Page Navigation
 * 
 * Based on Boutros AbiChedid
 * http://bacsoftwareconsulting.com/blog/index.php/web-programming/add-custom-wordpress-pagination-without-plugin/
 *
*/

/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}
 
/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = '&raquo;';
    $pagenavi_options['prev_text'] = '&laquo;';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
 
    //If NOT a single Post is being displayed
    /*http://codex.wordpress.org/Function_Reference/is_single)*/
    if (!is_single()) {
        $request = $wp_query->request;
        //intval Ñ Get the integer value of a variable
        /*http://php.net/manual/en/function.intval.php*/
        $posts_per_page = intval(get_query_var('posts_per_page'));
        //Retrieve variable in the WP_Query class.
        /*http://codex.wordpress.org/Function_Reference/get_query_var*/
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
 
        //empty Ñ Determine whether a variable is empty
        /*http://php.net/manual/en/function.empty.php*/
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
 
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        //ceil Ñ Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
 
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
 
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            /*http://php.net/manual/en/function.str-replace.php */
            /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before.'<div class="pagenavi">'."\n";
 
            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span> <div class="the-navi">';
            }
            //Displays a link to the previous post which exists in chronological order from the current post.
            /*http://codex.wordpress.org/Function_Reference/previous_post_link*/
 
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                /*http://codex.wordpress.org/Data_Validation*/
                //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">&laquo First</a>';
            }

            previous_posts_link($pagenavi_options['prev_text']);

 
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="current">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }

            next_posts_link($pagenavi_options['next_text'], $max_page);
 
            if ($end_page < $max_page) {
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">Last &raquo;</a>';
            }
 
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            echo '</div></div>'.$after."\n";
        }
    }
}





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
	_e('<a href="https://github.com/fikrirasyid/pantomime">Pantomime Theme (beta)</a>. Designed &amp; code-crafted by <a href="http://fikrirasyid.com" title="Fikri Rasyid, front end & WordPress theme developer, Bandung Indonesia.">Fikri Rasyid</a> in Bandung, Indonesia', 'pantomime');
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





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * STYLE LOGIN SCREEN
 *
 * I left the screen plain white because I like it that way.
 * Custom usage may modify this function.
 * At least you don't need to find its selectors and properties. ;)
 *
 * Added by Fikri Rasyid (fikrirasyid@gmail.com) on 4 Feb 2012
 * Last modified by Fikri Rasyid (fikrirasyid@gmail.com) on 4 Feb 2012
 * 
 */
function pantomime_custom_login_style_script(){
    ?>
    
    <style type="text/css">
        body{
            background:#FFF!important;
            height:100%;
            width:100%;
            position:fixed;
        }
        
        .login #nav a,
		.login #backtoblog a {
            color: #999 !important;
            text-shadow:none;
        }

        .login #nav a:hover,
		.login #backtoblog a:hover{
				color:#960000 !important;
		}
        
        .login h1 a{
            cursor:pointer;
        }   
    </style>
	
    <?php		
}
add_action('login_head', 'pantomime_custom_login_style_script');