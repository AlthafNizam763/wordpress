<?php
/**
 * Race Support CMS API Client
 *
 * Handles authenticated server-to-server HTTP requests to Race Support CMS.
 *
 * @package RaceSupportMediaIntegration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Race_CMS_API_Client
{
    private $base_url;
    private $api_key;
    private $timeout = 15;
    private $cache_ttl = 300; // 5 minutes

    public function __construct($base_url = null, $api_key = null)
    {
        $settings = get_option('race_cms_settings', array());

        $this->base_url = !empty($base_url) 
            ? untrailingslashit($base_url) 
            : untrailingslashit(!empty($settings['api_base_url']) ? $settings['api_base_url'] : 'http://localhost:3001');

        $this->api_key = !empty($api_key) 
            ? $api_key 
            : (!empty($settings['api_key']) ? $settings['api_key'] : '');
    }

    /**
     * Get configured request headers
     */
    private function get_headers()
    {
        $headers = array(
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent'   => 'WordPress-RaceCMS-Integration/' . RACE_CMS_VERSION,
        );

        if (!empty($this->api_key)) {
            $headers['x-cms-api-key'] = $this->api_key;
            $headers['Authorization'] = 'Bearer ' . $this->api_key;
        }

        return $headers;
    }

    /**
     * Execute HTTP request with safety checks
     */
    private function request($endpoint, $args = array())
    {
        if (empty($this->base_url)) {
            return new WP_Error('missing_base_url', __('CMS API Base URL is not configured.', 'race-cms-media'));
        }

        $url = $this->base_url . '/' . ltrim($endpoint, '/');

        $defaults = array(
            'method'    => 'GET',
            'timeout'   => $this->timeout,
            'headers'   => $this->get_headers(),
            'sslverify' => !preg_match('/localhost|127\.0\.0\.1/', $this->base_url),
        );

        $parsed_args = wp_parse_args($args, $defaults);
        $response = wp_remote_request($url, $parsed_args);

        if (is_wp_error($response)) {
            return $response;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($status_code >= 400) {
            $message = !empty($data['message']) 
                ? $data['message'] 
                : sprintf(__('CMS API responded with HTTP %d.', 'race-cms-media'), $status_code);

            return new WP_Error('http_' . $status_code, $message, array('status' => $status_code, 'body' => $data));
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            return new WP_Error('invalid_json', __('Invalid JSON response from CMS API.', 'race-cms-media'));
        }

        return $data;
    }

    /**
     * Health check to test connectivity and authentication
     */
    public function check_health()
    {
        $start_time = microtime(true);
        $response = $this->request('/api/integration/health');
        $latency = round((microtime(true) - $start_time) * 1000, 2);

        if (is_wp_error($response)) {
            // Fallback: test /api/media directly if /api/integration/health is unavailable
            $fallback = $this->request('/api/media?limit=1');
            $latency = round((microtime(true) - $start_time) * 1000, 2);

            if (is_wp_error($fallback)) {
                return array(
                    'ok'         => false,
                    'message'    => $fallback->get_error_message(),
                    'status'     => $fallback->get_error_code(),
                    'latency_ms' => $latency,
                );
            }

            return array(
                'ok'         => true,
                'message'    => __('Connected to CMS Media API successfully.', 'race-cms-media'),
                'data'       => $fallback['data'] ?? array(),
                'latency_ms' => $latency,
            );
        }

        return array(
            'ok'         => !empty($response['success']),
            'message'    => $response['message'] ?? __('Connected successfully.', 'race-cms-media'),
            'data'       => $response['data'] ?? array(),
            'latency_ms' => $latency,
        );
    }

    /**
     * Retrieve paginated media items
     *
     * @param array $params Query parameters: page, limit, mediaType, search, folder, fileId, bypass_cache
     * @return array|WP_Error
     */
    public function get_media($params = array())
    {
        $page         = max(1, intval($params['page'] ?? 1));
        $limit        = min(100, max(1, intval($params['limit'] ?? 20)));
        $media_type   = sanitize_text_field($params['mediaType'] ?? '');
        $search       = sanitize_text_field($params['search'] ?? '');
        $folder       = sanitize_text_field($params['folder'] ?? '');
        $file_id      = sanitize_text_field($params['fileId'] ?? '');
        $bypass_cache = !empty($params['bypass_cache']);

        $query_args = array(
            'page'  => $page,
            'limit' => $limit,
        );

        if (!empty($media_type) && in_array($media_type, array('image', 'video'), true)) {
            $query_args['mediaType'] = $media_type;
        }

        if (!empty($search)) {
            $query_args['search'] = $search;
        }

        if (!empty($folder)) {
            $query_args['folder'] = $folder;
        }

        if (!empty($file_id)) {
            $query_args['fileId'] = $file_id;
        }

        $cache_key = 'race_cms_media_' . md5(serialize($query_args) . $this->base_url);

        if (!$bypass_cache && empty($search) && empty($file_id)) {
            $cached = get_transient($cache_key);
            if (false !== $cached) {
                return $cached;
            }
        }

        $endpoint = '/api/media?' . http_build_query($query_args);
        $result = $this->request($endpoint);

        if (is_wp_error($result)) {
            return $result;
        }

        $payload = !empty($result['data']) ? $result['data'] : array(
            'items'      => array(),
            'pagination' => array(
                'page'       => $page,
                'limit'      => $limit,
                'total'      => 0,
                'totalPages' => 1,
                'hasMore'    => false,
            ),
        );

        if (!$bypass_cache && empty($search) && empty($file_id)) {
            set_transient($cache_key, $payload, $this->cache_ttl);
        }

        return $payload;
    }

    /**
     * Retrieve single media asset by document ID
     */
    public function get_single_media($id)
    {
        $sanitized_id = sanitize_text_field($id);
        if (empty($sanitized_id)) {
            return new WP_Error('invalid_id', __('Media ID cannot be empty.', 'race-cms-media'));
        }

        $result = $this->request('/api/media/' . rawurlencode($sanitized_id));
        if (is_wp_error($result)) {
            return $result;
        }

        return !empty($result['data']) ? $result['data'] : null;
    }

    /**
     * Clear all cached media queries
     */
    public function clear_cache()
    {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_race_cms_media_%' OR option_name LIKE '_transient_timeout_race_cms_media_%'");
    }
}
