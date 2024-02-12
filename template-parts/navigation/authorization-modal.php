<?php defined('ABSPATH') || exit;

if (!is_user_logged_in()): ?>
	
	<div class="authorization-popup-overlay login-form <?php if (!empty($_GET['login'])): ?>active<?php endif; ?>">
		
		<div class="authorization-popup">
			
			<div class="close-button">
				
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/close.svg'); ?>"
				     alt="<?php echo esc_attr__('Close icon', 'levre'); ?>">
			
			</div>
			
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
				
				<?php if (!empty($_GET['login']) && $_GET['login'] === 'failed'): ?>
					
					<div class="error-wrapper">
						
						<?php echo esc_html('Please fill in all fields correctly', 'levre'); ?>
					
					</div>
				
				<?php endif; ?>
				
				<div class="auth-redirect-wrapper">
					
					<h5 class="info-message">
						
						<?php echo esc_html__('Don’t have an account?', 'levre'); ?>
					
					</h5>
					
					<button class="auth-switcher fs-button dark-border-style">
						
						<?php echo esc_html__('Register', 'levre'); ?>
					
					</button>
				
				</div>
			
			</div>
		
		</div>
	
	</div>

<?php endif; ?>