<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to liquory_single_post_top action
         *
         */
        do_action('liquory_single_post_top');

        /**
         * Functions hooked in to liquory_single_post action
         * @see liquory_post_thumbnail - 10
         * @see liquory_post_header         - 20
         * @see liquory_post_content         - 30
         */
        do_action('liquory_single_post');

        /**
         * Functions hooked in to liquory_single_post_bottom action
         *
         * @see liquory_post_taxonomy      - 5
         * @see liquory_post_nav            - 10
         * @see liquory_display_comments    - 20
         */
        do_action('liquory_single_post_bottom');
        ?>

    </div>

</article><!-- #post-## -->
