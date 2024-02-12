<?php defined('ABSPATH') || exit;

$field_position_location = FSD_Helper::get_field('field_position_location');

$field_position_apply_now_button_text = FSD_Helper::get_field('field_position_apply_now_button_text');

$field_position_apply_now_button_link = FSD_Helper::get_field('field_position_apply_now_button_link');

$field_position_apply_now_successful_link = FSD_Helper::get_field('field_position_apply_now_successful_link');

$single_career_header = get_theme_mod('single-career-header', esc_attr(1));

$single_career_share = get_theme_mod('single-career-share', esc_attr(1));

$single_career_share_list = get_theme_mod('single-career-share-list');

$single_career_related = get_theme_mod('single-career-related', esc_attr(1));

?>

<div class="single-position-wrapper"
     <?php if (!empty($field_position_apply_now_successful_link)): ?>data-successful-link="<?php echo esc_attr($field_position_apply_now_successful_link); ?>"<?php endif; ?>>
	
	<?php if ($single_career_header): ?>
		
		<div class="single-position-header">
			
			<div class="thumbnail-wrapper">
				
				<?php
				
				$image_id = get_post_thumbnail_id(get_the_ID());
				
				echo FSD_Helper::render_image($image_id,
						'fs-square-size-large',
						['sizes' => implode(',', [
								'(max-width: 300px) 300px',
								'(max-width: 540px) 540px',
								'(max-width: 768px) 768px',
								'(max-width: 1024px) 1024px',
						]),
								'srcset' => implode(',', [
										esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-extra-small')) . ' 300w',
										esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-small')) . ' 540w',
										esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-medium')) . ' 768w',
										esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-large')) . ' 1024w',
								]),
								'loading' => 'lazy',
								'alt' => get_the_title()
						], false);
				
				?>
			
			</div>
			
			<div class="content-wrapper">
				
				<div class="inner-wrapper">
					
					<?php if (!empty($field_position_location)): ?>
						
						<p class="position-location">
							
							<?php echo esc_html($field_position_location); ?>
						
						</p>
					
					<?php endif; ?>
					
					<?php if (!empty(get_the_title())): ?>
						
						<h1 class="post-title">
							
							<?php the_title(); ?>
						
						</h1>
					
					<?php endif; ?>
					
					<?php if (!empty($field_position_apply_now_button_link) && !empty($field_position_apply_now_button_text)): ?>
						
						<a href="<?php echo esc_url($field_position_apply_now_button_link); ?>"
						   class="fs-button dark-border-style">
							
							<?php echo esc_html($field_position_apply_now_button_text); ?>
						
						</a>
					
					<?php endif; ?>
				
				</div>
			
			</div>
		
		</div>
	
	<?php endif; ?>
	
	<div class="single-position-body">
		
		<?php the_content(); ?>
	
	</div>
	
	<?php if ($single_career_share || $single_career_related || $field_position_apply_now_button_text && $field_position_apply_now_button_link): ?>
		
		<div class="single-position-footer">
			
			<div class="inner-wrapper container">
				
				<div class="apply-button-bottom">
					
					<?php if (!empty($field_position_apply_now_button_link) && !empty($field_position_apply_now_button_text)): ?>
						
						<a href="<?php echo esc_url($field_position_apply_now_button_link); ?>"
						   class="fs-button dark-style">
							
							<?php echo esc_html($field_position_apply_now_button_text); ?>
						
						</a>
					
					<?php endif; ?>
				
				</div>
				
				<?php if ($single_career_share && !empty($single_career_share_list)): ?>
					
					<div class="share-wrapper">
						
						<h3 class="footer-title">
							
							<?php echo esc_html__('Share', 'levre'); ?>
						
						</h3>
						
						<?php if ($single_career_share && $single_career_share_list): ?>
							
							<!-- Share Wrapper -->
							<div class="share-list">
								
								<?php if (in_array('twitter', $single_career_share_list)): ?>
									
									<!-- Twitter Share Link -->
									<?php FSD_Helper::the_twitter_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('pinterest', $single_career_share_list)): ?>
									
									<!-- Pinterest Share Link -->
									<?php FSD_Helper::the_pinterest_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('facebook', $single_career_share_list)): ?>
									
									<!-- Facebook Share Link -->
									<?php FSD_Helper::the_facebook_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('vk', $single_career_share_list)): ?>
									
									<!-- VK Share Link -->
									<?php FSD_Helper::the_vk_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('linkedin', $single_career_share_list)): ?>
									
									<!-- Linkedin Share Link -->
									<?php FSD_Helper::the_linkedin_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('odnoklassniki', $single_career_share_list)): ?>
									
									<!-- Odnoklassniki Share Link -->
									<?php FSD_Helper::the_odnoklassniki_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('tumblr', $single_career_share_list)): ?>
									
									<!-- Tumblr Share Link -->
									<?php FSD_Helper::the_tumblr_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('google', $single_career_share_list)): ?>
									
									<!-- Google Share Link -->
									<?php FSD_Helper::the_google_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('digg', $single_career_share_list)): ?>
									
									<!-- Digg Share Link -->
									<?php FSD_Helper::the_digg_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('reddit', $single_career_share_list)): ?>
									
									<!-- Reddit Share Link -->
									<?php FSD_Helper::the_reddit_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('stumbleupon', $single_career_share_list)): ?>
									
									<!-- Stumbleupon Share Link -->
									<?php FSD_Helper::the_stumbleupon_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('pocket', $single_career_share_list)): ?>
									
									<!-- Pocket Share Link -->
									<?php FSD_Helper::the_pocket_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('whatsapp', $single_career_share_list)): ?>
									
									<!-- Whatsapp Share Link -->
									<?php FSD_Helper::the_whatsapp_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('xing', $single_career_share_list)): ?>
									
									<!-- Xing Share Link -->
									<?php FSD_Helper::the_xing_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('email', $single_career_share_list)): ?>
									
									<!-- Email Share Link -->
									<?php FSD_Helper::the_email_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('telegram', $single_career_share_list)): ?>
									
									<!-- Telegram Share Link -->
									<?php FSD_Helper::the_telegram_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
								
								<?php if (in_array('skype', $single_career_share_list)): ?>
									
									<!-- Skype Share Link -->
									<?php FSD_Helper::the_skype_share_link_render(get_the_ID()); ?>
								
								<?php endif; ?>
							
							</div>
						
						<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if ($single_career_related): ?>
					
					<?php
					
					$args = [
							'posts_per_page' => 4,
							'order' => 'DESC',
							'post_type' => 'career',
							'post__not_in' => [get_the_ID()],
					];
					
					$the_query = new WP_Query($args);
					
					if ($the_query->have_posts()) :
						
						?>
						
						<div class="related-positions">
							
							<h3 class="footer-title">
								
								<?php echo esc_html__('You may find interesting', 'levre'); ?>
							
							</h3>
							
							<div class="positions-list">
								
								<div class="inner-wrapper">
									
									<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
										
										<?php
										
										$title = get_the_title();
										
										$field_position_location = FSD_Helper::get_field('field_position_location');
										
										?>
										
										<article <?php post_class('position-item'); ?>>
											
											<div class="item-inner">
												
												<a href="<?php the_permalink(); ?>" class="link-overlay">
												
												
												</a>
												
												<p class="post-title body-3">
													
													<?php echo esc_html(wp_trim_words($title, 7, '...')); ?>
												
												</p>
												
												<p class="location body-8">
													
													<?php echo esc_html($field_position_location); ?>
												
												</p>
												
												<span class="arrow">

                                         <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/arrow.svg') ?>"
                                              alt="<?php echo esc_attr__('Arrow Icon', 'levre'); ?>">

                                            </span>
											
											</div>
										
										</article>
									
									<?php endwhile; ?>
								
								</div>
							
							</div>
						
						</div>
					
					<?php
					
					endif;
				
				endif;
				
				?>
			
			</div>
		
		</div>
	
	<?php endif; ?>

</div>