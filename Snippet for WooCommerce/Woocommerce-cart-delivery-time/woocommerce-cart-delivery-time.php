<?php
/**
 * WooCommerce Cart Delivery Time in Product Title
 * Description: Adds delivery time from the product_delivery_time taxonomy under the product name on the cart page.

 */

add_filter( 'woocommerce_cart_item_name', 'custom_add_delivery_time_from_taxonomy_to_cart_title', 10, 3 );

function custom_add_delivery_time_from_taxonomy_to_cart_title( $product_name, $cart_item, $cart_item_key ) {
    if ( ! is_cart() ) return $product_name;

    $product    = $cart_item['data'];
    $product_id = $product->get_id();

    if ( $product->is_type( 'variation' ) ) {
        $parent_id = $product->get_parent_id();
    } else {
        $parent_id = $product_id;
    }

    $terms = wp_get_post_terms( $parent_id, 'product_delivery_time' );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        $term           = $terms[0];
        $delivery_label = $term->name;

        $product_name .= '<br><small class="product-delivery-time">Lieferzeit: ' . esc_html( $delivery_label ) . '</small>';
    }

    return $product_name;
}
