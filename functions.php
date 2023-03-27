<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

require_once get_template_directory() . '/templates/template-functions.php';
require_once get_template_directory() . '/functions-woocommerce.php';

register_nav_menus(
    array(
        'primary' 				=> esc_attr( 'Main menu' ),
        'footer'  				=> esc_attr( 'Footer menu' ),
    )
);

function is_home_template() {
    return is_page_template('templates/home-page.php');
}

if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'home_category_thumb', 206, 272, true );
    add_image_size( 'product_catalog_image', 328, 410, true );
    add_image_size( 'product_page_image', 630, 840, true );
    add_image_size( 'product_cart_image', 78, 100, true );
    add_image_size( 'home_half_screen_image', 960, 1080, true );
}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> esc_attr( 'Theme options' ),
        'menu_title'	=> esc_attr( 'Theme options' ),
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));
}

add_theme_support( 'custom-logo' );

function alex_room_scripts() {
    wp_register_style( 'alex_room_styles', get_template_directory_uri() . '/dist/app.css', false, '1.0' );
    wp_enqueue_style( 'alex_room_styles' );

    wp_register_script( 'alex_room_scripts', get_template_directory_uri() . '/dist/app.js', ["jquery"], '1.0', true );
    wp_localize_script('alex_room_scripts', 'ajaxUrl', array('url' => admin_url('admin-ajax.php')));
    wp_enqueue_script( 'alex_room_scripts' );
}
add_action( 'wp_enqueue_scripts', 'alex_room_scripts' );

function get_image_html_code_by_id($image_id, $classes = array() ) {
    $img_url 		= wp_get_attachment_url($image_id);
    $img_parts 		= pathinfo($img_url);
    $img_extention	= $img_parts['extension'];

    if($img_extention == 'svg'):
        return file_get_contents($img_url);
    else:
        return get_img_html_code($image_id, 'full', $classes);
    endif;
}

function get_img_html_code($image_id, $thumbnail_slug = 'full', $classes = array() ) {
    if(!$image_id){
        return null;
    }
    $img_url 		= wp_get_attachment_image_src($image_id,  $thumbnail_slug, true)[0];
    $img_sizes 		= getimagesize($img_url);
    $img_width 		= $img_sizes[0];
    $img_height 	= $img_sizes[1];
    $img_alt 		= get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
    if(!$img_alt){
        $img_alt 	= 'image';
    }
    return '<img class="' . implode(' ', $classes) . '" src="' . $img_url . '" alt="' . $img_alt . '" width="' . $img_width . '" height="' . $img_height . '">';
}