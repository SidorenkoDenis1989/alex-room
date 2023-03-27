<?php
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

add_action( 'template_redirect', 'cart2checkout_redirect' );
function cart2checkout_redirect() {
    if ( is_cart() ) {
        wp_redirect( wc_get_checkout_url()  );
        die;
    }
}

add_action( 'woocommerce_widget_shopping_cart_before_buttons', 'add_order_note_text_area' );
function add_order_note_text_area(){
    require_once get_template_directory() . '/templates/template-parts/order-note.php';
}

add_action('wp_ajax_change_cart_item_qty', 'change_cart_item_qty_handler');
add_action('wp_ajax_nopriv_change_cart_item_qty', 'change_cart_item_qty_handler');
function change_cart_item_qty_handler() {
    if(isset($_POST['cart_item_key']) && isset($_POST['qty'])) {
        $cart_item_key = $_POST['cart_item_key'];
        $qty = $_POST['qty'];
        $product = WC()->cart->get_cart_item( $cart_item_key );

        // Get the quantity of the item in the cart
        $product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($qty, FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

        // Update cart validation
        $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $product, $product_quantity );

        // Update the quantity of the item in the cart
        if ( $passed_validation ) {
            WC()->cart->set_quantity( $cart_item_key, $product_quantity, true );
        }
        wp_send_json(array(
                'fragments' => WC_AJAX:: get_refreshed_fragments(),
            )
        );
    } else {
        wp_send_json(array(
                'success' => false,
            )
        );
    }
}

add_filter('woocommerce_add_to_cart_fragments', 'minicart_fragments');
function minicart_fragments( $fragments ) {
    $cart_count = WC()->cart->get_cart_contents_count();
    ob_start();
    require get_template_directory() . '/templates/template-parts/minicart-product-list.php';
    $fragments['ul.woocommerce-mini-cart    '] = ob_get_clean();
    ob_end_clean();

    ob_start();
?>
        <p class="woocommerce-mini-cart__total total">
		<?php do_action( 'woocommerce_widget_shopping_cart_total' ); ?>
	</p>
<?php
    $fragments['p.woocommerce-mini-cart__total'] = ob_get_clean();
    ob_end_clean();
    ob_start();
    require get_template_directory() . '/templates/template-parts/products-counter.php';
    $fragments['span.products--counter'] = ob_get_clean();
    return $fragments;
}
