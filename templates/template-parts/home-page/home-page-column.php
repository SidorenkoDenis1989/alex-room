<div class="home-col home-col__left">
    <?php echo get_img_html_code($left_side_bg_id , 'home_half_screen_image', ["home-col__bg"]); ?>
    <div class="blur-overlay"></div>
    <?php if($left_side_product_cat): ?>
        <div class="home-col--title"><?php echo $left_side_product_cat->name; ?></div>
    <?php endif; ?>
    <div class="home-categories">
        <?php if(count($left_side_child_cat)): ?>
            <ul class="home-categories--list">
                <?php foreach ($left_side_child_cat as $cat): ?>
                    <li class="home-categories--item">
                        <!--<svg viewBox="0 0 294 130" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 65C3 30.7583 30.7583 3 65 3H229C263.242 3 291 30.7583 291 65V65C291 99.2417 263.242 127 229 127H65C30.7584 127 3 99.2417 3 65V65Z"></path>
                        </svg>-->
                        <a class="home-categories--item__link" href="<?php echo get_term_link($cat->term_id, "product_cat"); ?>">
                            <?php echo $cat->name; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;?>
    </div>
</div>