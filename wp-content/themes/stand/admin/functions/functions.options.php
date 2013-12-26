<?php

add_action('init','of_options');

if (!function_exists('of_options')) {

	function of_options() {

		global $of_set, $pri_color, $sec_color, $sel_color, $bg_color, $layout, $slider_height, $topbar, $bg_patterns, $blog_home_std, $portfolios_home_std, $projects_home_std, $homepage_blocks, $related_posts_std, $related_projects_std, $site_tagline;

		// Access the WordPress Categories via an Array
		$of_categories = array();
		$of_categories_obj = get_categories('hide_empty=0');
		
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
		}
		
		$categories_tmp = array_unshift($of_categories, "Select a category:");

		if ( $of_set['portfolio'] == true ) :
			// Access the WordPress Portfolios via an Array
			$of_portfolios = array();
			$of_portfolios_obj = get_terms('portfolios', 'hide_empty=0');
			foreach ($of_portfolios_obj as $of_port) {
				$of_portfolios[$of_port->term_id] = $of_port->name;
			}
			$portfolios_tmp = array_unshift($of_portfolios, "Select a portfolio:");
		endif;

		// Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");

		// Testing
		$of_options_select = array("one","two","three","four","five");
		$of_options_select_2 = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","-1");
		$of_options_select_3 = array("date","title");
		$of_options_select_4 = array("DESC","ASC");
		$of_options_select_5 = array("true","false");

		$portfolio_related_condition = array('Tags + Categories', 'Tags', 'Categories', 'Current Portfolio');
		$posts_related_condition = array('Tags + Categories', 'Tags', 'Categories');

		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");


		// Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = $homepage_blocks;


		// Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();

		if ( is_dir($alt_stylesheet_path) )
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) )
		    {
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false )
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }
		    }
		}


		// Background Images Reader
		$bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_stylesheet_directory_uri() .'/images/bg/'; // change this to where you store your bg images /* get_template_directory_uri */
		$bg_images = array();

		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) {
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }
		    }
		}


		// Body Background
		$body_repeat = array('repeat' => "repeat", 'no-repeat' => 'no-repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y');

		$body_pos = array(
			'top left' => 'top left',
			'top center' => "top center",
			'top right' => 'top right',
			'center left' => 'center left',
			'center center' => 'center center',
			'center right' => 'center right',
			'bottom left' => 'bottom left',
			'bottom center' => 'bottom center',
			'bottom right' => 'bottom right'
		);

		// Slider
		$slider_home = array(
			1	=> array(
				"order" => "1",
				"title" => "",
				"url"	=> "",
				"link" => "",
				"slider_link_behaviour" => "New Window",
				"description"	=> ""
			),
		);


		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/

		// More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
		$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center");

		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post");



/*-------------------------------------------------------------------------------------------*/
/* The Options Array */
/*-------------------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;

$of_options = array();

// =General Settings
$of_options[] = array( "name" => "General Settings",
					"type" => "heading");

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "introduction",
					"std" => "Here you may customize the general options of your website.",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Logo",
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo (http://yoursite.com/logo.png).",
					"id" => "logo",
					"std" => "",
					// "mod" => "min",
					"type" => "media");

$of_options[] = array( "name" => "",
					"desc" => "Enable Plain Text Logo - use a plain text logo rather than an image",
					"id" => "logo_text",
					"std" => false,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "Enable the Site Tagline",
					"id" => "tagline",
					"std" => $site_tagline,
					"folds" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "Topbar",
					"desc" => "Enable the site topbar",
					"id" => "topbar",
					"std" => $topbar,
					"folds" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "Enter the text you would like to display in the topbar. You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
					"id" => "topbar_text",
					"std" => "You may add some really cool content here, and you may use HTML as well!",
					"fold" => "topbar", /* the checkbox hook */
					"type" => "textarea");

$of_options[] = array( "name" => "Email",
					"desc" => "Enter the email address where you like to receive the emails from the Contact form, leave in blank to use the admin email.",
					"id" => "contact_email",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px PNG/ICO image that will represent your website's favicon.",
					"id" => "custom_favicon",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Custom Logo Login",
					"desc" => "You may change the default WordPress logo login. Upload or specify the image address of your online logo login (http://yoursite.com/custom-logo-login.png). The <strong>maximun image size is 260px * 140px</strong>, otherwise the image will cropped.",
					"id" => "custom_logo_login",
					"std" => "",
					"type" => "upload");

$of_options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => "google_analytics",
					"std" => "",
					"type" => "textarea");


// =Styling Options
$of_options[] = array( "name" => "Styling Options",
					"type" => "heading");

if ( $of_set['main_layout'] == true ) {
	$intro_ml = "In this area you may change the aspect of your website. Choose the layout, link colors, upload a pattern, a background image or add your own custom css.";
} else {
	$intro_ml = "In this area you may change the aspect of your website. Choose the link colors, upload a background image or add your own custom css.";
}

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "introduction",
					"std" => $intro_ml,
					"icon" => true,
					"type" => "info");

/*$of_options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => "alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);*/


if ( $of_set['responsive'] == true ) {

	$of_options[] = array( "name" => "Responsive Layout",
						"desc" => "Enable the responsive layout",
						"id" => "responsive_layout",
						"std" => true,
						"type" => "checkbox");

}

if ( $of_set['main_layout'] == true ) {

	$url =  ADMIN_DIR . 'assets/images/';
	$of_options[] = array( "name" => "Main Layout",
						"desc" => "Select main content and sidebar alignment.",
						"id" => "layout",
						"std" => $layout,
						"type" => "images",
						"options" => array(
							'layout-2cr' => $url . '2cr.png',
							'layout-2cl' => $url . '2cl.png',
							'layout-1col' => $url . '1col.png'
							/*'layout-2-col-portfolio' => $url . '2-col-portfolio.png',
							'layout-3-col-portfolio' => $url . '3-col-portfolio.png',
							'layout-4-col-portfolio' => $url . '4-col-portfolio.png',
							'3c-fixed.css' => $url . '3cm.png',
							'3c-r-fixed.css' => $url . '3cr.png'*/
							)
						);

}

$of_options[] = array( "name" =>  "Link and UI Colors",
					"desc" => "Pick a primary color (default $pri_color).",
					"id" => "primary_color",
					// "std" => "#fd4141",
					"std" => $pri_color,
					"type" => "color");

$of_options[] = array( "name" =>  "",
					"desc" => "Pick a secondary color (default $sec_color).",
					"id" => "secondary_color",
					"std" => $sec_color,
					"type" => "color");

$of_options[] = array( "name" =>  "Selection Color",
					"desc" => "Pick a selection color for the theme (default $sel_color).",
					"id" => "selection_color",
					"std" => $sel_color,
					"type" => "color");

$of_options[] = array( "name" =>  "Background Color",
					"desc" => "Pick a background color for the theme (default $bg_color).",
					"id" => "body_color",
					"std" => $bg_color,
					"type" => "color");

$of_options[] = array( "name" => "Background Patterns",
					"desc" => "Enable the background patterns",
					"id" => "bg_patterns",
					"std" => $bg_patterns, // 0
					"folds" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "You may choose between some default patterns, or upload your own background image using the uploader below.",
					"id" => "custom_bg",
					"std" => $bg_images_url."bg0.png",
					"type" => "tiles",
					"fold" => "bg_patterns", /* the checkbox hook */
					"options" => $bg_images);

$of_options[] = array( "name" => "Background Image",
					"desc" => "Use your own background image rather than color or pattern.",
					"id" => "body_options",
					"std" => 0, // 0
          			"folds" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "Upload your own background image or pattern, or specify the image address of your online image.",
					"id" => "body_image",
					"std" => "",
					"fold" => "body_options", /* the checkbox hook */
					"type" => "upload");

$of_options[] = array( "name" => "Background Repeat",
					"desc" => "Set the background repeat for the background image.",
					"id" => "body_repeat",
					"std" => "repeat",
					"fold" => "body_options", /* the checkbox hook */
					"type" => "radio",
					"options" => $body_repeat);

$of_options[] = array( "name" => "Background Position",
					"desc" => "Set the background position for the background image.",
					"id" => "body_pos",
					"std" => "top left",
					"fold" => "body_options", /* the checkbox hook */
					"type" => "radio",
					"options" => $body_pos);

$of_options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => "custom_css",
                    "std" => "",
                    "type" => "textarea");


// =Homepage
$of_options[] = array( "name" => "Homepage",
                    "type" => "heading");

if ( $of_set['layout_manager'] == true ) {
	$intro_lm = "This area is dedicated to the homepage page template, you may create your own layout using the layout manager feature, add an attractive home message and organize your posts.";
} else {
	$intro_lm = "This area is dedicated to the homepage page template, you may add an attractive home message and organize your posts.";
}

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "introduction",
					"std" => $intro_lm,
					"icon" => true,
					"type" => "info");

if ( $of_set['layout_manager'] == true ) {
	$of_options[] = array( "name" => "Layout Manager",
						"desc" => "Organize how you want the layout to appear on the homepage with drag &amp; drop sortings.",
						"id" => "homepage_layout",
						"std" => $of_options_homepage_blocks,
						"type" => "sorter");
}

/*$of_options[] = array( "name" => "Home Message",
					"desc" => "Enable the home message",
					"id" => "home_message",
					"std" => true, // 0
					"folds" => 1,
					"type" => "checkbox");*/

$of_options[] = array( "name" => "Home Message",
					"desc" => "Enter the home message title.",
					"id" => "home_message_title",
					"std" => "Howdy Folks!",
					// "fold" => "home_message", /* the checkbox hook */
					"type" => "text");

pll_register_string('custom',"Biz Orkestra'yız. Mobil ve internet dünyasında yaratıcı eserler ortaya çıkarıyoruz. İşimize ve müziğe tutku ile bağlı girişimcileriz!..");

$of_options[] = array( "name" => "",
					"desc" => "Enter the text you would like to display as home message. You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
					"id" => "home_message_text",
					"std" => "Enter the text you would like to display as home message.",
					// "fold" => "home_message", /* the checkbox hook */
					"type" => "textarea");

/*$of_options[] = array( "name" => "Latest Blog Posts",
					"desc" => "Enter the blog home title.",
					"id" => "blog_title",
					"std" => "Blog",
					"type" => "text");*/

$of_options[] = array( "name" => "Quote",
					"desc" => "Enter the text you would like to display as quote. You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
					"id" => "quote_text",
					"std" => "Bike messenger by day, aspiring actor by night, etc...",
					"type" => "textarea");

$of_options[] = array( "name" => "Blog",
					"desc" => "Select the category you want to display in the homepage. Leave in blank to show all the categories.",
					"id" => "blog_home_cat",
					"std" => "Uncategorized",
					"type" => "select",
					"options" => $of_categories);

$of_options[] = array( "name" => "",
					"desc" => "Define the number of posts you want to display in the homepage (-1 shows all posts).",
					"id" => "blog_home_postperpage",
					"std" => $blog_home_std,
					"type" => "select",
					"class" => "mini", //mini, tiny, small
					"options" => $of_options_select_2);


if ( $of_set['portfolio'] == true ) {

	// Portfolios
	$of_options[] = array( "name" => "Portfolios",
						"desc" => "Enter the section title.",
						"id" => "portfolios_home_title",
						"std" => "What We Do",
						"type" => "text");

	$of_options[] = array( "name" => "",
						"desc" => "Enter a short description. You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
						"id" => "portfolios_desc",
						"std" => "Bike messenger by day, aspiring actor by night, etc...",
						"type" => "text");

	/*$of_options[] = array( "name" => "",
						"desc" => "Define the number of portfolios you want to display in the homepage (-1 shows all posts).",
						"id" => "portfolios_home_postperpage",
						"std" => $portfolios_home_std,
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $of_options_select_2);*/

	// Projects
	$of_options[] = array( "name" => "Latest Projects",
						"desc" => "Enter the section title.",
						"id" => "projects_home_title",
						"std" => "Recent Works",
						"type" => "text");

	$of_options[] = array( "name" => "",
						"desc" => "Enter a short description. You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
						"id" => "projects_desc",
						"std" => "Bike messenger by day, aspiring actor by night, etc...",
						"type" => "text");

	$of_options[] = array( "name" => "",
						"desc" => "Select the portfolio you want to display in the homepage. Leave in blank to show all the portfolio posts.",
						"id" => "portfolio_home_project",
						"std" => "",
						"type" => "select",
						"options" => $of_portfolios);

	if ( $of_set['portfolio'] == true ) :
	$of_options[] = array( "name" => "",
						"desc" => "Define the number of posts you want to display in the homepage (-1 shows all posts).",
						"id" => "projects_home_postperpage",
						"std" => $projects_home_std,
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $of_options_select_2);
	endif;

	/* Also got rid of an annoing notice, if you want to reuse it please use ""std" => "-1","
	$of_options[] = array( "name" => "Portfolio Page ID",
						"desc" => "The page ID will be used to link the homepage to your portfolio page.",
						"id" => "portfolio_page_id",
						"std" => "-1",
						"type" => "text");*/

}


if ( $of_set['slider'] == true ) {

	// =Slider
	$of_options[] = array( "name" => "Slider",
	                    "type" => "heading");

	$of_options[] = array( "name" => "",
						"desc" => "",
						"id" => "introduction",
						"std" => "Here is where you setup and add images to the homepage slider.",
						"icon" => true,
						"type" => "info");

	$of_options[] = array( "name" => "Slider Manager",
						"desc" => "Add unlimited slides and drag &amp; drop to sort them. The minimum image size is 940px width, if bigger the image will be automatically resized.",
						"id" => "slider_home",
						"std" => $slider_home,
						"type" => "slider");

	$of_options[] = array( "name" => "Slider Options",
						"desc" => "<strong>Slider Height</strong> - define the slider height (default 360).",
						"id" => "slider_height",
						"std" => $slider_height,
						"type" => "text");

	$of_options[] = array( "name" => "",
						"desc" => "<strong>Navigation Arrows</strong> - <i>true</i> to display the navigation arrows.",
						"id" => "slider_arrows",
						"std" => "true",
						"type" => "select",
						"options" => $of_options_select_5);

	$of_options[] = array( "name" => "",
						"desc" => "<strong>Navigation Buttons</strong> - <i>true</i> to display the navigation buttons.",
						"id" => "slider_buttons",
						"std" => "true",
						"type" => "select",
						"options" => $of_options_select_5);

	/***** Mav Slider *****/
	/*$of_options[] = array( "name" => "",
						"desc" => "<strong>Timer</strong> - (integer) the time (in milliseconds) that a slide will wait before automatically navigate to the next one.",
						"id" => "slider_timer",
						"std" => "5000",
						"type" => "text");*/
	//
	/*$of_options[] = array( "name" => "",
						"desc" => "<strong>Link Behaviour</strong> - opens in a new window or in the same one the slider is in.",
						"id" => "slider_link_behaviour",
						"std" => "_blank",
						"type" => "select",
						"options" => $of_options_select_6);*/

}


// =Blog
$of_options[] = array( "name" => "Blog",
                    "type" => "heading");

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "introduction",
					"std" => "Blog Settings",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Related Posts",
					"desc" => "Enable related posts in the single blog page",
					"id" => "related_posts",
					"std" => true, // 0
					"folds" => 1,
					"type" => "checkbox");

$of_options[] = array( "name" => "",
					"desc" => "Select the number of posts you want to display (-1 shows all posts).",
					"id" => "related_posts_perpage",
					"std" => $related_posts_std,
					"fold" => "related_posts", /* the checkbox hook */
					"type" => "select",
					"class" => "mini", //mini, tiny, small
					"options" => $of_options_select_2);

$of_options[] = array( "name" => "",
					"desc" => "Choose the relation between the posts.",
					"id" => "posts_related_condition",
					"fold" => "related_posts", /* the checkbox hook */
					"std" => "none",
					"type" => "select",
					"options" => $posts_related_condition);


if ( $of_set['portfolio'] == true ) {

	// =Portfolio
	$of_options[] = array( "name" => "Portfolio",
	                    "type" => "heading");

	$of_options[] = array( "name" => "",
						"desc" => "",
						"id" => "introduction",
						"std" => "Portfolio Settings",
						"icon" => true,
						"type" => "info");

	$of_options[] = array( "name" => "Sorting",
						"desc" => "You may choose to order your projects by 'date' or by 'title' (default <i>date</i>).",
						"id" => "portfolio_order_1",
						"std" => "date",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $of_options_select_3);

	$of_options[] = array( "name" => "",
						"desc" => "It may also be sorted by 'ASC' (ascending) or 'DESC' (descending), default <i>DESC</i>.",
						"id" => "portfolio_order_2",
						"std" => "date",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $of_options_select_4);

	$of_options[] = array( "name" => "Related Projects",
						"desc" => "Enable related projects in the single project page",
						"id" => "related_projects",
						"std" => true, // 0
	          			"folds" => 1,
						"type" => "checkbox");

	$of_options[] = array( "name" => "",
						"desc" => "Select the number of projects you want to display (-1 shows all posts).",
						"id" => "related_projects_perpage",
						"std" => $related_projects_std,
						"fold" => "related_projects", /* the checkbox hook */
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $of_options_select_2);

	$of_options[] = array( "name" => "",
						"desc" => "Choose the relation between the projects.",
						"id" => "portfolio_related_condition",
						"std" => "none",
						"fold" => "related_projects", /* the checkbox hook */
						"type" => "select",
						"options" => $portfolio_related_condition);

	$of_options[] = array( "name" => "Labels",
						"desc" => "Upload a \"Label\" image for your <strong>Free</strong> project posts (the watermark for each project image).",
						"id" => "project_free_label",
						"std" => get_template_directory_uri() . "/images/label_free.png",
						"type" => "media");

	$of_options[] = array( "name" => "",
						"desc" => "Upload a \"Label\" image for your <strong>New</strong> project posts (the watermark for each project image).",
						"id" => "project_new_label",
						"std" => get_template_directory_uri() . "/images/label_new.png",
						"type" => "media");

	$of_options[] = array( "name" => "Bottom Quote",
						"desc" => "Enter the text you would like to display as quote. You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
						"id" => "portfolio_quote_text",
						"std" => "Bike messenger by day, aspiring actor by night, etc...",
						"type" => "textarea");
}


// =Footer
$of_options[] = array( "name" => "Footer",
                    "type" => "heading");

$of_options[] = array( "name" => "",
					"desc" => "",
					"id" => "introduction",
					"std" => "Here you may setup what will appear in the footer area.",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => "Footer Text Left",
                    "desc" => "You may use HTML and shortcodes: [signup-link] [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
                    "id" => "footer_text_left",
                    "std" => "Copyright &copy; [the-year] [blog-link]. All rights reserved. <br/>Powered by [wp-link]",
                    "type" => "textarea");

$of_options[] = array( "name" => "Footer Text Right",
                    "desc" => "You may use HTML and shortcodes: [the-year] [blog-title] [blog-link] [wp-link] [loginout-link]",
                    "id" => "footer_text_right",
                    "std" => "",
                    "type" => "textarea");


// =Backup Options
$of_options[] = array( "name" => "Backup",
					"type" => "heading");

$of_options[] = array( "name" => "Backup and Restore",
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'Use the buttons below to backup your current options, and then restore it back at a later time.<br/>This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',);

$of_options[] = array( "name" => "Transfer Theme Options Data",
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can transfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',);

	}
}
?>
