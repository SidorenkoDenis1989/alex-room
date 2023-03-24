export class DOMHandler {
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
}