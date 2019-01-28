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
        
        'functions/header',
        
        'loaders/enqueue',
        'loaders/locations',
        
        'ajax/KiyohSolution',
        'ajax/AddToCart',
        'ajax/api/GetAutofill',
    ]
);
