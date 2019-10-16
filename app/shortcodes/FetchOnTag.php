<?php

use Timber\Timber;

add_shortcode('tag-fetcher', static function ($atts) {
	$atts = shortcode_atts(
		[
			'tags'  => null,
			'limit' => -1
		],
		$atts
	);
	
	$context = \Timber\Timber::get_context();
	
	if (null !== $atts['tags']) {
		$tags = explode('|', $atts['tags']);
	}
	
	$posts = [];
	
	foreach (wc_get_products([
		'tag'  => $tags,
		'limit' => $atts['limit']
	]) as $wc_get_product) {
		$posts []= [
			'product'   => $wc_get_product,
			'post'      => get_post($wc_get_product->get_id())
		];
	}
	
	$context['products'] = $posts;
	
	return \Timber\Timber::compile('templates/shortcodes/tag-loader.twig', $context);
});


add_shortcode('popularity-fetcher', static function (array $atts = []) {
	$atts = shortcode_atts(
		[
			'category'  => null,
			'limit'     => 10
		],
		$atts
	);
	
	$context = Timber::get_context();
	$categories = false;
	
	if (null !== $atts['category']) {
		$categories = explode('|', $atts['category']);
	}
	
	$args = [
		'post_type'         => 'product',
		'post_status'       => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'    => $atts['limit'],
        'meta_key'          => 'total_sales',
        'orderby'           => 'meta_value_num',
		'tax_query'         => []
	];
	
	if ($categories) {
		foreach ($categories as $category) {
			$args['tax_query'] []= [
				'taxonomy'  => 'product_cat',
				'field'     => 'slug',
				'terms'     => $category
			];
		}
	}
	
	$posts = [];
	foreach (wc_get_products($args) as $wcGetProduct) {
		$posts [] = [
			'product'   => $wcGetProduct,
			'post'      => get_post($wcGetProduct->get_id())
		];
	}
	
	$context['products'] = $posts;
	
	Timber::render('templates/shortcodes/popularity-loader.twig', $context);
});
