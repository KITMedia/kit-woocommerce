<?php
/*
Plugin Name:  KIT Woocommerce
Plugin URI:   https://kitmedia.se
Version:      0.1.1
Description:  KIT Woocommerce customizer
Author:       KIT Media
Author URI:   https://kitmedia.se
GitHub Plugin URI: KITMedia/kit-woocommerce
GitHub Plugin URI: https://github.com/KITMedia/kit-woocommerce
*/

add_action( 'init', 'kit_woocommerce_init' );

function kit_woocommerce_init() {

	if ( class_exists( 'WC_Facebookcommerce_Integration' ) ) {
		// Handle integration with Woocommerce + Facebook product export

		add_filter( "facebook_for_woocommerce_integration_prepare_product", function ( $product_data, $id ) {
			// WooZone Specifics
			if ( class_exists( 'WooZone' ) ) {
				// Image url (replace with cool version from Imgix)
				$product_data['image_url'] = $product_data['image_url'] . '?kit-woocommerce';

				// get option: WooZone_amazon for aff-tag and accesskey
				// get metadata:  _amzASIN for product ASIN

				// Fetch WooZone data
				$amz_settings   = get_option( 'WooZone_amazon' );
				$affiliate_ids  = $amz_settings['AffiliateID'];
				$main_affiliate = $affiliate_ids[ $amz_settings['main_aff_id'] ];
				$access_key_id  = $amz_settings['AccessKeyID'];
				$amz_asin       = get_post_meta( $id, '_amzASIN', true );

				$amz_checkout = 'https://www.amazon.com/gp/aws/cart/add.html?AssociateTag=%s&SubscriptionId=%s&ASIN.1=%s&Quantity.1=1';
				$checkout_url = sprintf( $amz_checkout,
					$main_affiliate, // Todo: should this somehow be dynamic based on product?
					$access_key_id,
					$amz_asin
				);
				
				$amz_product = 'https://www.amazon.com/gp/product/%s/?tag=%s';
				$product_url = sprintf( $amz_product,
					$amz_asin,
					$main_affiliate // Todo: should this somehow be dynamic based on product?
				);

				// Product url (maybe link directly to Amazon item)
				$product_data['url'] = $product_url;

				// Checkout url (maybe checkout directly at Amazon)
				$product_data['checkout_url'] = $checkout_url;
			}

			return $product_data;
		}, 10, 2 );
	}
}