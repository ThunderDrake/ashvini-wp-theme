<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined('ABSPATH') || exit;

?>

<div class="cart-empty cart-is-empty-wrapper">

    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/empty-bag.svg'); ?>"
         alt="<?php echo esc_attr__('Empty Bag', 'levre'); ?>" class="empty-bag-icon">

    <h1 class="title">

        <?php echo esc_html__('Your bag is empty', 'levre'); ?>

    </h1>

    <?php

    if (wc_get_page_id('shop') > 0) : ?>
        <p class="return-to-shop">
            <a class="fs-button dark-border-style"
               href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                <?php
                /**
                 * Filter "Return To Shop" text.
                 *
                 * @param string $default_text Default text.
                 *
                 * @since 4.6.0
                 */
                echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Keep Shopping', 'levre')));
                ?>
            </a>
        </p>
    <?php endif; ?>

</div>