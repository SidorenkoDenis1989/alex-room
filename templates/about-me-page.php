<?php
/* Template Name: About me page */
get_header(); ?>
    <div class="about-me full-width d-flex flex-wrap justify-content-between align-items-stretch">
        <div class="full-width--banner">
        <?php
            $big_image_id = get_field("big_image");
            echo get_img_html_code($big_image_id);
        ?>
        </div>
        <?php woocommerce_breadcrumb(); ?>
        <div class="about-me--content">
            <h1><?php echo get_field("text_title"); ?></h1>
            <?php echo get_field("text"); ?>
        </div>
        <div class="about-me--photo">
            <?php
            $small_image_id = get_field("small_image");
            echo get_img_html_code($small_image_id,"home_half_screen_image");
            ?>
        </div>
        <div class="full-width--banner video-wrapper">
        <?php
            $iframe = get_field('video');

            preg_match('/src="(.+?)"/', $iframe, $matches);
            $src = $matches[1];

            preg_match('/\/embed\/(.+?)\?/', $src, $video_id_matches);
            $video_id = $video_id_matches[1];

            $params = array(
                'mute'      => 1,
                'controls'  => 0,
                'hd'        => 1,
                'autoplay'  => 1,
                'loop'      => 1,
                'playlist'  => $video_id
            );
            $new_src = add_query_arg($params, $src);
            $iframe = str_replace($src, $new_src, $iframe);

            $attributes = 'frameborder="0"';
            $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

            echo $iframe;
        ?>
        </div>
    </div>
<?php get_footer();