(function ($){
    document.addEventListener("DOMContentLoaded", function(event) {
        document.querySelectorAll(".home-col").forEach(elem => {
            elem.addEventListener("mouseenter", () => elem.classList.add("home-col__hover"));
        })
        document.querySelectorAll(".home-col").forEach(elem => {
            elem.addEventListener("mouseleave", () => elem.classList.remove("home-col__hover"));
        });

        document.querySelector(".home-content").addEventListener("mouseenter", function (){
            this.classList.add("home-content__active");
        });
        document.querySelector(".home-content").addEventListener("mouseleave", function (){
            this.classList.remove("home-content__active");
        });
    });
})(jQuery);