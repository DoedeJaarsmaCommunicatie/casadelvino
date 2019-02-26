<?php


class CasaElementor
{
    const VERSION = '1.0.0';
    
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    
    const MINIMUM_PHP_VERSION = '7.2';
    
    private static $_instance = null;
    
    public static function instance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
        
        add_action('elementor/elements/categories_registered', [$this, 'addElementorWidgetCategories']);
    }
    
    public function init()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'adminNoticeMissingMainPlugin']);
            return;
        }
        
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'adminNoticeMinimumElementorVersion']);
            return;
        }
        
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }
        
        add_action('elementor/widgets/widgets_registered', [$this, 'initWidgets']);
    }
    
    public function includes()
    {
    }
    
    /** @noinspection PhpMethodMayBeStaticInspection */
    public function adminNoticeMissingMainPlugin(): void
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'cdv'),
            '<strong>' . esc_html__('Casadelvino Elementor', 'cdv') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'cdv') . '</strong>'
        );
        
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    
    /** @noinspection PhpMethodMayBeStaticInspection */
    public function adminNoticeMinimumElementorVersion(): void
    {
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'cdv'),
            '<strong>' . esc_html__('Casadelvino Elementor', 'cdv') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'cdv') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    
    /** @noinspection PhpMethodMayBeStaticInspection */
    public function adminNoticeMinimumPhpVersion()
    {
        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'cdv'),
            '<strong>' . esc_html__('Casadelvino Elementor', 'cdv') . '</strong>',
            '<strong>' . esc_html__('PHP', 'cdv') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    
    public function initWidgets()
    {
        $djcee_error = function ($message, $subtitle = '', $title = '') {
            $title = $title ?: __('Casadelvino Elementor &rsaquo; Error', 'cdv');
            $footer = '<a href="https://doedejaarsma.nl/contact">doedejaarsma/contact</a>';
            $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
            wp_die($message, $title);
        };
        
        array_map(
            function ($file) use ($djcee_error) {
                $file = get_stylesheet_directory() . "/app/Elementor/Widgets/{$file}.php";
                require_once $file;
            
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $file());
            },
            [
                'CasaProductsMonthly',
            ]
        );
    }
    
    public function addElementorWidgetCategories(\Elementor\Elements_Manager $elements_manager): void
    {
        $elements_manager->add_category(
            'cdv',
            [
                'title'     => __('Casa Del Vino', 'cdv'),
                'icon'      => 'fa fa-plug',
            ]
        );
    }
}
