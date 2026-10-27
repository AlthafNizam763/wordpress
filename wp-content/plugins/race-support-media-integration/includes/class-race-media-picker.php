<?php
/**
 * Race Support CMS Media Picker & Catalogue
 *
 * Implements the Media -> Race CMS Media catalogue browser and the
 * post/page media picker modal.
 *
 * @package RaceSupportMediaIntegration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Race_Media_Picker
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_media_menu'));
        add_action('add_meta_boxes', array($this, 'add_post_meta_boxes'));
        add_action('save_post', array($this, 'save_post_meta'));
        add_action('admin_footer', array($this, 'render_picker_modal'));

        // AJAX endpoints
        add_action('wp_ajax_race_cms_get_catalog', array($this, 'ajax_get_catalog'));
        add_action('wp_ajax_race_cms_import_asset', array($this, 'ajax_import_asset'));
    }

    /**
     * Add menu under Media
     */
    public function add_media_menu()
    {
        add_media_page(
            __('Race Support CMS Media Library', 'race-cms-media'),
            __('Race CMS Media', 'race-cms-media'),
            'upload_files',
            'race-cms-media',
            array($this, 'render_catalogue_page')
        );
    }

    /**
     * Add meta box to content types
     */
    public function add_post_meta_boxes()
    {
        $screens = apply_filters('race_cms_meta_box_post_types', array('post', 'page'));

        foreach ($screens as $screen) {
            add_meta_box(
                'race_cms_media_box',
                __('Race Support CMS Media', 'race-cms-media'),
                array($this, 'render_post_meta_box'),
                $screen,
                'side',
                'high'
            );
        }
    }

    /**
     * Render the post meta box
     */
    public function render_post_meta_box($post)
    {
        wp_nonce_field('race_cms_save_post_meta', 'race_cms_meta_nonce');

        $media_url     = get_post_meta($post->ID, '_race_media_url', true);
        $media_file_id = get_post_meta($post->ID, '_race_media_file_id', true);
        $media_type    = get_post_meta($post->ID, '_race_media_type', true) ?: 'image';
        $media_title   = get_post_meta($post->ID, '_race_media_title', true);
        $attachment_id = get_post_meta($post->ID, '_race_media_attachment_id', true);

        $has_media = !empty($media_url);
        ?>
        <div class="race-cms-meta-box-inner" id="race-cms-meta-box-inner">
            <div class="race-cms-preview-wrap" style="<?php echo $has_media ? '' : 'display: none;'; ?>">
                <div id="race-cms-selected-preview" style="margin-bottom: 10px; border-radius: 4px; overflow: hidden; background: #1e293b; text-align: center;">
                    <?php if ($has_media): ?>
                        <?php if ($media_type === 'video'): ?>
                            <video src="<?php echo esc_url($media_url); ?>" controls style="max-width: 100%; height: auto; max-height: 180px; display: block;"></video>
                        <?php else: ?>
                            <img src="<?php echo esc_url($media_url); ?>" alt="<?php echo esc_attr($media_title); ?>" style="max-width: 100%; height: auto; max-height: 180px; display: block; margin: 0 auto;" />
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="race-cms-selected-details" style="font-size: 12px; margin-bottom: 12px; word-break: break-all;">
                    <div id="race-cms-selected-title" style="font-weight: 600; color: #1e293b;"><?php echo esc_html($media_title); ?></div>
                    <div id="race-cms-selected-type" style="color: #64748b; text-transform: uppercase; font-size: 10px; margin-top: 2px;">
                        <?php echo esc_html($media_type); ?> &bull; ImageKit CDN
                    </div>
                </div>

                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <button type="button" class="button button-secondary race-cms-open-picker-btn" style="flex: 1;">
                        <?php esc_html_e('Replace Media', 'race-cms-media'); ?>
                    </button>
                    <button type="button" class="button button-link-delete" id="race-cms-remove-media-btn">
                        <?php esc_html_e('Remove', 'race-cms-media'); ?>
                    </button>
                </div>

                <div style="margin-top: 10px;">
                    <button type="button" class="button" id="race-cms-set-featured-btn" style="width: 100%;">
                        <span class="dashicons dashicons-format-image" style="vertical-align: middle;"></span>
                        <?php esc_html_e('Sync as Featured Image', 'race-cms-media'); ?>
                    </button>
                </div>
            </div>

            <div class="race-cms-no-media-wrap" style="<?php echo $has_media ? 'display: none;' : ''; ?> text-align: center; padding: 20px 10px; border: 2px dashed #cbd5e1; border-radius: 6px;">
                <p style="color: #64748b; margin: 0 0 12px 0;">
                    <?php esc_html_e('No Race Support CMS asset selected.', 'race-cms-media'); ?>
                </p>
                <button type="button" class="button button-primary race-cms-open-picker-btn">
                    <span class="dashicons dashicons-cloud" style="vertical-align: middle;"></span>
                    <?php esc_html_e('Select from CMS Media', 'race-cms-media'); ?>
                </button>
            </div>

            <!-- Hidden Inputs -->
            <input type="hidden" name="race_media_url" id="race_media_url" value="<?php echo esc_attr($media_url); ?>" />
            <input type="hidden" name="race_media_file_id" id="race_media_file_id" value="<?php echo esc_attr($media_file_id); ?>" />
            <input type="hidden" name="race_media_type" id="race_media_type" value="<?php echo esc_attr($media_type); ?>" />
            <input type="hidden" name="race_media_title" id="race_media_title" value="<?php echo esc_attr($media_title); ?>" />
            <input type="hidden" name="race_media_attachment_id" id="race_media_attachment_id" value="<?php echo esc_attr($attachment_id); ?>" />
        </div>
        <?php
    }

    /**
     * Save post meta
     */
    public function save_post_meta($post_id)
    {
        if (!isset($_POST['race_cms_meta_nonce']) || !wp_verify_nonce($_POST['race_cms_meta_nonce'], 'race_cms_save_post_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = array(
            'race_media_url'           => '_race_media_url',
            'race_media_file_id'       => '_race_media_file_id',
            'race_media_type'          => '_race_media_type',
            'race_media_title'         => '_race_media_title',
            'race_media_attachment_id' => '_race_media_attachment_id',
        );

        foreach ($fields as $post_key => $meta_key) {
            if (isset($_POST[$post_key])) {
                $val = sanitize_text_field($_POST[$post_key]);
                if (!empty($val)) {
                    update_post_meta($post_id, $meta_key, $val);
                } else {
                    delete_post_meta($post_id, $meta_key);
                }
            }
        }
    }

    /**
     * Render the full standalone catalogue browser page
     */
    public function render_catalogue_page()
    {
        ?>
        <div class="wrap race-cms-catalogue-wrap">
            <h1 class="wp-heading-inline"><?php esc_html_e('Race Support CMS Media Catalogue', 'race-cms-media'); ?></h1>
            <a href="<?php echo esc_url(admin_url('options-general.php?page=race-support-cms-media')); ?>" class="page-title-action">
                <?php esc_html_e('Settings', 'race-cms-media'); ?>
            </a>
            <hr class="wp-header-end" />

            <div id="race-cms-catalogue-container" class="race-cms-catalogue-standalone">
                <!-- Rendered dynamically by JavaScript -->
                <div class="race-cms-loading-state">
                    <span class="spinner is-active" style="float: none;"></span>
                    <p><?php esc_html_e('Loading media catalogue from Race Support CMS...', 'race-cms-media'); ?></p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render the Media Picker modal template in admin footer
     */
    public function render_picker_modal()
    {
        $screen = get_current_screen();
        if (!$screen) return;
        ?>
        <div id="race-cms-picker-modal" class="race-cms-modal" style="display: none;">
            <div class="race-cms-modal-backdrop"></div>
            <div class="race-cms-modal-content">
                <div class="race-cms-modal-header">
                    <h2>
                        <span class="dashicons dashicons-cloud" style="vertical-align: middle;"></span>
                        <?php esc_html_e('Race Support CMS Media Library', 'race-cms-media'); ?>
                    </h2>
                    <button type="button" class="race-cms-modal-close" aria-label="<?php esc_attr_e('Close modal', 'race-cms-media'); ?>">&times;</button>
                </div>

                <div class="race-cms-modal-toolbar">
                    <div class="race-cms-search-box">
                        <span class="dashicons dashicons-search"></span>
                        <input type="search" id="race-cms-search-input" placeholder="<?php esc_attr_e('Search by title or filename...', 'race-cms-media'); ?>" />
                    </div>

                    <div class="race-cms-filters">
                        <select id="race-cms-type-filter">
                            <option value="all"><?php esc_html_e('All Media', 'race-cms-media'); ?></option>
                            <option value="image"><?php esc_html_e('Images', 'race-cms-media'); ?></option>
                            <option value="video"><?php esc_html_e('Videos', 'race-cms-media'); ?></option>
                        </select>

                        <button type="button" class="button" id="race-cms-refresh-btn" title="<?php esc_attr_e('Refresh Catalogue', 'race-cms-media'); ?>">
                            <span class="dashicons dashicons-update" style="vertical-align: middle;"></span>
                        </button>
                    </div>
                </div>

                <div class="race-cms-modal-body">
                    <div id="race-cms-items-grid" class="race-cms-grid-view">
                        <!-- Loaded via AJAX -->
                    </div>

                    <div id="race-cms-modal-loading" class="race-cms-loading-overlay" style="display: none;">
                        <span class="spinner is-active"></span>
                    </div>

                    <div id="race-cms-modal-empty" class="race-cms-empty-state" style="display: none;">
                        <span class="dashicons dashicons-format-image" style="font-size: 48px; width: 48px; height: 48px; color: #94a3b8;"></span>
                        <h3><?php esc_html_e('No media found', 'race-cms-media'); ?></h3>
                        <p><?php esc_html_e('Try clearing your search filters or check your CMS connection.', 'race-cms-media'); ?></p>
                    </div>
                </div>

                <div class="race-cms-modal-footer">
                    <div class="race-cms-pagination" id="race-cms-pagination">
                        <!-- Pagination controls -->
                    </div>

                    <div class="race-cms-modal-actions">
                        <button type="button" class="button" id="race-cms-cancel-btn"><?php esc_html_e('Cancel', 'race-cms-media'); ?></button>
                        <button type="button" class="button button-primary" id="race-cms-choose-btn" disabled>
                            <?php esc_html_e('Select Media', 'race-cms-media'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asset Details / Lightbox Modal -->
        <div id="race-cms-details-modal" class="race-cms-details-modal" style="display: none;">
            <div class="race-cms-modal-backdrop"></div>
            <div class="race-cms-details-content">
                <button type="button" class="race-cms-details-close">&times;</button>
                <div class="race-cms-details-body" id="race-cms-details-body">
                    <!-- Populated dynamically -->
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX: Get Media Catalogue
     */
    public function ajax_get_catalog()
    {
        check_ajax_referer('race_cms_admin_nonce', 'nonce');

        if (!current_user_can('upload_files')) {
            wp_send_json_error(array('message' => __('Unauthorized access.', 'race-cms-media')), 403);
        }

        $page       = max(1, intval($_POST['page'] ?? 1));
        $media_type = sanitize_text_field($_POST['mediaType'] ?? '');
        $search     = sanitize_text_field($_POST['search'] ?? '');
        $folder     = sanitize_text_field($_POST['folder'] ?? '');

        $settings = Race_Admin_Settings::get_settings();
        $limit    = !empty($settings['per_page']) ? intval($settings['per_page']) : 20;

        $client = new Race_CMS_API_Client();
        $result = $client->get_media(array(
            'page'      => $page,
            'limit'     => $limit,
            'mediaType' => $media_type !== 'all' ? $media_type : '',
            'search'    => $search,
            'folder'    => $folder,
        ));

        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()), 500);
        }

        // Check which items are already imported in WordPress Media Library
        $items = $result['items'] ?? array();
        foreach ($items as &$item) {
            $existing = Race_Media_Importer::get_imported_attachment($item['fileId']);
            $item['isImported'] = (bool)$existing;
            $item['attachmentId'] = $existing ? $existing->ID : null;
            $item['formattedSize'] = size_format($item['size']);
        }

        wp_send_json_success(array(
            'items'        => $items,
            'pagination'   => $result['pagination'] ?? array(),
            'deliveryMode' => $settings['delivery_mode'],
        ));
    }

    /**
     * AJAX: Import Asset into WordPress Media Library
     */
    public function ajax_import_asset()
    {
        check_ajax_referer('race_cms_admin_nonce', 'nonce');

        if (!current_user_can('upload_files')) {
            wp_send_json_error(array('message' => __('Unauthorized access.', 'race-cms-media')), 403);
        }

        $file_id = sanitize_text_field($_POST['fileId'] ?? '');
        $url     = esc_url_raw($_POST['url'] ?? '');
        $title   = sanitize_text_field($_POST['title'] ?? '');
        $type    = sanitize_text_field($_POST['mediaType'] ?? 'image');
        $post_id = intval($_POST['postId'] ?? 0);

        if (empty($url)) {
            wp_send_json_error(array('message' => __('Missing asset URL.', 'race-cms-media')), 400);
        }

        $asset = array(
            'fileId'    => $file_id,
            'url'       => $url,
            'title'     => $title,
            'mediaType' => $type,
        );

        $import_result = Race_Media_Importer::import_asset($asset, $post_id);

        if (is_wp_error($import_result)) {
            wp_send_json_error(array('message' => $import_result->get_error_message()), 500);
        }

        wp_send_json_success(array(
            'message'        => $import_result['already_existed'] ? __('Asset already in Media Library.', 'race-cms-media') : __('Asset imported successfully.', 'race-cms-media'),
            'attachment'     => $import_result,
        ));
    }
}
