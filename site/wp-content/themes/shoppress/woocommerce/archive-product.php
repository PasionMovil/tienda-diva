<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @package WooCommerce
 * @since WooCommerce 1.0
 * @todo replace loop-shop with a content template and include query/loop here instead.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); global $gp_settings; ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>

		<?php if($gp_settings['title'] == "Show") { ?>

			<div class="category-header">
			
				<?php global $wp_query;
				$cat = $wp_query->get_queried_object();
				if(isset($cat->term_id)) {
					$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
				} else {
					$thumbnail_id = "";
				} ?>
						
				<?php if($thumbnail_id) { ?><img src="<?php echo wp_get_attachment_url($thumbnail_id); ?>" class="category-thumbnail" alt="" /><?php } ?>
		
				<div class="left">
					
					<h1 class="page-title">
						<?php if ( is_search() ) : ?>
							<?php
								printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
								if ( get_query_var( 'paged' ) )
									printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
							?>
						<?php elseif ( is_tax() ) : ?>
							<?php echo single_term_title( "", false ); ?>
						<?php else : ?>
							<?php
								$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
			
								echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
							?>
						<?php endif; ?>
					</h1>
			
					<?php do_action( 'woocommerce_archive_description' ); ?>
			
					<?php if ( is_tax() ) : ?>
						<?php do_action( 'woocommerce_taxonomy_archive_description' ); ?>
					<?php elseif ( ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
						<?php do_action( 'woocommerce_product_archive_description', $shop_page ); ?>
					<?php endif; ?>
		
				</div>
	
			</div>
		
		<?php } ?>
				
		<?php if ( have_posts() ) : ?>

			<?php do_action('woocommerce_before_shop_loop'); ?>

			<ul class="products<?php echo $gp_settings['product_columns_class']; ?>">

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			</ul>

			<?php do_action('woocommerce_after_shop_loop'); ?>

		<?php else : ?>

			<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products'.$gp_settings['product_columns_class'].'">', 'after' => '</ul>' ) ) ) : ?>

				<p><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>

			<?php endif; ?>

		<?php endif; ?>

		<div class="clear"></div>

		<div class="woocommerce-pagination">
		<?php
			/**
			 * woocommerce_pagination hook
			 *
			 * @hooked woocommerce_pagination - 10
			 * @hooked woocommerce_catalog_ordering - 20
			 */
			do_action( 'woocommerce_pagination' );
			
		?>
		</div>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>