<?php

array_map(
    static function ($file) {
        $file = get_stylesheet_directory() . "/app/ajax/{$file}.php";
        load_template($file);
    },
    [
        'AddToCart',
        'Api/getCartContents',
        'Api/StockController',
        'UpdateCart',
    ]
);
