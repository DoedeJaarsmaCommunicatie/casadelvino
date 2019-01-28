<?php
namespace App\Customizer;

class GeneralInformation
{
    /**
     * @var \WP_Customize_Manager
     */
    private $wp_customize;
    
    public function instance($wp_customize)
    {
        $this->wp_customize = $wp_customize;
        $this->main();
    }
    
    protected function main()
    {
        $this->addSections();
        $this->addSettings();
    }
    
    protected function addSections()
    {
        $this->wp_customize->add_section('cdv_general_information', [
            'title'     => __('Algemene informatie', 'casadelvino'),
            'priority'  => 30,
        ]);
    }
    
    protected function addSettings()
    {
        $this->wp_customize->add_setting('header_telephone', [
            'default'   => '020-2614758',
            'transport' => 'refresh',
        ]);
    }
    
    protected function addControls()
    {
        $this->wp_customize->add_control(
            new \WP_Customize_Control(
                $this->wp_customize,
                'header_telephone',
                [
                    'label'     => __('Telefoonnummer'),
                    'section'   => 'cdv_general_information',
                    'settings'  => 'header_telephone',
                    'type'      => 'text',
                ]
            )
        );
    }
}
