<?php
/* Template Name: Features in News */
get_header();

race_render_page_hero(array(
    'title' => 'Features in News',
    'description' => 'A premium visual archive of RACE moments that reached wider public attention.',
    'image' => get_template_directory_uri() ,
));
?>

<section class="section-shell">
    <div class="container">
        <div class="gallery-shell animate-on-scroll">
            <div class="section-header" style="margin-bottom: 0;">
                <div>
                    <span class="eyebrow">Media Coverage</span>
                    <h2>Recognition, visibility, and public storytelling.</h2>
                </div>
            </div>
            <div id="news-container" class="media-masonry">
                <p class="empty-state">Loading media coverage...</p>
            </div>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const newsContainer = document.getElementById('news-container');

    const getImageUrl = (img) => {
        if (!img) return '';
        if (img.startsWith('http://') || img.startsWith('https://')) return img;
        return `http://localhost:3000${img}`;
    };

    subscribeToAllCollections((data) => {
        const news = data.news || [];
        
        // Flatten all images across news records, maintaining metadata and order
        const newsItems = [];
        news.forEach(item => {
            const images = item.images || [];
            images.forEach(img => {
                newsItems.push({
                    id: item.id,
                    title: item.title,
                    imgUrl: getImageUrl(img)
                });
            });
        });

        if (newsItems.length === 0) {
            newsContainer.innerHTML = '<p class="empty-state">No media coverage features found.</p>';
        } else {
            newsContainer.innerHTML = newsItems.map(item => `
                <a class="media-card animate-on-scroll" href="${item.imgUrl}" data-lightbox-group="news">
                    <img class="media-card__image" src="${item.imgUrl}" alt="${item.title || 'Media Coverage'}">
                </a>
            `).join('');
        }

        // Trigger animations for newly added items
        if (window.raceObserveElements) {
            window.raceObserveElements();
        }
    });
</script>

<?php get_footer(); ?>
