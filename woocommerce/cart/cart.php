<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

?>

<div class="cart-header">

    <h1 class="title">

        <?php echo esc_html__('Shopping bag', 'levre'); ?>

    </h1>

</div>

<?php

do_action('woocommerce_before_cart'); ?>

<div class="cart-form-wrapper">

    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>

        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <thead>
            <tr>
                <th class="product-thumbnail">&nbsp;</th>
                <th class="product-name">&nbsp;</th>
                <th class="product-price"><?php esc_html_e('Price', 'levre'); ?></th>
                <th class="product-quantity"><?php esc_html_e('Quantity', 'levre'); ?></th>
                <th class="product-subtotal"><?php esc_html_e('Total', 'levre'); ?></th>
                <th class="product-remove">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                        <td class="product-thumbnail">
                            <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                            if (!$product_permalink) {

                                ?>

                                <a href="<?php echo esc_url($product_permalink); ?>" class="image-wrapper">

                                    <?php

                                    $image_id = $_product->get_image_id();

                                    if (class_exists('FSD_Helper')):

                                        echo FSD_Helper::render_image($image_id,
                                            'thumbnail',
                                            array('sizes' => implode(',', array(
                                                '(max-width: 300px) 300px',
                                            )),
                                                'srcset' => implode(',', array(
                                                    esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')) . ' 300w',
                                                )),
                                                'loading' => 'lazy',
                                                'alt' => get_the_title(),
                                                'class' => 'product-thumbnail'
                                            ), false);

                                    else:

                                        ?>

                                        <img src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'large')); ?>"
                                             alt="<?php echo esc_attr(get_the_title()); ?>">

                                    <?php

                                    endif;

                                    ?>

                                </a>

                                <?php

                            } else {

                                ?>

                                <a href="<?php echo esc_url($product_permalink); ?>" class="image-wrapper">

                                    <?php

                                    $image_id = $_product->get_image_id();

                                    if (class_exists('FSD_Helper')):

                                        echo FSD_Helper::render_image($image_id,
                                            'thumbnail',
                                            array('sizes' => implode(',', array(
                                                '(max-width: 300px) 300px',
                                            )),
                                                'srcset' => implode(',', array(
                                                    esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')) . ' 300w',
                                                )),
                                                'loading' => 'lazy',
                                                'alt' => get_the_title(),
                                                'class' => 'product-thumbnail'
                                            ), false);

                                    else:

                                        ?>

                                        <img src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'large')); ?>"
                                             alt="<?php echo esc_attr(get_the_title()); ?>">

                                    <?php

                                    endif;

                                    ?>

                                </a>

                                <?php

                            }
                            ?>
                        </td>

                        <td class="product-name" data-title="<?php esc_attr_e('Product', 'levre'); ?>">
                            <?php
                            if (!$product_permalink) {
                                echo FSD_Theme::str_kses(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                            } else {
                                echo FSD_Theme::str_kses(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                            }

                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                            // Meta data.
                            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                            // Backorder notification.
                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                echo FSD_Theme::str_kses(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'levre') . '</p>', $product_id));
                            }
                            ?>
                        </td>

                        <td class="product-price" data-title="<?php esc_attr_e('Price', 'levre'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>

                        <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'levre'); ?>">

                            <div class="quantity-cell-inner">

                                <div class="quantity-wrapper">

                                    <?php

                                    echo '<button type="button" class="minus" ><img src="' . esc_url(get_template_directory_uri() . '/assets/img/minus-quantity.svg') . '"
                             alt="' . esc_attr__('Minus', 'levre') . '" class="minus"></button>';

                                    if ($_product->is_sold_individually()) {
                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name' => "cart[{$cart_item_key}][qty]",
                                                'input_value' => $cart_item['quantity'],
                                                'max_value' => $_product->get_max_purchase_quantity(),
                                                'min_value' => '0',
                                                'product_name' => $_product->get_name(),
                                            ),
                                            $_product,
                                            false
                                        );
                                    }

                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.

                                    echo '<button type="button" class="plus" ><img src="' . esc_url(get_template_directory_uri() . '/assets/img/plus-quantity.svg') . '"
                             alt="' . esc_attr__('Plus', 'levre') . '" class="plus-icon"></button>';

                                    ?>

                                </div>

                            </div>

                        </td>

                        <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'levre'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>

                        <td class="product-remove">
                            <?php
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                'woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"> <img src="' . esc_url(get_template_directory_uri() . '/assets/img/close-shop.svg') . '"
                                     alt="' . esc_html__('Remove item', 'levre') . '"></a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    esc_html__('Remove this item', 'levre'),
                                    esc_attr($product_id),
                                    esc_attr($_product->get_sku())
                                ),
                                $cart_item_key
                            );
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            <?php do_action('woocommerce_cart_actions'); ?>

            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <?php do_action('woocommerce_after_cart_contents'); ?>

            </tbody>

        </table>

        <div class="actions-wrapper">

            <?php if (wc_coupons_enabled()) : ?>

                <div class="coupon-form-wrapper">

                    <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                        <input type="text"
                               name="coupon_code"
                               class="input-text fs-input"
                               id="coupon_code"
                               value=""
                               placeholder="<?php esc_attr_e('Coupon code', 'levre'); ?>"/>
                        <button type="submit" class="fs-button dark-border-style" name="apply_coupon"
                                value="<?php esc_attr_e('Apply', 'levre'); ?>"><?php esc_attr_e('Apply', 'levre'); ?></button>
                    </form>

                </div>

            <?php else: ?>

                <br>

            <?php endif; ?>

            <button type="submit" class="button fs-button update-cart dark-border-style" name="update_cart"
                    value="<?php esc_attr_e('Update cart', 'levre'); ?>"><?php esc_html_e('Update cart', 'levre'); ?></button>

        </div>

        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <div class="cart-collaterals-wrapper">

        <div class="cart-collaterals-inner">

            <?php do_action('woocommerce_before_cart_collaterals'); ?>

            <div class="cart-collaterals">
                <?php
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cross_sell_display
                 * @hooked woocommerce_cart_totals - 10
                 */
                do_action('woocommerce_cart_collaterals');
                ?>
            </div>

            <?php if (wc_get_page_id('shop') > 0) : ?>
                <p class="return-to-shop">
                    <a class="fs-link"
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

            <?php do_action('woocommerce_after_cart'); ?>

        </div>

    </div>

</div>