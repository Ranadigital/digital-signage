<?php

if (!function_exists('liquory_display_comments')) {
    /**
     * Liquory display comments
     *
     * @since  1.0.0
     */
    function liquory_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || 0 !== intval(get_comments_number())) :
            comments_template();
        endif;
    }
}

if (!function_exists('liquory_comment')) {
    /**
     * Liquory comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int $depth the comment depth.
     *
     * @since 1.0.0
     */
    function liquory_comment($comment, $args, $depth) {
        if ('div' === $args['style']) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr($tag) . ' '; ?><?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">

        <div class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 50); ?>
            </div>
            <?php if ('div' !== $args['style']) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
                <?php endif; ?>
                <div class="comment-head">
                    <div class="comment-meta commentmetadata">
                        <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()); ?>
                        <?php if ('0' === $comment->comment_approved) : ?>
                            <em class="comment-awaiting-moderation"><?php esc_attr_e('Your comment is awaiting moderation.', 'liquory'); ?></em>
                            <br/>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(htmlspecialchars(get_comment_link($comment->comment_ID))); ?>"
                           class="comment-date">
                            <?php echo '<time datetime="' . get_comment_date('c') . '">' . get_comment_date() . '</time>'; ?>
                        </a>
                    </div>
                </div>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>

                <div class="reply">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args, array(
                                'add_below' => $add_below,
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                            )
                        )
                    );
                    ?>
                    <?php edit_comment_link(esc_html__('Edit', 'liquory'), '  ', ''); ?>
                </div>
                <?php if ('div' !== $args['style']) : ?>
            </div>
        <?php endif; ?>
        </div>
        <?php
    }
}

if (!function_exists('liquory_credit')) {
    /**
     * Display the theme credit
     *
     * @return void
     * @since  1.0.0
     */
    function liquory_credit() {
        ?>
        <div class="site-info">
            <?php echo apply_filters('liquory_copyright_text', $content = '&copy; ' . date('Y') . ' ' . '<a class="site-url" href="' . esc_url(site_url()) . '">' . esc_html(get_bloginfo('name')) . '</a>' . esc_html__('. All Rights Reserved.', 'liquory')); ?>
        </div><!-- .site-info -->
        <?php
    }
}

if (!function_exists('liquory_social')) {
    function liquory_social() {
        $social_list = liquory_get_theme_option('social_text', []);
        if (empty($social_list)) {
            return;
        }
        ?>
        <div class="liquory-social">
            <ul>
                <?php

                foreach ($social_list as $social_item) {
                    ?>
                    <li><a href="<?php echo esc_url($social_item); ?>"></a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
        <?php
    }
}

if (!function_exists('liquory_site_branding')) {
    /**
     * Site branding wrapper and display
     *
     * @return void
     * @since  1.0.0
     */
    function liquory_site_branding() {
        ?>
        <div class="site-branding">
            <?php echo liquory_site_title_or_logo(); ?>
        </div>
        <?php
    }
}

if (!function_exists('liquory_site_title_or_logo')) {
    /**
     * Display the site title or logo
     *
     * @param bool $echo Echo the string or return it.
     *
     * @return string
     * @since 2.1.0
     */
    function liquory_site_title_or_logo() {
        ob_start();
        the_custom_logo(); ?>
        <div class="site-branding-text">
            <?php if (is_front_page()) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                          rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                         rel="home"><?php bloginfo('name'); ?></a></p>
            <?php endif; ?>

            <?php
            $description = get_bloginfo('description', 'display');

            if ($description || is_customize_preview()) :
                ?>
                <p class="site-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div><!-- .site-branding-text -->
        <?php
        $html = ob_get_clean();
        return $html;
    }
}

if (!function_exists('liquory_primary_navigation')) {
    /**
     * Display Primary Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function liquory_primary_navigation() {
        ?>
        <nav class="main-navigation" role="navigation"
             aria-label="<?php esc_html_e('Primary Navigation', 'liquory'); ?>">
            <?php
            $args = apply_filters('liquory_nav_menu_args', [
                'fallback_cb'     => '__return_empty_string',
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
                'link_before' => '<span class="menu-title">',
                'link_after' => '</span>'
            ]);
            wp_nav_menu($args);
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('liquory_mobile_navigation')) {
    /**
     * Display Handheld Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function liquory_mobile_navigation() {
        ?>
        <div class="mobile-nav-tabs">
            <ul>
                <?php if (isset(get_nav_menu_locations()['handheld'])) { ?>
                    <li class="mobile-tab-title mobile-pages-title active" data-menu="pages">
                        <span><?php echo esc_html(get_term(get_nav_menu_locations()['handheld'], 'nav_menu')->name); ?></span>
                    </li>
                <?php } ?>
                <?php if (isset(get_nav_menu_locations()['vertical'])) { ?>
                    <li class="mobile-tab-title mobile-categories-title" data-menu="categories">
                        <span><?php echo esc_html(get_term(get_nav_menu_locations()['vertical'], 'nav_menu')->name); ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <nav class="mobile-menu-tab mobile-navigation mobile-pages-menu active"
             aria-label="<?php esc_html_e('Mobile Navigation', 'liquory'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'handheld',
                    'container_class' => 'handheld-navigation',
                )
            );
            ?>
        </nav>
        <nav class="mobile-menu-tab mobile-navigation-categories mobile-categories-menu"
             aria-label="<?php esc_html_e('Mobile Navigation', 'liquory'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'vertical',
                    'container_class' => 'handheld-navigation',
                )
            );
            ?>
        </nav>
        <?php
    }
}

if (!function_exists('liquory_homepage_header')) {
    /**
     * Display the page header without the featured image
     *
     * @since 1.0.0
     */
    function liquory_homepage_header() {
        edit_post_link(esc_html__('Edit this section', 'liquory'), '', '', '', 'button liquory-hero__button-edit');
        ?>
        <header class="entry-header">
            <?php
            the_title('<h1 class="entry-title">', '</h1>');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('liquory_page_header')) {
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function liquory_page_header() {

        if (is_front_page() || !is_page_template('default')) {
            return;
        }

        if (liquory_is_elementor_activated() && function_exists('hfe_init')) {
            if (Liquory_breadcrumb::get_template_id() !== '') {
                return;
            }
        }

        ?>
        <header class="entry-header">
            <?php
            if (has_post_thumbnail()) {
                liquory_post_thumbnail('full');
            }
            the_title('<h1 class="entry-title">', '</h1>');
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('liquory_page_content')) {
    /**
     * Display the post content
     *
     * @since 1.0.0
     */
    function liquory_page_content() {
        ?>
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'liquory'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if (!function_exists('liquory_post_header')) {
    /**
     * Display the post header with a link to the single post
     *
     * @since 1.0.0
     */
    function liquory_post_header() {
        ?>
        <header class="entry-header">
            <?php
            if (is_single()) {
                liquory_post_meta(['show_cat' => true, 'show_date' => false, 'show_author'  => false, 'show_comment' => false]);
                the_title('<h1 class="alpha entry-title">', '</h1>');
                ?>
                <div class="entry-meta">
                    <?php liquory_post_meta(['show_cat' => false, 'show_date' => true, 'show_author'  => true, 'show_comment' => true]); ?>
                </div>
                <?php
            } else {  ?>
                <?php liquory_post_meta(['show_cat' => true, 'show_date' => false, 'show_author'  => false, 'show_comment' => false]); ?>
                <?php
                the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
                if ('post' == get_post_type()) {
                    ?>
                    <div class="entry-meta">
                            <?php liquory_post_meta(['show_cat' => false, 'show_date' => true, 'show_author'  => true, 'show_comment' => true]); ?>
                    </div>
                    <?php
                }
            }
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if (!function_exists('liquory_post_content')) {
    /**
     * Display the post content with a link to the single post
     *
     * @since 1.0.0
     */
    function liquory_post_content() {
        ?>
        <div class="entry-content">
            <?php

            /**
             * Functions hooked in to liquory_post_content_before action.
             *
             */
            do_action('liquory_post_content_before');


            if (is_single()) {
                the_content(
                    sprintf(
                    /* translators: %s: post title */
                        esc_html__('Read More', 'liquory') . ' %s',
                        '<span class="screen-reader-text">' . get_the_title() . '</span>'
                    )
                );
            } else {
                ?>
                <div class="entry-excerpt"><?php the_excerpt();?></div>
                <?php echo '<div class="more-link-wrap"><a class="more-link" href="' . get_permalink() . '">' .  esc_html__('Read More', 'liquory') . '' .'</a></div>';
            }

            /**
             * Functions hooked in to liquory_post_content_after action.
             *
             */
            do_action('liquory_post_content_after');

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'liquory'),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if (!function_exists('liquory_post_meta')) {
    /**
     * Display the post meta
     *
     * @since 1.0.0
     */
    function liquory_post_meta($atts = array()) {
        global $post;
        if ('post' !== get_post_type()) {
            return;
        }

        extract(
            shortcode_atts(
                array(
                    'show_date'    => true,
                    'show_cat'     => true,
                    'show_author'  => true,
                    'show_comment' => true,
                ),
                $atts
            )
        );

        $categories_list = get_the_category_list('<span class="dot">,</span>');
        $categories      = '';
        if ($show_cat && $categories_list) {
            // Make sure there's more than one category before displaying.
            $categories = '<div class="categories-link"><span class="screen-reader-text">' . esc_html__('Categories', 'liquory') . '</span>' . $categories_list . '</div>';
        }

        $author = '';
        // Author.
        if ($show_author == 1) {
            $author_id = $post->post_author;
            $author    = sprintf(
                '<div class="post-author"><span>' . esc_html__('By ', 'liquory') . '<a href="%1$s" class="url fn" rel="author">%2$s</a></span></div>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                esc_html(get_the_author_meta('display_name', $author_id))
            );
        }

        $posted_on = '';
        // Posted on.
        if ($show_date) {
            $posted_on = '<div class="posted-on">' . sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), get_the_modified_date()) . '</div>';
        }

        echo wp_kses(
            sprintf('%3$s  %1$s %2$s', $categories, $author, $posted_on), array(
                'div'  => array(
                    'class' => array(),
                ),
                'span' => array(
                    'class' => array(),
                ),
                'a'    => array(
                    'href'  => array(),
                    'rel'   => array(),
                    'class' => array(),
                ),
                'time' => array(
                    'datetime' => array(),
                    'class'    => array(),
                )
            )
        );

        if ($show_comment) { ?>
            <div class="meta-reply">
                <?php
                comments_popup_link(esc_html__('0 comments', 'liquory'), esc_html__('1 comment', 'liquory'), esc_html__('% comments', 'liquory'));
                ?>
            </div>
            <?php
        }

    }
}

if (!function_exists('liquory_get_allowed_html')) {
    function liquory_get_allowed_html() {
        return apply_filters(
            'liquory_allowed_html',
            array(
                'br'     => array(),
                'i'      => array(),
                'b'      => array(),
                'u'      => array(),
                'em'     => array(),
                'del'    => array(),
                'a'      => array(
                    'href'  => true,
                    'class' => true,
                    'title' => true,
                    'rel'   => true,
                ),
                'strong' => array(),
                'span'   => array(
                    'style' => true,
                    'class' => true,
                ),
            )
        );
    }
}

if (!function_exists('liquory_edit_post_link')) {
    /**
     * Display the edit link
     *
     * @since 2.5.0
     */
    function liquory_edit_post_link() {
        edit_post_link(
            sprintf(
                wp_kses(__('Edit <span class="screen-reader-text">%s</span>', 'liquory'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
    }
}

if (!function_exists('liquory_categories_link')) {
    /**
     * Prints HTML with meta information for the current cateogries
     */
    function liquory_categories_link() {

        // Get Categories for posts.
        $categories_list = get_the_category_list('');

        if ('post' === get_post_type() && $categories_list) {
            // Make sure there's more than one category before displaying.
            echo '<div class="categories-link"><span class="screen-reader-text">' . esc_html__('Categories', 'liquory') . '</span>' . $categories_list . '</div>';
        }
    }
}

if (!function_exists('liquory_post_taxonomy')) {
    /**
     * Display the post taxonomies
     *
     * @since 2.4.0
     */
    function liquory_post_taxonomy() {
        /* translators: used between list items, there is a space after the comma */

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', ' ');
        ?>
        <aside class="entry-taxonomy">
            <?php if ($tags_list) : ?>
                <div class="tags-links">
                    <span class="screen-reader-text"><?php echo esc_html(_n('Tag:', 'Tags:', count(get_the_tags()), 'liquory')); ?></span>
                    <?php printf('%s', $tags_list); ?>
                </div>
            <?php endif;
            ?>
        </aside>
        <?php
    }
}

if (!function_exists('liquory_paging_nav')) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function liquory_paging_nav() {
        global $wp_query;

        $args = array(
            'type'      => 'list',
            'next_text' => '<span>' . esc_html__('Next', 'liquory') . '</span><i class="liquory-icon liquory-icon-angle-right"></i>',
            'prev_text' => '<i class="liquory-icon liquory-icon-angle-left"></i><span>' . esc_html__('Previous', 'liquory') . '</span>',
        );

        the_posts_pagination($args);
    }
}

if (!function_exists('liquory_post_nav')) {
    /**
     * Display navigation to next/previous post when applicable.
     */
    function liquory_post_nav() {

        $prev_post      = get_previous_post();
        $next_post      = get_next_post();
        $args           = [];
        $thumbnail_prev = '';
        $thumbnail_next = '';

        if ($prev_post) {
            $thumbnail_prev = get_the_post_thumbnail($prev_post->ID, array(60, 60));
        };

        if ($next_post) {
            $thumbnail_next = get_the_post_thumbnail($next_post->ID, array(60, 60));
        };
        if ($next_post) {
            $args['next_text'] = '<span class="nav-content"><span class="reader-text">' . esc_html__('Next', 'liquory') . ' </span><span class="title">%title</span></span>' . $thumbnail_next;
        }
        if ($prev_post) {
            $args['prev_text'] = $thumbnail_prev . '<span class="nav-content"><span class="reader-text">' . esc_html__('Prev', 'liquory') . ' </span><span class="title">%title</span></span> ';
        }

        the_post_navigation($args);

    }
}

if (!function_exists('liquory_posted_on')) {
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     *
     * @deprecated 2.4.0
     */
    function liquory_posted_on() {
        _deprecated_function('liquory_posted_on', '2.4.0');
    }
}

if (!function_exists('liquory_homepage_content')) {
    /**
     * Display homepage content
     * Hooked into the `homepage` action in the homepage template
     *
     * @return  void
     * @since  1.0.0
     */
    function liquory_homepage_content() {
        while (have_posts()) {
            the_post();

            get_template_part('content', 'homepage');

        } // end of the loop.
    }
}

if (!function_exists('liquory_get_sidebar')) {
    /**
     * Display liquory sidebar
     *
     * @uses get_sidebar()
     * @since 1.0.0
     */
    function liquory_get_sidebar() {
        get_sidebar();
    }
}

if (!function_exists('liquory_post_thumbnail')) {
    /**
     * Display post thumbnail
     *
     * @param string $size the post thumbnail size.
     *
     * @uses has_post_thumbnail()
     * @uses the_post_thumbnail
     * @var $size . thumbnail|medium|large|full|$custom
     * @since 1.5.0
     */
    function liquory_post_thumbnail($size = 'post-thumbnail', $showcate = false) {
        if (has_post_thumbnail()) {
            echo '<div class="post-thumbnail">';
            if ($showcate) { ?>
                    <?php liquory_post_meta(['show_cat' => true, 'show_date' => false, 'show_author'  => false]); ?>
            <?php }
            the_post_thumbnail($size ? $size : 'post-thumbnail');
            echo '</div>';
        }
    }
}

if (!function_exists('liquory_primary_navigation_wrapper')) {
    /**
     * The primary navigation wrapper
     */
    function liquory_primary_navigation_wrapper() {
        echo '<div class="liquory-primary-navigation"><div class="col-full">';
    }
}

if (!function_exists('liquory_primary_navigation_wrapper_close')) {
    /**
     * The primary navigation wrapper close
     */
    function liquory_primary_navigation_wrapper_close() {
        echo '</div></div>';
    }
}

if (!function_exists('liquory_header_container')) {
    /**
     * The header container
     */
    function liquory_header_container() {
        echo '<div class="col-full">';
    }
}

if (!function_exists('liquory_header_container_close')) {
    /**
     * The header container close
     */
    function liquory_header_container_close() {
        echo '</div>';
    }
}

if (!function_exists('liquory_header_custom_link')) {
    function liquory_header_custom_link() {
        echo liquory_get_theme_option('custom-link', '');
    }

}

if (!function_exists('liquory_header_contact_info')) {
    function liquory_header_contact_info() {
        echo liquory_get_theme_option('contact-info', '');
    }

}

if (!function_exists('liquory_header_account')) {
    function liquory_header_account() {

        if (!liquory_get_theme_option('show_header_account', true)) {
            return;
        }

        if (liquory_is_woocommerce_activated()) {
            $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $account_link = wp_login_url();
        }
        ?>
        <div class="site-header-account">
            <a href="<?php echo esc_url($account_link); ?>">
                <i class="liquory-icon-user-o"></i>
            </a>
            <div class="account-dropdown">

            </div>
        </div>
        <?php
    }

}

if (!function_exists('liquory_template_account_dropdown')) {
    function liquory_template_account_dropdown() {
        if (!liquory_get_theme_option('show_header_account', true)) {
            return;
        }
        ?>
        <div class="account-wrap d-none">
            <div class="account-inner <?php if (is_user_logged_in()): echo "dashboard"; endif; ?>">
                <?php if (!is_user_logged_in()) {
                    liquory_form_login();
                } else {
                    liquory_account_dropdown();
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('liquory_form_login')) {
    function liquory_form_login() {
        if (liquory_is_woocommerce_activated() && 'yes' === get_option('woocommerce_enable_myaccount_registration')) {
            $register_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $register_link = wp_registration_url();
        }
        ?>
        <div class="login-form-head">
            <span class="login-form-title"><?php esc_attr_e('Sign in', 'liquory') ?></span>
            <span class="pull-right">
                <a class="register-link" href="<?php echo esc_url($register_link); ?>"
                   title="<?php esc_attr_e('Register', 'liquory'); ?>"><?php esc_attr_e('Create an Account', 'liquory'); ?></a>
            </span>
        </div>
        <form class="liquory-login-form-ajax" data-toggle="validator">
            <p>
                <label><?php esc_attr_e('Username or email', 'liquory'); ?> <span class="required">*</span></label>
                <input name="username" type="text" required placeholder="<?php esc_attr_e('Username', 'liquory') ?>">
            </p>
            <p>
                <label><?php esc_attr_e('Password', 'liquory'); ?> <span class="required">*</span></label>
                <input name="password" type="password" required
                       placeholder="<?php esc_attr_e('Password', 'liquory') ?>">
            </p>
            <button type="submit" data-button-action
                    class="btn btn-primary btn-block w-100 mt-1"><?php esc_html_e('Login', 'liquory') ?></button>
            <input type="hidden" name="action" value="liquory_login">
            <?php wp_nonce_field('ajax-liquory-login-nonce', 'security-login'); ?>
        </form>
        <div class="login-form-bottom">
            <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="lostpass-link"
               title="<?php esc_attr_e('Lost your password?', 'liquory'); ?>"><?php esc_attr_e('Lost your password?', 'liquory'); ?></a>
        </div>
        <?php
    }
}

if (!function_exists('')) {
    function liquory_account_dropdown() { ?>
        <?php if (has_nav_menu('my-account')) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e('Dashboard', 'liquory'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'my-account',
                    'menu_class'     => 'account-links-menu',
                    'depth'          => 1,
                ));
                ?>
            </nav><!-- .social-navigation -->
        <?php else: ?>
            <ul class="account-dashboard">
                <?php if (liquory_is_woocommerce_activated()): ?>
                    <li>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                           title="<?php esc_html_e('My account', 'liquory'); ?>"><?php esc_html_e('Dashboard', 'liquory'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"
                           title="<?php esc_html_e('Orders', 'liquory'); ?>"><?php esc_html_e('Orders', 'liquory'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>"
                           title="<?php esc_html_e('Downloads', 'liquory'); ?>"><?php esc_html_e('Downloads', 'liquory'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>"
                           title="<?php esc_html_e('Edit Address', 'liquory'); ?>"><?php esc_html_e('Edit Address', 'liquory'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>"
                           title="<?php esc_html_e('Account Details', 'liquory'); ?>"><?php esc_html_e('Account Details', 'liquory'); ?></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>"
                           title="<?php esc_html_e('Dashboard', 'liquory'); ?>"><?php esc_html_e('Dashboard', 'liquory'); ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a title="<?php esc_html_e('Log out', 'liquory'); ?>" class="tips"
                       href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log Out', 'liquory'); ?></a>
                </li>
            </ul>
        <?php endif;

    }
}

if (!function_exists('liquory_header_search_popup')) {
    function liquory_header_search_popup() {
        ?>
        <div class="site-search-popup">
            <div class="site-search-popup-wrap">
                <a href="#" class="site-search-popup-close"><i class="liquory-icon-times-circle"></i></a>
                <?php
                if (liquory_is_woocommerce_activated()) {
                    liquory_product_search();
                } else {
                    ?>
                    <div class="site-search">
                        <?php get_search_form(); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="site-search-popup-overlay"></div>
        <?php
    }
}

if (!function_exists('liquory_header_search_button')) {
    function liquory_header_search_button() {

        add_action('wp_footer', 'liquory_header_search_popup', 1);
        ?>
        <div class="site-header-search">
            <a href="#" class="button-search-popup"><i class="liquory-icon-search"></i></a>
        </div>
        <?php
    }
}


if (!function_exists('liquory_header_sticky')) {
    function liquory_header_sticky() {
        get_template_part('template-parts/header', 'sticky');
    }
}

if (!function_exists('liquory_mobile_nav')) {
    function liquory_mobile_nav() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            ?>
            <div class="liquory-mobile-nav">
                <div class="menu-scroll-mobile">
                    <a href="#" class="mobile-nav-close"><i class="liquory-icon-times"></i></a>
                    <?php
                    liquory_mobile_navigation();
                    liquory_social();
                    ?>
                </div>
                <?php if (liquory_is_elementor_activated()) liquory_language_switcher_mobile(); ?>
            </div>
            <div class="liquory-overlay"></div>
            <?php
        }
    }
}

if (!function_exists('liquory_mobile_nav_button')) {
    function liquory_mobile_nav_button() {
        if (isset(get_nav_menu_locations()['handheld'])) {
            ?>
            <a href="#" class="menu-mobile-nav-button">
				<span
                        class="toggle-text screen-reader-text"><?php echo esc_attr(apply_filters('liquory_menu_toggle_text', esc_html__('Menu', 'liquory'))); ?></span>
                <div class="liquory-icon">
                    <span class="icon-1"></span>
                    <span class="icon-2"></span>
                    <span class="icon-3"></span>
                </div>
            </a>
            <?php
        }
    }
}

if (!function_exists('liquory_language_switcher')) {
    function liquory_language_switcher() {
        $languages = apply_filters('wpml_active_languages', []);
        if (liquory_is_wpml_activated() && count($languages) > 0) {
            ?>
            <div class="liquory-language-switcher">
                <ul class="menu">
                    <li class="item">
                        <div class="language-switcher-head">
                            <span class="title"><?php echo esc_html($languages[ICL_LANGUAGE_CODE]['translated_name']); ?></span>
                            <i aria-hidden="true" class="liquory-icon-angle-down"></i>
                        </div>
                        <ul class="sub-item">
                            <?php
                            foreach ($languages as $key => $language) {
                                if (ICL_LANGUAGE_CODE === $key) {
                                    continue;
                                }
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($language['url']) ?>">
                                        <img width="18" height="12"
                                             src="<?php echo esc_url($language['country_flag_url']) ?>"
                                             alt="<?php esc_attr($language['default_locale']) ?>">
                                        <span><?php echo esc_html($language['translated_name']); ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php
        }

    }
}

if (!function_exists('liquory_language_switcher_mobile')) {
    function liquory_language_switcher_mobile() {
        $languages = apply_filters('wpml_active_languages', []);
        if (liquory_is_wpml_activated() && count($languages) > 0) { ?>
            <div class="liquory-language-switcher-mobile">
                <ul class="menu">
                    <li class="item">
                        <div class="language-switcher-head">
                            <img src="<?php echo esc_url($languages[ICL_LANGUAGE_CODE]['country_flag_url']) ?>"
                                 alt="<?php esc_attr($languages[ICL_LANGUAGE_CODE]['default_locale']) ?>">
                        </div>
                    </li>
                    <?php foreach ($languages as $key => $language) {
                        if (ICL_LANGUAGE_CODE === $key) {
                            continue;
                        } ?>
                        <li class="item">
                            <div class="language-switcher-img">
                                <a href="<?php echo esc_url($language['url']) ?>">
                                    <img src="<?php echo esc_url($language['country_flag_url']) ?>"
                                         alt="<?php esc_attr($language['default_locale']) ?>">
                                </a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
        }
    }
}


if (!function_exists('liquory_footer_default')) {
    function liquory_footer_default() {
        get_template_part('template-parts/copyright');
    }
}

if (!function_exists('liquory_pingback_header')) {
    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     */
    function liquory_pingback_header() {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }
}

if (!function_exists('liquory_update_comment_fields')) {
    function liquory_update_comment_fields($fields) {

        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $aria_req  = $req ? "aria-required='true'" : '';

        $fields['author']
            = '<p class="comment-form-author">
			<input id="author" name="author" type="text" placeholder="' . esc_attr__('Your Name *', 'liquory') . '" value="' . esc_attr($commenter['comment_author']) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['email']
            = '<p class="comment-form-email">
			<input id="email" name="email" type="email" placeholder="' . esc_attr__('Email Address *', 'liquory') . '" value="' . esc_attr($commenter['comment_author_email']) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['url']
            = '<p class="comment-form-url">
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__('Your Website', 'liquory') . '" value="' . esc_attr($commenter['comment_author_url']) .
              '" size="30" />
			</p>';

        return $fields;
    }
}

add_filter('comment_form_default_fields', 'liquory_update_comment_fields');


function custom_comment_form_defaults($defaults) {
    $defaults['submit_button'] = '<button type="submit" id="%2$s" class="%3$s" value="%4$s"><span>%4$s</span></button>';
    return $defaults;
}

add_filter('comment_form_defaults', 'custom_comment_form_defaults');


if (!function_exists('liquory_update_comment_review_fields')) {
    function liquory_update_comment_review_fields($comment_form) {
        $commenter = wp_get_current_commenter();

        $name_email_required = (bool)get_option('require_name_email', 1);
        $fields              = array(
            'author' => array(
                'label'    => esc_html__('Name', 'liquory'),
                'type'     => 'text',
                'value'    => $commenter['comment_author'],
                'required' => $name_email_required,
            ),
            'email'  => array(
                'label'    => esc_html__('Email', 'liquory'),
                'type'     => 'email',
                'value'    => $commenter['comment_author_email'],
                'required' => $name_email_required,
            ),
        );

        $comment_form['fields'] = array();

        foreach ($fields as $key => $field) {
            $field_html = '<p class="comment-form-' . esc_attr($key) . '">';

            $field_html .= '<input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" value="' . esc_attr($field['value']) . '" size="30" ' . ($field['required'] ? 'required' : '') . ' placeholder="' . esc_html($field['label']) . ' *"' . ' />';

            $field_html .= '</p>';

            $comment_form['fields'][$key] = $field_html;
        }

        if (wc_review_ratings_enabled()) {
            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'liquory') . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__('Rate&hellip;', 'liquory') . '</option>
						<option value="5">' . esc_html__('Perfect', 'liquory') . '</option>
						<option value="4">' . esc_html__('Good', 'liquory') . '</option>
						<option value="3">' . esc_html__('Average', 'liquory') . '</option>
						<option value="2">' . esc_html__('Not that bad', 'liquory') . '</option>
						<option value="1">' . esc_html__('Very poor', 'liquory') . '</option>
					</select></div>';
        }
        $comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" required placeholder="' . esc_html__('Your review *', 'liquory') . '"></textarea></p>';

        return $comment_form;
    }
}
add_filter('woocommerce_product_review_comment_form_args', 'liquory_update_comment_review_fields');


function liquory_replace_categories_list($output, $args) {
    if ($args['show_count'] = 1) {
        $pattern     = '#<li([^>]*)><a([^>]*)>(.*?)<\/a>\s*\(([0-9]*)\)\s*#i';  // removed ( and )
        $replacement = '<li$1><a$2><span class="cat-name">$3</span> <span class="cat-count">($4)</span></a>';
        return preg_replace($pattern, $replacement, $output);
    }
    return $output;
}

add_filter('wp_list_categories', 'liquory_replace_categories_list', 10, 2);

function liquory_replace_archive_list($link_html, $url, $text, $format, $before, $after, $selected) {
    if ($format == 'html') {
        $pattern     = '#<li><a([^>]*)>(.*?)<\/a>&nbsp;\s*\(([0-9]*)\)\s*#i';  // removed ( and )
        $replacement = '<li><a$1><span class="archive-name">$2</span> <span class="archive-count">($3)</span></a>';
        return preg_replace($pattern, $replacement, $link_html);
    }
    return $link_html;
}

add_filter('get_archives_link', 'liquory_replace_archive_list', 10, 7);


add_filter('bcn_breadcrumb_title', 'liquory_breadcrumb_title_swapper', 3, 10);
function liquory_breadcrumb_title_swapper($title, $type, $id) {
    if (in_array('home', $type)) {
        $title = esc_html__('Home', 'liquory');
    }
    return $title;
}

add_action('wp_footer', 'liquory_render_html_back_to_top');
function liquory_render_html_back_to_top() {
    echo sprintf('<a href="#" class="scrollup"><span class="scrollup-icon liquory-icon-angle-up"></span><span class="scrollup-label">%s</span></a>',
        esc_html__('Top', 'liquory'));

}
