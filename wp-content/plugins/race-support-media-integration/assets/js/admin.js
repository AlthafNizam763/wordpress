/**
 * Race Support CMS Media Integration Admin JavaScript
 */
(function ($) {
    'use strict';

    const state = {
        currentPage: 1,
        totalPages: 1,
        selectedItem: null,
        activeFilter: 'all',
        searchQuery: '',
        searchTimeout: null,
        isModalPicker: false,
        cachedItems: []
    };

    $(document).ready(function () {
        initSettingsPage();
        initPickerModal();
        initPostMetaBox();
        initStandaloneCatalogue();
    });

    /**
     * 1. Settings Page Handlers
     */
    function initSettingsPage() {
        const $testBtn = $('#race-cms-test-conn-btn');
        const $syncBtn = $('#race-cms-sync-btn');
        const $clearBtn = $('#race-cms-clear-cache-btn');
        const $toggleKeyBtn = $('#race-cms-toggle-key-visibility');

        if ($toggleKeyBtn.length) {
            $toggleKeyBtn.on('click', function () {
                const $input = $('#api_key');
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $(this).text('Hide Key');
                } else {
                    $input.attr('type', 'password');
                    $(this).text('Show/Edit Key');
                }
            });
        }

        if ($testBtn.length) {
            $testBtn.on('click', function () {
                const $spinner = $('#race-cms-conn-spinner');
                const $result = $('#race-cms-conn-result');
                const baseUrl = $('#api_base_url').val();
                const apiKey = $('#api_key').val();

                $spinner.addClass('is-active');
                $result.html('<div class="notice notice-info inline"><p>Testing connection to Race Support CMS...</p></div>');
                $testBtn.prop('disabled', true);

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'race_cms_test_connection',
                        nonce: raceCmsData.nonce,
                        api_base_url: baseUrl,
                        api_key: apiKey
                    },
                    success: function (res) {
                        $spinner.removeClass('is-active');
                        $testBtn.prop('disabled', false);

                        if (res.success) {
                            const data = res.data;
                            $result.html(`
                                <div class="notice notice-success inline" style="margin: 5px 0;">
                                    <p><strong>Success!</strong> ${res.data.message || 'Connected to CMS API.'} 
                                    <span style="color: #64748b;">(Latency: ${res.data.latency_ms} ms)</span></p>
                                </div>
                            `);
                            $('.race-cms-status-badge')
                                .css('background-color', '#10b981')
                                .text('Connected');
                        } else {
                            $result.html(`
                                <div class="notice notice-error inline" style="margin: 5px 0;">
                                    <p><strong>Connection Error:</strong> ${res.data.message || 'Failed to connect.'}</p>
                                </div>
                            `);
                            $('.race-cms-status-badge')
                                .css('background-color', '#ef4444')
                                .text('Failed');
                        }
                    },
                    error: function (xhr) {
                        $spinner.removeClass('is-active');
                        $testBtn.prop('disabled', false);
                        $result.html(`
                            <div class="notice notice-error inline" style="margin: 5px 0;">
                                <p><strong>Server Error:</strong> ${xhr.statusText} (${xhr.status})</p>
                            </div>
                        `);
                    }
                });
            });
        }

        if ($syncBtn.length) {
            $syncBtn.on('click', function () {
                const $spinner = $('#race-cms-sync-spinner');
                const $result = $('#race-cms-sync-result');

                $spinner.addClass('is-active');
                $syncBtn.prop('disabled', true);
                $result.html('<span style="color: #64748b; font-size: 12px;">Synchronizing catalogue...</span>');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'race_cms_run_sync',
                        nonce: raceCmsData.nonce
                    },
                    success: function (res) {
                        $spinner.removeClass('is-active');
                        $syncBtn.prop('disabled', false);

                        if (res.success) {
                            $result.html(`<span style="color: #10b981; font-size: 12px; font-weight: 600;">${res.data.message}</span>`);
                            $('#race-cms-last-sync').text(res.data.last_sync_time);
                        } else {
                            $result.html(`<span style="color: #ef4444; font-size: 12px;">${res.data.message}</span>`);
                        }
                    },
                    error: function (xhr) {
                        $spinner.removeClass('is-active');
                        $syncBtn.prop('disabled', false);
                        $result.html(`<span style="color: #ef4444; font-size: 12px;">Error: ${xhr.statusText}</span>`);
                    }
                });
            });
        }

        if ($clearBtn.length) {
            $clearBtn.on('click', function () {
                $(this).prop('disabled', true);
                $.post(ajaxurl, {
                    action: 'race_cms_clear_cache',
                    nonce: raceCmsData.nonce
                }, function (res) {
                    $clearBtn.prop('disabled', false);
                    alert(res.data.message || 'Cache cleared.');
                });
            });
        }
    }

    /**
     * 2. Post Meta Box & Modal Launcher
     */
    function initPostMetaBox() {
        $(document).on('click', '.race-cms-open-picker-btn', function (e) {
            e.preventDefault();
            state.isModalPicker = true;
            openModalPicker();
        });

        $('#race-cms-remove-media-btn').on('click', function (e) {
            e.preventDefault();
            $('#race_media_url').val('');
            $('#race_media_file_id').val('');
            $('#race_media_type').val('');
            $('#race_media_title').val('');
            $('#race_media_attachment_id').val('');

            $('#race-cms-selected-preview').empty();
            $('.race-cms-preview-wrap').hide();
            $('.race-cms-no-media-wrap').show();
        });

        $('#race-cms-set-featured-btn').on('click', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const url = $('#race_media_url').val();
            const fileId = $('#race_media_file_id').val();
            const title = $('#race_media_title').val();
            const type = $('#race_media_type').val();
            const currentAttachId = $('#race_media_attachment_id').val();

            if (!url) return;

            if (currentAttachId) {
                if (typeof wp !== 'undefined' && wp.media && wp.media.featuredImage) {
                    wp.media.featuredImage.set(parseInt(currentAttachId, 10));
                    alert('Featured image set to attachment #' + currentAttachId);
                }
                return;
            }

            // Need to import asset first
            $btn.prop('disabled', true).text('Importing for Featured Image...');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'race_cms_import_asset',
                    nonce: raceCmsData.nonce,
                    fileId: fileId,
                    url: url,
                    title: title,
                    mediaType: type,
                    postId: $('#post_ID').val() || 0
                },
                success: function (res) {
                    $btn.prop('disabled', false).html('<span class="dashicons dashicons-format-image"></span> Sync as Featured Image');
                    if (res.success && res.data.attachment) {
                        const attachId = res.data.attachment.attachment_id;
                        $('#race_media_attachment_id').val(attachId);
                        if (typeof wp !== 'undefined' && wp.media && wp.media.featuredImage) {
                            wp.media.featuredImage.set(attachId);
                        }
                        alert('Asset imported into Media Library (# ' + attachId + ') and set as Featured Image!');
                    } else {
                        alert('Import failed: ' + (res.data ? res.data.message : 'Unknown error'));
                    }
                },
                error: function (xhr) {
                    $btn.prop('disabled', false).html('<span class="dashicons dashicons-format-image"></span> Sync as Featured Image');
                    alert('Import request failed: ' + xhr.statusText);
                }
            });
        });
    }

    /**
     * 3. Picker Modal Logic
     */
    function initPickerModal() {
        const $modal = $('#race-cms-picker-modal');
        if (!$modal.length) return;

        // Close handlers
        $modal.find('.race-cms-modal-close, #race-cms-cancel-btn, .race-cms-modal-backdrop').on('click', function () {
            closeModalPicker();
        });

        // Search debouncing
        $('#race-cms-search-input').on('input', function () {
            clearTimeout(state.searchTimeout);
            state.searchQuery = $(this).val().trim();
            state.searchTimeout = setTimeout(function () {
                state.currentPage = 1;
                fetchCatalogue();
            }, 300);
        });

        // Filter change
        $('#race-cms-type-filter').on('change', function () {
            state.activeFilter = $(this).val();
            state.currentPage = 1;
            fetchCatalogue();
        });

        // Refresh button
        $('#race-cms-refresh-btn').on('click', function () {
            state.currentPage = 1;
            fetchCatalogue();
        });

        // Choose / Select media button
        $('#race-cms-choose-btn').on('click', function () {
            if (!state.selectedItem) return;
            applySelection(state.selectedItem);
            closeModalPicker();
        });

        // Details modal close
        $('#race-cms-details-modal').find('.race-cms-details-close, .race-cms-modal-backdrop').on('click', function () {
            $('#race-cms-details-modal').hide();
            $('#race-cms-details-body').empty();
        });
    }

    function openModalPicker() {
        $('#race-cms-picker-modal').fadeIn(150);
        state.selectedItem = null;
        $('#race-cms-choose-btn').prop('disabled', true);
        fetchCatalogue();
    }

    function closeModalPicker() {
        $('#race-cms-picker-modal').fadeOut(150);
    }

    function applySelection(item) {
        $('#race_media_url').val(item.url);
        $('#race_media_file_id').val(item.fileId);
        $('#race_media_type').val(item.mediaType);
        $('#race_media_title').val(item.title);
        $('#race_media_attachment_id').val(item.attachmentId || '');

        const $preview = $('#race-cms-selected-preview');
        $preview.empty();

        if (item.mediaType === 'video') {
            $preview.append(`<video src="${item.url}" controls style="max-width: 100%; height: auto; max-height: 180px; display: block;"></video>`);
        } else {
            $preview.append(`<img src="${item.url}" alt="${item.title}" style="max-width: 100%; height: auto; max-height: 180px; display: block; margin: 0 auto;" />`);
        }

        $('#race-cms-selected-title').text(item.title || item.fileName);
        $('#race-cms-selected-type').text(item.mediaType.toUpperCase() + ' • ImageKit CDN');

        $('.race-cms-no-media-wrap').hide();
        $('.race-cms-preview-wrap').show();
    }

    /**
     * 4. Fetch Catalogue & Render Cards
     */
    function fetchCatalogue() {
        const $grid = $('#race-cms-items-grid');
        const $loading = $('#race-cms-modal-loading');
        const $empty = $('#race-cms-modal-empty');

        $loading.show();
        $empty.hide();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'race_cms_get_catalog',
                nonce: raceCmsData.nonce,
                page: state.currentPage,
                mediaType: state.activeFilter,
                search: state.searchQuery
            },
            success: function (res) {
                $loading.hide();
                if (res.success && res.data.items) {
                    state.cachedItems = res.data.items;
                    state.totalPages = res.data.pagination ? res.data.pagination.totalPages : 1;
                    renderGrid(res.data.items, $grid);
                    renderPagination(res.data.pagination);
                } else {
                    $grid.empty();
                    $empty.show();
                }
            },
            error: function () {
                $loading.hide();
                $grid.empty();
                $empty.show();
            }
        });
    }

    function renderGrid(items, $container) {
        $container.empty();

        if (!items || items.length === 0) {
            $('#race-cms-modal-empty').show();
            return;
        }

        items.forEach(function (item) {
            const isVideo = item.mediaType === 'video';
            const thumbnailSrc = item.url;
            const importedBadge = item.isImported ? '<span class="race-cms-imported-badge">In Library</span>' : '';
            const videoBadge = isVideo ? '<span class="race-cms-video-badge"><span class="dashicons dashicons-video-alt3" style="font-size: 12px; width: 12px; height: 12px;"></span> VIDEO</span>' : '';

            const $card = $(`
                <div class="race-cms-media-card" data-file-id="${item.fileId}">
                    <div class="race-cms-card-thumbnail">
                        ${isVideo ? `<video src="${item.url}" preload="metadata" muted></video>` : `<img src="${thumbnailSrc}" alt="${item.title}" loading="lazy">`}
                        ${videoBadge}
                        ${importedBadge}
                    </div>
                    <div class="race-cms-card-info">
                        <div class="race-cms-card-title" title="${item.title || item.fileName}">${item.title || item.fileName}</div>
                        <div class="race-cms-card-meta">
                            <span>${item.formattedSize || ''}</span>
                            <span>${item.mediaType}</span>
                        </div>
                        <div class="race-cms-card-actions">
                            <button type="button" class="button button-small race-cms-card-details-btn">Details</button>
                            <button type="button" class="button button-small race-cms-card-copy-btn" title="Copy ImageKit CDN URL">Copy URL</button>
                        </div>
                    </div>
                </div>
            `);

            // Card click selection
            $card.on('click', function (e) {
                if ($(e.target).closest('button').length) return;
                $('.race-cms-media-card').removeClass('is-selected');
                $card.addClass('is-selected');
                state.selectedItem = item;
                $('#race-cms-choose-btn').prop('disabled', false);
            });

            // Double click opens details
            $card.on('dblclick', function () {
                openDetailsModal(item);
            });

            // Details button
            $card.find('.race-cms-card-details-btn').on('click', function (e) {
                e.stopPropagation();
                openDetailsModal(item);
            });

            // Copy URL button
            $card.find('.race-cms-card-copy-btn').on('click', function (e) {
                e.stopPropagation();
                copyToClipboard(item.url, $(this));
            });

            $container.append($card);
        });
    }

    function renderPagination(pagination) {
        const $pagination = $('#race-cms-pagination');
        $pagination.empty();

        if (!pagination || pagination.totalPages <= 1) return;

        const $prevBtn = $(`<button type="button" class="button" ${pagination.page <= 1 ? 'disabled' : ''}>&laquo; Prev</button>`);
        const $pageInfo = $(`<span>Page <strong>${pagination.page}</strong> of <strong>${pagination.totalPages}</strong> (${pagination.total} items)</span>`);
        const $nextBtn = $(`<button type="button" class="button" ${pagination.page >= pagination.totalPages ? 'disabled' : ''}>Next &raquo;</button>`);

        $prevBtn.on('click', function () {
            if (state.currentPage > 1) {
                state.currentPage--;
                fetchCatalogue();
            }
        });

        $nextBtn.on('click', function () {
            if (state.currentPage < pagination.totalPages) {
                state.currentPage++;
                fetchCatalogue();
            }
        });

        $pagination.append($prevBtn, $pageInfo, $nextBtn);
    }

    /**
     * 5. Lightbox / Details Modal
     */
    function openDetailsModal(item) {
        const $modal = $('#race-cms-details-modal');
        const $body = $('#race-cms-details-body');
        $body.empty();

        const isVideo = item.mediaType === 'video';
        const previewEl = isVideo 
            ? `<video src="${item.url}" controls autoplay playsinline style="max-height: 400px; width: 100%;"></video>` 
            : `<img src="${item.url}" alt="${item.title}" />`;

        const detailsHtml = `
            <div class="race-cms-details-preview">
                ${previewEl}
            </div>

            <h3 style="margin-top: 0;">${item.title || item.fileName}</h3>

            <table class="race-cms-details-table">
                <tr><th>File Name:</th><td><code>${item.fileName}</code></td></tr>
                <tr><th>ImageKit File ID:</th><td><code>${item.fileId}</code></td></tr>
                <tr><th>MIME Type:</th><td>${item.mimeType || 'unknown'}</td></tr>
                <tr><th>File Size:</th><td>${item.formattedSize || ''} (${item.size} bytes)</td></tr>
                <tr><th>Folder:</th><td><code>${item.folder || '/admin-media'}</code></td></tr>
                <tr><th>Upload Date:</th><td>${item.createdAt || 'N/A'}</td></tr>
                <tr><th>ImageKit CDN URL:</th><td><input type="text" readonly value="${item.url}" class="large-text" style="font-size: 12px; background: #f8fafc;" /></td></tr>
            </table>

            <div class="race-cms-details-actions">
                <button type="button" class="button button-primary" id="race-cms-modal-copy-url">
                    <span class="dashicons dashicons-admin-page" style="vertical-align: middle;"></span> Copy ImageKit CDN URL
                </button>
                <a href="${item.url}" target="_blank" rel="noopener noreferrer" class="button button-secondary">
                    <span class="dashicons dashicons-external" style="vertical-align: middle;"></span> Open Original Asset
                </a>
                <button type="button" class="button button-secondary" id="race-cms-modal-import-btn" ${item.isImported ? 'disabled' : ''}>
                    <span class="dashicons dashicons-download" style="vertical-align: middle;"></span> 
                    ${item.isImported ? 'Already in WP Media Library (Attachment #' + item.attachmentId + ')' : 'Import to WP Media Library'}
                </button>
            </div>
        `;

        $body.html(detailsHtml);

        // Copy button in details
        $body.find('#race-cms-modal-copy-url').on('click', function () {
            copyToClipboard(item.url, $(this));
        });

        // Import button in details
        $body.find('#race-cms-modal-import-btn').on('click', function () {
            const $btn = $(this);
            $btn.prop('disabled', true).text('Importing asset...');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'race_cms_import_asset',
                    nonce: raceCmsData.nonce,
                    fileId: item.fileId,
                    url: item.url,
                    title: item.title,
                    mediaType: item.mediaType
                },
                success: function (res) {
                    if (res.success && res.data.attachment) {
                        item.isImported = true;
                        item.attachmentId = res.data.attachment.attachment_id;
                        $btn.text('Imported (Attachment #' + item.attachmentId + ')');
                        // Update badge in card grid
                        $(`.race-cms-media-card[data-file-id="${item.fileId}"] .race-cms-card-thumbnail`)
                            .append('<span class="race-cms-imported-badge">In Library</span>');
                        alert(res.data.message || 'Asset imported successfully!');
                    } else {
                        $btn.prop('disabled', false).text('Import to WP Media Library');
                        alert('Import failed: ' + (res.data ? res.data.message : 'Unknown error'));
                    }
                },
                error: function (xhr) {
                    $btn.prop('disabled', false).text('Import to WP Media Library');
                    alert('Import request failed: ' + xhr.statusText);
                }
            });
        });

        $modal.fadeIn(150);
    }

    /**
     * 6. Standalone Catalogue Page View (Media -> Race CMS Media)
     */
    function initStandaloneCatalogue() {
        const $container = $('#race-cms-catalogue-container');
        if (!$container.length) return;

        // Render standalone controls & grid
        const toolbarHtml = `
            <div class="race-cms-modal-toolbar" style="padding: 0 0 16px 0; border-bottom: 1px solid #e2e8f0; margin-bottom: 20px;">
                <div class="race-cms-search-box">
                    <span class="dashicons dashicons-search"></span>
                    <input type="search" id="race-cms-standalone-search" placeholder="Search by title or filename..." />
                </div>
                <div class="race-cms-filters">
                    <select id="race-cms-standalone-type">
                        <option value="all">All Media</option>
                        <option value="image">Images</option>
                        <option value="video">Videos</option>
                    </select>
                    <button type="button" class="button" id="race-cms-standalone-refresh" title="Refresh">
                        <span class="dashicons dashicons-update" style="vertical-align: middle;"></span> Refresh
                    </button>
                </div>
            </div>
            <div id="race-cms-standalone-grid" class="race-cms-grid-view"></div>
            <div id="race-cms-standalone-empty" class="race-cms-empty-state" style="display: none;">
                <span class="dashicons dashicons-format-image" style="font-size: 48px; width: 48px; height: 48px; color: #94a3b8;"></span>
                <h3>No media found</h3>
                <p>No media files match your query in Race Support CMS.</p>
            </div>
            <div class="race-cms-modal-footer" style="margin-top: 24px; padding: 14px 0;">
                <div class="race-cms-pagination" id="race-cms-standalone-pagination"></div>
            </div>
        `;

        $container.html(toolbarHtml);

        function loadStandalone() {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'race_cms_get_catalog',
                    nonce: raceCmsData.nonce,
                    page: state.currentPage,
                    mediaType: $('#race-cms-standalone-type').val(),
                    search: $('#race-cms-standalone-search').val().trim()
                },
                success: function (res) {
                    if (res.success && res.data.items) {
                        $('#race-cms-standalone-empty').hide();
                        renderGrid(res.data.items, $('#race-cms-standalone-grid'));
                        renderStandalonePagination(res.data.pagination);
                    } else {
                        $('#race-cms-standalone-grid').empty();
                        $('#race-cms-standalone-empty').show();
                    }
                }
            });
        }

        function renderStandalonePagination(pagination) {
            const $p = $('#race-cms-standalone-pagination');
            $p.empty();
            if (!pagination || pagination.totalPages <= 1) return;

            const $prev = $(`<button type="button" class="button" ${pagination.page <= 1 ? 'disabled' : ''}>&laquo; Prev</button>`);
            const $info = $(`<span>Page <strong>${pagination.page}</strong> of <strong>${pagination.totalPages}</strong> (${pagination.total} items)</span>`);
            const $next = $(`<button type="button" class="button" ${pagination.page >= pagination.totalPages ? 'disabled' : ''}>Next &raquo;</button>`);

            $prev.on('click', function () {
                if (state.currentPage > 1) {
                    state.currentPage--;
                    loadStandalone();
                }
            });

            $next.on('click', function () {
                if (state.currentPage < pagination.totalPages) {
                    state.currentPage++;
                    loadStandalone();
                }
            });

            $p.append($prev, $info, $next);
        }

        $('#race-cms-standalone-search').on('input', function () {
            clearTimeout(state.searchTimeout);
            state.searchTimeout = setTimeout(function () {
                state.currentPage = 1;
                loadStandalone();
            }, 300);
        });

        $('#race-cms-standalone-type, #race-cms-standalone-refresh').on('change click', function () {
            state.currentPage = 1;
            loadStandalone();
        });

        loadStandalone();
    }

    /**
     * Utility: Copy to Clipboard
     */
    function copyToClipboard(text, $btn) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function () {
                showCopyFeedback($btn);
            });
        } else {
            const $temp = $('<textarea>');
            $('body').append($temp);
            $temp.val(text).select();
            document.execCommand('copy');
            $temp.remove();
            showCopyFeedback($btn);
        }
    }

    function showCopyFeedback($btn) {
        const originalText = $btn.html();
        $btn.html('<span class="dashicons dashicons-yes" style="font-size: 14px; width: 14px; height: 14px; vertical-align: middle;"></span> Copied!');
        setTimeout(function () {
            $btn.html(originalText);
        }, 1800);
    }

})(jQuery);
