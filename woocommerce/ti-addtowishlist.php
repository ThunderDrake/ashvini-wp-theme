<?php
/**
 * The Template for displaying add to wishlist product button.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-addtowishlist.php.
 *
 * @version             2.4.3
 * @package           TInvWishlist\Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
wp_enqueue_script('tinvwl');
?>

<div class="tinv-wraper woocommerce circle-button tinv-wishlist <?php echo esc_attr($class_postion) ?>"
     data-product_id="<?php echo esc_attr($product->get_id()); ?>">
    <?php do_action('tinvwl_wishlist_addtowishlist_button', $product, $loop); ?>
    <?php do_action('tinvwl_wishlist_addtowishlist_dialogbox', $product, $loop); ?>

    <span class="icons-wrapper">

            <span class="hover-state">

                             <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/heart-icon-white.svg') ?>"
                                  alt="<?php echo esc_attr__('Wishlist Icon', 'levre'); ?>">

                        </span>

        <span class="default-state">

                             <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/heart-icon.svg') ?>"
                                  alt="<?php echo esc_attr__('Wishlist Icon', 'levre'); ?>">

                        </span>

        <span class="already-in-state">

                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/heart-icon-fill.svg') ?>"
                                     alt="<?php echo esc_attr__('Wishlist Icon', 'levre'); ?>">

                            </span>

        </span>

</div>

<div class="tinv-wraper woocommerce product-wishlist-button tinv-wishlist <?php echo esc_attr($class_postion) ?>"
     data-product_id="<?php echo esc_attr($product->get_id()); ?>">
    <?php do_action('tinvwl_wishlist_addtowishlist_button', $product, $loop); ?>
    <?php do_action('tinvwl_wishlist_addtowishlist_dialogbox', $product, $loop); ?>

    <p class="not-added state">

        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/heart-icon.svg') ?>"
             alt="<?php echo esc_attr__('Wishlist Icon', 'levre'); ?>">

        <span class="common">

                <?php

                echo esc_html__('Add to Wishlist', 'levre');

                ?>

            </span>

    </p>

    <p class="added state">

        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/heart-icon-fill.svg') ?>"
             alt="<?php echo esc_attr__('Wishlist Icon', 'levre'); ?>">

        <span class="common">

                <?php echo esc_html__('The product is already in your wishlist!', 'levre'); ?>

            </span>

        <a href="<?php echo esc_url(tinv_url_wishlist_default()); ?>" target="_blank">

            <?php echo esc_html__('Browse Wishlist', 'levre'); ?>

        </a>

    </p>

</div>
