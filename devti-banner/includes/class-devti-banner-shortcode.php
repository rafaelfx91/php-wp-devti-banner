<?php
class DevTI_Banner_Shortcode {
    private static $instance = null;
    private $main;

    private function __construct() {
        $this->main = DevTI_Banner::get_instance();
        
        add_shortcode('devti-banner', [$this, 'render_shortcode']);
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function render_shortcode($atts) {
        $atts = shortcode_atts([
            'class' => ''
        ], $atts, 'devti-banner');

        $banners = $this->main->get_banners();
        if (empty($banners)) {
            return '';
        }

        $options = get_option('devti_banner_options');
        $style = sprintf(
            'max-width: %s; height: %s;',
            esc_attr($options['banner_width'] ?? '1024px'),
            esc_attr($options['banner_height'] ?? '50px')
        );

        ob_start();
        ?>
        <div class="devti-banner-container <?php echo esc_attr($atts['class']); ?>" style="<?php echo $style; ?>">
            <?php foreach ($banners as $banner): ?>
                <?php if ($banner['image']): ?>
                    <div class="devti-banner-slide">
                        <?php if ($banner['link']): ?>
                            <a href="<?php echo esc_url($banner['link']); ?>" target="_blank">
                                <img src="<?php echo esc_url($banner['image']); ?>" alt="" class="devti-banner-image">
                            </a>
                        <?php else: ?>
                            <img src="<?php echo esc_url($banner['image']); ?>" alt="" class="devti-banner-image">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}