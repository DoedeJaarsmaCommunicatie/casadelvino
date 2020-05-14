<?php
class AutoFillController extends \WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'casa/v1';
        $this->rest_base = 'autofill';
    }

    public function register_routes(): void
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'               => \WP_REST_Server::READABLE,
                    'callback'              => [ $this, 'get_items'],
                    'permission_callback'   => [ $this, 'get_items_permissions_check'],
                ],
            ]
        );
    }

    /**
     * @param WP_REST_Request $request
     *
     * @return true Always true.
     */
    public function get_items_permissions_check($request)
    {
        return true;
    }

    /**
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|\WP_REST_Response the response
     */
    public function get_items($request)
    {
        return rest_ensure_response($this->getResponse());
    }

    /**
     * Sets the response.
     *
     * @uses array_merge()
     * @since 1.0.0
     * @return array
     */
    protected function getResponse(): array
    {
        $response = $this->getWineNames();
        $response = array_merge($response, $this->getCountryNames());
        $response = array_merge($response, $this->getGrapeNames());
        return $response;
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
        return array_map(static function ($obj) {
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
        return array_map(static function (\WC_Product $obj) {
            return $obj->get_name();
        }, $this->getAllWines());
    }

    /**
     * Fetches all wines as objects.
     *
     * @uses wc_get_products()
     * @since 1.0.0
     * @return \WC_Product[]
     */
    protected function getAllWines(): array
    {
        return \wc_get_products([
            'orderby'       => 'title',
            'order'         => 'DESC',
            'numberposts'   => '500'
        ]);
    }
}
