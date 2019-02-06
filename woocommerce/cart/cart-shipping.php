<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = ! empty($has_calculated_shipping);
$show_shipping_calculator = ! empty($show_shipping_calculator);
$calculator_text          = '';
// Not working correctly
//if (class_exists('Timber')) {
//    $context = \Timber\Timber::get_context();
//    $context['destination'] = $formatted_destination;
//    $context['has_calculated_shipping'] = $has_calculated_shipping;
//    $context['show_shipping_calculator'] = $show_shipping_calculator;
//    $context['calc_text'] = $calculator_text;
//    $context['package_name'] = wp_kses_post($package_name);
//    $context['methods'] = $available_methods;
//    $context['chosen_method'] = $chosen_method;
//    return \Timber\Timber::render('templates/woocommerce/cart/parts/cart-shipping.twig', $context);
//} ?>
    <tr class="woocommerce-shipping-totals shipping">
        <th><?php echo wp_kses_post($package_name); ?></th>
        <td data-title="<?php echo esc_attr($package_name); ?>">
	        <?php if ($available_methods) : ?>
<ul id="shipping_method" class="woocommerce-shipping-methods">
                    <?php foreach ($available_methods as $method) : ?>
<li>
                            <?php
if (1 < count($available_methods)) {
printf('<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // WPCS: XSS ok.
} else {
printf('<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id)); // WPCS: XSS ok.
}
printf('<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method)); // WPCS: XSS ok.
do_action('woocommerce_after_shipping_rate', $method, $index); ?>
</li>
                    <?php endforeach; ?>
</ul>
            <?php endif;?>
        </td>
</tr>
