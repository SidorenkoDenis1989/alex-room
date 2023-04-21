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
    });
})(jQuery);