<?php defined('ABSPATH') || exit; ?>

<div class="filter-wrapper">
	
	<a class="filter-button body-7 <?php if (is_home() && !is_category()): echo esc_attr('active'); endif; ?>"
	   href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
		
		<?php echo esc_html__('All Articles', 'levre'); ?>
	
	</a>
	
	<?php
	
	$categories = get_categories();
	
	foreach ($categories as $category):
		
		$id = $category->term_id;
		
		$name = $category->name;
		
		$slug = $category->slug;
		
		?>
		
		<a class="filter-button body-7 <?php if (is_category() && get_the_category()[0]->slug === $slug): echo esc_attr('active'); endif; ?>"
		   href="<?php echo esc_url(get_term_link($id)); ?>">
			
			<?php echo esc_html($name); ?>
		
		</a>
	
	<?php endforeach; ?>

</div>