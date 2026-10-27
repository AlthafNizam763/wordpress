<?php
/**
 * Race Support CMS Media Admin Settings
 *
 * Implements the Settings -> Race Support CMS Media page with connection diagnostics,
 * synchronization controls, and secure options storage.
 *
 * @package RaceSupportMediaIntegration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Race_Admin_Settings
{
    const OPTION_NAME = 'race_cms_settings';

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_ajax_race_cms_test_connection', array($this, 'ajax_test_connection'));
        add_action('wp_ajax_race_cms_run_sync', array($this, 'ajax_run_sync'));
        add_action('wp_ajax_race_cms_clear_cache', array($this, 'ajax_clear_cache'));
    }

    /**
     * Add settings page under Settings menu
     */
    public function add_settings_page()
    {
        add_options_page(
            __('Race Support CMS Media Settings', 'race-cms-media'),
            __('Race Support CMS Media', 'race-cms-media'),
            'manage_options',
            'race-support-cms-media',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings and sanitize callback
     */
    public function register_settings()
    {
        register_setting('race_cms_settings_group', self::OPTION_NAME, array(
            'sanitize_callback' => array($this, 'sanitize_settings'),
            'default'           => self::get_defaults(),
        ));
    }

    /**
     * Default options
     */
    public static function get_defaults()
    {
        return array(
            'api_base_url'     => 'http://localhost:3001',
            'api_key'          => 'race_cms_sec_bd7a17f3a68f9d90eceea41ca8ac681afde142d91a1124d5',
            'delivery_mode'    => 'external', // 'external' (Mode A) or 'import' (Mode B)
            'default_folder'   => '/admin-media',
            'default_type'     => 'all',
            'auto_sync'        => 0,
            'import_on_demand' => 1,
            'per_page'         => 20,
            'last_sync_time'   => '',
            'last_error'       => '',
            'connection_status'=> 'untested',
        );
    }

    /**
     * Retrieve merged settings
     */
    public static function get_settings()
    {
        $saved = get_option(self::OPTION_NAME, array());
        return wp_parse_args($saved, self::get_defaults());
    }

    /**
     * Sanitize settings on save
     */
    public function sanitize_settings($input)
    {
        $current = self::get_settings();
        $output  = array();

        $output['api_base_url'] = !empty($input['api_base_url']) 
            ? untrailingslashit(esc_url_raw(trim($input['api_base_url']))) 
            : $current['api_base_url'];

        // If a new key was entered, save it; if masked, keep current
        if (!empty($input['api_key']) && strpos($input['api_key'], '••••') === false) {
            $output['api_key'] = sanitize_text_field(trim($input['api_key']));
        } else {
            $output['api_key'] = $current['api_key'];
        }

        $output['delivery_mode']    = in_array($input['delivery_mode'] ?? '', array('external', 'import'), true) ? $input['delivery_mode'] : 'external';
        $output['default_folder']   = sanitize_text_field($input['default_folder'] ?? '/admin-media');
        $output['default_type']     = in_array($input['default_type'] ?? '', array('all', 'image', 'video'), true) ? $input['default_type'] : 'all';
        $output['auto_sync']        = !empty($input['auto_sync']) ? 1 : 0;
        $output['import_on_demand'] = !empty($input['import_on_demand']) ? 1 : 0;
        $output['per_page']         = min(100, max(10, intval($input['per_page'] ?? 20)));

        // Preserve system status fields
        $output['last_sync_time']    = $current['last_sync_time'];
        $output['last_error']        = $current['last_error'];
        $output['connection_status'] = $current['connection_status'];

        add_settings_error('race_cms_messages', 'race_cms_message', __('Settings saved successfully.', 'race-cms-media'), 'updated');

        return $output;
    }

    /**
     * AJAX handler to test connection
     */
    public function ajax_test_connection()
    {
        check_ajax_referer('race_cms_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized access.', 'race-cms-media')), 403);
        }

        $base_url = !empty($_POST['api_base_url']) ? esc_url_raw(trim($_POST['api_base_url'])) : null;
        $api_key  = !empty($_POST['api_key']) && strpos($_POST['api_key'], '••••') === false ? sanitize_text_field(trim($_POST['api_key'])) : null;

        $client = new Race_CMS_API_Client($base_url, $api_key);
        $health = $client->check_health();

        $settings = self::get_settings();
        if ($health['ok']) {
            $settings['connection_status'] = 'connected';
            $settings['last_error']        = '';
            update_option(self::OPTION_NAME, $settings);
            wp_send_json_success($health);
        } else {
            $settings['connection_status'] = 'failed';
            $settings['last_error']        = $health['message'];
            update_option(self::OPTION_NAME, $settings);
            wp_send_json_error($health);
        }
    }

    /**
     * AJAX handler to run manual synchronization
     */
    public function ajax_run_sync()
    {
        check_ajax_referer('race_cms_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized access.', 'race-cms-media')), 403);
        }

        $client = new Race_CMS_API_Client();
        $client->clear_cache();

        $result = $client->get_media(array(
            'page'         => 1,
            'limit'        => 50,
            'bypass_cache' => true,
        ));

        $settings = self::get_settings();

        if (is_wp_error($result)) {
            $settings['last_error'] = $result->get_error_message();
            update_option(self::OPTION_NAME, $settings);
            wp_send_json_error(array(
                'message' => sprintf(__('Synchronization failed: %s', 'race-cms-media'), $result->get_error_message()),
            ));
        }

        $items = $result['items'] ?? array();
        $total = $result['pagination']['total'] ?? count($items);

        $settings['last_sync_time']    = current_time('mysql');
        $settings['connection_status'] = 'connected';
        $settings['last_error']        = '';
        update_option(self::OPTION_NAME, $settings);

        wp_send_json_success(array(
            'message'        => sprintf(__('Successfully synchronized %d media items from Race Support CMS.', 'race-cms-media'), $total),
            'count'          => count($items),
            'total'          => $total,
            'last_sync_time' => $settings['last_sync_time'],
        ));
    }

    /**
     * AJAX handler to clear transient media cache
     */
    public function ajax_clear_cache()
    {
        check_ajax_referer('race_cms_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => __('Unauthorized access.', 'race-cms-media')), 403);
        }

        $client = new Race_CMS_API_Client();
        $client->clear_cache();

        wp_send_json_success(array(
            'message' => __('Media catalogue cache cleared successfully.', 'race-cms-media'),
        ));
    }

    /**
     * Render the admin settings page
     */
    public function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = self::get_settings();
        $masked_key = !empty($settings['api_key']) 
            ? str_repeat('•', 20) . substr($settings['api_key'], -6) 
            : '';

        $status_color = $settings['connection_status'] === 'connected' ? '#10b981' : ($settings['connection_status'] === 'failed' ? '#ef4444' : '#f59e0b');
        $status_label = $settings['connection_status'] === 'connected' ? __('Connected', 'race-cms-media') : ($settings['connection_status'] === 'failed' ? __('Failed', 'race-cms-media') : __('Untested', 'race-cms-media'));
        ?>
        <div class="wrap race-cms-settings-wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <p class="description">
                <?php esc_html_e('Connect WordPress with Race Support CMS to retrieve, select, and import media stored in ImageKit and Firebase Firestore.', 'race-cms-media'); ?>
            </p>

            <?php settings_errors(); ?>

            <div class="race-cms-grid">
                <!-- Main Settings Form -->
                <div class="race-cms-card">
                    <form method="post" action="options.php" id="race-cms-settings-form">
                        <?php settings_fields('race_cms_settings_group'); ?>

                        <h2><?php esc_html_e('CMS Connection Settings', 'race-cms-media'); ?></h2>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><label for="api_base_url"><?php esc_html_e('Race Support CMS API Base URL', 'race-cms-media'); ?></label></th>
                                <td>
                                    <input name="<?php echo esc_attr(self::OPTION_NAME); ?>[api_base_url]" type="url" id="api_base_url" value="<?php echo esc_attr($settings['api_base_url']); ?>" class="regular-text" placeholder="http://localhost:3001" required />
                                    <p class="description"><?php esc_html_e('Base URL of the running Next.js CMS (e.g. http://localhost:3001 in development, or https://cms.raceindia.org in production).', 'race-cms-media'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="api_key"><?php esc_html_e('Server-to-Server Integration Key', 'race-cms-media'); ?></label></th>
                                <td>
                                    <input name="<?php echo esc_attr(self::OPTION_NAME); ?>[api_key]" type="text" id="api_key" value="<?php echo esc_attr($masked_key); ?>" class="regular-text" autocomplete="off" />
                                    <button type="button" class="button" id="race-cms-toggle-key-visibility"><?php esc_html_e('Show/Edit Key', 'race-cms-media'); ?></button>
                                    <p class="description"><?php esc_html_e('The secret token configured in RACE_CMS_INTEGRATION_KEY on your CMS backend.', 'race-cms-media'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Connection Test', 'race-cms-media'); ?></th>
                                <td>
                                    <button type="button" class="button button-secondary" id="race-cms-test-conn-btn">
                                        <span class="dashicons dashicons-networking" style="vertical-align: middle;"></span>
                                        <?php esc_html_e('Test Connection Now', 'race-cms-media'); ?>
                                    </button>
                                    <span class="spinner" id="race-cms-conn-spinner" style="float: none;"></span>
                                    <div id="race-cms-conn-result" style="margin-top: 10px;"></div>
                                </td>
                            </tr>
                        </table>

                        <hr />

                        <h2><?php esc_html_e('Media Delivery & Import Options', 'race-cms-media'); ?></h2>
                        <table class="form-table" role="presentation">
                            <tr>
                                <th scope="row"><?php esc_html_e('Media Delivery Mode', 'race-cms-media'); ?></th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" name="<?php echo esc_attr(self::OPTION_NAME); ?>[delivery_mode]" value="external" <?php checked($settings['delivery_mode'], 'external'); ?> />
                                            <strong><?php esc_html_e('Mode A — External ImageKit CDN URLs (Recommended)', 'race-cms-media'); ?></strong>
                                        </label>
                                        <p class="description" style="margin-left: 24px; margin-bottom: 12px;">
                                            <?php esc_html_e('Streams assets directly from ImageKit CDN without duplicating files onto local WordPress disk. Minimizes disk storage and server bandwidth.', 'race-cms-media'); ?>
                                        </p>

                                        <label>
                                            <input type="radio" name="<?php echo esc_attr(self::OPTION_NAME); ?>[delivery_mode]" value="import" <?php checked($settings['delivery_mode'], 'import'); ?> />
                                            <strong><?php esc_html_e('Mode B — WordPress Media Library Import', 'race-cms-media'); ?></strong>
                                        </label>
                                        <p class="description" style="margin-left: 24px;">
                                            <?php esc_html_e('Automatically copies chosen assets into the native WordPress Media Library while preserving provenance metadata.', 'race-cms-media'); ?>
                                        </p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="default_folder"><?php esc_html_e('Default Media Folder', 'race-cms-media'); ?></label></th>
                                <td>
                                    <input name="<?php echo esc_attr(self::OPTION_NAME); ?>[default_folder]" type="text" id="default_folder" value="<?php echo esc_attr($settings['default_folder']); ?>" class="regular-text" placeholder="/admin-media" />
                                    <p class="description"><?php esc_html_e('Default folder namespace in ImageKit / Firestore (leave empty to display all folders).', 'race-cms-media'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="default_type"><?php esc_html_e('Default Media Type Filter', 'race-cms-media'); ?></label></th>
                                <td>
                                    <select name="<?php echo esc_attr(self::OPTION_NAME); ?>[default_type]" id="default_type">
                                        <option value="all" <?php selected($settings['default_type'], 'all'); ?>><?php esc_html_e('All Media (Images & Videos)', 'race-cms-media'); ?></option>
                                        <option value="image" <?php selected($settings['default_type'], 'image'); ?>><?php esc_html_e('Images Only', 'race-cms-media'); ?></option>
                                        <option value="video" <?php selected($settings['default_type'], 'video'); ?>><?php esc_html_e('Videos Only', 'race-cms-media'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="per_page"><?php esc_html_e('Catalogue Items Per Page', 'race-cms-media'); ?></label></th>
                                <td>
                                    <input name="<?php echo esc_attr(self::OPTION_NAME); ?>[per_page]" type="number" id="per_page" min="10" max="100" step="5" value="<?php echo esc_attr($settings['per_page']); ?>" class="small-text" />
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Import on Demand', 'race-cms-media'); ?></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="<?php echo esc_attr(self::OPTION_NAME); ?>[import_on_demand]" value="1" <?php checked($settings['import_on_demand'], 1); ?> />
                                        <?php esc_html_e('Show an "Import to WP Media Library" button on individual items in the media picker.', 'race-cms-media'); ?>
                                    </label>
                                </td>
                            </tr>
                        </table>

                        <?php submit_button(__('Save Settings', 'race-cms-media')); ?>
                    </form>
                </div>

                <!-- Status & Operations Sidebar -->
                <div class="race-cms-sidebar">
                    <div class="race-cms-card">
                        <h2><?php esc_html_e('Connection Status', 'race-cms-media'); ?></h2>
                        <div class="race-cms-status-badge" style="background-color: <?php echo esc_attr($status_color); ?>;">
                            <?php echo esc_html($status_label); ?>
                        </div>

                        <ul class="race-cms-meta-list" style="margin-top: 15px;">
                            <li><strong><?php esc_html_e('WordPress Site URL:', 'race-cms-media'); ?></strong> <code><?php echo esc_html(home_url()); ?></code></li>
                            <li><strong><?php esc_html_e('Configured CMS URL:', 'race-cms-media'); ?></strong> <code><?php echo esc_html($settings['api_base_url']); ?></code></li>
                            <li><strong><?php esc_html_e('Last Sync:', 'race-cms-media'); ?></strong> <span id="race-cms-last-sync"><?php echo esc_html($settings['last_sync_time'] ?: __('Never', 'race-cms-media')); ?></span></li>
                            <?php if (!empty($settings['last_error'])): ?>
                                <li class="race-cms-error-meta"><strong><?php esc_html_e('Last Error:', 'race-cms-media'); ?></strong> <?php echo esc_html($settings['last_error']); ?></li>
                            <?php endif; ?>
                        </ul>

                        <div class="race-cms-actions" style="margin-top: 20px;">
                            <button type="button" class="button button-primary" id="race-cms-sync-btn" style="width: 100%; margin-bottom: 8px;">
                                <span class="dashicons dashicons-update" style="vertical-align: middle;"></span>
                                <?php esc_html_e('Sync Media Catalogue Now', 'race-cms-media'); ?>
                            </button>
                            <button type="button" class="button" id="race-cms-clear-cache-btn" style="width: 100%;">
                                <?php esc_html_e('Clear Cache', 'race-cms-media'); ?>
                            </button>
                            <span class="spinner" id="race-cms-sync-spinner" style="float: none; margin-top: 8px;"></span>
                            <div id="race-cms-sync-result" style="margin-top: 10px;"></div>
                        </div>
                    </div>

                    <div class="race-cms-card" style="margin-top: 20px;">
                        <h2><?php esc_html_e('System Diagnostics', 'race-cms-media'); ?></h2>
                        <ul class="race-cms-meta-list">
                            <li><strong><?php esc_html_e('PHP Version:', 'race-cms-media'); ?></strong> <?php echo esc_html(phpversion()); ?></li>
                            <li><strong><?php esc_html_e('cURL Enabled:', 'race-cms-media'); ?></strong> <?php echo function_exists('curl_version') ? 'Yes' : 'No'; ?></li>
                            <li><strong><?php esc_html_e('Fileinfo Extension:', 'race-cms-media'); ?></strong> <?php echo extension_loaded('fileinfo') ? 'Yes' : 'No'; ?></li>
                            <li><strong><?php esc_html_e('Max Upload Size:', 'race-cms-media'); ?></strong> <?php echo esc_html(size_format(wp_max_upload_size())); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
