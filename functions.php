<?php

/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-21
 * Time: 10:27
 */

require_once get_stylesheet_directory() . '/vendor/autoload.php';

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

function casa_dequeue_scripts() {
	wp_dequeue_style('wc-block-style');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('toolset_bootstrap_styles');
	wp_deregister_script('wcpv-frontend-scripts');

	if (!is_admin_bar_showing()) {
		wp_dequeue_style('dashicons');
	}

	if (is_product()) {
		wp_dequeue_style('elementor-pro');
		wp_dequeue_style('elementor-global');
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

add_action('wp_enqueue_scripts', 'casa_dequeue_scripts', 50, 0);
