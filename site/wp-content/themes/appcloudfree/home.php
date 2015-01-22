<?php get_header(); ?>
	<article id="featured">
		<?php $iclUtility->getFeatureProduct(1,3);?>
		<h2 id="featured-title">Featured Apps</h2>
			<div id="slider" class="wrap1 stepcarousel">
				<div class="belt">
				<?php
					if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				?>
					<section itemscope itemtype="http://data-vocabulary.org/Product" class="featured-content">
						<h3 itemprop="name" class="featured-content-title"><a href="<?php echo get_permalink(get_the_ID()) ?>"><?php the_title() ?></a></h3>
						<?php echo $iclUtility->getProductImage(get_the_ID(),60,60)?>
						<span itemscope class="featured-category"><meta itemprop="category" content=""><?php echo get_the_term_list( $post->ID, 'wpsc_product_category', '', ', ', '' ); ?></span>
						<span itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer" class="featured-price">
							<span itemprop="price"><?php echo wpsc_the_product_price(); ?></span>
						</span>
						<figure class="featured-image">
							<?php echo $iclUtility->getProductImage(get_the_ID(),326,377) ?>
						</figure>
						<div itemprop="description">
							<p><?php echo myExcerpts(false,75); ?></p>
						</div>
						<form class="product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />					
							<?php if( wpsc_product_is_customisable() ) : ?>
								<input type="hidden" value="true" name="is_customisable"/>
							<?php endif; ?>
							<?php
							/**
							 * Cart Options
							 */
							?>

							<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div class="wpsc_buy_button_container">
											<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
											<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
											<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
											<?php else: ?>
										<input type="submit" value="<?php _e('Add To Cart', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
											<?php endif; ?>
										<div class="wpsc_loading_animation">
											<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
											<?php _e('Updating cart...', 'wpsc'); ?>
										</div><!--close wpsc_loading_animation-->
									</div><!--close wpsc_buy_button_container-->
								<?php else : ?>
									<p class="soldout"><?php _e('This product has sold out.', 'wpsc'); ?></p>
								<?php endif ; ?>
							<?php endif ; ?>
						</form><!--close product_form-->
					</section>
				<?php endwhile;endif;?>						
				</div>
			</div>
		<ul class="slide-nav">
			<li class="prev-slide"><a href="javascript:stepcarousel.stepBy('slider', -1)">Previous</a></li>
			<li class="next-slide"><a href="javascript:stepcarousel.stepBy('slider', 1)">Next</a></li>
		</ul>
	</article>

	<article id="content">
		<h2 id="content-title">Newest Apps</h2>
		<div id="slider2" class="wrap1 stepcarousel">
			<div class="belt">
				<div class="item">
<?php 
		$iclUtility->getRecentProduct(1,27);
		global $wp_query;
		$total = $wp_query->post_count;
		$count = 1;
		if ( have_posts() ) : while ( have_posts() ) : the_post();
?>		
					<section itemscope itemtype="http://data-vocabulary.org/Product" class="entry-content recent-item">
						<h3 itemprop="name" class="entry-content-title"><a href="<?php echo get_permalink(get_the_ID())?>"><?php the_title()?></a></h3>
						<?php echo $iclUtility->getProductImage(get_the_ID(),60,60)?>
						<span itemscope class="content-category"><meta itemprop="category" content=""><?php echo get_the_term_list( $post->ID, 'wpsc_product_category', '', ', ', '' ); ?></span>
						<span itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer" class="content-price">
							<meta itemprop="currency" content="USD" /><?php echo wpsc_the_product_price(); ?></span>
						</span>
						<div itemprop="description">
							<p><?php echo myExcerpts(false,20); ?></p>
						</div>
					</section>
<?php
				if ( $count % 9 == 0 ) : ?>
				</div> <!-- .item -->
				<div class="item">
<?php				
				endif;
				
				$count++;
			endwhile;endif;
?>			</div> <!-- .item -->
			</div> <!-- .belt -->
		</div> <!-- #slider2 -->
<?php
	if ( $total > 9 ) :
?>		
		<ul class="slide-nav">
			<li class="prev-slide"><a href="javascript:stepcarousel.stepBy('slider2', -1)">Previous</a></li>
			<li class="next-slide"><a href="javascript:stepcarousel.stepBy('slider2', 1)">Next</a></li>
		</ul>	

<?php
	endif;
?>
	</article>
		 
<?php get_footer(); ?>