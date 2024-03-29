<?php
/**
 * The Template for displaying dropdown wishlist products.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist-product-counter.php.
 *
 * @version             2.8.0
 * @package           TInvWishlist\Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
wp_enqueue_script( 'tinvwl' );
if ( $icon_class && 'custom' === $icon && ! empty( $icon_upload ) ) {
	$text = sprintf( '<img src="%s" /> %s', esc_url( $icon_upload ), $text );
}
?>
<a href="<?php echo esc_url( tinv_url_wishlist_default() ); ?>"
   name="<?php echo esc_attr( sanitize_title( $text ) ); ?>" aria-label="<?php echo esc_attr( $text ); ?>"
   class="wishlist_products_counter<?php echo ' ' . $icon_class . ' ' . $icon_style . ( empty( $text ) ? ' no-txt' : '' ) . ( 0 < $counter ? ' wishlist-counter-with-products' : '' ); // WPCS: xss ok. ?>">
	<span class="wishlist_products_counter_text"><?php echo FSD_Theme::check_for_empty($text); // WPCS: xss ok. ?></span>
	<?php if ( $show_counter ) : ?>
		<span class="wishlist_products_counter_number"></span>
	<?php endif; ?>
</a>
