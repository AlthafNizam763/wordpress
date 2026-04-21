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
            <?php race_render_media_grid('news', array('columns' => 'masonry', 'lightbox_group' => 'news')); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
