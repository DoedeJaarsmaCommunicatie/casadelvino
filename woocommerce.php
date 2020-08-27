<?php

use Timber\Term;
use Timber\Post;
use Timber\Timber;
use Timber\Helper;

defined('ABSPATH') || exit;
$context            = Timber::get_context();

if (is_singular('product')) {
    $context['post']        = new Post();
    $product                = wc_get_product($context['post']->id);
    $context['product']     = $product;

    $context['regions'] = Helper::transient('product-' . $product->get_id() . '-regions', static function () use ($product) {
        $regions = [];
        if (has_term('', 'pa_streek', $product->get_id())) {
            if (get_the_terms($product->get_id(), 'pa_streek')[0]) {
                foreach (get_the_terms($product->get_id(), 'pa_streek') as $region) {
                    $regions [] = new Term($region->term_id);
                }
            }
        }
        return $regions;
    }, 3600);

    $context['grapes'] = Helper::transient('product-' . $product->get_id() .  '-grapes', static function () use ($product) {
        $grapes = [];
        if (has_term('', 'pa_druif', $product->get_id())) {
            if (get_the_terms($product->get_id(), 'pa_druif')[0]) {
                foreach (get_the_terms($product->get_id(), 'pa_druif') as $druif) {
                    $grapes [] = new Term($druif->term_id);
                }
            }
        }
        return $grapes;
    }, 3600);

    $context['domains'] = Helper::transient('product-' . $product->get_id() .  '-domains', function () use ($product) {
        $domains = [];
        if (has_term('', 'pa_domein', $product->get_id())) {
            if (get_the_terms($product->get_id(), 'pa_domein')[0]) {
                foreach (get_the_terms($product->get_id(), 'pa_domein') as $domein) {
                    $domains [] = new Term($domein->term_id);
                }
            }
        }

        return $domains;
    }, 3600);

    $context['category'] = Helper::transient('product-' . $product->get_id() . '-categories', static function () use ($product) {
        return array_map(static function ($term) {
            return new Term($term->term_id);
        }, get_the_terms($product->get_id(), 'product_cat'));
    }, 3600);

    $context['related_products'] = Helper::transient('product-' . $context['post']->ID . '-related', static function () use ($context) {
        $related_limit               = 4;
        $related_ids                 = wc_get_related_products($context['product']->get_id(), $related_limit);
        return Timber::get_posts($related_ids);
    }, 3600);

    Timber::render('templates/woocommerce/single-product.twig', $context);
} else {
    $posts = Timber::get_posts();
    $context['products'] = $posts;

    if (is_product_category()) {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $context['category'] = get_term($term_id, 'product_cat');
        $context['title'] = single_term_title('', false);
    }

    Timber::render('templates/woocommerce/archive.twig', $context);
}
