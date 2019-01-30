<?php

/**
 * My custom Twig functionality.
 *
 * @param Twig_Environment $twig
 * @return $twig
 */
add_filter('timber/twig', function (\Twig_Environment $twig) {
    $twig->addFunction(new Timber\Twig_Function('cart_product_subtotal', 'cdv_cart_product_subtotal'));
    $twig->addFunction(new Timber\Twig_Function('cart_quantity_input', 'cdv_cart_quantity_amount'));
    return $twig;
});

function cdv_cart_product_subtotal($product, $quantity)
{
    return wc()->cart->get_product_subtotal($product, $quantity);
}

/**
 * @SuppressWarnings(PHPMD)
 *
 * @param WC_Product $product
 * @param            $item
 * @param            $key
 */
function cdv_cart_quantity_amount(WC_Product $product, $item, $key)
{
    if ($product->is_sold_individually()) {
        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $key);
    } else {
        $product_quantity = woocommerce_quantity_input(array(
            'input_name'   => "cart[{$key}][qty]",
            'input_value'  => $item['quantity'],
            'max_value'    => $product->get_max_purchase_quantity(),
            'min_value'    => '0',
            'product_name' => $product->get_name(),
        ), $product, false);
    }
    
    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $key, $item);
}
