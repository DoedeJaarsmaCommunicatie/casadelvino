<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-21
 * Time: 10:27
 */
add_theme_support('woocommerce');

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
