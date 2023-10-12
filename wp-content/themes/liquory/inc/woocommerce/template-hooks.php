<?php
/**
 * =================================================
 * Hook liquory_page
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_single_post_top
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_single_post
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_single_post_bottom
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_loop_post
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_footer
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_after_footer
 * =================================================
 */
add_action('liquory_after_footer', 'liquory_sticky_single_add_to_cart', 999);

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'liquory_render_woocommerce_shop_canvas', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_content_top
 * =================================================
 */
add_action('liquory_content_top', 'liquory_shop_messages', 10);

/**
 * =================================================
 * Hook liquory_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_sidebar
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_loop_after
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_page_after
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_woocommerce_list_item_title
 * =================================================
 */
add_action('liquory_woocommerce_list_item_title', 'liquory_product_label', 5);
add_action('liquory_woocommerce_list_item_title', 'liquory_woocommerce_product_list_image', 10);

/**
 * =================================================
 * Hook liquory_woocommerce_list_item_content
 * =================================================
 */
add_action('liquory_woocommerce_list_item_content', 'woocommerce_template_loop_product_title', 10);
add_action('liquory_woocommerce_list_item_content', 'woocommerce_template_loop_rating', 15);
add_action('liquory_woocommerce_list_item_content', 'woocommerce_template_loop_price', 20);
add_action('liquory_woocommerce_list_item_content', 'liquory_stock_label', 25);

/**
 * =================================================
 * Hook liquory_woocommerce_before_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_woocommerce_before_shop_loop_item_image
 * =================================================
 */
add_action('liquory_woocommerce_before_shop_loop_item_image', 'liquory_product_label', 10);
add_action('liquory_woocommerce_before_shop_loop_item_image', 'woocommerce_template_loop_product_thumbnail', 15);
add_action('liquory_woocommerce_before_shop_loop_item_image', 'liquory_woocommerce_product_loop_action_start', 20);
add_action('liquory_woocommerce_before_shop_loop_item_image', 'liquory_wishlist_button', 25);
add_action('liquory_woocommerce_before_shop_loop_item_image', 'liquory_quickview_button', 30);
add_action('liquory_woocommerce_before_shop_loop_item_image', 'liquory_compare_button', 35);
add_action('liquory_woocommerce_before_shop_loop_item_image', 'liquory_woocommerce_product_loop_action_close', 40);

/**
 * =================================================
 * Hook liquory_woocommerce_shop_loop_item_caption
 * =================================================
 */
add_action('liquory_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_product_title', 5);
add_action('liquory_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_rating', 10);
add_action('liquory_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_price', 15);
add_action('liquory_woocommerce_shop_loop_item_caption', 'liquory_stock_label', 20);
add_action('liquory_woocommerce_shop_loop_item_caption', 'liquory_woocommerce_get_product_description', 25);
add_action('liquory_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_add_to_cart', 30);

/**
 * =================================================
 * Hook liquory_woocommerce_after_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_product_list_start
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_product_list_image
 * =================================================
 */
add_action('liquory_product_list_image', 'liquory_product_label', 5);
add_action('liquory_product_list_image', 'liquory_woocommerce_product_list_image', 10);

/**
 * =================================================
 * Hook liquory_product_list_content
 * =================================================
 */
add_action('liquory_product_list_content', 'woocommerce_template_loop_product_title', 10);
add_action('liquory_product_list_content', 'woocommerce_template_loop_rating', 15);
add_action('liquory_product_list_content', 'woocommerce_template_loop_price', 20);
add_action('liquory_product_list_content', 'liquory_stock_label', 25);

/**
 * =================================================
 * Hook liquory_product_list_end
 * =================================================
 */
