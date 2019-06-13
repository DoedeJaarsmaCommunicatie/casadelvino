<?php

add_shortcode('tag-fetcher', function ($atts) {
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
