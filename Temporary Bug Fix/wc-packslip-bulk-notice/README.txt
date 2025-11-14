WooCommerce Packslip Bulk Notice
================================

Description
-----------

This small helper adds a persistent admin notice after running ShipTastic / WooCommerce Germanized (gzd) bulk actions for shipping labels and packing slips.

Instead of showing the success message only once (inside the bulk handler), the message is stored per user and rendered as a banner at the top of the Shipments / Return Shipments screens.
The notice can be dismissed and will not be shown again for the same bulk run.

Features
--------

- Stores the last bulk success message per user (based on a hash of message + time [+ filename])
- Works with ShipTastic and WooCommerce Germanized shipment bulk actions
- Context-aware:
  - Shipments screen
  - Return Shipments screen
- Renders a clear banner with the message and a "back to overview" button
- Dismiss state is persisted in user meta

Requirements
------------

- WordPress
- WooCommerce
- ShipTastic and/or WooCommerce Germanized Pro (for the shipment bulk actions that fire the hooks)

File structure
--------------

- wc-packslip-bulk-notice.php
  Main file containing:
  - Constant: PACKSLIP_BULK_NOTICE_META
  - Functions:
    - save_packslip_bulk_notice()
    - render_packslip_notice_banner()
    - close_packslip_notice_banner()

Installation
------------

1. Download or copy wc-packslip-bulk-notice.php.

2. Option A – as a standalone plugin:
   - Create a new folder inside wp-content/plugins/, e.g. wc-packslip-bulk-notice/.
   - Put wc-packslip-bulk-notice.php inside that folder.
   - Add a standard WordPress plugin header to the top of the file if needed.
   - Activate the plugin from the WordPress admin.

3. Option B – as a must-use plugin:
   - Place wc-packslip-bulk-notice.php into wp-content/mu-plugins/.

4. Option C – inside your theme:
   - Drop the code into your theme’s functions.php or a custom include file.
   - Require/include it from functions.php.

How it works
------------

1. When a supported bulk action finishes, save_packslip_bulk_notice():
   - Reads the success message from the handler.
   - Builds a unique run ID (hash).
   - Stores the message, run ID, context (shipment / return), and timestamps in user_meta using PACKSLIP_BULK_NOTICE_META.

2. On the corresponding admin screen (wc-stc-shipments or wc-stc-return-shipments),
   render_packslip_notice_banner():
   - Checks capabilities and current screen.
   - Reads user_meta for the current user.
   - Ensures the notice:
     - Matches the current screen context,
     - Has not been dismissed,
     - Has not been rendered before for this run.
   - Renders a banner at the top of the page with:
     - The stored message
     - A button pointing to a dismiss URL.

3. When the dismiss URL is clicked, close_packslip_notice_banner():
   - Verifies the nonce.
   - Marks the notice as dismissed in user_meta.
   - Redirects back to the page without the query arguments.

Customization
-------------

- Button label
  The default button text is German:
  - "Zur Übersicht" (Back to overview)

  You can change this by editing the string inside render_packslip_notice_banner():
  - esc_html__( 'Zur Übersicht', 'woocommerce-germanized-pro' )

- Styling
  The banner is styled via a small inline <style> block.
  You can:
  - Adjust colors, spacing, or typography directly there, or
  - Remove the inline styles and move them into a dedicated admin CSS file.

- Query parameter & nonce names
  If you need different names for security or consistency reasons, change:
  - packslip_notice_close
  - packslip_notice
  in both the banner generation and the closing handler.