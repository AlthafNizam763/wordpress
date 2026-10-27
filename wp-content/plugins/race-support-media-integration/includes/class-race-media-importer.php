<?php
/**
 * Race Support Media Importer
 *
 * Securely imports ImageKit assets into the native WordPress Media Library.
 * Enforces SSRF protection, duplicate checks, MIME validation, and idempotent writes.
 *
 * @package RaceSupportMediaIntegration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Race_Media_Importer
{
    const MAX_IMAGE_SIZE = 26214400;  // 25 MB
    const MAX_VIDEO_SIZE = 104857600; // 100 MB

    private static $allowed_image_mimes = array(
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    );

    private static $allowed_video_mimes = array(
        'video/mp4'  => 'mp4',
        'video/webm' => 'webm',
    );

    /**
     * Check if asset was already imported by fileId
     */
    public static function get_imported_attachment($file_id)
    {
        if (empty($file_id)) {
            return false;
        }

        $query = new WP_Query(array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'posts_per_page' => 1,
            'meta_query'     => array(
                array(
                    'key'     => '_race_cms_file_id',
                    'value'   => sanitize_text_field($file_id),
                    'compare' => '=',
                ),
            ),
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
        ));

        if ($query->have_posts()) {
            return $query->posts[0];
        }

        return false;
    }

    /**
     * Validate source URL for SSRF protection
     */
    public static function validate_imagekit_url($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return new WP_Error('invalid_url', __('Invalid media URL provided.', 'race-cms-media'));
        }

        $parsed = parse_url($url);
        $scheme = $parsed['scheme'] ?? '';
        $host   = strtolower($parsed['host'] ?? '');

        // Only allow HTTPS or HTTP (local development)
        if (!in_array($scheme, array('http', 'https'), true)) {
            return new WP_Error('invalid_scheme', __('Unsupported URL scheme.', 'race-cms-media'));
        }

        // Verify ImageKit domain or configured CDN host
        $is_imagekit = ($host === 'ik.imagekit.io' || str_ends_with($host, '.imagekit.io'));
        $is_local_dev = in_array($host, array('localhost', '127.0.0.1'), true);

        if (!$is_imagekit && !$is_local_dev) {
            return new WP_Error(
                'untrusted_domain',
                sprintf(__('Media URL domain "%s" is not an authorized ImageKit CDN endpoint.', 'race-cms-media'), esc_html($host))
            );
        }

        return true;
    }

    /**
     * Import an asset into the WordPress Media Library
     *
     * @param array $asset Metadata array: fileId, url, title, fileName, mediaType, mimeType, size
     * @param int   $post_id Optional post ID to attach the media to
     * @return array|WP_Error
     */
    public static function import_asset($asset, $post_id = 0)
    {
        if (!current_user_can('upload_files')) {
            return new WP_Error('forbidden', __('Permission denied. You cannot upload files.', 'race-cms-media'));
        }

        $file_id    = sanitize_text_field($asset['fileId'] ?? '');
        $source_url = esc_url_raw($asset['url'] ?? '');
        $title      = sanitize_text_field($asset['title'] ?? '');
        $file_name  = sanitize_file_name($asset['fileName'] ?? basename(parse_url($source_url, PHP_URL_PATH)));
        $media_type = sanitize_text_field($asset['mediaType'] ?? 'image');

        if (empty($source_url)) {
            return new WP_Error('missing_url', __('Missing media source URL.', 'race-cms-media'));
        }

        // 1. SSRF URL validation
        $valid_url = self::validate_imagekit_url($source_url);
        if (is_wp_error($valid_url)) {
            return $valid_url;
        }

        // 2. Idempotency Check: Return existing attachment if already imported
        if (!empty($file_id)) {
            $existing = self::get_imported_attachment($file_id);
            if ($existing) {
                return array(
                    'already_existed' => true,
                    'attachment_id'   => $existing->ID,
                    'url'             => wp_get_attachment_url($existing->ID),
                    'thumbnail_url'   => wp_get_attachment_image_url($existing->ID, 'thumbnail') ?: wp_get_attachment_url($existing->ID),
                    'title'           => $existing->post_title,
                    'file_id'         => $file_id,
                    'media_type'      => $media_type,
                );
            }
        }

        // 3. Download the asset safely to temporary location
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $temp_file = download_url($source_url, 30);
        if (is_wp_error($temp_file)) {
            return new WP_Error('download_failed', sprintf(__('Failed to download media asset: %s', 'race-cms-media'), $temp_file->get_error_message()));
        }

        // 4. File Size & MIME Verification
        $file_size = filesize($temp_file);
        if ($file_size <= 0) {
            @unlink($temp_file);
            return new WP_Error('empty_file', __('Downloaded file is empty (0 bytes).', 'race-cms-media'));
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $real_mime = finfo_file($finfo, $temp_file);
        finfo_close($finfo);

        $is_image = array_key_exists($real_mime, self::$allowed_image_mimes);
        $is_video = array_key_exists($real_mime, self::$allowed_video_mimes);

        if (!$is_image && !$is_video) {
            @unlink($temp_file);
            return new WP_Error('unsupported_mime', sprintf(__('File MIME type "%s" is not permitted. Only standard web images and videos are allowed.', 'race-cms-media'), esc_html($real_mime)));
        }

        if ($is_image && $file_size > self::MAX_IMAGE_SIZE) {
            @unlink($temp_file);
            return new WP_Error('image_too_large', __('Image exceeds maximum permitted size of 25 MB.', 'race-cms-media'));
        }

        if ($is_video && $file_size > self::MAX_VIDEO_SIZE) {
            @unlink($temp_file);
            return new WP_Error('video_too_large', __('Video exceeds maximum permitted size of 100 MB.', 'race-cms-media'));
        }

        // Prepare proper extension and filename
        $ext = $is_image ? self::$allowed_image_mimes[$real_mime] : self::$allowed_video_mimes[$real_mime];
        if (empty(pathinfo($file_name, PATHINFO_EXTENSION))) {
            $file_name .= '.' . $ext;
        }

        $file_array = array(
            'name'     => $file_name,
            'tmp_name' => $temp_file,
        );

        // 5. Sideload file into WordPress uploads directory
        $post_data = array(
            'post_title'   => !empty($title) ? $title : pathinfo($file_name, PATHINFO_FILENAME),
            'post_content' => '',
            'post_excerpt' => '',
            'post_status'  => 'inherit',
        );

        $attachment_id = media_handle_sideload($file_array, $post_id, $title, $post_data);

        // Clean up temp file if sideload failed
        if (is_wp_error($attachment_id)) {
            @unlink($temp_file);
            return $attachment_id;
        }

        // 6. Record source identifiers and provenance metadata
        update_post_meta($attachment_id, '_race_cms_file_id', $file_id);
        update_post_meta($attachment_id, '_race_cms_source_url', $source_url);
        update_post_meta($attachment_id, '_race_cms_imported_at', current_time('mysql'));
        update_post_meta($attachment_id, '_race_cms_media_type', $is_image ? 'image' : 'video');

        if (!empty($asset['id'])) {
            update_post_meta($attachment_id, '_race_cms_doc_id', sanitize_text_field($asset['id']));
        }

        if ($is_image) {
            update_post_meta($attachment_id, '_wp_attachment_image_alt', sanitize_text_field($title ?: pathinfo($file_name, PATHINFO_FILENAME)));
        }

        return array(
            'already_existed' => false,
            'attachment_id'   => $attachment_id,
            'url'             => wp_get_attachment_url($attachment_id),
            'thumbnail_url'   => wp_get_attachment_image_url($attachment_id, 'thumbnail') ?: wp_get_attachment_url($attachment_id),
            'title'           => get_the_title($attachment_id),
            'file_id'         => $file_id,
            'media_type'      => $is_image ? 'image' : 'video',
        );
    }
}
