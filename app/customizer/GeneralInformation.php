<?php
namespace App\Customizer;

class GeneralInformation
{
    /**
     * @var \WP_Customize_Manager
     */
    private $wp_customize;
    
    /**
     * @SuppressWarnings(PHPMD)
     * @param $wp_customize
     */
    public function instance($wp_customize): void
    {
        $this->wp_customize = $wp_customize;
        $this->main();
    }
    
    protected function main(): void
    {
        $this->addSections();
        $this->addSettings();
        $this->addControls();
    }
    
    protected function addSections(): void
    {
        $this->wp_customize->add_section('cdv_general_information', [
            'title'     => __('Algemene informatie', 'casadelvino'),
            'priority'  => 30,
        ]);
    }
    
    protected function addSettings(): void
    {
        $this->wp_customize->add_setting('header_telephone', [
            'default'   => '020-2614758',
            'transport' => 'refresh',
        ]);
        $this->wp_customize->add_setting('phone_linked', [
            'default'   => false,
            'transport' => 'refresh',
        ]);
    }
    
    protected function addControls(): void
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
        $this->wp_customize->add_control(
            new \WP_Customize_Control(
                $this->wp_customize,
                'phone_linked',
                [
                    'label'     => __('Telefoonnummer als link'),
                    'section'   => 'cdv_general_information',
                    'settings'  => 'phone_linked',
                    'type'      => 'checkbox',
                ]
            )
        );
    }
}
