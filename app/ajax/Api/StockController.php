<?php


class StockController extends \WP_REST_Controller
{
    public function __construct()
    {
        $this->namespace = 'casa/v1';
        $this->rest_base = 'stock';
    }
    
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)',
            [
                [
                    'methods'           => WP_REST_Server::READABLE,
                    'callback'          => [$this, 'get_stock'],
                ]
            ]
        );
    }
    
    /**
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_stock($request)
    {
        $product = wc_get_product((int) $request['id']);
        
        return rest_ensure_response([ $product->is_in_stock() ]);
    }
}

add_action('rest_api_init', static function () {
    $sc = new StockController();
    $sc->register_routes();
});
