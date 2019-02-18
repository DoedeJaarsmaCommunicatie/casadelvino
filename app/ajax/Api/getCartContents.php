<?php

class getCartContents
{
    public function __construct()
    {
        add_action('wp_ajax_get_cart_contents', [$this, 'getCartContents']);
        add_action('wp_ajax_nopriv_get_cart_contents', [$this, 'getCartContents']);
    }
    
    public function getCartContents(): void
    {
        ob_start();
        if (!$this->cartHasItems()) {
            $this->sendFailedResponse('No items in cart', __('There are no items in cart'));
        }
        
        $this->sendSuccessResponse($this->getCartItems());
    }
    
    protected function getCartItems(): array
    {
        return wc()->cart->get_cart_contents();
    }
    
    protected function cartHasItems(): bool
    {
        return wc()->cart->get_cart_contents_count() > 0;
    }
    
    protected function sendSuccessResponse(array $data): void
    {
        wp_send_json_success($data);
    }
    
    protected function sendFailedResponse($error, $msg): void
    {
        wp_send_json_error(
            [
                'error'     => $error,
                'message'   => $msg,
            ]
        );
    }
}

new getCartContents();
