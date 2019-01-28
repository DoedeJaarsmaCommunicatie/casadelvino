<?php
namespace App\Customizer;

use App\Customizer\GeneralInformation;

class Customizer
{
    public function __construct()
    {
        add_action('customize_register', [GeneralInformation::class, 'instance']);
    }
}
