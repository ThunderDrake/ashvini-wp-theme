<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
	return;
}

global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes = apply_filters(
		'woocommerce_single_product_image_gallery_classes',
		[
				'woocommerce-product-gallery',
				'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
				'woocommerce-product-gallery--columns-' . absint($columns),
				'images',
		]
);

$attachment_ids = $product->get_gallery_image_ids();

?>
<div class="product-gallery-main-wrapper <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>"
     data-columns="<?php echo esc_attr($columns); ?>">
	<figure class="woocommerce-product-gallery__wrapper">
		
		<?php if (!empty($attachment_ids) || have_rows('field_product_video_gallery')): ?>
			
			<?php
			
			array_unshift($attachment_ids, $post_thumbnail_id);
			
			?>
			
			<div class="thumbnails-slider-wrapper">
				
				<div class="navigation-button navigation-button-prev">
					
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-up.svg'); ?>"
					     alt="<?php echo esc_attr__('Arrow Up', 'levre'); ?>">
				
				</div>
				
				<div class="swiper-container products-thumbnails-slider">
					
					<div class="swiper-wrapper">
						
						<?php
						
						$counter = 0;
						
						if (!empty($attachment_ids)):
							
							if ($attachment_ids && $product->get_image_id()) {
								foreach ($attachment_ids as $attachment_id) {
									
									?>
									
									<div class="swiper-slide image-slide"
									     data-order="<?php echo esc_attr($counter); ?>">
										
										<?php
										
										if (class_exists('FSD_Helper')):
											
											echo FSD_Helper::render_image($attachment_id,
													'large',
													['sizes' => implode(',', [
															'(max-width: 1024px) 1024px',
													]),
															'srcset' => implode(',', [
																	esc_url(wp_get_attachment_image_url($attachment_id, 'large')) . ' 1024w',
															]),
															'loading' => 'lazy',
															'class' => 'wp-image-slider',
															'alt' => get_the_title()
													], false);
										
										else:
											
											?>
											
											<img src="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'large')); ?>"
											     alt="<?php echo esc_attr(get_the_title()); ?>">
										
										<?php
										
										endif;
										
										?>
									
									</div>
									
									<?php
									
								}
							}
						
						endif;
						
						if (have_rows('field_product_video_gallery')):
							
							while (have_rows('field_product_video_gallery')) : the_row();
								
								$video_image = FSD_Helper::get_sub_field('field_product_video_preview');
								
								if (!empty($video_image['id'])):
									
									?>
									
									<div class="swiper-slide swiper-slide-video">
										
										<?php
										
										if (class_exists('FSD_Helper')):
											
											echo FSD_Helper::render_image($video_image['id'],
													'large',
													['sizes' => implode(',', [
															'(max-width: 1024px) 1024px',
													]),
															'srcset' => implode(',', [
																	esc_url(wp_get_attachment_image_url($video_image['id'], 'large')) . ' 1024w',
															]),
															'loading' => 'lazy',
															'class' => 'wp-image-slider',
															'alt' => get_the_title()
													], false);
										
										else:
											
											?>
											
											<img src="<?php echo esc_url(wp_get_attachment_image_url($video_image['id'], 'large')); ?>"
											     alt="<?php echo esc_attr(get_the_title()); ?>">
										
										<?php
										
										endif;
										
										?>
									
									</div>
								
								<?php
								
								endif;
							
							endwhile;
						
						endif;
						
						?>
					
					</div>
				
				</div>
				
				<div class="navigation-button navigation-button-next">
					
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow-down.svg'); ?>"
					     alt="<?php echo esc_attr__('Arrow Down', 'levre'); ?>">
				
				</div>
			
			</div>
		
		<?php endif; ?>
		
		<?php if (!empty($attachment_ids) || have_rows('field_product_video_gallery')): ?>
			
			<?php
			
			$attachment_ids = $product->get_gallery_image_ids();
			
			?>
			
			<div class="image-wrapper with-gallery">
				
				<div class="swiper-container products-gallery-slider">
					
					<div class="swiper-wrapper">
						
						<?php
						
						$counter = 1;
						
						if ($attachment_ids && $product->get_image_id() || have_rows('field_product_video_gallery') && $product->get_image_id()) {
							
							if ($post_thumbnail_id) {
								$html = '<div class="swiper-slide"><div class="zoom-wrapper"
                                         data-zoom-value="1"
                                         data-zoom-url="' . esc_url(wp_get_attachment_image_url($post_thumbnail_id, 'large')) . '">';
								$html .= wc_get_gallery_image_html($post_thumbnail_id, true);
								$html .= '</div></div>';
							} else {
								$html = '<div class="swiper-slide">';
								$html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'levre'));
								$html .= '</div>';
							}
							
							echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
							
							foreach ($attachment_ids as $attachment_id) {
								
								?>
								
								<div class="swiper-slide">
									
									<div class="zoom-wrapper"
									     data-zoom-value="1"
									     data-zoom-url="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'large')); ?>">
										
										<?php
										
										if (class_exists('FSD_Helper')):
											
											echo FSD_Helper::render_image($attachment_id,
													'large',
													['sizes' => implode(',', [
															'(max-width: 1024px) 1024px',
													]),
															'srcset' => implode(',', [
																	esc_url(wp_get_attachment_image_url($attachment_id, 'large')) . ' 1024w',
															]),
															'loading' => 'lazy',
															'class' => 'wp-image-slider',
															'alt' => get_the_title()
													], false);
										else:
											
											?>
											
											<img src="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'large')); ?>"
											     alt="<?php echo esc_attr(get_the_title()); ?>">
										
										<?php
										
										endif;
										
										?>
									
									</div>
								
								</div>
								
								<?php
							}
						}
						
						if (have_rows('field_product_video_gallery')):
							
							while (have_rows('field_product_video_gallery')) : the_row();
								
								$video_type = FSD_Helper::get_sub_field('field_product_video');
								
								$video_image = FSD_Helper::get_sub_field('field_product_video_preview');
								
								if (!empty($video_image)):
									
									?>
									
									<div class="swiper-slide swiper-slide-video">
										
										<div class="gallery-video-wrapper video-wrapper">
											
											<?php if ($video_type === 'youtube'):
												
												$url = FSD_Helper::get_sub_field('field_product_video_url');
												
												if (!empty($url)):
													
													?>
													
													<div class="plyr__video-embed video-player player">
														
														<iframe src="<?php echo esc_url($url); ?>&amp;iv_load_policy=3&amp;modestbranding=0&amp;playsinline=0&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
														        allowfullscreen
														        allowtransparency
														        allow="autoplay">
														
														</iframe>
													
													</div>
												
												<?php endif;
											
											elseif ($video_type === 'vimeo'):
												
												$url = FSD_Helper::get_sub_field('field_product_video_url');
												
												if (!empty($url)):
													
													?>
													
													<div class="plyr__video-embed video-player player">
														
														<iframe src="<?php echo esc_url($url); ?>&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media">
														
														</iframe>
													
													</div>
												
												<?php endif; ?>
											
											<?php elseif ($video_type === 'html'):
												
												$file = FSD_Helper::get_sub_field('field_product_video_file');
												
												if (!empty($file)):
													
													?>
													
													<video class="video-player player" playsinline controls>
														
														<source src="<?php echo esc_url($file); ?>" type="video/mp4" />
													
													</video>
												
												<?php endif; ?>
											
											<?php endif; ?>
										
										</div>
									
									</div>
								
								<?php
								
								endif;
							
							endwhile;
						
						endif;
						
						?>
					
					</div>
					
					<div class="products-gallery-slider-pagination">
					
					</div>
				
				</div>
			
			</div>
		
		<?php
		
		else:
			
			?>
			
			<div class="image-wrapper">
				
				<?php
				
				if ($post_thumbnail_id) {
					$html = wc_get_gallery_image_html($post_thumbnail_id, true);
				} else {
					$html = sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'levre'));
				}
				
				echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
				
				?>
			
			</div>
		
		<?php
		
		endif; ?>
	
	</figure>
</div>