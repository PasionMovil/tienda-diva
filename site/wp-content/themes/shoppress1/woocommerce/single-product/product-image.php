<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $woocommerce, $gp_settings;

?>
<div class="images">

	<?php if ( has_post_thumbnail() ) : 
	
		if(get_post_meta(get_post_thumbnail_id(), '_gp_video_url', true)) {
			$pi_url = 'file='.get_post_meta(get_post_thumbnail_id(), '_gp_video_url', true);
		} else {
			$pi_url = wp_get_attachment_url( get_post_thumbnail_id() );
		}	
		
		if($gp_settings['image_effect'] == "Lightbox") {
			$pi_lightbox = 'rel="prettyPhoto[gallery]" ';
		} else {
			$pi_lightbox = '';
		}	
			
	?>

		<a itemprop="image" <?php echo $pi_lightbox; ?>href="<?php echo $pi_url; ?>" title="<?php echo get_the_title( get_post_thumbnail_id() ); ?>"><?php echo get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ) ?></a>

	<?php else : ?>

		<img src="<?php echo woocommerce_placeholder_img_src(); ?>" alt="Placeholder" />

	<?php endif; ?>

	<?php do_action('woocommerce_product_thumbnails'); ?>

</div>