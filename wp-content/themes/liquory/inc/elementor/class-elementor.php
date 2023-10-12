<?php


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Liquory_Elementor')) :

    /**
     * The Liquory Elementor Integration class
     */
    class Liquory_Elementor {
        private $suffix = '';

        public function __construct() {
            $this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            add_action('wp', [$this, 'register_auto_scripts_frontend']);
            add_action('elementor/init', array($this, 'add_category'));
            add_action('wp_enqueue_scripts', [$this, 'add_scripts'], 15);
            add_action('elementor/widgets/widgets_registered', array($this, 'include_widgets'));
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'add_js']);

            // Custom Animation Scroll
            add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

            // Elementor Fix Noitice WooCommerce
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'woocommerce_fix_notice'));

            // Backend
            add_action('elementor/editor/after_enqueue_styles', [$this, 'add_style_editor'], 99);

            // Add Icon Custom
            add_action('elementor/icons_manager/native', [$this, 'add_icons_native']);
            add_action('elementor/controls/controls_registered', [$this, 'add_icons']);

            // Add Breakpoints
            add_action('wp_enqueue_scripts', 'liquory_elementor_breakpoints', 9999);

            if (!liquory_is_elementor_pro_activated()) {
                require trailingslashit(get_template_directory()) . 'inc/elementor/class-custom-css.php';
                require trailingslashit(get_template_directory()) . 'inc/elementor/class-section-sticky.php';
                if (is_admin()) {
                    add_action('manage_elementor_library_posts_columns', [$this, 'admin_columns_headers']);
                    add_action('manage_elementor_library_posts_custom_column', [$this, 'admin_columns_content'], 10, 2);
                }
            }

            add_filter('elementor/fonts/additional_fonts', [$this, 'additional_fonts']);

        }

        public function additional_fonts($fonts) {
            $fonts["Outfit"] = 'googlefonts';
            return $fonts;
        }

        public function admin_columns_headers($defaults) {
            $defaults['shortcode'] = esc_html__('Shortcode', 'liquory');

            return $defaults;
        }

        public function admin_columns_content($column_name, $post_id) {
            if ('shortcode' === $column_name) {
                ob_start();
                ?>
                <input class="elementor-shortcode-input" type="text" readonly onfocus="this.select()" value="[hfe_template id='<?php echo esc_attr($post_id); ?>']"/>
                <?php
                ob_get_contents();
            }
        }

        public function add_js() {
            global $liquory_version;
            wp_enqueue_script('liquory-elementor-frontend', get_theme_file_uri('/assets/js/elementor-frontend.js'), [], $liquory_version);
        }

        public function add_style_editor() {
            global $liquory_version;
            wp_enqueue_style('liquory-elementor-editor-icon', get_theme_file_uri('/assets/css/admin/elementor/icons.css'), [], $liquory_version);
        }

        public function add_scripts() {
            global $liquory_version;
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_enqueue_style('liquory-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', $liquory_version);
            wp_style_add_data('liquory-elementor', 'rtl', 'replace');

            // Add Scripts
            wp_register_script('tweenmax', get_theme_file_uri('/assets/js/libs/TweenMax.min.js'), array('jquery'), '1.11.1');

            if (liquory_elementor_check_type('animated-bg-parallax')) {
                wp_enqueue_script('tweenmax');
                wp_enqueue_script('jquery-panr', get_theme_file_uri('/assets/js/libs/jquery-panr' . $suffix . '.js'), array('jquery'), '0.0.1');
            }
        }

        public function register_auto_scripts_frontend() {
            global $liquory_version;
            wp_register_script('liquory-elementor-brand', get_theme_file_uri('/assets/js/elementor/brand.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-countdown', get_theme_file_uri('/assets/js/elementor/countdown.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-image-carousel', get_theme_file_uri('/assets/js/elementor/image-carousel.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-image-gallery', get_theme_file_uri('/assets/js/elementor/image-gallery.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-image-hotspots', get_theme_file_uri('/assets/js/elementor/image-hotspots.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-product-categories', get_theme_file_uri('/assets/js/elementor/product-categories.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-product-tab', get_theme_file_uri('/assets/js/elementor/product-tab.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-products', get_theme_file_uri('/assets/js/elementor/products.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-tabs', get_theme_file_uri('/assets/js/elementor/tabs.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial.js'), array('jquery','elementor-frontend'), $liquory_version, true);
            wp_register_script('liquory-elementor-video', get_theme_file_uri('/assets/js/elementor/video.js'), array('jquery','elementor-frontend'), $liquory_version, true);
           
        }

        public function add_category() {
            Elementor\Plugin::instance()->elements_manager->add_category(
                'liquory-addons',
                array(
                    'title' => esc_html__('Liquory Addons', 'liquory'),
                    'icon'  => 'fa fa-plug',
                ), 1);
        }

        public function add_animations_scroll($animations) {
            $animations['Liquory Animation'] = [
                'opal-move-up'    => 'Move Up',
                'opal-move-down'  => 'Move Down',
                'opal-move-left'  => 'Move Left',
                'opal-move-right' => 'Move Right',
                'opal-flip'       => 'Flip',
                'opal-helix'      => 'Helix',
                'opal-scale-up'   => 'Scale',
                'opal-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets($widgets_manager) {
            require 'base_widgets.php';

            $files_custom = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
            foreach ($files_custom as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }

            $files = glob(get_theme_file_path('/inc/elementor/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        public function woocommerce_fix_notice() {
            if (liquory_is_woocommerce_activated()) {
                remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
                remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
            }
        }

        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"liquory-icon-account":"account","liquory-icon-alarm":"alarm","liquory-icon-amazing-value":"amazing-value","liquory-icon-angle-down":"angle-down","liquory-icon-angle-left":"angle-left","liquory-icon-angle-right":"angle-right","liquory-icon-angle-up":"angle-up","liquory-icon-arrow_s":"arrow_s","liquory-icon-arrow-right1":"arrow-right1","liquory-icon-beer":"beer","liquory-icon-beer2":"beer2","liquory-icon-best-seller":"best-seller","liquory-icon-breadcrumb":"breadcrumb","liquory-icon-calendar-alt":"calendar-alt","liquory-icon-cart":"cart","liquory-icon-check-o":"check-o","liquory-icon-check-square-solid":"check-square-solid","liquory-icon-click":"click","liquory-icon-clock":"clock","liquory-icon-close-circle-line":"close-circle-line","liquory-icon-club":"club","liquory-icon-cocktail":"cocktail","liquory-icon-cocktail2":"cocktail2","liquory-icon-cogac":"cogac","liquory-icon-cogac2":"cogac2","liquory-icon-coolicon":"coolicon","liquory-icon-day-delivery":"day-delivery","liquory-icon-delivery":"delivery","liquory-icon-directly":"directly","liquory-icon-expert":"expert","liquory-icon-facebook-o":"facebook-o","liquory-icon-fast-delivery":"fast-delivery","liquory-icon-featured":"featured","liquory-icon-filter-ul":"filter-ul","liquory-icon-filters":"filters","liquory-icon-free-return":"free-return","liquory-icon-gift2":"gift2","liquory-icon-grape":"grape","liquory-icon-great-value":"great-value","liquory-icon-grid-o":"grid-o","liquory-icon-help-center":"help-center","liquory-icon-increase":"increase","liquory-icon-instagram-o":"instagram-o","liquory-icon-layout-grid-line":"layout-grid-line","liquory-icon-left-arrow":"left-arrow","liquory-icon-linkedin-in":"linkedin-in","liquory-icon-list-o":"list-o","liquory-icon-long-arrow-down":"long-arrow-down","liquory-icon-long-arrow-right":"long-arrow-right","liquory-icon-long-arrow-up":"long-arrow-up","liquory-icon-mail-send-line":"mail-send-line","liquory-icon-map-marker-alt":"map-marker-alt","liquory-icon-map-pin-line":"map-pin-line","liquory-icon-marketplace":"marketplace","liquory-icon-minus-o":"minus-o","liquory-icon-mobile-shopping":"mobile-shopping","liquory-icon-mobile":"mobile","liquory-icon-money-check":"money-check","liquory-icon-movies":"movies","liquory-icon-new":"new","liquory-icon-play-fill":"play-fill","liquory-icon-plus-o":"plus-o","liquory-icon-plus2":"plus2","liquory-icon-price":"price","liquory-icon-quote-left":"quote-left","liquory-icon-reply-line":"reply-line","liquory-icon-right-arrow-cicrle":"right-arrow-cicrle","liquory-icon-right-arrow":"right-arrow","liquory-icon-safe-packaging":"safe-packaging","liquory-icon-sale":"sale","liquory-icon-search2":"search2","liquory-icon-send-back":"send-back","liquory-icon-setting":"setting","liquory-icon-share-all":"share-all","liquory-icon-shopping-new":"shopping-new","liquory-icon-sliders-v":"sliders-v","liquory-icon-store2":"store2","liquory-icon-support":"support","liquory-icon-team":"team","liquory-icon-tequila":"tequila","liquory-icon-th-large-o":"th-large-o","liquory-icon-ticket-simple":"ticket-simple","liquory-icon-trusted-marketplace":"trusted-marketplace","liquory-icon-twitter-o":"twitter-o","liquory-icon-user-o":"user-o","liquory-icon-valuable":"valuable","liquory-icon-wallet-security":"wallet-security","liquory-icon-whiskey":"whiskey","liquory-icon-whiskey2":"whiskey2","liquory-icon-wine-tasting":"wine-tasting","liquory-icon-wine":"wine","liquory-icon-wine2":"wine2","liquory-icon-360":"360","liquory-icon-arrow-down":"arrow-down","liquory-icon-arrow-left":"arrow-left","liquory-icon-arrow-right":"arrow-right","liquory-icon-arrow-up":"arrow-up","liquory-icon-bars":"bars","liquory-icon-caret-down":"caret-down","liquory-icon-caret-left":"caret-left","liquory-icon-caret-right":"caret-right","liquory-icon-caret-up":"caret-up","liquory-icon-cart-empty":"cart-empty","liquory-icon-check-square":"check-square","liquory-icon-chevron-down":"chevron-down","liquory-icon-chevron-left":"chevron-left","liquory-icon-chevron-right":"chevron-right","liquory-icon-chevron-up":"chevron-up","liquory-icon-circle":"circle","liquory-icon-cloud-download-alt":"cloud-download-alt","liquory-icon-comment":"comment","liquory-icon-comments":"comments","liquory-icon-compare":"compare","liquory-icon-contact":"contact","liquory-icon-credit-card":"credit-card","liquory-icon-dot-circle":"dot-circle","liquory-icon-edit":"edit","liquory-icon-envelope":"envelope","liquory-icon-expand-alt":"expand-alt","liquory-icon-external-link-alt":"external-link-alt","liquory-icon-file-alt":"file-alt","liquory-icon-file-archive":"file-archive","liquory-icon-filter":"filter","liquory-icon-folder-open":"folder-open","liquory-icon-folder":"folder","liquory-icon-frown":"frown","liquory-icon-gift":"gift","liquory-icon-grid":"grid","liquory-icon-grip-horizontal":"grip-horizontal","liquory-icon-heart-fill":"heart-fill","liquory-icon-heart":"heart","liquory-icon-history":"history","liquory-icon-home":"home","liquory-icon-info-circle":"info-circle","liquory-icon-instagram":"instagram","liquory-icon-level-up-alt":"level-up-alt","liquory-icon-list":"list","liquory-icon-map-marker-check":"map-marker-check","liquory-icon-meh":"meh","liquory-icon-minus-circle":"minus-circle","liquory-icon-minus":"minus","liquory-icon-mobile-android-alt":"mobile-android-alt","liquory-icon-money-bill":"money-bill","liquory-icon-pencil-alt":"pencil-alt","liquory-icon-plus-circle":"plus-circle","liquory-icon-plus":"plus","liquory-icon-quickview":"quickview","liquory-icon-random":"random","liquory-icon-rating-stroke":"rating-stroke","liquory-icon-rating":"rating","liquory-icon-reply-all":"reply-all","liquory-icon-reply":"reply","liquory-icon-search-plus":"search-plus","liquory-icon-search":"search","liquory-icon-shield-check":"shield-check","liquory-icon-shopping-basket":"shopping-basket","liquory-icon-shopping-cart":"shopping-cart","liquory-icon-sign-out-alt":"sign-out-alt","liquory-icon-smile":"smile","liquory-icon-spinner":"spinner","liquory-icon-square":"square","liquory-icon-star":"star","liquory-icon-store":"store","liquory-icon-sync":"sync","liquory-icon-tachometer-alt":"tachometer-alt","liquory-icon-th-large":"th-large","liquory-icon-th-list":"th-list","liquory-icon-thumbtack":"thumbtack","liquory-icon-ticket":"ticket","liquory-icon-times-circle":"times-circle","liquory-icon-times":"times","liquory-icon-trophy-alt":"trophy-alt","liquory-icon-user-headset":"user-headset","liquory-icon-user-shield":"user-shield","liquory-icon-user":"user","liquory-icon-video":"video","liquory-icon-wishlist-empty":"wishlist-empty","liquory-icon-wishlist":"wishlist","liquory-icon-adobe":"adobe","liquory-icon-amazon":"amazon","liquory-icon-android":"android","liquory-icon-angular":"angular","liquory-icon-apper":"apper","liquory-icon-apple":"apple","liquory-icon-atlassian":"atlassian","liquory-icon-behance":"behance","liquory-icon-bitbucket":"bitbucket","liquory-icon-bitcoin":"bitcoin","liquory-icon-bity":"bity","liquory-icon-bluetooth":"bluetooth","liquory-icon-btc":"btc","liquory-icon-centos":"centos","liquory-icon-chrome":"chrome","liquory-icon-codepen":"codepen","liquory-icon-cpanel":"cpanel","liquory-icon-discord":"discord","liquory-icon-dochub":"dochub","liquory-icon-docker":"docker","liquory-icon-dribbble":"dribbble","liquory-icon-dropbox":"dropbox","liquory-icon-drupal":"drupal","liquory-icon-ebay":"ebay","liquory-icon-facebook-f":"facebook-f","liquory-icon-facebook":"facebook","liquory-icon-figma":"figma","liquory-icon-firefox":"firefox","liquory-icon-google-plus":"google-plus","liquory-icon-google":"google","liquory-icon-grunt":"grunt","liquory-icon-gulp":"gulp","liquory-icon-html5":"html5","liquory-icon-joomla":"joomla","liquory-icon-link-brand":"link-brand","liquory-icon-linkedin":"linkedin","liquory-icon-mailchimp":"mailchimp","liquory-icon-opencart":"opencart","liquory-icon-paypal":"paypal","liquory-icon-pinterest-p":"pinterest-p","liquory-icon-reddit":"reddit","liquory-icon-skype":"skype","liquory-icon-slack":"slack","liquory-icon-snapchat":"snapchat","liquory-icon-spotify":"spotify","liquory-icon-trello":"trello","liquory-icon-twitter":"twitter","liquory-icon-vimeo":"vimeo","liquory-icon-whatsapp":"whatsapp","liquory-icon-wordpress":"wordpress","liquory-icon-yoast":"yoast","liquory-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native($tabs) {
            global $liquory_version;
            $tabs['opal-custom'] = [
                'name'          => 'liquory-icon',
                'label'         => esc_html__('Liquory Icon', 'liquory'),
                'prefix'        => 'liquory-icon-',
                'displayPrefix' => 'liquory-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => $liquory_version,
                'fetchJson'     => get_theme_file_uri('/inc/elementor/icons.json'),
                'native'        => true,
            ];

            return $tabs;
        }
    }

endif;

return new Liquory_Elementor();
