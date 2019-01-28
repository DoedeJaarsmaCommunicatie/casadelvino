<?php

/**
 * Class GetAutofill
 * @author Mitch Hijlkema
 * @version 1.0.0
 * @package App
 */
class GetAutofill
{
    /**
     * The response that should be returned.
     *
     * @var array  The response that should be returned.
     */
    private $response;
    
    /**
     * GetAutofill constructor.
     */
    public function __construct()
    {
        add_action('wp_ajax_get_autofill', [$this, 'getAutofillCallback']);
        add_action('wp_ajax_nopriv_get_autofill', [$this, 'getAutofillCallback']);
    }
    
    /**
     * Handles the functionality for getAutofill.
     *
     * @since 1.0.0
     * @return void
     */
    public function getAutofillCallback(): void
    {
        ob_start();
        $this->setResponse();
        
        $this->sendResponse();
    }
    
    /**
     * Returns the response.
     *
     * @uses wp_send_json_success()
     * @since 1.0.0
     * @return void
     */
    final protected function sendResponse(): void
    {
        wp_send_json_success($this->response);
    }
    
    /**
     * Sets the response.
     *
     * @uses array_merge()
     * @since 1.0.0
     * @return void
     */
    protected function setResponse(): void
    {
        $this->response = $this->getWineNames();
        $this->response = array_merge($this->response, $this->getCountryNames());
        $this->response = array_merge($this->response, $this->getGrapeNames());
    }
    
    /**
     * Returns the names of the grapes.
     *
     * @uses array_map()
     * @since 1.0.0
     * @return array
     */
    protected function getGrapeNames(): array
    {
        return array_map(function ($obj) {
            return $obj->name;
        }, $this->getAllGrapes());
    }
    
    /**
     * Fetches all grapes from WooCommerce.
     *
     * @uses get_terms()
     * @since 1.0.0
     * @return array
     */
    protected function getAllGrapes(): array
    {
        return get_terms('pa_druif');
    }
    
    /**
     * Returns the names from the countries.
     *
     * @uses array_map()
     * @since 1.0.0
     * @return array
     */
    protected function getCountryNames(): array
    {
        return array_map(function ($obj) {
            return $obj->name;
        }, $this->getAllCountries());
    }
    
    /**
     * Fetches all countries as object.
     *
     * @uses get_terms()
     * @since 1.0.0
     * @return array
     */
    protected function getAllCountries(): array
    {
        return get_terms('pa_land');
    }
    
    /**
     * Returns the names from the wines.
     *
     * @uses array_map()
     * @since 1.0.0
     * @return array
     */
    protected function getWineNames(): array
    {
        return array_map(function ($obj) {
            return $obj->name;
        }, $this->getAllWines());
    }
    
    /**
     * Fetches all wines as objects.
     *
     * @uses wc_get_products()
     * @since 1.0.0
     * @return array
     */
    protected function getAllWines(): array
    {
        return wc_get_products([
            'orderby'   => 'title',
            'order'     => 'DESC'
        ]);
    }
}

new GetAutofill();
