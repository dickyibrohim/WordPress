WooCommerce HPOS – Search by Displayed Order Number (Meta-first, Auto-Open)

Overview
This snippet lets you search orders on the WooCommerce → Orders (HPOS) screen using the displayed order number (e.g., 23679 or #23679), not just the internal HPOS ID. It prioritizes matches found in common custom/sequential order-number meta keys. If no meta match is found, it falls back to treating the input as the internal HPOS ID. If exactly one match exists, it auto-opens the order edit screen; if multiple, it filters the Orders list to those IDs.

Why you need this
WooCommerce often shows a customer-facing order number (like “Bestellung #23679”) that can differ from the internal HPOS ID. Default search may not find it. This snippet bridges that gap without altering any data.

Key features
• Works on the HPOS Orders screen (admin.php?page=wc-orders).
• Accepts 23679 or #23679 (the hash is optional).
• Meta-first resolution; falls back to internal ID only if no meta match.
• Auto-open when there’s exactly one match; filters the list when multiple results exist.
• Read-only: does not write or backfill anything to the database.

Requirements
• WooCommerce with High-Performance Order Storage (HPOS) enabled.
• WordPress user capability: manage_woocommerce.
• Modern WordPress/PHP versions recommended.

Installation
1) Put the PHP snippet in a small custom plugin, mu-plugin, or your child theme’s functions.php (plugin/mu-plugin recommended).
2) Ensure HPOS is enabled in WooCommerce.

Usage
1) Go to WooCommerce → Orders (HPOS).
2) Type the visible order number (e.g., 23679 or #23679) into the Search field.
3) Press Enter.
   – If one order matches → you’ll be taken directly to the HPOS edit screen for that order.
   – If multiple orders match → the Orders table is filtered to only those IDs.

How it works (short)
1) Runs only on the HPOS Orders screen (woocommerce_page_wc-orders).
2) Normalizes input to digits (e.g., “#23679” → “23679”).
3) Searches wc_orders_meta for exact matches across supported meta keys.
4) If there is at least one meta match, those IDs are used. Otherwise, it tries the number as an internal HPOS ID.
5) One match = redirect to edit. Multiple = filter the Orders table via woocommerce_orders_table_query_clauses.

Supported meta keys
• _order_number
• _order_number_formatted
• _alg_wc_custom_order_number
• _alg_wc_full_custom_order_number
• _sequential_order_number
• order_number
• order_number_formatted
• wt_ons_order_number (WebToffee)
• ywpo_number (YITH)

Security & performance
• Read-only SELECT queries; no writes, no backfill.
• Uses $wpdb->prepare for SQL safety.
• Restricted to admins with manage_woocommerce capability.
• Lightweight; only triggers for numeric searches on the HPOS Orders screen.

Notes
• If your numbering plugin uses a different meta key, add it to the $keys array in the snippet.
• Meta-first behavior avoids opening the wrong order when a number collides with another order’s internal ID.
• This version auto-opens when there’s a single match. If you prefer not to auto-open, use a variant that always filters the list.

Troubleshooting
• “No results”: Your numbering plugin may store the value in a non-standard key. Add that key to the $keys array.
• “Opens the wrong order”: Ensure meta-first remains the first branch, and confirm the number actually exists under a supported meta key.