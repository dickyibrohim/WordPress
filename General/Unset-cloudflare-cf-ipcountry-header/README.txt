Unset Cloudflare CF-IPCOUNTRY Header for WordPress
==================================================

Description
-----------
This small helper snippet unsets the `HTTP_CF_IPCOUNTRY` value from the `$_SERVER` superglobal as early as possible in WordPress.

It is useful when:
- You are using Cloudflare, and
- The `CF-IPCountry` header is causing unexpected behavior in plugins or custom code that rely on geolocation, and
- You want to ensure WordPress/PHP no longer sees this value.

For convenience, it also logs the current `CF-IPCountry` value to the browser console for administrators, so you can easily verify that it has been removed.


How It Works
------------
The code does two things:

1. On `plugins_loaded` (priority `0`), it checks if `$_SERVER['HTTP_CF_IPCOUNTRY']` is set.  
   - If yes, it calls `unset( $_SERVER['HTTP_CF_IPCOUNTRY'] );`.

2. On `wp_footer`, if the current user has the `manage_options` capability (usually administrators only), it prints a small inline `<script>`:
   - This script logs the value of `CF-IPCountry (after unset)` to the browser console.
   - If the variable no longer exists, it will log `NOT SET`.


Code
----
You can use the snippet as-is:

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


Installation
------------
You have a few options:

1. **As a normal plugin**
   - Create a new PHP file, for example:  
     `wp-unset-cloudflare-cf-ipcountry-header.php`
   - Add a standard WordPress plugin header at the top (optional, if you want it to show in the Plugins list).
   - Place the file in:  
     `wp-content/plugins/`
   - Activate it from **Dashboard → Plugins**.

2. **As a must-use plugin (mu-plugin)**
   - Create the same file and put it into:  
     `wp-content/mu-plugins/`
   - It will load automatically without needing activation.

3. **Inside your theme**
   - Copy the code into your theme’s `functions.php` or a theme-specific helper file.
   - This ties the behavior to the active theme.


Usage & Verification
--------------------
1. Make sure your site is proxied through Cloudflare and `CF-IPCOUNTRY` is normally sent.
2. Install and activate this snippet via one of the methods above.
3. Log in as an administrator.
4. Open any frontend page and open your browser’s developer tools → Console.
5. You should see a message:

   `CF-IPCountry (after unset): NOT SET`

   If the header is still present for some reason, the logged value will show the country code instead.


Requirements
------------
- WordPress 5.0+ (should also work on older versions in most cases).
- PHP 7.0+ recommended.
- Cloudflare proxy enabled and sending `CF-IPCOUNTRY` header (otherwise the snippet simply logs `NOT SET`).


Notes
-----
- This snippet does not add any admin UI or settings.
- It only affects the `$_SERVER['HTTP_CF_IPCOUNTRY']` variable inside PHP/WordPress, not the actual HTTP header at the web server level.
- The console logging is restricted to users with `manage_options` to avoid exposing internal details to visitors.
