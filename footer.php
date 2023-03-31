<?php if(!is_home_template()): ?>
    </div>
</div>
<?php endif; ?>
    <div class="site-overlay"></div>
<?php if(!is_home_template()): ?>
    <footer id="footer" class="footer">
        <div class="container d-grid d-grid__column-3 align-items-center">
            <div class="footer--menu d-flex align-items-center align-items-center">
                <?php if ( has_nav_menu( 'footer' ) ) : ?>
                    <ul id="footer--menu__list" class="d-flex align-items-center">
                        <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'footer',
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
            <div id="footer-logo" class="d-flex flex-column justify-content-center align-items-center">
                <?php echo get_custom_logo(); ?>
                <?php
                $footer_bottom_label = get_field("footer_bottom_label", "option");
                if($footer_bottom_label):?>
                    <div class="footer--bottom-label d-flex justify-content-center">
                        <?php echo str_replace('{{year}}', date("Y"), $footer_bottom_label); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="social-menu d-flex justify-content-end align-items-center">
                <?php require get_template_directory() . '/templates/template-parts/social-media.php'; ?>
            </div>
        </div>
    </footer>
<?php
endif;
wp_footer();