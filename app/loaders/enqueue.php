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
        'cdv_general_styles',
        get_stylesheet_directory_uri() . '/dist/styles/cdv.combined.css',
        [],
        filemtime(get_stylesheet_directory(). '/dist/styles/cdv.combined.css')
    );

    wp_register_style(
        'cdv_archive',
        get_stylesheet_directory_uri() . '/dist/styles/archive.css',
        [],
        filemtime(get_stylesheet_directory(). '/dist/styles/archive.css'),
        'all'
    );

    wp_register_style(
        'cdv_checkout',
        get_stylesheet_directory_uri() . '/dist/styles/checkout.css',
        [],
        filemtime(get_stylesheet_directory(). '/dist/styles/checkout.css'),
        'all'
    );

    wp_register_script(
        'manifest-js',
        get_stylesheet_directory_uri() . '/dist/js/manifest.js',
        [],
        filemtime(get_stylesheet_directory(). '/dist/js/manifest.js'),
        true
    );

    wp_register_script(
        'vendor-js',
        get_stylesheet_directory_uri() . '/dist/js/vendor.js',
        ['manifest-js'],
        filemtime(get_stylesheet_directory(). '/dist/js/vendor.js'),
        true
    );

    wp_register_script(
        'cdv_vue',
        get_stylesheet_directory_uri() . '/dist/js/app.vue.webpack.js',
        ['manifest-js', 'vendor-js'],
        filemtime(get_stylesheet_directory(). '/dist/js/app.vue.webpack.js'),
        true
    );

    /**
     * Scripts
     */
    wp_register_script(
        'cdv_submenu_handler',
        get_stylesheet_directory_uri() . '/dist/js/bundled.js',
        [],
        filemtime(get_stylesheet_directory(). '/dist/js/bundled.js'),
        true
    );

    wp_register_script(
        'cdv_typescript_bundle',
        get_stylesheet_directory_uri() . '/dist/js/bundled.ts.js',
        [],
        filemtime(get_stylesheet_directory(). '/dist/js/bundled.ts.js'),
        20190206,
        true
    );
}
add_action('wp_enqueue_scripts', 'cdv_registers', 1, 0);

/**
 * Enqueue scripts and styles.
 */
function cdv_enqueue()
{
    wp_enqueue_script('cdv_submenu_handler');

    if (!is_customize_preview()) {
        wp_enqueue_script('cdv_vue');
        wp_enqueue_script('cdv_typescript_bundle');
    }

    if (is_checkout() || is_checkout_pay_page() || is_cart()) {
        wp_enqueue_style('cdv_checkout');
    }

    if (is_archive()) {
        wp_enqueue_style('cdv_archive');
    }

    wp_localize_script('ajax_add_to_cart', 'cdv_ajax_object', [ 'ajax_url' => admin_url('admin-ajax.php') ]);

    if (is_product()) {
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-migrate');
    }


    if (!is_home()) {
        wp_deregister_style('badubed-main-style');
    }
    wp_deregister_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'cdv_enqueue', 20);

add_action('wp_enqueue_scripts', static function () {
    if (is_product()) {
        wp_deregister_style('woocommerce-general');
        wp_deregister_style('wcpf-plugin-style');
        wp_deregister_style('woocommerce-layout');
        wp_deregister_style('woocommerce-smallscreen');
        wp_deregister_style('elementor-icons');
        wp_deregister_style('font-awesome');
        wp_deregister_style('elementor-animations');
        wp_deregister_script('wcpf-plugin-vendor-script');
        wp_deregister_script('wcpf-plugin-polyfills-script');
        wp_deregister_script('wcpf-plugin-script');
    }
}, 20);

add_filter('elementor/frontend/print_google_fonts', '__return_false');

add_action('elementor/frontend/after_enqueue_styles', static function () {
    if (is_product()) {
        wp_dequeue_style('elementor-pro');
        wp_dequeue_style('elementor-waypoints');
        wp_dequeue_style('swiper');
        wp_dequeue_style('elementor-frontend');
    }
}, 20);



function cdv_enqueue_autofill()
{
    wp_enqueue_script(
        'search_form_autofiller_cdn',
        'https://cdn.jsdelivr.net/gh/TarekRaafat/autoComplete.js@3.2.2/dist/js/autoComplete.min.js',
        [],
        201901,
        true
    );
}

add_action('wp_enqueue_scripts', 'cdv_enqueue_autofill');

add_action('wp_footer', static function () {
    if (is_product()) {
        wp_register_script(
            'jquery',
            'https://code.jquery.com/jquery-3.5.1.min.js',
            [],
            '3.5.1',
            true
        );

        wp_register_script(
            'jquery-migrate',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js',
            [],
            '3.0.1',
            true
        );
    }
});
