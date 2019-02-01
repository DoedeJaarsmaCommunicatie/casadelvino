<?php

array_map(
    function ($file) {
        $file = get_stylesheet_directory() . "/app/post/{$file}.php";
        load_template($file);
    },
    [
        'CPT',
        'Streek',
    ]
);
