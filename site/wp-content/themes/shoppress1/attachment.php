<?php get_header(); ?>


<!-- BEGIN BREADCRUMBS -->

<?php if($gp_settings['breadcrumbs'] == "Show") { ?><div id="breadcrumb"><?php echo the_breadcrumb(); ?></div>	<?php } ?>

<!-- END BREADCRUMBS -->


<!-- BEGIN CONTENT -->

<div id="content">


	<!-- BEGIN TITLE -->
	
	<?php if($gp_settings['title'] == "Show") { ?><h1 class="page-title"><?php _e('Page Not Found', 'gp_lang'); ?></h1><?php } ?>

	<!-- END TITLE -->
	
		
	<!-- BEGIN IMAGE -->
		
	<?php the_attachment_link($post->post_ID, true) ?>
	
	<!-- END IMAGE -->
	
	
	<!-- BEGIN POST CONTENT -->
	
	<div id="post-content">
		<?php the_content(); ?>
	</div>
	
	<!-- END POST CONTET-->
	
	
	<!-- BEGIN POST NAV -->	
	
	<?php wp_link_pages('before=<div class="clear"></div><div class="wp-pagenavi post-navi">&pagelink=<span>%</span>&after=</div>'); ?>
	
	<!-- END POST NAV -->
	
	
	<!--BEGIN COMMENTS -->
	
	<?php comments_template(); ?>
	
	<!-- END COMMENTS -->
	
		
</div>

<!-- END CONTENT -->


<?php get_footer(); ?>