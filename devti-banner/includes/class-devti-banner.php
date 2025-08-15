<?php
class DevTI_Banner {
    private static $instance = null;
    private $options;

    private function __construct() {
        $this->options = get_option('devti_banner_options');
        
        // Registrar scripts e estilos
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function activate() {
        // Configurações padrão
        $default_options = [
            'banner_count' => 3,
            'banner_height' => '50px',
            'banner_width' => '1024px',
            'banner_delay' => 3000,
            'banner_links' => array_fill(0, 3, ''),
            'banner_images' => array_fill(0, 3, '')
        ];

        add_option('devti_banner_options', $default_options);
    }

    public static function deactivate() {
        // Limpar opções se necessário
        // delete_option('devti_banner_options');
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'devti-banner-frontend',
            DEVTIBANNER_PLUGIN_URL . 'assets/css/devti-banner-frontend.css',
            [],
            DEVTIBANNER_VERSION
        );

        wp_enqueue_script(
            'slick-carousel',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
            ['jquery'],
            '1.8.1',
            true
        );

        wp_enqueue_style(
            'slick-carousel-css',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
            [],
            '1.8.1'
        );

        wp_enqueue_style(
            'slick-carousel-theme',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
            ['slick-carousel-css'],
            '1.8.1'
        );

        wp_enqueue_script(
            'devti-banner-frontend',
            DEVTIBANNER_PLUGIN_URL . 'assets/js/devti-banner-frontend.js',
            ['jquery', 'slick-carousel'],
            DEVTIBANNER_VERSION,
            true
        );

        // Passar configurações para o JS
        wp_localize_script('devti-banner-frontend', 'devtiBannerSettings', [
            'delay' => isset($this->options['banner_delay']) ? $this->options['banner_delay'] : 3000
        ]);
    }

    public function get_banners() {
        if (empty($this->options['banner_images'])) {
            return [];
        }

        $banners = [];
        for ($i = 0; $i < $this->options['banner_count']; $i++) {
            if (!empty($this->options['banner_images'][$i])) {
                $banners[] = [
                    'image' => $this->options['banner_images'][$i],
                    'link' => $this->options['banner_links'][$i] ?? ''
                ];
            }
        }

        return $banners;
    }
}