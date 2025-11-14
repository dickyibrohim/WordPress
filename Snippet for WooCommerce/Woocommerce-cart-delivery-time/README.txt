# WooCommerce – Show Delivery Time Under Cart Item Name

This snippet shows a **delivery time label** (from a custom product taxonomy) under the product name on the **WooCommerce cart page**.

It expects a taxonomy like `product_delivery_time` attached to your products, with terms such as `2–3 Tage`, `5–7 Tage`, etc.

---

## Usage (functions.php)

1. Make sure you have a taxonomy named `product_delivery_time` assigned to your products.
2. Assign the appropriate delivery time term to each product (or its parent for variations).
3. Add the code below to your theme’s **`functions.php`** (preferably a child theme).

### Ready to copy – functions.php snippet


##Example Output
Product Name XYZ
<br>
<small class="product-delivery-time">Lieferzeit: 3–5 Werktage</small>

##Optional CSS Styling
If you want to style the label, you can add something like this to your CSS:

```
.product-delivery-time {
    font-size: 0.85em;
    opacity: 0.8;
    display: inline-block;
    margin-top: 2px;
}

```
###Notes

Only runs on the cart page (is_cart()).
Uses the first term from the product_delivery_time taxonomy.
If no term is set, nothing is added under the product name.