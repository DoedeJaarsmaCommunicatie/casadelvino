<?php

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
