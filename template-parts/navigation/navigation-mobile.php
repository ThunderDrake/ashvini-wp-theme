<?php defined('ABSPATH') || exit;

if (class_exists('WooCommerce')):
	
	$cart_count = WC()->cart->cart_contents_count;

endif;

$logotype = get_theme_mod('branding-logotype', esc_url(get_template_directory_uri() . '/assets/img/logo.svg'));

$logotype_white = get_theme_mod('branding-logotype-white', esc_url(get_template_directory_uri() . '/assets/img/logo.svg'));

$logotype_width = get_theme_mod('branding-logotype-width', esc_attr('93'));

$navigation_type = get_theme_mod('navigation-type', esc_attr('type-1'));

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

array_push($classes, esc_attr('shopping-bag-' . $navigation_shopping_bag_type));

if ($navigation_top_banner_toggle):
	
	array_push($classes, esc_attr('global-top-banner-enabled'));

endif;

array_push($classes, esc_attr('navigation-' . $navigation_style));

$classes = implode(' ', $classes);

?>

<nav class="navigation-mobile <?php echo esc_attr($classes); ?>">
	
	<div class="inner-wrapper">
		
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
		
		<div class="menu-actions-wrapper">
			
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
								
								<?php if ($navigation_style === 'dark'): ?>
									
									<img src="<?php echo esc_url($logotype_white); ?>"
									     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
									>
								
								<?php else: ?>
									
									<img src="<?php echo esc_url($logotype); ?>"
									     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
									>
								
								<?php endif; ?>
							
							<?php endif; ?>
						
						<?php else: ?>
							
							<h3 class="site-name">
								
								<?php echo esc_html(get_bloginfo()); ?>
							
							</h3>
						
						<?php endif; ?>
					
					</a>
				
				</div>
			
			<?php endif; ?>
			
			<div class="right-side">
				
				<?php if ($navigation_shopping_bag_toggle && class_exists('WooCommerce')): ?>
					
					<div class="shopping-bag-toggle">
						
						<?php if ($navigation_style === 'transparent-light'): ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/cart-icon.svg'); ?>"
							     alt="<?php echo esc_attr__('Bag icon', 'levre'); ?>" class="hidden-icon">
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/cart-icon-white.svg'); ?>"
							     alt="<?php echo esc_attr__('Bag icon', 'levre'); ?>" class="show-icon">
						
						<?php else: ?>
							
							<?php if ($navigation_style === 'dark'): ?>
								
								<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/cart-icon-white.svg'); ?>"
								     alt="<?php echo esc_attr__('Bag icon', 'levre'); ?>">
							
							<?php else: ?>
								
								<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/cart-icon.svg'); ?>"
								     alt="<?php echo esc_attr__('Bag icon', 'levre'); ?>">
							
							<?php endif; ?>
						
						<?php endif; ?>
						
						<p class="cart-count">
							
							<?php echo esc_html(WC()->cart->cart_contents_count); ?>
						
						</p>
					
					</div>
				
				<?php endif; ?>
				
				<div class="menu-toggle">

            <span class="open-toggle">

                 <?php if ($navigation_style === 'transparent-light'): ?>
	
	                 <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/bars.svg'); ?>"
	                      alt="<?php echo esc_attr__('Bars icon', 'levre'); ?>" class="hidden-icon">
	
	                 <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/bars-white.svg'); ?>"
	                      alt="<?php echo esc_attr__('Bars icon', 'levre'); ?>" class="show-icon">

                 <?php else: ?>
	
	                 <?php if ($navigation_style === 'dark'): ?>
		
		                 <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/bars-white.svg'); ?>"
		                      alt="<?php echo esc_attr__('Bars icon', 'levre'); ?>">
	
	                 <?php else: ?>
		
		                 <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/bars.svg'); ?>"
		                      alt="<?php echo esc_attr__('Bars icon', 'levre'); ?>">
	
	                 <?php endif; ?>

                 <?php endif; ?>

            </span>
					
					<span class="close-toggle">

                      <?php if ($navigation_style === 'transparent-light'): ?>
	
	                      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
	                           alt="<?php echo esc_attr__('Close icon', 'levre'); ?>" class="hidden-icon">
	
	                      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close-white.svg'); ?>"
	                           alt="<?php echo esc_attr__('Close icon', 'levre'); ?>" class="show-icon">

                      <?php else: ?>
	
	                      <?php if ($navigation_style === 'dark'): ?>
		
		                      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close-white.svg'); ?>"
		                           alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
	
	                      <?php else: ?>
		
		                      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
		                           alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
	
	                      <?php endif; ?>

                      <?php endif; ?>

            </span>
				
				</div>
			
			</div>
		
		</div>
	
	</div>
	
	<div class="menu-panel">
		
		<div class="inner-panel">
			
			<div class="search-form-wrapper">
				
				<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
					
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search.svg'); ?>"
					     alt="<?php echo esc_attr('Search Icon', 'levre'); ?>" class="search">
					
					<!-- search-field -->
					<input type="search" class="search-field"
					       placeholder="<?php echo esc_attr__('Search', 'levre'); ?>"
					       value="<?php echo get_search_query(); ?>" name="s"
					       title="<?php echo esc_attr__('Search', 'levre'); ?>">
				
				</form>
			
			</div>
			
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
			
			<div class="actions-wrapper">
				
				<?php if ($navigation_authorization_toggle): ?>
					
					<div class="authorization-toggle action-toggle">
						
						<?php if (is_user_logged_in()): ?>
						
						<a href="<?php echo esc_url(get_author_posts_url(get_current_user_id())); ?>">
							
							<?php endif; ?>
							
							<?php echo esc_html__('Login', 'levre'); ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-2.svg'); ?>"
							     alt="<?php echo esc_attr__('Authorization icon', 'levre'); ?>">
							
							<?php if (is_user_logged_in()): ?>
						
						</a>
					
					<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if ($navigation_wishlist_toggle && class_exists('WooCommerce') && function_exists('tinv_url_wishlist_default')): ?>
					
					<div class="wishlist-toggle action-toggle">
						
						<a href="<?php echo esc_url(tinv_url_wishlist_default()); ?>">
							
							<?php echo esc_html__('Wishlist', 'levre'); ?>
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/search-1.svg'); ?>"
							     alt="<?php echo esc_attr__('Wishlist icon', 'levre'); ?>">
						
						</a>
					
					</div>
				
				<?php endif; ?>
			
			</div>
		
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
							
							<?php echo esc_html('Items', 'levre'); ?>
						
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
								
								<article class="product"
								         data-product-id="<?php echo esc_attr($product_id); ?>">
									
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
						
						<p class="loading-message">
							
							<?php echo esc_html__('Loading', 'levre'); ?>
						
						</p>
					
					<?php endif; ?>
				
				</div>
				
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
						
						<a href="<?php echo esc_url(wc_get_cart_url()); ?>"
						   class="fs-button dark-border-style">
							
							<?php echo esc_html__('View Bag', 'levre'); ?>
						
						</a>
						
						<a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
						   class="fs-button dark-style">
							
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

</nav>