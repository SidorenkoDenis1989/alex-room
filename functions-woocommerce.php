<?php
function alexroom_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'alexroom_add_woocommerce_support' );

remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

add_action( 'template_redirect', 'cart2checkout_redirect' );
function cart2checkout_redirect() {
    if ( is_cart() ) {
        $cart_qty = WC()->cart->get_cart_contents_count();
        $redirect_url = $cart_qty ? wc_get_checkout_url() : get_home_url();
        wp_redirect( $redirect_url );
        die;
    }
    if ( is_account_page() && !is_user_logged_in() ) {
        global $wp;
        $request = explode( '/', $wp->request );
        if ( end($request) == 'my-account') {
            wp_redirect( "/login" );
            die;
        }
    }
    if (is_product()) {
        $product_id = get_the_ID();
        $product = wc_get_product($product_id);
        if ( $product->is_type( 'variable' ) ) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        }
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

add_action('wp_ajax_alex_room_add_to_cart', 'alex_room_add_to_cart_handler');
add_action('wp_ajax_nopriv_alex_room_add_to_cart', 'alex_room_add_to_cart_handler');
function alex_room_add_to_cart_handler() {
    if(!isset($_POST['product_id']) || !isset($_POST['qty']) || !isset($_POST['variation_id'])){
        wp_send_json(array(
                'success' => false,
            )
        );
    }

    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];
    $qty = $_POST['qty'];
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $qty);
    $product_status = get_post_status($product_id);
    if ($passed_validation && 'publish' === $product_status) {
        WC()->cart->add_to_cart($product_id, $qty, $variation_id);
    }

    wp_send_json(array(
            'fragments' => WC_AJAX:: get_refreshed_fragments(),
        )
    );
}

add_filter('woocommerce_add_to_cart_fragments', 'minicart_fragments');
function minicart_fragments( $fragments ) {
    $cart_count = WC()->cart->get_cart_contents_count();
    ob_start();
    require get_template_directory() . '/templates/template-parts/minicart-product-list.php';
    $fragments['ul.woocommerce-mini-cart'] = ob_get_clean();
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
    ob_end_clean();


    ob_start();
    echo '<div class="woocommerce-notices-wrapper">';
    wc_print_notices();
    echo '</div>';
    $fragments['div.woocommerce-notices-wrapper'] = ob_get_clean();
    ob_end_clean();

    ob_start();
    include get_template_directory() . '/woocommerce/checkout/review-order.php';
    $fragments['div.woocommerce-checkout-review-order-table'] = ob_get_clean();
    ob_end_clean();

    return $fragments;
}

add_action('init', function(){
    remove_post_type_support( 'product', 'comments' );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
    add_filter( 'woocommerce_product_description_heading', '__return_false', 99 );
    add_filter( 'woocommerce_product_additional_information_heading', '__return_false', 99 );
    add_filter('woocommerce_reset_variations_link', '__return_empty_string');

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    add_action( 'woocommerce_before_shop_loop_item_title', 'alexroom_flash_labels', 10);

    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
    add_action( 'woocommerce_after_shop_loop', 'alexroom_pagination', 10);

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    add_action( 'woocommerce_before_single_product_summary', 'alexroom_product_thumbnails', 20 );

    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
    add_action( 'woocommerce_after_variations_table', 'woocommerce_single_variation_add_to_cart_button', 20 );

    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 40 );

    add_filter( 'woocommerce_product_tabs', 'alexroom_remove_tabs', 98 );

    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 10 );

    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    add_action( 'woocommerce_review_order_after_cart_contents', 'woocommerce_checkout_coupon_form', 10 );
    add_action( 'woocommerce_review_order_before_cart_contents', 'woocommerce_checkout_order_review_mobile_title', 10 );
});

function woocommerce_template_loop_product_thumbnail() {
    global $product;
    $product_img = $product->get_image("product_catalog_image");
    $attachment_ids = $product->get_gallery_image_ids();
    $thumbnail_classes = ["product--thumbnail"];
    if (!count($attachment_ids) ){
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
    if(!is_archive('product') || is_admin()){
        return $price;
    }
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

add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'filter_dropdown_option_html', 12, 2 );
function filter_dropdown_option_html( $html, $args ) {
    $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );
    $show_option_none_html = '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    $html = str_replace($show_option_none_html, '', $html);
    return $html;
}

function alexroom_product_thumbnails(){
    global $product;
    $product_img = $product->get_image("product_page_image");
    $product_img_small = $product->get_image("product_page_image_small");
    $attachment_ids = $product->get_gallery_image_ids();
    $thumbnail_classes = ["product--thumbnail"];
    if (!count($attachment_ids) ){
        array_push($thumbnail_classes, "product--thumbnail__singular");
    }
    ?>
    <div class="single-product--gallery__wrapper">
        <div class="single-product--gallery__slider">
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
            <ul class="single-product--gallery single-product--gallery__large">
                <li class="single-product--gallery__item">
                    <?php echo $product_img; ?>
                </li>
                <?php
                    if(count($attachment_ids)):
                        foreach ($attachment_ids as $attachment_id):
                ?>
                            <li class="single-product--gallery__item">
                                <?php echo wp_get_attachment_image($attachment_id, 'product_page_image'); ?>
                            </li>
                <?php
                        endforeach;
                    endif;
                ?>
            </ul>
        </div>
        <ul class="single-product--gallery single-product--gallery__small">
            <li class="single-product--gallery__item">
                <?php echo $product_img_small; ?>
            </li>
            <?php
            if(count($attachment_ids)):
                foreach ($attachment_ids as $attachment_id):
                    ?>
                    <li class="single-product--gallery__item">
                        <?php echo wp_get_attachment_image($attachment_id, 'product_page_image_small'); ?>
                    </li>
                <?php
                endforeach;
            endif;
            ?>
        </ul>
    </div>
    <?php
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'alexroom_quantity_minus_sign' );
function alexroom_quantity_minus_sign() {
    echo '<div class="single-product--quantity__wrapper">';
    echo '<button type="button" class="single-product--quantity__button minus" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><title>Minus</title><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>';
}

add_action( 'woocommerce_after_add_to_cart_quantity', 'alexroom_quantity_plus_sign' );
function alexroom_quantity_plus_sign() {
    echo '<button type="button" class="single-product--quantity__button plus" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><title>Plus</title><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>';
    echo '</div>';
}


function alexroom_remove_tabs($tabs) {
    unset( $tabs['additional_information'] );
    unset( $tabs['reviews'] );
    return $tabs;
}

add_action('wp_ajax_alex_room_set_coupon', 'alex_room_set_coupon_handler');
add_action('wp_ajax_nopriv_alex_room_set_coupon', 'alex_room_set_coupon_handler');
function alex_room_set_coupon_handler() {
    if(isset($_POST['coupon_code'])) {
        $coupon_code = $_POST['coupon_code'];
        WC()->cart->apply_coupon( $coupon_code );

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

add_action('wp_ajax_alex_room_remove_coupon', 'alex_room_remove_coupon_handler');
add_action('wp_ajax_nopriv_alex_room_remove_coupon', 'alex_room_remove_coupon_handler');
function alex_room_remove_coupon_handler() {
    WC()->cart->remove_coupons();
    WC()->cart->calculate_totals();

    wp_send_json(array(
            'fragments' => WC_AJAX:: get_refreshed_fragments(),
        )
    );
}

add_filter( 'woocommerce_cart_totals_coupon_html', 'alexroom_woocommerce_coupon_html_filter', 10, 3 );
function alexroom_woocommerce_coupon_html_filter( $coupon_html, $coupon, $discount_amount_html ){
    $coupon_html = $discount_amount_html . ' <a href="#" class="alexroom--remove-coupon">' . __( '[Remove]', 'woocommerce' ) . '</a>';
    return $coupon_html;
}


add_filter( 'woocommerce_checkout_fields' , 'remove_company_name' );
function remove_company_name( $fields ) {
    unset($fields['billing']['billing_company']);
    return $fields;
}

    

add_filter('woocommerce_get_breadcrumb', function ($crumbs) {
    if (is_singular("product") || is_product_category()) {
        array_splice($crumbs,1, 1);
    }
    return $crumbs;
});

add_filter('woocommerce_account_menu_items', 'remove_my_account_tabs', 999);
function remove_my_account_tabs($items) {
    unset($items['dashboard']);
    unset($items['downloads']);
    unset($items['subscriptions']);
    return $items;
}
function woocommerce_checkout_order_review_mobile_title() {
    echo '<h3 class="woocommerce-checkout-review-order-title">';
    echo '<span>' . __('Show order summary', 'woocommerce') . '</span>';
    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" role="img" class="a8x1wuo _1fragem14 _1fragem30 _1fragem9e _1fragem9d" focusable="false" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m11.9 5.6-4.653 4.653a.35.35 0 0 1-.495 0L2.1 5.6"></path></svg>';
    echo '</h3>';
}