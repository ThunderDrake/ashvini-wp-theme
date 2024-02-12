<?php defined('ABSPATH') || exit; ?>

<header class="not-fount-header">
	
	<div class="inner-wrapper container">
		
		<h1 class="search-term">
			
			<?php echo esc_html(get_search_query()); ?>
		
		</h1>
		
		<p class="subtitle body-4">
			
			<?php echo esc_html__('Nothing Found', 'levre'); ?>
		
		</p>
		
		<a href="<?php echo esc_url(get_home_url()); ?>" class="fs-button dark-border-style">
			
			<?php echo esc_html__('Search Again', 'levre'); ?>
		
		</a>
	
	</div>

</header>