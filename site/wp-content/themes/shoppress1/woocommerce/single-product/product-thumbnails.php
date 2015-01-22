<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $woocommerce, $gp_settings;
?>
<div class="thumbnails"><?php
	$attachments = get_posts( array(
		'post_type' 	=> 'attachment',
		'numberposts' 	=> -1,
		'post_status' 	=> null,
		'post_parent' 	=> $post->ID,
		'post__not_in'	=> array( get_post_thumbnail_id() ),
		'post_mime_type'=> 'image',
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC'
	) );
	if ($attachments) {

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachments as $key => $attachment ) {

			if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image', true ) == 1 )
				continue;

			$classes = array( '' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			if(get_post_meta($attachment->ID, '_gp_video_url', true)) {
				$pt_url = 'file='.get_post_meta($attachment->ID, '_gp_video_url', true);
			} else {
				$pt_url = wp_get_attachment_url( $attachment->ID );
			}	
	
			if($gp_settings['image_effect'] == "Lightbox") {
				$pi_lightbox = 'rel="prettyPhoto[gallery]" ';
			} else {
				$pi_lightbox = '';
			}				

			printf( '<a href="%s" title="%s" '.$pi_lightbox.'class="%s">%s</a>', $pt_url, esc_attr( $attachment->post_title ), implode(' ', $classes), wp_get_attachment_image( $attachment->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) ) );

			$loop++;

		}

	}
?></div>