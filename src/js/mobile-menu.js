import {DOMService} from "./dom-service";

(function ($){
    const mobileMenuButton = document.querySelector(".mobile-menu--button a");
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener("click", event => {
            event.preventDefault();
            DOMService.toggleMobileMenu();
        });
    }
})(jQuery);