<?php
/* Template Name: Courses & Training */
get_header();

race_render_page_hero(array(
    'title' => 'Courses & Training',
    'description' => 'A curated set of learning experiences designed for students, trainers, professionals, women, and broader community groups.',
    'image' => get_template_directory_uri() . '/images/ProgramsTraining.jpeg',
));
?>

<section class="section-shell">
    <div class="container">
        <div class="section-shell--compact" style="padding-top: 0;">
            <div class="section-header animate-on-scroll">
                <div>
                    <span class="eyebrow">Training Portfolio</span>
                    <h2>All Training & Skill Development Programmes</h2>
                </div>
            </div>
            <div class="program-grid" id="courses-container">
                <p class="empty-state">Loading training courses...</p>
            </div>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const coursesContainer = document.getElementById('courses-container');

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
        const courses = data.courses || [];

        if (courses.length === 0) {
            coursesContainer.innerHTML = '<p class="empty-state">No courses are available at this time.</p>';
        } else {
            coursesContainer.innerHTML = courses.map(item => `
                <article class="program-card animate-on-scroll">
                    <img class="program-card__image" src="${getImageUrl(item.images)}" alt="${item.title || 'Course Image'}">
                    <div class="program-card__copy">
                        <span class="program-card__tag">Training Programme</span>
                        <h3>${item.title || 'Untitled Programme'}</h3>
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
