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

        document.querySelector(".order-note__title").addEventListener("click", event => {
            event.preventDefault();
            $(".order-note__text").slideToggle();
        });

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
                newValue = currentQty + 1;
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

        $(".product--gallery").each(function(index, gallery) {
            $(gallery).slick({
                prevArrow: $(gallery).parent().find($('.gallery--button__prev')),
                nextArrow: $(gallery).parent().find($('.gallery--button__next')),
            });
        });

        const archiveProductLink = $('.woocommerce-loop-product__link');
        archiveProductLink.on("click", e => {
            if (e.target.nodeName === 'svg') {
                e.preventDefault();
            }

        });
        archiveProductLink.on("swipe", e => {
                e.preventDefault();
        });
    });
})(jQuery);