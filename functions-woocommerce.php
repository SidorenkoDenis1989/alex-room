<?php
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

add_action( 'template_redirect', 'cart2checkout_redirect' );
function cart2checkout_redirect() {
    if ( is_cart() ) {
        wp_redirect( wc_get_checkout_url()  );
        die;
    }
}
