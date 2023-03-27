<?php
    $cart_count = WC()->cart->get_cart_contents_count();
?>
    <span class="products--counter"><?php echo $cart_count; ?></span>
<?php