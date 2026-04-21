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
                <?php race_render_media_grid('gallery', array('columns' => 'masonry', 'lightbox_group' => 'gallery')); ?>
            </div>

            <div class="gallery-panel" data-gallery-panel="reels">
                <?php race_render_video_cards(); ?>
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

<?php get_footer(); ?>
