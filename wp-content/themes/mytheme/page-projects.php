<?php
/* Template Name: Projects */
get_header();

race_render_page_hero(array(
    'title' => 'Projects',
    'description' => 'Long-form initiatives where RACE nurtures change through sustained participation and community ownership.',
    'image' => get_template_directory_uri() . '/images/ProjectCollaboration.jpeg',
));
?>

<section class="section-shell">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Project Portfolio</span>
                <h2>Designed for continuity, not just one-time activity.</h2>
            </div>
            <p>These projects reflect how RACE turns purpose into repeatable community action with memory, follow-through, and visible public value.</p>
        </div>

        <div id="projects-container">
            <p class="empty-state">Loading projects...</p>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const projectsContainer = document.getElementById('projects-container');

    const getImageUrl = (img) => {
        if (!img) return '<?php echo get_template_directory_uri(); ?>/images/bg.jpg';
        if (img.startsWith('http://') || img.startsWith('https://')) return img;
        return `http://localhost:3000${img}`;
    };

    subscribeToAllCollections((data) => {
        const projects = data.projects || [];

        if (projects.length === 0) {
            projectsContainer.innerHTML = '<p class="empty-state">No flagship projects found.</p>';
        } else {
            projectsContainer.innerHTML = projects.map((project, index) => {
                const images = project.images || [];
                const mainImage = images.length > 0 ? getImageUrl(images[0]) : '<?php echo get_template_directory_uri(); ?>/images/bg.jpg';
                const otherImages = images.slice(1).map(img => getImageUrl(img));
                const alternateClass = index % 2 === 1 ? 'story-card--reverse' : '';
                const paddingTop = index === 0 ? '0' : '40px';

                let remainingImagesHtml = '';
                if (otherImages.length > 0) {
                    remainingImagesHtml = `
                        <div style="margin-top: 24px;">
                            <div class="media-grid">
                                ${otherImages.map(imgUrl => `
                                    <a class="media-card animate-on-scroll" href="${imgUrl}" data-lightbox-group="${project.id}">
                                        <img class="media-card__image" src="${imgUrl}" alt="${project.title || 'Project Image'}">
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                return `
                    <div class="section-shell--compact" style="padding-top: ${paddingTop};">
                        <article class="story-card ${alternateClass} animate-on-scroll">
                            <img class="story-card__image" src="${mainImage}" alt="${project.title || 'Project Image'}">
                            <div>
                                <span class="eyebrow">Flagship Project</span>
                                <h3>${project.title || 'Untitled Project'}</h3>
                                <p>${project.description || ''}</p>
                            </div>
                        </article>
                        ${remainingImagesHtml}
                    </div>
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
