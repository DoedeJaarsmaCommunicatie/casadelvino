<?php

/**
 * My custom Twig functionality.
 *
 * @param Twig_Environment $twig
 * @return $twig
 */
add_filter('timber/twig', function (\Twig_Environment $twig) {
    $twig->addFunction(new Timber\Twig_Function('edit_post_link', 'cdv_cart_product_subtotal'));
    return $twig;
});

function cdv_cart_product_subtotal($product, $quantity)
{
    return wc()->cart->get_product_subtotal($product, $quantity);
}
