<?php
    wp_head();
    $is_home_template = is_home_template();
    $header_class = $is_home_template ? "header__home" : "";
?>
<header id="header" <?php echo $header_class ? 'class="' . $header_class  .  '"' : ""; ?>>
    <div class="container d-grid d-grid__column-3 align-items-center">
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
                    <span class="minicart--count">
                        <?php require_once get_template_directory() . '/templates/template-parts/products-counter.php'; ?>
                    </span>
                </span>
            </a>
        </div>
    </div>
</header>
<?php require get_template_directory() . '/templates/template-parts/minicart-wrapper.php';?>
<?php if(!$is_home_template): ?>
<div class="breadcrumbs">
    <div class="container">
        <?php woocommerce_breadcrumb(); ?>
    </div>
</div>
<div class="site-content">
    <div class="container">
<?php endif; ?>