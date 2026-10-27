<?php
/**
 * Plugin Name: Race Support CMS Media Integration
 * Plugin URI:  https://raceindia.org
 * Description: Connects WordPress with the Race Support CMS media system. Supports external ImageKit CDN URL delivery (Mode A) and native WordPress Media Library import (Mode B) with Firebase Firestore synchronization.
 * Version:     1.0.0
 * Author:      Race Support Team
 * Author URI:  https://raceindia.org
 * License:     GPL-2.0+
 * Text Domain: race-cms-media
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RACE_CMS_VERSION', '1.0.0');
define('RACE_CMS_PLUGIN_FILE', __FILE__);
define('RACE_CMS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RACE_CMS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Require Core Integration Classes
require_once RACE_CMS_PLUGIN_DIR . 'includes/class-race-cms-api-client.php';
require_once RACE_CMS_PLUGIN_DIR . 'includes/class-race-media-importer.php';
require_once RACE_CMS_PLUGIN_DIR . 'includes/class-race-admin-settings.php';
require_once RACE_CMS_PLUGIN_DIR . 'includes/class-race-media-picker.php';
require_once RACE_CMS_PLUGIN_DIR . 'includes/class-race-frontend.php';
require_once RACE_CMS_PLUGIN_DIR . 'includes/class-race-rest-controller.php';

/**
 * Main plugin bootstrap
 */
class Race_Support_CMS_Media_Plugin
{
    private static $instance = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links'));

        // Initialize sub-controllers
        new Race_Admin_Settings();
        new Race_Media_Picker();
        new Race_Frontend();
        new Race_REST_Controller();
    }

    /**
     * Enqueue Admin scripts and styles
     */
    public function enqueue_admin_assets($hook)
    {
        $allowed_hooks = array(
            'settings_page_race-support-cms-media',
            'media_page_race-cms-media',
            'post.php',
            'post-new.php',
            'upload.php',
        );

        if (!in_array($hook, $allowed_hooks, true)) {
            return;
        }

        wp_enqueue_style(
            'race-cms-admin-css',
            RACE_CMS_PLUGIN_URL . 'assets/css/admin.css',
            array('dashicons'),
            RACE_CMS_VERSION
        );

        wp_enqueue_script(
            'race-cms-admin-js',
            RACE_CMS_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            RACE_CMS_VERSION,
            true
        );

        $settings = Race_Admin_Settings::get_settings();

        wp_localize_script('race-cms-admin-js', 'raceCmsData', array(
            'ajaxurl'      => admin_url('admin-ajax.php'),
            'nonce'        => wp_create_nonce('race_cms_admin_nonce'),
            'pluginUrl'    => RACE_CMS_PLUGIN_URL,
            'deliveryMode' => $settings['delivery_mode'],
            'apiBaseUrl'   => $settings['api_base_url'],
        ));
    }

    /**
     * Add quick settings link on Plugins page
     */
    public function add_action_links($links)
    {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            esc_url(admin_url('options-general.php?page=race-support-cms-media')),
            __('Settings', 'race-cms-media')
        );
        array_unshift($links, $settings_link);
        return $links;
    }
}

// Activation hook
register_activation_hook(__FILE__, function () {
    $current = get_option(Race_Admin_Settings::OPTION_NAME);
    if (false === $current) {
        update_option(Race_Admin_Settings::OPTION_NAME, Race_Admin_Settings::get_defaults());
    }
});

// Deactivation hook
register_deactivation_hook(__FILE__, function () {
    // Clear transients
    $client = new Race_CMS_API_Client();
    $client->clear_cache();
});

// Initialize plugin
add_action('plugins_loaded', function () {
    Race_Support_CMS_Media_Plugin::get_instance();
});
