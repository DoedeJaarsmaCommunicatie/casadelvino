<?php

$templates        = [ 'templates/search.twig', 'templates/archive.twig', 'templates/index.twig' ];
$context          = \Timber\Timber::get_context();
$context['title'] = 'Zoekresultaten voor: ' . get_search_query();
$context['posts'] = new \Timber\PostQuery();

\Timber\Timber::render($templates, $context);
