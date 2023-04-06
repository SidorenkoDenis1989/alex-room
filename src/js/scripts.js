import 'slick-carousel';
import {DOMService} from "./dom-service.js";
import {AsyncHandler} from "./async-functions";
(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".home-col").forEach(elem => {
            elem.addEventListener("mouseenter", () => elem.classList.add("home-col__hover"));
        })
        document.querySelectorAll(".home-col").forEach(elem => {
            elem.addEventListener("mouseleave", () => elem.classList.remove("home-col__hover"));
        });

        const homeContentElement = document.querySelector(".home-content");
        if (homeContentElement) {
            homeContentElement.addEventListener("mouseenter", function (){
                this.classList.add("home-content__active");
            });

            homeContentElement.addEventListener("mouseleave", function (){
                this.classList.remove("home-content__active");
            });
        }

        document.querySelector(".minicart--button").addEventListener("click", event => {
            event.preventDefault();
            DOMService.toggleMiniCart()
        });
        document.querySelector(".minicart--toggler").addEventListener("click", event => {
            event.preventDefault();
            DOMService.toggleMiniCart()
        });
        document.querySelector(".site-overlay").addEventListener("click", () => {
            DOMService.closeMiniCart();
        });

        const orderNoteTitle =  document.querySelector(".order-note__title");
        if (orderNoteTitle) {
            orderNoteTitle.addEventListener("click", event => {
                event.preventDefault();
                $(".order-note__text").slideToggle();
            });
        }

        document.querySelector('body').addEventListener("click", event => {
            const target = event.target;
            const closestElement = target.closest(".quantity--button");
            if(!closestElement){
                return;
            }
            const hasRequiredClass = closestElement.classList.contains('increase') || closestElement.classList.contains('decrease');
            if(!hasRequiredClass){
                return;
            }
            event.preventDefault();
            const qtyWrapper = closestElement.closest(".woocommerce-mini-cart-item__quantity");
            const currentQty = Number(qtyWrapper.querySelector("span").innerText);
            let newValue = 0;
            if (closestElement.classList.contains('increase')) {
                const maxQty = closestElement.getAttribute("max");
                newValue = currentQty + 1;
                if (maxQty > 0 && newValue > maxQty) {
                    return;
                }
            }
            if (closestElement.classList.contains('decrease')) {
                newValue = currentQty - 1;
            }
            if (newValue < 0) {
                return;
            }
            const cartItemKey = closestElement.dataset.cart_item_key;
            AsyncHandler.changeCartItemQty(cartItemKey, newValue);
        });

        document.querySelector('body').addEventListener("click", event => {
            const target = event.target;
            const closestElement = target.closest(".woocommerce-mini-cart-item__remove");
            if(!closestElement){
                return;
            }
            event.preventDefault();
            const cartItemKey = closestElement.dataset.cart_item_key;
            AsyncHandler.changeCartItemQty(cartItemKey, 0);
        });

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

        $(".single-product--gallery__large").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
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