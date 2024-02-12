<?php
/**
 * The Template for displaying header for wishlist.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist-header.php.
 *
 * @version             1.21.5
 * @package           TInvWishlist\Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="tinv-header">

	<h1 class="wishlist-title">

        <?php echo FSD_Theme::str_kses( apply_filters( 'tinvwl_wishlist_header_title', $wishlist['title'], $wishlist ) ); ?>

    </h1>

	<?php do_action( 'tinvwl_in_title_wishlist', $wishlist ); ?>

</div>
