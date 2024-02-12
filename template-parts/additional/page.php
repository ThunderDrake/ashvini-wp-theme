<?php defined('ABSPATH') || exit;

if (class_exists('FSD_Core') || class_exists('WooCommerce') && (is_cart() || is_checkout() || is_account_page() || is_product() || is_shop() || is_product_taxonomy())):
	
	if (have_posts()) :
		
		while (have_posts()) : the_post();
			
			/* page content */
			the_content();
		
		endwhile;
	
	endif;
	
	$page = (int)get_theme_mod('shop-brands-main-page');
	
	if (!empty($page)):
		
		if ((int)get_the_ID() === $page):
			
			/* include brands archive page */
			get_template_part('template-parts/woocommerce/brands');
		
		endif;
	
	endif;

else:
	
	?>
	
	<div class="default-page-wrapper">
		
		<div class="page-header">
			
			<div class="container inner-wrapper">
				
				<h1 class="page-title">
					
					<?php
					
					if (is_search()):
						
						echo esc_html__('Search Results', 'levre');
					
					elseif (is_post_type_archive('product')):
						
						echo esc_html__('Shop', 'levre');
					
					elseif (is_post_type_archive('portfolio')):
						
						echo esc_html__('Portfolio', 'levre');
					
					elseif (is_404()):
						
						echo esc_html__('Page not Found', 'levre');
					
					elseif (is_archive()):
						
						echo get_the_archive_title();
					
					elseif (is_home()):
						
						echo esc_html__('The Blog', 'levre');
					
					elseif (class_exists('Woocommerce') && is_shop()):
						
						echo esc_html__('Shop', 'levre');
					
					else:
						
						echo wp_get_document_title();
					
					endif;
					
					?>
				
				</h1>
			
			</div>
		
		</div>
		
		<div class="inner-wrapper container">
			
			<?php
			
			if (have_posts()) :
				
				while (have_posts()) : the_post();
					
					?>
					
					<div class="entry-content">
						
						<?php
						
						the_content();
						
						?>
					
					</div>
					
					<?php
					
					global $multipage;
					
					if (0 !== $multipage): ?>
						
						<div class="entry-navigation">
							
							<?php
							
							wp_link_pages([
									'link_before' => '<div class="link">',
									'link_after' => '</div>',
							]);
							
							?>
						
						</div>
					
					<?php
					
					endif;
					
					if (comments_open() || get_comments_number()) :
						
						?>
						
						<div class="default-comments">
							
							<?php
							
							comments_template();
							
							?>
						
						</div>
					
					<?php
					
					endif;
				
				endwhile;
			
			endif;
			
			?>
		
		</div>
	
	</div>

<?php

endif;