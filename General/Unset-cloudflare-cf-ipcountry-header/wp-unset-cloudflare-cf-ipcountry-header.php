<?php

add_action( 'plugins_loaded', function () {
	if ( isset( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) {
		unset( $_SERVER['HTTP_CF_IPCOUNTRY'] );
	}
}, 0 );

add_action( 'wp_footer', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$val = isset( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ? $_SERVER['HTTP_CF_IPCOUNTRY'] : 'NOT SET';

	echo '<script>console.log("CF-IPCountry (after unset): ' . esc_js( $val ) . '");</script>';
} );
