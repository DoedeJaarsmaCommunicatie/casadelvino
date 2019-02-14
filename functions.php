<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-21
 * Time: 10:27
 */
add_theme_support('woocommerce');

array_map(
    function ($file) {
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

remove_action('register_new_user', 'wp_send_new_user_notifications');

if (! function_exists('wp_new_user_notification')) :
    function wp_new_user_notification($user_id, $deprecated = null, $notify = '')
    {
        return;
    }
endif;
