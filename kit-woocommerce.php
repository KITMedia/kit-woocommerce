<?php
/*
Plugin Name:  KIT Woocommerce
Plugin URI:   https://kitmedia.se
Description:  KIT Woocommerce customizer
Author:       KIT Media
Author URI:   https://kitmedia.se
*/


add_action( 'init', 'kit_woocommerce_init' );

function kit_woocommerce_init() {

	add_filter( "facebook_for_woocommerce_integration_prepare_product", function ( $product_data, $id ) {

		// Image url (replace with cool version from Imgix)
		$product_data['image_url'] = $product_data['image_url'] . '?kit-woocommerce';

		// Product url (maybe link directly to Amazon item)
		$product_data['url'] = $product_data['url'] . '?kit-woocommerce';

		// Checkout url (maybe checkout directly at Amazon)
		$product_data['checkout_url'] = $product_data['checkout_url'] . '&kit-woocommerce';

		return $product_data;
	} );
}