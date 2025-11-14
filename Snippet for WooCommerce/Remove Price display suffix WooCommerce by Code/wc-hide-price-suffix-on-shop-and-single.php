add_filter( 'woocommerce_get_price_suffix', function( $suffix, $product, $price, $qty ) {
    if ( is_shop() || is_product() ) {
        return '';
    }
    return $suffix;
}, 10, 4 );
