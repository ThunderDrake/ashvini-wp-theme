<?php defined('ABSPATH') || exit;

$shop_filter_sidebar = get_theme_mod('shop-filter-sidebar', esc_attr(1));

if (!empty($_GET['shop_filter'])):
	
	$shop_filter_sidebar = $_GET['shop_filter'];

endif;

$shop_filter_sidebar_type = get_theme_mod('shop-filter-sidebar-type', esc_attr('fixed'));


if (!empty($_GET['shop_filter_type'])):
	
	$shop_filter_sidebar_type = $_GET['shop_filter_type'];

endif;


if ($shop_filter_sidebar && is_active_sidebar('shop-filters-sidebar') && class_exists('WooCommerce') && is_shop() || is_product_taxonomy()):
	
	?>
	
	<div class="fixed-filter-sidebar-overlay"></div>
	
	<div class="fixed-filter-sidebar">
		
		<div class="sidebar-header">
			
			<h4 class="filter-title">
				
				<?php echo esc_html__('Filters', 'levre'); ?>
			
			</h4>
			
			<div class="close-button">
				
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
				     alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
			
			</div>
		
		</div>
		
		<div class="sidebar-inner">
			
			<?php
			
			dynamic_sidebar('shop-filters-sidebar');
			
			?>
		
		</div>
	
	</div>

<?php

endif;

?>