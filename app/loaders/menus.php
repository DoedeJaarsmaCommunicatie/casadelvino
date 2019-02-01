<?php

add_filter('timber/context', 'add_to_context');
function add_to_context($context)
{
    // So here you are adding data to Timber's context object, i.e...
    // Now, in similar fashion, you add a Timber Menu and send it along to the context.
    $context['primaryMenu'] = new \Timber\Menu('primary-menu');
    $context['mobileSubmenu'] = new \Timber\Menu('mobile-sub-menu');
    
    return $context;
}

function cdv_register_nav_menu()
{
    register_nav_menus(
        [
            'mobile-sub-menu'  => __('Mobile secondary', 'casadelvino'),
            'primary-menu'     => __('Primair', 'casadelvino'),
        ]
    );
}
add_action('after_setup_theme', 'cdv_register_nav_menu', 0);
