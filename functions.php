<?php defined('ABSPATH') || exit;

/* include class-tgm-plugin-activation */
require_once(get_template_directory() . '/class-tgm-plugin-activation.php');

/* include menu walker */
require_once(get_template_directory() . '/class-fsd-walker.php');

/* include main theme class */
require_once(get_template_directory() . '/class-fsd-theme.php');

/* theme instance */
$FSD_Theme = new FSD_Theme([
	/* theme version */
	'version' => '2.5',
	/* theme name */
	'name' => esc_html__('Levre', 'levre'),
]);

add_filter('https_ssl_verify', '__return_false');