<?php
/* Template Name: Action Plan */
get_header(); ?>

<section class="page-header" style="background-color: #f4f4f4; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase;">Action Plan</h1>
        <p style="color: #666; font-size: 18px;">Our strategic roadmap for creating impact.</p>
    </div>
</section>

<main class="container" style="padding: 60px 20px;">
    <div class="action-plan-grid"
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-top: 40px;">
        <div class="plan-card"
            style="background: #fff; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-radius: 8px;">
            <h3>Programs</h3>
            <p>Impactful initiatives designed for change.</p>
            <a href="<?php echo home_url('/programs'); ?>" class="btn">View Programs</a>
        </div>
        <div class="plan-card"
            style="background: #fff; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-radius: 8px;">
            <h3>Training</h3>
            <p>Skill development and capacity building.</p>
            <a href="<?php echo home_url('/training'); ?>" class="btn">View Training</a>
        </div>
        <div class="plan-card"
            style="background: #fff; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-radius: 8px;">
            <h3>Research</h3>
            <p>Data-driven insights for better solutions.</p>
            <a href="<?php echo home_url('/research'); ?>" class="btn">View Research</a>
        </div>
        <div class="plan-card"
            style="background: #fff; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-radius: 8px;">
            <h3>Project</h3>
            <p>Collaborative projects for community growth.</p>
            <a href="<?php echo home_url('/project'); ?>" class="btn">View Project</a>
        </div>
    </div>

    <div class="page-content" style="margin-top: 60px;">
        <?php
        while (have_posts()):
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>