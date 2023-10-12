<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $product WC_Product
 */
global $product;

if (!is_a($product, 'WC_Product')) {
    return;
}

?>
<li class="product">
    <div class="product-list-inner">
        <?php
        /**
         * Functions hooked in to liquory_product_list_start action
         *
         */
        do_action('liquory_product_list_start', $args);
        ?>
        <div class="product-image">
            <?php
            /**
             * Functions hooked in to liquory_product_list_image action
             *
             * @see liquory_product_label - 5 - woo
             * @see liquory_woocommerce_product_list_image - 10 - woo
             */
            do_action('liquory_product_list_image', $args);
            ?>
        </div>

        <div class="product-content">
            <?php
            /**
             * Functions hooked in to liquory_product_list_content action
             *
             * @see woocommerce_template_loop_product_title - 10 - woo
             * @see woocommerce_template_loop_rating - 15 - woo
             * @see woocommerce_template_loop_price - 20 - woo
             * @see liquory_stock_label - 25 - woo
             *
             */
            do_action('liquory_product_list_content');

            ?>
        </div>

        <?php
        /**
         * Functions hooked in to liquory_product_list_end action
         *
         */
        do_action('liquory_product_list_end', $args);
        ?>
    </div>
</li>
