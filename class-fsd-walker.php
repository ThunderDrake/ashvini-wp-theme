<?php defined('ABSPATH') || exit;

/**
 * Class FSD_Walker
 */
class FSD_Walker extends Walker
{
	
	/**
	 * @var array
	 */
	private $classes;
	
	/**
	 * FSD_Walker constructor.
	 *
	 * @param array $classes
	 */
	public function __construct($classes = [])
	{
		
		$this->classes = $classes;
		
		$this->megamenu_item_id = false;
		
	}
	
	/**
	 * What the class handles.
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 * @see   Walker::$tree_type
	 */
	public $tree_type = ['post_type', 'taxonomy', 'custom'];
	
	/**
	 * Database fields to use.
	 *
	 * @since 1.0.0
	 * @var array
	 *
	 * @see   Walker::$db_fields
	 */
	public $db_fields = [
		'parent' => 'menu_item_parent',
		'id' => 'db_id',
	];
	
	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 *
	 * @see   Walker::start_lvl()
	 *
	 * @since 1.0.0
	 *
	 */
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) :
			
			$t = '';
			
			$n = '';
		
		else :
			
			$t = "\t";
			
			$n = "\n";
		
		endif;
		
		$indent = str_repeat($t, $depth);
		
		// Default class.
		$classes = ['sub-menu'];
		
		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 *
		 * @since 7.3.0
		 *
		 */
		$class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
		
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		
		$output .= "{$n}{$indent}<ul$class_names>{$n}";
		
	}
	
	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 *
	 * @see   Walker::end_lvl()
	 *
	 * @since 1.0.0
	 *
	 */
	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) :
			
			$t = '';
			
			$n = '';
		
		else :
			
			$t = "\t";
			
			$n = "\n";
		
		endif;
		
		$indent = str_repeat($t, $depth);
		
		$output .= "$indent</ul>{$n}";
		
	}
	
	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 *
	 * @see   Walker::start_el()
	 *
	 * @since 1.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) :
			
			$t = '';
			
			$n = '';
		
		else :
			
			$t = "\t";
			
			$n = "\n";
		
		endif;
		
		$indent = ($depth) ? str_repeat($t, $depth) : '';
		
		$item_children_check = false;
		
		$classes = empty($item->classes) ? [] : (array)$item->classes;
		
		$classes[] = 'menu-item-' . $item->ID;
		
		if (function_exists('get_field') && class_exists('FSD_Helper')):
			
			$megamenu_toggle = FSD_Helper::get_field('field_menu_megamenu_toggle', $item);
			
			if ($megamenu_toggle):
				
				array_push($classes, esc_attr('menu-item-has-megamenu'));
				
				$this->megamenu_item_id = $item->ID;
			
			endif;
		
		endif;
		
		foreach ($classes as $class):
			
			if ($class === 'menu-item-has-children'):
				
				$item_children_check = true;
			
			endif;
		
		endforeach;
		
		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 *
		 * @since 4.4.0
		 *
		 */
		$args = apply_filters('nav_menu_item_args', $args, $item, $depth);
		
		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 *
		 * @since 1.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 */
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
		
		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 */
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
		
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';
		
		$output .= $indent . '<li' . $id . $class_names . '>';
		
		$atts = [];
		
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		
		$atts['target'] = !empty($item->target) ? $item->target : '';
		
		if ('_blank' === $item->target && empty($item->xfn)) :
			
			$atts['rel'] = 'noopener noreferrer';
		
		else :
			
			$atts['rel'] = $item->xfn;
		
		endif;
		
		$atts['href'] = !empty($item->url) ? $item->url : '';
		
		$atts['aria-current'] = $item->current ? 'page' : '';
		
		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @param array    $atts         {
		 *                               The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 * @type string    $title        Title attribute.
		 * @type string    $target       Target attribute.
		 * @type string    $rel          The rel attribute.
		 * @type string    $href         The href attribute.
		 * @type string    $aria_current The aria-current attribute.
		 *                               }
		 *
		 * @param WP_Post  $item         The current menu item.
		 * @param stdClass $args         An object of wp_nav_menu() arguments.
		 * @param int      $depth        Depth of menu item. Used for padding.
		 *
		 * @since 7.3.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 */
		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
		
		$attributes = '';
		
		foreach ($atts as $attr => $value) :
			
			if (is_scalar($value) && '' !== $value && false !== $value) :
				
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				
				$attributes .= ' ' . $attr . '="' . $value . '"';
			
			endif;
		
		endforeach;
		
		if ($this->megamenu_item_id && (int)$item->menu_item_parent === $this->megamenu_item_id):
			
			$attributes .= ' class="megamenu-title"';
		
		endif;
		
		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters('the_title', $item->title, $item->ID);
		
		/**
		 * Filters a menu item's title.
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 *
		 * @since 4.4.0
		 *
		 */
		$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
		
		$item_output = $args->before;
		
		$item_output .= '<a' . $attributes . '>';
		
		$item_output .= $args->link_before . $title . $args->link_after;
		
		if ($item_children_check):
			
			$item_output .= '<img class="menu-item-icon" src="' . esc_url(get_template_directory_uri() . '/assets/img/chevron.svg') . '"
                 alt="' . esc_attr__('Chevron icon', 'levre') . '">';
		
		endif;
		
		$item_output .= '</a>';
		
		$item_output .= $args->after;
		
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		
	}
	
	/**
	 * Ends the element output, if needed.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 *
	 * @since 1.0.0
	 *
	 * @see   Walker::end_el()
	 *
	 */
	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) :
			
			$t = '';
			
			$n = '';
		
		else :
			
			$t = "\t";
			
			$n = "\n";
		
		endif;
		
		$output .= "</li>{$n}";
		
	}
	
}