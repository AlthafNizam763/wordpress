<?php
/* Template Name: Ongoing & Past Events */
get_header();

race_render_page_hero(array(
    'title' => 'Ongoing & Past Events',
    'description' => 'A polished archive of featured programmes, milestone moments, and the energy that keeps the RACE calendar moving.',
    'image' => get_template_directory_uri() ,
));

$featured = array(
    array(
        'title' => 'Race Gurukulam 2k26 in Association with IMA Kollam',
        'date' => 'April 10-11, 2026',
        'text' => 'A self discovery and personality transformation programme for students aged 12 to 18, designed as an immersive growth experience.',
        'image' => get_template_directory_uri() . '/images/gurukulam26.jpeg',
        'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdX4lwtw9ggMoNBSBJ-XphIIYLn-Cxi4ud5CfMwrlN_364WWQ/viewform?usp=publish-editor',
    ),
);

$archive = array(
    array('date' => 'December 2025', 'title' => 'Annual Charity Gathering', 'text' => 'A reflective close to the year with community partners, supporters, and beneficiaries sharing the impact made possible together.'),
    array('date' => 'October 2025', 'title' => 'Youth Leadership Summit', 'text' => 'A focused gathering for student leaders exploring responsibility, confidence, and the future role of youth-led change.'),
    array('date' => 'August 2025', 'title' => 'Community Innovation Sessions', 'text' => 'A collaborative format where ideas for social good were prototyped and discussed with practical follow-through in mind.'),
    array('date' => 'June 2025', 'title' => 'Environmental Outreach Drive', 'text' => 'A public-facing effort that combined awareness, action, and sustained follow-up around environmental responsibility.'),
);
?>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Featured Programme</span>
                <h2>Designed to feel current, premium, and easy to act on.</h2>
            </div>
        </div>
        <div class="grid-2">
            <?php foreach ($featured as $event) : ?>
                <article class="story-card animate-on-scroll" style="grid-column: 1 / -1;">
                    <img class="story-card__image" src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr($event['title']); ?>">
                    <div>
                        <span class="leader-card__role">Featured Event</span>
                        <h3><?php echo esc_html($event['title']); ?></h3>
                        <p><strong style="color: var(--primary);">Scheduled:</strong> <?php echo esc_html($event['date']); ?></p>
                        <p><?php echo esc_html($event['text']); ?></p>
                        <a href="<?php echo esc_url($event['url']); ?>" class="btn" target="_blank" rel="noreferrer">Register Now</a>
                    </div>
                </article>
            <?php endforeach; ?>
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
        <div class="timeline-list">
            <?php foreach ($archive as $item) : ?>
                <article class="timeline-card animate-on-scroll">
                    <span class="timeline-card__date"><?php echo esc_html($item['date']); ?></span>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
