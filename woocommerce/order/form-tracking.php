<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined( 'ABSPATH' ) || exit;

global $post;
?>

<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="woocommerce-form woocommerce-form-track-order track_order">

	<p class="upper-text"><?php esc_html_e( 'To track your order please enter your Order ID below and press Track. Order ID can be found in your order confirmation email.', 'levre' ); ?></p>

	<div class="form-inner">

        <p class="form-row form-row-first"><input class="input-text fs-input" type="text" name="orderid" id="orderid" value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Order ID *', 'levre' ); ?>" /></p><?php // @codingStandardsIgnoreLine ?>
        <p class="form-row form-row-last"><input class="input-text fs-input" type="text" name="order_email" id="order_email" value="<?php echo isset( $_REQUEST['order_email'] ) ? esc_attr( wp_unslash( $_REQUEST['order_email'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Email *', 'levre' ); ?>" /></p><?php // @codingStandardsIgnoreLine ?>
        <div class="clear"></div>

        <p class="form-row"><button type="submit" class="button fs-button dark-style" name="track" value="<?php esc_attr_e( 'Track', 'levre' ); ?>"><?php esc_html_e( 'Track', 'levre' ); ?></button></p>
        <?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>

    </div>

</form>