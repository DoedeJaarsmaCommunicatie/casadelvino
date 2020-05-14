<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2019-01-22
 * Time: 13:25
 */

/**
 * @param $elementor_theme_manager \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager
 *
 * @SuppressWarnings(PHPMD)
 */
function cdv_register_elementor_locations($elementor_theme_manager)
{
    $elementor_theme_manager->register_location('footer');
    $elementor_theme_manager->register_location('single');
    $elementor_theme_manager->register_location(
        'nieuwsbrief-right',
        [
            'label' => __('Nieuwsbrief', 'casadelvino'),
            'multiple' => false,
            'edit_in_content' => true,
        ]
    );
    $elementor_theme_manager->register_location(
        'product-related-image',
        [
            'label' => __('Afbeelding gerelateerd product', 'casadelvino'),
            'multiple' => false,
            'edit_in_content' => true,
        ]
    );
}

add_action('elementor/theme/register_locations', 'cdv_register_elementor_locations');
