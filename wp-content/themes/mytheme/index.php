<?php
get_header();

$hero_video = get_template_directory() . '/videos/home.mp4';
$hero_video_url = file_exists($hero_video) ? get_template_directory_uri() . '/videos/home.mp4' : '';
$testimonial_images = race_get_image_files('testimonials');
$testimonials = array(
    'This space helped me discover confidence, clarity, and a stronger sense of purpose in how I serve my community.',
    'The sessions are practical, warm, and deeply transformative. You leave with tools you can use immediately.',
    'RACE creates the rare kind of environment where learning, leadership, and compassion genuinely grow together.',
    'Volunteering here gave me real responsibility, stronger communication, and a deeper understanding of social impact.',
);
?>

<section class="hero-home hero-home--cinematic">
    <?php if ($hero_video_url) : ?>
        <video class="hero-home__video" autoplay muted loop playsinline>
            <source src="<?php echo esc_url($hero_video_url); ?>" type="video/mp4">
        </video>
    <?php endif; ?>
    <div class="hero-home__overlay"></div>
    <div class="container">
        <div class="hero-home__cinematic-content animate-on-scroll">
            <h1>Research Academy <span>For Creative Excellence</span></h1>
            <p>A charitable organization providing activity-based training for educators, students, youth, professionals, and entrepreneurs, led by expert trainers with global collaborations.</p>
            <div class="hero-home__actions">
                <a href="<?php echo esc_url(race_get_page_url('ongoing-events')); ?>" class="btn">Register Now <i class="fas fa-arrow-right"></i></a>
                <a href="<?php echo esc_url(race_get_page_url('courses-training')); ?>" class="btn btn--hero-outline">Explore Programs <i class="fas fa-chevron-down"></i></a>
            </div>
        </div>
        <div class="hero-home__stats hero-home__stats--floating animate-on-scroll">
            <div class="hero-home__stat"><strong data-target="150" data-suffix="+">0</strong><span>Active volunteers</span></div>
            <div class="hero-home__stat"><strong data-target="20" data-suffix="+">0</strong><span>Programs delivered</span></div>
            <div class="hero-home__stat"><strong data-target="120" data-suffix="+">0</strong><span>Experienced mentors</span></div>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Why RACE</span>
                <h2>A more thoughtful, more immersive way to grow.</h2>
            </div>
            <p>We blend strategic training, social responsibility, counselling, and youth leadership into a modern ecosystem that feels aspirational while staying deeply grounded in real community work.</p>
        </div>

        <div class="grid-3">
            <article class="feature-card animate-on-scroll">
                <span class="feature-card__icon"><i class="fas fa-seedling"></i></span>
                <h3>Our Vision</h3>
                <p>To be the trailblazer of creative thoughts.</p>
            </article>
            <article class="feature-card animate-on-scroll">
                <span class="feature-card__icon"><i class="fas fa-compass"></i></span>
                <h3>Our Mission</h3>
                <p>Instigate creative excellence and self-reliance among individuals through systematic, strategic, and holistic programs.</p>
            </article>
            <article class="feature-card animate-on-scroll">
                <span class="feature-card__icon"><i class="fas fa-globe"></i></span>
                <h3>Our Perspective</h3>
                <p>With a profound vision on man and Mother Nature,<br>
                By holding the divine principles of universal brotherhood, Social justice and truth, And sowing the seeds of creative excellence, The Chancellors of race will stride beyond the frontiers of nations For an exuberant realm.</p>
            </article>
        </div>
    </div>
</section>

<section class="section-shell">
    <div class="container">
        <div class="surface-panel animate-on-scroll" style="padding: 38px;">
            <div class="section-header" style="margin-bottom: 20px;">
                <div>
                    <span class="eyebrow">About RACE</span>
                    <h2>Training that reaches students, youth, families, professionals, and institutions.</h2>
                </div>
            </div>
            <div class="grid-2">
                <p>Research Academy for Creative Excellence is a charitable organisation powered by people committed to creative growth and meaningful social change. The training division is one of its core strengths, serving educators, students, youth, professionals, corporates, NGOs, entrepreneurs, and families.</p>
                <p>With trainers, counsellors, and doctors working together, RACE delivers participatory, activity-based, and experiential learning programs with both national and international exposure. The result is not just learning, but transformation that lasts.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">What We Do</span>
                <h2>Three pillars that shape the RACE experience.</h2>
            </div>
            <a href="<?php echo esc_url(race_get_page_url('action-plan')); ?>" class="btn btn--ghost">See the Action Plan</a>
        </div>

        <div class="story-grid">
            <article class="story-card animate-on-scroll">
                <img class="story-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/ProgramsTraining.jpeg'); ?>" alt="Programs and training">
                <div>
                    <span class="eyebrow">Programs &amp; Training</span>
                    <h3>Designed to unlock potential through immersive learning.</h3>
                    <p>We create practical, energising programs that help participants build confidence, communication, leadership, and a stronger inner compass.</p>
                    <a href="<?php echo esc_url(race_get_page_url('courses-training')); ?>" class="btn btn--ghost">Explore programs</a>
                </div>
            </article>

            <article class="story-card story-card--reverse animate-on-scroll">
                <img class="story-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/ResearchDevelopment.jpeg'); ?>" alt="Research and development">
                <div>
                    <span class="eyebrow">Research &amp; Development</span>
                    <h3>Grounded in insight, shaped for the realities people face now.</h3>
                    <p>RACE studies needs carefully, adapts its methods intelligently, and develops programs that respond to current social and human challenges.</p>
                    <a href="<?php echo esc_url(race_get_page_url('features-news')); ?>" class="btn btn--ghost">See public impact</a>
                </div>
            </article>

            <article class="story-card animate-on-scroll" style="grid-column: 1 / -1;">
                <img class="story-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/ProjectCollaboration.jpeg'); ?>" alt="Projects and collaboration">
                <div>
                    <span class="eyebrow">Projects &amp; Collaboration</span>
                    <h3>Partnerships that turn ideas into community outcomes.</h3>
                    <p>Our work grows stronger through collaborative execution with institutions, stakeholders, and changemakers who care about measurable, people-centered progress.</p>
                    <a href="<?php echo esc_url(race_get_page_url('collaborations')); ?>" class="btn btn--ghost">View collaborations</a>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Impact Snapshot</span>
                <h2>Built around trust, participation, and lived outcomes.</h2>
            </div>
            <p>Every initiative is designed to move people from passive participation to personal ownership, collective responsibility, and sustained growth.</p>
        </div>

        <div class="grid-4">
            <article class="impact-card animate-on-scroll"><strong>Students</strong><p>Programs that help young people discover identity, skills, and direction.</p></article>
            <article class="impact-card animate-on-scroll"><strong>Youth</strong><p>Leadership pathways that convert energy into clarity and positive social contribution.</p></article>
            <article class="impact-card animate-on-scroll"><strong>Families</strong><p>Counselling and support spaces that strengthen emotional wellbeing and resilience.</p></article>
            <article class="impact-card animate-on-scroll"><strong>Institutions</strong><p>Custom training and collaborative projects shaped to real organisational needs.</p></article>
        </div>
    </div>
</section>

<section class="section-shell">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Voices From The Community</span>
                <h2>The experience feels personal because the work is personal.</h2>
            </div>
        </div>
        <div class="testimonials-carousel animate-on-scroll">
            <div class="testimonials-carousel__track">
                <?php foreach ($testimonial_images as $index => $image) : ?>
                    <?php
                    $name = ucwords(str_replace(array('-', '_'), ' ', pathinfo(basename($image), PATHINFO_FILENAME)));
                    $quote = $testimonials[$index % count($testimonials)];
                    $image_url = trailingslashit(get_template_directory_uri()) . 'images/testimonials/' . basename($image);
                    ?>
                    <article class="leader-card">
                        <img class="leader-card__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>">
                        <div>
                            <span class="leader-card__role">Community voice</span>
                            <h3><?php echo esc_html($name); ?></h3>
                            <p><?php echo esc_html($quote); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
                <!-- Duplicate items for seamless loop -->
                <?php foreach ($testimonial_images as $index => $image) : ?>
                    <?php
                    $name = ucwords(str_replace(array('-', '_'), ' ', pathinfo(basename($image), PATHINFO_FILENAME)));
                    $quote = $testimonials[$index % count($testimonials)];
                    $image_url = trailingslashit(get_template_directory_uri()) . 'images/testimonials/' . basename($image);
                    ?>
                    <article class="leader-card">
                        <img class="leader-card__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>">
                        <div>
                            <span class="leader-card__role">Community voice</span>
                            <h3><?php echo esc_html($name); ?></h3>
                            <p><?php echo esc_html($quote); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="glass-panel animate-on-scroll" style="padding: 38px;">
            <div class="section-header" style="margin-bottom: 18px;">
                <div>
                    <span class="eyebrow">Take The Next Step</span>
                    <h2>Join a movement that makes growth feel purposeful.</h2>
                </div>
                <p>Whether you want to register, collaborate, volunteer, or simply start a conversation, there is a clear pathway into the RACE community.</p>
            </div>
            <div class="hero-home__actions" style="margin-top: 0;">
                <a href="<?php echo esc_url(race_get_page_url('your-voice-matters')); ?>" class="btn">Send Your Voice</a>
                <a href="<?php echo esc_url(race_get_page_url('gallery')); ?>" class="btn btn--ghost">View the Gallery</a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
