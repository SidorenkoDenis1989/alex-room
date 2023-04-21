import {CHECKOUT_ORDER_REVIEW_TITLE, OPENED_CHECKOUT_ORDER_REVIEW_TITLE} from "./text-constant";

export class DOMService {
    static closeMiniCart() {
        document.querySelector(".minicart").classList.remove("minicart__active");
        document.querySelector(".site-overlay").classList.remove("site-overlay__active");
    }
    static toggleMiniCart() {
        document.querySelector(".minicart").classList.toggle("minicart__active");
        this.toggleOverlay();
    }
    static toggleOverlay() {
        document.querySelector(".site-overlay").classList.toggle("site-overlay__active");
    }
    static updateFragments(fragments) {
        if (!fragments) {
           return;
        }
        Object.entries(fragments).map(([key, value]) => {
            document.querySelectorAll(key).forEach(element => {
                const node = document.createRange().createContextualFragment(value);
                if (element) {
                    element.parentNode.replaceChild(node, element);
                }
            });
        });
    }

    static scrollPageTop() {
        document.querySelector("body").scrollTop = 0;
    }

    static closeOrderReview() {
        this.scrollPageTop();
        const reviewOrderTitle = document.querySelector(".woocommerce-checkout-review-order-title");
        reviewOrderTitle.classList.remove("woocommerce-checkout-review-order-title__opened");
        reviewOrderTitle.querySelector('span').textContent = CHECKOUT_ORDER_REVIEW_TITLE;
        if (document.body.clientWidth < 921) {
            document.querySelector(".checkout--products-list").style.display = "none";
        }
    }
}