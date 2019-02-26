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
    $product = wc_get_product($id); ?>
	POTM??
	<?php print $product->get_meta('is_monthly'); ?>
<?php
}
