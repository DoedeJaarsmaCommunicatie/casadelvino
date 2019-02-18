<?php

array_map(
    function ($file) {
        $file = get_stylesheet_directory() . "/app/ajax/{$file}.php";
        load_template($file);
    },
    [
        'AddToCart',
        'KiyohSolution',
        'Api/GetAutofill',
        'Api/isInStock',
        'Api/getCartContents',
        'Api/GetProduct',
    ]
);
