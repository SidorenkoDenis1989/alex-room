import 'slick-carousel';

(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        $(".product--gallery").each(function(index, gallery) {
            $(gallery).slick({
                prevArrow: $(gallery).parent().find($('.gallery--button__prev')),
                nextArrow: $(gallery).parent().find($('.gallery--button__next')),
            });
        });

        const archiveProductLink = $('.woocommerce-loop-product__link');
        archiveProductLink.on("click", e => {
            if (e.target.nodeName === 'svg' || e.target.nodeName === 'BUTTON' || e.target.nodeName === 'button') {
                e.preventDefault();
            }

        });
        archiveProductLink.on("swipe", e => {
            e.preventDefault();
        });
    });
})(jQuery);