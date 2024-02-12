<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
    <?php do_action('woocommerce_before_add_to_cart_button'); ?>



    <?php
    do_action('woocommerce_before_add_to_cart_quantity');
    ?>

    <div class="quantity-wrapper">

        <?php

        echo '<button type="button" class="minus" ><img src="' . esc_url(get_template_directory_uri() . '/assets/img/minus-quantity.svg') . '"
                             alt="' . esc_attr__('Minus', 'levre') . '" class="minus"></button>';

        woocommerce_quantity_input(
            array(
                'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
            )
        );

        echo '<button type="button" class="plus" ><img src="' . esc_url(get_template_directory_uri() . '/assets/img/plus-quantity.svg') . '"
                             alt="' . esc_attr__('Plus', 'levre') . '" class="plus-icon"></button>';

        ?>

    </div>

    <?php

    do_action('woocommerce_after_add_to_cart_quantity');
    ?>


    <button type="submit"
            class="fs-button dark-style"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

    <?php do_action('woocommerce_after_add_to_cart_button'); ?>

    <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
    <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>
    <input type="hidden" name="variation_id" class="variation_id" value="0"/>
</div>