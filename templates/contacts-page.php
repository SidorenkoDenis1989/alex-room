<?php
/* Template Name: Contacts page */
get_header(); ?>
<div class="contacts full-width d-flex flex-wrap justify-content-between align-items-stretch">
    <?php woocommerce_breadcrumb(); ?>
    <div class="contacts--column">
    <?php
        $page_id = get_the_ID();
        $image_id = get_field("left_part_image", $page_id);
        echo get_img_html_code($image_id , 'home_half_screen_image');
    ?>
    </div>
    <div class="contacts--column">
        <h1><?php echo get_field("form_title", $page_id); ?></h1>
        <?php echo get_field("text_below_forms_title", $page_id); ?>
        <?php
            $form_shortcode = get_field("forms_shortcode", $page_id);
            echo do_shortcode( $form_shortcode);
        ?>
    </div>
</div>
<?php get_footer();