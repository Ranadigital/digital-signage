<?php
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <?php
                    the_archive_description('<div class="taxonomy-description">', '</div>');
                    ?>
                </header><!-- .page-header -->
                <?php
                if (is_post_type_archive('liquory_service') || is_tax('liquory_service_cat')) {
                    get_template_part('template-parts/archive-service');
                } elseif (is_post_type_archive('liquory_project') || is_tax('liquory_project_cat')) {
                    get_template_part('template-parts/archive-project');
                } else {
                    get_template_part('loop');
                }
            else :
                get_template_part('content', 'none');
            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
do_action('liquory_sidebar');
get_footer();
