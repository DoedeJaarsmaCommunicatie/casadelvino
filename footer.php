<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2018-12-03
 * Time: 08:45
 */

$timberContext = $GLOBALS['timberContext']; // @codingStandardsIgnoreFile
if (! isset($timberContext)) {
    throw new \Exception('Timber context not set in footer.');
}

$timberContext['content'] = ob_get_contents();
ob_end_clean();
$templates = array( 'templates/layouts/wc_base.twig' );
Timber::render($templates, $timberContext);
//wp_die(Timber::render($templates, $timberContext));

