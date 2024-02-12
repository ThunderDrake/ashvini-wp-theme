<?php defined('ABSPATH') || exit;

/**
 * Class FSD_Theme
 */
final class FSD_Theme
{
	
	/**
	 * @var mixed|string
	 */
	public static $version = '';
	
	/**
	 * @var string
	 */
	public static $name = '';
	
	/**
	 * @return mixed|string
	 */
	public static function getVersion()
	{
		
		/* return version */
		return self::$version;
		
	}
	
	/**
	 * @param mixed|string $version
	 */
	public static function setVersion($version)
	{
		
		/* set version */
		self::$version = $version;
		
	}
	
	/**
	 * @return string
	 */
	public static function getName()
	{
		
		/* return name */
		return self::$name;
		
	}
	
	/**
	 * @param string $name
	 */
	public static function setName($name)
	{
		
		/* set name */
		self::$name = $name;
		
	}
	
	/**
	 * FSD_Theme constructor.
	 *
	 * @param $args
	 */
	public function __construct($args)
	{
		
		/* added custom upload extensions (mime types) */
		add_filter('mime_types', [$this, 'custom_upload_extensions']);
		
		/* setup version of theme */
		if (!empty($args['version'])):
			
			/* new value */
			$this->setVersion($args['version']);
		
		else:
			
			/* default value */
			$this->setVersion('1.0');
		
		endif;
		
		/* setup theme name */
		if (!empty($args['name'])):
			
			/* new value */
			$this->setName($args['name']);
		
		else:
			
			/* default value */
			$this->setName(esc_html__('levre', 'levre'));
		
		endif;
		
		add_filter('document_title_parts', function ($parts) {
			
			if (isset($parts['site'])) unset($parts['site']);
			
			return $parts;
		});
		
		/* setup theme slug */
		
		/* init theme */
		$this->init_theme();
		
	}
	
	/**
	 * init theme
	 */
	protected function init_theme()
	{
		
		/* theme translation */
		add_action('init', [$this, 'i18n']);
		
		add_action('init', [$this, 'templates_cached'], 999);
		
		/* init sidebar area */
		add_action('widgets_init', [$this, 'init_sidebar_area']);
		
		/* init navigation area */
		add_action('after_setup_theme', [$this, 'init_navigation_area']);
		
		/* theme setup values */
		add_action('after_setup_theme', [$this, 'theme_setup']);
		
		/* enqueue theme styles */
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		
		add_action('wp_enqueue_scripts', [$this, 'inline_styles']);
		
		add_action('wp_enqueue_scripts', [$this, 'css_variables']);
		
		/* enqueue theme scripts */
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		
		/* enqueue theme admin styles */
		add_action('admin_head', [$this, 'enqueue_admin_styles']);
		
		add_action('wp_head', [$this, 'pingback_header']);
		
		/* change default comment template */
		add_filter('wp_list_comments_args', function ($args) {
			
			if (is_singular('post') || (!class_exists('FSD_Core') && is_page())):
				
				$args['callback'] = function ($comment, $depth, $args) {
					
					$this->comment_template($comment, $depth, $args);
					
				};
			
			endif;
			
			return $args;
			
		});
		
		/* Update comment form fields */
		add_filter('comment_form_default_fields', [$this, 'comment_form_default_fields']);
		
		/* Update comment form textarea */
		add_filter('comment_form_field_comment', [$this, 'comment_form_field_comment']);
		
		add_action('login_form_middle', [$this, 'add_lost_password_link']);
		
		add_action('wp_ajax_nopriv_fs_switch_reg', [$this, 'switch_reg']);
		
		add_action('wp_ajax_fs_switch_reg', [$this, 'switch_reg']);
		
		add_action('wp_ajax_nopriv_fs_reg', [$this, 'register_handler']);
		
		add_action('wp_ajax_fs_reg', [$this, 'register_handler']);
		
		add_action('wp_ajax_nopriv_fs_switch_login', [$this, 'switch_login']);
		
		add_action('wp_ajax_fs_switch_login', [$this, 'switch_login']);
		
		add_action('wp_ajax_nopriv_fs_blog_load_more', [$this, 'blog_load_more']);
		
		add_action('wp_ajax_fs_blog_load_more', [$this, 'blog_load_more']);
		
		add_action('wp_ajax_nopriv_FSD_Shop_load_more', [$this, 'shop_load_more']);
		
		add_action('wp_ajax_FSD_Shop_load_more', [$this, 'shop_load_more']);
		
		add_filter('loop_shop_per_page', [$this, 'set_products_per_page'], 99);
		
		add_filter('loop_shop_columns', [$this, 'set_columns_count'], 1, 10);
		
		remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
		
		remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
		
		remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
		
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
		
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
		
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
		
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
		
		add_action('woocommerce_shop_loop_item_title', [$this, 'change_products_loop_title'], 10);
		
		add_action('woocommerce_archive_description', [$this, 'woocommerce_output_all_notices'], 10);
		
		add_action('woocommerce_before_shop_loop_item', [$this, 'woocommerce_template_loop_rating'], 5);
		
		/* override woo billing checkout fields */
		add_filter('woocommerce_checkout_fields', [$this, 'override_billing_checkout_fields'], 20, 1);
		
		/* override woo address checkout fields */
		add_filter('woocommerce_default_address_fields', [$this, 'override_default_address_checkout_fields'], 20, 1);
		
		/* override woo order button text */
		add_filter('woocommerce_order_button_text', [$this, 'override_order_button_text']);
		
		add_filter('wc_add_to_cart_message_html', ['FSD_Theme', 'custom_added_to_cart_message'], 10, 3);
		
		/* disable woo select styles / scripts */
		add_action('wp_enqueue_scripts', function () {
			
			wp_dequeue_style('select2');
			wp_dequeue_script('select2');
			wp_dequeue_script('selectWoo');
		}, 11);
		
		/* check if exists woocommerce */
		if (class_exists('Woocommerce')):
			
			/*  enqueue woo styles */
			add_filter('woocommerce_enqueue_styles', [$this, 'woo_enqueue_styles']);
		
		endif;
		
		/* check if exists ocdi */
		if (class_exists('OCDI_Plugin')):
			
			/* disable ocdi branding */
			add_filter('ocdi/disable_pt_branding', '__return_true');
			
			/* ocdi import files */
			add_filter('ocdi/import_files', [$this, 'ocdi_import_files']);
			
			/* ocdi after import */
			add_action('ocdi/after_import', 'fsd_ocdi_after_import_setup');
			
			function fsd_ocdi_after_import_setup($selected_import)
			{
				
				/* define global wp rewrite */
				global $wp_rewrite;
				
				$front_page_id = get_page_by_title('Homepage 1');
				
				$blog_page_id = get_page_by_title('Blog');
				
				$shop_page_id = get_page_by_path('shop');
				
				$wishlist_page_id = get_page_by_path('wishlist');
				
				update_option('page_for_posts', $blog_page_id->ID);
				
				update_option('woocommerce_shop_page_id', $shop_page_id->ID);
				
				if (function_exists('tinv_update_option')):
					
					tinv_update_option('page', 'wishlist', $wishlist_page_id->ID);
				
				endif;
				
				if ('Mono' === $selected_import['import_file_name']) :
					
					/* get front page id */
					$front_page_id = get_page_by_title('Homepage 1');
				
				elseif ('Organic' === $selected_import['import_file_name']) :
					
					$front_page_id = get_page_by_title('Homepage 2');
				
				elseif ('Multi' === $selected_import['import_file_name']) :
					
					$front_page_id = get_page_by_title('Homepage 3');
				
				elseif ('Video' === $selected_import['import_file_name']) :
					
					$front_page_id = get_page_by_title('Homepage 4');
				
				endif;
				
				/* get navigation menu */
				$navigation_menu = get_term_by('name', 'Menu 1', 'nav_menu');
				
				/* set menu navigation */
				set_theme_mod('nav_menu_locations',
						[
								'primary_menu' => $navigation_menu->term_id,
						]
				);
				
				update_option('show_on_front', 'page');
				
				/* set front page */
				update_option('page_on_front', $front_page_id->ID);
				
				/* update rewrite rules to false */
				update_option("rewrite_rules", false);
				
				/* set permalink structure */
				$wp_rewrite->set_permalink_structure('/%postname%/');
				
				/* flush permalinks */
				$wp_rewrite->flush_rules(true);
				
			}
		
		endif;
		
		/* check if exists tgma */
		if (class_exists('TGM_Plugin_Activation')):
			
			/* tgm required plugins */
			add_action('tgmpa_register', [$this, 'register_required_plugins']);
		
		endif;
		
		add_filter('authenticate', 'custom_authenticate_username_password', 30, 3);
		
		function custom_authenticate_username_password($user, $username, $password)
		{
			
			if (is_a($user, 'WP_User')) {
				
				return $user;
				
			}
			
			if (empty($username) || empty($password)) {
				
				$error = new WP_Error();
				
				$user = new WP_Error('authentication_failed', __('ERROR: Invalid username or incorrect password.', 'levre'));
				
				return $error;
				
			}
		}
		
		add_action('wp_login_failed', 'my_front_end_login_fail');
		
		function my_front_end_login_fail($username)
		{
			
			$referrer = wp_get_referer();
			
			if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
				
				wp_redirect(add_query_arg('login', 'failed', $referrer));
				
				exit;
				
			}
			
		}
		
	}
	
	/**
	 * register required theme plugins
	 */
	public function register_required_plugins()
	{
		
		/* plugins array */
		$plugins = [
			/* Levre Core Plugin */
				[
						'name' => 'Levre Core Plugin',
						'slug' => 'fs-wp-levre-core',
						'source' => get_template_directory_uri() . '/plugins/fs-wp-levre-core.zip',
						'required' => true,
						'version' => 1.0,
						'force_activation' => false,
						'force_deactivation' => false,
						'external_url' => '',
				],
			/* Advanced Custom Fields PRO */
				[
						'name' => 'Advanced Custom Fields PRO',
						'slug' => 'advanced-custom-fields-pro',
						'source' => get_template_directory_uri() . '/plugins/advanced-custom-fields-pro.zip',
						'required' => true,
						'version' => 1.0,
						'force_activation' => false,
						'force_deactivation' => false,
						'external_url' => '',
				],
			/* Boxzilla */
				[
						'name' => 'Boxzilla',
						'slug' => 'boxzilla',
						'required' => false,
				],
			/* CF7 */
				[
						'name' => 'Contact Form 7',
						'slug' => 'contact-form-7',
						'required' => false,
				],
			/* Elementor */
				[
						'name' => 'Elementor',
						'slug' => 'elementor',
						'required' => true,
				],
			/* Instagram Feed */
				[
						'name' => 'Smash Balloon Instagram Feed',
						'slug' => 'instagram-feed',
						'required' => false,
				],
			/* Kirki Customizer Framework */
				[
						'name' => 'Kirki',
						'slug' => 'kirki',
						'required' => true,
				],
			/* Woocommerce */
				[
						'name' => 'Mailchimp for WordPress',
						'slug' => 'mailchimp-for-wp',
						'required' => false,
				],
			/* OCDI */
				[
						'name' => 'One Click Demo Import',
						'slug' => 'one-click-demo-import',
						'required' => false,
				],
			/* Woocommerce */
				[
						'name' => 'WooCommerce',
						'slug' => 'woocommerce',
						'required' => true,
				],
			/* PW WooCommerce Gift Cards */
				[
						'name' => 'PW WooCommerce Gift Cards',
						'slug' => 'pw-woocommerce-gift-cards',
						'required' => false,
				],
			/* TI WooCommerce Wishlist */
				[
						'name' => 'TI WooCommerce Wishlist',
						'slug' => 'ti-woocommerce-wishlist',
						'required' => false,
				],
			/* Variation Swatches for WooCommerce */
				[
						'name' => 'Variation Swatches for WooCommerce',
						'slug' => 'woo-variation-swatches',
						'required' => false,
				],
			/* WOOF - WooCommerce Products Filter */
				[
						'name' => 'WOOF - WooCommerce Products Filter',
						'slug' => 'woocommerce-products-filter',
						'required' => false,
				],
			/* Classic Widgets */
				[
						'name' => 'Classic Widgets',
						'slug' => 'classic-widgets',
						'required' => false,
				],
		];
		
		/* tgm config */
		$config = [
				'id' => 'levre',
				'default_path' => get_template_directory() . '/plugins',
				'menu' => 'tgmpa-install-plugins',
				'parent_slug' => 'themes.php',
				'capability' => 'edit_theme_options',
				'has_notices' => true,
				'dismissable' => true,
				'dismiss_msg' => '',
				'is_automatic' => true,
				'message' => '',
		];
		
		/* init tgmpa */
		tgmpa($plugins, $config);
		
	}
	
	/**
	 * @return array
	 */
	public function ocdi_import_files()
	{
		
		/* return main demo */
		return [
			
			/* (#0) main demo */
				[
					/* demo name */
						'import_file_name' => esc_html__('Mono', 'levre'),
					/* demo XML (content) */
						'import_file_url' => 'https://firstsight.design/levre/demo-install/mono.xml',
					/* demo dat (customizer settings) */
						'import_customizer_file_url' => 'https://firstsight.design/levre/demo-install/mono.dat',
					/* import widgets */
						'import_widget_file_url' => 'https://firstsight.design/levre/demo-install/mono.json',
					/* import preview */
						'import_preview_image_url' => 'https://firstsight.design/levre/demo-install/mono.jpg',
					/* preview */
						'preview_url' => 'https://firstsight.design/levre/mono/homepage-1/',
				],
			
			/* (#1) main demo */
				[
					/* demo name */
						'import_file_name' => esc_html__('Organic', 'levre'),
					/* demo XML (content) */
						'import_file_url' => 'https://firstsight.design/levre/demo-install/organic.xml',
					/* demo dat (customizer settings) */
						'import_customizer_file_url' => 'https://firstsight.design/levre/demo-install/organic.dat',
					/* import widgets */
						'import_widget_file_url' => 'https://firstsight.design/levre/demo-install/organic.json',
					/* import preview */
						'import_preview_image_url' => 'https://firstsight.design/levre/demo-install/organic.jpg',
					/* preview */
						'preview_url' => 'https://firstsight.design/levre/mono/homepage-2/',
				],
			
			/* (#2) main demo */
				[
					/* demo name */
						'import_file_name' => esc_html__('Multi', 'levre'),
					/* demo XML (content) */
						'import_file_url' => 'https://firstsight.design/levre/demo-install/multi.xml',
					/* demo dat (customizer settings) */
						'import_customizer_file_url' => 'https://firstsight.design/levre/demo-install/multi.dat',
					/* import widgets */
						'import_widget_file_url' => 'https://firstsight.design/levre/demo-install/multi.json',
					/* import preview */
						'import_preview_image_url' => 'https://firstsight.design/levre/demo-install/multi.jpg',
					/* preview */
						'preview_url' => 'https://firstsight.design/levre/mono/homepage-3/',
				],
			
			/* (#3) main demo */
				[
					/* demo name */
						'import_file_name' => esc_html__('Video', 'levre'),
					/* demo XML (content) */
						'import_file_url' => 'https://firstsight.design/levre/demo-install/video.xml',
					/* demo dat (customizer settings) */
						'import_customizer_file_url' => 'https://firstsight.design/levre/demo-install/video.dat',
					/* import widgets */
						'import_widget_file_url' => 'https://firstsight.design/levre/demo-install/video.json',
					/* import preview */
						'import_preview_image_url' => 'https://firstsight.design/levre/demo-install/video.jpg',
					/* preview */
						'preview_url' => 'https://firstsight.design/levre/mono/homepage-4/',
				],
		
		];
		
	}
	
	/**
	 * @return void
	 */
	public function inline_styles()
	{
		
		$offset = get_theme_mod('blog-grid-offset', esc_attr(15));
		
		if (!empty($_GET['offset'])):
			
			$offset = $_GET['offset'];
		
		endif;
		
		$logotype_width = get_theme_mod('branding-logotype-width', esc_attr('93'));
		
		if (!empty($_GET['logotype_width'])):
			
			$logotype_width = $_GET['logotype_width'];
		
		endif;
		
		$shop_header_bg = '';
		
		$shop_header_type = get_theme_mod('shop-header-type', esc_attr('default'));
		
		if (!empty($_GET['shop_header_type'])):
			
			$shop_header_type = $_GET['shop_header_type'];
		
		endif;
		
		
		if ($shop_header_type === 'image'):
			
			$shop_header_bg = get_theme_mod('shop-header-bg');
		
		endif;
		
		$custom_css = "
		.blog-grid{
			margin: -" . esc_attr($offset) . "px;
		}
		.blog-grid .post-article{
		    padding: " . esc_attr($offset) . "px;
		}
		.theme-logo img{
		    width: " . esc_attr($logotype_width) . "px;
		}
		.shop-archive-header .top-side{
		background-image: url(" . esc_attr($shop_header_bg) . ")
		}
		.product-gallery-main-wrapper{
		opacity: 0; transition: opacity .25s ease-in-out;
		}
		#pwgc-purchase-container,.shipping-calculator-form,.woocommerce-PaymentMethods .woocommerce-PaymentBox,.checkout_pw_gift_card,.hidden-elem,.checkout_coupon{
		display:none;
		}
		";
		
		wp_add_inline_style('fsd-main', $custom_css);
		
	}
	
	
	/**
	 * @param $existing_mimes
	 *
	 * @return mixed
	 */
	public function custom_upload_extensions($existing_mimes)
	{
		
		$existing_mimes['json'] = 'application/json';
		
		/* added dat to current mimes array */
		$existing_mimes['dat'] = 'application/dat';
		
		/* added svg to current mimes array */
		$existing_mimes['svg'] = 'image/svg+xml';
		
		/* added otf to current mimes array */
		$existing_mimes['otf'] = 'application/x-font-otf';
		
		/* added ttf to current mimes array */
		$existing_mimes['ttf'] = 'application/x-font-ttf';
		
		/* added eot to current mimes array */
		$existing_mimes['eot'] = 'application/x-font-eot';
		
		/* added woff to current mimes array */
		$existing_mimes['woff'] = 'application/x-font-woff';
		
		/* added woff2 to current mimes array */
		$existing_mimes['woff2'] = 'application/x-font-woff2';
		
		/* return mimes with new ones */
		
		return $existing_mimes;
		
	}
	
	/**
	 * @return void
	 */
	public function templates_cached()
	{
		
		if (is_admin() && function_exists('elementor_pro_load_plugin') && !\Elementor\Plugin::$instance->preview->is_preview_mode(get_the_id()) && !\Elementor\Plugin::$instance->editor->is_edit_mode(get_the_id())):
			
			$templates = [];
			
			$templates = \Elementor\Plugin::$instance->templates_manager->get_source('local')->get_items([
					'type' => 'section',
			]);
			
			update_option('fs_elementor_templates', $templates, false);
		
		endif;
		
	}
	
	/**
	 * init theme translation (i18n)
	 */
	public function i18n()
	{
		
		/* reg text domain */
		load_theme_textdomain('levre', get_template_directory() . '/lang');
		
	}
	
	/**
	 * @return void
	 */
	public function pingback_header()
	{
		
		if (is_singular() && pings_open()) {
			
			echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
			
		}
		
	}
	
	/**
	 * enqueue theme admin styles
	 */
	public function enqueue_admin_styles()
	{
		
		/* check if admin styles exists */
		if (!wp_style_is('fsd-admin')):
			
			/* enqueue admin styles */
			wp_enqueue_style('fsd-admin', get_template_directory_uri() . '/assets/css/admin.min.css');
		
		endif;
		
	}
	
	/**
	 * enqueue theme styles
	 */
	public function enqueue_styles()
	{
		
		/* check if remix icons styles exists */
		if (!wp_style_is('font-awesome-5')):
			
			/* enqueue remix icons styles */
			wp_enqueue_style('font-awesome-5', get_template_directory_uri() . '/assets/css/all.min.css');
		
		endif;
		
		/* check if default styles exists */
		if (!wp_style_is('fsd-default') && !class_exists('FSD_Core')):
			
			/* enqueue default styles */
			wp_enqueue_style('fsd-default', get_template_directory_uri() . '/assets/css/default.min.css');
		
		endif;
		
		if (is_home() && !wp_style_is('fsd-blog')):
			
			/* enqueue main styles */
			wp_enqueue_style('fsd-blog', get_template_directory_uri() . '/assets/css/blog.min.css');
		
		endif;
		
		if (!wp_style_is('fsd-career')):
			
			/* enqueue career styles */
			wp_enqueue_style('fsd-career', get_template_directory_uri() . '/assets/css/career.min.css');
		
		endif;
		
		if (!wp_style_is('fsd-default-fonts')):
			
			/* enqueue default-fonts styles */
			wp_enqueue_style('fsd-default-fonts', get_template_directory_uri() . '/assets/css/default-fonts.css');
		
		endif;
		
		/* check if woocommerce styles exists */
		if (!wp_style_is('swiper-slider')):
			
			/* enqueue woocommerce styles */
			wp_enqueue_style('swiper-slider', get_template_directory_uri() . '/assets/css/swiper.min.css');
			
			wp_deregister_style('swiper');
		
		endif;
		
		/* check if plyr styles exists */
		if (!wp_style_is('plyr')):
			
			/* enqueue swiper styles */
			wp_enqueue_style('plyr', get_template_directory_uri() . '/assets/css/plyr.min.css');
		
		endif;
		
		/* check if main styles exists */
		if (!wp_style_is('fsd-main')):
			
			/* enqueue main styles */
			wp_enqueue_style('fsd-main', get_template_directory_uri() . '/assets/css/main.min.css');
		
		endif;
		
	}
	
	/**
	 * @param $enqueue_styles
	 *
	 * @return mixed
	 */
	public function woo_enqueue_styles($enqueue_styles)
	{
		
		/* enqueue theme woo styles */
		wp_enqueue_style('fsd-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.min.css');
		
		/* return styles */
		
		return $enqueue_styles;
		
	}
	
	/**
	 * enqueue theme scripts
	 */
	public function enqueue_scripts()
	{
		
		/* check if singular || comments_open || thread_comments option === true */
		if (is_singular() && comments_open() && get_option('thread_comments')) :
			
			/* enqueue comment-reply script */
			wp_enqueue_script('comment-reply');
		
		endif;
		
		/* check if jarallax scripts exists */
		if (!wp_script_is('jarallax')):
			
			/* enqueue jarallax scripts */
			wp_enqueue_script('jarallax', get_template_directory_uri() . '/assets/js/jarallax.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if plyr scripts exists */
		if (!wp_script_is('plyr')):
			
			/* enqueue plyr scripts */
			wp_enqueue_script('plyr', get_template_directory_uri() . '/assets/js/plyr.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if jquery-cookie scripts exists */
		if (!wp_script_is('jquery-cookie')):
			
			/* enqueue jquery-cookie scripts */
			wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/assets/js/jquery.cookie.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if countdown scripts exists */
		if (!wp_script_is('countdown')):
			
			/* enqueue countdown scripts */
			wp_enqueue_script('countdown', get_template_directory_uri() . '/assets/js/countdown.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if swiper scripts exists */
		if (!wp_script_is('swiper')):
			
			/* enqueue swiper scripts */
			wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if easyzoom scripts exists */
		if (!wp_script_is('easyzoom')):
			
			/* enqueue easyzoom scripts */
			wp_enqueue_script('easyzoom', get_template_directory_uri() . '/assets/js/easyzoom.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if marquee scripts exists */
		if (!wp_script_is('marquee')):
			
			/* enqueue marquee scripts */
			wp_enqueue_script('marquee', get_template_directory_uri() . '/assets/js/marquee.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if paroller scripts exists */
		if (!wp_script_is('paroller')):
			
			/* enqueue paroller scripts */
			wp_enqueue_script('paroller', get_template_directory_uri() . '/assets/js/paroller.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
		
		endif;
		
		/* check if main scripts exists */
		if (!wp_script_is('fsd-main')):
			
			/* enqueue main scripts */
			wp_enqueue_script('fsd-main', get_template_directory_uri() . '/assets/js/main.min.js', ['jquery', 'imagesloaded'],
					self::$version, true);
			
			/* localize fsd_ajax object */
			wp_localize_script('fsd-main', 'fsd_ajax', [
					'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
			]);
		
		endif;
		
	}
	
	/**
	 *
	 */
	public function css_variables()
	{
		
		$variables = "
		:root {
		     --check-icon-url: url('" . get_template_directory_uri() . "/assets/img/check.svg');
		     --chevron-down-icon-url: url('" . get_template_directory_uri() . "/assets/img/chevron-down.svg');
		     --gallery-cursor: url('" . get_template_directory_uri() . "/assets/img/hover-plus.svg');
		     --close-icon-url: url('" . get_template_directory_uri() . "/assets/img/close.svg');
		     --select-arrow-url: url('" . get_template_directory_uri() . "/assets/img/select-arrow.svg');
		}";
		
		wp_add_inline_style('fsd-main', $variables);
		
	}
	
	/**
	 * init navigation area
	 */
	public function init_navigation_area()
	{
		
		/* register primary nav menu (navigation area) */
		register_nav_menus([
				'primary_menu' => esc_html__('Navigation Menu', 'levre'),
		]);
		
	}
	
	/**
	 * init sidebar area
	 */
	public function init_sidebar_area()
	{
		
		if (class_exists('FSD_Core')):
			
			/* register footer sidebar */
			register_sidebar([
					'name' => esc_html__('Footer sidebar', 'levre'),
					'id' => 'footer-sidebar',
					'description' => esc_html__('Footer sidebar', 'levre'),
					'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s" >',
					'after_widget' => '</div>',
					'before_title' => '<h6 class="widget-title">',
					'after_title' => '</h6>',
			]);
			
			/* register shop sidebar */
			register_sidebar([
					'name' => esc_html__('Shop filters sidebar', 'levre'),
					'id' => 'shop-filters-sidebar',
					'description' => esc_html__('Shop filters sidebar', 'levre'),
					'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s" >',
					'after_widget' => '</div>',
					'before_title' => '<h6 class="widget-title">',
					'after_title' => '</h6>',
			]);
		
		else:
			
			/* register default blog sidebar */
			register_sidebar([
					'name' => esc_html__('Blog sidebar', 'levre'),
					'id' => 'blog-sidebar',
					'description' => esc_html__('Blog sidebar', 'levre'),
					'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s" >',
					'after_widget' => '</div>',
					'before_title' => '<h4 class="widget-title">',
					'after_title' => '</h4>',
			]);
		
		endif;
		
	}
	
	/**
	 * theme setup
	 */
	public function theme_setup()
	{
		
		/* add editor styles */
		add_editor_style();
		
		/* add automatic-feed-links support */
		add_theme_support('automatic-feed-links');
		
		/* add post-thumbnails support */
		add_theme_support('post-thumbnails');
		
		/* add html5 support */
		add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
		
		/* add customize-selective-refresh-widgets support */
		add_theme_support('customize-selective-refresh-widgets');
		
		/* add title-tag support */
		add_theme_support("title-tag");
		
		/* add editor-styles support */
		add_theme_support('editor-styles');
		
		if (class_exists('WooCommerce')):
			
			remove_theme_support('wc-product-gallery-zoom');
			
			remove_theme_support('wc-product-gallery-slider');
			
			/* add woocommerce support */
			add_theme_support('woocommerce');
		
		endif;
		
		if (!isset($content_width)):
			
			$content_width = 1200;
		
		endif;
		
	}
	
	/**
	 * @param $fields
	 *
	 * @return mixed
	 */
	public function comment_form_default_fields($fields)
	{
		
		/* check if is singgile post */
		if (is_singular('post') || (!class_exists('FSD_Core') && is_page())):
			
			/* get current commenter */
			$commenter = wp_get_current_commenter();
			
			/* get requite name email */
			$req = get_option('require_name_email');
			
			/* set aria req */
			$aria_req = $req ? "aria-required='true'" : '';
			
			/* set new author field */
			$fields['author'] = '<div class="input-wrapper"><p class="comment-form-author input-field-wrapper">
            <input id="author" 
            class="input-field fs-input"
            name="author" 
            type="text" 
            placeholder="' . esc_attr("Default *") . '" 
            value="' . esc_attr($commenter['comment_author']) . '" 
            size="30" ' . $aria_req . ' /></p>';
			
			/* set new email field */
			$fields['email'] = '<p class="comment-form-email input-field-wrapper">
            <input id="email" 
            class="input-field fs-input"
            name="email" 
            type="email" 
            placeholder="' . esc_attr("Email *") . '" 
            value="' . esc_attr($commenter['comment_author_email']) . '" 
            size="30" ' . $aria_req . ' /></p>';
			
			/* set new website url field */
			$fields['url'] = '<p class="comment-form-url input-field-wrapper">
            <input id="url" 
            class="input-field fs-input"
            name="url" 
            type="url"  
            placeholder="' . esc_attr("Website") . '" 
            value="' . esc_attr($commenter['comment_author_url']) . '" 
            size="30" /></p></div>';
		
		endif;
		
		unset($commenter);
		
		unset($req);
		
		unset($aria_req);
		
		/* return modified fields */
		
		return $fields;
		
	}
	
	/**
	 * @param $comment_field
	 *
	 * @return string
	 */
	public function comment_form_field_comment($comment_field)
	{
		
		/* check if is single post */
		if (is_singular('post') || (!class_exists('FSD_Core') && is_page())):
			
			/* set new comment field */
			$comment_field = '<div class="comment-form-textarea">
            <textarea required id="comment" 
            name="comment"  class="fs-textarea"
            placeholder="' . esc_attr__("Comment *", "levre") . '" 
            aria-required="true"></textarea></div>';
		
		endif;
		
		/* return modified field */
		
		return $comment_field;
		
	}
	
	/**
	 * @return string
	 */
	public function add_lost_password_link()
	{
		
		return '<p class="login-lost"><a href="' . esc_url('/wp-login.php?action=lostpassword') . '">' . esc_html__('Lost Password?', 'levre') . '</a></p>';
		
	}
	
	/**
	 * @param      $comment
	 * @param bool $depth
	 * @param bool $args
	 */
	public static function comment_template($comment, $depth = false, $args = false)
	{
		
		/* check if comment exists */
		if ($comment):
			
			?>
			
			<!-- comment -->
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent', $comment); ?>>
				
				<!-- comment body -->
				<div class="comment-body">
					
					<!-- author avatar -->
					<div class="author-avatar">
						
						<?php
						
						/* check if avatar size is empty */
						if (empty($args['avatar_size'])):
							
							/* avatar size */
							$avatar_size = 100;
						
						else:
							
							/* avatar size */
							$avatar_size = $args['avatar_size'];
						
						endif;
						
						/* output avatar */
						echo get_avatar($comment, $avatar_size);
						
						unset($avatar_size);
						
						?>
					
					</div>
					
					<!-- comment content -->
					<div class="comment-content">
						
						<!-- author name -->
						<h6 class="author-name">
							
							<?php
							
							/* comment author link */
							comment_author_link();
							
							?>
						
						</h6>
						
						<!-- date wrapper -->
						<div class="date-wrapper">
							
							<!-- date -->
							<p class="date">
								
								<?php
								
								/* output comment date */
								printf(esc_html('%1$s at %2$s'), get_comment_date(), get_comment_time());
								
								?>
							
							</p>
						
						</div>
						
						<!-- comment text -->
						<div class="comment-text">
							
							<?php
							
							/* output comment text */
							comment_text();
							
							/* output comment reply link */
							comment_reply_link([
									'reply_text' => esc_html__('Reply', 'levre'),
									'depth' => 5,
									'max_depth' => 10,
									'before' => '<span class="reply-link-wrapper">',
									'after' => '</span>'
							], $comment);
							
							?>
						
						</div>
						
						<?php if ('0' == $comment->comment_approved) : ?>
							
							<!-- comment awaiting moderation -->
							<p class="comment-awaiting-moderation">
								
								<?php echo esc_html__('Your comment is awaiting moderation.', 'levre'); ?>
							
							</p>
						
						<?php endif; ?>
					
					</div>
				
				</div>
			
			</li>
		
		<?php
		
		endif;
		
	}
	
	/**
	 * @return void
	 */
	public function blog_load_more()
	{
		
		wp_reset_postdata();
		
		global $wp_query;
		
		$query = $wp_query->query_vars;
		
		$paged = $_POST['paged'];
		
		$offset = get_theme_mod('blog-grid-offset', esc_attr(15));
		
		
		if (!empty($_GET['offset'])):
			
			$offset = $_GET['offset'];
		
		endif;
		
		
		$query['paged'] = $paged + 1;
		
		query_posts($query);
		
		if (have_posts()) :
			
			// run the loop
			while (have_posts()): the_post();
				
				$category = get_the_category();
				
				$date = get_the_date();
				
				$title = get_the_title();
				
				?>
				
				<article <?php post_class('post-article blog-card'); ?>">
				
				<div class="post-inner">
					
					<?php if (has_post_thumbnail()): ?>
						
						<div class="post-header">
							
							<a href="<?php the_permalink(); ?>" class="link-overlay"></a>
							
							<?php
							
							if (class_exists('FSD_Helper')):
								
								$image_id = get_post_thumbnail_id(get_the_ID());
								
								echo FSD_Helper::render_image($image_id,
										'fs-vertical-size-medium',
										['sizes' => implode(',', [
												'(max-width: 300px) 300px',
												'(max-width: 540px) 540px',
										]),
												'srcset' => implode(',', [
														esc_url(wp_get_attachment_image_url($image_id, 'fs-vertical-size-extra-small')) . ' 300w',
														esc_url(wp_get_attachment_image_url($image_id, 'fs-vertical-size-small')) . ' 540w',
												]),
												'loading' => 'lazy',
												'alt' => get_the_title()
										], false);
							
							else:
								
								the_post_thumbnail();
							
							endif;
							
							?>
						
						</div>
					
					<?php endif; ?>
					
					<div class="post-body">
						
						<?php if (!empty($category) || !empty($date)): ?>
							
							<div class="meta-wrapper">
								
								<?php if (!empty($category)): ?>
									
									<a class="category-name meta-item"
									   href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
										
										<?php echo esc_html($category[0]->name); ?>
									
									</a>
								
								<?php endif; ?>
								
								<?php if (!empty($date)): ?>
									
									<p class="date meta-item">
										
										<?php echo esc_html($date); ?>
									
									</p>
								
								<?php endif; ?>
							
							</div>
						
						<?php endif; ?>
						
						<?php if (!empty($title)): ?>
							
							<?php if (class_exists('FSD_Core')): ?>
								
								<h6 class="post-title body-5">
									
									<a href="<?php the_permalink(); ?>">
										
										<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
									
									</a>
								
								</h6>
							
							<?php else: ?>
								
								<h4 class="post-title-default">
									
									<a href="<?php the_permalink(); ?>">
										
										<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
									
									</a>
								
								</h4>
							
							<?php endif; ?>
						
						<?php endif; ?>
					
					</div>
				
				</div>
				
				</article>
			
			<?php
			
			endwhile;
		
		endif;
		
		wp_reset_postdata();
		
		die();
		
	}
	
	/**
	 * @return void
	 */
	public function shop_load_more()
	{
		
		$sorting = $_POST['sorting'];
		
		$category = $_POST['category'];
		
		$sorting = explode(' ', $sorting);
		
		wp_reset_postdata();
		
		if ($sorting[0] === 'date' && !empty($sorting)):
			
			$order = 'DESC';
		
		else:
			
			$order = 'ASC';
		
		endif;
		
		$args = [
				'post_type' => 'product',
				'paged' => $_POST['paged'] + 1,
				'orderby' => $sorting[0],
				'order' => $order,
				'posts_per_page' => get_theme_mod('shop-number-of-items', esc_attr(12)),
		];
		
		if (!empty($category)):
			
			$args['tax_query'] = [
					'relation' => 'AND',
					[
							'taxonomy' => 'product_cat',
							'field' => 'slug',
							'terms' => $category
					],
			];
		
		endif;
		
		$loop = new WP_Query($args);
		
		if ($loop->have_posts()) :
			
			while ($loop->have_posts()) : $loop->the_post();
				
				wc_get_template_part('content', 'product');
			
			endwhile;
		
		endif;
		
		wp_reset_postdata();
		
		die();
		
	}
	
	/**
	 * @return void
	 */
	public function switch_login()
	{
		
		?>
		
		<div class="form-wrapper">
			
			<h2 class="form-title">
				
				<?php echo esc_html__('Login', 'levre'); ?>
			
			</h2>
			
			<?php
			
			if (class_exists('WooCommerce')):
				
				$myaccount_page = get_option('woocommerce_myaccount_page_id');
				
				$myaccount_page_url = get_permalink($myaccount_page);
			
			else:
				
				$myaccount_page_url = esc_url(get_home_url());
			
			endif;
			
			wp_login_form([
					'echo' => true,
					'redirect' => $myaccount_page_url,
					'form_id' => 'loginform',
					'label_username' => __('Username or email address *', 'levre'),
					'label_password' => __('Password *', 'levre'),
					'label_remember' => __('Remember Me', 'levre'),
					'label_log_in' => __('Log In', 'levre'),
					'id_username' => 'user_login',
					'id_password' => 'user_pass',
					'id_remember' => 'rememberme',
					'id_submit' => 'wp-submit',
					'remember' => true,
					'value_username' => null,
					'value_remember' => false
			]);
			
			?>
		
		</div>
		
		<div class="auth-redirect-wrapper">
			
			<h5 class="info-message">
				
				<?php echo esc_html__('Don’t have an account?', 'levre'); ?>
			
			</h5>
			
			<button class="auth-switcher fs-button dark-border-style">
				
				<?php echo esc_html__('Register', 'levre'); ?>
			
			</button>
		
		</div>
		
		<?php
		
		die();
		
	}
	
	/**
	 * @return void
	 */
	public function register_handler()
	{
		
		$info = [];
		
		$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']);
		
		$info['user_pass'] = sanitize_text_field($_POST['password']);
		
		$info['user_email'] = sanitize_email($_POST['email']);
		
		$info['role'] = 'customer';
		
		$user_register = wp_insert_user($info);
		
		if (is_wp_error($user_register)) :
			
			$error = $user_register->get_error_codes();
			
			if (in_array('empty_user_login', $error)):
				
				$string = json_encode(['loggedin' => false, 'redirecturl' => home_url(), 'message' => _($user_register->get_error_message('empty_user_login'))]);
				
				$string = str_replace('\\', '', $string);
				
				echo esc_attr($string);
			
			elseif (in_array('existing_user_login', $error)):
				
				$string = json_encode(['loggedin' => false, 'redirecturl' => home_url(), 'message' => _('This username is already registered.', 'levre')]);
				
				$string = str_replace('\\', '', $string);
				
				echo esc_attr($string);
			
			elseif (in_array('existing_user_email', $error)):
				
				$string = json_encode(['loggedin' => false, 'redirecturl' => home_url(), 'message' => _('This email address is already registered.', 'levre')]);
				
				$string = str_replace('\\', '', $string);
				
				echo esc_attr($string);
			
			endif;
		
		else :
			
			wp_signon([
					'user_login' => $info['nickname'],
					'user_password' => $info['user_pass'],
			], false);
		
		endif;
		
		if (class_exists('WooCommerce')):
			
			$myaccount_page = get_option('woocommerce_myaccount_page_id');
			
			$myaccount_page_url = get_permalink($myaccount_page);
		
		else:
			
			$myaccount_page_url = esc_url(get_home_url());
		
		endif;
		
		echo esc_url($myaccount_page_url);
		
		die();
		
	}
	
	/**
	 * @return void
	 */
	public function switch_reg()
	{
		
		?>
		
		<h2 class="form-title">
			
			<?php echo esc_html__('Create an account', 'levre'); ?>
		
		</h2>
		
		<form class="registration-form">
			
			<input type="text" name="username" placeholder="<?php echo esc_attr__('Username *', 'levre'); ?>"
			       class="fs-input" required>
			
			<input type="email" name="email" placeholder="<?php echo esc_attr__('Email *', 'levre'); ?>"
			       class="fs-input" required>
			
			<input type="password" name="password" placeholder="<?php echo esc_attr__('Password *', 'levre'); ?>"
			       class="fs-input"
			       required>
			
			<input type="password" name="repeat-password"
			       placeholder="<?php echo esc_attr__('Repeat Password *', 'levre'); ?>" class="fs-input" required>
			
			<button class="fs-button dark-style" type="submit">
				
				<?php echo esc_html__('Register', 'levre'); ?>
			
			</button>
			
			<div class="reg-alert">
			
			</div>
		
		</form>
		
		<div class="auth-redirect-wrapper">
			
			<h5 class="info-message">
				
				<?php echo esc_html__('Already have an account?', 'levre'); ?>
			
			</h5>
			
			<button class="auth-switcher fs-button dark-border-style">
				
				<?php echo esc_html__('Login', 'levre'); ?>
			
			</button>
		
		</div>
		
		<?php
		
		die();
		
	}
	
	/**
	 * @param $message
	 * @param $products
	 *
	 * @return string
	 */
	public static function custom_added_to_cart_message($message, $products)
	{
		
		$count = 0;
		
		$titles = [];
		
		if (count($products) === 1):
			
			$message = '<div class="image-wrapper">';
		
		endif;
		
		foreach ($products as $product_id => $qty) :
			
			$titles[] = ($qty > 1 ? absint($qty) . ' &times; ' : '') . sprintf(_x('&ldquo;%s&rdquo;', 'Item name in quotes', 'levre'), strip_tags(get_the_title($product_id)));
			
			$count += $qty;
			
			if (count($products) === 1):
				
				$product = wc_get_product($product_id);
				
				$image_id = $product->get_image_id();
				
				$image_url = wp_get_attachment_image_url($image_id, 'fs-vertical-size-small');
				
				$message .= '<a href="' . esc_url($product->get_permalink()) . '"><img src="' . $image_url . '"></a>';
			
			endif;
		
		endforeach;
		
		if (count($products) === 1):
			
			$message .= '</div>';
		
		endif;
		
		$titles = array_filter($titles);
		
		$added_text = sprintf(_n(
				'%s has been added to your bag.',
				'%s has been added to your bag.',
				$count,
				'levre'
		), wc_format_list_of_items($titles));
		
		$message .= sprintf('<div class="notice-inner-wrapper"><p class="notice-message">%s</p><a href="%s" class="fs-link">%s <img src="' . esc_url(get_template_directory_uri() . '/assets/img/arrow.svg') . '"
                                     alt="' . esc_attr__('Arrow', 'levre') . '"> </a></div>', esc_html($added_text), esc_url(wc_get_page_permalink('cart')), esc_html__('View Bag', 'levre'));
		
		
		return $message;
		
	}
	
	/**
	 * @return string|void
	 */
	public function override_order_button_text()
	{
		
		/* new order button text */
		return esc_html__('Apply Now', 'levre');
		
	}
	
	/**
	 * @param $fields
	 *
	 * @return mixed
	 */
	public function override_billing_checkout_fields($fields)
	{
		
		if (!empty($fields['billing']['billing_phone'])):
			
			if ($fields['billing']['billing_phone']['required']):
				
				/* billing phone field */
				$fields['billing']['billing_phone']['placeholder'] = esc_html__('Phone (required)', 'levre');
			
			else:
				
				/* billing phone field */
				$fields['billing']['billing_phone']['placeholder'] = esc_html__('Phone (optional)', 'levre');
			
			endif;
		
		endif;
		
		/* billing email field */
		$fields['billing']['billing_email']['placeholder'] = esc_html__('Email Address', 'levre');
		
		/* return modified fields */
		
		return $fields;
		
	}
	
	
	/**
	 * @return void
	 */
	public function change_products_loop_title()
	{
		
		echo '<h5 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</h6>';
		
	}
	
	/**
	 * @param $address_fields
	 *
	 * @return mixed
	 */
	public function override_default_address_checkout_fields($address_fields)
	{
		
		/* address name field */
		$address_fields['first_name']['placeholder'] = esc_html__('First Name', 'levre');
		
		/* address last name field */
		$address_fields['last_name']['placeholder'] = esc_html__('Last Name', 'levre');
		
		if (!empty($address_fields['address_1'])):
			
			if ($address_fields['address_1']['required']):
				
				/* address 1 field */
				$address_fields['address_1']['placeholder'] = esc_html__('Address (required)', 'levre');
			
			else:
				
				/* address 1 field */
				$address_fields['address_1']['placeholder'] = esc_html__('Address (optional)', 'levre');
			
			endif;
		
		endif;
		
		if (!empty($address_fields['company'])):
			
			if ($address_fields['company']['required']):
				
				/* address company field */
				$address_fields['company']['placeholder'] = esc_html__('Company Name (required)', 'levre');
			
			else:
				
				/* address company field */
				$address_fields['company']['placeholder'] = esc_html__('Company Name (optional)', 'levre');
			
			endif;
		
		endif;
		
		/* address state field */
		$address_fields['state']['placeholder'] = esc_html__('State / Country', 'levre');
		
		/* address country field */
		$address_fields['country']['placeholder'] = esc_html__('Select Country', 'levre');
		
		/* address postcode field */
		$address_fields['postcode']['placeholder'] = esc_html__('Postcode / Zip', 'levre');
		
		/* address city field */
		$address_fields['city']['placeholder'] = esc_html__('Town / City', 'levre');
		
		/* return modified fields */
		
		return $address_fields;
		
	}
	
	/**
	 * @return void
	 */
	public function woocommerce_output_all_notices()
	{
		
		echo '<div class="woocommerce-notices-wrapper">';
		
		wc_print_notices();
		
		echo '</div>';
		
	}
	
	/**
	 * @return void
	 */
	public function woocommerce_template_loop_rating()
	{
		
		wc_get_template('loop/rating.php');
		
	}
	
	/**
	 * @return mixed
	 */
	public function set_products_per_page()
	{
		
		return get_theme_mod('shop-number-of-items', esc_attr(12));
		
	}
	
	/**
	 * @return mixed
	 */
	public function set_columns_count()
	{
		
		
		if (!empty($_GET['shop_columns'])):
			
			return $_GET['shop_columns'];
		
		else:
			
			return get_theme_mod('shop-number-of-grid-column', 4);
		
		endif;
		
	}
	
	/**
	 * @return void
	 */
	public function coupon_code()
	{
		
		?>
		
		<?php if (wc_coupons_enabled()) { ?>
		<div class="coupon">
			
			<p class="coupon-title">
				
				<?php echo esc_html__('Coupon', 'levre'); ?>
			
			</p>
			
			<div class="coupon-form-wrapper">
				<form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
					<input type="text"
					       name="coupon_code"
					       class="input-text fs-input"
					       id="coupon_code"
					       value=""
					       placeholder="<?php esc_attr_e('Coupon code', 'levre'); ?>" />
					<button type="submit" class="fs-button dark-border-style" name="apply_coupon"
					        value="<?php esc_attr_e('Apply', 'levre'); ?>"><?php esc_attr_e('Apply', 'levre'); ?></button>
				</form>
			</div>
			
			<?php do_action('woocommerce_cart_coupon'); ?>
		
		</div>
	<?php } ?>
		
		<?php
		
	}
	
	/**
	 * @param $str
	 *
	 * @return mixed|void
	 */
	public static function check_for_empty($str)
	{
		
		if (!empty($str)):
			
			return $str;
		
		endif;
		
	}
	
	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function str_kses($str)
	{
		
		$allowed_tags = [
				'img' => [
						'src' => [],
						'alt' => [],
						'width' => [],
						'height' => [],
						'class' => [],
				],
				'a' => [
						'href' => [],
						'title' => [],
						'class' => [],
				],
				'span' => [
						'class' => [],
				],
				'br' => [],
				'div' => [
						'class' => [],
						'id' => [],
				],
				'h1' => [
						'class' => [],
						'id' => [],
				],
				'h2' => [
						'class' => [],
						'id' => [],
				],
				'h3' => [
						'class' => [],
						'id' => [],
				],
				'h4' => [
						'class' => [],
						'id' => [],
				],
				'h5' => [
						'class' => [],
						'id' => [],
				],
				'h6' => [
						'class' => [],
						'id' => [],
				],
				'p' => [
						'class' => [],
						'id' => [],
				],
				'strong' => [
						'class' => [],
						'id' => [],
				],
				'b' => [
						'class' => [],
						'id' => [],
				],
				'i' => [
						'class' => [],
						'id' => [],
				],
				'del' => [
						'class' => [],
						'id' => [],
				],
				'ul' => [
						'class' => [],
						'id' => [],
				],
				'li' => [
						'class' => [],
						'id' => [],
				],
				'ol' => [
						'class' => [],
						'id' => [],
				],
				'input' => [
						'class' => [],
						'id' => [],
						'type' => [],
						'style' => [],
						'name' => [],
						'value' => [],
				],
		];
		
		if (function_exists('wp_kses')) {
			
			return wp_kses($str, $allowed_tags);
			
		}
		
	}
	
}