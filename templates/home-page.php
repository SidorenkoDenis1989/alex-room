<?php
    /* Template Name: Home page */
    get_header();
    $left_side = get_field("left_side");
    $right_side = get_field("right_side");

    $left_side_bg_id = $left_side['background_image'];
    $right_side_bg_id = $right_side['background_image'];

    $left_side_product_cat_id = $left_side['parent_product_category'];
    $right_side_product_cat_id = $right_side['parent_product_category'];

?>
    <div class="home-content">
    <?php
        get_home_page_column($left_side_bg_id, $left_side_product_cat_id, "left");
        get_home_page_column($right_side_bg_id, $right_side_product_cat_id, "right");
    ?>
    </div>
<?php
    get_footer();