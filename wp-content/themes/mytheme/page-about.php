<?php
/*
Template Name: About Us
*/
get_header(); ?>

<!-- About Hero -->
<section class="hero-section" style="min-height: 400px; align-items: center;">
    <div class="hero-left">
        <small>Who We Are</small>
        <h1>About Race</h1>
        <p>Research Academy for Creative Excellence</p>
    </div>
    <div class="hero-right">
        <img src="<?php echo get_template_directory_uri(); ?>/images/bg.jpg" alt="About Hero">
    </div>
</section>

<!-- About Content -->
<section class="container content-split">
    <div class="text-content">
        <h3>Our Story</h3>
        <p style="margin-bottom: 20px; color: #666;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat.
        </p>
        <p style="margin-bottom: 20px; color: #666;">
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident.
        </p>
    </div>
    <div class="image-content" style="background: #e0e0e0;"></div>
</section>

<!-- Mission & Vision -->
<section class="container" style="padding-bottom: 80px;">
    <div class="solutions-grid">
        <div class="solution-card green">
            <h3>Our Vision</h3>
            <p>To be the trailblazer of creative thoughts.</p>
        </div>
        <div class="solution-card grey">
            <h3>Our Mission</h3>
            <p>Instigate creative excellence and self-reliance among individual through systematic programming.</p>
        </div>
        <div class="solution-card black">
            <h3>Our Values</h3>
            <p>Universal brotherhood, social justice, and truth.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>