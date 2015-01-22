<?php 

//////////////////////////////////////// Slider ////////////////////////////////////////

function gp_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		'name' => 'slider',
        'width' => '661',
        'height' => '450',
        'cats' => '',
        'slides' => '-1',
        'effect' => 'fade',
        'timeout' => '6',
        'orderby' => 'menu_order',
        'order' => 'asc',
        'arrows' => 'false',
        'buttons' => 'true',
        'shadow' => 'false',
		'margins' => '',
        'align' => 'alignleft',
        'preload' => 'false'
    ), $atts));

	global $wp_query, $post, $gp_settings, $dirname;
	require(gp_inc . 'options.php');
	
	// Remove spaces from slider name
	$name = preg_replace('/[^a-zA-Z0-9]/', '', $name);

	// Shadow
	if($shadow == "true") {
		$shadow = " shadow";
	} else {
		$shadow = "";
	}
	
	// Margins
	if($margins != "") {
		if(preg_match('/%/', $margins) OR preg_match('/em/', $margins) OR preg_match('/px/', $margins)) {
			$margins = str_replace(",", " ", $margins);
			$margins = 'margin: '.$margins.'; ';	
		} else {
			$margins = str_replace(",", "px ", $margins);
			$margins = 'margin: '.$margins.'px; ';		
		}
		$margins = str_replace("autopx", "auto", $margins);
	} else {
		$margins = "";
	}
	
	// Preload
	if($preload == "true") {
		$preload = " preload";
	} else {
		$preload = "";
	}
	
	// Slider Query	
	if($cats) {
		$args=array(
		'post_type' => 'slide',
		//'slide_categories' => $cats,
		'posts_per_page' => $slides,
		'orderby' => $orderby,
		'order' => $order,
		'tax_query' => array('relation' => 'OR', array('taxonomy' => 'slide_categories', 'terms' => explode(',', $cats), 'field' => array('id', 'slug')))
		);
	} else {
		$args=array(
		'post_type' => 'slide',
		'posts_per_page' => $slides,
		'orderby' => $orderby,
		'order' => $order
		);	
	}
	
	$featured_query = new wp_query($args);
	
	ob_start(); ?>
	
	<?php if ($featured_query->have_posts()) : $slide_counter = ""; ?>
	
	<!--Begin Slider Wrapper-->
	<div id="<?php echo $name; ?>" class="flexslider <?php echo $align; ?><?php echo $shadow; ?><?php echo $preload; ?>" style="width: <?php echo $width; ?>px; <?php echo $margins; ?>">
		
		<!--Begin Slider-->
		<ul class="slides">

			<?php while ($featured_query->have_posts()) : $featured_query->the_post(); $slide_counter++; ?>

				<li class="slide<?php if($slide_counter != "1") {} elseif(get_post_meta($post->ID, $dirname.'_slide_autostart_video', true)) { ?> video-autostart<?php } ?>" id="<?php echo $name; ?>-slide-<?php the_ID(); ?>">
					
					<!--Begin Caption-->
					<?php if(!get_post_meta($post->ID, $dirname.'_slide_title', true) OR get_post_meta($post->ID, $dirname.'_slide_caption_link_text', true)) { 

					$slide_caption_position = get_post_meta($post->ID, $dirname.'_slide_caption_position', true);

					if($slide_caption_position == "Top Left Overlay") {
						$caption_class = " caption-topleft";
					} elseif($slide_caption_position == "Top Right Overlay") {
						$caption_class = " caption-topright";
					} elseif($slide_caption_position == "Bottom Left Overlay") {
						$caption_class = " caption-bottomleft ";
					} elseif($slide_caption_position == "Bottom Right Overlay") {
						$caption_class = " caption-bottomright";
					}
					
					?>
						
						<div class="caption<?php echo $caption_class; ?>">
							<?php if(!get_post_meta($post->ID, $dirname.'_slide_title', true)) { ?><div class="caption-title"><?php the_title(); ?></div><?php } ?>
							<?php if(get_post_meta($post->ID, $dirname.'_slide_caption_link', true)) { ?><a href="<?php echo get_post_meta($post->ID, $dirname.'_slide_caption_link', true); ?>" class="caption-link"><?php echo get_post_meta($post->ID, $dirname.'_slide_caption_link_text', true); ?></a><?php } ?>
							<?php do_shortcode(the_content()); ?>
						</div>
					
					<?php } ?>
					<!--End Caption-->
					
					<!--Begin Video-->
					<?php if(get_post_meta($post->ID, $dirname.'_slide_video', true) OR get_post_meta($post->ID, $dirname.'_webm_mp4_slide_video', true) OR get_post_meta($post->ID, $dirname.'_ogg_slide_video', true)) { ?>

						<?php
												
						// Video Type	
						$vimeo = strpos(get_post_meta($post->ID, $dirname.'_slide_video', true),"vimeo.com");
						$yt1 = strpos(get_post_meta($post->ID, $dirname.'_slide_video', true),"youtube.com");
						$yt2 = strpos(get_post_meta($post->ID, $dirname.'_slide_video', true),"youtu.be"); 
						
						?>
						
						<div class="slide-video"<?php if(!$vimeo) { ?> style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;"<?php } ?>>
						
							<div class="play-video" id="<?php echo $name; ?>-play-video-<?php the_ID(); ?>"<?php if(!$vimeo) { ?> style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;"<?php } ?>>
							
								<div class="play-video-button"<?php if(!$vimeo) { ?> style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;"<?php } ?>></div>
								
								<?php if(has_post_thumbnail()) { ?>
									<div class="<?php if(!$vimeo) { ?>slide-image<?php } ?>">
										<div>
											<?php $image = vt_resize(get_post_thumbnail_id(), $gp_settings['placeholder'], $width, $height, true); ?>
											<img src="<?php echo $image['url']; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />	
										</div>
									</div>
								<?php } ?>		
								
							</div>
						
							<?php if($vimeo) { // Vimeo
							
							// Vimeo Clip ID
							if(preg_match('/www.vimeo/', get_post_meta($post->ID, $dirname.'_slide_video', true))) {							
								$vimeoid = trim(get_post_meta($post->ID, $dirname.'_slide_video', true),'http://www.vimeo.com/');
							} else {							
								$vimeoid = trim(get_post_meta($post->ID, $dirname.'_slide_video', true),'http://vimeo.com/');
							}
							
							?>

								<div class="video-player" style="padding-bottom: <?php echo($height / $width)*100; ?>%;">
									<iframe src="http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=<?php if($slide_counter != "1") { ?>0<?php } elseif(get_post_meta($post->ID, $dirname.'_slide_autostart_video', true)) { ?>1<?php } else { ?>0<?php } ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
								</div>
								
								<script>						
								jQuery(window).load(function() { // Play Vimeo video
									jQuery("#<?php echo $name; ?>-play-video-<?php the_ID(); ?>").click(function(){
									  var thePage = jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player");
									  thePage.html(thePage.html().replace('http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=0', 'http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=1'));
									});
									jQuery("#<?php echo $name; ?> .prev, #<?php echo $name; ?> .next, #<?php echo $name; ?> .flex-control-nav li a").click(function(){ // Pause Vimeo video
									  var thePage = jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player");
									  thePage.html(thePage.html().replace('http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=1', 'http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=0'));
									});
								});
								</script>							
								
							<?php } else { // JW Player ?>								
											
								<?php if(($gp_settings['iPhone'] OR $gp_settings['iPad']) && (!$yt1 && !$yt2)) { ?>
			
									<video id="<?php echo $name; ?>-player-<?php the_ID(); ?>" class="video-player" controls="controls" poster="<?php $image = vt_resize(get_post_thumbnail_id(), $gp_settings['placeholder'], $width, $height, true); echo $image['url']; ?>" style="padding-bottom: <?php echo($height / $width)*100; ?>%; width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
										<source src="<?php echo get_post_meta($post->ID, $dirname.'_slide_video', true); ?>" type="video/mp4" />
										<source src="<?php echo get_post_meta($post->ID, $dirname.'_slide_video', true); ?>" type="video/webm" />
										<source src="<?php echo get_post_meta($post->ID, $dirname.'_webm_mp4_slide_video', true); ?>" type="video/mp4" />
										<source src="<?php echo get_post_meta($post->ID, $dirname.'_webm_mp4_slide_video', true); ?>" type="video/webm" />
										<source src="<?php echo get_post_meta($post->ID, $dirname.'_ogg_slide_video', true); ?>" type="video/ogg" />
									</video>
								
								<?php } else { ?>	
								
									<div class="video-player">
										<div id="<?php echo $name; ?>-player-<?php the_ID(); ?>"></div>
									</div>
										
								<?php } ?>
									
								<script>
								
									//<![CDATA[
	
									jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").setup({
										image: "<?php echo get_template_directory_uri(); ?>/lib/images/black.gif",
										icons: "true",
										autostart: "<?php if($slide_counter != '1') { ?>false<?php } elseif(get_post_meta($post->ID, $dirname.'_slide_autostart_video', true)) { ?>true<?php } else { ?>false<?php } ?>",
										stretching: "fill",
										controlbar: "<?php if(get_post_meta($post->ID, $dirname.'_slide_video_controls', true) == 'Over') { ?>over<?php } elseif(get_post_meta($post->ID, $dirname.'_slide_video_controls', true) == 'Bottom') { ?>bottom<?php } else { ?>none<?php } ?>",
										skin: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/fs39/fs39.xml",
										height: <?php echo $height; ?>,
										width: <?php echo $width; ?>,
										screencolor: "000000",
										modes:
											[
											<?php if($gp_settings['MSIE'] OR get_post_meta($post->ID, $dirname.'_slide_video_priority', true) == 'Flash') { ?>
												{type: "flash", src: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/player.swf", config: {file: "<?php echo get_post_meta($post->ID, $dirname.'_slide_video', true); ?>"}},					
												{type: "html5", config: {file: "<?php echo get_post_meta($post->ID, $dirname.'_slide_video', true); ?>"<?php if(($gp_settings['iPhone'] OR $gp_settings['iPad']) && ($yt1 OR $yt2)) {} else { ?>, file: "<?php echo get_post_meta($post->ID, $dirname.'_webm_mp4_slide_video', true); ?>", file: "<?php echo get_post_meta($post->ID, $dirname.'_ogg_slide_video', true); ?>"<?php } ?>}}
											<?php } else { ?>
												{type: "html5", config: {file: "<?php echo get_post_meta($post->ID, $dirname.'_slide_video', true); ?>"<?php if(($gp_settings['iPhone'] OR $gp_settings['iPad']) && ($yt1 OR $yt2)) {} else { ?>, file: "<?php echo get_post_meta($post->ID, $dirname.'_webm_mp4_slide_video', true); ?>", file: "<?php echo get_post_meta($post->ID, $dirname.'_ogg_slide_video', true); ?>"<?php } ?>}},	
												{type: "flash", src: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/player.swf", config: {file: "<?php echo get_post_meta($post->ID, $dirname.'_slide_video', true); ?>"}}
											<?php } ?>
											],
										plugins: {}
									});
									
									//]]>
									
									// Play JW Player						
									jQuery(document).ready(function(){
										jQuery("#<?php echo $name; ?>-play-video-<?php the_ID(); ?>").click(function() {
											jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").play();	
										});	
									});
									
									// Stop JW Player
									jQuery(window).load(function() {	
										jQuery("#<?php echo $name; ?> .prev, #<?php echo $name; ?> .next, #<?php echo $name; ?> .flex-control-nav li a").click(function() {
											if(jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").getState() === "PLAYING") {
												jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").stop();
											}
										});
									});	
						
								</script>
								
							<?php } ?>
							
							<script>
							jQuery(document).ready(function(){
		
								// Hide Play Button
								jQuery("#<?php echo $name; ?>-play-video-<?php the_ID(); ?>").click(function() {
									jQuery('#<?php echo $name; ?>-play-video-<?php the_ID(); ?>').hide();
									jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .caption').hide();
								});
								
							});	
							</script>
						
						</div>
						<!--End Video-->
	
					<?php } else { ?>
					
						<!--Begin Image-->
																														
							<?php $image = vt_resize(get_post_thumbnail_id(), $gp_settings['placeholder'], 9999, 9999, true); ?>
							
							<?php if(get_post_meta($post->ID, $dirname.'_slide_url', true) OR  get_post_meta($post->ID, $dirname.'_slide_link_type', true) != "Page") { ?>
							<?php $image = vt_resize(get_post_thumbnail_id(), $gp_settings['placeholder'], 9999, 9999, true); ?>
							<a href="<?php if(get_post_meta($post->ID, $dirname.'_slide_link_type', true) == "Lightbox Video") { ?>file=<?php echo get_post_meta($post->ID, $dirname.'_slide_url', true); } elseif(get_post_meta($post->ID, $dirname.'_slide_link_type', true) == "Lightbox Image") { if(get_post_meta($post->ID, $dirname.'_slide_url', true)) { echo get_post_meta($post->ID, $dirname.'_slide_url', true); } else { echo $image['url']; }} else { if(get_post_meta($post->ID, $dirname.'_slide_url', true)) { echo get_post_meta($post->ID, $dirname.'_slide_url', true); } else { the_permalink(); }} ?>" title="<?php the_title(); ?>"<?php if(get_post_meta($post->ID, $dirname.'_slide_link_type', true) != "Page") { ?> rel="prettyPhoto"<?php } ?>>
							<?php } ?>
																																															
								<?php $image = vt_resize(get_post_thumbnail_id(), $gp_settings['placeholder'], $width, $height, true); ?>
								<?php if(get_post_meta($post->ID, $dirname.'_slide_link_type', true) == "Lightbox Image") { ?><span class="hover-image"></span><?php } elseif(get_post_meta($post->ID, $dirname.'_slide_link_type', true) == "Lightbox Video") { ?><span class="hover-video"></span><?php } ?>							
								
								<img src="<?php echo $image['url']; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />
								
							<?php if(get_post_meta($post->ID, $dirname.'_slide_url', true) OR  get_post_meta($post->ID, $dirname.'_slide_link_type', true) != "Page") { ?></a><?php } ?>	
							
						<!--End Image-->	
	
					<?php } ?>

				</li>

			<?php endwhile; ?>
		
			</ul>
			<!--End Slider-->
		
		</div>
		<!--End Slider Wrapper-->

	<?php else : ?>
		
		<div class="columns one last separate"><div><?php _e('Oops, you haven\'t set your slider up correctly. Make sure you have created some slides from Slides -> Add New and if you are using slide categories get the category IDs from ID column from Slides -> Slide Categories.', 'gp_lang'); ?></div></div>
		
	<?php endif; wp_reset_query(); ?>
		
	<script>
	jQuery(document).ready(function(){
		
		jQuery("#<?php echo $name; ?>.flexslider").flexslider({ 
			animation: "<?php echo $effect; ?>",
			slideshowSpeed: <?php if($timeout == 0) { echo "9999999"; } else { echo $timeout*1000; } ?>,
			animationDuration: 600,
			directionNav: <?php if($arrows == "true") { ?>true<?php } else { ?>false<?php } ?>,			
			controlNav: <?php if($buttons == "true") { ?>true<?php } else { ?>false<?php } ?>,				
			pauseOnAction: true, 
			pauseOnHover: false,
			touch: false,
			start: function(slider) {

				// Pause Slider
				jQuery("#<?php echo $name; ?> .flex-control-nav li a, #<?php echo $name; ?> .play-video").click(function() { 
					slider.pause(); 
				});
											
				// Resume Slider
				jQuery("#<?php echo $name; ?> .prev, #<?php echo $name; ?> .next").click(function() {
					slider.resume();
				});
		
			}
		});	

		// Show Play Button
		jQuery("#<?php echo $name; ?> .prev, #<?php echo $name; ?> .next, #<?php echo $name; ?> .flex-control-nav li a").click(function() {
			jQuery('#<?php echo $name; ?> .play-video').show();
			jQuery('#<?php echo $name; ?> .caption').show();
		});
		
	});
	
	</script>
	
<?php

	$output_string = ob_get_contents();
	ob_end_clean(); 
	
	return $output_string;

}
add_shortcode('slider', 'gp_slider');

?>