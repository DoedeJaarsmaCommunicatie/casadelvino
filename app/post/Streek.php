<?php

$streek = new CPT(
    [
        'post_type_name'     => 'streek',
        'singular' => 'Streek',
        'plural'   => 'Streken',
        'slug'     => 'streken',
    ],
    [
    	'supports'  => [
    		'title',
    	    'editor',
    	    'page-attributes',
	    ],
        'rewrite'   => [
            'slug'  => 'wijngebieden-italie'
        ],
        'hierarchical' => true,
    ]
);
