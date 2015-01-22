<?php get_header(); global $gp_settings; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<!-- BEGIN CONTENT -->
	
	<div id="content">


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
					
							
		<!-- BEGIN IMAGE -->
										
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>				
			<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
				<?php $image = vt_resize(get_post_thumbnail_id(), '', $gp_settings['image_width'], $gp_settings['image_height'], true); ?>
				<img src="<?php echo $image['url']; ?>" width="<?php echo $gp_settings['image_width']; ?>" height="<?php echo $gp_settings['image_height']; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />			
			</div>					
			<?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
		<?php } ?>
		
		<!-- END IMAGE -->
				
				
		<!-- BEGIN POST CONTENT -->
				
		<div id="post-content">
			<?php the_content(); ?>
		</div>
		
		<!-- END POST CONTENT -->
				
				
		<!-- BEGIN POST NAV -->
				
		<?php wp_link_pages('before=<div class="clear"></div><div class="post-navi">&pagelink=<span>%</span>&after=</div>'); ?>		
		
		<!-- END POST NAV -->


		<!-- BEGIN POST TAGS -->
		
		<?php if($gp_settings['meta_tags'] == "0") { ?><?php the_tags('<div class="post-meta post-tags"><span class="tag-icon">', ', ', '</span></div>'); ?><?php } ?>		
		
		<!-- END POST TAGS -->
				
		
		<!-- BEGIN AUTHOR INFO PANEL -->
		
		<?php if($gp_settings['author_info'] == "0") { ?><?php echo do_shortcode('[author]'); ?>	<?php } ?>
		
		<!-- END AUTHOR INFO PANEL -->
	

		<!-- BEGIN RELATED POSTS -->
		
		<?php if($gp_settings['related_items'] == "0") { ?>				
			<?php echo do_shortcode('[related_posts id="" cats="" images="true" image_width="'.$gp_settings['related_image_width'].'" image_height="'.$gp_settings['related_image_height'].'" image_wrap="false" cols="4" per_page="4" link="both" orderby="random" order="desc" offset="0" content_display="excerpt" excerpt_length="0" title="true" title_size="12" meta="false" read_more="false" pagination="false" spacing="spacing-small" preload="false"]'); ?>			
		<?php } ?>	
		
		<!-- END RELATED POSTS -->
				
		
		<!-- BEGIN COMMENTS -->
		
		<?php comments_template(); ?>
		
		<!-- END COMMENTS -->

	
	</div>
	
	<!-- END CONTENT -->
	
	
	<?php get_sidebar(); ?>


<?php endwhile; endif; ?>


<?php get_footer(); ?>