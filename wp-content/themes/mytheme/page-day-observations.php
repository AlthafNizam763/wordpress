<?php
/* Template Name: Day Observations */
get_header();

race_render_page_hero(array(
    'title' => 'Day Observations',
    'description' => 'A curated archive of awareness days, cultural observances, and public education moments documented through the RACE lens.',
    'image' => get_template_directory_uri() . '/images/gallerybg.png',
));

$observations = array(
    array('title' => 'International & National Youth Day', 'folder' => 'bio-farming', 'text' => 'A bio-farming initiative that empowered youth to engage with sustainable cultivation and link food, health, and environmental responsibility.'),
    array('title' => 'Onam Celebration', 'folder' => 'onam', 'text' => 'Student artwork blended cultural celebration with pandemic awareness, showing resilience, tradition, and youthful creativity.'),
    array('title' => 'World Kindness Day', 'folder' => 'kindness', 'text' => 'A virtual observance designed to promote compassion, community spirit, and meaningful digital participation.'),
    array('title' => 'National Girl Child Day', 'folder' => 'girl-child', 'text' => 'A writing-based observance focused on gender equality, dignity, and the role of the girl child in building a better tomorrow.'),
    array('title' => 'Father\'s Day', 'folder' => 'father', 'text' => 'A special online celebration honoring founder chairman Rajilan MC and the guiding role he has played in the RACE family.'),
    array('title' => 'International Men\'s Day', 'folder' => 'men', 'text' => 'A reflection-driven observance that invited participants to appreciate the multifaceted role of men in society.'),
    array('title' => 'International Yoga Day', 'folder' => 'yoga', 'text' => 'A wellness-focused session that highlighted harmony, mindfulness, and the practical value of yoga in daily life.'),
    array('title' => 'Malala Day', 'folder' => 'malala', 'text' => 'A celebration of education, activism, and social responsibility featuring student leadership and inspiring community voices.'),
    array('title' => 'Pusthaka Cheppu Thurannappol', 'folder' => 'pusthaka', 'text' => 'A reading week initiative that encouraged participants to share books, insights, and a deeper culture of knowledge exchange.'),
    array('title' => 'Mother\'s Day: Thalolam', 'folder' => 'thalolam', 'text' => 'An online Mother\'s Day family meetup that blended appreciation, community engagement, and thoughtful event design.'),
    array('title' => 'Women\'s Day', 'folder' => 'women', 'text' => 'A virtual celebration of womanhood and empowerment built around recognition, dignity, and collective admiration.'),
    array('title' => 'World NGO Day', 'folder' => 'ngo', 'text' => 'A public conversation on the role of NGOs, featuring distinguished guests and highlighting social excellence in action.'),
    array('title' => 'Republic Day Celebration', 'folder' => 'rep', 'text' => 'A simple but significant observance celebrating civic identity and the value of collective belonging.'),
    array('title' => 'Susthiravikas', 'folder' => 'susthiravikas', 'text' => 'A youth-focused voter awareness initiative combining quizzes, digital engagement, and active citizenship.'),
    array('title' => 'Army Day Celebration', 'folder' => 'armyday', 'text' => 'A commemorative programme honoring military service, sacrifice, and national pride through interviews and documentary storytelling.'),
    array('title' => 'Christmas Celebration', 'folder' => 'christmasday', 'text' => 'A festive observance that added warmth, togetherness, and seasonal community spirit to the yearly calendar.'),
    array('title' => 'World Human Rights Day', 'folder' => 'worldhumanrightday', 'text' => 'A virtual event centered on human rights, political economy, and meaningful public discussion.'),
    array('title' => 'UN Day Celebration', 'folder' => 'unday', 'text' => 'A future-facing discussion aligned with the UN75 initiative and the theme of shaping our future together.'),
    array('title' => 'World Mental Health Day', 'folder' => 'worldmentalhealthday', 'text' => 'An awareness programme led by expert guidance that emphasized mental health advocacy and community support.'),
    array('title' => 'Heart Day', 'folder' => 'heartday', 'text' => 'A medical awareness session focused on healthy living, heart rhythm, and accessible public education.'),
    array('title' => 'Energy Conservation Day', 'folder' => 'energyconservationday', 'text' => 'A visual awareness campaign that reinforced energy responsibility and practical conservation habits.'),
);
?>

<section class="section-shell">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Observation Archive</span>
                <h2>Awareness days presented with more clarity and better browsing flow.</h2>
            </div>
            <p>Each observation now reads like a polished editorial section, with cleaner hierarchy and image handling that works much better across devices.</p>
        </div>

        <div style="display: grid; gap: 36px;">
            <?php foreach ($observations as $item) : ?>
                <article class="archive-card animate-on-scroll" style="padding: 30px;">
                    <span class="eyebrow">Day Observation</span>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                    <div style="margin-top: 20px;">
                        <?php race_render_day_observation_images($item['folder']); ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
