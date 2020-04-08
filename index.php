<?php

defined('ABSPATH') || exit;

$context = \Timber\Timber::get_context();
$context['post'] = new \Timber\Post();

\Timber\Timber::render(['templates/index.twig'], $context);
