<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>
<div class="checkout--content">
    <div class="checkout--customer-info" data-current-fields="1">
        <form name="checkout" method="post" class="checkout woocommerce-checkout d-flex flex-wrap flex-column" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            <?php if ( $checkout->get_checkout_fields() ) : ?>
                <?php woocommerce_breadcrumb(); ?>
                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                <?php do_action( 'woocommerce_checkout_billing' ); ?>
                <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                <div class="woocommerce-checkout-payment--wrapper" data-field="3">
                    <?php
                        do_action( 'woocommerce_checkout_after_customer_details' );
                        if ( ! wp_doing_ajax() ) {
                            do_action( 'woocommerce_review_order_after_payment' );
                        }
                    ?>
                </div>
                <div class="woocommerce-checkout--buttons">
                    <a href="#" class="woocommerce-checkout--button woocommerce-checkout--button__prev" data-button="1">
                        <?php echo __( 'Return', 'woocommerce' ) ?>
                    </a>
                    <a href="#" class="woocommerce-checkout--button woocommerce-checkout--button__next" data-button="2">
                        <?php echo  __( 'Continue to shipping', 'woocommerce' ) ?>
                    </a>
                    <a href="#" class="woocommerce-checkout--button woocommerce-checkout--button__next" data-button="3">
                        <?php echo __( 'Continue to payment', 'woocommerce' ) ?>
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="checkout--order-review">
        <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
        <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </div>
        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    </div>
</div>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
