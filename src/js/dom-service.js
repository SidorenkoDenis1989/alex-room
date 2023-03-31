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
}