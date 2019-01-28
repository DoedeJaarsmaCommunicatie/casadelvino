<?php

class GetAutofill
{
    /**
     * The response that should be returned.
     *
     * @var array  The response that should be returned.
     */
    private $response;
    
    public function __construct()
    {
        add_action('wp_ajax_get_autofill', [$this, 'getAutofillCallback']);
        add_action('wp_ajax_nopriv_get_autofill', [$this, 'getAutofillCallback']);
    }

    public function getAutofillCallback(): void
    {
        ob_start();
        $this->setResponse();
        
        $this->sendResponse();
    }
    
    final protected function sendResponse(): void
    {
        wp_send_json_success($this->response);
    }
    
    protected function setResponse(): void
    {
        $this->response = $this->getWineNames();
        $this->response = array_merge($this->response, $this->getCountryNames());
    }
    
    protected function getAllGrapes(): array
    {
        return [];
    }
    
    protected function getCountryNames(): array
    {
        return array_map(function ($obj) {
            return $obj->name;
        }, $this->getAllCountries());
    }
    
    protected function getAllCountries(): array
    {
        return get_terms('pa_land');
    }
    
    protected function getWineNames(): array
    {
        return array_map(function ($obj) {
            return $obj->name;
        }, $this->getAllWines());
    }
    
    protected function getAllWines(): array
    {
        return wc_get_products([
            'orderby'   => 'title',
            'order'     => 'DESC'
        ]);
    }
}

new GetAutofill();
