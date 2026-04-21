<?php
/* Template Name: Action Plan */
get_header();

race_render_page_hero(array(
    'title' => 'Action Plan',
    'description' => 'A curated hub for the initiatives, training, projects, and public-facing work that define the RACE roadmap.',
    'image' => get_template_directory_uri() . '/images/ProjectCollaboration.jpeg',
));

$items = array(
    array('title' => 'Ongoing & Past Events', 'text' => 'Track live opportunities and revisit flagship programs that shaped the community.', 'icon' => 'fa-calendar-check', 'url' => race_get_page_url('ongoing-events')),
    array('title' => 'Courses & Training', 'text' => 'Explore the learning tracks built for students, trainers, professionals, and leaders.', 'icon' => 'fa-chalkboard-user', 'url' => race_get_page_url('courses-training')),
    array('title' => 'Projects', 'text' => 'See the long-form initiatives where RACE translates ideas into sustained impact.', 'icon' => 'fa-diagram-project', 'url' => race_get_page_url('projects')),
    array('title' => 'Day Observations', 'text' => 'Celebrate awareness campaigns, cultural observances, and public education moments.', 'icon' => 'fa-sun', 'url' => race_get_page_url('day-observations')),
    array('title' => 'Collaborations', 'text' => 'Discover partner-led work with institutions, communities, and public stakeholders.', 'icon' => 'fa-handshake', 'url' => race_get_page_url('collaborations')),
    array('title' => 'Features in News', 'text' => 'Browse external visibility and media moments that highlight RACE in the public sphere.', 'icon' => 'fa-newspaper', 'url' => race_get_page_url('features-news')),
);
?>

<section class="section-shell">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Explore The Ecosystem</span>
                <h2>Everything important, organised in one premium overview.</h2>
            </div>
            <p>The Action Plan page works as a directional layer, helping visitors move quickly into the part of the organisation most relevant to them.</p>
        </div>
        <div class="grid-3">
            <?php foreach ($items as $item) : ?>
                <article class="feature-card animate-on-scroll">
                    <span class="feature-card__icon"><i class="fas <?php echo esc_attr($item['icon']); ?>"></i></span>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                    <a href="<?php echo esc_url($item['url']); ?>" class="btn btn--ghost">Open Section</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
