<?php
/* Template Name: Team Race */
get_header(); ?>

<section class="page-header" style="background-color: #f4f4f4; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase; color: #000000ff;">Team Race</h1>
    </div>
</section>


<div style="background-color: #11823b; padding: 15px; text-align: center; margin-bottom: 40px; border-radius: 4px;">
    <h2 style="color: white; font-size: 20px; font-weight: 500; margin: 0;">Team Members</h2>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
    <!-- M -->
    <main class="container" style="padding: 60px 20px;">
        <div class="members-images" style="column-count: 4; column-gap: 20px;">
            <?php
            $members_path = get_template_directory() . '/images/members/';
            $members_url = get_template_directory_uri() . '/images/members/';

            // Get all image files
            $images = glob($members_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

            if ($images) {
                foreach ($images as $image) {
                    $image_name = basename($image);
                    echo '<div class="members-item" style="break-inside: avoid; margin-bottom: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
                    echo '<img src="' . $members_url . $image_name . '" alt="Members Image" style="width: 100%; height: auto; display: block; transition: transform 0.5s ease; cursor: pointer;" onmouseover="this.style.transform=\'scale(1.05)\'" onmouseout="this.style.transform=\'scale(1)\'">';
                    echo '</div>';
                }
            } else {
                echo '<p style="text-align: center; color: #666;">No images found in the members.</p>';
            }
            ?>
        </div>
</div>
</div>

<style>
    @media (max-width: 1200px) {
        .members-images {
            column-count: 3 !important;
        }
    }

    @media (max-width: 768px) {
        .members-images {
            column-count: 2 !important;
        }
    }

    @media (max-width: 480px) {
        .members-images {
            column-count: 1 !important;
        }
    }
</style>
</main>

<?php get_footer(); ?>