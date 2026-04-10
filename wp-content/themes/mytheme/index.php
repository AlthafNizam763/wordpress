<?php get_header(); ?>

<!-- Hero Section -->
<section id="home" class="hero-section">
    <div class="hero-left animate-on-scroll">
        <small>Welcome to Race</small>
      <h1>Self Discovery & Personality transformation Program.</h1>
        <p>Let's Unlock Sustainable Potential</p>
        <div>
            <a href="https://wa.me/919061517298?text=Hi%20I%20want%20to%20register" target="_blank" class="btn">
            Register Now
            </a>
        </div>
    </div>
    <div class="hero-right animate-on-scroll">
        <img src="<?php echo get_template_directory_uri(); ?>/images/bg.jpg" alt="Hero Background">
    </div>
</section>

<!-- Our Solutions -->
<section id="services" class="solutions-section container animate-on-scroll">
    <div class="solutions-header">
        <h2>race for excellence</h2>
        <!-- <p>Research Academy For Creative Excellence is an NGO serving with the vision to be the trailblazers of Creative
            thoughts.</p> -->
    </div>
    <div class="solutions-grid">
        <div class="solution-card green animate-on-scroll">
            <h3 style="margin-top: 0; margin-bottom: 20px;">☆ Our Vision</h3>
            <p style="font-size: 16px; line-height: 1.6; font-weight: 300;">To be the trailblazer of creative thoughts</p>
        </div>
        <div class="solution-card grey animate-on-scroll">
            <h3 style="margin-top: 0; margin-bottom: 20px;">☆ Our Mission</h3>
            <p style="font-size: 16px; line-height: 1.6; font-weight: 400;">Instigate creative excellence and self-reliance among
                individual through systematic, strategic and holistic programming.</p>
        </div>
        <div class="solution-card black animate-on-scroll" style="background-color: #FAC150;">
            <h3 style="margin-top: 0; margin-bottom: 20px;">☆ Our Prespective</h3>
            <p style="font-size: 16px; line-height: 1.6; font-weight: 300;">With a profound vision on man and Mother Nature,<br>By holding the divine principles of universal brotherhood,  Social justice and truth,
            And sowing the seeds of creative excellence,
            The Chancellors of RACE will stride beyond the frontiers of nations
            For an exuberant realm</p>
        </div>
    </div>
</section>

<section class="container" style="padding: 60px 20px;">
    <div class="text-content animate-on-scroll"
        style="max-width: 900px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
        <h3 style="font-size: 32px; margin-bottom: 25px; color: #11823b;">About Us</h3>
        <p style="margin-bottom: 20px; color: #555; font-size: 16px; line-height: 1.8;">
            Research Academy for Creative Excellence – race is a charitable organization of people with creative
            excellence. This great tree of knowledge has different areas of activities. Training division is one among
            them. race organizes training for different sections of society including Educators, Students, Youth,
            Professionals, Corporate, Marketing Personnel, various NGOs, Business entrepreneurs to develop their
            personality in new dimensions. Adolescent, Pre marital, family counseling are other key areas in which
            Trainers of race concentrating.
        </p>
        <p style="margin-bottom: 20px; color: #555; font-size: 16px; line-height: 1.8;">
            A team of Trainers, Counselors and Doctors are in charge of race Training division. Professional Trainers
            with National and International exposure are conducting programmes by following the methodology of activity
            oriented participatory and experimental learning techniques.
        </p>
        <p style="margin-bottom: 40px; color: #555; font-size: 16px; line-height: 1.8;">race is working in association
            with many National and International
            training organizations.</p>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section container animate-on-scroll" style="padding: 80px 0; overflow: hidden;">
    <h2 style="text-align: center; margin-bottom: 50px;">Testimonials</h2>
    <div class="marquee-container">
        <div class="marquee-content">
                        <?php
$testimonials = [
    "This NGO transformed my skills through training and volunteering in impactful government and community projects.",
    "The training programs improved my confidence, leadership, and teamwork, preparing me for real social responsibilities.",
    "Volunteering with this organisation gave me practical experience and deep understanding of community development challenges.",
    "I coordinated online programs smoothly, gaining technical skills, organisational experience, and strong communication abilities daily.",
    "Working on government projects through this NGO taught discipline, responsibility, and commitment to public service.",
    "Every program was well-organised, practical, and inspiring, helping participants develop professional and personal competencies strongly.",
    "The NGO created opportunities for youth leadership, social awareness, and active participation in community initiatives.",
    "I learned teamwork and problem-solving while volunteering, making my contribution to society more meaningful today.",
    "The online training sessions were interactive, accessible, and professionally managed, enhancing learning and engagement significantly.",
    "Being part of this NGO strengthened my values, skills, and motivation to serve communities effectively."
];

$testimonial_path = get_template_directory() . '/images/testimonials/';
$testimonial_url = get_template_directory_uri() . '/images/testimonials/';

// Get all image files from the testimonials folder
$image_files = glob($testimonial_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

// Function to display an item
if (!function_exists('display_testimonial_card')) {
    function display_testimonial_card($text, $image_url, $name)
    {
        echo '<div class="testimonial-card-new">';
        echo '<div class="testimonial-img-box">';
        echo '<img src="' . $image_url . '" alt="' . esc_attr($name) . '">';
        echo '<span class="author-name">' . esc_html($name) . '</span>';
        echo '</div>';
        echo '<div class="testimonial-text-box">';
        echo '<p style="margin-bottom: 0;">' . esc_html($text) . '</p>';
        echo '<a href="#" class="read-more">Read More..</a>';
        echo '</div>';
        echo '</div>';
    }
}

if ($image_files) {
    // Loop through twice for seamless marquee
    for ($loop = 0; $loop < 2; $loop++) {
        foreach ($image_files as $index => $file) {
            $filename = basename($file);
            $img_url = $testimonial_url . $filename;

            // Clean up name from filename (e.g., Dhanu-G-S.jpg -> Dhanu G S)
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $name = str_replace(['-', '_', '.'], ' ', $name);
            $name = ucwords(strtolower($name));

            // Pick a testimonial text (cycle if more images than texts, but here it's likely vice versa)
            $text = $testimonials[$index % count($testimonials)];

            display_testimonial_card($text, $img_url, $name);
        }
    }
}
else {
    echo '<p>No testimonials found.</p>';
}
?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="container animate-on-scroll" style="padding-bottom: 60px;">
    <div class="stats-banner">
        <div class="stat-item">
            <h3 data-target="150">0</h3>
            <p>Volunteer</p>
        </div>
        <div class="stat-item">
            <h3 data-target="20">0</h3>
            <p>Events</p>
        </div>
        <div class="stat-item">
            <h3 data-target="120">0</h3>
            <p>Experienced Masters</p>
        </div>
    </div>
</section>


<!-- Text Banner -->
<!-- <div class="text-banner">
    <h2>Lorem Ipsum is Simply Dummy?</h2>
</div> -->

<!-- Video Section -->
<!-- <section class="video-section">
    <div class="play-btn">▶</div>
</section> -->

<!-- Video Thumbnails -->
<!-- <section class="video-thumbs">
    <div class="thumbs-container">
        <div class="thumb-item">▶</div>
        <div class="thumb-item">▶</div>
        <div class="thumb-item">▶</div>
        <div class="thumb-item">▶</div>
    </div>
</section> -->

<!-- Split Content 1 -->
<section class="container" style="text-align: center; padding-top: 60px;">
    <h2 style="margin-bottom: 10px; font-size: 36px;">What We Do @ race</h2>
</section>
<section class="container content-split animate-on-scroll">
    <div class="text-content">
        <div class="icon-wrapper"><i class="fas fa-chalkboard-user"></i></div>
        <h3>Programs & Training</h3>
        <p style="margin-bottom: 20px; color: #666;">Exhibits a collection of Programs and projects that can foster the
            determinations of every individuals.</p>
    </div>
    <div class="">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ProgramsTraining.jpeg" alt="Programs & Training">
    </div>
</section>

<!-- Split Content 2 -->
<section class="container content-split animate-on-scroll">
    <div class="">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ResearchDevelopment.jpeg"
            alt="Research & Development">
    </div>
    <div class="text-content">
        <div class="icon-wrapper"><i class="fas fa-flask"></i></div>
        <h3>Research & Development</h3>
        <p style="margin-bottom: 20px; color: #666;">RACE educates the public, fosters development, and gives people the
            tools they need to become trailblazers.</p>
    </div>
</section>

<!-- Split Content 3 -->
<section class="container content-split animate-on-scroll">
    <div class="text-content">
        <div class="icon-wrapper"><i class="fas fa-users"></i></div>
        <h3>Project & Collaboration</h3>
        <p style="margin-bottom: 20px; color: #666;">Each individual contributes effectively to shared goals, fostering
            personal growth and organizational success through collaborative teamwork with government and community stakeholders.</p>
    </div>
    <div class="">
        <img src="<?php echo get_template_directory_uri(); ?>/images/ProjectCollaboration.jpeg"
            alt="Project & Collaboration">
    </div>
</section>

<!-- Brands/Logos -->
<!-- <section class="container" style="text-align: center; padding: 50px 0;">
    <h2 style="margin-bottom: 40px;">LOREM IPSUM</h2>
    <div style="font-size: 60px; color: #ccc; letter-spacing: 20px;">LOGO LOGO LOGO LOGO</div>
</section> -->

<!-- Checklist Section -->
<!-- <section class="container content-split">
    <div class="text-content">
        <h3 style="margin-bottom: 30px;">LOREM IPSUM & SIMPLY DUMMY</h3>
        <ul style="list-style: none;">
            <li
                style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <span>Lorem ipsum dolor sit amet</span>
                <span style="color: #7bb862;">✔</span>
            </li>
            <li
                style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <span>Consectetur adipiscing elit</span>
                <span style="color: #7bb862;">✔</span>
            </li>
            <li
                style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <span>Sed do eiusmod tempor incididunt</span>
                <span style="color: #7bb862;">✔</span>
            </li>
            <li
                style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <span>Ut labore et dolore magna aliqua</span>
                <span style="color: #7bb862;">✔</span>
            </li>
        </ul>
    </div>
    <div class="image-content"></div>
</section> -->

<!-- 4 Column Info -->
<!-- <section class="container" style="padding: 80px 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h2>Lorem Ipsum</h2>
        <a href="#" class="btn primary">View More</a>
    </div>
    <div class="grid-4" style="gap: 50px;">
        <div>
            <h4 style="color: #eab308; margin-bottom: 20px;">TITLE</h4>
            <p style="font-size: 13px; color: #666; line-height: 1.8; margin-bottom: 20px;">Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut elit tellus.</p>
            <a href="#" class="read-more">Read More</a>
        </div>
        <div>
            <h4 style="color: #eab308; margin-bottom: 20px;">TITLE</h4>
            <p style="font-size: 13px; color: #666; line-height: 1.8; margin-bottom: 20px;">Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut elit tellus.</p>
            <a href="#" class="read-more">Read More</a>
        </div>
        <div>
            <h4 style="color: #eab308; margin-bottom: 20px;">TITLE</h4>
            <p style="font-size: 13px; color: #666; line-height: 1.8; margin-bottom: 20px;">Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut elit tellus.</p>
            <a href="#" class="read-more">Read More</a>
        </div>
        <div>
            <h4 style="color: #eab308; margin-bottom: 20px;">TITLE</h4>
            <p style="font-size: 13px; color: #666; line-height: 1.8; margin-bottom: 20px;">Lorem ipsum dolor sit amet,
                consectetur adipiscing elit. Ut elit tellus.</p>
            <a href="#" class="read-more">Read More</a>
        </div>
    </div>
</section> -->

<!-- 3 Grid Image Section -->
<!-- <section class="container" style="margin-bottom: 80px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h2>Lorem Ipsum</h2>
        <a href="#" class="btn">View More</a>
    </div>
    <div class="solutions-grid" style="gap: 30px;">
        <div
            style="background: #ccc; height: 300px; padding: 30px; display: flex; flex-direction: column; justify-content: flex-end;">
            <h3>Lorem Ipsum</h3>
            <p style="font-size: 12px; margin-bottom: 10px;">Lorem ipsum dolor sit amet</p>
            <a href="#" style="color: black; font-weight: bold;">Read More</a>
        </div>
        <div
            style="background: #ccc; height: 300px; padding: 30px; display: flex; flex-direction: column; justify-content: flex-end;">
            <h3>Lorem Ipsum</h3>
            <p style="font-size: 12px; margin-bottom: 10px;">Lorem ipsum dolor sit amet</p>
            <a href="#" style="color: black; font-weight: bold;">Read More</a>
        </div>
        <div
            style="background: #ccc; height: 300px; padding: 30px; display: flex; flex-direction: column; justify-content: flex-end;">
            <h3>Lorem Ipsum</h3>
            <p style="font-size: 12px; margin-bottom: 10px;">Lorem ipsum dolor sit amet</p>
            <a href="#" style="color: black; font-weight: bold;">Read More</a>
        </div>
    </div>
</section> -->

<!-- Contact Form Section -->
<!-- <section id="contact" class="contact-section">
    <div class="contact-left"> -->
<!-- Map or Image -->
<!-- </div>
    <div class="contact-right">
        <h2 style="margin-bottom: 10px;">Lorem Ipsum Has Been</h2>
        <h2 style="margin-bottom: 40px;">The Industry's</h2>

        <form>
            <div class="form-group">
                <input type="text" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Subject">
            </div>
            <div class="form-group">
                <textarea rows="4" placeholder="Message"></textarea>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</section> -->

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const counters = document.querySelectorAll(".stat-item h3");

        const startCounter = (counter) => {
            const target = +counter.getAttribute("data-target");
            let count = 0;
            const speed = target / 40; // speed control

            const updateCount = () => {
                count += speed;
                if (count < target) {
                    counter.innerText = Math.ceil(count);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target + "+";
                }
            };

            updateCount();
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCounter(entry.target);
                    observer.unobserve(entry.target); // run only once
                }
            });
        }, { threshold: 0.6 });

        counters.forEach(counter => observer.observe(counter));
    });
</script>


<?php get_footer(); ?>