<?php defined('ABSPATH') || exit;

?>
	
	<!doctype html>
	
	<!-- html -->
<html <?php language_attributes(); ?>>
	
	<!-- head -->
	<head>
		
		<!-- charset -->
		<meta charset="<?php bloginfo('charset'); ?>" />
		
		<!-- viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<!-- profile -->
		<link rel="profile" href="https://gmpg.org/xfn/11" />
		
		<?php
		
		/* wp_head */
		wp_head();
		
		?>
	
	</head>
	<!-- /head -->

<body <?php

/* body_class */
body_class();

?>>

<?php

/* wp_body_open */
wp_body_open();

$classes = [];

$navigation_top_banner_toggle = get_theme_mod('navigation-top-banner-toggle', esc_attr(0));

$navigation_type = get_theme_mod('navigation-type', esc_attr('type-1'));

if (!empty($_GET['navigation_type'])):
	
	$navigation_type = $_GET['navigation_type'];

endif;


$navigation_state = get_theme_mod('navigation-state', esc_attr('sticky'));


if (!empty($_GET['navigation_state'])):
	
	$navigation_state = $_GET['navigation_state'];

endif;


$navigation_style = get_theme_mod('navigation-style', esc_attr('light'));


if (!empty($_GET['navigation_style'])):
	
	$navigation_style = $_GET['navigation_style'];

endif;


$navigation_scroll_animation = get_theme_mod('navigation-scroll-animation', esc_attr('none'));


if (!empty($_GET['navigation_animation'])):
	
	$navigation_scroll_animation = $_GET['navigation_animation'];

endif;


$navigation_scroll_animation_additional = get_theme_mod('navigation-scroll-animation-additional', esc_attr('none'));


if (!empty($_GET['navigation_animation'])):
	
	$navigation_scroll_animation_additional = $_GET['navigation_animation'];

endif;


$navigation_authorization_toggle = get_theme_mod('navigation-authorization-toggle', esc_attr(1));

$navigation_search_button_toggle = get_theme_mod('navigation-search-button-toggle', esc_attr(1));

array_push($classes, esc_attr('global-navigation-' . $navigation_type));

array_push($classes, esc_attr('global-navigation-' . $navigation_style));

if ($navigation_top_banner_toggle):
	
	array_push($classes, esc_attr('global-top-banner-enabled'));

endif;

if ($navigation_state === 'sticky' && $navigation_style === 'transparent' || $navigation_style === 'transparent-light'):
	
	array_push($classes, esc_attr('global-scroll-animation-' . $navigation_scroll_animation));

endif;

if ($navigation_state === 'sticky' && $navigation_style === 'light' || $navigation_style === 'dark'):
	
	array_push($classes, esc_attr('global-scroll-animation-' . $navigation_scroll_animation_additional));

endif;

get_template_part('template-parts/navigation/navigation-mobile');

if ($navigation_authorization_toggle):
	
	get_template_part('template-parts/navigation/authorization-modal');

endif;

if ($navigation_search_button_toggle):
	
	get_template_part('template-parts/navigation/search-overlay');

endif;

if (class_exists('WooCommerce') && class_exists('FSD_Core')):
	
	if (class_exists('WOOF')):
		
		get_template_part('template-parts/woocommerce/shop-filter');
	
	endif;
	
	get_template_part('template-parts/woocommerce/single-product-gallery');

endif;

$classes = implode(' ', $classes);

if (class_exists('FSD_Core')):
	
	?>
	
	<div class="page-overlay">
	
	</div>

<?php endif; ?>
	
	<!-- main wrapper -->
<div class="main-wrapper <?php echo esc_attr($classes); ?>">

<?php if (class_exists('WooCommerce')):
	
	if (!is_cart() && !is_checkout() && !is_account_page() && !is_product() && !is_shop() && !is_product_taxonomy()):
		
		?>
		
		<div class="global-notification-wrapper">
		
		</div>
	
	<?php
	
	endif;

endif;

/* include navigation */
get_template_part('template-parts/navigation/navigation');

if (class_exists('WooCommerce')):
	
	/* additional woocommerce check */
	if (is_cart() || is_checkout() || is_account_page() || is_product() || is_shop() || is_product_taxonomy()):
		
		/* reset postdata */
		wp_reset_postdata();
		
		$shop_header_trigger = false;
		
		if (is_shop() || is_product_taxonomy()):
			
			$shop_header_trigger = get_theme_mod('shop-header', esc_attr(1));
			
			$shop_header_type = get_theme_mod('shop-header-type', esc_attr('default'));
		
		endif;
		
		$classes = [];
		
		if (!$shop_header_trigger):
			
			array_push($classes, esc_attr('shop-without-header'));
		
		endif;
		
		if (is_shop() || is_product_taxonomy()):
			
			array_push($classes, esc_attr('shop-wrapper'));
			
			if ($shop_header_trigger && $shop_header_type === 'image'):
				
				array_push($classes, esc_attr('shop-wrapper-image-header'));
			
			endif;
		
		endif;
		
		if (is_product()):
			
			array_push($classes, esc_attr('product-wrapper'));
		
		endif;
		
		if (is_checkout()):
			
			array_push($classes, esc_attr('checkout-wrapper'));
		
		endif;
		
		if (is_cart() && !WC()->cart->is_empty()):
			
			array_push($classes, esc_attr('cart-wrapper'));
		
		endif;
		
		if (is_account_page()):
			
			array_push($classes, esc_attr('account-wrapper'));
			
			if (is_user_logged_in()):
				
				array_push($classes, esc_attr('log-in'));
			
			endif;
		
		endif;
		
		$classes = implode(' ', $classes);
		
		?>
		
		<div class="woocommerce-wrapper <?php echo esc_attr($classes); ?>">
		
		<div class="inner-wrapper <?php if (!is_product() && !is_shop() && !is_product_taxonomy()): ?>container<?php endif; ?>">
	
	<?php
	
	endif;
	
	if (function_exists('tinv_get_option_defaults')):
		
		if (is_wishlist() && get_the_permalink() === tinv_url_wishlist_default()):
			
			?>
			
			<div class="woocommerce-wrapper wishlist-wrapper">
				
				<div class="inner-wrapper container">
		
		<?php
		
		endif;
	
	endif;

endif;