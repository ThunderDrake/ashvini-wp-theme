<?php defined('ABSPATH') || exit;

if (class_exists('FSD_Core') && function_exists('elementor_load_plugin_textdomain')):
	
	if (class_exists('WooCommerce') && is_shop()):
		
		$cta = get_field('field_cta_content', get_option('woocommerce_shop_page_id'));
	
	else:
		
		$cta = get_field('field_cta_content', get_the_ID());
	
	endif;
	
	if (!empty($cta)):
		
		echo Elementor\Plugin::$instance->frontend->get_builder_content($cta);
	
	endif;

endif;

$copyright = get_theme_mod('branding-copyright', esc_html__('© 2021 Beauty Store. All rights reserved.', 'levre'));

$footer_widgets_area = get_theme_mod('footer-widgets-area', esc_attr(1));

$footer_copyright_toggle = get_theme_mod('footer-copyright-toggle', esc_attr(1));

$footer_icons_toggle = get_theme_mod('footer-icons-toggle', esc_attr(1));

$footer_icons_list = get_theme_mod('footer-icons-list');

if ($footer_widgets_area || $footer_icons_toggle || $footer_copyright_toggle): ?>
	
	<footer class="footer <?php if (!$footer_widgets_area || !is_active_sidebar('footer-sidebar')): ?>without-widgets<?php endif; ?>">
		
		<div class="inner-wrapper container-fluid">
			
			<?php
			
			if (is_active_sidebar('footer-sidebar')):
				
				if ($footer_widgets_area):
					
					?>
					
					<div class="footer-sidebar-area">
						
						<?php
						
						dynamic_sidebar('footer-sidebar');
						
						?>
					
					</div>
				
				<?php
				
				endif;
			
			endif;
			
			?>
			
			<?php if ($footer_icons_toggle && $footer_copyright_toggle): ?>
				
				<div class="copyright-wrapper">
					
					<?php if ($footer_icons_toggle && !empty($footer_icons_list)): ?>
						
						<ul class="icons-list">
							
							<?php foreach ($footer_icons_list as $item): ?>
								
								<?php
								
								$fa = $item['font_awesome_icon'];
								
								$url = $item['url'];
								
								if (!empty($item['custom_icon'])):
									
									$custom_icon = $item['custom_icon'];
								
								else:
									
									$custom_icon = false;
								
								endif;
								
								?>
								
								<li class="icon-item">
									
									<?php if (empty($url) || $url === '#'): ?>
										
										<p>
											
											<?php if (!empty($custom_icon)): ?>
												
												<img src="<?php echo esc_url(wp_get_attachment_image_url($custom_icon)); ?>"
												     class="custom-icon">
											
											<?php else: ?>
												
												<i class="<?php echo esc_attr($fa); ?>"></i>
											
											<?php endif; ?>
										
										</p>
									
									<?php else: ?>
										
										<a href="<?php echo esc_url($url); ?>">
											
											<?php if (!empty($custom_icon)): ?>
												
												<img src="<?php echo esc_url(wp_get_attachment_image_url($custom_icon)); ?>"
												     class="custom-icon">
											
											<?php else: ?>
												
												<i class="<?php echo esc_attr($fa); ?>"></i>
											
											<?php endif; ?>
										
										</a>
									
									<?php endif; ?>
								
								</li>
							
							<?php endforeach; ?>
						
						</ul>
					
					<?php endif; ?>
					
					<?php if ($footer_copyright_toggle && !empty($copyright)): ?>
						
						<div class="copyright">
							
							<?php echo _($copyright); ?>
						
						</div>
					
					<?php endif; ?>
				
				</div>
			
			<?php endif; ?>
		
		</div>
	
	</footer>

<?php endif; ?>