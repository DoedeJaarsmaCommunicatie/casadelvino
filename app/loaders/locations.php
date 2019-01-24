<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-22
 * Time: 13:25
 */

function cdv_register_elementor_locations($elementor_theme_manager)
{
    $elementor_theme_manager->register_location('footer');
//    $elementor_theme_manager->register_location(
//        'main-footer',
//        [
//            'label' => __('Footer', 'casadelvino'),
//            'multiple' => false,
//            'edit_in_content' => true,
//        ]
//    );
}
add_action('elementor/theme/register_locations', 'cdv_register_elementor_locations');
