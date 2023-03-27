<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
    <?php
    do_action( 'woocommerce_before_mini_cart_contents' );

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $parent_product = $_product->get_type() === "variation" ? $cart_item['data']->get_parent_data() : null;
        $product_attrs = $_product->get_attributes();

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            $product_name      = $parent_product ? $parent_product['title'] : $_product->get_name();
            $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image("product_cart_image"), $cart_item, $cart_item_key );
            $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
            ?>
            <li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                <?php
                echo apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                        '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                        esc_attr__( 'Remove this item', 'woocommerce' ),
                        esc_attr( $product_id ),
                        esc_attr( $cart_item_key ),
                        esc_attr( $_product->get_sku() )
                    ),
                    $cart_item_key
                );
                ?>
                <?php
                if ( empty( $product_permalink ) ) :
                    echo $thumbnail;
                else :
                    ?>
                    <a href="<?php echo esc_url( $product_permalink ); ?>">
                        <?php echo $thumbnail; ?>
                    </a>
                <?php endif; ?>
                <div class="woocommerce-mini-cart-item__info">
                    <?php
                    if ( empty( $product_permalink ) ) :
                        echo wp_kses_post( $product_name );
                    else :
                        ?>
                        <a href="<?php echo esc_url( $product_permalink ); ?>">
                            <?php echo wp_kses_post( $product_name ); ?>
                        </a>
                    <?php
                    endif;
                    if(count($product_attrs)):
                        ?>
                        <div class="woocommerce-mini-cart-item__attrs">
                            <ul>
                                <?php foreach ($product_attrs as $attr_key => $attr_value): ?>
                                    <li>Select <?php echo wc_attribute_label($attr_key); ?>: <?php echo $attr_value; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="woocommerce-mini-cart-item__quantity">
                        <a href="#" class="quantity--button decrease" data-cart_item_key="<?php echo $cart_item_key; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <title>Minus</title>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a>
                        <span><?php echo $cart_item['quantity']; ?></span>
                        <a href="#" class="quantity--button increase" data-cart_item_key="<?php echo $cart_item_key; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                <title>Plus</title>
                                <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                <div class="woocommerce-mini-cart-item__price"><?php echo $product_price; ?></div>
            </li>
            <?php
        }
    }

    do_action( 'woocommerce_mini_cart_contents' );
    ?>
</ul>