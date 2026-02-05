<?php get_header(); ?>

<!-- Hero Section -->
<section id="home" class="hero-section">
    <div class="hero-left">
        <small>Welcome to Race</small>
        <h1>You have to dream before your Dream Can come True</h1>
        <p>By APJ Abdul Kalam</p>
        <div>
            <a href="#" class="btn">Contact Us</a>
        </div>
    </div>
    <div class="hero-right">
        <img src="<?php echo get_template_directory_uri(); ?>/images/bg.jpg" alt="Hero Background">
    </div>
</section>

<!-- Our Solutions -->
<section id="services" class="solutions-section container">
    <div class="solutions-header">
        <h2>Race to Excellence</h2>
        <p>Research Academy For Creative Excellence is an NGO serving with the vision to be the trailblazers of Creative
            thoughts.</p>
    </div>
    <div class="solutions-grid">
        <div class="solution-card green">
            <h3>☆ Our Vision</h3>
            <p style="font-size: 12px; margin-bottom: 20px;">To be the trailblazer of creative thoughts</p>
        </div>
        <div class="solution-card grey">
            <h3>☆ Our Mission</h3>
            <p style="font-size: 12px; margin-bottom: 20px;">Instigate creative excellence and self-reliance among
                individual through systematic, strategic and holistic programming.</p>
        </div>
        <div class="solution-card black">
            <h3>☆ Our Prespective</h3>
            <p style="font-size: 12px; margin-bottom: 20px;">With profound perception on man and mother nature, by
                holding the divine principles of universal brotherhood, social justice and truth, sowing the seeds of
                creative excellence.</p>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section container" style="padding: 80px 0; overflow: hidden;">
    <h2 style="text-align: center; margin-bottom: 50px;">Testimonials</h2>
    <div class="marquee-container">
        <div class="marquee-content">
            <?php
            $members_path = get_template_directory() . '/images/members/';
            $members_url = get_template_directory_uri() . '/images/members/';
            $images = glob($members_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

            if ($images) {
                // Function to display an item
                function display_testimonial_item($image, $url)
                {
                    $filename = basename($image);
                    // Remove extension
                    $name = preg_replace('/\.[^.]+$/', '', $filename);
                    // Replace hyphens/underscores with spaces
                    $name = str_replace(array('-', '_'), ' ', $name);

                    echo '<div class="testimonial-item">';
                    echo '<img src="' . $url . $filename . '" alt="' . esc_attr($name) . '" class="testimonial-bg">';
                    echo '<div class="testimonial-overlay"></div>';
                    echo '<div class="testimonial-content">';
                    echo '<div class="author-info">';
                    echo '<h4>' . esc_html($name) . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // Loop 1: Original Items
                foreach ($images as $image) {
                    display_testimonial_item($image, $members_url);
                }

                // Loop 2: Duplicate Items for Seamless Loop (Repeat the set)
                foreach ($images as $image) {
                    display_testimonial_item($image, $members_url);
                }
            } else {
                echo '<p style="text-align:center; color:#999;">No testimonials found.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="container" style="padding-bottom: 60px;">
    <div class="stats-banner">
        <div class="stat-item">
            <h3>150+</h3>
            <p>Volunteer</p>
        </div>
        <div class="stat-item">
            <h3>20+</h3>
            <p>Events</p>
        </div>
        <div class="stat-item">
            <h3>120+</h3>
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
<section class="container content-split">
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
<section class="container content-split">
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
<section class="container content-split">
    <div class="text-content">
        <div class="icon-wrapper"><i class="fas fa-users"></i></div>
        <h3>Project & Collaboration</h3>
        <p style="margin-bottom: 20px; color: #666;">Each individual contributes effectively to shared goals, fostering
            personal growth and organizational success through collaborative teamwork.</p>
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

<?php get_footer(); ?>