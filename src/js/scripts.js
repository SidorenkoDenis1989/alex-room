import {DOMHandler} from "./dom-handler";
(function ($){
    document.addEventListener("DOMContentLoaded", function(event) {
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
            DOMHandler.toggleMiniCart()
        });
        document.querySelector(".minicart--toggler").addEventListener("click", event => {
            event.preventDefault();
            DOMHandler.toggleMiniCart()
        });
        document.querySelector(".site-overlay").addEventListener("click", event => {
            DOMHandler.closeMiniCart();
        });
    });
})(jQuery);