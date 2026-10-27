<?php
/**
 * Race Support CMS Frontend Delivery & Shortcodes
 *
 * Provides theme template tags, shortcodes, and post thumbnail filters
 * for seamless ImageKit CDN media delivery in WordPress themes.
 *
 * @package RaceSupportMediaIntegration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Race_Frontend
{
    public function __construct()
    {
        add_shortcode('race_media', array($this, 'shortcode_media'));
        add_shortcode('race_image', array($this, 'shortcode_image'));
        add_shortcode('race_video', array($this, 'shortcode_video'));
        add_shortcode('race_media_grid', array($this, 'shortcode_grid'));

        add_filter('post_thumbnail_html', array($this, 'filter_post_thumbnail_html'), 10, 5);
    }

    /**
     * Shortcode: [race_media]
     */
    public function shortcode_media($atts)
    {
        $atts = shortcode_atts(array(
            'file_id'  => '',
            'url'      => '',
            'type'     => '',
            'title'    => '',
            'class'    => '',
            'width'    => '',
            'height'   => '',
            'controls' => 'true',
        ), $atts, 'race_media');

        $url = esc_url($atts['url']);
        $type = sanitize_text_field($atts['type']);

        if (empty($url) && !empty($atts['file_id'])) {
            $client = new Race_CMS_API_Client();
            $result = $client->get_media(array('fileId' => $atts['file_id']));
            if (!is_wp_error($result) && !empty($result['items'][0])) {
                $item = $result['items'][0];
                $url = $item['url'];
                $type = $item['mediaType'];
                if (empty($atts['title'])) {
                    $atts['title'] = $item['title'];
                }
            }
        }

        if (empty($url)) {
            return '';
        }

        if ($type === 'video' || preg_match('/\.(mp4|webm|ogg)($|\?)/i', $url)) {
            return self::render_video_tag($url, $atts);
        }

        return self::render_image_tag($url, $atts);
    }

    /**
     * Shortcode: [race_image]
     */
    public function shortcode_image($atts)
    {
        $atts['type'] = 'image';
        return $this->shortcode_media($atts);
    }

    /**
     * Shortcode: [race_video]
     */
    public function shortcode_video($atts)
    {
        $atts['type'] = 'video';
        return $this->shortcode_media($atts);
    }

    /**
     * Shortcode: [race_media_grid]
     */
    public function shortcode_grid($atts)
    {
        $atts = shortcode_atts(array(
            'folder' => '',
            'type'   => 'all',
            'limit'  => 12,
            'class'  => 'media-grid',
        ), $atts, 'race_media_grid');

        $client = new Race_CMS_API_Client();
        $result = $client->get_media(array(
            'folder'    => $atts['folder'],
            'mediaType' => $atts['type'] !== 'all' ? $atts['type'] : '',
            'limit'     => intval($atts['limit']),
        ));

        if (is_wp_error($result) || empty($result['items'])) {
            return '<p class="empty-state">' . esc_html__('No media available from Race Support CMS.', 'race-cms-media') . '</p>';
        }

        ob_start();
        echo '<div class="' . esc_attr($atts['class']) . '">';
        foreach ($result['items'] as $item) {
            $item_url = esc_url($item['url']);
            $item_title = esc_attr($item['title'] ?: $item['fileName']);

            if ($item['mediaType'] === 'video') {
                echo '<div class="video-card animate-on-scroll">';
                echo '<video src="' . $item_url . '" preload="metadata" muted playsinline></video>';
                echo '<span class="video-card__play"><i class="fas fa-play"></i></span>';
                echo '<span class="video-card__title">' . esc_html($item_title) . '</span>';
                echo '</div>';
            } else {
                echo '<a class="media-card animate-on-scroll" href="' . $item_url . '" data-lightbox-group="race-cms">';
                echo '<img class="media-card__image" src="' . $item_url . '" alt="' . $item_title . '" loading="lazy">';
                echo '</a>';
            }
        }
        echo '</div>';
        return ob_get_clean();
    }

    /**
     * Filter post_thumbnail_html to fallback to ImageKit URL if set
     */
    public function filter_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr)
    {
        if (!empty($html)) {
            return $html;
        }

        $image_url = get_post_meta($post_id, '_race_media_url', true);
        $media_type = get_post_meta($post_id, '_race_media_type', true);

        if (!empty($image_url) && $media_type !== 'video') {
            $title = get_post_meta($post_id, '_race_media_title', true) ?: get_the_title($post_id);
            $classes = isset($attr['class']) ? esc_attr($attr['class']) : 'attachment-post-thumbnail size-post-thumbnail wp-post-image';

            return sprintf(
                '<img src="%s" class="%s race-cms-imagekit-featured" alt="%s" loading="lazy" />',
                esc_url($image_url),
                $classes,
                esc_attr($title)
            );
        }

        return $html;
    }

    public static function render_image_tag($url, $atts = array())
    {
        $class = !empty($atts['class']) ? 'class="' . esc_attr($atts['class']) . '" ' : '';
        $alt   = !empty($atts['title']) ? esc_attr($atts['title']) : '';
        $style = '';
        if (!empty($atts['width'])) $style .= 'max-width: ' . esc_attr($atts['width']) . ';';
        if (!empty($atts['height'])) $style .= 'max-height: ' . esc_attr($atts['height']) . ';';
        $style_attr = !empty($style) ? 'style="' . $style . '" ' : '';

        return sprintf(
            '<img src="%s" alt="%s" %s%sloading="lazy" />',
            esc_url($url),
            $alt,
            $class,
            $style_attr
        );
    }

    public static function render_video_tag($url, $atts = array())
    {
        $controls = ($atts['controls'] ?? 'true') !== 'false' ? 'controls ' : '';
        $class    = !empty($atts['class']) ? 'class="' . esc_attr($atts['class']) . '" ' : '';
        $style    = '';
        if (!empty($atts['width'])) $style .= 'max-width: ' . esc_attr($atts['width']) . ';';
        if (!empty($atts['height'])) $style .= 'max-height: ' . esc_attr($atts['height']) . ';';
        $style_attr = !empty($style) ? 'style="' . $style . '" ' : '';

        return sprintf(
            '<video src="%s" %s%s%splaysinline preload="metadata"></video>',
            esc_url($url),
            $controls,
            $class,
            $style_attr
        );
    }
}

/**
 * Global Theme Helper Functions
 */

if (!function_exists('race_cms_get_post_media')) {
    function race_cms_get_post_media($post_id = 0)
    {
        $post_id = $post_id ? $post_id : get_the_ID();
        if (!$post_id) return null;

        $url = get_post_meta($post_id, '_race_media_url', true);
        if (empty($url)) return null;

        return array(
            'url'           => $url,
            'file_id'       => get_post_meta($post_id, '_race_media_file_id', true),
            'type'          => get_post_meta($post_id, '_race_media_type', true) ?: 'image',
            'title'         => get_post_meta($post_id, '_race_media_title', true),
            'attachment_id' => get_post_meta($post_id, '_race_media_attachment_id', true),
        );
    }
}

if (!function_exists('race_cms_render_post_media')) {
    function race_cms_render_post_media($post_id = 0, $args = array())
    {
        $media = race_cms_get_post_media($post_id);
        if (!$media) return '';

        if ($media['type'] === 'video') {
            return Race_Frontend::render_video_tag($media['url'], $args);
        }

        return Race_Frontend::render_image_tag($media['url'], $args);
    }
}
