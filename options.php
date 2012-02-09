<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();

	$options[] = array( "name" => "General",
						"type" => "heading");

	$options[] = array( "name" => "Favicon",
						"desc" => "Upload custom favicon here. Favicon is 16 x 16 pixels .ico formatted image used as site icon",
						"id" => "pantomime_favicon",
						"type" => "upload");	

	$options[] = array( "name" => "Custom Javascript / Stylesheet on &lt;head&gt;",
						"desc" => "Paste custom stylesheet / javascript code such as Google Analytics here. The script will be inserted inside &lt;head&gt; area.",
						"id" => "pantomime_custom_script_head",
						"std" => "",
						"type" => "textarea"); 


	$options[] = array( "name" => "Custom Javascript on footer",
						"desc" => "Paste custom javascript code such as Google Analytics here. The script will be inserted on footer area.",
						"id" => "pantomime_custom_script_foot",
						"std" => "",
						"type" => "textarea"); 

	$options[] = array( "name" => "Color Scheme",
						"type" => "heading");
							

	$options[] = array( "name" => "Link Color",
						"desc" => "Main link color. Most of link presented will use this color.",
						"id" => "pantomime_link_color",
						"std" => "#666666",
						"type" => "color");

	$options[] = array( "name" => "Link Hover",
						"desc" => "Color of hovered link.",
						"id" => "pantomime_link_color_hover",
						"std" => "#BD0000",
						"type" => "color");

	$options[] = array( "name" => "Title Color",
						"desc" => "Color of the text on header.",
						"id" => "pantomime_title_color",
						"std" => "#000000",
						"type" => "color");
        
	$options[] = array( "name" => "Content Link Color",
						"desc" => "Content's link color. Content's link will use this color.",
						"id" => "pantomime_content_link_color",
						"std" => "#AFAFAF",
						"type" => "color");

	
	$options[] = array( "name" => "Typography",
						"type" => "heading");

	$pantomime_heading_typography = array(
                                              "Default" => "Helvetica Neue (Default)",
                                              "Copse" => "Copse",
                                              "Pacifico" => "Pacifico",
                                              "Lobster" => "Lobster",
                                              "Bangers" => "Bangers",
                                              "Kreon" => "Kreon",
                                              "Leckerli+One" => "Leckerli One",
                                              "Carter+One" => "Carter One"
                                            );
	
        $options[] = array( "name" => "Heading Typography",
						"desc" => "Select font that will be used for your headings (site name, content title and content headings).",
						"id" => "pantomime_heading_typography",
						"std" => "Helvetica Neue (Default)",
						"type" => "select",
						"options" => $pantomime_heading_typography);	

	$options[] = array( "name" => "Social Media",
						"type" => "heading");
	
	$options[] = array( "name" => "Facebook Page URL",
						"desc" => "Type Facebook URL here.",
						"id" => "facebook_url",
						"std" => "http://facebook.com/fikri.rasyid.book",
						"type" => "text");

	$options[] = array( "name" => "Twitter Username",
						"desc" => "Type Twitter username here.",
						"id" => "twitter_username",
						"std" => "fikrirasyid",
						"type" => "text");

	$options[] = array( "name" => "RSS Feed URL",
						"desc" => "Type the RSS Feed URL here.",
						"id" => "rssfeed_url",
						"std" => get_bloginfo('url') . "/?feed=rss",
						"type" => "text");

	$options[] = array( "name" => "Feedburner ID",
						"desc" => "Type Google Feedburner ID here. It will be used for email subscription on content's subscription box.",
						"id" => "feedburner_id",
						"std" => "FikriRasyid",
						"type" => "text");	

	$options[] = array( "name" => "Content",
						"type" => "heading");

	$options[] = array( "name" => "Custom text before content",
						"desc" => "Want to add some texts, images or even ads BEFORE every content on every post? Type it here.",
						"id" => "pantomime_before_content",
						"std" => "",
						"type" => "textarea"); 


	$options[] = array( "name" => "Custom text after content",
						"desc" => "Want to add some texts, images or even ads AFTER every content on every post? Type it here.",
						"id" => "pantomime_after_content",
						"std" => "",
						"type" => "textarea"); 

	$options[] = array( "name" => "Custom message for closed comment form",
						"desc" => "Type custom message for closed comment form here.",
						"id" => "pantomime_closed_comment_message",
						"std" => "Sorry but we have decided to close the comment section for this post.",
						"type" => "textarea");
    
	$options[] = array( "name" => "Activate Feedburner email subscription box?",
						"desc" => "Tick this option if you want to show Feedburner email subscription box at the bottom of the content. Make sure that you have Feedburner account and your Feedburner ID",
						"id" => "pantomime_feedburner_subscription_box_status",
						"std" => "0",
						"type" => "checkbox");    

	$options[] = array( "name" => "Custom message for Feedburner email subscription box",
						"desc" => "Type custom message for Feedburner Mail Subscription form here.",
						"id" => "pantomime_feedburner_subscription_box_message",
						"std" => "Type your email address and press the subscribe button. Whenever new content is published here, it will be delivered to your email address. Instantly.",
						"type" => "textarea");

	$options[] = array( "name" => "Ads",
						"type" => "heading");

	$options[] = array( "name" => "Fixed Sidebar Banner",
						"desc" => "Set the ad you want to show on fixed sidebar here.",
						"type" => "info");

	$options[] = array( "name" => "Show Fixed Sidebar ad?",
						"desc" => "Tick this option if you want to show fixed sidebar ad",
						"id" => "pantomime_fixed_sidebar_ad_status",
						"std" => "1",
						"type" => "checkbox");

	$options[] = array( "name" => "Fixed Sidebar Banner Link",
						"desc" => "Type URL you want to use as link in fixed sidebar banner here",
						"id" => "pantomime_fixed_sidebar_ad_link",
						"std" => "http://outstando.com/thoughtplifier/",
						"type" => "text");	

	$options[] = array( "name" => "Fixed Sidebar Banner Image",
						"desc" => "Upload image you want to use as banner here. Maximum width of the image should be 170 pixels.",
						"id" => "pantomime_fixed_sidebar_ad_image",
						"type" => "upload");

	$options[] = array( "name" => "Fixed Sidebar Banner Text",
						"desc" => "Type text you want to use as description of fixed sidebar banner here",
						"id" => "pantomime_fixed_sidebar_ad_text",
						"std" => "Thoughtplifier: a single-column WordPress Themes by Outstando",
						"type" => "text");	
	
	return $options;
}