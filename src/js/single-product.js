import 'slick-carousel';
import {AsyncHandler} from "./async-functions";
import {DOMService} from "./dom-service";

(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        $(".single-product--gallery__large").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            adaptiveHeight: true,
            fade: true,
            cssEase: 'linear',
            speed: 500,
            prevArrow: $(".single-product--gallery__large").parent().find($('.gallery--button__prev')),
            nextArrow: $(".single-product--gallery__large").parent().find($('.gallery--button__next')),
            asNavFor: ".single-product--gallery__small"
        });

        $(".single-product--gallery__small").slick({
            slidesToShow: 7,
            slidesToScroll: 1,
            infinite: true,
            speed: 500,
            arrows: false,
            asNavFor: ".single-product--gallery__large"
        });

        $('.single-product--gallery__small .slick-slide').on("click", function(){
            const slideIndex = $(this).attr('data-slick-index');
            $(".single-product--gallery__large").slick('slickGoTo', slideIndex);
        });


        $('body').on( 'click', 'button.plus, button.minus', function() {
            const qty = $(this).parent('.single-product--quantity__wrapper').find('.quantity').find('.qty');
            const val = parseFloat(qty.val());
            const max = parseFloat(qty.attr('max'));
            const min = parseFloat(qty.attr('min'));
            const STEP = 1;

            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( max <= val ) ) {
                    qty.val( max );
                }
                else {
                    qty.val( val + STEP );
                }
            }
            else {
                if ( min && ( min >= val ) ) {
                    qty.val( min );
                }
                else if ( val > 1 ) {
                    qty.val( val - STEP );
                }
            }
        });

        const singleAddToCartButton = document.querySelector('.single_add_to_cart_button');
        if (singleAddToCartButton) {
            singleAddToCartButton.addEventListener("click", function (e){
                e.preventDefault();
                const variation_input = document.querySelector('form input.variation_id');
                const variation_id = variation_input ? variation_input.value : 0;
                const product_input = document.querySelector('form input[name="product_id"]');
                const $productId = product_input ? product_input.value : this.value;
                const qty_input = document.querySelector('form input.qty');
                const qty = qty_input ? qty_input.value : 1;
                AsyncHandler.addToCart($productId, qty, variation_id).then((response) => {
                    if(response?.fragments?.['div.woocommerce-notices-wrapper'] == '<div class="woocommerce-notices-wrapper"></div>'){
                        DOMService.toggleMiniCart();
                    }
                });
            })
        }
    });
})(jQuery);