<?php
/**
 * Theme functions and definitions.
 */
	 add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
				// Rename the reviews tab
	$tabs['additional_information']['title'] = __( 'Specification' );	// Rename the additional information tab

	return $tabs;

}
?>

<?php the_content(); ?>