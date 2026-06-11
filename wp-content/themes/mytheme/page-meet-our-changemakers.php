<?php
/* Template Name: Meet Our Changemakers */
get_header();

race_render_page_hero(array(
    'title' => 'Meet Our Changemakers',
    'description' => 'Faces, moments, and visual stories from the people carrying the spirit of RACE forward.',
    'image' => get_template_directory_uri() ,
));
?>

<section class="section-shell">
    <div class="container">
        <div class="gallery-shell animate-on-scroll">
            <div class="section-header" style="margin-bottom: 0;">
                <div>
                    <span class="eyebrow">Changemaker Gallery</span>
                    <h2>A more human way to showcase the people behind the work.</h2>
                </div>
            </div>
            <div id="changemakers-container" class="media-masonry">
                <p class="empty-state">Loading changemakers...</p>
            </div>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const changemakersContainer = document.getElementById('changemakers-container');

    const getImageUrl = (img) => {
        if (!img) return '';
        if (img.startsWith('http://') || img.startsWith('https://')) return img;
        return `http://localhost:3000${img}`;
    };

    subscribeToAllCollections((data) => {
        const changemakers = data.changemakers || [];

        if (changemakers.length === 0) {
            changemakersContainer.innerHTML = '<p class="empty-state">No changemakers registered.</p>';
        } else {
            changemakersContainer.innerHTML = changemakers.map(item => {
                const imgUrl = getImageUrl(item.image);
                return `
                    <a class="media-card animate-on-scroll" href="${imgUrl}" data-lightbox-group="changemaker">
                        <img class="media-card__image" src="${imgUrl}" alt="${item.name || 'Changemaker'}">
                        <div style="padding: 16px; text-align: center; background: rgba(255, 255, 255, 0.9);">
                            <h3 style="font-size: 1.25rem; margin-bottom: 4px; font-family: 'Manrope', sans-serif; font-weight: 700; color: var(--text);">${item.name || 'Untitled'}</h3>
                            <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 0;">${item.title || ''}</p>
                        </div>
                    </a>
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
