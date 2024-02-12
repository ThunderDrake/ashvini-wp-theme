<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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

defined('ABSPATH') || exit;

do_action('woocommerce_before_reset_password_form');
?>

    <form method="post" class="woocommerce-ResetPassword lost_reset_password">

        <h1 class="lost-title">

            <?php echo esc_html__('Reset Password', 'levre'); ?>

        </h1>

        <p class="password-message"> <?php echo apply_filters('woocommerce_reset_password_message', esc_html__('Enter a new password below.', 'levre')); ?></p><?php // @codingStandardsIgnoreLine ?>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text fs-input"
                   placeholder="<?php echo esc_html__('Current Password *', 'levre'); ?>"
                   name="password_1" id="password_1" autocomplete="new-password"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text fs-input"
                   placeholder="<?php echo esc_html__('New Password *', 'levre'); ?>"
                   name="password_2" id="password_2" autocomplete="new-password"/>
        </p>

        <input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>"/>
        <input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>"/>

        <div class="clear"></div>

        <?php do_action('woocommerce_resetpassword_form'); ?>

        <p class="woocommerce-form-row form-row">
            <input type="hidden" name="wc_reset_password" value="true"/>
            <button type="submit" class="fs-button dark-style"
                    value="<?php esc_attr_e('Save', 'levre'); ?>"><?php esc_html_e('Save', 'levre'); ?></button>
        </p>

        <?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>

    </form>
<?php
do_action('woocommerce_after_reset_password_form');