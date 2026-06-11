<?php
/* Template Name: Collaborations */
get_header();

race_render_page_hero(array(
    'title' => 'Collaborations',
    'description' => 'Institutional partnerships and public-interest collaborations that amplify the reach of RACE.',
    'image' => get_template_directory_uri() . '/images/collaborations.gif',
));
?>

<section class="section-shell">
    <div class="container">
        <div class="story-grid">
            <div id="collaborations-container" style="display: contents;">
                <p class="empty-state">Loading collaborations...</p>
            </div>

            <article class="surface-panel animate-on-scroll" style="padding: 32px;">
                <span class="eyebrow">Why Collaboration Matters</span>
                <h2 style="font-size: 3rem;">Better outcomes happen when communities, institutions, and facilitators align.</h2>
                <p>RACE collaborations are designed to create mutual value: stronger program delivery, better reach, deeper trust, and a more sustainable model for long-term impact.</p>
                <div class="grid-2" style="margin-top: 22px;">
                    <div class="info-card">
                        <h3>Shared Reach</h3>
                        <p>Programs become more visible and more relevant when local stakeholders participate in delivery.</p>
                    </div>
                    <div class="info-card">
                        <h3>Shared Responsibility</h3>
                        <p>Each collaboration is shaped around practical ownership, not one-sided execution.</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const collaborationsContainer = document.getElementById('collaborations-container');

    const getImageUrl = (images) => {
        if (!images) return '<?php echo get_template_directory_uri(); ?>/images/bg.jpg';
        if (Array.isArray(images)) {
            if (images.length === 0) return '<?php echo get_template_directory_uri(); ?>/images/bg.jpg';
            return getImageUrl(images[0]);
        }
        if (typeof images === 'string') {
            if (images.startsWith('http://') || images.startsWith('https://')) return images;
            return `http://localhost:3000${images}`;
        }
        return '<?php echo get_template_directory_uri(); ?>/images/bg.jpg';
    };

    subscribeToAllCollections((data) => {
        const collaborations = data.collaborations || [];

        if (collaborations.length === 0) {
            collaborationsContainer.innerHTML = '<p class="empty-state">No collaborations found.</p>';
        } else {
            collaborationsContainer.innerHTML = collaborations.map(item => `
                <article class="story-card animate-on-scroll">
                    <img class="story-card__image" src="${getImageUrl(item.images)}" alt="${item.title || 'Collaboration Image'}">
                    <div>
                        <span class="eyebrow">Featured Collaboration</span>
                        <h3>${item.title || 'Untitled Collaboration'}</h3>
                        <p>${item.description || ''}</p>
                    </div>
                </article>
            `).join('');
        }

        // Trigger animations for newly added items
        if (window.raceObserveElements) {
            window.raceObserveElements();
        }
    });
</script>

<?php get_footer(); ?>
