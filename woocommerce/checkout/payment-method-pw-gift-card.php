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

defined( 'ABSPATH' ) or exit;

global $pw_gift_cards_redeeming;
if ( $pw_gift_cards_redeeming->cart_contains_gift_card() && 'yes' !== get_option( 'pwgc_allow_gift_card_purchasing', 'yes' ) ) {
    return;
}

if ( 'review_order_before_submit' === get_option( 'pwgc_redeem_checkout_location', 'review_order_before_submit' ) ) {
    ?>
    <div id="pwgc-redeem-gift-card-form">
        <form id="pwgc-redeem-form">
            <label for="pwgc-redeem-gift-card-number"><?php _e( 'Have a gift card?', 'levre' ); ?></label>
            <div id="pwgc-redeem-error"></div>
           <div class="input-wrapper">
               <input type="text" id="pwgc-redeem-gift-card-number" class="fs-input" name="card_number" autocomplete="off" placeholder="<?php esc_attr_e( 'Gift card number', 'levre' ); ?>">
               <input type="submit" id="pwgc-redeem-button" class="fs-button dark-border-style" data-wait-text="<?php esc_attr_e( 'Please wait...', 'levre' ); ?>" value="<?php esc_html_e( 'Apply', 'levre' ); ?>">
           </div>
        </form>
    </div>
    <script>
        jQuery(function() {
            jQuery('#pwgc-redeem-form').off('submit.pimwick').on('submit.pimwick', function(e) {
                pwgc_checkout_redeem_gift_card(jQuery('#pwgc-redeem-button'));
                e.preventDefault();
                return false;
            });
        });
    </script>
    <?php
}
