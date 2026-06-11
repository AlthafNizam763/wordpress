<?php
/* Template Name: Ongoing & Past Events */
get_header();

race_render_page_hero(array(
    'title' => 'Ongoing & Past Events',
    'description' => 'A polished archive of featured programmes, milestone moments, and the energy that keeps the RACE calendar moving.',
    'image' => get_template_directory_uri() ,
));
?>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Featured Programme</span>
                <h2>Designed to feel current, premium, and easy to act on.</h2>
            </div>
        </div>
        <div class="grid-2" id="featured-events-container">
            <p class="empty-state">Loading ongoing events...</p>
        </div>
    </div>
</section>

<section class="section-shell">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Archive</span>
                <h2>Past moments that still shape the story.</h2>
            </div>
            <p>The archive gives the site continuity, helping visitors see that the organisation has rhythm, history, and a record of delivery.</p>
        </div>
        <div class="timeline-list" id="past-events-container">
            <p class="empty-state">Loading past events...</p>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const featuredContainer = document.getElementById('featured-events-container');
    const pastContainer = document.getElementById('past-events-container');

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
        const events = data.events || [];
        
        // Filter ongoing events
        const ongoingEvents = events.filter(e => e.status === 'Ongoing');
        const pastEvents = events.filter(e => e.status !== 'Ongoing');

        // Render ongoing
        if (ongoingEvents.length === 0) {
            featuredContainer.innerHTML = '<p class="empty-state">No ongoing events scheduled at this time.</p>';
        } else {
            featuredContainer.innerHTML = ongoingEvents.map(event => `
                <article class="story-card animate-on-scroll" style="grid-column: 1 / -1;">
                    <img class="story-card__image" src="${getImageUrl(event.images)}" alt="${event.title || 'Event Image'}">
                    <div>
                        <span class="leader-card__role">Featured Event</span>
                        <h3>${event.title || 'Untitled Event'}</h3>
                        <p><strong style="color: var(--primary);">Scheduled:</strong> ${event.date || 'No Date'}</p>
                        <p>${event.description || ''}</p>
                    </div>
                </article>
            `).join('');
        }

        // Render past
        if (pastEvents.length === 0) {
            pastContainer.innerHTML = '<p class="empty-state">No archived events available.</p>';
        } else {
            pastContainer.innerHTML = pastEvents.map(event => `
                <article class="timeline-card animate-on-scroll">
                    <span class="timeline-card__date">${event.date || 'Past Event'}</span>
                    <h3>${event.title || 'Untitled Event'}</h3>
                    <p>${event.description || ''}</p>
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
