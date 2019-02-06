<?php
/**
 * Template Name: Vueless page
 * Description: Een pagina waarbij vue geen element target heeft.
 */

$templates          = [
    'templates/vueless.twig'
];

$context = Timber::get_context();
$post = new \Timber\Post();
$context['post'] = $post;

\Timber\Timber::render($templates, $context);
