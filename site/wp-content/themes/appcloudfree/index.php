<?php get_header(); ?>
<?php global $iclUtility;?>

		<section id="content-wrapper">
			<section id="main-content">

<?php 
		if ( have_posts() ) :
			while ( have_posts() ) : the_post(); 
?>
				<div class="post">
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
						<header class="post-title">
<?php 
						if (!$iclUtility->isOnWPSCpage() && !is_page()):
?>
							<div class="date"><strong><?php echo date_posted_on('d');?></strong><?php echo date_posted_on('M');?></div>
<?php 
						endif;
?>
							<h2 class="entry-title"><a href="<?php echo get_permalink(get_the_ID())?>"><?php the_title(); ?></a></h2>
						</header>
						<div class="post-content">
<?php 
						the_content();
						edit_post_link( __( 'Edit', 'appcloud' ), '<span class="edit-link">', '</span>' ); 
?>
						</div><!-- .post-content -->
					</div><!-- #post-## -->
				</div> <!-- .post -->
<?php 
				if(is_single () || is_page()):
					comments_template( '', true );
				endif;
			endwhile;		
?>
			

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php 
			if (  $wp_query->max_num_pages > 1 ) : 
?>
			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
			</div><!-- #nav-below -->
<?php 
			endif; 
			
		endif; 
?>

				
			</section><!-- main-content -->
				

			<section id="sidebar">
<?php 
			if ( !dynamic_sidebar('Left Sidebar') ) :
			endif;
?>
			</section><!-- sidebar -->
		</section><!-- content wrapper -->
                   
<?php get_footer(); ?>