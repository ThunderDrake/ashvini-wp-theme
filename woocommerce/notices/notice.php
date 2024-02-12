<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-info"<?php echo wc_get_notice_data_attr( $notice ); ?>>

        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/info.svg') ?>"
             alt="<?php echo esc_attr__('Info Item','levre'); ?>" class="message-icon">

		<?php echo wc_kses_notice( $notice['notice'] ); ?>
        <div class="toast-close-button close-button">

            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close-tost.svg'); ?>"
                 alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">

        </div>
	</div>
<?php endforeach; ?>
