<?php
/* Template Name: Projects */
get_header(); ?>

<section class="page-header" style="background-color: #f4f4f4; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase; color: #000000ff;">Projects</h1>
    </div>
</section>

<section class="container" style="padding: 60px 20px;">
    <div class="text-content">
        <h3
            style="border-left: 4px solid #a91b0d; padding-left: 20px; color: #000080; font-size: 26px; margin-bottom: 20px; font-weight: 700;">
            Gurukulam</h3>
        <p
            style="margin-bottom: 20px; color: #555; line-height: 1.8; font-size: 16px; background: #f9f9f9; padding: 20px; border-radius: 6px; border-left: 4px solid #11823b;">
            Race Gurukulam is a consistent and continues process with a mission of creating personality transformation
            among the teens and adolescents. Facilitating the young to be the change agents is a social service. It is
            like sowing seeds and nurturing them into huge trees that offer shadow and fruits. Gurukulam is a three-day
            residential camp packed with with activity, fun and entertainment filled sessions to bring out the inner
            talents and social skills of the children to transform them for the future.
        </p>
    </div>
    <div class="gurukulam-images"
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <?php
        $gurukulam_dir = get_template_directory() . '/images/gurukulam/';
        if (is_dir($gurukulam_dir)) {
            $images = glob($gurukulam_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach ($images as $image):
                $image_url = get_template_directory_uri() . '/images/gurukulam/' . basename($image);
                ?>
                <div class="gurukulam-image"
                    style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <img src="<?php echo esc_url($image_url); ?>" alt="Gurukulam"
                        style="width: 100%; height: 250px; object-fit: cover;">
                </div>
                <?php
            endforeach;
        }
        ?>
    </div>

    <!-- <section class="container" style="padding: 60px 20px;"> -->
    <div class="text-content">
        <h3
            style="border-left: 4px solid #a91b0d; padding-left: 20px; color: #000080; font-size: 26px; margin-bottom: 20px; font-weight: 700;">
            Dhasha Vriksha</h3>
        <p
            style="margin-bottom: 20px; color: #555; line-height: 1.8; font-size: 16px; background: #f9f9f9; padding: 20px; border-radius: 6px; border-left: 4px solid #11823b;">
            Dhasha Vriksha is the continuing and most dearest project of the team race. In this new normal world of
            complete digitalization, on June 5th, environment day, the research academy for creative excellence
            started our journey towards making history by bringing together people from different parts of the state
            on a single platform through online resources and planting 150+ saplings on the same day. From there on,
            the team conducted regular inspections and made sure that the plants were protected throughout the year.
            The aim of the programme is to protect mother earth and to provide shade and shelter to many living
            beings. The idea is being carried forward by including interested people in the community of planters.
        </p>
    </div>
    <div class="dhashar-images"
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <?php
        $dhashar_dir = get_template_directory() . '/images/dhashar/';
        if (is_dir($dhashar_dir)) {
            $images = glob($dhashar_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            foreach ($images as $image):
                $image_url = get_template_directory_uri() . '/images/dhashar/' . basename($image);
                ?>
                <div class="dhashar-image"
                    style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <img src="<?php echo esc_url($image_url); ?>" alt="dhashar"
                        style="width: 100%; height: 250px; object-fit: cover;">
                </div>
                <?php
            endforeach;
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>