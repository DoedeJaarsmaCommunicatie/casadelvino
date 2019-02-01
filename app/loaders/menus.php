<?php

function cdv_register_nav_menu()
{
    register_nav_menus(
        [
            'mobile-sub-menu'  => __('Mobile secondary', 'casadelvino'),
        ]
    );
}
add_action('after_setup_theme', 'cdv_register_nav_menu', 0);
