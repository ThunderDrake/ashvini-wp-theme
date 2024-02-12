<?php defined('ABSPATH') || exit;

if (class_exists('WooCommerce')):
	
	$cart_count = WC()->cart->cart_contents_count;

endif;

$logotype = get_theme_mod('branding-logotype', esc_url(get_template_directory_uri() . '/assets/img/logo.svg'));

$logotype_white = get_theme_mod('branding-logotype-white', esc_url(get_template_directory_uri() . '/assets/img/logo.svg'));

$logotype_width = get_theme_mod('branding-logotype-width', esc_attr('93'));

if (!empty($_GET['logotype_width'])):
	
	$logotype_width = $_GET['logotype_width'];

endif;

$navigation_type = get_theme_mod('navigation-type', esc_attr('type-1'));

if (class_exists('FSD_Helper') && !empty(FSD_Helper::get_field('field_navigation_type')) && FSD_Helper::get_field('field_navigation_type') !== 'default'):
	
	$navigation_type = FSD_Helper::get_field('field_navigation_type');

endif;

if (!empty($_GET['navigation_type'])):
	
	$navigation_type = $_GET['navigation_type'];

endif;

$navigation_style = get_theme_mod('navigation-style', esc_attr('light'));

if (class_exists('FSD_Helper') && !empty(FSD_Helper::get_field('field_navigation_style')) && FSD_Helper::get_field('field_navigation_style') !== 'default'):
	
	$navigation_style = FSD_Helper::get_field('field_navigation_style');

endif;

if (!empty($_GET['navigation_style'])):
	
	$navigation_style = $_GET['navigation_style'];

endif;

$navigation_state = get_theme_mod('navigation-state', esc_attr('sticky'));

if (!empty($_GET['navigation_state'])):
	
	$navigation_state = $_GET['navigation_state'];

endif;

$navigation_scroll_animation = get_theme_mod('navigation-scroll-animation', esc_attr('fill'));

if (!empty($_GET['navigation_animation'])):
	
	$navigation_scroll_animation = $_GET['navigation_animation'];

endif;

$navigation_scroll_animation_additional = get_theme_mod('navigation-scroll-animation-additional', esc_attr('fill'));


if (!empty($_GET['navigation_animation'])):
	
	$navigation_scroll_animation_additional = $_GET['navigation_animation'];

endif;

$megamenu_style = get_theme_mod('megamenu-style', esc_attr('style-1'));

if (!empty($_GET['megamenu_style'])):
	
	$megamenu_style = $_GET['megamenu_style'];

endif;

$megamenu_layout = get_theme_mod('megamenu-layout', esc_attr('wide'));

if (!empty($_GET['megamenu_layout'])):
	
	$megamenu_layout = $_GET['megamenu_layout'];

endif;

$navigation_logotype_toggle = get_theme_mod('navigation-logotype-toggle', esc_attr(1));

$navigation_shopping_bag_toggle = get_theme_mod('navigation-shopping-bag-toggle', esc_attr(1));

$navigation_shopping_bag_icon = get_theme_mod('navigation-shopping-bag-icon');

$navigation_shopping_bag_icon_white = get_theme_mod('navigation-shopping-bag-icon-white');

$navigation_shopping_bag_icon_width = get_theme_mod('navigation-shopping-bag-icon-width');

$navigation_shopping_bag_type = get_theme_mod('shopping-bag-type', esc_attr('static'));

$navigation_authorization_toggle = get_theme_mod('navigation-authorization-toggle', esc_attr(1));

$navigation_search_button_toggle = get_theme_mod('navigation-search-button-toggle', esc_attr(1));

$navigation_wishlist_toggle = get_theme_mod('navigation-wishlist-toggle', esc_attr(1));

$navigation_top_banner_toggle = get_theme_mod('navigation-top-banner-toggle', esc_attr(0));

$navigation_top_banner_offer_text = get_theme_mod('navigation-top-banner-offer-text', esc_html__('PRESIDENTS’ DAY SALE: Save up to $200 with code PREZ200. Ends 2/20.', 'levre'));

$navigation_top_banner_button_text = get_theme_mod('navigation-top-banner-button-text', esc_html__('Learn More', 'levre'));

$navigation_top_banner_button_link = get_theme_mod('navigation-top-banner-button-link', esc_attr('#'));

$navigation_top_banner_button_link_target = get_theme_mod('navigation-top-banner-button-link-target', esc_attr('self'));

$classes = [];

array_push($classes, 'navigation-' . esc_attr($navigation_type));

array_push($classes, 'navigation-' . esc_attr($navigation_style));

array_push($classes, 'navigation-' . esc_attr($navigation_state));

array_push($classes, 'megamenu-' . esc_attr($megamenu_style));

array_push($classes, 'megamenu-' . esc_attr($megamenu_layout));

array_push($classes, 'shopping-bag-' . esc_attr($navigation_shopping_bag_type));

if ($navigation_state === 'sticky' && $navigation_style === 'transparent' || $navigation_style === 'transparent-light'):
	
	array_push($classes, 'scroll-animation-' . esc_attr($navigation_scroll_animation));

endif;

if ($navigation_state === 'sticky' && $navigation_style === 'light' || $navigation_style === 'dark'):
	
	array_push($classes, 'scroll-animation-' . esc_attr($navigation_scroll_animation_additional));

endif;

$classes = implode(' ', $classes);

?>

<nav class="navigation <?php echo esc_attr($classes); ?>">
	
	<?php if ($navigation_top_banner_toggle): ?>
		
		<div class="top-banner">
			
			<?php if (!empty($navigation_top_banner_offer_text)): ?>
				
				<p class="offer-text">
					
					<?php echo esc_html($navigation_top_banner_offer_text); ?>
					
					<?php if (!empty($navigation_top_banner_button_text) && !empty($navigation_top_banner_button_link)): ?>
						
						<a href="<?php echo esc_url($navigation_top_banner_button_link); ?>"
						   target="<?php echo esc_attr($navigation_top_banner_button_link_target); ?>"
						   class="offer-link">
							
							<?php echo esc_html($navigation_top_banner_button_text); ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/link-arrow.svg'); ?>"
							     alt="<?php echo esc_attr__('Arrow', 'levre'); ?>">
						
						</a>
					
					<?php endif; ?>
				
				</p>
			
			<?php endif; ?>
			
			<div class="close-button">
				
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
				     alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
			
			</div>
		
		</div>
	
	<?php endif; ?>
	
	<div class="inner-wrapper">
		
		<div class="navigation-inner container-fluid">
			
			<?php if ($navigation_type === 'type-2' && class_exists('WooCommerce') && function_exists('tinv_url_wishlist_default')): ?>
				
				<a class="wishlist-toggle" href="<?php echo esc_url(tinv_url_wishlist_default()); ?>">
					
					<?php if ($navigation_style === 'light' || $navigation_style === 'transparent'): ?>
						
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-1.svg'); ?>"
						     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>">
					
					<?php elseif ($navigation_style === 'dark' || $navigation_style === 'transparent-light'): ?>
						
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/wishlist-black.svg'); ?>"
						     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>" class="show-icon">
						
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-1.svg'); ?>"
						     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>" class="hidden-icon">
					
					<?php endif; ?>
				
				</a>
			
			<?php endif; ?>
			
			<?php if ($navigation_logotype_toggle): ?>
				
				<!-- theme logotype -->
				<div class="theme-logo">
					
					<a href="<?php echo esc_url(home_url('/')); ?>">
						
						<?php if (!empty($logotype)): ?>
							
							<?php if ($navigation_style === 'transparent-light'): ?>
								
								<img src="<?php echo esc_url($logotype); ?>" class="hidden-icon"
								     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
								>
								
								<img src="<?php echo esc_url($logotype_white); ?>"
								     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
								     class="show-icon">
							
							<?php else: ?>
								
								<img src="<?php echo esc_url($logotype); ?>"
								     alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
							
							<?php endif; ?>
						
						<?php else: ?>
							
							<h3 class="site-name">
								
								<?php echo esc_html(get_bloginfo()); ?>
							
							</h3>
						
						<?php endif; ?>
					
					</a>
				
				</div>
			
			<?php endif; ?>
			
			<?php if ($navigation_type === 'type-1'): ?>
				
				<div class="menu-list-wrapper">
					
					<?php
					
					if (has_nav_menu('primary_menu')) :
						
						wp_nav_menu([
								'theme_location' => 'primary_menu',
								'menu' => 'primary_menu',
								'menu_class' => 'menu-list',
								'container' => '',
								'walker' => new FSD_Walker()
						]);
					
					endif;
					
					?>
				
				</div>
			
			<?php endif; ?>
			
			<div class="action-wrapper">
				
				<?php if ($navigation_search_button_toggle): ?>
					
					<div class="search-toggle action-toggle">
						
						<?php if ($navigation_style === 'light' || $navigation_style === 'transparent'): ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search.svg'); ?>"
							     alt="<?php echo esc_attr__('Search icon', 'levre'); ?>">
						
						<?php elseif ($navigation_style === 'dark' || $navigation_style === 'transparent-light'): ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-black.svg'); ?>"
							     alt="<?php echo esc_attr__('Search icon', 'levre'); ?>" class="show-icon">
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search.svg'); ?>"
							     alt="<?php echo esc_attr__('Search icon', 'levre'); ?>" class="hidden-icon">
						
						<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if ($navigation_wishlist_toggle && $navigation_type !== 'type-2' && class_exists('WooCommerce') && function_exists('tinv_get_option_defaults')): ?>
					
					<a class="wishlist-toggle action-toggle" href="<?php echo esc_url(tinv_url_wishlist_default()); ?>">
						
						<?php if ($navigation_style === 'light' || $navigation_style === 'transparent'): ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-1.svg'); ?>"
							     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>">
						
						<?php elseif ($navigation_style === 'dark' || $navigation_style === 'transparent-light'): ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/wishlist-black.svg'); ?>"
							     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>" class="show-icon">
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-1.svg'); ?>"
							     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>" class="hidden-icon">
						
						<?php endif; ?>
					
					</a>
				
				<?php endif; ?>
				
				<?php if ($navigation_authorization_toggle && class_exists('WooCommerce')): ?>
					
					<div class="authorization-toggle action-toggle <?php if (is_user_logged_in()): ?> authorized <?php endif; ?>">
						
						<?php if (is_user_logged_in()): ?>
					
					<?php
					
					$myaccount_page = get_option('woocommerce_myaccount_page_id');
					
					$myaccount_page_url = get_permalink($myaccount_page);
					
					?>
						
						<a href="<?php echo esc_url($myaccount_page_url); ?>">
							
							<?php endif; ?>
							
							<?php if ($navigation_style === 'light' || $navigation_style === 'transparent'): ?>
								
								<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-2.svg'); ?>"
								     alt="<?php echo esc_attr__('Authorization icon', 'levre'); ?>">
							
							<?php elseif ($navigation_style === 'dark' || $navigation_style === 'transparent-light'): ?>
								
								<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/user-black.svg'); ?>"
								     alt="<?php echo esc_attr__('Authorization icon', 'levre'); ?>" class="show-icon">
								
								<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-2.svg'); ?>"
								     alt="<?php echo esc_attr__('Authorization icon', 'levre'); ?>" class="hidden-icon">
							
							<?php endif; ?>
							
							<?php if (is_user_logged_in()): ?>
						
						</a>
					
					<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if ($navigation_shopping_bag_toggle && class_exists('WooCommerce')): ?>
					
					<div class="shopping-bag-toggle action-toggle">
						
						<?php if (empty($navigation_shopping_bag_icon)): ?>
							
							<?php echo esc_html__('Bag', 'levre'); ?>
						
						<?php else: ?>
							
							<?php if ($navigation_style === 'light' || $navigation_style === 'transparent'): ?>
								
								<img src="<?php echo esc_url($navigation_shopping_bag_icon); ?>"
										<?php if (!empty($navigation_shopping_bag_icon_width) && $navigation_shopping_bag_icon_width > 1): ?>
											style="width: <?php echo esc_attr($navigation_shopping_bag_icon_width); ?>px;"
										<?php endif; ?>
                                     alt="<?php echo esc_attr__('Bag', 'levre'); ?>" class="bag-icon">
							
							<?php elseif ($navigation_style === 'dark' || $navigation_style === 'transparent-light'): ?>
								
								<img src="<?php echo esc_url($navigation_shopping_bag_icon); ?>"
										<?php if (!empty($navigation_shopping_bag_icon_width) && $navigation_shopping_bag_icon_width > 1): ?>
											style="width: <?php echo esc_attr($navigation_shopping_bag_icon_width); ?>px;"
										<?php endif; ?>
                                     alt="<?php echo esc_attr__('Bag', 'levre'); ?>" class="bag-icon hidden-icon">
								
								<img src="<?php echo esc_url($navigation_shopping_bag_icon_white); ?>"
										<?php if (!empty($navigation_shopping_bag_icon_width) && $navigation_shopping_bag_icon_width > 1): ?>
											style="width: <?php echo esc_attr($navigation_shopping_bag_icon_width); ?>px;"
										<?php endif; ?>
                                     alt="<?php echo esc_attr__('Bag', 'levre'); ?>" class="bag-icon show-icon">
							
							<?php endif; ?>
						
						<?php endif; ?>
						
						<p class="cart-count">
							
							<?php echo esc_html(WC()->cart->cart_contents_count); ?>
						
						</p>
					
					</div>
				
				<?php endif; ?>
			
			</div>
		
		</div>
		
		<?php if (class_exists('WooCommerce')): ?>
			
			<div class="shopping-bag-panel">
				
				<div class="inner-bag <?php if ($cart_count === 0): ?> empty-cart-state <?php endif; ?>">
					
					<div class="bag-header">
						
						<p class="before-count">
							
							<?php echo esc_html__('Your Bag', 'levre'); ?>
						
						</p>
						
						<?php if ($cart_count > 0): ?>
							
							<p class="count">

                                <span class="cart-count">

                                    <?php echo esc_html($cart_count); ?>

                                </span>
								
								<?php echo esc_html__('Items', 'levre'); ?>
							
							</p>
						
						<?php endif; ?>
						
						<div class="close-button">
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
							     alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
						
						</div>
					
					</div>
					
					<div class="bag-body">
						
						<?php if ($navigation_shopping_bag_type === 'static'): ?>
							
							<div class="products-list">
								
								<?php
								
								wp_reset_postdata();
								
								$items = WC()->cart->get_cart();
								
								foreach ($items as $item => $values) :
									
									$product_id = $values['data']->get_id();
									
									$product = wc_get_product($product_id);
									
									$title = $product->get_title();
									
									$image_id = $product->get_image_id();
									
									$quantity = $values['quantity'];
									
									?>
									
									<article class="product" data-product-id="<?php echo esc_attr($product_id); ?>">
										
										<div class="product-image">
											
											<?php
											if (class_exists('FSD_Helper')):
												echo FSD_Helper::render_image($image_id,
														'thumbnail',
														['sizes' => implode(',', [
																'(max-width: 300px) 300px',
														]),
																'srcset' => implode(',', [
																		esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')) . ' 300w',
																]),
																'loading' => 'lazy',
																'alt' => get_the_title()
														], false);
											else:
												
												?>
												
												<img src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'large')); ?>"
												     alt="<?php echo esc_attr(get_the_title()); ?>">
											
											<?php
											
											endif;
											
											?>
											
											<a href="<?php echo esc_url($product->get_permalink()); ?>"
											   class="link-overlay"></a>
										
										</div>
										
										<div class="product-body">
											
											<h6 class="product-title">
												
												<a href="<?php echo esc_url($product->get_permalink()); ?>">
													
													<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
												
												</a>
											
											</h6>
											
											<p class="product-price">
												
												<?php echo FSD_Theme::check_for_empty($product->get_price_html()); ?>
											
											</p>
											
											<div class="custom-quantity-input-wrapper">
												
												<p class="pre">
													
													<?php echo esc_html__('Quantity', 'levre'); ?>
												
												</p>
												
												<div class="quantity-inner">
													
													<button class="decrease">
														
														<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/chevron.svg'); ?>"
														     alt="<?php echo esc_attr__('Chevron Left', 'levre'); ?>">
													
													</button>
													
													<input type="number" class="quantity-input" min="1"
													       value="<?php echo esc_attr($quantity); ?>">
													
													<button class="increase">
														
														<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/chevron.svg'); ?>"
														     alt="<?php echo esc_attr__('Chevron Right', 'levre'); ?>">
													
													</button>
												
												</div>
											
											</div>
											
											<div class="product-remote-button">
												
												<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
												     alt="<?php echo esc_attr__('Remove Icon', 'levre'); ?>">
											
											</div>
										
										</div>
									
									</article>
								
								<?php
								
								endforeach;
								
								wp_reset_postdata();
								
								?>
							
							</div>
						
						<?php else: ?>
						
						
						<?php endif; ?>
					
					</div>
					
					<p class="loading-message">
						
						<?php echo esc_html__('Loading', 'levre'); ?>
					
					</p>
					
					<div class="bag-footer">
						
						<div class="subtotal">
							
							<p>
								
								<?php echo esc_html__('Subtotal:', 'levre'); ?>
							
							</p>
							
							<span class="subtotal-value">

                              <?php echo WC()->cart->get_cart_total(); ?>

                        </span>
						
						</div>
						
						<div class="links">
							
							<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="fs-button dark-border-style">
								
								<?php echo esc_html__('View Bag', 'levre'); ?>
							
							</a>
							
							<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="fs-button dark-style">
								
								<?php echo esc_html__('Checkout', 'levre'); ?>
							
							</a>
						
						</div>
					
					</div>
					
					<div class="empty-cart">
						
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/empty-cart.svg'); ?>"
						     alt="<?php echo esc_attr__('Empty Cart', 'levre'); ?>">
						
						<p class="empty-message">
							
							<?php echo esc_html__('Your bag is empty', 'levre'); ?>
						
						</p>
					
					</div>
				
				</div>
			
			</div>
		
		<?php endif; ?>
	
	</div>
	
	<?php if ($navigation_type === 'type-2'): ?>
		
		<div class="menu-list-wrapper">
			
			<?php
			
			if (has_nav_menu('primary_menu')) :
				
				wp_nav_menu([
						'theme_location' => 'primary_menu',
						'menu' => 'primary_menu',
						'menu_class' => 'menu-list',
						'container' => '',
						'walker' => new FSD_Walker()
				]);
			
			endif;
			
			?>
		
		</div>
	
	<?php endif; ?>

</nav>