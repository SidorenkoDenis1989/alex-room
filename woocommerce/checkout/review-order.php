<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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

defined( 'ABSPATH' ) || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>
    <ul class="checkout--products-list">
<?php
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product       = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_attrs  = $_product->get_attributes();
?>
    <li class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
    <?php
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            $parent_product = $_product->get_type() === "variation" ? $cart_item['data']->get_parent_data() : null;
            $product_name   = $parent_product ? $parent_product['title'] : $_product->get_name();
    ?>
        <div class="checkout--products-item__thumb">
        <?php
            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image("checkout_image_small"), $cart_item, $cart_item_key );
            echo $thumbnail;
        ?>
            <div class="checkout--products-item__qty">
                <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); ?>
            </div>
        </div>
        <div class="product-name">
        <?php
            echo $product_name;
            if(count($product_attrs)):
        ?>
            <div class="checkout--products-item__attrs">
                <ul>
                <?php 
                    foreach ($product_attrs as $attr_key => $attr_value):
                        $term_names = [];
                        if (!is_string($attr_value)) {
                            $attr_options = $attr_value->get_data()['options'];
                            $terms = get_terms(
                                array(
                                    'taxonomy'    => $attr_key,
                                    'include'  => $attr_options,
                                )
                            );

                            foreach ($terms as $term) {
                                array_push($term_names, $term->name);   
                            } 
                        }

                        $value = is_string($attr_value) ? $attr_value : join($term_names, ', '); 
                ?>
                        <li><?php echo wc_attribute_label($attr_key); ?>: <?php echo $value; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        </div>
        <div class="product-total">
            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
        </div>
    <?php } ?>
    </li>
<?php } ?>
    </ul>
<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
    <ul class="checkout--order-total">
		<li class="checkout--order-total__item">
			<div><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
			<div><?php wc_cart_totals_subtotal_html(); ?></div>
		</li>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <li class="checkout--order-total__item cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <div><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
            <div><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
        </li>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <li class="checkout--order-total__item fee">
            <div><?php echo esc_html( $fee->name ); ?></div>
            <div><?php wc_cart_totals_fee_html( $fee ); ?></div>
        </li>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                    <li class="checkout--order-total__item tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <div><?php echo esc_html( $tax->label ); ?></div>
                        <div><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                    </li>
				<?php endforeach; ?>
			<?php else : ?>
                <li class="checkout--order-total__item tax-total">
					<div><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
					<div><?php wc_cart_totals_taxes_total_html(); ?></div>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

        <li class="checkout--order-total__item order-total">
			<div><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
			<div><?php wc_cart_totals_order_total_html(); ?></div>
		</li>
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
    </ul>
</div>
