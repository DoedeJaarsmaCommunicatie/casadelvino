<?php

/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-21
 * Time: 10:27
 */

require_once get_stylesheet_directory() . '/vendor/autoload.php';

add_theme_support('custom-logo');
add_theme_support('woocommerce');

if (is_admin()) {
    $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/DoedeJaarsmaCommunicatie/casadelvino/',
        __FILE__,
        'casadelvino'
    );
}

array_map(
    static function ($file) {
        $file = get_stylesheet_directory() . "/app/{$file}.php";
        load_template($file);
    },
    [
        'init',

        'functions/cart',
        'functions/header',
        'functions/terms',

        'loaders/enqueue',
        'loaders/locations',
        'loaders/customizer',
        'loaders/menus',

        'hooks/dehook',

        'widgets/registers',
    ]
);


add_action('rest_api_init', static function () {
    require_once __DIR__ . '/app/ajax/Api/AutoFillController.php';

    $afc = new AutoFillController();
    $afc->register_routes();
});

function example_price_free_delivery_note()
{
    ?>
    <style>
        .delivery-note .head-item-price,
        .delivery-note .head-price,
        .delivery-note .product-item-price,
        .delivery-note .product-price,
        .delivery-note .order-items tfoot {
            display: none;
        }
        .delivery-note .head-name,
        .delivery-note .product-name {
            width: 50%;
        }
        .delivery-note .head-quantity,
        .delivery-note .product-quantity {
            width: 50%;
        }
        .delivery-note .order-items tbody tr:last-child {
            border-bottom: 0.24em solid black;
        }
    </style>
    <?php
}
add_action('wcdn_head', 'example_price_free_delivery_note', 20);

add_filter('timber/context', function ($context) {
    $context['device'] = new Mobile_Detect();
    return $context;
});

function casa_dequeue_scripts()
{
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('toolset_bootstrap_styles');
    wp_deregister_script('wcpv-frontend-scripts');
    wp_dequeue_script('jquery');
    wp_dequeue_style('casa-lever');
    wp_dequeue_style('badubed-style');

    wp_dequeue_style('elementor-post-5272');
    wp_dequeue_style('elementor-post-5296');
    wp_dequeue_style('elementor-post-5446');
    wp_dequeue_style('elementor-frontend');
    wp_dequeue_style('elementor-global');

    if (!is_admin_bar_showing()) {
        wp_dequeue_style('dashicons');
    }

    if (is_product()) {
        wp_dequeue_style('elementor-pro');
        wp_dequeue_style('elementor-global');
        wp_deregister_script('jquery-swiper');
        wp_dequeue_script('jquery');
        wp_deregister_script('mailchimp-woocommerce');
    }

    if (is_product() || !(is_cart() || is_checkout() || is_woocommerce() || is_account_page())) {
        wp_dequeue_style('woocommerce_frontend_styles');
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_style('woocommerce_prettyPhoto_css');

        wp_dequeue_style('wooajaxcart');
        wp_dequeue_style('wcpf-plugin-style');
        wp_dequeue_style('wpgdprc.css');

        wp_deregister_script('selectWoo');
        wp_deregister_script('wc-add-payment-method');
        wp_deregister_script('wc_price_slider');
        wp_deregister_script('wc-single-product');
        wp_deregister_script('wc-credit-card-form');
        wp_deregister_script('wc-chosen');
        wp_deregister_script('wc-cart');
        wp_deregister_script('jqueryui');
        wp_deregister_script('fancybox');
        wp_deregister_script('prettyPhoto');
        wp_deregister_script('prettyPhoto-init');
        wp_deregister_script('woocommerce');
        wp_deregister_script('jquery-blockui');
        wp_deregister_script('jquery-placeholder');
        wp_deregister_script('jquery-payment');

        wp_deregister_script('wcpf-plugin-polyfills-script');
        wp_deregister_script('wcpf-plugin-vendor-script');
    }
}

add_action('wp_enqueue_scripts', 'casa_dequeue_scripts', PHP_INT_MAX, 0);

add_action('wp_footer', function () {
    wp_enqueue_style('elementor-post-5272');
    wp_enqueue_style('elementor-post-5296');
    wp_enqueue_style('elementor-post-5446');
    wp_enqueue_style('elementor-frontend');
    wp_enqueue_style('elementor-global');
    wp_enqueue_script('jquery');
});

add_action('wp_footer', static function () {
    wp_deregister_script('elementor-pro-frontend');
}, PHP_INT_MAX);

function env_debug()
{
    return defined('WP_DEBUG') && WP_DEBUG;
}

add_action('elementor/frontend/after_register_scripts', static function () {
    if (is_product()) {
        wp_deregister_script('elementor-frontend');
        wp_deregister_script('jquery-swiper');
        wp_deregister_script('elementor-sticky');
    }
});

add_action('elementor/frontend/after_enqueue_styles', static function () {
  if (is_product()) {
    wp_dequeue_style('elementor-frontend');
  }
});

add_filter( 'wc_add_to_cart_message_html', '__return_false' );
