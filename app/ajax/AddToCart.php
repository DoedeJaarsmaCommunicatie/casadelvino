<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-23
 * Time: 15:53
 */

class AddToCart
{
    private $productId;
    private $quantity;
    private $data;

    public function __construct()
    {
        add_action('wp_ajax_nopriv_add_to_cart', [$this, 'addToCartCallback']);
        add_action('wp_ajax_add_to_cart', [$this, 'addToCartCallback']);
    }

    public function addToCartCallback(): void
    {
        ob_start();
        $this->data = json_decode(file_get_contents('php://input'));

        $this->setProductId();
        $this->setQuantity();

        if ($this->didPassValidation() && $this->addToCart()) {
            $this->sendSuccessResponse();
        } else {
            $this->sendFailedResponse();
        }
    }

    private function sendSuccessResponse(): void
    {
        do_action('woocommerce_ajax_added_to_cart', $this->productId);
        if ($this->shouldSendToCart()) {
            wc_add_to_cart_message($this->productId);
        }

        wp_send_json_success([
            'product'   => wc_get_product($this->productId)->get_name(),
            'quantity'  => $this->quantity
        ]);
    }

    private function sendFailedResponse(): void
    {
        wp_send_json_error([
            'product_url'   =>  apply_filters(
                'woocommerce_cart_redirect_after_error',
                get_permalink($this->productId),
                $this->productId
            )
        ]);
    }

    private function shouldSendToCart(): bool
    {
        return get_option('woocommerce_cart_redirect_after_add') === 'yes';
    }

    private function didPassValidation(): bool
    {
        return apply_filters(
            'woocommerce_add_to_cart_validation',
            true,
            $this->productId,
            $this->quantity
        );
    }

    private function addToCart(): bool
    {
        return WC()->cart->add_to_cart($this->productId, $this->quantity);
    }

    private function setProductId(): void
    {
        $this->productId = apply_filters(
            'woocommerce_add_to_cart_product_id',
            absint($this->data->product_id)
        );
    }

    private function setQuantity(): void
    {
        $this->quantity = empty($this->data->quantity)?
            1 :
            apply_filters(
                'woocommerce_stock_amount',
                absint($this->data->quantity)
            );
    }
}

add_action('init', static function () {
    new AddToCart();
});
