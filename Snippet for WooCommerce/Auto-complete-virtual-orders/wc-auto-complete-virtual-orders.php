<?php
/**
 * Automatically complete WooCommerce orders
 * for fully virtual or downloadable products.
 * Skip Bacs / manual Transfer.
 */

add_action( 'woocommerce_thankyou', 'auto_complete_virtual_downloadable_orders' );

function auto_complete_virtual_downloadable_orders( $order_id ) {
	if ( ! $order_id ) {
		return;
	}

	$order = wc_get_order( $order_id );

	if ( ! $order instanceof WC_Order ) {
		return;
	}

	if ( $order->get_status() === 'completed' ) {
		return;
	}

	$payment_method = $order->get_payment_method();

	// Skip manual bank transfer orders
	if ( $payment_method === 'bacs' ) {
		return;
	}

	$virtual_downloadable = true;

	foreach ( $order->get_items() as $item ) {
		$product = $item->get_product();

		if ( ! $product || ( ! $product->is_virtual() && ! $product->is_downloadable() ) ) {
			$virtual_downloadable = false;
			break;
		}
	}

	if ( $virtual_downloadable ) {
		$order->update_status( 'completed' );
	}
}
