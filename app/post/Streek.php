<?php

use CPT;

$streek = new CPT(
    [
        'name'     => 'streek',
        'singular' => 'Streek',
        'plural'   => 'Streken',
        'slug'     => 'streken',
    ]
);

$streek->register_post_type();
