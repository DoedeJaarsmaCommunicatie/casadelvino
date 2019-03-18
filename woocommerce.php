<?php

if (! class_exists('Timber')) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    
    return;
}

$context            = Timber::get_context();

if (is_singular('product')) {
    $context['post']        = Timber::get_post($GLOBALS['post']->ID);
    $product                = wc_get_product($context['post']->ID);
    $context['product']     = $product;
    
    if (get_the_terms($product->get_id(), 'pa_streek')[0]) {
        foreach (get_the_terms($product->get_id(), 'pa_streek') as $region) {
            $context['regions']      []= new \Timber\Term($region->term_id);
        }
    }
    
    if (get_the_terms($product->get_id(), 'pa_druif')[0]) {
        foreach (get_the_terms($product->get_id(), 'pa_druif') as $druif) {
            $context['grapes']    []= new \Timber\Term($druif->term_id);
        }
    }
    
    if (get_the_terms($product->get_id(), 'pa_domein')[0]) {
        foreach (get_the_terms($product->get_id(), 'pa_domein') as $domein) {
            $context['domains']     []= new \Timber\Term($domein->term_id);
        }
    }
    
    $context['category'] = array_map(function ($term) {
        return new \Timber\Term($term->term_id);
    }, get_the_terms($product->get_id(), 'product_cat'));
    
    $related_limit               =  2;
    
    if ($product->get_upsell_ids()) {
        $context['related_products'] = \Timber\Timber::get_posts($product->get_upsell_ids());
        
        if ($context['related_products'] > 2) {
        	$context['related_products'] = array_splice( $context['related_products'], 0, 2);
        }
    } else {
        $related_ids                 =  wc_get_related_products($context['product']->get_id(), $related_limit);
        $context['related_products'] =  Timber::get_posts($related_ids);
    }
    wp_reset_postdata();
    
    Timber::render('templates/woocommerce/single-product.twig', $context);
} else {
    $posts = Timber::get_posts();
    $context['products'] = $posts;
    
    if (is_product_category()) {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $context['category'] = get_term($term_id, 'product_cat');
        $context['title'] = single_term_title('', false);
    }
    
    Timber::render('templates/woocommerce/archive.twig', $context);
}
