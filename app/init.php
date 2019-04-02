<?php

/**
 *
 */
array_map(
    function ($file) {
        $file = get_stylesheet_directory() . "/app/{$file}.php";
        load_template($file);
    },
    [
        'ajax/init',
        'post/init',
    
        'hooks/woocommerce',

    ]
);


add_filter('woocommerce_default_catalog_orderby', 'custom_default_catalog_orderby');

function custom_default_catalog_orderby() {
	return 'popularity'; // Can also use title and price
}
