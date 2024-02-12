<?php defined('ABSPATH') || exit;

wp_reset_postdata();

if (is_product()):
	
	global $product;
	
	if (!empty($product) && !is_string($product) && !empty($product->get_image_id())):
		
		$post_thumbnail_id = $product->get_image_id();
		
		$attachment_ids = $product->get_gallery_image_ids();
		
		if (!empty($attachment_ids)):
			
			array_unshift($attachment_ids, $post_thumbnail_id);
		
		endif;
		
		?>
		
		<div class="gallery-lightbox-overlay">
			
			<div class="close-button">
				
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
				     alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
			
			</div>
			
			<?php if (!empty($attachment_ids)): ?>
				
				<div class="lightbox-products-thumbnails-slider-wrapper">
					
					<div class="swiper-container lightbox-products-thumbnails-slider">
						
						<div class="swiper-wrapper">
							
							<?php
							
							if ($attachment_ids && $product->get_image_id()) {
								
								foreach ($attachment_ids as $attachment_id) {
									?>
									
									<div class="swiper-slide">
										
										<?php
										
										echo FSD_Helper::render_image($attachment_id,
												'medium',
												['sizes' => implode(',', [
														'(max-width: 768px) 768px',
												]),
														'srcset' => implode(',', [
																esc_url(wp_get_attachment_image_url($attachment_id, 'medium')) . ' 768w',
														]),
														'loading' => 'lazy',
														'class' => 'wp-image-slider',
														'alt' => get_the_title()
												], false);
										
										?>
									
									</div>
									
									<?php
								}
								
							}
							
							?>
						
						</div>
					
					</div>
				
				</div>
			
			<?php endif; ?>
			
			<div class="lightbox-gallery-slider-wrapper">
				
				<?php if (!empty($attachment_ids)): ?>
					
					<div class="navigation-wrapper">
						
						<div class="navigation-button navigation-button-prev">
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-left.svg'); ?>"
							     alt="<?php echo esc_attr__('Left', 'levre'); ?>">
						
						</div>
						
						<div class="navigation-button navigation-button-next">
							
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-right.svg'); ?>"
							     alt="<?php echo esc_attr__('Right', 'levre'); ?>">
						
						</div>
					
					</div>
					
					<div class="swiper-container lightbox-gallery-slider">
						
						<div class="swiper-wrapper">
							
							<?php
							
							$attachment_ids = $product->get_gallery_image_ids();
							
							if ($post_thumbnail_id) {
								$html = '<div class="swiper-slide">';
								$html .= wc_get_gallery_image_html($post_thumbnail_id, true);
								$html .= '</div>';
							} else {
								$html = '<div class="swiper-slide">';
								$html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'levre'));
								$html .= '</div>';
							}
							
							echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
							
							if ($attachment_ids && $product->get_image_id()) {
								
								foreach ($attachment_ids as $attachment_id) {
									?>
									
									<div class="swiper-slide">
										
										<div class="image-wrapper">
											
											<?php
											
											echo FSD_Helper::render_image($attachment_id,
													'full',
													['sizes' => implode(',', [
															'(max-width: 1920px) 1920px',
													]),
															'srcset' => implode(',', [
																	esc_url(wp_get_attachment_image_url($attachment_id, 'full')) . ' 1920w',
															]),
															'loading' => 'lazy',
															'class' => 'wp-image-slider',
															'alt' => get_the_title()
													], false);
											
											?>
										
										</div>
									
									</div>
									
									<?php
								}
								
							}
							
							?>
						
						</div>
					
					</div>
				
				<?php else: ?>
					
					<div class="single-image-wrapper">
						
						<?php
						
						if ($post_thumbnail_id) {
							$html = wc_get_gallery_image_html($post_thumbnail_id, true);
						} else {
							$html = sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'levre'));
						}
						
						echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
						
						?>
					
					</div>
				
				<?php endif; ?>
			
			</div>
		
		</div>
	
	<?php endif; ?>

<?php endif;

wp_reset_postdata();