<?php

array_map(
    function ($file) {
        $file = get_stylesheet_directory() . "/app/customizer/{$file}.php";
        load_template($file);
    },
    [
        'Customizer',
        'GeneralInformation',
    ]
);

new \App\Customizer\Customizer();
