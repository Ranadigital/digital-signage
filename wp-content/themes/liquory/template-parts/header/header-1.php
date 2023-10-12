<header id="masthead" class="site-header header-1" role="banner">
    <div class="header-container">
        <div class="container header-main">
            <div class="header-left">
                <?php
                liquory_site_branding();
                if (liquory_is_woocommerce_activated()) {
                    ?>
                    <div class="site-header-cart header-cart-mobile">
                        <?php liquory_cart_link(); ?>
                    </div>
                    <?php
                }
                ?>
                <?php liquory_mobile_nav_button(); ?>
            </div>
            <div class="header-center">
                <?php liquory_primary_navigation(); ?>
            </div>
            <div class="header-right desktop-hide-down">
                <div class="header-group-action">
                    <?php
                    liquory_header_account();
                    if (liquory_is_woocommerce_activated()) {
                        liquory_header_wishlist();
                        liquory_header_cart();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header><!-- #masthead -->
