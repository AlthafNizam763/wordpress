<?php
/* Template Name: Courses & Training */
get_header(); ?>

<style>
    /* Integrated Styles for Training Page */
    :root {
        --primary-green: #11823b;
        --secondary-bg: #f9f9f9;
        --text-dark: #333;
        --text-muted: #666;
    }

    .training-hero {
        background-color: var(--secondary-bg);
        padding: 80px 0;
        text-align: center;
        margin-bottom: 60px;
    }

    .training-hero h1 {
        font-size: 48px;
        text-transform: uppercase;
        color: #000;
        margin-bottom: 20px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .category-section {
        margin-bottom: 100px;
    }

    .category-header {
        position: relative;
        padding-bottom: 20px;
        margin-bottom: 50px;
        border-bottom: 1px solid #eee;
    }

    .category-header h2 {
        font-size: 32px;
        color: var(--primary-green);
        text-transform: uppercase;
        font-weight: 700;
        display: inline-block;
        position: relative;
    }

    .category-header h2::after {
        content: '';
        position: absolute;
        bottom: -21px;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: var(--primary-green);
    }

    .program-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #eee;
    }

    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .program-image {
        height: 240px;
        background-color: #ddd;
        position: relative;
        overflow: hidden;
    }

    .program-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .program-card:hover .program-image img {
        transform: scale(1.05);
    }

    .program-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: linear-gradient(45deg, #f3f3f3, #e9e9e9);
        color: #aaa;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .program-content {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .program-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--text-dark);
    }

    .program-desc {
        font-size: 15px;
        line-height: 1.7;
        color: var(--text-muted);
        margin-bottom: 20px;
        flex: 1;
    }

    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 40px;
    }

    @media (max-width: 768px) {
        .training-hero h1 {
            font-size: 36px;
        }

        .program-grid {
            grid-template-columns: 1fr;
        }

        .category-header h2 {
            font-size: 26px;
        }
    }
</style>

<div class="training-hero">
    <div class="container animate-on-scroll">
        <h1>Courses & Training</h1>
    </div>
</div>

<div class="container">

    <!-- Category A: Students -->
    <section class="category-section">
        <div class="category-header">
            <h2>Training Programme for Students</h2>
        </div>
        <div class="program-grid">
            <!-- Disha -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/disha/';
                    $disha_url = get_template_directory_uri() . '/images/disha/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="Disha" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="Disha" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: Disha</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Disha</h3>
                    <p class="program-desc">
                        DISHA is a flagship programme conducted by the Research Academy for Creative Excellence. The
                        programme was designed based on the UN’s concern about the impact of the COVID-19 pandemic on
                        students, causing mental anxiety and other issues. It is critical to implement entertaining and
                        supporting programmes to reduce their mental stress. Race was deeply concerned about it and
                        conducted DISHA to overcome this situation. Disha opened a space for students to be free from
                        loneliness and mental stress and to discover themselves.
                    </p>
                </div>
            </article>

            <!-- HOPE -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/hope/';
                    $disha_url = get_template_directory_uri() . '/images/hope/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="HOPE" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="HOPE" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: HOPE</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">HOPE</h3>
                    <p class="program-desc">
                        Hope is a salient programme conducted by Research Academy for Creative Excellence. The programme
                        is mainly focused on higher secondary students. The aim of the programme is to arrange a golden
                        opportunity to shape future life to success. It focused to help higher secondary students to
                        identify their skills, perspectives, passions and to introduce various opportunities to them.
                        The resource person is career master Sree Satar Sreekaryam.
                    </p>
                </div>
            </article>
        </div>
    </section>

    <!-- Category B: Youths -->
    <section class="category-section">
        <div class="category-header">
            <h2>Training Programme for Youths</h2>
        </div>
        <div class="program-grid">
            <!-- Meliora -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/meliora/';
                    $disha_url = get_template_directory_uri() . '/images/meliora/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="Meliora" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="Meliora" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: Meliora</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Meliora</h3>
                    <p class="program-desc">
                        Meliora is an effective Project of race which focus to bring out the real trailblazers. This is
                        a exclusive program conducted only for the Student Leaders of race. This program helps the
                        individuals to make them more confident and to create a strong determination which accelerate
                        them to success.
                    </p>
                </div>
            </article>
        </div>
    </section>

    <!-- Category C: Trainers -->
    <section class="category-section">
        <div class="category-header">
            <h2>Training Programme for Trainers</h2>
        </div>
        <div class="program-grid">
            <!-- Diamond Cutter -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/diamond-cutter/';
                    $disha_url = get_template_directory_uri() . '/images/diamond-cutter/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="Diamond Cutter" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="Diamond Cutter" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: Diamond Cutter</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Diamond Cutter</h3>
                    <p class="program-desc">
                        Diamond Cutter train-the-trainer three day residential workshop is a package out of the box
                        tools and tactics. Diamond cutter is focused on need based theoretical analysis of current
                        trends along with personalized interactive sessions it is a learner focused workshop engaging
                        the participants with high energy practical sessions. Diamond cutter is designed to improve and
                        enhance trainers proficiencies, productivity and potential. Diamond cutter transforms the
                        participants as the “Trainer of the time”.
                    </p>
                </div>
            </article>
        </div>
    </section>

    <!-- Category D: Entrepreneurs -->
    <section class="category-section">
        <div class="category-header">
            <h2>Entrepreneurs & Professionals</h2>
        </div>
        <div class="program-grid">
            <!-- B.M.W -->
            <article class="program-card animate-on-scroll">
                <div class="program-content">
                    <h3 class="program-title">B.M.W</h3>
                    <p class="program-desc">
                        This is one of an effective program exclusively conducted for Entrepreneurs, Marketing team,
                        Management Team for Business Promotion Motive. Customized program done in demand from
                        organizations or institutions.
                    </p>
                </div>
            </article>

            <!-- Sharpen ur saw -->
            <article class="program-card animate-on-scroll">
                <div class="program-content">
                    <h3 class="program-title">Sharpen ur saw</h3>
                    <p class="program-desc">
                        Sharpen Ur Saw is an exclusive program conducted for Professionals. The best asset a person can
                        have is preserved and improved with the aid of this programme. It entails developing a
                        well-balanced self-renewal plan for your physical, social/emotional, mental, and spiritual
                        well-being.
                    </p>
                </div>
            </article>
        </div>
    </section>

    <!-- Category E: Women empowerment -->
    <section class="category-section">
        <div class="category-header">
            <h2>Women Empowerment</h2>
        </div>
        <div class="program-grid">
            <!-- Karuthal -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/karuthal/';
                    $disha_url = get_template_directory_uri() . '/images/karuthal/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="Karuthal" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="Karuthal" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: Karuthal</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Karuthal</h3>
                    <p class="program-desc">
                        Karuthal an online free training programme on complete physical, mental and social wellbeing of
                        adolescent girls. It is a Q&A programme conducted by Research Academy for Creative Excellence.
                        It is one of the most effective programmes conducted by race to address various concerns of
                        adolescent girls about there health and hygiene issues. The programme is coordinated by Race
                        councilling head Dr. Preetha.
                    </p>
                </div>
            </article>

            <!-- Arjidha -->
            <article class="program-card animate-on-scroll">
                <div class="program-content">
                    <h3 class="program-title">Arjidha</h3>
                    <p class="program-desc">
                        Argitha is a modern day training program with target focused on women entrepreneurs. Women are
                        most unutilized national resource of our country. Most of the women are spending their time in
                        there households unproductively. Argidha is program for the household women. This training
                        program has been developed after identifying the needs and potential of the household’s women.
                        This program helps the women to transform themselves as entrepreneur and further become earning
                        member of their family.
                    </p>
                </div>
            </article>
        </div>
    </section>

    <!-- Category F: General -->
    <section class="category-section">
        <div class="category-header">
            <h2>General / Common</h2>
        </div>
        <div class="program-grid">
            <!-- Hastha -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/hastha/';
                    $disha_url = get_template_directory_uri() . '/images/hastha/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="Hastha" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="Hastha" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: Hastha</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Hastha</h3>
                    <p class="program-desc">
                        It is a customized training programme for the geriatric and differently abled amog us. The
                        research team of race personally interviewed various old aged homes to identity the inmates
                        mental and emotional state. It helped us in developing a special training programme for them
                        under the title HASTHA. A series of the training programme HASTHA was conducted in various old
                        aged homes by the training team of race in association with social justice department at
                        Trivandrum.
                    </p>
                </div>
            </article>

            <!-- PSC -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/psc/';
                    $disha_url = get_template_directory_uri() . '/images/psc/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="PSC" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="PSC" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: PSC</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Public Speaking Course (PSC)</h3>
                    <p class="program-desc">
                        The P.S.C Program is part of the Critical Seed Projects. This program aims to bring the audience
                        to real speakers and help individuals become more confident in communication. Usually, PSC is
                        conducted annually for those preparing to attend interviews, political speeches, teachers and
                        even lecturers. The duration of the course is about 3 days and the activities and assessments
                        for the next two days.
                    </p>
                </div>
            </article>

            <!-- FYFO -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/fyfo/';
                    $disha_url = get_template_directory_uri() . '/images/fyfo/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="FYFO" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="FYFO" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: FYFO</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">FYFO</h3>
                    <p class="program-desc">
                        Created training program for effective presentation/ public speaking has rendered its one decade
                        long impressive presence and support among all walks of life ranging from adolescents to
                        veterans. It is a program designed with integrating the needs of the modern day public speaking
                        to help the participants face every stage without fear and to help them excel in their field
                        with improved speaking and presentation skills. The participants are the public which ranges
                        from entrepreneurs to young students, politicians to public servers, and the common people who
                        wants to mark their presence with the help of communication skills.
                    </p>
                </div>
            </article>

            <!-- FACE -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/face/';
                    $disha_url = get_template_directory_uri() . '/images/face/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="FACE" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="FACE" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: FACE</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">FACE</h3>
                    <p class="program-desc">
                        Fostering awareness of civil service examination (FACE) is a one day online programme. FACE is
                        an important project being conducted by RACE involving prominent people in the field of civil
                        service training to clear the fears and queries of the students about the importance, relevance,
                        possibilities and merits of civil service coaching. Through this training, RACE prepares the
                        students who want to work in the field of civil service to find out the right direction and
                        strive to reach the goal of civil service with more interest.
                    </p>
                </div>
            </article>

            <!-- Cancer Awareness -->
            <article class="program-card animate-on-scroll">
                <div class="program-image">
                    <?php
                    $disha_dir = get_template_directory() . '/images/cancer-awareness/';
                    $disha_url = get_template_directory_uri() . '/images/cancer-awareness/';
                    $images = glob($disha_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if ($images) {
                        echo '<div class="gallery-image" style="width: 100%; height: 100%;">';
                        $first = true;
                        foreach ($images as $image) {
                            $filename = basename($image);
                            $image_src = $disha_url . $filename;
                            if ($first) {
                                echo '<img src="' . esc_url($image_src) . '" alt="Cancer Awareness" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">';
                                $first = false;
                            } else {
                                echo '<img src="' . esc_url($image_src) . '" alt="Cancer Awareness" style="display: none;">';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="program-image-placeholder">Image: Cancer Awareness</div>';
                    }
                    ?>
                </div>
                <div class="program-content">
                    <h3 class="program-title">Awareness class on cancer prevention</h3>
                    <p class="program-desc">
                        A virtual "Awareness Class on Cancer Prevention" scheduled for November 15, 2020, at 3 PM via
                        Zoom. Jointly organized by IMA Kazhakoottam and the Research Academy for Creative Excellence
                        (race), the session features Dr. Prasanth CV, President of IMA TVM and RMO at RCC TVM, as the
                        keynote speaker. The event is led by Chairperson Dr. Kavitha Ravi and Guest of Honour MC
                        Rajilan, supported by Moderator Dr. Riaz, General Secretary A Shaharudeen, and Project
                        Co-ordinator Noufiya N.
                    </p>
                </div>
            </article>
        </div>
    </section>

</div>


<?php get_footer(); ?>