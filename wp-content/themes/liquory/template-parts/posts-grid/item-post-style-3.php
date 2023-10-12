<div class="column-item post-style-3">
    <div class="post-inner">
        <?php
        liquory_post_thumbnail('liquory-post-grid', false);
        ?>
        <div class="entry-content">
            <?php liquory_post_meta(['show_cat' => true, 'show_date' => false, 'show_author'  => false, 'show_comment' => false]); ?>
            <?php the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
            <div class="entry-meta">
                <?php liquory_post_meta(['show_cat' => false, 'show_date' => true, 'show_author'  => true, 'show_comment' => true]); ?>
            </div>
            <div class="excerpt-content"><?php echo wp_trim_words(get_the_excerpt(), 50); ?></div>

            <div class="more-link-wrap">
                <a class="more-link" href="<?php the_permalink() ?>">
                    <span><?php echo esc_html__('Read More', 'liquory'); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
