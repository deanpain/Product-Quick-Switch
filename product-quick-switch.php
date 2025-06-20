<?php
/**
 * Plugin Name: Product Quick Switch
 * Plugin URI:  https://wordpress.org/plugins/product-quick-switch/
 * Description: Adds a searchable dropdown to WooCommerce product edit pages to quickly switch to another product.
 * Version:     2.5
 * Author:      InkPixel
 * Author URI:  https://www.facebook.com/people/InkPixel-Studio/61576687495349/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: product-quick-switch
 * Requires at least: 5.0
 * Tested up to: 6.5
 * WC requires at least: 4.0
 * WC tested up to: 9.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Declare compatibility with High-Performance Order Storage (HPOS).
 *
 * This action ensures that WooCommerce recognizes this plugin as compatible
 * with HPOS, preventing potential incompatibility warnings. Even though this
 * plugin primarily deals with products (which are not directly affected by HPOS
 * order table changes), declaring compatibility is good practice to avoid generic
 * warnings from WooCommerce's system.
 */
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
            'custom_order_tables', // The feature your plugin is compatible with (HPOS)
            __FILE__,              // The main plugin file path
            true                   // Whether the plugin is compatible or not (true for compatible)
        );
    }
} );

/**
 * Registers the meta box for the Product Quick Switch.
 *
 * This function removes the default 'Publish' meta box and then
 * adds our custom 'Quick Product Switch' meta box, re-adding 'Publish'
 * afterwards to maintain its position.
 */
add_action('add_meta_boxes', 'pqs_register_meta_box', 0);

function pqs_register_meta_box() {
    // Remove default Publish meta box to re-add it in a specific order
    remove_meta_box('submitdiv', 'product', 'side');

    // Add our custom quick switch meta box
    add_meta_box(
        'pqs_quick_switch_box',            // Unique ID for the meta box
        'Quick Product Switch',           // Title of the meta box
        'pqs_render_dropdown_meta_box',   // Callback function to render the content
        'product',                        // Post type where the meta box will appear
        'side',                           // Context (side column)
        'high'                            // Priority (high to appear near the top)
    );

    // Re-add the Publish meta box immediately after our custom one
    add_meta_box('submitdiv', 'Publish', 'post_submit_meta_box', 'product', 'side', 'core');
}

/**
 * Renders the content of the Quick Product Switch meta box.
 *
 * This function displays a search input and a dropdown populated
 * with all WooCommerce products. The JavaScript handles the live
 * filtering of options based on the search input.
 *
 * @param WP_Post $post The current post object being edited.
 */
function pqs_render_dropdown_meta_box($post) {
    // Basic inline style for the search input
    ?>
    <style>
    /* Ensure the search box takes full width for better usability */
    #pqs_search_box {
        width: 100%;
        margin-bottom: 5px; /* Add some space below the search box */
    }
    /* Ensure the quick switch dropdown takes full width */
    #pqs_quick_switch {
        width: 100%;
    }
    /* Style options that are hidden by the filter */
    #pqs_quick_switch option[style*="display: none"] {
        display: none; /* Make sure hidden options are not visible */
    }
    </style>
    
    <input type="text" id="pqs_search_box" placeholder="Search products..." />

    <select id="pqs_quick_switch" onchange="if(this.value) window.location.href=this.value;">
        <option value="">Select a product...</option>
        <?php
        /**
         * Fetch all products from the database using wc_get_products for HPOS compatibility.
         *
         * 'limit' => -1 ensures all products are retrieved.
         * 'orderby' and 'order' sort them alphabetically by title.
         * 'status' includes common statuses to make more products accessible.
         */
        $products = wc_get_products([
            'limit'          => -1,                               // Retrieve all products
            'orderby'        => 'title',                            // Order by product title
            'order'          => 'ASC',                              // Ascending order
            'status'         => ['publish', 'draft', 'pending', 'private'], // Include various statuses
            'return'         => 'objects',                          // Ensure full WC_Product objects are returned
        ]);

        // Loop through each product and create an option for the dropdown
        foreach ($products as $product_item) {
            // Get product title using WC_Product method
            $title = $product_item->get_name();                   // Get product title
            // Get product ID using WC_Product method
            $product_id = $product_item->get_id();
            // Get the edit URL for the product
            $edit_link = get_edit_post_link($product_id);
            
            // Output the option tag. Both value and data-title are escaped.
            // The displayed title is now also explicitly escaped with esc_html().
            echo "<option value='" . esc_url($edit_link) . "' data-title='" . esc_attr($title) . "'>" . esc_html($title) . "</option>";
        }
        ?>
    </select>

    <script>
    /**
     * Self-executing anonymous function to encapsulate the JavaScript
     * and prevent global variable conflicts.
     */
    (function(){
        // Get references to the HTML elements
        const searchBox = document.getElementById('pqs_search_box');
        const dropdown = document.getElementById('pqs_quick_switch');

        /**
         * Filters the dropdown options based on the search box input.
         */
        function filterOptions() {
            const search = searchBox.value.toLowerCase(); // Get search term and convert to lowercase for case-insensitive matching

            // Loop through each option in the dropdown list
            for (let option of dropdown.options) {
                // Skip the first "Select a product..." option, which has no value
                if (!option.value) continue;

                // Get the product title from the 'data-title' attribute and convert to lowercase
                const title = option.getAttribute('data-title').toLowerCase();

                // Determine if the option matches the search term
                // An option matches if the search box is empty OR the title includes the search term
                const match = (search === '' || title.includes(search));

                // Set the display style of the option. If it matches, display it; otherwise, hide it.
                option.style.display = match ? '' : 'none';
            }
        }

        // Add an event listener to the search input.
        // The 'input' event fires whenever the value of an <input> element has been changed.
        searchBox.addEventListener('input', filterOptions);
    })();
    </script>
    <?php
}
