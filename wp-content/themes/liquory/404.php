<?php
get_header(); ?>

    <div id="primary" class="content">
        <main id="main" class="site-main">
            <div class="error-404 not-found">
                <div class="error-img404">
                    <img src="<?php echo get_theme_file_uri('assets/images/404/404.jpg') ?>" alt="<?php echo esc_attr__('404 Page', 'liquory') ?>">
                </div>
                <div class="page-content">
                    <header class="page-header">
                        <h1 class="error-title"><?php esc_html_e('404 Error', 'liquory'); ?></h1>
                        <h3 class="sub-title"><?php esc_html_e('We can’t find the page your are looking for ', 'liquory'); ?></h3>
                    </header><!-- .page-header -->

                    <a href="<?php echo esc_url(home_url('/')); ?>" class="go-back"><?php esc_html_e('Go back Homepage', 'liquory'); ?></a>
                </div><!-- .page-content -->
            </div><!-- .error-404 -->
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();
