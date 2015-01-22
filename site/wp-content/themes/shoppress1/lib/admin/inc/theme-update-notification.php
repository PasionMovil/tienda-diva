<?php
/**********************************************************************
*                                                            *
*   Provides a notification to the user everytime            *
*   your WordPress theme is updated                          *
*                                                            *
*   Author: Joao Araujo                                      *
*   Profile: http://themeforest.net/user/unisphere           *
*   Follow me: http://twitter.com/unispheredesign            *
*                                                            *
**********************************************************************/
 

// Constants for the theme name, folder and remote XML url
define( 'NOTIFIER_THEME_NAME', $themename ); // The theme name
define( 'NOTIFIER_THEME_FOLDER_NAME', $dirname ); // The theme folder name
define( 'NOTIFIER_XML_FILE', 'http://www.ghostpool.com/help/'.$dirname.'/lib/updater.xml' ); // The remote notifier XML file containing the latest version of the theme and changelog
define( 'NOTIFIER_CACHE_INTERVAL', 21600 ); // The time interval for the remote XML cache in the database (21600 seconds = 6 hours)



// Adds an update notification to the WordPress Dashboard menu
function gp_update_notifier_menu() {  
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
	    $xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = wp_get_theme(); $theme_data->Version; // Read theme current version from the style.css
		
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			add_dashboard_page( NOTIFIER_THEME_NAME . ' Theme Updates', NOTIFIER_THEME_NAME . ' <span class="update-plugins count-1"><span class="update-count">1</span></span>', 'administrator', 'theme-update-notifier', 'gp_update_notifier');
		}
	}	
}
add_action('admin_menu', 'gp_update_notifier_menu');  



// Adds an update notification to the WordPress 3.1+ Admin Bar
function gp_update_notifier_bar_menu() {
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
		global $wp_admin_bar, $wpdb;
	
		if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;
		
		$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = wp_get_theme(); $theme_data->Version; // Read theme current version from the style.css
	
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			$wp_admin_bar->add_menu( array( 'id' => 'gp_update_notifier', 'title' => '<span>' . NOTIFIER_THEME_NAME . ' <span id="ab-updates">Theme Update</span></span>', 'href' => get_admin_url() . 'index.php?page=theme-update-notifier' ) );
		}
	}
}
add_action( 'admin_bar_menu', 'gp_update_notifier_bar_menu', 1000 );



// The notifier page
function gp_update_notifier() { 
	$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
	$theme_data = wp_get_theme(); $theme_data->Version; // Read theme current version from the style.css ?>
	
	<style>
		.update-nag { display: none; }
		#instructions {max-width: 670px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo NOTIFIER_THEME_NAME ?> <?php _e('Theme Updates' ,'gp_lang'); ?></h2>
	    <div id="message" class="updated below-h2"><p><strong><?php _e('There is a new version of the', 'gp_lang'); ?> <?php echo NOTIFIER_THEME_NAME; ?> <?php _e('theme available.', 'gp_lang'); ?></strong> <?php _e('You have version', 'gp_lang'); ?> <?php echo $theme_data['Version']; ?> <?php _e('installed. Update to version', 'gp_lang'); ?> <?php echo $xml->latest; ?>.</p></div>

		<img style="margin: 0 0 20px 0; border: 1px solid #ddd;" src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>" width="300" height="225" />
		
		<div id="message" class="updated below-h2">
		    
			<h3>Update Instructions</h3>
            
            <p><?php _e('To update to the latest version of', 'gp_lang'); ?> <?php echo NOTIFIER_THEME_NAME ?> <?php _e('see the', 'gp_lang'); ?> <a href="http://ghostpool.com/help/<?php echo NOTIFIER_THEME_FOLDER_NAME; ?>/help.html#updating" target="_blank"><?php _e('Updating The Theme', 'gp_lang'); ?></a> <?php _e('section of the help file.', 'gp_lang'); ?></p>
			
			<p><strong><?php _e('Please read the', 'gp_lang'); ?> <a href="http://ghostpool.com/help/<?php echo NOTIFIER_THEME_FOLDER_NAME; ?>/changelog.html" target="_blank"><?php _e('changelog', 'gp_lang'); ?></a> <?php _e('before upgrading.', 'gp_lang'); ?></strong></p>
			
			<p><?php echo $xml->info; ?></p>		    
		    
		</div>

	</div>
    
<?php } 



// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function get_latest_theme_version($interval) {
	$notifier_file_url = NOTIFIER_XML_FILE;	
	$db_cache_field = 'notifier-cache';
	$db_cache_field_last_updated = 'notifier-cache-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results	
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		} 
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	// Let's see if the $xml data was returned as we expected it to.
	// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
	if( strpos((string)$notifier_data, '<notifier>') === false ) {
		$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><changelog></changelog></notifier>';
	}
	
	// Load the remote XML data into a variable and return it
	if ( function_exists('simplexml_load_string') ) {	
		return simplexml_load_string($notifier_data); 	
	}
}

?>