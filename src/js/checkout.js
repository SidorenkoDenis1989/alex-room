import {AsyncHandler} from "./async-functions";
import {CHECKOUT_ORDER_REVIEW_TITLE, OPENED_CHECKOUT_ORDER_REVIEW_TITLE} from "./text-constant";
import {DOMService} from "./dom-service";

(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('body').addEventListener("click", e => {
            const target = e.target;
            const closestElement = target.closest(".checkout--order-total ul#shipping_method li input[type=radio]");
            if(!closestElement){
                return;
            }
            const event = new Event("update_checkout");
            document.body.dispatchEvent(event);
        });

        document.querySelector('body').addEventListener("click", e => {
            const target = e.target;
            const closestElement = target.closest("form.checkout_coupon button");
            if(!closestElement){
                return;
            }
            e.preventDefault();
            const couponCode = document.querySelector('form.checkout_coupon input').value;
            if (!couponCode) {
                return;
            }
            AsyncHandler.setCoupon(couponCode);
        });

        document.querySelector('body').addEventListener("click", e => {
            const target = e.target;
            const closestElement = target.closest(".alexroom--remove-coupon");
            if(!closestElement){
                return;
            }
            e.preventDefault();
            AsyncHandler.removeCoupon();
        });

        document.querySelector('body').addEventListener("click", e => {
            const target = e.target;
            const checkoutNavButton = target.closest(".woocommerce-checkout--button");
            if(!checkoutNavButton){
                return;
            }
            e.preventDefault();
            const currentFieldsIndex = Number(document.querySelector('.checkout--customer-info').getAttribute("data-current-fields"));

            DOMService.closeOrderReview();

            let newCurrentFieldsIndex;
            if (checkoutNavButton.classList.contains('woocommerce-checkout--button__next')) {
                newCurrentFieldsIndex = currentFieldsIndex + 1;
            }
            if (checkoutNavButton.classList.contains('woocommerce-checkout--button__prev')) {
                newCurrentFieldsIndex = currentFieldsIndex - 1;
            }
            document.querySelector('.checkout--customer-info').setAttribute("data-current-fields", newCurrentFieldsIndex);
            document.querySelectorAll(`.woocommerce-checkout--button`).forEach(button => button.style.display = 'none');
            document.querySelectorAll(`.woocommerce-checkout > div[data-field]`).forEach(fieldsContainer => {
                fieldsContainer.style.overflow = 'hidden';
                fieldsContainer.style.height = '0';
            });
            document.querySelectorAll(`.woocommerce-checkout > div[data-field="${newCurrentFieldsIndex}"]`).forEach(fieldsContainer => {
                fieldsContainer.style.overflow = 'unset';
                fieldsContainer.style.height = 'auto';
            });

            if (document.querySelector(`.woocommerce-checkout--button[data-button="${newCurrentFieldsIndex + 1}"]`)) {
                document.querySelector(`.woocommerce-checkout--button[data-button="${newCurrentFieldsIndex + 1}"]`).style.display = 'block';
            }

            if (newCurrentFieldsIndex > 1) {
                document.querySelector('.woocommerce-checkout--button__prev').style.display = 'block';
            } else {
                document.querySelector('.woocommerce-checkout--button__prev').style.display = 'none';
            }
        });

        document.querySelector('body').addEventListener("click", e => {
            const target = e.target;
            const reviewOrderTitle = target.closest(".woocommerce-checkout-review-order-title");
            if(!reviewOrderTitle){
                return;
            }
            reviewOrderTitle.classList.toggle("woocommerce-checkout-review-order-title__opened");
            reviewOrderTitle.querySelector('span').textContent = reviewOrderTitle.classList.contains("woocommerce-checkout-review-order-title__opened") ? OPENED_CHECKOUT_ORDER_REVIEW_TITLE : CHECKOUT_ORDER_REVIEW_TITLE;
            jQuery(".checkout--products-list").slideToggle();
        });
    });
})(jQuery);