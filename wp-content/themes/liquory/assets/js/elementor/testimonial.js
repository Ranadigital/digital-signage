(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/liquory-testimonials.default', ($scope) => {
            let $carousel = $('.liquory-carousel', $scope);
            if ($carousel.length > 0) {
                let data = $carousel.data('settings');
                liquory_slick_carousel_init($carousel, data);
            }
        });
    });

})(jQuery);
