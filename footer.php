<?php defined('ABSPATH') || exit;

if (class_exists('WooCommerce')):
	
	if (is_cart() || is_checkout() || is_account_page() || is_product() || is_shop() || is_product_taxonomy()):
		
		?>
		
		</div>
		
		</div>
		
		<?php
		
		wp_reset_postdata();
	
	endif;

endif;

if (function_exists('tinv_get_option_defaults')):
	
	if (is_wishlist()):
		
		?>
		
		</div>
		
		</div>
	
	<?php
	
	endif;

endif;

/* reset postdata */
wp_reset_postdata();

/* include footer template */
get_template_part('template-parts/navigation/footer');

?>

</div>
<!-- /page-wrapper -->

<?php

/* reset postdata */
wp_reset_postdata();

/* footer */
wp_footer();

?>

</body>
<!-- /BODY -->

</html>
<!-- /HTML -->