<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

$product_id = $product->get_id();

if (!empty($product_id)):
	
	$product_cart_id = WC()->cart->generate_cart_id($product_id);
	
	$quick_actions = get_theme_mod('shop-quick-actions-overlay', 1);
	
	?>
	
	<li <?php wc_product_class('', $product); ?> data-product-id="<?php echo esc_attr($product_id); ?>">
		
		<div class="product-inner">
			
			<div class="thumbnail-wrapper">
				
				<?php
				
				wc_get_template('loop/rating.php');
				
				/**
				 * Hook: woocommerce_before_shop_loop_item_title.
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action('woocommerce_before_shop_loop_item_title');
				
				?>
				
				<a href="<?php the_permalink(); ?>" class="link-overlay"></a>
				
				<?php if (!empty($quick_actions)): ?>
					
					<div class="buttons-overlay">
						
						<a class="fs-add-to-cart-button <?php echo esc_attr($product->get_type()) ?> fs-button dark-border-style <?php if (WC()->cart->find_product_in_cart($product_cart_id)): ?> already-in-cart <?php endif; ?>"
						   <?php if (WC()->cart->find_product_in_cart($product_cart_id)): ?>href="<?php echo esc_url(wc_get_cart_url()); ?>" <?php elseif ((!$product->is_in_stock() || $product->get_type() !== 'simple') && $product->get_type() !== 'external'): ?> href="<?php echo esc_url(get_permalink($product_id)); ?>" <?php elseif ($product->get_type() === 'external' && !empty($product->get_product_url())): ?> href="<?php echo esc_url($product->get_product_url()); ?>" <?php endif; ?>
						   data-href="<?php echo esc_url(wc_get_cart_url()); ?>">
							
							<div class="def-st">
								
								<?php
								
								if (WC()->cart->find_product_in_cart($product_cart_id)):
									
									echo esc_html__('View Cart', 'levre');
								
								elseif (!$product->is_in_stock()):
									
									echo esc_html__('Read More', 'levre');
								
								else:
									
									if ($product->get_type() !== 'variable' && $product->get_type() !== 'external'):
										
										?>
										
										<svg class="left-ic" width="13" height="13" viewBox="0 0 13 13" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd"
											      d="M7 6L7 0L6 0L6 6L0 6L0 7L6 7V13H7V7L13 7V6L7 6Z" fill="black" />
										</svg>
									
									<?php
									
									endif;
									
									echo esc_html($product->add_to_cart_text());
									
									if ($product->get_type() === 'variable' || $product->get_type() === 'external'):
										
										?>
										
										<svg class="right-ic" width="17" height="11" viewBox="0 0 17 11" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<path d="M0 5H15.5C15.7761 5 16 5.22386 16 5.5C16 5.77614 15.7761 6 15.5 6H0V5Z"
											      fill="black" />
											<path fill-rule="evenodd" clip-rule="evenodd"
											      d="M11.5 0.5L10.7929 1.20711L15.0355 5.44975L10.7929 9.69239L11.5 10.3995L15.7426 6.15685L16.4497 5.44975L15.7426 4.74264L11.5 0.5Z"
											      fill="black" />
										</svg>
									
									<?php
									
									endif;
								
								endif;
								
								?>
							
							</div>
							
							<div class="load-st">
								
								<svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<style>.spinner_0XTQ {
											transform-origin: center;
											animation: spinner_y6GP .75s linear infinite
										}
										
										@keyframes spinner_y6GP {
											100% {
												transform: rotate(360deg)
											}
										}</style>
									<path class="spinner_0XTQ"
									      d="M12,23a9.63,9.63,0,0,1-8-9.5,9.51,9.51,0,0,1,6.79-9.1A1.66,1.66,0,0,0,12,2.81h0a1.67,1.67,0,0,0-1.94-1.64A11,11,0,0,0,12,23Z"
									      fill="#fff" />
								</svg>
							
							</div>
							
							<div class="already-in-state">
								
								<?php echo esc_html__('View Cart', 'levre'); ?>
							
							</div>
						
						</a>
						
						<?php
						
						echo do_shortcode('[ti_wishlists_addtowishlist product_id="' . $product_id . '"]');
						
						?>
					
					</div>
				
				<?php endif; ?>
			
			</div>
			
			<div class="responsive-rating">
				
				<?php
				
				wc_get_template('loop/rating.php');
				
				?>
			
			</div>
			
			<a href="<?php the_permalink(); ?>">
				
				<?php
				
				/**
				 * Hook: woocommerce_shop_loop_item_title.
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action('woocommerce_shop_loop_item_title');
				
				?>
			
			</a>
			
			<?php
			
			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action('woocommerce_after_shop_loop_item_title');
			?>
		
		</div>
	
	</li>

<?php endif;