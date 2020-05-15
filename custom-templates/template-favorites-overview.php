<?php

/**
 * Template Name: Favorites overview
 */

$context = \Timber\Timber::get_context();
$context['post'] = new \Timber\Post();
$context['favorites'] = \Timber\Timber::get_posts(get_user_favorites());
$context['user'] = wp_get_current_user();

$templates = [
    'templates/views/page-specific/favorites.html.twig'
];

\Timber\Timber::render($templates, $context);
