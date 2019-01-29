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
//wp_die(get_page_template());
$timberContext['content'] = ob_get_contents();
ob_end_clean();
$templates = array( 'templates/layouts/base.twig' );
Timber::render($templates, $timberContext);


