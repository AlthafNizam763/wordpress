<?php
/* Template Name: Courses & Training */
get_header();

race_render_page_hero(array(
    'title' => 'Courses & Training',
    'description' => 'A curated set of learning experiences designed for students, trainers, professionals, women, and broader community groups.',
    'image' => get_template_directory_uri() . '/images/ProgramsTraining.jpeg',
));

$categories = array(
    array('title' => 'Training Programmes for Students', 'items' => array(
        array('title' => 'Disha', 'folder' => 'disha', 'text' => 'A flagship programme designed during the COVID-19 period to reduce student stress, restore emotional balance, and help young people rediscover themselves through meaningful interaction.'),
        array('title' => 'Hope', 'folder' => 'hope', 'text' => 'A future-shaping initiative for higher secondary students focused on skills, passions, perspectives, and career-oriented confidence.'),
    )),
    array('title' => 'Training Programmes for Youth', 'items' => array(
        array('title' => 'Meliora', 'folder' => 'meliora', 'text' => 'A focused programme for student leaders that builds confidence, determination, and readiness for purposeful leadership.'),
    )),
    array('title' => 'Training Programmes for Trainers', 'items' => array(
        array('title' => 'Diamond Cutter', 'folder' => 'diamond-cutter', 'text' => 'A high-energy train-the-trainer residential workshop built around practical tools, learner-centered facilitation, and current training realities.'),
    )),
    array('title' => 'Entrepreneurs & Professionals', 'items' => array(
        array('title' => 'B.M.W', 'folder' => '', 'text' => 'A demand-based programme for entrepreneurs, marketing teams, and management professionals focused on business growth and performance.'),
        array('title' => 'Sharpen Ur Saw', 'folder' => '', 'text' => 'A self-renewal programme for professionals that supports physical, social, emotional, mental, and spiritual balance.'),
    )),
    array('title' => 'Women Empowerment', 'items' => array(
        array('title' => 'Karuthal', 'folder' => 'karuthal', 'text' => 'An online training and Q&A initiative supporting the physical, mental, and social wellbeing of adolescent girls.'),
        array('title' => 'Arjidha', 'folder' => '', 'text' => 'A programme designed to help women, especially household women, identify their potential and become confident entrepreneurs.'),
    )),
    array('title' => 'General / Common', 'items' => array(
        array('title' => 'Hastha', 'folder' => 'hastha', 'text' => 'A customised programme developed for elderly and differently abled communities through needs-based research and compassionate facilitation.'),
        array('title' => 'Public Speaking Course', 'folder' => 'psc', 'text' => 'An annual programme that helps participants become more confident speakers, presenters, and interview candidates.'),
        array('title' => 'FYFO', 'folder' => 'fyfo', 'text' => 'A public speaking and presentation programme with wide appeal, helping participants from many backgrounds communicate more effectively.'),
        array('title' => 'FACE', 'folder' => 'face', 'text' => 'A one-day online awareness programme introducing civil service aspirations, opportunities, and the right direction for students.'),
        array('title' => 'Cancer Prevention Awareness', 'folder' => 'cancer-awareness', 'text' => 'A virtual awareness session organised jointly with medical leadership to promote public understanding of cancer prevention.'),
    )),
);
?>

<section class="section-shell">
    <div class="container">
        <?php foreach ($categories as $category) : ?>
            <div class="section-shell--compact" style="padding-top: 0;">
                <div class="section-header animate-on-scroll">
                    <div>
                        <span class="eyebrow">Training Cluster</span>
                        <h2><?php echo esc_html($category['title']); ?></h2>
                    </div>
                </div>
                <div class="program-grid">
                    <?php foreach ($category['items'] as $item) : ?>
                        <article class="program-card animate-on-scroll">
                            <?php if (!empty($item['folder'])) : ?>
                                <img class="program-card__image" src="<?php echo esc_url(race_get_first_image_url($item['folder'], get_template_directory_uri() . '/images/bg.jpg')); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                            <?php endif; ?>
                            <div class="program-card__copy">
                                <span class="program-card__tag"><?php echo esc_html($category['title']); ?></span>
                                <h3><?php echo esc_html($item['title']); ?></h3>
                                <p><?php echo esc_html($item['text']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php get_footer(); ?>
