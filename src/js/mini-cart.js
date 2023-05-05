import {DOMService} from "./dom-service";
import {AsyncHandler} from "./async-functions";

(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        const miniCartButton = document.querySelector(".minicart--button");
        if (miniCartButton) {
            miniCartButton.addEventListener("click", event => {
                event.preventDefault();
                DOMService.toggleMiniCart()
            });
        }

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
    });
})(jQuery);