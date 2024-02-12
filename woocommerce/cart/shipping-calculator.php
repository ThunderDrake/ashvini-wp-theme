<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
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

do_action('woocommerce_before_shipping_calculator'); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

    <?php printf('<a href="#" class="shipping-calculator-button">%s</a>', esc_html(!empty($button_text) ? $button_text : __('Calculate shipping', 'levre'))); ?>

    <section class="shipping-calculator-form" style="display: none;">

        <?php if (apply_filters('woocommerce_shipping_calculator_enable_country', true)) : ?>
            <p class="form-row form-row-wide" id="calc_shipping_country_field">
                <select name="calc_shipping_country" id="calc_shipping_country"
                        class="country_to_state country_select fs-select" rel="calc_shipping_state">
                    <option value="default"><?php esc_html_e('Select a country / region&hellip;', 'levre'); ?></option>
                    <?php
                    foreach (WC()->countries->get_shipping_countries() as $key => $value) {
                        echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
                    }
                    ?>
                </select>
            </p>
        <?php endif; ?>

        <?php if (apply_filters('woocommerce_shipping_calculator_enable_state', true)) : ?>
            <p class="form-row form-row-wide" id="calc_shipping_state_field">
                <?php
                $current_cc = WC()->customer->get_shipping_country();
                $current_r = WC()->customer->get_shipping_state();
                $states = WC()->countries->get_states($current_cc);

                if (is_array($states) && empty($states)) {
                    ?>
                    <input type="hidden" name="calc_shipping_state" id="calc_shipping_state" class="fs-input"
                           placeholder="<?php esc_attr_e('State / County', 'levre'); ?>"/>
                    <?php
                } elseif (is_array($states)) {
                    ?>
                    <span>
						<select name="calc_shipping_state" class="state_select fs-select" id="calc_shipping_state"
                                data-placeholder="<?php esc_attr_e('State / County', 'levre'); ?>">
							<option value=""><?php esc_html_e('Select an option&hellip;', 'levre'); ?></option>
							<?php
                            foreach ($states as $ckey => $cvalue) {
                                echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
                            }
                            ?>
						</select>
					</span>
                    <?php
                } else {
                    ?>
                    <input type="text" class="input-text fs-input" value="<?php echo esc_attr($current_r); ?>"
                           placeholder="<?php esc_attr_e('State / County', 'levre'); ?>"
                           name="calc_shipping_state" id="calc_shipping_state"/>
                    <?php
                }
                ?>
            </p>
        <?php endif; ?>

        <?php if (apply_filters('woocommerce_shipping_calculator_enable_city', true)) : ?>
            <p class="form-row form-row-wide" id="calc_shipping_city_field">
                <input type="text" class="input-text fs-input"
                       value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>"
                       placeholder="<?php esc_attr_e('City', 'levre'); ?>" name="calc_shipping_city"
                       id="calc_shipping_city"/>
            </p>
        <?php endif; ?>

        <?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
            <p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                <input type="text" class="input-text fs-input"
                       value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>"
                       placeholder="<?php esc_attr_e('Postcode / ZIP', 'levre'); ?>"
                       name="calc_shipping_postcode" id="calc_shipping_postcode"/>
            </p>
        <?php endif; ?>

        <p class="update-totals-wrapper">
            <button type="submit" name="calc_shipping" value="1"
                    class="update-totals-button"><?php esc_html_e('Update totals', 'levre'); ?></button>
        </p>
        <?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
    </section>
</form>

<?php do_action('woocommerce_after_shipping_calculator'); ?>