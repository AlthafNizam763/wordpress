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
            <?php race_render_media_grid('changemaker', array('columns' => 'masonry', 'lightbox_group' => 'changemaker')); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
