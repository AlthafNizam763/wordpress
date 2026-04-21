<?php
/* Template Name: Team Race */
get_header();

race_render_page_hero(array(
    'title' => 'Team RACE',
    'description' => 'The leadership, coordination, and volunteer energy that gives RACE its direction and character.',
    'image' => get_template_directory_uri() ,
));

$leaders = array(
    array('name' => 'MC Rajilan', 'role' => 'Founder & Chairman', 'image' => 'rajilan.png', 'points' => array('Trainer\'s Trainer & Mentor, DoPT, Govt of India', 'Trainer\'s Trainer & Author, JCI', '30+ years of excellence in HR training')),
    array('name' => 'Vinod Sreedhar', 'role' => 'Vice Chairman, Training & Creative Head', 'image' => 'vinod.png', 'points' => array('Trainer\'s Trainer & Mentor, DoPT, Govt of India', 'Trainer\'s Trainer & Author, JCI', '25+ years of excellence in HR training')),
    array('name' => 'Shaharudeen', 'role' => 'General Secretary', 'image' => 'shahrudeen.png', 'points' => array('Trainer, DoPT, Govt of India', 'National trainer of Junior Chamber International India', '20+ years of excellence in HR training')),
    array('name' => 'Dr. S Preetha', 'role' => 'Head, Guidance & Counseling Cell', 'image' => 'preetha.png', 'points' => array('Trainer and mentor', 'Guidance and counselling leadership', '20+ years of excellence in HR training')),
    array('name' => 'Reshmi Sreekanth, M.S.W', 'role' => 'Government Project Coordinator & Administrative Officer', 'image' => 'reshmi.png', 'points' => array('Coordinates public-facing projects', 'Supports administrative continuity', 'Bridges program design and execution')),
    array('name' => 'Ajmal A, M.B.A', 'role' => 'Chief Director Projects', 'image' => 'ajmal.png', 'points' => array('Oversees project direction', 'Supports program scaling', 'Strengthens execution quality')),
    array('name' => 'Noufiya N, M.Sc', 'role' => 'Chief Student Project Officer', 'image' => 'noufiya.png', 'points' => array('Connects student teams to execution', 'Supports youth-centered initiatives', 'Brings academic and project coordination together')),
);

$race_teams = array(
    array('name' => 'Arun Kumar', 'qualification' => '', 'role' => '', 'image' => 'arun-kumar.jpg'),
    array('name' => 'Jayakrishnan', 'qualification' => '', 'role' => '', 'image' => 'jayakrishnan.jpg'),
    array('name' => 'Althaf N', 'qualification' => '', 'role' => '', 'image' => 'althaf-n.jpg'),
);
?>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Leadership Team</span>
                <h2>A stronger, more premium presentation of the people behind the organisation.</h2>
            </div>
        </div>
        <div class="leaders-grid">
            <?php foreach ($leaders as $leader) : ?>
                <article class="leader-card animate-on-scroll">
                    <img class="leader-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/head/' . $leader['image']); ?>" alt="<?php echo esc_attr($leader['name']); ?>">
                    <div>
                        <span class="leader-card__role"><?php echo esc_html($leader['role']); ?></span>
                        <h3><?php echo esc_html($leader['name']); ?></h3>
                        <ul>
                            <?php foreach ($leader['points'] as $point) : ?>
                                <li><?php echo esc_html($point); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Our IT & Media Cell Team</span>
            </div>
        </div>
        <div class="grid-3">
            <?php foreach ($race_teams as $team_member) : ?>
                <?php 
                $is_circle_only = in_array($team_member['name'], array('Arun Kumar', 'Jayakrishnan', 'Althaf N'));
                ?>
                <?php if ($is_circle_only) : ?>
                    <article class="circle-member animate-on-scroll" style="text-align: center;">
                        <img class="circle-member__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/team/' . $team_member['image']); ?>" alt="<?php echo esc_attr($team_member['name']); ?>" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; margin: 0 auto 12px;">
                        <h3 class="member-card__name"><?php echo esc_html($team_member['name']); ?></h3>
                    </article>
                <?php else : ?>
                    <article class="member-card animate-on-scroll">
                        <img class="member-card__image" src="<?php echo esc_url(get_template_directory_uri() . '/images/team/' . $team_member['image']); ?>" alt="<?php echo esc_attr($team_member['name']); ?>">
                        <div>
                            <h3 class="member-card__name"><?php echo esc_html($team_member['name']); ?></h3>
                            <?php if ($team_member['qualification']) : ?>
                                <p class="member-card__role"><?php echo esc_html($team_member['qualification']); ?></p>
                            <?php endif; ?>
                            <p style="font-size: 0.85rem; color: var(--muted);"><?php echo esc_html($team_member['role']); ?></p>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
