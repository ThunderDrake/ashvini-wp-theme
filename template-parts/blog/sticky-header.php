<?php defined('ABSPATH') || exit;

wp_reset_postdata();

global $post;

$loop = get_posts('numberposts=1&order=ASC');

$first = $loop[0]->ID;

if (empty($first)):
	
	$first = false;

endif;

if (!empty(get_option('sticky_posts')[0])):
	
	$first = get_option('sticky_posts')[0];

endif;

$id = get_theme_mod('sticky-post-section-post', esc_attr($first));

if (!empty($id)):
	
	$post = get_post($id);
	
	$category = get_the_category($id);
	
	$date = get_the_date('', $id);
	
	$title = get_the_title($id);
	
	$excerpt = get_the_excerpt($post);
	
	$permalink = get_the_permalink($id);
	
	?>
	
	<header class="sticky-post-header">
		
		<div class="inner-wrapper container <?php if (!has_post_thumbnail()): ?>without-image<?php endif; ?>">
			
			<?php if (has_post_thumbnail()): ?>
				
				<div class="left-side">
					
					<a href="<?php the_permalink($id); ?>" class="link-overlay"></a>
					
					<?php
					
					if (has_post_thumbnail()):
						
						if (!empty($id)):
							
							$image_id = get_post_thumbnail_id($id);
							
							if (class_exists('FSD_Helper')):
								
								echo FSD_Helper::render_image($image_id,
										'fs-square-size-medium',
										['sizes' => implode(',', [
												'(max-width: 300px) 300px',
												'(max-width: 540px) 540px',
												'(max-width: 768px) 768px',
										]),
												'srcset' => implode(',', [
														esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-extra-small')) . ' 300w',
														esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-small')) . ' 540w',
														esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-medium')) . ' 768w',
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
						
						endif;
					
					else:
						
						echo get_the_post_thumbnail($id);
					
					endif;
					
					?>
				
				</div>
			
			<?php endif; ?>
			
			<div class="right-side">
				
				<div class="post-body">
					
					<div class="meta-wrapper">
						
						<?php if (!empty($category)): ?>
							
							<a class="category-name meta-item"
							   href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
								
								<?php echo esc_html($category[0]->name); ?>
							
							</a>
						
						<?php endif; ?>
						
						<p class="date meta-item">
							
							<?php echo esc_html($date); ?>
						
						</p>
					
					</div>
					
					<?php if (!empty($title)): ?>
						
						<h1 class="post-title">
							
							<a href="<?php echo esc_url($permalink); ?>">
								
								<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
							
							</a>
						
						</h1>
					
					<?php endif; ?>
					
					<?php if (!empty($excerpt)): ?>
						
						<p class="excerpt body-1">
							
							<?php echo esc_html(wp_trim_words($excerpt, 25, '...')); ?>
						
						</p>
					
					<?php endif; ?>
					
					<?php if (!empty($permalink)): ?>
						
						<a href="<?php echo esc_url($permalink); ?>" class="read-more-link fs-button dark-border-style">
							
							<?php echo esc_html__('Read Article', 'levre'); ?>
						
						</a>
					
					<?php endif; ?>
				
				</div>
			
			</div>
		
		</div>
	
	</header>

<?php endif; ?>

<?php wp_reset_postdata(); ?>