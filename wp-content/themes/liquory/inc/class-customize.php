<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Liquory_Customize')) {

    class Liquory_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        public function get_banner() {
            global $post;

            $options[''] = esc_html__('Select Banner', 'liquory');
            if (!liquory_is_elementor_activated()) {
                return;
            }
            $args = array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                's'              => 'Banner ',
                'order'          => 'ASC',
            );

            $query1 = new WP_Query($args);
            while ($query1->have_posts()) {
                $query1->the_post();
                $options[$post->post_name] = $post->post_title;
            }

            wp_reset_postdata();
            return $options;
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function tesst($wp_customize) {
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    'dav_bgImage',
                    array(
                        'label'    => esc_attr__('Background image', 'liquory'),
                        'section'  => 'dav_display_options',
                        'settings' => 'dav_bgImage',
                        'priority' => 8
                    )
                )
            );
        }

        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */
            require_once get_theme_file_path('inc/customize-control/editor.php');
            $this->init_liquory_blog($wp_customize);
            $this->liquory_register_theme_customizer($wp_customize);


            if (liquory_is_woocommerce_activated()) {
                $this->init_woocommerce($wp_customize);
            }

            do_action('liquory_customize_register', $wp_customize);
        }

        function liquory_register_theme_customizer($wp_customize) {
            /**
             * Defining our own 'Display Options' section
             */
            $wp_customize->add_section(
                'liquory_display_options',
                array(
                    'title'    => esc_attr__('Age Verification', 'liquory'),
                    'priority' => 55,
                )
            );

            /* minAge */
            $wp_customize->add_setting(
                'liquory_minAge',
                array(
                    'default'           => '18',
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_minAge',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Minimum age?', 'liquory'),
                    'type'     => 'number',
                    'priority' => 7,
                )
            );

            /* Add setting for background image uploader. */
            $wp_customize->add_setting('liquory_bgImage');

            /* Add control for background image uploader (actual uploader) */
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    'liquory_bgImage',
                    array(
                        'label'    => esc_attr__('Background image', 'liquory'),
                        'section'  => 'liquory_display_options',
                        'settings' => 'liquory_bgImage',
                        'priority' => 8
                    )
                )
            );

            /* Add setting for logo uploader. */
            $wp_customize->add_setting('liquory_logo');

            /* Add control for logo uploader (actual uploader) */
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    'liquory_logo',
                    array(
                        'label'    => esc_attr__('Logo image', 'liquory'),
                        'section'  => 'liquory_display_options',
                        'settings' => 'liquory_logo',
                        'priority' => 9
                    )
                )
            );

            /* title */
            $wp_customize->add_setting(
                'liquory_title',
                array(
                    'default'           => esc_attr__('Age Verification', 'liquory'),
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_title',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Title', 'liquory'),
                    'type'     => 'text',
                    'priority' => 10,
                )
            );

            /* description */
            $wp_customize->add_setting(
                'liquory_description',
                array(
                    'default'           => esc_attr__('You must be of legal drinking age to buy our products. Age will be verified upon delivery through ID.', 'liquory'),
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_description',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Description', 'liquory'),
                    'type'     => 'textarea',
                    'priority' => 11,
                )
            );

            /* copy */
            $wp_customize->add_setting(
                'liquory_copy',
                array(
                    'default'           => esc_attr__('You must be [age] years old to enter.', 'liquory'),
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_copy',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Copy', 'liquory'),
                    'type'     => 'textarea',
                    'priority' => 13,
                )
            );

            /* Yes button */
            $wp_customize->add_setting(
                'liquory_button_yes',
                array(
                    'default'           => esc_attr__('YES', 'liquory'),
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_button_yes',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Button #1 text', 'liquory'),
                    'type'     => 'text',
                    'priority' => 14,
                )
            );

            /* No button */
            $wp_customize->add_setting(
                'liquory_button_no',
                array(
                    'default'           => esc_attr__('NO', 'liquory'),
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_button_no',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Button #2 text', 'liquory'),
                    'type'     => 'text',
                    'priority' => 13,
                )
            );

            /* Success/Failure message display time */
            $wp_customize->add_setting(
                'liquory_message_display_time',
                array(
                    'default'           => 2000,
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_message_display_time',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Message display time (milliseconds)', 'liquory'),
                    'type'     => 'number',
                    'priority' => 18,
                )
            );
            /* Success/Failure message display time */
            $wp_customize->add_setting(
                'liquory_cookie_days',
                array(
                    'default'           => 30,
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_cookie_days',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Cookie (day)', 'liquory'),
                    'type'     => 'number',
                    'priority' => 20,
                )
            );

            /* Show or Hide Blog Description */
            $wp_customize->add_setting(
                'liquory_adminHide',
                array(
                    'default'           => '',
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_adminHide',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Hide for admin users?', 'liquory'),
                    'type'     => 'checkbox',
                    'priority' => 99,
                )
            );

            /* Show or Hide Blog Description */
            $wp_customize->add_setting(
                'liquory_Enable',
                array(
                    'default'           => '',
                    'sanitize_callback' => 'liquory_sanitize_input',
                    'transport'         => 'refresh',
                )
            );
            $wp_customize->add_control(
                'liquory_Enable',
                array(
                    'section'  => 'liquory_display_options',
                    'label'    => esc_attr__('Enable Age Verification', 'liquory'),
                    'type'     => 'checkbox',
                    'priority' => 99,
                )
            );

        } // end liquory_register_theme_customizer

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_liquory_blog($wp_customize) {

            $wp_customize->add_panel('liquory_blog', array(
                'title' => esc_html__('Blog', 'liquory'),
            ));

            // =========================================
            // Blog Archive
            // =========================================
            $wp_customize->add_section('liquory_blog_archive', array(
                'title'      => esc_html__('Archive', 'liquory'),
                'panel'      => 'liquory_blog',
                'capability' => 'edit_theme_options',
            ));

            $wp_customize->add_setting('liquory_options_blog_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_blog_sidebar', array(
                'section' => 'liquory_blog_archive',
                'label'   => esc_html__('Sidebar Position', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__('None', 'liquory'),
                    'left'  => esc_html__('Left', 'liquory'),
                    'right' => esc_html__('Right', 'liquory'),
                ),
            ));

            $wp_customize->add_setting('liquory_options_blog_style', array(
                'type'              => 'option',
                'default'           => 'standard',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_blog_style', array(
                'section' => 'liquory_blog_archive',
                'label'   => esc_html__('Blog style', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'standard' => esc_html__('Blog Standard', 'liquory'),
                    'list'     => esc_html__('Blog List', 'liquory'),
                    'style-1'  => esc_html__('Blog Grid', 'liquory'),
                ),
            ));

            $wp_customize->add_setting('liquory_options_blog_columns', array(
                'type'              => 'option',
                'default'           => 1,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_blog_columns', array(
                'section' => 'liquory_blog_archive',
                'label'   => esc_html__('Colunms', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'liquory'),
                    2 => esc_html__('2', 'liquory'),
                    3 => esc_html__('3', 'liquory'),
                    4 => esc_html__('4', 'liquory'),
                ),
            ));

            // =========================================
            // Blog Single
            // =========================================
            $wp_customize->add_section('liquory_blog_single', array(
                'title'      => esc_html__('Singular', 'liquory'),
                'panel'      => 'liquory_blog',
                'capability' => 'edit_theme_options',
            ));
            $wp_customize->add_setting('liquory_options_blog_single_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_blog_single_sidebar', array(
                'section' => 'liquory_blog_single',
                'label'   => esc_html__('Sidebar Position', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__('None', 'liquory'),
                    'left'  => esc_html__('Left', 'liquory'),
                    'right' => esc_html__('Right', 'liquory'),
                ),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */


        public function init_woocommerce($wp_customize) {

            $wp_customize->add_panel('woocommerce', array(
                'title' => esc_html__('Woocommerce', 'liquory'),
            ));

            $wp_customize->add_section('liquory_woocommerce_archive', array(
                'title'      => esc_html__('Archive', 'liquory'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            if (liquory_is_elementor_activated()) {
                $wp_customize->add_setting('liquory_options_shop_banner', array(
                    'type'              => 'option',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('liquory_options_shop_banner', array(
                    'section'     => 'liquory_woocommerce_archive',
                    'label'       => esc_html__('Banner', 'liquory'),
                    'type'        => 'select',
                    'description' => __('Banner will take templates name prefix is "Banner"', 'liquory'),
                    'choices'     => $this->get_banner()
                ));
            }

            $wp_customize->add_setting('liquory_options_woocommerce_archive_layout', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_woocommerce_archive_layout', array(
                'section' => 'liquory_woocommerce_archive',
                'label'   => esc_html__('Layout Style', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'default' => esc_html__('Sidebar', 'liquory'),
                    //====start_premium
                    'canvas'  => esc_html__('Canvas Filter', 'liquory'),
                    //====end_premium
                ),
            ));

            $wp_customize->add_setting('liquory_options_woocommerce_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_woocommerce_archive_sidebar', array(
                'section' => 'liquory_woocommerce_archive',
                'label'   => esc_html__('Sidebar Position', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'liquory'),
                    'right' => esc_html__('Right', 'liquory'),

                ),
            ));

            // =========================================
            // Single Product
            // =========================================

            $wp_customize->add_section('liquory_woocommerce_single', array(
                'title'      => esc_html__('Singular', 'liquory'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            $wp_customize->add_setting('liquory_options_single_product_gallery_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('liquory_options_single_product_gallery_layout', array(
                'section' => 'liquory_woocommerce_single',
                'label'   => esc_html__('Style', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'horizontal' => esc_html__('Horizontal', 'liquory'),
                    //====start_premium
                    'vertical'   => esc_html__('Vertical', 'liquory'),
                    'gallery'    => esc_html__('Gallery', 'liquory'),
                    'sticky'     => esc_html__('Sticky', 'liquory'),
                    //====end_premium
                ),
            ));

            $wp_customize->add_setting('liquory_options_single_product_content_meta', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'liquory_sanitize_editor',
            ));

            $wp_customize->add_control(new Liquory_Customize_Control_Editor($wp_customize, 'liquory_options_single_product_content_meta', array(
                'section' => 'liquory_woocommerce_single',
                'label'   => esc_html__('Single extra description', 'liquory'),
            )));

            // =========================================
            // Product
            // =========================================
            $wp_customize->add_setting('liquory_options_wocommerce_row_laptop', array(
                'type'              => 'option',
                'default'           => 3,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_wocommerce_row_laptop', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row Laptop', 'liquory'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('liquory_options_wocommerce_row_tablet', array(
                'type'              => 'option',
                'default'           => 2,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_wocommerce_row_tablet', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row tablet', 'liquory'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('liquory_options_wocommerce_row_mobile', array(
                'type'              => 'option',
                'default'           => 1,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('liquory_options_wocommerce_row_mobile', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row mobile', 'liquory'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('liquory_options_wocommerce_block_style', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('liquory_options_wocommerce_block_style', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Style', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    '' => esc_html__('Style 1', 'liquory'),
                ),
            ));

            $wp_customize->add_setting('liquory_options_woocommerce_product_hover', array(
                'type'              => 'option',
                'default'           => 'none',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('liquory_options_woocommerce_product_hover', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Animation Image Hover', 'liquory'),
                'type'    => 'select',
                'choices' => array(
                    'none'          => esc_html__('None', 'liquory'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'liquory'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'liquory'),
                    'right-to-left' => esc_html__('Right to Left', 'liquory'),
                    'left-to-right' => esc_html__('Left to Right', 'liquory'),
                    'swap'          => esc_html__('Swap', 'liquory'),
                    'fade'          => esc_html__('Fade', 'liquory'),
                    'zoom-in'       => esc_html__('Zoom In', 'liquory'),
                    'zoom-out'      => esc_html__('Zoom Out', 'liquory'),
                ),
            ));
        }
    }
}
return new Liquory_Customize();
