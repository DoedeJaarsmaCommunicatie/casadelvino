<?php

function register_shop_widgets()
{
    register_sidebar([
        'name'  => __('Filter sidebar', 'casadelvino'),
        'id'    => 'product_filter_widget',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ]);
}

add_action('widgets_init', 'register_shop_widgets');
