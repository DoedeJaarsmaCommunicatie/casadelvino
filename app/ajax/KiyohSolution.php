<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-23
 * Time: 16:30
 */
require_once __DIR__ . '/../../vendor/autoload.php';

use JKetelaar\Kiyoh\Kiyoh;

class KiyohSolution
{
    /**
     * @var Kiyoh
     */
    private $client;
    
    /**
     * @var \JKetelaar\Kiyoh\Models\Company
     */
    private $casa;
    
    /**
     * @var \JKetelaar\Kiyoh\Models\Review
     */
    private $reviews;
    
    public const CONNECTORCODE = 'ac77DazP6D4uYxuNfU8rVMdMSWFx8n87v2e5wCzcfEBentSdAB';
    public const COMPANYCODE = 15837;
    
    public function __construct()
    {
        add_action('wp_ajax_fetch_kiyoh', [ $this, 'fetch' ]);
        add_action('wp_ajax_nopriv_fetch_kiyoh', [ $this, 'fetch' ]);
    }
    
    public function fetch(): void
    {
        if ($this->doesTransientExist()) {
            $this->sendResponse();
        }
        $this->setKiyoh();
        $this->setData();
        $this->sendResponse();
    }
    
    private function setData(): void
    {
        set_transient('cdv_kiyoh_fetch', 43200);
        update_option('cdv_kiyoh_score', $this->casa->getTotalScore());
        update_option('cdv_kiyoh_reviews_count', $this->casa->getTotalReviews());
        update_option('cdv_kiyoh_url', $this->casa->getUrl());
        update_option('cdv_kiyoh_last_review', wp_json_encode($this->reviews));
    }
    
    private function doesTransientExist(): bool
    {
        if (isset($_GET['fresh'])) {
            delete_transient('cdv_kiyoh_fetch');
        }
        return get_transient('cdv_kiyoh_fetch') !== false;
    }
    
    private function setKiyoh(): void
    {
        $this->client = new Kiyoh(self::CONNECTORCODE, self::COMPANYCODE);
        
        $this->casa = $this->client->getCompany();
        $this->reviews = $this->client->getReviews();
    }
    
    private function sendResponse(): void
    {
        wp_send_json_success(
            [
                'total_score'   => get_option('cdv_kiyoh_score'),
                'total_reviews' => get_option('cdv_kiyoh_reviews_count'),
                'kiyoh_url'     => get_option('cdv_kiyoh_url'),
                'reviews'       => get_option('cdv_kiyoh_last_review'),
            ]
        );
    }
}

new KiyohSolution();
