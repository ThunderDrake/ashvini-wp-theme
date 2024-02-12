<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">

    <?php
    if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
        ?>

        <div class="container">

            <?php if ($order->has_status('failed')) : ?>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php echo esc_html__('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'levre'); ?></p>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
                       class="button pay"><?php echo esc_html__('Pay', 'levre'); ?></a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                           class="button pay"><?php echo esc_html__('My account', 'levre'); ?></a>
                    <?php endif; ?>
                </p>

            <?php else : ?>

                <div class="success-page-wrapper">

                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/order.svg'); ?>"
                         alt="<?php echo esc_attr__('Order icon', 'levre'); ?>" class="order-icon">

                    <h2 class="title">

                        <?php echo esc_html__('Thank you for your order!', 'levre'); ?>

                    </h2>

                    <p class="subtitle">

                        <?php echo esc_html__('You will receive email confirmation shortly at ', 'levre') . $order->get_billing_email(); ?>

                    </p>

                    <a class="keep-shopping-button fs-button dark-border-style"
                       href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">

                        <?php echo esc_html__('Keep shopping', 'levre'); ?>

                    </a>

                </div>

            <?php endif; ?>

        </div>


        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

    <?php else : ?>

        <div class="success-page-wrapper">

            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/order.svg'); ?>"
                 alt="<?php echo esc_attr__('Order icon', 'levre'); ?>" class="order-icon">

            <h1 class="title">

                <?php echo esc_html__('Thank you for your order', 'levre'); ?>

            </h1>

            <p class="subtitle">

                <?php echo esc_html__('Thank you. Your order has been received.', 'levre'); ?>

            </p>

            <a class="keep-shopping-button fs-button dark-border-style"
               href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">

                <?php echo esc_html__('Keep shopping', 'levre'); ?>

            </a>

        </div>

    <?php endif; ?>

</div>