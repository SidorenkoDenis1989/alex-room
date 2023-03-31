<?php
    function get_home_page_column($image_id, $product_cat_id, $class) {
        $wrapper_class = $class ? "home-col home-col__" . $class : "home-col";
        $product_cat = $product_cat_id ? get_term_by("id", $product_cat_id, "product_cat") : null;
        $child_sub_cats = $product_cat_id ? get_terms(
            "product_cat",
            array(
                'parent' => $product_cat_id,
                'orderby' => 'name',
                'hide_empty' => true
            )
        ) : [];
?>
        <div class="<?php echo $wrapper_class; ?>>">
            <?php echo get_img_html_code($image_id , 'home_half_screen_image', ["home-col__bg"]); ?>
            <div class="blur-overlay"></div>
        <?php if($product_cat): ?>
            <div class="home-col--title"><?php echo $product_cat->name; ?></div>
            <?php endif; ?>
                <div class="home-categories">
            <?php if(count($child_sub_cats)): ?>
            <ul class="home-categories--list">
            <?php
                foreach ($child_sub_cats as $cat):
                    $thumb_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
            ?>
                <li class="home-categories--item">
                    <!--<svg viewBox="0 0 294 130" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 65C3 30.7583 30.7583 3 65 3H229C263.242 3 291 30.7583 291 65V65C291 99.2417 263.242 127 229 127H65C30.7584 127 3 99.2417 3 65V65Z"></path>
                    </svg>-->
                    <?php if($thumb_id): ?>
                    <div class="sm-image">
                        <div class="sticker">
                            <svg width="79" height="139" viewBox="0 0 79 139" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.273438 0.333008L10.8802 8.33301L19.9401 0.333008L29.8839 8.33301L39.6068 0.333008L49.3296 8.33301L59.2734 0.333008L68.7753 8.33301L78.9401 0.333008V139L68.7753 132.333L59.2734 139L50.2135 132.333L39.6068 139L29.8839 132.333L19.9401 139L10.8802 132.333L0.273437 139L0.273438 0.333008Z" fill="#F5D9B8"></path>
                            </svg>
                        </div>
                        <div class="image-mask">
                            <?php echo get_img_html_code($thumb_id , 'home_category_thumb', ["home-categories--item__thumb"]); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <a class="home-categories--item__link" href="<?php echo get_term_link($cat->term_id, "product_cat"); ?>">
                        <?php echo $cat->name; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif;?>
            </div>
        </div>
<?php
}