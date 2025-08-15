<?php
class DevTI_Banner_Admin {
    private static $instance = null;
    private $options_page;

    private function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'settings_init']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function add_admin_menu() {
        $this->options_page = add_options_page(
            __('DevTI Banner Settings', 'devti-banner'),
            __('DevTI Banner', 'devti-banner'),
            'manage_options',
            'devti-banner',
            [$this, 'options_page_html']
        );
    }

    public function enqueue_admin_assets($hook) {
        if ($hook !== $this->options_page) {
            return;
        }

        wp_enqueue_media();
        
        wp_enqueue_style(
            'devti-banner-admin',
            DEVTIBANNER_PLUGIN_URL . 'assets/css/devti-banner-admin.css',
            [],
            DEVTIBANNER_VERSION
        );

        wp_enqueue_script(
            'devti-banner-admin',
            DEVTIBANNER_PLUGIN_URL . 'assets/js/devti-banner-admin.js',
            ['jquery'],
            DEVTIBANNER_VERSION,
            true
        );
    }

    public function settings_init() {
        register_setting('devti-banner', 'devti_banner_options', [
            'sanitize_callback' => [$this, 'sanitize_options']
        ]);

        add_settings_section(
            'devti_banner_main_section',
            __('Configurações do Banner', 'devti-banner'),
            [$this, 'main_section_html'],
            'devti-banner'
        );

        add_settings_field(
            'banner_count',
            __('Quantidade de Banners', 'devti-banner'),
            [$this, 'banner_count_html'],
            'devti-banner',
            'devti_banner_main_section'
        );

        add_settings_field(
            'banner_size',
            __('Tamanho do Banner', 'devti-banner'),
            [$this, 'banner_size_html'],
            'devti-banner',
            'devti_banner_main_section'
        );

        add_settings_field(
            'banner_delay',
            __('Delay entre banners (ms)', 'devti-banner'),
            [$this, 'banner_delay_html'],
            'devti-banner',
            'devti_banner_main_section'
        );

        add_settings_field(
            'banner_images',
            __('Banners', 'devti-banner'),
            [$this, 'banner_images_html'],
            'devti-banner',
            'devti_banner_main_section'
        );
    }

    public function sanitize_options($input) {
        $output = [];
        $old_options = get_option('devti_banner_options');
        
        // Sanitizar quantidade de banners
        $output['banner_count'] = absint($input['banner_count'] ?? 3);
        if ($output['banner_count'] < 1) $output['banner_count'] = 1;
        if ($output['banner_count'] > 10) $output['banner_count'] = 10;
        
        // Sanitizar tamanhos
        $output['banner_height'] = sanitize_text_field($input['banner_height'] ?? '50px');
        $output['banner_width'] = sanitize_text_field($input['banner_width'] ?? '1024px');
        
        // Sanitizar delay
        $output['banner_delay'] = absint($input['banner_delay'] ?? 3000);
        if ($output['banner_delay'] < 500) $output['banner_delay'] = 500;
        
        // Sanitizar links e imagens
        $output['banner_links'] = [];
        $output['banner_images'] = [];
        
        for ($i = 0; $i < $output['banner_count']; $i++) {
            $output['banner_links'][$i] = esc_url_raw($input['banner_links'][$i] ?? '');
            $output['banner_images'][$i] = esc_url_raw($input['banner_images'][$i] ?? '');
        }
        
        return $output;
    }

    public function main_section_html() {
        echo '<p>' . esc_html__('Configure os banners que serão exibidos no carrossel.', 'devti-banner') . '</p>';
    }

    public function banner_count_html() {
        $options = get_option('devti_banner_options');
        $count = $options['banner_count'] ?? 3;
        ?>
        <input type="number" min="1" max="10" name="devti_banner_options[banner_count]" value="<?php echo esc_attr($count); ?>">
        <?php
    }

    public function banner_size_html() {
        $options = get_option('devti_banner_options');
        ?>
        <label>
            <?php esc_html_e('Largura:', 'devti-banner'); ?>
            <input type="text" name="devti_banner_options[banner_width]" value="<?php echo esc_attr($options['banner_width'] ?? '1024px'); ?>">
        </label>
        <label>
            <?php esc_html_e('Altura:', 'devti-banner'); ?>
            <input type="text" name="devti_banner_options[banner_height]" value="<?php echo esc_attr($options['banner_height'] ?? '50px'); ?>">
        </label>
        <?php
    }

    public function banner_delay_html() {
        $options = get_option('devti_banner_options');
        ?>
        <input type="number" min="500" step="100" name="devti_banner_options[banner_delay]" value="<?php echo esc_attr($options['banner_delay'] ?? 3000); ?>">
        <span><?php esc_html_e('milissegundos', 'devti-banner'); ?></span>
        <?php
    }

    public function banner_images_html() {
        $options = get_option('devti_banner_options');
        $count = $options['banner_count'] ?? 3;
        
        for ($i = 0; $i < $count; $i++) {
            $image_url = $options['banner_images'][$i] ?? '';
            $link_url = $options['banner_links'][$i] ?? '';
            ?>
            <div class="devti-banner-item">
                <h4><?php echo esc_html(sprintf(__('Banner %d', 'devti-banner'), $i + 1)); ?></h4>
                
                <div class="devti-banner-image-preview" style="<?php echo $image_url ? 'display:block;' : 'display:none;'; ?>">
                    <img src="<?php echo esc_url($image_url); ?>" style="max-height: 100px;">
                </div>
                
                <input type="hidden" class="devti-banner-image-url" name="devti_banner_options[banner_images][<?php echo $i; ?>]" value="<?php echo esc_url($image_url); ?>">
                <button type="button" class="button devti-banner-upload-image" data-index="<?php echo $i; ?>">
                    <?php esc_html_e('Selecionar Imagem', 'devti-banner'); ?>
                </button>
                <button type="button" class="button devti-banner-remove-image" data-index="<?php echo $i; ?>" style="<?php echo $image_url ? 'display:inline-block;' : 'display:none;'; ?>">
                    <?php esc_html_e('Remover Imagem', 'devti-banner'); ?>
                </button>
                
                <label>
                    <?php esc_html_e('Link:', 'devti-banner'); ?>
                    <input type="url" class="regular-text" name="devti_banner_options[banner_links][<?php echo $i; ?>]" value="<?php echo esc_url($link_url); ?>">
                </label>
            </div>
            <?php
        }
    }

    public function options_page_html() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        if (isset($_GET['settings-updated'])) {
            add_settings_error('devti_banner_messages', 'devti_banner_message', __('Configurações salvas.', 'devti-banner'), 'updated');
        }
        
        settings_errors('devti_banner_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <form action="options.php" method="post">
                <?php
                settings_fields('devti-banner');
                do_settings_sections('devti-banner');
                submit_button(__('Salvar Configurações', 'devti-banner'));
                ?>
            </form>
        </div>
        <?php
    }
}