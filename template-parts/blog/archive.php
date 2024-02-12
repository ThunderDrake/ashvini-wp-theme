<?php defined('ABSPATH') || exit;

global $wp_query;

$total_results = $wp_query->found_posts;

if ($total_results > 0):
	
	if (is_search()):
		
		?>
		
		<header class="archive-header">
			
			<div class="inner-wrapper container">
				
				<h1 class="page-title">
					
					<?php
					
					echo esc_html__('Search Results', 'levre');
					
					?>
				
				</h1>
				
				<p class="results-count body-4">
					
					<?php
					
					echo esc_html($total_results) . esc_html__(' Results', 'levre');
					
					?>
				
				</p>
			
			</div>
		
		</header>
	
	<?php
	
	endif;
	
	if (is_archive() && !is_search() && !is_category()):
		
		?>
		
		<header class="archive-header">
			
			<div class="inner-wrapper container">
				
				<h1 class="page-title">
					
					<?php echo get_the_archive_title(); ?>
				
				</h1>
				
				<p class="results-count body-4">
					
					<?php
					
					echo esc_html($total_results) . esc_html__(' Results', 'levre');
					
					?>
				
				</p>
			
			</div>
		
		</header>
	
	<?php
	
	endif;
	
	get_template_part('template-parts/blog/blog');

else:
	
	get_template_part('template-parts/additional/not-found');

endif;