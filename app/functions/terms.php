<?php

add_filter('timber/twig', function (\Twig_Environment $twig) {
    $twig->addFunction(new Timber\Twig_Function('fetchProductsFromTerm', 'cdv_find_products_on_term'));
    return $twig;
});

function cdv_find_products_on_term($termSlug, $termName ='pa_streek', $limit = 3)
{
    if (!$termSlug) {
        return;
    }
    
    $args = [
        'post_type'             => 'product',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => 1,
        'posts_per_page'        => $limit,
        'orderby'               => 'RAND',
        'tax_query'             => [
            'relationship'  => 'OR',
            [
                'taxonomy'      =>  $termName,
                'terms'         => [ $termSlug ],
                'field'         => 'slug',
                'operator'      => 'IN',
            ]
        ]
    ];
    
    return \Timber\Timber::get_posts($args);
};
