<?php
/* Template Name: Day Observations */
get_header();

race_render_page_hero(array(
    'title' => 'Day Observations',
    'description' => 'A curated archive of awareness days, cultural observances, and public education moments documented through the RACE lens.',
    'image' => get_template_directory_uri() . '/images/gallerybg.png',
));
?>

<section class="section-shell">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Observation Archive</span>
                <h2>Awareness days presented with more clarity and better browsing flow.</h2>
            </div>
            <p>Each observation now reads like a polished editorial section, with cleaner hierarchy and image handling that works much better across devices.</p>
        </div>

        <div id="observations-container" style="display: grid; gap: 36px;">
            <p class="empty-state">Loading day observations...</p>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const observationsContainer = document.getElementById('observations-container');

    const getImageUrl = (img) => {
        if (!img) return '';
        if (img.startsWith('http://') || img.startsWith('https://')) return img;
        return `http://localhost:3000${img}`;
    };

    subscribeToAllCollections((data) => {
        const observations = data.observations || [];

        if (observations.length === 0) {
            observationsContainer.innerHTML = '<p class="empty-state">No day observations archived.</p>';
        } else {
            observationsContainer.innerHTML = observations.map(item => {
                const images = (item.images || []).map(img => getImageUrl(img));
                let mediaGridHtml = '';

                if (images.length > 0) {
                    mediaGridHtml = `
                        <div style="margin-top: 20px;">
                            <div class="media-grid">
                                ${images.map(imgUrl => `
                                    <a class="media-card animate-on-scroll" href="${imgUrl}" data-lightbox-group="${item.id}">
                                        <img class="media-card__image" src="${imgUrl}" alt="${item.title || 'Observation Image'}">
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                return `
                    <article class="archive-card animate-on-scroll" style="padding: 30px;">
                        <span class="eyebrow">Day Observation</span>
                        <h3>${item.title || 'Untitled Observation'}</h3>
                        <p>${item.description || ''}</p>
                        ${mediaGridHtml}
                    </article>
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
