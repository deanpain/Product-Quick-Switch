=== Product Quick Switch ===
Contributors: InkPixel
Tags: woocommerce, products, quick switch, search, filter
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 2.5
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Adds a searchable dropdown to WooCommerce product edit pages to quickly switch to another product.

== Description ==

The Product Quick Switch plugin streamlines your WooCommerce product management by adding a convenient meta box to the product edit screen. This meta box features a searchable dropdown menu that allows you to quickly navigate to any other product in your store directly from the current edit page.

No more tedious back-and-forth through the product list! Simply type a few characters of the product you're looking for, select it from the filtered dropdown, and you'll be instantly redirected to its edit screen.

**Features:**
* **Seamless Integration:** Adds a meta box to the standard WooCommerce product edit page.
* **Quick Navigation:** Instantly switch to any product with a single click after selection.
* **Searchable Dropdown:** Easily find products by typing in the search box, which dynamically filters the dropdown options.
* **Performance Optimized:** Efficiently retrieves product data for a smooth user experience.
* **HPOS Compatible:** Fully compatible with WooCommerce's High-Performance Order Storage feature.

This plugin is designed to save you time and clicks, making your WooCommerce product editing workflow more efficient.

== Installation ==

1.  **Upload** the `product-quick-switch` folder to the `/wp-content/plugins/` directory.
2.  **Activate** the plugin through the 'Plugins' menu in WordPress.
3.  Navigate to any WooCommerce product edit page (Products -> All Products -> Edit).
4.  You will find the "Quick Product Switch" meta box on the right sidebar.

== Frequently Asked Questions ==

= Does this plugin work with High-Performance Order Storage (HPOS)? =
Yes, this plugin is declared compatible with WooCommerce's High-Performance Order Storage (HPOS) feature from version 2.3 onwards.

= Can I filter products by category or status? =
No, this version of the plugin focuses purely on a simple searchable dropdown for quick product switching. The category and status filters were removed to simplify the interface and improve performance.

= What if I have a very large number of products? =
The plugin fetches all products to populate the dropdown for client-side searching. For extremely large stores (tens of thousands of products or more), you might experience a slight delay on initial page load where the dropdown is rendered. However, the client-side filtering remains very fast.

== Screenshots ==

(No screenshots yet. You will add these to your WordPress.org plugin page.)

== Changelog ==

= 2.5 =
* FIX: Ensured all output is properly escaped using `esc_html()` for the option text, addressing WordPress.Security.EscapeOutput.OutputNotEscaped warnings.

= 2.4 =
* FIX: Applied `esc_attr()` to the `data-title` attribute to ensure proper escaping and address WordPress.Security.EscapeOutput.OutputNotEscaped warnings.

= 2.3 =
* ADD: Declared formal compatibility with WooCommerce High-Performance Order Storage (HPOS) to prevent incompatibility warnings.
* UPD: Bumped plugin version to reflect HPOS compatibility declaration.

= 2.2 =
* FIX: Updated product data retrieval to use `wc_get_products()` for compatibility with WooCommerce High-Performance Order Storage (HPOS).
* UPD: Adjusted product object data access (e.g., `get_name()`, `get_id()`).
* UPD: Bumped plugin version.

= 2.1 =
* REM: Removed category and status filter dropdowns.
* IMP: Simplified JavaScript filtering logic for improved performance.
* ADD: Comprehensive WordPress.org plugin header.

= 2.0 =
* Initial release with searchable and filterable dropdowns.

== Upgrade Notice ==

= 2.5 =
Fixed a WordPress coding standard warning related to output escaping. Update is recommended for full compliance.

= 2.4 =
Fixed a WordPress coding standard warning related to attribute escaping. Update is recommended for full compliance.

= 2.3 =
This version includes a formal declaration of compatibility with WooCommerce's High-Performance Order Storage (HPOS). Update to resolve potential incompatibility warnings.

= 2.2 =
This version includes critical updates for WooCommerce High-Performance Order Storage (HPOS) compatibility. Update is highly recommended if you are using or planning to use HPOS.

= 2.1 =
This version significantly simplifies the plugin by removing category and status filters and improving performance. Update to this version for a streamlined experience.
