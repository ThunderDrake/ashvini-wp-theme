<?php

/*
Copyright (C) 2016-2017 Pimwick, LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) || exit;

global $pw_gift_cards_redeeming;
if ( $pw_gift_cards_redeeming->cart_contains_gift_card() && 'yes' !== get_option( 'pwgc_allow_gift_card_purchasing', 'yes' ) ) {
    return;
}

if ( 'before_checkout_form' === get_option( 'pwgc_redeem_checkout_location', 'review_order_before_submit' ) ) {
	?>
	<div class="woocommerce-form-coupon-toggle">
		<?php wc_print_notice( __( 'Have a gift card?', 'levre' ) . ' <a href="#" class="show-pw-gift-card">' . __( 'Click here to enter your gift card number', 'levre' ) . '</a>', 'notice' ); ?>
	</div>

	<form class="checkout_pw_gift_card woocommerce-form-coupon" method="post">

		<p><?php esc_html_e( 'If you have a gift card number, please apply it below.', 'levre' ); ?></p>

		<p class="form-row form-row-first">
			<input type="text" name="pw_gift_card_number" class="input-text fs-input" placeholder="<?php esc_attr_e( 'Gift card number', 'levre' ); ?>" id="pwgc-redeem-gift-card-number" value="" />
		</p>

		<p class="form-row form-row-last">
			<input type="submit" class="button" name="apply_pw_gift_card" id="pwgc-apply-gift-card-checkout" value="<?php esc_attr_e( 'Apply', 'levre' ); ?>" data-wait-text="<?php esc_html_e( 'Please wait...', 'levre' ); ?>">
		</p>

		<p>
			<span id="pwgc-redeem-error"></span>
		</p>

		<div class="clear"></div>
	</form>
	<?php
}
