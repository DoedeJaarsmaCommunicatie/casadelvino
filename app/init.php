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
    // So here you are adding data to Timber's context object, i.e...
    // Now, in similar fashion, you add a Timber Menu and send it along to the context.
    $context['mobileSubmenu'] = new \Timber\Menu('mobile-sub-menu');
    
    return $context;
}
