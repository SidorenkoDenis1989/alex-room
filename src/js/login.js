(function ($){
    document.addEventListener("DOMContentLoaded", function() {
        const createLoginButton = document.querySelector(".create_account");
        if (createLoginButton) {
            createLoginButton.addEventListener("click", event => {
                event.preventDefault();
                document.querySelector('#customer_login .col-1').style.display = "none";
                document.querySelector('#customer_login .col-2').style.display = "block";
            });
        }

        const loginToAccountButton = document.querySelector(".login_to_account");
        if (loginToAccountButton) {
            loginToAccountButton.addEventListener("click", event => {
                event.preventDefault();
                document.querySelector('#customer_login .col-1').style.display = "block";
                document.querySelector('#customer_login .col-2').style.display = "none";
            });
        }
    });
})(jQuery);