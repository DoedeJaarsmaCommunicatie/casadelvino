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
    
    $related_limit               =  2;
    $related_ids                 =  wc_get_related_products($context['product']->get_id(), $related_limit);
    $context['related_products'] =  Timber::get_posts($related_ids);
	wp_reset_postdata();
	
    Timber::render('templates/woocommerce/partials/tease-product.twig', $context);
//    if (is_front_page()) {
//    } else {
//        Timber::render('templates/woocommerce/partials/tease-archive.twig', $context);
//    }
}
