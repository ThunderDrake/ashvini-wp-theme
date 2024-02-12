<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

<div class="u-columns col2-set" id="customer_login">

    <div class="u-column1 col-1">

        <?php endif; ?>

        <h1 class="form-title"><?php esc_html_e('Login', 'levre'); ?></h1>

        <form class="woocommerce-form woocommerce-form-login login" method="post">

            <?php do_action('woocommerce_login_form_start'); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text fs-input" name="username"
                       id="username" autocomplete="username"
                       placeholder="<?php echo esc_html__('Username or email address *', 'levre'); ?>"
                       value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input class="woocommerce-Input woocommerce-Input--text input-text fs-input" type="password"
                       name="password" id="password" placeholder="<?php echo esc_html__('Password *', 'levre'); ?>"
                       autocomplete="current-password"/>
            </p>

            <?php do_action('woocommerce_login_form'); ?>

            <div class="actions-row">

                <p class="remember-me">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox fs-checkbox"
                               name="rememberme" type="checkbox" id="rememberme" value="forever"/>
                        <span><?php esc_html_e('Remember me', 'levre'); ?></span>
                    </label>
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                </p>
                <p class="woocommerce-LostPassword lost_password">
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'levre'); ?></a>
                </p>

            </div>

            <button type="submit"
                    class="woocommerce-form-login__submit fs-button dark-style"
                    name="login"
                    value="<?php esc_attr_e('Log in', 'levre'); ?>"><?php esc_html_e('Log in', 'levre'); ?></button>

            <?php do_action('woocommerce_login_form_end'); ?>

        </form>

        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    </div>


    <div class="u-column2 col-2">

        <h5 class="register-message"><?php esc_html_e('Don’t have an account?', 'levre'); ?></h5>

        <form method="post"
              class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?> >

            <?php do_action('woocommerce_register_form_start'); ?>

            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text fs-input"
                           name="username" id="reg_username" autocomplete="username"
                           placeholder="<?php echo esc_html__('Username *', 'levre'); ?>"
                           value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text fs-input" name="email"
                       id="reg_email" autocomplete="email" placeholder="<?php echo esc_html__('Email *', 'levre'); ?>"
                       value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
            </p>

            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text fs-input"
                           name="password" id="reg_password" autocomplete="new-password"/>
                </p>

            <?php else : ?>

                <p class="password-message"><?php esc_html_e('A password will be sent to your email address.', 'levre'); ?></p>

            <?php endif; ?>

            <?php do_action('woocommerce_register_form'); ?>

            <p class="submit-wrapper">
                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                <button type="submit"
                        class="woocommerce-form-register__submit fs-button dark-style"
                        name="register"
                        value="<?php esc_attr_e('Register', 'levre'); ?>"><?php esc_html_e('Register', 'levre'); ?></button>
            </p>

            <?php do_action('woocommerce_register_form_end'); ?>

        </form>

    </div>

</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>