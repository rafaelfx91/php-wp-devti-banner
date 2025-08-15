<?php
/**
 * Plugin Name: DevTI Banner
 * Plugin URI: https://seusite.com/devti-banner
 * Description: Plugin para exibição de banners responsivos em carrossel
 * Version: 1.0.0
 * Author: Seu Nome
 * Author URI: https://seusite.com
 * Text Domain: devti-banner
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 8.0
 * License: GPLv2 or later
 */

defined('ABSPATH') || exit;

// Defina constantes do plugin
define('DEVTIBANNER_VERSION', '1.0.0');
define('DEVTIBANNER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DEVTIBANNER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Verificar dependências
if (!version_compare(PHP_VERSION, '8.0', '>=')) {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>';
        esc_html_e('DevTI Banner requer PHP versão 8.0 ou superior. Sua versão atual é ' . PHP_VERSION . '. Por favor, atualize seu PHP.', 'devti-banner');
        echo '</p></div>';
    });
    return;
}

// Carregar classes principais
require_once DEVTIBANNER_PLUGIN_DIR . 'includes/class-devti-banner.php';
require_once DEVTIBANNER_PLUGIN_DIR . 'includes/class-devti-banner-admin.php';
require_once DEVTIBANNER_PLUGIN_DIR . 'includes/class-devti-banner-shortcode.php';

// Inicializar o plugin
function devti_banner_init() {
    $main = DevTI_Banner::get_instance();
    $admin = DevTI_Banner_Admin::get_instance();
    $shortcode = DevTI_Banner_Shortcode::get_instance();
    
    // Carregar traduções
    load_plugin_textdomain('devti-banner', false, basename(dirname(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'devti_banner_init');

// Ativação do plugin
register_activation_hook(__FILE__, ['DevTI_Banner', 'activate']);

// Desativação do plugin
register_deactivation_hook(__FILE__, ['DevTI_Banner', 'deactivate']);