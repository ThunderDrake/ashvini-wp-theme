<?php defined('ABSPATH') || exit; ?>

<div class="search-form-overlay">
	
	<div class="close-toggle">
		
		<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
		     alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
	
	</div>
	
	<div class="search-form-wrapper container">
		
		<?php get_search_form(); ?>
	
	</div>

</div>