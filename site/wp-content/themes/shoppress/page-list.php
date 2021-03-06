<?php
/*
Template Name: Page List
*/
get_header(); global $gp_settings; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		
	<!-- BEGIN CONTENT -->		

	<div id="content">


		<!-- BEGIN BREADCRUMBS -->
	
		<?php if($gp_settings['breadcrumbs'] == "Show") { ?><div id="breadcrumb"><?php echo the_breadcrumb(); ?></div><?php } ?>
		
		<!-- END BREADCRUMBS -->
		

		<!-- BEGIN TITLE -->

		<?php if($gp_settings['title'] == "Show") { ?><h1 class="page-title"><?php the_title(); ?></h1><?php } ?>
		
		<!-- END TITLE -->


		<!-- BEGIN POST META -->
		
		<?php if($gp_settings['meta_date'] == "0" OR $gp_settings['meta_author'] == "0" OR $gp_settings['meta_cats'] == "0" OR $gp_settings['meta_comments'] == "0") { ?>
		
			<div class="post-meta">
			
				<?php if($gp_settings['meta_author'] == "0") { ?><span class="author-icon"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
				
				<?php if($gp_settings['meta_date'] == "0") { ?><span class="clock-icon"><?php the_time(get_option('date_format')); ?></span><?php } ?>
				
				<?php if($gp_settings['meta_cats'] == "0" && $post->post_type == "post") { ?><span class="folder-icon"><?php the_category(', '); ?></span><?php } ?>
				
				<?php if($gp_settings['meta_comments'] == "0" && 'open' == $post->comment_status) { ?><span class="speech-icon"><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
				
			</div>
			
		<?php } ?>
		
		<!-- BEGIN POST META -->
					
							
		<!-- BEGIN FEATURED IMAGE -->
		
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>
			<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
				<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)),  $gp_settings['image_width'], $gp_settings['image_height'], true, true); ?>
				<?php if(get_option($dirname."_retina") == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)),  $gp_settings['image_width']*2, $gp_settings['image_height']*2, true, true); } else { $retina = ""; } ?>
				<img src="<?php echo $image; ?>" data-rel="<?php echo $retina; ?>" style="width: <?php echo $gp_settings['image_width']; ?>px;<?php if($gp_settings['hard_crop'] == "Enable") { ?> height: <?php echo $gp_settings['image_height']; ?>px;<?php } ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />			
			</div>
			<?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
		<?php } ?>
		
		<!-- END FEATURED IMAGE -->
				
				
		<!-- BEGIN PAGE LIST -->

		<?php $children = wp_list_pages('depth=1&title_li=&child_of='.$post->ID.'&echo=0'); if($children) { ?>
		
			<ul class="gp-list">
				<?php echo $children; ?>
			</ul>

		<?php } ?>	
		
		<!-- END PAGE LIST -->
	
	
	</div>
	
	<!--END CONTENT -->	
	
	
	<?php get_sidebar(); ?>


<?php endwhile; endif; ?>


<?php get_footer(); ?>