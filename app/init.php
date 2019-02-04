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
    ]
);


add_filter('timber/context', 'add_to_context');

function add_to_context($context)
{
    $context['device'] = new Mobile_Detect();
    return $context;
}
