<?php
namespace App\Customizer;

use App\Customizer\GeneralInformation;

class Customizer
{
    public function __construct()
    {
        $generalInformation = new GeneralInformation();
	    add_action('customize_register', [$generalInformation, 'instance']);
    }
}
