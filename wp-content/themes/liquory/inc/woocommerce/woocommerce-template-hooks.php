<?php
/**
 * Liquory WooCommerce hooks
 *
 * @package liquory
 */

/**
 * Layout
 *
 * @see  liquory_before_content()
 * @see  liquory_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  liquory_shop_messages()
 */

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
//remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('hfe_header', 'liquory_get_shop_banner', 95);
add_action('woocommerce_before_main_content', 'liquory_before_content', 10);
add_action('woocommerce_after_main_content', 'liquory_after_content', 10);

/**
 * Layout Archive
 * sorting
 */
add_action('woocommerce_before_shop_loop', 'liquory_sorting_wrapper', 15);
add_action('woocommerce_before_shop_loop', 'liquory_button_shop_canvas', 16);
add_action('woocommerce_before_shop_loop', 'liquory_button_grid_list_layout', 17);
//add_action('woocommerce_before_shop_loop', 'liquory_products_per_page_select', 35);
add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 35);
add_action('woocommerce_before_shop_loop', 'liquory_sorting_wrapper_close', 40);

/**
 * Layout Single
 *
 */

//Wrapper content single
add_action('woocommerce_before_single_product_summary', 'liquory_woocommerce_single_content_wrapper_start', 2);
add_action('woocommerce_single_product_summary', 'liquory_woocommerce_single_content_wrapper_end', 99);

// single product summary
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'liquory_woocommerce_single_product_summary_left_start', 2);
add_action('woocommerce_single_product_summary', 'liquory_single_product_summary_top', 3);
add_action('woocommerce_single_product_summary', 'liquory_single_product_after_title', 6);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 9);
add_action('woocommerce_single_product_summary', 'liquory_stock_label', 10);

add_action('woocommerce_single_product_summary', 'liquory_woocommerce_deal_progress', 26);
add_action('woocommerce_single_product_summary', 'liquory_woocommerce_single_product_summary_left_end', 61);
add_action('woocommerce_single_product_summary', 'liquory_single_product_extra', 25);

add_filter('woosc_button_position_single', '__return_false');
add_filter('woosw_button_position_single', '__return_false');

add_action('woocommerce_after_add_to_cart_button', function () {
    if (function_exists('woosw_init') || function_exists('woosc_init')) {
        ?>
        <div class="clear"></div>
        <?php
    }
}, 30);

add_action('woocommerce_after_add_to_cart_button', 'liquory_wishlist_button', 31);
add_action('woocommerce_after_add_to_cart_button', 'liquory_compare_button', 32);

//style product single
add_filter('woocommerce_get_image_size_gallery_thumbnail', function ($size) {
    return array(
        'width'  => 100,
        'height' => 100,
        'crop'   => 1,
    );
});
$product_single_style = liquory_get_theme_option('single_product_gallery_layout', 'horizontal');
add_theme_support('wc-product-gallery-lightbox');
if ($product_single_style === 'horizontal' || $product_single_style === 'vertical' || $product_single_style === 'sidebar') {
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-slider');
}
if ($product_single_style === 'sticky') {
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    remove_action('woocommerce_single_product_summary', 'liquory_single_product_extra', 70);
    add_action('woocommerce_single_product_summary', 'liquory_output_product_data_accordion', 70);
    add_filter('woocommerce_single_product_image_thumbnail_html', 'liquory_woocommerce_single_product_image_thumbnail_html', 10, 2);
}
if ($product_single_style === 'gallery') {
    add_filter('woocommerce_single_product_image_thumbnail_html', 'liquory_woocommerce_single_product_image_thumbnail_html', 10, 2);
}


//Position label onsale
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action('liquory_single_product_video_360', 'woocommerce_show_product_sale_flash', 30);
add_action('liquory_single_product_video_360', 'liquory_single_product_video_360', 10);

/**
 * Product Search
 *
 * @see liquory_ajax_search_result()
 */

add_action('pre_get_product_search_form', 'liquory_ajax_search_result');
/**
 * Cart fragment
 *
 * @see liquory_cart_link_fragment()
 */
add_filter('woocommerce_add_to_cart_fragments', 'liquory_ajax_add_to_cart_add_fragments');

if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {
    add_filter('woocommerce_add_to_cart_fragments', 'liquory_cart_link_fragment');
} else {
    add_filter('add_to_cart_fragments', 'liquory_cart_link_fragment');
}

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');

add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_order_review_start', 5);
add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_order_review_end', 15);

add_filter('woocommerce_get_script_data', function ($params, $handle) {
    if ($handle == "wc-add-to-cart") {
        $params['i18n_view_cart'] = '';
    }
    return $params;
}, 10, 2);

/**
 * Layout Product
 *
 **/

add_filter('woosc_button_position_archive', '__return_false');
add_filter('woosq_button_position', '__return_false');
add_filter('woosw_button_position_archive', '__return_false');

function liquory_include_hooks_product_blocks() {
//    // Remove product content link
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

    add_action('woocommerce_before_shop_loop_item', 'liquory_product_block_wrapper_start', 0);
    add_action('woocommerce_after_shop_loop_item', 'liquory_product_block_wrapper_close', 99);
    add_action('woocommerce_before_shop_loop_item', 'liquory_product_transition_wrapper_start', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'liquory_product_block_wrapper_close', 99);
    add_action('woocommerce_before_shop_loop_item_title', 'liquory_woocommerce_product_loop_action_start', 20);
    add_action('woocommerce_before_shop_loop_item_title', 'liquory_woocommerce_product_loop_action_close', 40);
    add_action('woocommerce_before_shop_loop_item_title', 'liquory_wishlist_button', 25);
    add_action('woocommerce_before_shop_loop_item_title', 'liquory_quickview_button', 30);
    add_action('woocommerce_before_shop_loop_item_title', 'liquory_compare_button', 35);
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 50);
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 50);
    add_action('woocommerce_shop_loop_item_title', 'liquory_product_caption_wrapper_start', 0);
    add_action('woocommerce_after_shop_loop_item_title', 'liquory_product_caption_wrapper_close', 99);
    add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
    add_action('woocommerce_after_shop_loop_item_title', 'liquory_stock_label', 15);

    add_action('woocommerce_after_shop_loop_item_title', 'liquory_product_caption_bottom_wrapper_start', 60);
    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 65);
    add_action('woocommerce_after_shop_loop_item_title', 'liquory_product_caption_bottom_wrapper_close', 70);
}

if (isset($_GET['action']) && $_GET['action'] === 'elementor') {
    return;
}
liquory_include_hooks_product_blocks();
