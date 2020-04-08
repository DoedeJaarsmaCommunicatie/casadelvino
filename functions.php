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
