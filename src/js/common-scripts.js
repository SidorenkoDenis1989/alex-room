import {DOMService} from "./dom-service";

(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarToggler = document.querySelectorAll(".sidebar--toggler");
        if (sidebarToggler) {
            sidebarToggler.forEach(button => button.addEventListener("click", event => {
                event.preventDefault();
                DOMService.closeSidebars();
            }));
        }

        document.querySelector(".site-overlay").addEventListener("click", () => {
            DOMService.closeSidebars();
        });
    });
})(jQuery);