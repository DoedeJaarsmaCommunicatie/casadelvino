<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-22
 * Time: 10:53
 */


function cdv_registers()
{
    wp_register_style(
        'cdv_archive',
        get_stylesheet_directory_uri() . '/dist/styles/archive.css',
        [],
        20190128,
        'all'
    );
    
    wp_register_style(
        'cdv_checkout',
        get_stylesheet_directory_uri() . '/dist/styles/checkout.css',
        [],
        20190128,
        'all'
    );
    
    wp_register_script(
        'cdv_vue',
        get_stylesheet_directory_uri() . '/dist/js/app.vue.webpack.js',
        [],
        20190123,
        true
    );
}
add_action('wp_enqueue_scripts', 'cdv_registers', 1, 0);

/**
 * Enqueue scripts and styles.
 */
function cdv_enqueue()
{
    wp_enqueue_style('badubed-style', get_stylesheet_uri(), [], 201811, 'all');
    wp_enqueue_style('badubed-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,700', []);
    wp_enqueue_style('badubed-font-2', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,900', []);
    wp_enqueue_script('badubed-fontawesome', 'https://use.fontawesome.com/releases/v5.7.0/js/all.js', []);
    
    wp_enqueue_style(
        'cdv_general_styles',
        get_stylesheet_directory_uri() . '/dist/styles/cdv.combined.css',
        [],
        201901
    );
    
    wp_enqueue_script(
        'cdv_submenu_handler',
        get_stylesheet_directory_uri() . '/dist/js/bundled.js',
        [],
        2019,
        true
    );
    
    if (!is_customize_preview()) {
        wp_enqueue_script('cdv_vue');
    }
    
    if (is_checkout() || is_checkout_pay_page() || is_cart()) {
        wp_enqueue_style('cdv_checkout');
    }
    
    wp_localize_script('ajax_add_to_cart', 'cdv_ajax_object', [ 'ajax_url' => admin_url('admin-ajax.php') ]);
}
add_action('wp_enqueue_scripts', 'cdv_enqueue');


function cdv_enqueue_autofill()
{
    wp_enqueue_style(
        'search_form_cdn',
        'https://cdn.jsdelivr.net/gh/TarekRaafat/autoComplete.js@3.2.2/dist/css/autoComplete.min.css',
        [],
        201901,
        'all'
    );

    wp_enqueue_script(
        'search_form_autofiller_cdn',
        'https://cdn.jsdelivr.net/gh/TarekRaafat/autoComplete.js@3.2.2/dist/js/autoComplete.min.js',
        [],
        201901,
        true
    );
}

add_action('wp_enqueue_scripts', 'cdv_enqueue_autofill');
