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
    <p class="title woocommerce-mini-cart__total total">
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

add_action('init', function(){
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    add_action( 'woocommerce_before_shop_loop_item_title', 'alexroom_flash_labels', 10);

    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
    add_action( 'woocommerce_after_shop_loop', 'alexroom_pagination', 10);

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
});

function woocommerce_template_loop_product_thumbnail() {
    global $product;
    $product_img = $product->get_image("product_catalog_image");
    $attachment_ids = $product->get_gallery_image_ids();
    $thumbnail_classes = ["product--thumbnail"];
    if (!   count($attachment_ids) ){
        array_push($thumbnail_classes, "product--thumbnail__singular");
    }
?>
    <ul class="product--thumbnail__wrapper">
        <li class="<?php echo implode(" ", $thumbnail_classes); ?>">
            <?php echo $product_img; ?>
        </li>
        <?php if(count($attachment_ids)): ?>
        <li class="product--gallery__wrapper">
            <?php if(count($attachment_ids) > 1): ?>
                <button class="gallery--button gallery--button__prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                        <title>Left</title>
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="gallery--button gallery--button__next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <title>Right</title>
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            <?php endif; ?>
            <ul class="product--gallery">
                <?php foreach ($attachment_ids as $attachment_id): ?>
                    <li class="product--gallery__item">
                        <?php echo wp_get_attachment_image($attachment_id, 'product_catalog_image'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
<?php
}

function alexroom_pagination() {
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));

        echo '<div class="pagination">';
        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
        ));
        echo '</div>';
    }
}

function alexroom_flash_labels() {
    global $product;
    echo '<div class="flash-labels">';
        if($product->is_on_sale()){
            echo '<div class="on-sale">Sale</div>';
        }
        if(!$product->is_in_stock()){
            echo '<div class="out-of-stock">Out of stock</div>';
        }
    echo '</div>';
}

function variable_price_format_filter( $price, $product ) {
    $prefix = 'From ';

    $min_price_regular = $product->get_variation_regular_price( 'min', true );
    $min_price_sale    = $product->get_variation_sale_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    $min_price = $product->get_variation_price( 'min', true );

    $price = ( $min_price_sale == $min_price_regular ) ?
        wc_price( $min_price_regular ) :
        '<del>' . wc_price( $min_price_regular ) . '</del>' . '<ins>' . wc_price( $min_price_sale ) . '</ins>';

    return ( $min_price == $max_price ) ?
        $price :
        $prefix . $price;
}

add_filter( 'woocommerce_variable_sale_price_html', 'variable_price_format_filter', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'variable_price_format_filter', 10, 2 );