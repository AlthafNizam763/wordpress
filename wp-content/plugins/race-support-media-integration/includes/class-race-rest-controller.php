<?php
/**
 * Race Support CMS WordPress REST API Controller
 *
 * Exposes secure REST endpoints for CMS health checks, catalogue browsing,
 * and asset imports.
 *
 * @package RaceSupportMediaIntegration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Race_REST_Controller extends WP_REST_Controller
{
    protected $namespace = 'race-cms/v1';

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes()
    {
        // GET /wp-json/race-cms/v1/health
        register_rest_route($this->namespace, '/health', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_health'),
                'permission_callback' => array($this, 'admin_permissions_check'),
            ),
        ));

        // GET /wp-json/race-cms/v1/media
        register_rest_route($this->namespace, '/media', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_media_items'),
                'permission_callback' => array($this, 'user_permissions_check'),
                'args'                => array(
                    'page'      => array('default' => 1, 'sanitize_callback' => 'absint'),
                    'limit'     => array('default' => 20, 'sanitize_callback' => 'absint'),
                    'mediaType' => array('sanitize_callback' => 'sanitize_text_field'),
                    'search'    => array('sanitize_callback' => 'sanitize_text_field'),
                    'folder'    => array('sanitize_callback' => 'sanitize_text_field'),
                    'fileId'    => array('sanitize_callback' => 'sanitize_text_field'),
                ),
            ),
        ));

        // GET /wp-json/race-cms/v1/media/(?P<id>[a-zA-Z0-9_-]+)
        register_rest_route($this->namespace, '/media/(?P<id>[a-zA-Z0-9_-]+)', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_single_item'),
                'permission_callback' => array($this, 'user_permissions_check'),
            ),
        ));

        // POST /wp-json/race-cms/v1/import
        register_rest_route($this->namespace, '/import', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array($this, 'import_item'),
                'permission_callback' => array($this, 'user_permissions_check'),
                'args'                => array(
                    'fileId' => array('required' => true, 'sanitize_callback' => 'sanitize_text_field'),
                    'url'    => array('required' => true, 'sanitize_callback' => 'esc_url_raw'),
                    'title'  => array('sanitize_callback' => 'sanitize_text_field'),
                    'mediaType' => array('sanitize_callback' => 'sanitize_text_field'),
                    'postId' => array('default' => 0, 'sanitize_callback' => 'absint'),
                ),
            ),
        ));

        // POST /wp-json/race-cms/v1/sync
        register_rest_route($this->namespace, '/sync', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array($this, 'trigger_sync'),
                'permission_callback' => array($this, 'admin_permissions_check'),
            ),
        ));
    }

    public function admin_permissions_check($request)
    {
        return current_user_can('manage_options');
    }

    public function user_permissions_check($request)
    {
        return current_user_can('upload_files');
    }

    public function get_health($request)
    {
        $client = new Race_CMS_API_Client();
        $health = $client->check_health();

        $settings = Race_Admin_Settings::get_settings();

        return rest_ensure_response(array(
            'wordpress' => array(
                'siteUrl'        => home_url(),
                'version'        => get_bloginfo('version'),
                'deliveryMode'   => $settings['delivery_mode'],
                'lastSync'       => $settings['last_sync_time'] ?: null,
            ),
            'cms'       => $health,
        ));
    }

    public function get_media_items($request)
    {
        $client = new Race_CMS_API_Client();
        $params = array(
            'page'      => $request->get_param('page'),
            'limit'     => $request->get_param('limit'),
            'mediaType' => $request->get_param('mediaType'),
            'search'    => $request->get_param('search'),
            'folder'    => $request->get_param('folder'),
            'fileId'    => $request->get_param('fileId'),
        );

        $result = $client->get_media($params);
        if (is_wp_error($result)) {
            return new WP_Error($result->get_error_code(), $result->get_error_message(), array('status' => 500));
        }

        $items = $result['items'] ?? array();
        foreach ($items as &$item) {
            $existing = Race_Media_Importer::get_imported_attachment($item['fileId']);
            $item['isImported'] = (bool)$existing;
            $item['attachmentId'] = $existing ? $existing->ID : null;
        }

        return rest_ensure_response(array(
            'success'    => true,
            'data'       => $items,
            'pagination' => $result['pagination'] ?? array(),
        ));
    }

    public function get_single_item($request)
    {
        $id = $request->get_param('id');
        $client = new Race_CMS_API_Client();
        $item = $client->get_single_media($id);

        if (is_wp_error($item)) {
            return new WP_Error($item->get_error_code(), $item->get_error_message(), array('status' => 404));
        }

        return rest_ensure_response(array(
            'success' => true,
            'data'    => $item,
        ));
    }

    public function import_item($request)
    {
        $asset = array(
            'fileId'    => $request->get_param('fileId'),
            'url'       => $request->get_param('url'),
            'title'     => $request->get_param('title'),
            'mediaType' => $request->get_param('mediaType') ?: 'image',
        );

        $post_id = $request->get_param('postId');
        $result = Race_Media_Importer::import_asset($asset, $post_id);

        if (is_wp_error($result)) {
            return new WP_Error($result->get_error_code(), $result->get_error_message(), array('status' => 500));
        }

        return rest_ensure_response(array(
            'success' => true,
            'data'    => $result,
        ));
    }

    public function trigger_sync($request)
    {
        $client = new Race_CMS_API_Client();
        $client->clear_cache();
        $result = $client->get_media(array('page' => 1, 'limit' => 50, 'bypass_cache' => true));

        if (is_wp_error($result)) {
            return new WP_Error($result->get_error_code(), $result->get_error_message(), array('status' => 500));
        }

        $settings = Race_Admin_Settings::get_settings();
        $settings['last_sync_time'] = current_time('mysql');
        $settings['connection_status'] = 'connected';
        $settings['last_error'] = '';
        update_option(Race_Admin_Settings::OPTION_NAME, $settings);

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Synchronization completed.', 'race-cms-media'),
            'lastSync' => $settings['last_sync_time'],
            'total' => $result['pagination']['total'] ?? 0,
        ));
    }
}
