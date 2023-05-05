<?php
    $mini_cart_label = get_field("minicart_top_label", "option");
?>
<div class="minicart">
    <div class="minicart--header">
        <span class="title light-beige">
            Shopping cart (<?php require get_template_directory() . '/templates/template-parts/products-counter.php'; ?>)
        </span>
        <a href="#" class="sidebar--toggler">
            <?php require get_template_directory() . '/templates/template-parts/icons/close-icon.php'; ?>
        </a>
    </div>
    <?php if($mini_cart_label): ?>
    <div class="minicart--label">
        <svg class="icon icon--small icon--type-leaf" stroke-width="1" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path fill="currentColor" d="M14.63.98a1 1 0 00-.78-.3h-.03l-.07.01-.25.03a41.89 41.89 0 00-3.87.52c-1.1.2-2.31.48-3.38.83a7.15 7.15 0 00-2.74 1.48 6.04 6.04 0 00-.36 8.15L1.53 13.3a.5.5 0 00.71.7l1.61-1.6a6.04 6.04 0 008.2-.31 7.15 7.15 0 001.48-2.74c.36-1.07.63-2.27.83-3.39a46.92 46.92 0 00.53-3.86l.02-.26.01-.07v-.02a1 1 0 00-.29-.78zm-1.72.8l.17-.02-4.89 4.9v-4.1c1.76-.41 3.61-.66 4.72-.78zM8.45 7.81h4.5c-.21.8-.45 1.56-.74 2.2H6.24l2.21-2.2zM7.7 2.68v4.46L5.5 9.35V3.43c.64-.3 1.4-.54 2.2-.75zM4.22 4.26c.2-.2.47-.4.78-.57v6.15L3.86 11a5.04 5.04 0 01.36-6.73zm.34 7.44l1.19-1.18h6.22c-.2.35-.4.65-.62.87a5.04 5.04 0 01-6.8.31zm8.5-4.4h-4.1l4.9-4.9-.03.3a41.1 41.1 0 01-.76 4.6z"></path>
        </svg>
        <?php echo $mini_cart_label; ?>
    </div>
    <?php
        endif;
        woocommerce_mini_cart();
        require get_template_directory() . '/templates/template-parts/loader.php';
    ?>
</div>