<?php 

require(gp_inc . 'options.php');
global $gp_settings, $dirname;

?>

<script>
/* File Directory */
var rootFolder = '<?php echo get_template_directory_uri(); ?>';
var viewproduct = "<?php _e('View Product', 'gp_lang'); ?>";

<?php if(get_option($dirname.'_add_to_cart_button') == "Hide") { ?>jQuery(document).ready(function(){ jQuery('ul.products li.product .add_to_cart_button').remove(); });<?php } ?>
<?php if(get_option($dirname.'_view_product_button') == "Hide") { ?>jQuery(document).ready(function(){ jQuery('ul.products li.product .view_product_button').remove(); });<?php } ?>
</script>

<?php 

// Detect Browsers
$gp_settings['MSIE'] = (stripos($_SERVER['HTTP_USER_AGENT'],'MSIE') !== false);
$gp_settings['iPhone'] = (stripos($_SERVER['HTTP_USER_AGENT'],'iPhone') !== false);
$gp_settings['iPad'] = (stripos($_SERVER['HTTP_USER_AGENT'],'iPad') !== false);

// Browser Class
if($gp_settings['iPhone'] OR $gp_settings['iPad']) {
	$gp_settings['browser'] = 'ios-class';
} else {
	$gp_settings['browser'] = '';
}

// Preload Effect
if(get_option($dirname.'_preload') == '0') {
	$gp_settings['preload'] = 'preload';
} else {
	$gp_settings['preload'] = '';
}

// Placeholder Image URL
$gp_settings['placeholder'] = get_template_directory_uri().'/lib/images/placeholder.png';

// Skins
if(isset($_GET['skin']) && $_GET['skin'] != 'default') {
	$gp_settings['skin'] = 'skin-'.$_GET['skin'];
} elseif(isset($_COOKIE['SkinCookie']) && $_COOKIE['SkinCookie'] != 'default') {
	$gp_settings['skin'] = 'skin-'.$_COOKIE['SkinCookie']; 
} elseif(get_post_meta($post->ID, $dirname.'_skin', true) && get_post_meta($post->ID, $dirname.'_skin', true) != 'Default') {
	$gp_settings['skin'] = 'skin-'.get_post_meta($post->ID, $dirname.'_skin', true);
} else {
	$gp_settings['skin'] = 'skin-'.get_option($dirname.'_skin');
}


/////////////////////////////////////// Homepage ///////////////////////////////////////
	
	
if(is_home()) {

	$gp_settings['layout'] = "fullwidth";
	
	
/////////////////////////////////////// WooCommerce Product Categories ///////////////////////////////////////
	
	
} elseif(function_exists('woocommerce_content') && is_product_category()) {

	$gp_settings['sidebar'] = get_option($dirname.'_product_cat_sidebar');
	$gp_settings['layout'] = get_option($dirname.'_product_cat_layout');
	$gp_settings['title'] = get_option($dirname.'_product_cat_title');
	$gp_settings['search'] = get_option($dirname.'_product_cat_search');	
	$gp_settings['bottom_widgets'] = get_option($dirname.'_product_cat_bottom_content_widgets');
		
	if(get_option($dirname.'_product_cat_breadcrumbs') == 'Hide') {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	}	


/////////////////////////////////////// WooCommerce Product Pages ///////////////////////////////////////
	
	
} elseif(function_exists('woocommerce_breadcrumb') && is_product()) {

	// Sidebar
	if(get_post_meta($post->ID, $dirname.'_sidebar', true) && get_post_meta($post->ID, $dirname.'_sidebar', true) != 'Default') {
		$gp_settings['sidebar'] = get_post_meta($post->ID, $dirname.'_sidebar', true);
	} else {
		$gp_settings['sidebar'] = get_option($dirname.'_product_sidebar');
	}
		
	// Layout
	if(get_post_meta($post->ID, $dirname.'_layout', true) && get_post_meta($post->ID, $dirname.'_layout', true) != 'Default') {
		$gp_settings['layout'] = get_post_meta($post->ID, $dirname.'_layout', true);
	} else {
		$gp_settings['layout'] = get_option($dirname.'_product_layout');
	}
 
	// Breadcrumbs
	if(get_post_meta($post->ID, $dirname.'_breadcrumbs', true) && get_post_meta($post->ID, $dirname.'_breadcrumbs', true) != 'Default') {
		$gp_settings['breadcrumbs'] = get_post_meta($post->ID, $dirname.'_breadcrumbs', true);
	} else {
		$gp_settings['breadcrumbs'] = get_option($dirname.'_product_breadcrumbs');
	}
	if($gp_settings['breadcrumbs'] == 'Hide') {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	}	
	
	// Search Bar
	if(get_post_meta($post->ID, $dirname.'_search', true) && get_post_meta($post->ID, $dirname.'_search', true) != 'Default') {
		$gp_settings['search'] = get_post_meta($post->ID, $dirname.'_search', true);
	} else {
		$gp_settings['search'] = get_option($dirname.'_product_search');
	} 

	// Bottom Widgets
	if(get_post_meta($post->ID, $dirname.'_bottom_widgets', true) && get_post_meta($post->ID, $dirname.'_bottom_widgets', true) != 'Default') {
		$gp_settings['bottom_widgets'] = get_post_meta($post->ID, $dirname.'_bottom_widgets', true);
	} else {
		$gp_settings['bottom_widgets'] = get_option($dirname.'_product_bottom_content_widgets');
	}
	
	// Image Effect
	if(get_post_meta($post->ID, $dirname.'_image_effect', true) && get_post_meta($post->ID, $dirname.'_image_effect', true) != 'Default') {
		$gp_settings['image_effect'] = get_post_meta($post->ID, $dirname.'_image_effect', true);
	} else {
		$gp_settings['image_effect'] = get_option($dirname.'_image_effect');
	}
		
		
/////////////////////////////////////// Categories, Archives etc. ///////////////////////////////////////


} elseif(is_archive() OR is_search()) {

	$gp_settings['sidebar'] = get_option($dirname.'_cat_sidebar');
	$gp_settings['thumbnail_width'] = get_option($dirname.'_cat_thumbnail_width');
	$gp_settings['thumbnail_height'] = get_option($dirname.'_cat_thumbnail_height');
	$gp_settings['image_wrap'] = get_option($dirname.'_cat_image_wrap');
	$gp_settings['layout'] = get_option($dirname.'_cat_layout');
	$gp_settings['title'] = get_option($dirname.'_cat_title');		
	$gp_settings['breadcrumbs'] = get_option($dirname.'_cat_breadcrumbs');
	$gp_settings['search'] = get_option($dirname.'_cat_search');	
	$gp_settings['bottom_widgets'] = get_option($dirname.'_cat_bottom_content_widgets');
	$gp_settings['content_display'] = get_option($dirname.'_cat_content_display');
	$gp_settings['excerpt_length'] = get_option($dirname.'_cat_excerpt_length');
	$gp_settings['read_more'] = get_option($dirname.'_cat_read_more');
	$gp_settings['meta_date'] = get_option($dirname.'_cat_date');
	$gp_settings['meta_author'] = get_option($dirname.'_cat_author');
	$gp_settings['meta_cats'] = get_option($dirname.'_cat_cats');
	$gp_settings['meta_tags'] = get_option($dirname.'_cat_tags');
	$gp_settings['meta_comments'] = get_option($dirname.'_cat_comments');
	
						
/////////////////////////////////////// Posts ///////////////////////////////////////


} elseif(is_single()) {

	// Show Image
	if(get_post_meta($post->ID, $dirname.'_show_image', true) && get_post_meta($post->ID, $dirname.'_show_image', true) != 'Default') {
		$gp_settings['show_image'] = get_post_meta($post->ID, $dirname.'_show_image', true);
	} else {
		$gp_settings['show_image'] = get_option($dirname.'_show_post_image');
	}
	
	// Image Dimensions
	if(get_post_meta($post->ID, $dirname.'_image_width', true) && get_post_meta($post->ID, $dirname.'_image_width', true) != "") {
		$gp_settings['image_width'] = get_post_meta($post->ID, $dirname.'_image_width', true);
	} else {
		$gp_settings['image_width'] = get_option($dirname.'_post_image_width');
	}
	if(get_post_meta($post->ID, $dirname.'_image_height', true) && get_post_meta($post->ID, $dirname.'_image_height', true) != "") {
		$gp_settings['image_height'] = get_post_meta($post->ID, $dirname.'_image_height', true);
	} else {
		$gp_settings['image_height'] = get_option($dirname.'_post_image_height');
	}
	
	// Image Wrap
	if(get_post_meta($post->ID, $dirname.'_image_wrap', true) && get_post_meta($post->ID, $dirname.'_image_wrap', true) != 'Default') {
		$gp_settings['image_wrap'] = get_post_meta($post->ID, $dirname.'_image_wrap', true);
	} else {
		$gp_settings['image_wrap'] = get_option($dirname.'_post_image_wrap');
	}

	// Sidebar
	if(get_post_meta($post->ID, $dirname.'_sidebar', true) && get_post_meta($post->ID, $dirname.'_sidebar', true) != 'Default') {
		$gp_settings['sidebar'] = get_post_meta($post->ID, $dirname.'_sidebar', true);
	} else {
		$gp_settings['sidebar'] = get_option($dirname.'_post_sidebar');
	}
		
	// Layout
	if(is_attachment()) {
		$gp_settings['layout'] = 'fullwidth';
	} else {
		if(get_post_meta($post->ID, $dirname.'_layout', true) && get_post_meta($post->ID, $dirname.'_layout', true) != 'Default') {
			$gp_settings['layout'] = get_post_meta($post->ID, $dirname.'_layout', true);
		} else {
			$gp_settings['layout'] = get_option($dirname.'_post_layout');
		}
	}

	// Title
	if(get_post_meta($post->ID, $dirname.'_title', true) && get_post_meta($post->ID, $dirname.'_title', true) != 'Default') {
		$gp_settings['title'] = get_post_meta($post->ID, $dirname.'_title', true);
	} else {
		$gp_settings['title'] = get_option($dirname.'_post_title');
	} 	
 
	// Breadcrumbs
	if(get_post_meta($post->ID, $dirname.'_breadcrumbs', true) && get_post_meta($post->ID, $dirname.'_breadcrumbs', true) != 'Default') {
		$gp_settings['breadcrumbs'] = get_post_meta($post->ID, $dirname.'_breadcrumbs', true);
	} else {
		$gp_settings['breadcrumbs'] = get_option($dirname.'_post_breadcrumbs');
	}
	
	// Search Bar
	if(get_post_meta($post->ID, $dirname.'_search', true) && get_post_meta($post->ID, $dirname.'_search', true) != 'Default') {
		$gp_settings['search'] = get_post_meta($post->ID, $dirname.'_search', true);
	} else {
		$gp_settings['search'] = get_option($dirname.'_post_search');
	} 

	// Bottom Widgets
	if(get_post_meta($post->ID, $dirname.'_bottom_widgets', true) && get_post_meta($post->ID, $dirname.'_bottom_widgets', true) != 'Default') {
		$gp_settings['bottom_widgets'] = get_post_meta($post->ID, $dirname.'_bottom_widgets', true);
	} else {
		$gp_settings['bottom_widgets'] = get_option($dirname.'_post_bottom_content_widgets');
	}
	
	// Post Meta						
	$gp_settings['meta_date'] = get_option($dirname.'_post_date');
	$gp_settings['meta_author'] = get_option($dirname.'_post_author');
	$gp_settings['meta_cats'] = get_option($dirname.'_post_cats');
	$gp_settings['meta_tags'] = get_option($dirname.'_post_tags');
	$gp_settings['meta_comments'] = get_option($dirname.'_post_comments');
	
	// Author Info Panel
	$gp_settings['author_info'] = get_option($dirname.'_post_author_info');
						
	// Related Items
	$gp_settings['related_items'] = get_option($dirname.'_post_related_items');			
	$gp_settings['related_image_width'] = get_option($dirname.'_post_related_image_width');
	$gp_settings['related_image_height'] = get_option($dirname.'_post_related_image_height');
	

/////////////////////////////////////// Pages, Attachments, 404 etc. ///////////////////////////////////////


} else {

	// Show Image
	if(get_post_meta($post->ID, $dirname.'_show_image', true) && get_post_meta($post->ID, $dirname.'_show_image', true) != 'Default') {
		$gp_settings['show_image'] = get_post_meta($post->ID, $dirname.'_show_image', true);
	} else {
		$gp_settings['show_image'] = get_option($dirname.'_show_page_image');
	}
	
	// Image Dimensions
	if(get_post_meta($post->ID, $dirname.'_image_width', true) && get_post_meta($post->ID, $dirname.'_image_width', true) != "") {
		$gp_settings['image_width'] = get_post_meta($post->ID, $dirname.'_image_width', true);
	} else {
		$gp_settings['image_width'] = get_option($dirname.'_page_image_width');
	}
	if(get_post_meta($post->ID, $dirname.'_image_height', true) && get_post_meta($post->ID, $dirname.'_image_height', true) != "") {
		$gp_settings['image_height'] = get_post_meta($post->ID, $dirname.'_image_height', true);
	} else {
		$gp_settings['image_height'] = get_option($dirname.'_page_image_height');
	}
	
	// Image Wrap
	if(get_post_meta($post->ID, $dirname.'_image_wrap', true) && get_post_meta($post->ID, $dirname.'_image_wrap', true) != 'Default') {
		$gp_settings['image_wrap'] = get_post_meta($post->ID, $dirname.'_image_wrap', true);
	} else {
		$gp_settings['image_wrap'] = get_option($dirname.'_page_image_wrap');
	}

	// Sidebar
	if(get_post_meta($post->ID, $dirname.'_sidebar', true) && get_post_meta($post->ID, $dirname.'_sidebar', true) != 'Default') {
		$gp_settings['sidebar'] = get_post_meta($post->ID, $dirname.'_sidebar', true);
	} else {
		$gp_settings['sidebar'] = get_option($dirname.'_page_sidebar');
	}
		
	// Layout
	if(get_post_meta($post->ID, $dirname.'_layout', true) && get_post_meta($post->ID, $dirname.'_layout', true) != 'Default') {
		$gp_settings['layout'] = get_post_meta($post->ID, $dirname.'_layout', true);
	} else {
		$gp_settings['layout'] = get_option($dirname.'_page_layout');
	}
	
	// Title
	if(get_post_meta($post->ID, $dirname.'_title', true) && get_post_meta($post->ID, $dirname.'_title', true) != 'Default') {
		$gp_settings['title'] = get_post_meta($post->ID, $dirname.'_title', true);
	} else {
		$gp_settings['title'] = get_option($dirname.'_page_title');
	} 	
 
	// Breadcrumbs
	if(get_post_meta($post->ID, $dirname.'_breadcrumbs', true) && get_post_meta($post->ID, $dirname.'_breadcrumbs', true) != 'Default') {
		$gp_settings['breadcrumbs'] = get_post_meta($post->ID, $dirname.'_breadcrumbs', true);
	} else {
		$gp_settings['breadcrumbs'] = get_option($dirname.'_page_breadcrumbs');
	}
	
	// Search Bar
	if(get_post_meta($post->ID, $dirname.'_search', true) && get_post_meta($post->ID, $dirname.'_search', true) != 'Default') {
		$gp_settings['search'] = get_post_meta($post->ID, $dirname.'_search', true);
	} else {
		$gp_settings['search'] = get_option($dirname.'_page_search');
	} 
	
	// Bottom Widgets
	if(get_post_meta($post->ID, $dirname.'_bottom_widgets', true) && get_post_meta($post->ID, $dirname.'_bottom_widgets', true) != 'Default') {
		$gp_settings['bottom_widgets'] = get_post_meta($post->ID, $dirname.'_bottom_widgets', true);
	} else {
		$gp_settings['bottom_widgets'] = get_option($dirname.'_page_bottom_content_widgets');
	}
		
	// Post Meta						
	$gp_settings['meta_date'] = get_option($dirname.'_page_date');
	$gp_settings['meta_author'] = get_option($dirname.'_page_author');
	$gp_settings['meta_cats'] = '1';
	$gp_settings['meta_tags'] = '1';
	$gp_settings['meta_comments'] = get_option($dirname.'_page_comments');
	
	// Author Info Panel
	$gp_settings['author_info'] = get_option($dirname.'_page_author_info');
						
}

?>