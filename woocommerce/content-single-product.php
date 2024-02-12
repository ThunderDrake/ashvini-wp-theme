<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

use Elementor\Plugin;

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
?>

<div class="container notices-container">

    <?php

    do_action('woocommerce_before_single_product');

    if (post_password_required()) {
        echo get_the_password_form(); // WPCS: XSS ok.
        return;
    }

    ?>

</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <div class="inner-product container">

        <div class="gallery-wrapper">

            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>

        </div>

        <div class="summary entry-summary">
            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action('woocommerce_single_product_summary');
            ?>

            <?php
            /**
             * Hook: woocommerce_after_single_product_summary.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action('woocommerce_after_single_product_summary');
            ?>

        </div>

    </div>

    <?php

    if (class_exists('FSD_Core') && function_exists('elementor_load_plugin_textdomain')):

        $after_template = FSD_Helper::get_field('field_after_content');

        if (!empty($after_template)):

            ?>

            <div class="after-content">

                <?php echo Elementor\Plugin::$instance->frontend->get_builder_content($after_template); ?>

            </div>

        <?php

        endif;

    endif;

    $related_toggle = get_theme_mod('shop-related-products', esc_attr('1'));

    $upsells_toggle = get_theme_mod('shop-upsells-products', esc_attr('1'));

    if ($related_toggle || $upsells_toggle):

        ?>

        <div class="product-bottom-side container">

            <?php

            if ($upsells_toggle):

                woocommerce_upsell_display();

            endif;

            if ($related_toggle):

                $related_args = array();

                $related_args['posts_per_page'] = get_theme_mod('shop-number-of-related-items', esc_attr('4'));

                $related_args['columns'] = get_theme_mod('shop-number-of-related-column', esc_attr('4'));

                woocommerce_related_products($related_args);

            endif;

            ?>

        </div>

    <?php endif; ?>

</div>

<div class="container">

    <?php do_action('woocommerce_after_single_product'); ?>

</div>