<?php
/* Template Name: Gallery */
get_header();

race_render_page_hero(array(
    'title' => 'Gallery',
    'description' => 'A smoother browsing experience for both photos and video stories, redesigned for modern devices and premium presentation.',
    'image' => get_template_directory_uri() . '/images/gallerybg.png',
));
?>

<section class="section-shell">
    <div class="container">
        <div class="gallery-shell animate-on-scroll">
            <div class="gallery-tabs">
                <button type="button" class="gallery-tab is-active" data-gallery-tab="photos">Photos</button>
                <button type="button" class="gallery-tab" data-gallery-tab="reels">Reels</button>
            </div>

            <div class="gallery-panel is-active" data-gallery-panel="photos">
                <div id="gallery-photos-container" class="media-masonry">
                    <p class="empty-state">Loading photos...</p>
                </div>
            </div>

            <div class="gallery-panel" data-gallery-panel="reels">
                <div id="gallery-reels-container" class="video-grid">
                    <p class="empty-state">Loading reels...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('[data-gallery-tab]');
    const panels = document.querySelectorAll('[data-gallery-panel]');
    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.galleryTab;
            tabs.forEach((item) => item.classList.toggle('is-active', item === tab));
            panels.forEach((panel) => panel.classList.toggle('is-active', panel.dataset.galleryPanel === target));
        });
    });
});
</script>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const photosContainer = document.getElementById('gallery-photos-container');
    const reelsContainer = document.getElementById('gallery-reels-container');

    const getMediaUrl = (item) => {
        const src = item.url || item.path || '';
        if (!src) return '';
        if (src.startsWith('http://') || src.startsWith('https://')) return src;
        return `http://localhost:3000${src}`;
    };

    subscribeToAllCollections((data) => {
        const gallery = data.gallery || [];

        // Filter images and videos
        const photos = gallery.filter(item => item.type === 'image' || !item.type || item.contentType?.startsWith('image/'));
        const videos = gallery.filter(item => item.type === 'video' || item.contentType?.startsWith('video/'));

        // Render Photos
        if (photos.length === 0) {
            photosContainer.innerHTML = '<p class="empty-state">No photos found in the gallery.</p>';
        } else {
            photosContainer.innerHTML = photos.map(item => {
                const imgUrl = getMediaUrl(item);
                return `
                    <a class="media-card animate-on-scroll" href="${imgUrl}" data-lightbox-group="gallery">
                        <img class="media-card__image" src="${imgUrl}" alt="${item.title || 'Gallery Image'}">
                    </a>
                `;
            }).join('');
        }

        // Render Reels
        if (videos.length === 0) {
            reelsContainer.innerHTML = '<p class="empty-state">No video reels found in the gallery.</p>';
        } else {
            reelsContainer.innerHTML = videos.map(item => {
                const videoUrl = getMediaUrl(item);
                return `
                    <button class="video-card animate-on-scroll" type="button" data-video-src="${videoUrl}" data-video-title="${item.title || 'Video Reel'}">
                        <video src="${videoUrl}" preload="metadata" muted playsinline></video>
                        <span class="video-card__play"><i class="fas fa-play"></i></span>
                        <span class="video-card__title">${item.title || 'Video Reel'}</span>
                    </button>
                `;
            }).join('');
        }

        // Trigger animations for newly added items
        if (window.raceObserveElements) {
            window.raceObserveElements();
        }
    });
</script>

<?php get_footer(); ?>
