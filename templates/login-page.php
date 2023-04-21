<?php
/* Template Name: Login page */
get_header(); ?>
    <div class="login full-width d-flex flex-wrap justify-content-center align-items-center">
        <?php woocommerce_breadcrumb(); ?>
        <?php wc_get_template('myaccount/form-login.php');; ?>
    </div>
<?php get_footer();
