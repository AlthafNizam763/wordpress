<?php
/* Template Name: Meet Our Changemakers */
get_header(); ?>

<section class="page-header" style="background-color: #f4f4f4; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase;">Meet Our Changemakers</h1>
        <p style="color: #666; font-size: 18px;">Stories of those who are shaping a better future.</p>
    </div>
</section>

<main class="container" style="padding: 60px 20px;">
    <div class="page-content">
        <?php
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>