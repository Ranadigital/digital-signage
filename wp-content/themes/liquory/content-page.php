<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to liquory_page action
	 *
	 * @see liquory_page_header          - 10
	 * @see liquory_page_content         - 20
	 *
	 */
	do_action( 'liquory_page' );
	?>
</article><!-- #post-## -->
