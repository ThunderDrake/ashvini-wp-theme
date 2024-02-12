<?php defined('ABSPATH') || exit;

?>

<!-- search-form -->
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
	
	<!-- search-field -->
	<input type="search" class="search-field"
	       placeholder="<?php echo esc_attr__('Enter some keywords...', 'levre'); ?>"
	       value="<?php echo get_search_query(); ?>" name="s"
	       title="<?php echo esc_attr__('Enter some keywords...', 'levre'); ?>">

</form>