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
            <article class="story-card animate-on-scroll">
                <img class="story-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/oorjjakiran.jpg'); ?>" alt="Oorjjakiran">
                <div>
                    <span class="eyebrow">Featured Collaboration</span>
                    <h3>Oorjjakiran</h3>
                    <p>Oorjjakiran is one of the State Government program initiatives connected to EMC and structured in partnership with RACE. The campaign spreads awareness about careful electricity use and the importance of conserving energy.</p>
                    <p>By involving both parents and students, the initiative moves beyond awareness into daily behavioral change, making the collaboration practical, educational, and community-based.</p>
                </div>
            </article>

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

<?php get_footer(); ?>
