<?php
/* Template Name: Projects */
get_header();

race_render_page_hero(array(
    'title' => 'Projects',
    'description' => 'Long-form initiatives where RACE nurtures change through sustained participation and community ownership.',
    'image' => get_template_directory_uri() . '/images/ProjectCollaboration.jpeg',
));

$projects = array(
    array(
        'title' => 'Gurukulam',
        'folder' => 'gurukulam',
        'description' => 'Race Gurukulam is a continuing mission to create personality transformation among teens and adolescents. The residential camp is designed as an immersive journey of activity, fun, social learning, and talent discovery that helps children become confident change agents for the future.',
    ),
    array(
        'title' => 'Dhasha Vriksha',
        'folder' => 'dhashar',
        'description' => 'Started on Environment Day, Dhasha Vriksha is one of the most beloved projects of team RACE. It brought together people from different parts of the state to plant more than 150 saplings and sustain them through regular follow-up, community participation, and a shared commitment to protecting the earth.',
    ),
);
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

        <?php foreach ($projects as $index => $project) : ?>
            <div class="section-shell--compact" style="padding-top: <?php echo $index === 0 ? '0' : '40px'; ?>;">
                <article class="story-card <?php echo $index % 2 ? 'story-card--reverse' : ''; ?> animate-on-scroll">
                    <img class="story-card__image" src="<?php echo esc_url(race_get_first_image_url($project['folder'], get_template_directory_uri() . '/images/bg.jpg')); ?>" alt="<?php echo esc_attr($project['title']); ?>">
                    <div>
                        <span class="eyebrow">Flagship Project</span>
                        <h3><?php echo esc_html($project['title']); ?></h3>
                        <p><?php echo esc_html($project['description']); ?></p>
                    </div>
                </article>
                <div style="margin-top: 24px;">
                    <?php race_render_media_grid($project['folder'], array('lightbox_group' => $project['folder'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php get_footer(); ?>
