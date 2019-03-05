<?php

$streek = new CPT(
    [
        'post_type_name'     => 'streek',
        'singular' => 'Streek',
        'plural'   => 'Streken',
        'slug'     => 'streken',
    ],
    [
        'rewrite'   => [
            'slug'  => 'wijngebieden-italie'
        ],
        'hierarchical' => true,
    ]
);
