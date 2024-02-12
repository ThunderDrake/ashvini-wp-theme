<?php
/**
 * The Template for displaying empty wishlist.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist-empty.php.
 *
 * @version             2.5.2
 * @package           TInvWishlist\Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>
<div class="tinv-wishlist woocommerce">
    <?php do_action('tinvwl_before_wishlist', $wishlist); ?>

    <table class="tinvwl-table-manage-list pseudo-table">
        <thead>
        <tr>

            <th class="product-name">

                <?php esc_html_e('Product Name', 'levre'); ?>

            </th>

            <th class="product-price">

                <?php esc_html_e('Price', 'levre'); ?>

            </th>

            <th class="product-stock">

                <?php esc_html_e('Stock Status', 'levre'); ?>

            </th>

        </tr>
        </thead>
    </table>

    <?php if (function_exists('wc_print_notices') && isset(WC()->session)) {
        wc_print_notices();
    } ?>
    <p class="cart-empty">
        <?php if (get_current_user_id() === $wishlist['author']) { ?>
            <?php esc_html_e('No products added to the wishlist', 'levre'); ?>
        <?php } else { ?>
            <?php esc_html_e('No products added to the wishlist', 'levre'); ?>
        <?php } ?>
    </p>

    <?php do_action('tinvwl_wishlist_is_empty'); ?>
</div>