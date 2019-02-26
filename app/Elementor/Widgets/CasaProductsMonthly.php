<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CasaProductsMonthly extends \ElementorPro\Modules\Woocommerce\Widgets\Products
{
    public function get_name(): string
    {
        return 'cdv-products-month';
    }
    
    public function get_title(): string
    {
        return __('Monthly products', 'cdv');
    }
    
    public function get_categories(): array
    {
        return [
            'cdv',
        ];
    }
    
    protected function render(): void
    {
        if (WC()->session) {
            wc_print_notices();
        }
        
        $settings = $this->get_settings();
        
        $shortcode = new \ElementorPro\Modules\Woocommerce\Classes\Products_Renderer($settings, 'products');
        
        $content = $shortcode->get_content();
        
        if ($content) {
            echo $content;
        } elseif ($this->get_settings('nothing_found_message')) {
            echo '<div class="elementor-nothing-found elementor-products-nothing-found">'
                 . esc_html($this->get_settings('nothing_found_message'))
                 . '</div>';
        }
    }
}
