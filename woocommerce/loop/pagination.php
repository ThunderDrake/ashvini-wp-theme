<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if (!defined('ABSPATH')) {
    exit;
}

$total = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format = isset($format) ? $format : '';

if ($total <= 1) {
    return;
}

$pagination_type = get_theme_mod('shop-pagination-type', esc_attr('default'));

if (!empty($_GET['shop_pagination_type'])):

    $pagination_type = $_GET['shop_pagination_type'];

endif;

?>
<nav class="fs-woocommerce-pagination">

    <?php

    if ($pagination_type === 'default'):

        echo paginate_links(
            apply_filters(
                'woocommerce_pagination_args',
                array( // WPCS: XSS ok.
                    'base' => $base,
                    'format' => $format,
                    'add_args' => false,
                    'current' => max(1, $current),
                    'total' => $total,
                    'prev_text' => '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/right-pagination-arrow.svg') . '"
                             alt="' . esc_attr__('Next', 'levre') . '" class="next-arrow">',
                    'next_text' => '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/right-pagination-arrow.svg') . '"
                             alt="' . esc_attr__('Next', 'levre') . '" class="next-arrow">',
                    'type' => 'list',
                    'end_size' => 1,
                    'mid_size' => 5,
                )
            )
        );

    elseif ($pagination_type === 'load-more'):

        ?>

        <button class="fs-button dark-border-style load-more-button">

            <?php echo esc_html__('Load More', 'levre'); ?>

        </button>

    <?php

    endif;

    ?>

</nav>
