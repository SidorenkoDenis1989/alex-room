<div class="mobile-menu--wrapper">
    <div class="mobile-menu--header d-flex justify-content-end align-items-center">
        <a href="#" class="sidebar--toggler">
            <?php require get_template_directory() . '/templates/template-parts/icons/close-icon.php'; ?>
        </a>
    </div>
    <div class="mobile-menu">
        <?php if ( has_nav_menu( 'mobile' ) ) : ?>
            <ul class="mobile-menu--list">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'mobile',
                        'items_wrap'     => '%3$s',
                        'container'      => false,
                        'depth'          => 1,
                        'link_before'    => '',
                        'link_after'     => '',
                        'fallback_cb'    => false,
                    )
                );
                ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="mobile-menu--footer social-menu d-flex justify-content-start align-items-center">
        <?php require get_template_directory() . '/templates/template-parts/social-media.php'; ?>
    </div>
</div>