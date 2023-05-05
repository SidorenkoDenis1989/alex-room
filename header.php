<?php
    wp_head();
    $is_home_template = is_home_template();
    $is_checkout = is_checkout() && empty( is_wc_endpoint_url('order-received') );
    $header_class = $is_home_template ? "header__home" : "";
    $site_content_classes = ["site-content"];
    $container_classes = ["container"];
    if (is_checkout() && !empty( is_wc_endpoint_url('order-received'))) {
        array_push($container_classes, "container--checkout__thank-you");
    }
    if (is_checkout() && empty( is_wc_endpoint_url('order-received'))) {
        array_push($container_classes, "container--checkout");
    }
    if (is_page_template('templates/about-me-page.php')) {
        array_push($site_content_classes, "site-content--about-me");
    }
    if (!$is_checkout):
?>
<header id="header" <?php echo $header_class ? 'class="' . $header_class  .  '"' : ""; ?>>
    <div class="container d-flex align-items-center">
        <div class="mobile-menu--button">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu" aria-hidden="true">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>
        </div>
        <div id="site-logo" class="d-flex align-items-center"><?php echo get_custom_logo(); ?></div>
        <div id="main-menu" class="d-flex justify-content-center align-items-center">
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
        <div id="header__right-side" class="d-flex justify-content-end align-items-center">
            <?php if(!is_user_logged_in()): ?>
                <a href="/login" class="login-button">Login</a>
            <?php else: ?>
                <a href="/my-account" class="login-button">
                    My account
                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <path d="M12,2 C14.7614237,2 17,4.23857625 17,7 C17,9.76142375 14.7614237,12 12,12 C9.23857625,12 7,9.76142375 7,7 C7,4.23857625 9.23857625,2 12,2 Z M12,3.42857143 C10.0275545,3.42857143 8.42857143,5.02755446 8.42857143,7 C8.42857143,8.97244554 10.0275545,10.5714286 12,10.5714286 C13.2759485,10.5714286 14.4549736,9.89071815 15.0929479,8.7857143 C15.7309222,7.68071045 15.7309222,6.31928955 15.0929479,5.2142857 C14.4549736,4.10928185 13.2759485,3.42857143 12,3.42857143 Z" fill="currentColor"></path>
                            <path d="M3,18.25 C3,15.763979 7.54216175,14.2499656 12.0281078,14.2499656 C16.5140539,14.2499656 21,15.7636604 21,18.25 C21,19.9075597 21,20.907554 21,21.2499827 L3,21.2499827 C3,20.9073416 3,19.9073474 3,18.25 Z" stroke="currentColor" stroke-width="1.5"></path>
                            <circle stroke="currentColor" stroke-width="1.5" cx="12" cy="7" r="4.25"></circle>
                        </g>
                    </svg>
                </a>
            <?php endif; ?>
            <a href="#" class="minicart--button">
                <span class="minicart--icon">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" aria-hidden="true">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path d="M15.3214286,9.5 C15.3214286,7.93720195 15.3214286,6.5443448 15.3214286,5.32142857 C15.3214286,3.48705422 13.8343743,2 12,2 C10.1656257,2 8.67857143,3.48705422 8.67857143,5.32142857 C8.67857143,6.5443448 8.67857143,7.93720195 8.67857143,9.5" id="Oval-Copy-11" stroke="currentColor" stroke-width="1.5"></path>
                        <polygon stroke="currentColor" stroke-width="1.5" points="5.35714286 7.70535714 18.6428571 7.70535714 19.75 21.2678571 4.25 21.2678571"></polygon>
                      </g>
                    </svg>
                    <span class="minicart--count">
                        <?php require_once get_template_directory() . '/templates/template-parts/products-counter.php'; ?>
                    </span>
                </span>
            </a>
        </div>
    </div>
</header>
<?php
    require get_template_directory() . '/templates/template-parts/minicart-wrapper.php';
    endif;
    require get_template_directory() . '/templates/template-parts/mobile-menu.php';
?>
<?php if(!$is_home_template): ?>
<div class="<?php echo join(" ", $site_content_classes); ?>">
    <div class="<?php echo join(" ", $container_classes);?>">
<?php endif; ?>