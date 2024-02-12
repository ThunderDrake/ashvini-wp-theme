<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

$shop_filter_sidebar = get_theme_mod('shop-filter-sidebar', esc_attr(1));


if (!empty($_GET['shop_filter'])):

    $shop_filter_sidebar = $_GET['shop_filter'];

endif;


$shop_filter_sidebar_type = get_theme_mod('shop-filter-sidebar-type', esc_attr('fixed'));


if (!empty($_GET['shop_filter_type'])):

    $shop_filter_sidebar_type = $_GET['shop_filter_type'];

endif;


get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action('woocommerce_archive_description');

if (woocommerce_product_loop()) { ?>

    <?php

    $header_trigger = get_theme_mod('shop-header', esc_attr(1));


    if (!empty($_GET['shop_header'])):

        $header_trigger = $_GET['shop_header'];

    endif;


    if ($header_trigger):

        $shop_header_bg = '';

        $shop_header_type = get_theme_mod('shop-header-type', esc_attr('default'));


        if (!empty($_GET['shop_header_type'])):

            $shop_header_type = $_GET['shop_header_type'];

        endif;


        $shop_title = get_theme_mod('shop-title', esc_html__('Carefully selected beauty products', 'levre'));

        $shop_subtitle = get_theme_mod('shop-subtitle', esc_html__('Our team carefully selects only the best products that have toxic-free formulas and are not tested on animals.', 'levre'));

        if ($shop_header_type === 'image'):

            $shop_header_bg = get_theme_mod('shop-header-bg');

        endif;

        ?>

        <header class="shop-archive-header <?php echo esc_attr('header-type-' . $shop_header_type); ?>">

        <div class="top-side <?php echo esc_attr($shop_header_type); ?>">

            <div class="container">

                <h1 class="shop-title">

                    <?php echo esc_html($shop_title); ?>

                </h1>

                <p class="shop-subtitle">

                    <?php echo esc_html($shop_subtitle); ?>

                </p>

            </div>

        </div>

    <?php endif; ?>

    <div class="bottom-side">

        <div class="container">

            <div class="left-side">

                <?php

                if (class_exists('FSD_Helper')):

                    FSD_Helper::the_breadcrumbs();

                endif;

                ?>

            </div>

            <div class="right-side">

                <?php

                woocommerce_catalog_ordering();

                ?>

                <div class="toggle-wrapper <?php if ($shop_filter_sidebar_type === 'fixed' && $shop_filter_sidebar && class_exists('WOOF')): ?> not-only-mobile <?php endif; ?>">

                    <button class="fs-button dark-border-style filter-sidebar-toggle ">

                        <?php echo esc_html__('Filter', 'levre'); ?>

                    </button>

                </div>

            </div>

        </div>

    </div>

    </header>

    <div class="container loop-container">

        <div class="shop-loop-wrapper">

            <?php

            if ($shop_filter_sidebar_type === 'default' && $shop_filter_sidebar && is_active_sidebar('shop-filters-sidebar')):

                ?>

                <div class="filter-sidebar">

                    <div class="sidebar-inner">

                        <?php

                        dynamic_sidebar('shop-filters-sidebar');

                        ?>

                    </div>

                </div>

            <?php

            endif;

            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');

            if (is_product_category()):

                $category = get_queried_object();

            endif;

            ?>

            <div class="loop-inner"
                 <?php if (!empty($orderby)): ?>data-sorting="<?php echo esc_attr($orderby); ?>"<?php endif; ?>
                 <?php if (!empty($category)): ?>data-category="<?php echo esc_attr($category->slug); ?>"<?php endif; ?>>

                <?php

                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');

                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();

                /**
                 * Hook: woocommerce_after_shop_loop.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action('woocommerce_after_shop_loop');

                ?>

            </div>

        </div>

    </div>

    <?php

} else {
    ?>

    <div class="container">

        <?php

        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action('woocommerce_no_products_found');

        ?>

    </div>

    <?php
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');