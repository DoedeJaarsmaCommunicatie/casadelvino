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
        
        $this->sendSuccessResponse($this->returnProduct());
    }
    
    protected function sendSuccessResponse(WC_Product $product): void
    {
        if ($this->isEnoughStock($product->get_stock_status())) {
            wp_send_json_success(
                [
                    'in_stock'  => 1,
                    'stock'     => $product->get_stock_quantity(),
                ]
            );
        }
        
        if ($this->allowBackorder($product->get_stock_status())) {
            wp_send_json_success([
                'backorder'     => 1,
            ]);
        }
        
        wp_send_json_success([
            'backorder'     => 0,
        ]);
    }
    
    protected function allowBackorder($backorder)
    {
        return $backorder === 'onbackorder';
    }
    
    protected function isEnoughStock($status)
    {
        return $status === 'instock';
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
