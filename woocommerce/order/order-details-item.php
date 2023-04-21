<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<li class="woocommerce-order-details__item">
    <div class="woocommerce-order-details__item-title">
        <div class="woocommerce-order-details__product-thumb">
            <?php
                $product_attrs = $product->get_attributes();
                $qty        = $item->get_quantity();
                $refunded_qty = $order->get_qty_refunded_for_item( $item_id );

                if ( $refunded_qty ) {
                    $qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
                } else {
                    $qty_display = esc_html( $qty );
                }
                $thumbnail  = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image("checkout_image_small"), $item, $item_id );
                echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . $qty_display . '</strong>', $item );
                echo $thumbnail;
            ?>
        </div>
        <div class="woocommerce-order-details__product-content">
        <?php
            $is_visible        = $product && $product->is_visible();
            $product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

            $item_data = $item->get_data();
            $product_id = $item_data["product_id"];
            $product_name   = get_the_title($product_id);

            echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $product_name ) : $product_name, $item, $is_visible ) );
            do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
            if(count($product_attrs)):
        ?>
                <div class="woocommerce-mini-cart-item__attrs">
                    <ul>
                        <?php foreach ($product_attrs as $attr_key => $attr_value): ?>
                            <li><?php echo wc_attribute_label($attr_key); ?>: <?php echo $attr_value; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
        <?php
            endif;
            do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
        ?>
        </div>
    </div>

    <div class="woocommerce-order-details__item-content">
		<?php echo $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>

</li>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<li class="woocommerce-order-details__item">
    <div class="woocommerce-order-details__item-title">
        <?php echo __("Order note", "woocommerce"); ?>
    </div>
    <div class="woocommerce-order-details__item-content"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></div>
</li>

<?php endif; ?>
