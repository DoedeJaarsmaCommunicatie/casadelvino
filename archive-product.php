<?php

if (class_exists('Timber')) {
    $context = \Timber\Timber::get_context();
    
//    $context['filter'] = \Timber\Timber::get_widgets('product_filter_widget');
    
    \Timber\Timber::render('templates/woocommerce/archive.twig');
}
