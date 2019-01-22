<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-04
 * Time: 11:07
 */

if (class_exists('Timber')) {
    $context                = Timber::get_context();
    
    $context['post']        = Timber::get_post($GLOBALS['post']->ID);
    $product                = wc_get_product($context['post']->ID);
    $context['product']     = $product;

    Timber::render('templates/woocommerce/partials/tease-product.twig', $context);
//    if (is_front_page()) {
//    } else {
//        Timber::render('templates/woocommerce/partials/tease-archive.twig', $context);
//    }
}
