<article id="post-<?php the_ID(); ?>" <?php post_class('article-default'); ?>>
    <div class="post-inner">
        <?php liquory_post_thumbnail('post-thumbnail', false); ?>
        <div class="post-content">
            <?php
            /**
             * Functions hooked in to liquory_loop_post action.
             *
             * @see liquory_post_header          - 15
             * @see liquory_post_content         - 30
             */
            do_action('liquory_loop_post');
            ?>
        </div>
    </div>
</article><!-- #post-## -->