<?php
/**
 * =================================================
 * Hook liquory_page
 * =================================================
 */
add_action('liquory_page', 'liquory_page_header', 10);
add_action('liquory_page', 'liquory_page_content', 20);

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
add_action('liquory_single_post', 'liquory_post_thumbnail', 10);
add_action('liquory_single_post', 'liquory_post_header', 20);
add_action('liquory_single_post', 'liquory_post_content', 30);

/**
 * =================================================
 * Hook liquory_single_post_bottom
 * =================================================
 */
add_action('liquory_single_post_bottom', 'liquory_post_taxonomy', 5);
add_action('liquory_single_post_bottom', 'liquory_post_nav', 10);
add_action('liquory_single_post_bottom', 'liquory_display_comments', 20);

/**
 * =================================================
 * Hook liquory_loop_post
 * =================================================
 */
add_action('liquory_loop_post', 'liquory_post_header', 15);
add_action('liquory_loop_post', 'liquory_post_content', 30);

/**
 * =================================================
 * Hook liquory_footer
 * =================================================
 */
add_action('liquory_footer', 'liquory_footer_default', 20);

/**
 * =================================================
 * Hook liquory_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'liquory_template_account_dropdown', 1);
add_action('wp_footer', 'liquory_mobile_nav', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'liquory_pingback_header', 1);

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
add_action('liquory_sidebar', 'liquory_get_sidebar', 10);

/**
 * =================================================
 * Hook liquory_loop_after
 * =================================================
 */
add_action('liquory_loop_after', 'liquory_paging_nav', 10);

/**
 * =================================================
 * Hook liquory_page_after
 * =================================================
 */
add_action('liquory_page_after', 'liquory_display_comments', 10);

/**
 * =================================================
 * Hook liquory_woocommerce_list_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_woocommerce_list_item_content
 * =================================================
 */

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

/**
 * =================================================
 * Hook liquory_woocommerce_shop_loop_item_caption
 * =================================================
 */

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

/**
 * =================================================
 * Hook liquory_product_list_content
 * =================================================
 */

/**
 * =================================================
 * Hook liquory_product_list_end
 * =================================================
 */
