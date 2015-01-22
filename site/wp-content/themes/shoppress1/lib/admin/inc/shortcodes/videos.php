<?php

//////////////////////////////////////// Videos ////////////////////////////////////////

function gp_video($atts, $content = null) {
    extract(shortcode_atts(array(
		'name' => '',
        'url' => '',
		'html5_1' => '',
        'html5_2' => '',
        'priority' => 'flash',
        'image' => '',
        'width' => '560',
        'height' => '315',
        'controlbar' => 'bottom',
        'autostart' => 'false',
        'icons' => 'true',
        'stretching' => 'fill',
        'align' => 'alignnone',
        'plugins' => '',
        'skin' => get_template_directory_uri().'/lib/scripts/mediaplayer/fs39/fs39.xml',
        'player' => get_template_directory_uri().'/lib/scripts/mediaplayer/player.swf'        
    ), $atts));
	
	global $gp_settings;
	
	// Remove spaces from video name
	$name = preg_replace('/[^a-zA-Z0-9]/', '', $name);

	// Video Type	
	$vimeo = strpos($url,"vimeo.com");
	$yt1 = strpos($url,"youtube.com");
	$yt2 = strpos($url,"youtu.be");
	
	ob_start(); ?>

	<div class="sc-video <?php echo $align; ?>">
	
		<div class="sc-video-inner">
						
			<?php if($vimeo) { ?>
										
				<?php if($autostart == "false") {
					$autostart = "0";
				} elseif($autostart == "true") {
					$autostart = "1";
				}
		
				// Vimeo Clip ID
				if(preg_match('/www.vimeo/',$url)) {							
					$vimeoid = trim($url,'http://www.vimeo.com/');
				} else {							
					$vimeoid = trim($url,'http://vimeo.com/');
				}				
		
				?>
				
				<iframe src="http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=<?php echo $autostart; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				
			<?php } else {
			
			// Allow relative URLs
			if(!preg_match("/http:/", $url) && !preg_match("/https:/", $url)) { $url = site_url().'/'.$url; }
			if(!preg_match("/http:/", $html5_1) && !preg_match("/https:/", $html5_1)) { $html5_1 = site_url().'/'.$html5_1; }
			if(!preg_match("/http:/", $html5_2) && !preg_match("/https:/", $html5_2)) { $html5_2 = site_url().'/'.$html5_2; }
			
			 ?>
			
				<?php if(($gp_settings['iPhone'] OR $gp_settings['iPad']) && (!$yt1 && !$yt2)) { ?>
				
					<video id="video-<?php echo $name; ?>" controls="controls" width="<?php echo $width; ?>" height="<?php echo $height; ?>" poster="<?php $image = vt_resize('', $image, $width, $height, true); echo $image['url']; ?>">
						<source src="<?php echo $url; ?>" type="video/mp4" />
						<source src="<?php echo $url; ?>" type="video/webm" />
						<source src="<?php echo $html5_1; ?>" type="video/mp4" />
						<source src="<?php echo $html5_1; ?>" type="video/webm" />
						<source src="<?php echo $html5_2; ?>" type="video/mp4" />
					</video>
				
				<?php } else { ?>	
							
					<div id="video-<?php echo $name; ?>"></div>
					
				<?php } ?>
				
				<script>
					jwplayer("video-<?php echo $name; ?>").setup({
						<?php if($image) { $image = vt_resize('', $image, $width, $height, true); ?>image: "<?php echo $image['url']; ?>",<?php } ?>
						icons: "<?php echo $icons; ?>",
						autostart: "<?php echo $autostart; ?>",
						stretching: "<?php echo $stretching; ?>",
						controlbar: "<?php echo $controlbar; ?>",
						skin: "<?php echo $skin; ?>",
						width: <?php echo $width; ?>,
						height: <?php echo $height; ?>,
						screencolor: "000000",
						modes:
							[
							<?php if($gp_settings['MSIE'] OR $priority == "flash") { ?>
								{type: "flash", src: "<?php echo $player; ?>", config: {file: "<?php echo $url; ?>"}},					
								{type: "html5", config: {file: "<?php echo $url; ?>"<?php if(($gp_settings['iPhone'] OR $gp_settings['iPad']) && ($yt1 OR $yt2)) {} else { ?>, file: "<?php echo $html5_1; ?>", file: "<?php echo $html5_2; ?>"<?php } ?>}}
							<?php } else { ?>
								{type: "html5", config: {file: "<?php echo $url; ?>"<?php if(($gp_settings['iPhone'] OR $gp_settings['iPad']) && ($yt1 OR $yt2)) {} else { ?>, file: "<?php echo $html5_1; ?>", file: "<?php echo $html5_2; ?>"<?php } ?>}},	
								{type: "flash", src: "<?php echo $player; ?>", config: {file: "<?php echo $url; ?>"}}
							<?php } ?>
							],
						plugins: {<?php echo $plugins; ?>}
					});
				</script>
			
			<?php } ?>
		
		</div>

	</div>

<?php 

	$output_string = ob_get_contents();
	ob_end_clean(); 
	
	return $output_string;

}

add_shortcode('video', 'gp_video');

?>