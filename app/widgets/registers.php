<?php

function cdv_register_shop_widgets()
{
    register_sidebar([
        'name'  => __('Filter sidebar', 'casadelvino'),
        'id'    => 'product-filter-widget',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ]);
}

add_action('widgets_init', 'cdv_register_shop_widgets');
