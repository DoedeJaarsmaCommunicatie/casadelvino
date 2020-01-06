<?php

remove_action('init', ['WC_Block_Library', 'register_assets'], 20);
add_action('wp_print_styles', 'dequeue_font_awesome_style');
function dequeue_font_awesome_style()
{
    wp_dequeue_style('font-awesome');
    wp_deregister_style('font-awesome');
}
add_filter('woocommerce_product_tabs', 'cdv_product_tabs');

function cdv_product_tabs($tabs)
{
    $tabs['settings_tab'] = [
        'title'     => __('Product Extra settings', 'cdv'),
        'priority'  => 50,
        'callback'  => 'cdv_product_setting_tab_content',
    ];
    
    return $tabs;
}

add_action('woocommerce_top_pagination', 'woocommerce_pagination', 20);

function cdv_product_setting_tab_content()
{
    $id = get_the_ID();
    $product = wc_get_product($id);
    echo 'Product van de Maand';
}


add_action('woocommerce_before_shop_main_content', function () {
    if (is_product_category()) {
        productCategoryHeader();
    }
});

add_action('woocommerce_after_shop_main_content', function () {
    if (is_product_category()) {
        productCategoryFooter();
    }
});


function productCategoryHeader()
{
    $context = \Timber\Timber::get_context();
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $context['category'] = get_term($term_id, 'product_cat');
    $context['title'] = single_term_title('', false);
    $context['acf'] = get_fields($queried_object);
    
    return \Timber\Timber::render('templates/woocommerce/archive/category-header.twig', $context);
}

function productCategoryFooter()
{
    $context = \Timber\Timber::get_context();
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $context['category'] = get_term($term_id, 'product_cat');
    $context['title'] = single_term_title('', false);
    $context['acf'] = get_fields($queried_object);
    
    return \Timber\Timber::render('templates/woocommerce/archive/category-footer.twig', $context);
}

function doede_admin_notifier($hook)
{
    if ('edit.php' != $hook) {
        return;
    }
    wp_enqueue_script('doede_admin_notifier', get_stylesheet_directory_uri() . '/dist/js/admin.js', ['jquery'], 20190428, true);
}
add_action('admin_enqueue_scripts', 'doede_admin_notifier');

add_action('cdv_before_single_product', 'cdv_add_to_cart_message');

add_action('cdv_before_shop_content', 'cdv_add_to_cart_message');

add_action('cdv_before_front_page_content', 'cdv_add_to_cart_message');

function cdv_add_to_cart_message()
{
    if (!isset($_GET['add-to-cart'])) {
        return;
    }
    $id = $_GET['add-to-cart'];
    
    print '<cdv-mobile-cart product_name="' . get_the_title($id) . '"></cdv-mobile-cart>';
}
