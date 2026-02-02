<?php
/* Template Name: Your Voice Matters */
get_header(); ?>

<section class="page-header"
    style="background: url('<?php echo get_template_directory_uri(); ?>/images/contactus.gif') no-repeat center center; background-size: cover; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase; color: #000000ff;">Your Voice
            Matters
        </h1>
    </div>
</section>

<main class="container" style="padding: 60px 20px;">
    <div class="contact-layout" style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; margin-bottom: 60px;">

        <!-- COLUMN 1: LEFT (Registration + Form) -->
        <div style="display: flex; flex-direction: column; gap: 30px;">

            <!-- Registration Dropdown Section -->
            <div class="registration-section"
                style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: center;">
                <h3 style="margin-bottom: 20px; font-size: 22px; font-weight: 600; color: #11823b;">Registration</h3>
                <div style="position: relative; display: inline-block; width: 100%;">
                    <button onclick="toggleRegistration()"
                        style="width: 100%; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 16px; color: #555;">
                        <span>Select an option to Register</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="reg-dropdown"
                        style="display: none; position: absolute; width: 100%; background: white; border: 1px solid #eee; border-top: none; border-radius: 0 0 5px 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); z-index: 100;">
                        <a href="#" target="_blank"
                            style="display: block; padding: 12px 15px; color: #333; text-decoration: none; border-bottom: 1px solid #f5f5f5; transition: background 0.2s;"
                            onmouseover="this.style.background='#f0f0f0'"
                            onmouseout="this.style.background='white'">Partner with our mission</a>
                        <a href="#" target="_blank"
                            style="display: block; padding: 12px 15px; color: #333; text-decoration: none; border-bottom: 1px solid #f5f5f5; transition: background 0.2s;"
                            onmouseover="this.style.background='#f0f0f0'"
                            onmouseout="this.style.background='white'">Participated</a>
                        <a href="#" target="_blank"
                            style="display: block; padding: 12px 15px; color: #333; text-decoration: none; border-bottom: 1px solid #f5f5f5; transition: background 0.2s;"
                            onmouseover="this.style.background='#f0f0f0'"
                            onmouseout="this.style.background='white'">Volunteer</a>
                        <a href="#" target="_blank"
                            style="display: block; padding: 12px 15px; color: #333; text-decoration: none; transition: background 0.2s;"
                            onmouseover="this.style.background='#f0f0f0'"
                            onmouseout="this.style.background='white'">Internship</a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper"
                style="background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom: 30px; font-size: 24px; font-weight: 600; color: #11823b;">Send us a Message
                </h3>
                <form action="" method="post">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #444;">Your
                            Name</label>
                        <input type="text" placeholder="Enter your name"
                            style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; outline: none; transition: border 0.3s;"
                            onfocus="this.style.borderColor='#11823b'" onblur="this.style.borderColor='#ddd'">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #444;">Email
                            Address</label>
                        <input type="email" placeholder="Enter your email"
                            style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; outline: none; transition: border 0.3s;"
                            onfocus="this.style.borderColor='#11823b'" onblur="this.style.borderColor='#ddd'">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 500; color: #444;">Subject</label>
                        <input type="text" placeholder="Enter subject"
                            style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; outline: none; transition: border 0.3s;"
                            onfocus="this.style.borderColor='#11823b'" onblur="this.style.borderColor='#ddd'">
                    </div>
                    <div style="margin-bottom: 30px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 500; color: #444;">Message</label>
                        <textarea placeholder="Write your message..." rows="5"
                            style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; outline: none; transition: border 0.3s;"
                            onfocus="this.style.borderColor='#11823b'"
                            onblur="this.style.borderColor='#ddd'"></textarea>
                    </div>
                    <button type="submit"
                        style="background: #11823b; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: 600; width: 100%; transition: background 0.3s;"
                        onmouseover="this.style.background='#0d612c'" onmouseout="this.style.background='#11823b'">Send
                        Message</button>
                </form>
            </div>
        </div>

        <!-- COLUMN 2: RIGHT (Contact Info + Map) -->
        <div class="contact-info">
            <h2 style="font-size: 28px; margin-bottom: 30px; color: #11823b; font-weight: 700;">Get in Touch</h2>
            <p style="margin-bottom: 40px; color: #666; line-height: 1.8;">
                We'd love to hear from you. Whether you have a question about our programs, training, or just want to
                say hello, our team is ready to answer all your questions.
            </p>

            <div class="info-item" style="display: flex; gap: 20px; margin-bottom: 30px;">
                <div
                    style="width: 50px; height: 50px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #11823b; font-size: 20px;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #333; font-size: 18px;">Visit Us</h4>
                    <p style="margin: 0; color: #666;">262 Bhavana Nagar
                        Town Adhirthi, <br>Kadappakada,
                        Kollam, 691008</p>
                </div>
            </div>

            <div class="info-item" style="display: flex; gap: 20px; margin-bottom: 30px;">
                <div
                    style="width: 50px; height: 50px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #11823b; font-size: 20px;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #333; font-size: 18px;">Email Us</h4>
                    <p style="margin: 0; color: #666;">raceindia2014@gmail.com</p>
                </div>
            </div>

            <div class="info-item" style="display: flex; gap: 20px; margin-bottom: 40px;">
                <div
                    style="width: 50px; height: 50px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #11823b; font-size: 20px;">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <h4 style="margin: 0 0 5px; color: #333; font-size: 18px;">Call Us</h4>
                    <p style="margin: 0; color: #666;">+91 9645567295<br>+91 94474 27471</p>
                </div>
            </div>

            <!-- Map Section (Moved here) -->
            <div class="map-section"
                style="width: 100%; border-radius: 10px; overflow: hidden; height: 350px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.8823356505336!2d76.60000576924826!3d8.890530571639964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05fcfa8c3c9bdf%3A0x63a590fa58af6e1d!2sKappalandimukku-Kadappakkada%20Rd%2C%20Bavana%20Nagar%2C%20Kollam%2C%20Kerala%20691008!5e0!3m2!1sen!2sin!4v1770022882020!5m2!1sen!2sin"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

</main>

<script>
    function toggleRegistration() {
        var dropdown = document.getElementById("reg-dropdown");
        if (dropdown.style.display === "none" || dropdown.style.display === "") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        var isClickInside = document.querySelector('.registration-section').contains(event.target);
        if (!isClickInside) {
            document.getElementById("reg-dropdown").style.display = "none";
        }
    });
</script>

<?php get_footer(); ?>