<?php

class UpdateCart
{
    private $_data;
    
    public function __construct()
    {
        add_action('wp_ajax_nopriv_update_cart', [$this, 'updateCart']);
        add_action('wp_ajax_update_cart', [$this, 'updateCart']);
    }
    
    public function updateCart(): void
    {
        ob_start();
        $this->_data = json_decode(file_get_contents('php://input'));
        
        if ($this->getQuantity() === 0) {
            wc()->cart->remove_cart_item($this->getCartId());
            wp_send_json_success('removed');
        }
        
        wc()->cart->set_quantity($this->getCartId(), $this->getQuantity());
        wp_send_json_success('updated');
    }
    
    protected function getCartId(): string
    {
        return $this->_data->product_id;
    }
    
    protected function getQuantity(): int
    {
        return $this->_data->quantity;
    }
}
