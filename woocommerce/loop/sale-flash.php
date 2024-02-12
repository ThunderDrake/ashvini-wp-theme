<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$labels_toggle = get_theme_mod('shop-labels',1);

global $post, $product;

if($labels_toggle):

?>
    <div class="badges-wrapper">

        <?php

        $newness_days = (int)get_theme_mod('shop-newest-items-treshhold', esc_attr('3'));

        $field_new_label = false;

        if (class_exists('FSD_Helper')):

            $field_new_label = FSD_Helper::get_field('field_new_label', get_the_ID());

        endif;

        $created = strtotime($product->get_date_created());

        if ((time() - (60 * 60 * 24 * $newness_days)) < $created || $field_new_label) :

            echo '<span class="itsnew">' . esc_html__('New!', 'levre') . '</span>';

        endif;

        if (!$product->is_in_stock()) :

            echo '<span class="sold-out-badge">' . esc_html__("Sold Out", "levre") . '</span>';

        endif;

        if ($product->is_on_sale()) :

            echo apply_filters('woocommerce_sale_flash', '<span class="onsale">' . esc_html__('Sale!', 'levre') . '</span>', $post, $product);

        endif;

        ?>

    </div>

<?php

endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
