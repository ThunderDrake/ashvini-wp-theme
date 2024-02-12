<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if (!defined('ABSPATH')) {
    exit;
}

if (is_product()):

    ?>

    <div class="container">

<?php

endif;

if (!empty($breadcrumb)) {

    echo FSD_Theme::check_for_empty($wrap_before);

    foreach ($breadcrumb as $key => $crumb) {

        echo FSD_Theme::check_for_empty($before);

        if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
            echo '<a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a>';
        } else {
            echo esc_html($crumb[0]);
        }

        echo FSD_Theme::check_for_empty($after);

        if (sizeof($breadcrumb) !== $key + 1) {
            echo FSD_Theme::check_for_empty($delimiter);
        }
    }

    echo FSD_Theme::check_for_empty($wrap_after);

}

if (is_product()):

    ?>

    </div>

<?php

endif;
