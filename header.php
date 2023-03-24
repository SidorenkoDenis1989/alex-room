<?php
    wp_head();
    $is_home_template = is_home_template();
    $header_class = $is_home_template ? "header__home" : "";
    $cart_count = WC()->cart->get_cart_contents_count();
?>
<header id="header" <?php echo $header_class ? 'class="' . $header_class  .  '"' : ""; ?>>
    <div class="container">
        <div id="site-logo"><?php echo get_custom_logo(); ?></div>
        <div id="main-menu">
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <ul id="main-menu__list">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'items_wrap'     => '%3$s',
                            'container'      => false,
                            'depth'          => 2,
                            'link_before'    => '',
                            'link_after'     => '',
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                </ul>
            <?php endif; ?>
        </div>
        <div id="header__right-side">
            <a href="#" class="login-button">Login</a>
            <a href="#" class="minicart--button">
                <span class="minicart--icon">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" aria-hidden="true">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M15.3214286,9.5 C15.3214286,7.93720195 15.3214286,6.5443448 15.3214286,5.32142857 C15.3214286,3.48705422 13.8343743,2 12,2 C10.1656257,2 8.67857143,3.48705422 8.67857143,5.32142857 C8.67857143,6.5443448 8.67857143,7.93720195 8.67857143,9.5" id="Oval-Copy-11" stroke="currentColor" stroke-width="1.5"></path>
                        <polygon stroke="currentColor" stroke-width="1.5" points="5.35714286 7.70535714 18.6428571 7.70535714 19.75 21.2678571 4.25 21.2678571"></polygon>
                      </g>
                    </svg>
                    <span class="minicart--count"><?php echo $cart_count; ?></span>
                </span>
            </a>
        </div>
    </div>
</header>
<div class="minicart">
    <div class="minicart--header">
        <span class="light-beige">Shopping cart (<?php echo $cart_count; ?>)</span>
        <a href="#" class="minicart--toggler">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon feather-x" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
        </a>
    </div>
    <?php woocommerce_mini_cart(); ?>
</div>
<?php if(!$is_home_template): ?>
<div class="site-content">
    <div class="container">
<?php endif; ?>