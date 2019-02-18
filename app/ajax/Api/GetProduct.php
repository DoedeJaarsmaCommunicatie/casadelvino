<?php

class GetProduct
{
    public function __construct()
    {
        add_action('wp_ajax_get_product_data', [$this, 'getProductData']);
        add_action('wp_ajax_nopriv_get_product_data', [$this, 'getProductData']);
    }
    
    public function getProductData(): void
    {
        if (!$this->isProductIdSet()) {
            $this->sendFailedResponse();
        }
        
        $this->sendSuccessResponse();
    }
    
    protected function productId(): int
    {
        return $_GET[ 'product_id' ]?? $_POST[ 'product_id' ];
    }
    
    protected function sendSuccessResponse(): void
    {
        $product = wc_get_product($this->productId());
        wp_send_json_success(
            [
                'name'          => $product->get_name(),
                'price'         => $product->get_price(),
            ]
        );
    }
    
    protected function isProductIdSet(): bool
    {
        return isset($_GET['product_id']) || isset($_POST['product_id']);
    }
    
    protected function sendFailedResponse(): void
    {
        wp_send_json_error(
            [
                'error'     => 'No ID passed',
                'message'   => 'No Product ID has been passed'
            ]
        );
    }
}

new GetProduct();
