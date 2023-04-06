<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
    <?php
    do_action( 'woocommerce_before_mini_cart_contents' );

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $parent_product = $_product->get_type() === "variation" ? $cart_item['data']->get_parent_data() : null;
        $product_attrs = $_product->get_attributes();
        $max_qty = $_product->get_max_purchase_quantity();

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
                        <a class="bold" href="<?php echo esc_url( $product_permalink ); ?>">
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
                        <a href="#" class="quantity--button increase" data-cart_item_key="<?php echo $cart_item_key; ?>" max="<? echo $max_qty; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                <title>Plus</title>
                                <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                <div class="woocommerce-mini-cart-item__price bold">
                    <?php echo $product_price; ?>
                    <a href="#" class="woocommerce-mini-cart-item__remove" data-cart_item_key="<?php echo $cart_item_key; ?>">
                        <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="800px" height="800px" viewBox="0 0 408.483 408.483"
                             xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M87.748,388.784c0.461,11.01,9.521,19.699,20.539,19.699h191.911c11.018,0,20.078-8.689,20.539-19.699l13.705-289.316
                                        H74.043L87.748,388.784z M247.655,171.329c0-4.61,3.738-8.349,8.35-8.349h13.355c4.609,0,8.35,3.738,8.35,8.349v165.293
                                        c0,4.611-3.738,8.349-8.35,8.349h-13.355c-4.61,0-8.35-3.736-8.35-8.349V171.329z M189.216,171.329
                                        c0-4.61,3.738-8.349,8.349-8.349h13.355c4.609,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.737,8.349-8.349,8.349h-13.355
                                        c-4.61,0-8.349-3.736-8.349-8.349V171.329L189.216,171.329z M130.775,171.329c0-4.61,3.738-8.349,8.349-8.349h13.356
                                        c4.61,0,8.349,3.738,8.349,8.349v165.293c0,4.611-3.738,8.349-8.349,8.349h-13.356c-4.61,0-8.349-3.736-8.349-8.349V171.329z"/>
                                    <path d="M343.567,21.043h-88.535V4.305c0-2.377-1.927-4.305-4.305-4.305h-92.971c-2.377,0-4.304,1.928-4.304,4.305v16.737H64.916
                                        c-7.125,0-12.9,5.776-12.9,12.901V74.47h304.451V33.944C356.467,26.819,350.692,21.043,343.567,21.043z"/>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
            </li>
            <?php
        }
    }

    do_action( 'woocommerce_mini_cart_contents' );
    ?>
</ul>