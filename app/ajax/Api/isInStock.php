<?php

class isInStock
{
    private $productid;
    
    public function __construct()
    {
        add_action('wp_ajax_check_stock', [$this, 'stockCallback']);
        add_action('wp_ajax_nopriv_check_stock', [$this, 'stockCallback']);
    }
    
    public function stockCallback()
    {
    	ob_start();
        if (!$this->isProductIDSet()) {
            $this->sendFailedResponse();
        }
        
        $this->setProductID();
        
        $product = $this->returnProduct();
        
        wp_send_json_success($product->get_stock_quantity());
    }
    
    /**
     * @SuppressWarnings(PHPMD)
     * @return bool@
     */
    protected function isProductIDSet(): bool
    {
        return isset($_GET['product_id']);
    }
    
    /**
     * @SuppressWarnings(PHPMD)
     */
    protected function setProductID(): void
    {
        $this->productid = $_GET['product_id'];
    }

    protected function returnProduct()
    {
        return wc_get_product($this->productid);
    }
    
    protected function sendFailedResponse(): void
    {
        wp_send_json_error([
            'error' => 'No product ID set',
            'message' => __('No Product ID set, returning nothing.')
        ]);
    }
}

new isInStock();
