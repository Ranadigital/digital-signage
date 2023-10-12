<?php

namespace Liquory\Liquory_Age_Verification;

class Liquory_Age_Verification {
    private static $_instance = null;

    public static function instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10);
        add_action('wp_footer', array($this, 'liquory_avpublic_js'));
    }

    public function enqueue_scripts() {
        global $liquory_version;
        if ('1' == get_theme_mod('liquory_Enable')) {
            wp_enqueue_script('liquory-age-verification-cookie', get_template_directory_uri() . '/assets/js/frontend/js.cookie.js', array('jquery'), $liquory_version, false);
            wp_enqueue_script('age-verification', get_template_directory_uri() . '/assets/js/frontend/age-verification.js', array('jquery'), $liquory_version, false);
        }
    }

    function liquory_avpublic_js() {
        $landing = apply_filters('liquory_landing_id', '');
        // Empty redirect.
        $redirect_fail = '';

        // Set the redirect URL.
        $redirectOnFail = esc_url(apply_filters('liquory_avredirect_on_fail_link', $redirect_fail));

        // Add content before popup contents.
        $beforeContent = apply_filters('liquory_avbefore_popup_content', '');

        // Add content after popup contents.
        $afterContent = apply_filters('liquory_avafter_popup_content', '');

        // Add JavaScript codes to footer based on setting in the Customizer.

        if ('1' != get_theme_mod('liquory_Enable') || ('1' === get_theme_mod('liquory_adminHide') && current_user_can('administrator')) || $landing === get_queried_object_id()) {
            // Do nothing.
        } else { ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $.liquoryageCheck({
                        "bgImage": '<?php echo get_theme_mod('liquory_bgImage', '') ?>',
                        "minAge": '<?php echo get_theme_mod('liquory_minAge', '18')?>',
                        "imgLogo": '<?php echo get_theme_mod('liquory_logo', '')?>',
                        "title": '<?php echo get_theme_mod('liquory_title', '')?>',
                        "description": '<?php echo get_theme_mod('liquory_description', '')?>',
                        "copy": '<?php echo get_theme_mod('liquory_copy', esc_attr__('You must be [age] years old to enter.', 'liquory'))?>',
                        'btnYes': '<?php  echo get_theme_mod('liquory_button_yes', esc_attr__('YES', 'liquory'))?>',
                        'btnNo': '<?php echo get_theme_mod('liquory_button_no', esc_attr__('NO', 'liquory'))?>',
                        "successTitle": '<?php echo esc_attr__('Success!', 'liquory')?>',
                        "successText": '<?php echo esc_attr__('You are now being redirected back to the site ...', 'liquory')?>',
                        "successMessage": '<?php echo get_theme_mod('liquory_success_message', 'show')?>',
                        "failTitle": '<?php echo esc_attr__('Sorry!', 'liquory')?>',
                        "failText": '<?php echo esc_attr__('You are not old enough to view the site ...', 'liquory')?>',
                        "messageTime": '<?php echo get_theme_mod('liquory_message_display_time', '2000')?>',
                        "cookieDays": '<?php echo get_theme_mod('liquory_cookie_days', '30')?>',
                        "redirectOnFail": '<?php echo $redirectOnFail?>',
                        "beforeContent": '<?php echo $beforeContent?>',
                        "afterContent": '<?php echo $afterContent?>'
                    });
                });
            </script>
            <?php
        } // end adminHide check.
    }

}

Liquory_Age_Verification::instance();