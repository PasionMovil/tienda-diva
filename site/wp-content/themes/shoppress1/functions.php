<?php

/////////////////////////////////////// Localisation ///////////////////////////////////////


load_theme_textdomain('gp_lang', get_template_directory() . '/languages');
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if(is_readable($locale_file)) require_once($locale_file);


/////////////////////////////////////// Theme Information ///////////////////////////////////////


$themename = get_option('current_theme'); // Theme Name
$dirname = strtolower(str_replace(" ", "", get_option('current_theme'))); // Directory Name


/////////////////////////////////////// File Directories ///////////////////////////////////////


define("gp", get_template_directory() . '/');
define("gp_inc", get_template_directory() . '/lib/inc/');
define("gp_scripts", get_template_directory() . '/lib/scripts/');
define("gp_admin", get_template_directory() . '/lib/admin/inc/');
define("gp_wc", get_template_directory() . '/woocommerce/');


/////////////////////////////////////// Additional Functions ///////////////////////////////////////


// Main Theme Options
require_once(gp_admin . 'theme-options.php');
require(gp_inc . 'options.php');

// Meta Options
require_once(gp_admin . 'theme-meta-options.php');

// Sidebars
require_once(gp_admin . 'theme-sidebars.php');

// Shortcodes
require_once(gp_admin . 'theme-shortcodes.php');

// Custom Post Types
require_once(gp_admin . 'theme-post-types.php');

// Update Notification
require_once(gp_admin . 'theme-update-notification.php');

// TinyMCE
if(is_admin()) { require_once (gp_admin . 'tinymce/tinymce.php'); }

// WP Show IDs
if(is_admin()) { require_once(gp_admin . 'wp-show-ids/wp-show-ids.php'); }

// Import/Export Widgets
if(is_admin()) { require_once(gp_admin . 'widget-settings-importexport/widget_data.php'); }

// Auto Install
if(is_admin()) { require_once(gp_admin . 'theme-auto-install.php'); }

// Image Resizer
require_once(gp_scripts . 'image-resizer.php');

// Woocommerce Functions
if(file_exists(gp_wc.'functions-woocommerce.php')) { require_once(gp_wc . 'functions-woocommerce.php'); }


/////////////////////////////////////// Enqueue Styles ///////////////////////////////////////


function gp_enqueue_styles() { 
	if(!is_admin()){
	
		global $post, $dirname;
		require(gp_inc . 'options.php');

		wp_enqueue_style('reset', get_template_directory_uri().'/lib/css/reset.css');

		wp_enqueue_style('gp-style', get_stylesheet_directory_uri().'/style.css');
		
		wp_enqueue_style('responsive', get_template_directory_uri().'/responsive.css');
	
		wp_enqueue_style('prettyphoto', get_template_directory_uri().'/lib/scripts/prettyPhoto/css/prettyPhoto.css');

		if(isset($_GET['skin']) && $_GET['skin'] == "default") {
			$skin = $_COOKIE['SkinCookie']; 
			setcookie('SkinCookie', $skin, time()-3600);
			$skin = get_option($dirname.'_skin');
		} elseif(isset($_GET['skin'])) {
			$skin = $_GET['skin'];
			setcookie('SkinCookie', $skin);			
		} elseif(isset($_COOKIE['SkinCookie'])) {
			$skin = $_COOKIE['SkinCookie']; 
		}

		if((isset($_GET['skin']) && $_GET['skin'] != "default") OR (isset($_COOKIE['SkinCookie']) && $_COOKIE['SkinCookie'] != "default")) {
			
			wp_enqueue_style('style-skin', get_template_directory_uri().'/style-'.$skin.'.css');		
		
		} else {

			if((is_singular() && !is_attachment() && !is_404()) && (get_post_meta($post->ID, $dirname.'_skin', true) && get_post_meta($post->ID, $dirname.'_skin', true) != "Default")) {

				wp_enqueue_style('style-skin', get_template_directory_uri().'/style-'.get_post_meta($post->ID, $dirname.'_skin', true).'.css');		
	
			} else {
		
				wp_enqueue_style('style-skin', get_template_directory_uri().'/style-'.get_option($dirname.'_skin').'.css');
				
			}
		
		}
	
		if(get_option($dirname.'_custom_stylesheet')) {
		
			wp_enqueue_style('style-theme-custom', get_template_directory_uri().'/'.get_option($dirname.'_custom_stylesheet'));		
		
		}
		
		if((is_single() OR is_page()) && get_post_meta($post->ID, $dirname.'_custom_stylesheet', true)) {
		
			wp_enqueue_style('style-page-custom', get_template_directory_uri().'/'.get_post_meta($post->ID, $dirname.'_custom_stylesheet', true));		
		
		}
	
	}
}
add_action('wp_print_styles', 'gp_enqueue_styles');


/////////////////////////////////////// Enqueue Scripts ///////////////////////////////////////


function gp_enqueue_scripts() { 
	if(!is_admin()){
	
		require(gp_inc . 'options.php');

		wp_enqueue_script('jquery');
		
		wp_enqueue_script('jquery-ui-accordion');
		
		wp_enqueue_script('jquery-ui-tabs');
				
		if(is_singular()) wp_enqueue_script('comment-reply');
		
		wp_enqueue_script('swfobject', 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js');
		
		wp_enqueue_script('jwplayer', get_template_directory_uri().'/lib/scripts/mediaplayer/jwplayer.js', array('jquery'));
		
		wp_enqueue_script('flex-slider', get_template_directory_uri().'/lib/scripts/jquery.flexslider.js', array('jquery'));
		
		wp_enqueue_script('prettyphoto', get_template_directory_uri().'/lib/scripts/prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'));

		wp_enqueue_script('jqtransform', get_template_directory_uri().'/lib/scripts/jquery.jqtransform.js', array('jquery'));
				
		wp_enqueue_script('custom-js', get_template_directory_uri().'/lib/scripts/custom.js', array('jquery'));
						
	}
}
add_action('wp_print_scripts', 'gp_enqueue_scripts');


/////////////////////////////////////// WP Header Hooks ///////////////////////////////////////


function gp_wp_header() {
	
	global $post, $dirname;
	require(gp_inc . 'options.php');
		
    if(get_option($dirname.'_favicon_ico')) echo '<link rel="shortcut icon" href="'.get_option($dirname.'_favicon_ico').'" /><link rel="icon" href="'.get_option($dirname.'_favicon_ico').'" type="image/vnd.microsoft.icon" />';
    
    if(get_option($dirname.'_favicon_png')) echo '<link rel="icon" type="image/png" href="'.get_option($dirname.'_favicon_png').'" />';
    
    if(get_option($dirname.'_apple_icon')) echo '<link rel="apple-touch-icon" href="'.get_option($dirname.'_apple_icon').'" />';
   
   	if(get_option($dirname.'_custom_css')) echo '<style>'.stripslashes(get_option($dirname.'_custom_css')).'</style>';

	echo stripslashes(get_option($dirname.'_scripts'));

	echo '<style>';
	
	// Primary
	
	if(get_option($dirname.'_body_text_color') OR get_option($dirname.'_body_font') OR get_option($dirname.'_body_size')) {
		echo 'body, input, textarea, select {
		color: '.get_option($dirname.'_body_text_color').';	
		font-family: "'.get_option($dirname.'_body_font').'";
		font-size: '.get_option($dirname.'_body_size').'px;
		}';
	}
		
	if(get_option($dirname.'_body_link_color')) {
		echo 'a {color: '.get_option($dirname.'_body_link_color').';}';
	}
	
	if(get_option($dirname.'_body_link_hover_color')) {
		echo 'a:hover {color: '.get_option($dirname.'_body_link_hover_color').';}';
	}
	
	// Heading
	
	if(get_option($dirname.'_heading_text_color') OR get_option($dirname.'_heading_font')) {
		echo 'h1, h2, h3, h4, h5, h6, .widget .widget-title, {color: '.get_option($dirname.'_heading_text_color').'; font-family: "'.get_option($dirname.'_heading_font').'";}';
	}	

	if(get_option($dirname.'_heading1_size')) {
		echo 'h1 {font-size: '.get_option($dirname.'_heading1_size').'px;}';
	}	
	
	if(get_option($dirname.'_heading2_size')) {
		echo 'h2 {font-size: '.get_option($dirname.'_heading2_size').'px;}';
	}
		
	if(get_option($dirname.'_heading3_size')) {
		echo 'h3 {font-size: '.get_option($dirname.'_heading3_size').'px;}';
	}
		
	if(get_option($dirname.'_heading_link_color')) {				
		echo 'h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: '.get_option($dirname.'_heading_link_color').';}';
	}
	
	if(get_option($dirname.'_heading_link_hover_color')) {
		echo 'h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, #sidebar .menu li a:hover {color: '.get_option($dirname.'_heading_link_hover_color').';}';
	}	

	// Header
	
	if(get_option($dirname.'_header_right_bg_color')) {
		echo '#header {background: '.get_option($dirname.'_header_right_bg_color').';
		background: -moz-linear-gradient(left, '.get_option($dirname.'_header_left_bg_color').' 0%, '.get_option($dirname.'_header_left_bg_color').' 50%, '.get_option($dirname.'_header_right_bg_color').' 50.1%, '.get_option($dirname.'_header_right_bg_color').' 100%);
		background: -webkit-gradient(linear, left top, right top, color-stop(0%,'.get_option($dirname.'_header_left_bg_color').'), color-stop(50%,'.get_option($dirname.'_header_left_bg_color').'), color-stop(50.1%,'.get_option($dirname.'_header_right_bg_color').'), color-stop(100%,'.get_option($dirname.'_header_right_bg_color').'));
		background: -webkit-linear-gradient(left, '.get_option($dirname.'_header_left_bg_color').' 0%,'.get_option($dirname.'_header_left_bg_color').' 50%,'.get_option($dirname.'_header_right_bg_color').' 50.1%,'.get_option($dirname.'_header_right_bg_color').' 100%);
		background: -o-linear-gradient(left, '.get_option($dirname.'_header_left_bg_color').' 0%,'.get_option($dirname.'_header_left_bg_color').' 50%,'.get_option($dirname.'_header_right_bg_color').' 50.1%,'.get_option($dirname.'_header_right_bg_color').' 100%);
		background: -ms-linear-gradient(left, '.get_option($dirname.'_header_left_bg_color').' 0%,'.get_option($dirname.'_header_left_bg_color').' 50%,'.get_option($dirname.'_header_right_bg_color').' 50.1%,'.get_option($dirname.'_header_right_bg_color').' 100%);
		background: linear-gradient(to right, '.get_option($dirname.'_header_left_bg_color').' 0%,'.get_option($dirname.'_header_left_bg_color').' 50%,'.get_option($dirname.'_header_right_bg_color').' 50.1%,'.get_option($dirname.'_header_right_bg_color').' 100%);
		-pie-background: linear-gradient(left, '.get_option($dirname.'_header_left_bg_color').' 0%,'.get_option($dirname.'_header_left_bg_color').' 50%,'.get_option($dirname.'_header_right_bg_color').' 50.1%,'.get_option($dirname.'_header_right_bg_color').' 100%);}
		#header-right, .nav .sub-menu, .dropdowncart-contents {background: '.get_option($dirname.'_header_right_bg_color').' !important;}';
	}	

	if(get_option($dirname.'_header_text_color')) {
		echo '.cart-link, .dropdowncart, .dropdowncart-contents .cart_list li a {
		color: '.get_option($dirname.'_header_text_color').' !important;
		}';
	}
		
	if(get_option($dirname.'_header_link_color')) {
		echo '#header-nav .menu a {color: '.get_option($dirname.'_header_link_color').';}';
	}
	
	if(get_option($dirname.'_header_link_hover_color')) {
		echo '#header-nav .menu a:hover, #header .nav li span, .dropdowncart .amount, .dropdowncart:hover .amount {color: '.get_option($dirname.'_header_link_hover_color').';}
		#header .nav .sub-menu li::before {border-color: transparent '.get_option($dirname.'_header_link_hover_color').';}';
	}
	
	// Outer Body
	
	if(get_option($dirname.'_outer_body_text_color')) {
		echo '#body-nav.nav .nav-text, #footer {
		color: '.get_option($dirname.'_outer_body_text_color').';
		}';
	}
		
	if(get_option($dirname.'_outer_body_link_color')) {
		echo '#body-nav.nav li a, #footer a:hover, #footer li a, #footer .tagcloud a {color: '.get_option($dirname.'_outer_body_link_color').';}
		#body-nav.nav li a, #header .nav .sub-menu li::before {border-color: transparent '.get_option($dirname.'_outer_body_link_hover_color').';}';
	}

	if(get_option($dirname.'_outer_body_link_hover_color')) {
		echo '#body-nav.nav li a:hover, #body-nav.nav li span, .product .price .amount, .product .price ins .amount, #footer .widget-title, #footer a, #footer li a:hover, #footer .tagcloud a:hover, .caption a {color: '.get_option($dirname.'_outer_body_link_hover_color').' !important;}
		#body-nav.nav li a, #body-nav.nav .sub-menu li::before {border-color: transparent '.get_option($dirname.'_outer_body_link_hover_color').';}';
	}	
		
	// Content
		
	if(get_option($dirname.'_content_bg_color_1')) {
		echo '#content-wrapper, #content {background: '.get_option($dirname.'_content_bg_color_1').';}';
	}	


	if(get_option($dirname.'_content_bg_color_2')) {
		echo '.widget, .post-thumbnail, input, textarea, input[type="password"] {background: '.get_option($dirname.'_content_bg_color_2').';}';
	}	
	
	if(get_option($dirname.'_content_border_color')) {
		echo '#content-wrapper, .nav .sub-menu, .sc-divider, .gp-table, .gp-table td, .text-box, ul.products .product img:hover, div.product .woocommerce_tabs ul.tabs, #content div.product .woocommerce_tabs ul.tabs, .dropdowncart-contents {border-color:'.get_option($dirname.'_content_border_color').' !important;}
		.post-thumbnail:hover {background: '.get_option($dirname.'_content_border_color').';}';
	}	
	
	// Buttons
	
	if(get_option($dirname.'_button_text_color')) {
		echo 'input[type="button"], input[type="submit"], input[type="reset"], button, .button {color: '.get_option($dirname.'_button_text_color').';}';
	}	

	if(get_option($dirname.'_button_text_hover_color')) {
		echo 'input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, button:hover, .button:hover {color: '.get_option($dirname.'_button_text_hover_color').';}';
	}	
				
	if(get_option($dirname.'_button_bg_color')) {		
		echo 'input[type="button"], input[type="submit"], input[type="reset"], button, .button, #searchsubmit:hover, #footer input[type="submit"]:hover, #footer input[type="button"]:hover, #footer input[type="submit"]:hover, #footer input[type="reset"]:hover, #footer button:hover, #footer .button:hover {background-color: '.get_option($dirname.'_button_bg_color').';}';
	}	

	if(get_option($dirname.'_button_bg_hover_color')) {
		echo 'input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, button:hover, .button:hover, #searchsubmit, #footer input[type="submit"], #footer input[type="button"], #footer input[type="submit"], #footer input[type="reset"], #footer button, #footer .button {background-color: '.get_option($dirname.'_button_bg_hover_color').';}';
	}
		
	echo '</style>';
	
	echo '
	<!--[if lte IE 9]>
	<style>
	#header
	{
	behavior: url("'.get_template_directory_uri().'/lib/scripts/pie/PIE.php");
	}
	</style>
	<![endif]-->';
		
	
}
add_action('wp_head', 'gp_wp_header');


/////////////////////////////////////// Navigation Menus ///////////////////////////////////////


add_action('init', 'register_my_menus');
function register_my_menus() {
	register_nav_menus(array(
		'header-nav' => __('Header Navigation', 'gp_lang'),
		'body-nav' => __('Body Navigation', 'gp_lang')
	));
}


/*************************************** Mobile Navigation Walker ***************************************/	

class gp_mobile_menu extends Walker_Nav_Menu {

	var $to_depth = -1;

    function start_lvl(&$output, $depth){
		$output .= '</option>';
    }

    function end_lvl(&$output, $depth){
		$indent = str_repeat("\t", $depth); // don't output children closing tag
    }

    function start_el(&$output, $item, $depth, $args){
		$indent = ($depth) ? str_repeat("&nbsp;", $depth * 4) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'mobile-menu-item-' . $item->ID;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';
		$id = apply_filters('nav_menu_item_id', 'mobile-menu-item-'. $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
		$value = ' value="'. $item->url .'"';
		$output .= '<option'.$id.$value.$class_names.'>';
		$item_output = $args->before;
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$output .= $indent.$item_output;
    }

    function end_el(&$output, $item, $depth){
		if(substr($output, -9) != '</option>')
      		$output .= "</option>"; // replace closing </li> with the option tag
    }

}


/////////////////////////////////////// Theme Support ///////////////////////////////////////


// Featured images
add_theme_support('post-thumbnails');
set_post_thumbnail_size(150, 150, true);

// Background customizer
add_theme_support('custom-background');

// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();

// Set the content width based on the theme's design and stylesheet.
if(!isset($content_width)) $content_width = 670;

// Add default posts and comments RSS feed links to <head>.
add_theme_support('automatic-feed-links');


/////////////////////////////////////// Excerpts ///////////////////////////////////////


// Character Length
function new_excerpt_length($length) {
	return 10000;
}
add_filter('excerpt_length', 'new_excerpt_length');

function excerpt($count){
	$excerpt = get_the_excerpt();
	$excerpt = strip_tags($excerpt);
	if(strlen($excerpt) > $count) {
		$excerpt = substr($excerpt, 0, $count);
		$excerpt = $excerpt."...";
	}
	return $excerpt;
}

// Replace Excerpt Ellipsis
function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');
remove_filter('the_excerpt', 'wpautop');

// Content More Text
function new_more_link($more_link, $more_link_text) {
	return str_replace('more-link', 'more-link read-more', $more_link);
}
add_filter('the_content_more_link', 'new_more_link', 10, 2);


/////////////////////////////////////// Add Excerpt Support To Pages ///////////////////////////////////////


add_action('init', 'my_add_excerpts_to_pages');
function my_add_excerpts_to_pages() {
     add_post_type_support('page', 'excerpt');
}


/////////////////////////////////////// Title Length ///////////////////////////////////////


function the_title_limit($count) {
	$title = the_title('','',FALSE);
	$title = strip_tags($title);
	if(strlen($title) > $count) {
		$title = substr($title, 0, $count);
		$title = $title."...";
	}
	echo $title;
}


/////////////////////////////////////// Breadcrumbs ///////////////////////////////////////


function the_breadcrumb() {
global $post;
	if (!is_home()) {
		echo '<a href="'.home_url().'">'.__('Home', 'gp_lang').'</a>';
		if (is_category()) {
			echo " &rsaquo; ";
			echo single_cat_title();
		}
		elseif(is_singular('post') && !is_attachment()) {
			$cat = get_the_category(); $cat = $cat[0];
			echo " &rsaquo; ";
			if(get_the_category()) { 
				$cat = get_the_category(); $cat = $cat[0];
				echo get_category_parents($cat, TRUE, ' &rsaquo; ');
			}
			echo get_the_title();
		}		
		elseif (is_search()) {
			echo " &rsaquo; ";
			_e('Search', 'gp_lang');
		}		
		elseif (is_page() && $post->post_parent) {
			echo ' &rsaquo; <a href="'.get_permalink($post->post_parent).'">';
			echo get_the_title($post->post_parent);
			echo "</a> &rsaquo; ";
			echo get_the_title();
		}
		elseif (is_page() OR is_attachment()) {
			echo " &rsaquo; "; 
			echo get_the_title();
		}
		
		elseif (is_author()) {
			echo wp_title(' &rsaquo; ', true, 'left');
			echo "'s ".__('Posts', 'gp_lang');
		}
		elseif (is_404()) {
			echo " &rsaquo; "; 
			_e('Page Not Found', 'gp_lang');;
		}
		elseif (is_archive()) {
			echo wp_title(' &rsaquo; ', true, 'left');
		}
	}
}


/////////////////////////////////////// Page Navigation ///////////////////////////////////////


function gp_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     
	 if (get_query_var('paged')) {
		 $paged = get_query_var('paged');
	 } elseif (get_query_var('page')) {
		 $paged = get_query_var('page');
	 } else {
		 $paged = 1;
	 }

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
	
     if(1 != $pages)
     {
        echo "<div class='clear'></div><div class='wp-pagenavi cat-navi'>";
		echo '<span class="pages">'.__('Page', 'gp_lang').' '.$paged.' '.__('of', 'gp_lang').' '.$pages.'</span>';
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&(!($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


/////////////////////////////////////// Shortcode Support For Text Widget ///////////////////////////////////////


add_filter('widget_text', 'do_shortcode');


/////////////////////////////////////// Shortcode Empty Paragraph Fix ///////////////////////////////////////


// Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content)
{   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);

	return $content;
}


/////////////////////////////////////// Custom Media Gallery Field ///////////////////////////////////////


function gp_attachment_fields_to_edit($form_fields, $post) {
	$form_fields["gp_video_url"] = array(
		"label" => __('Audio/Video URL', 'gp_lang'),
		"input" => "text",
		"value" => get_post_meta($post->ID, "_gp_video_url", true),
		"helps" => __('The URL of your video or audio file (YouTube/Vimeo/FLV/MP4/M4V/MP3).', 'gp_lang'),
	);
   return $form_fields;
}
add_filter("attachment_fields_to_edit", "gp_attachment_fields_to_edit", null, 2);

function gp_attachment_fields_to_save($post, $attachment) {
	if(isset($attachment['gp_video_url'])){
		update_post_meta($post['ID'], '_gp_video_url', $attachment['gp_video_url']);
	}	
	return $post;
}
add_filter("attachment_fields_to_save", "gp_attachment_fields_to_save", null , 2);


/////////////////////////////////////// Redirect to Theme Options after Activation ///////////////////////////////////////


if(is_admin() && isset($_GET['activated']) && $pagenow == "themes.php") {
	add_action('admin_head','ct_option_setup');
	header('Location: '.admin_url().'themes.php?page=theme-options.php');
}

?>