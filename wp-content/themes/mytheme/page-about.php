<?php
/* Template Name: About Us */
get_header();

race_render_page_hero(array(
    'title' => 'Chairman\'s Desk',
    'description' => 'A personal note on the mission, philosophy, and human-centered future of RACE.',
    'image' => get_template_directory_uri() ,
));
?>

<section class="section-shell">
    <div class="container">
        <div class="story-grid">
            <article class="story-card animate-on-scroll">
                <img class="story-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/head/rajilan.png'); ?>" alt="MC Rajilan">
                <div>
                    <span class="eyebrow">Warm Welcome</span>
                    <h3>RACE is built to help people grow with clarity, courage, and contribution.</h3>
                    <p>At RACE, we believe the journey to excellence is never a solitary path. It is a collaborative flight powered by mentorship, thoughtful systems, and a shared commitment to helping people discover their highest potential.</p>
                    <p>Our training division supports students, professionals, entrepreneurs, educators, NGOs, and families through holistic learning and counselling spaces that respond to both personal and social realities.</p>
                </div>
            </article>

            <article class="surface-panel animate-on-scroll" style="padding: 32px;">
                <span class="eyebrow">Chairman&rsquo;s Message</span>
                <h2 style="font-size: 3rem;">Wings to fly with confidence and purpose.</h2>
                <p>We often say that the strongest elements that help an organisation move toward its destination are the wings it builds into people. Those wings are created through precise vision, practical methods, and an honest belief that every individual can rise further.</p>
                <p>Whether you are a student seeking direction, a professional pursuing growth, or an entrepreneur preparing to lead, RACE exists to offer structure, insight, and encouragement that can carry you forward.</p>
                <p>Our invitation is simple: join us, build with us, and become part of a community where growth is deeply human and excellence is meaningful.</p>
                <p style="color: var(--text); font-weight: 800; margin-top: 1.2rem;">MC Rajilan<br><span style="color: var(--muted); font-weight: 600; font-size: 0.95rem;">Founder &amp; Chairman</span></p>
            </article>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">What Guides Us</span>
                <h2>The values behind the work.</h2>
            </div>
            <p>RACE is most effective when the design of a program is matched by the integrity of the people delivering it.</p>
        </div>
        <div class="grid-3">
            <article class="feature-card animate-on-scroll">
                <span class="feature-card__icon"><i class="fas fa-lightbulb"></i></span>
                <h3>Clarity</h3>
                <p>We design programs around real human needs rather than generic activity.</p>
            </article>
            <article class="feature-card animate-on-scroll">
                <span class="feature-card__icon"><i class="fas fa-hands-helping"></i></span>
                <h3>Care</h3>
                <p>Growth is supported through empathy, counselling, and a culture of trust.</p>
            </article>
            <article class="feature-card animate-on-scroll">
                <span class="feature-card__icon"><i class="fas fa-people-group"></i></span>
                <h3>Collective Progress</h3>
                <p>We help individuals flourish in ways that strengthen their families, institutions, and communities.</p>
            </article>
        </div>
    </div>
</section>

<?php get_footer(); ?>
