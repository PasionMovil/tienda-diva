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
							<h2 class="entry-title"><?php the_title(); ?></h2>
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