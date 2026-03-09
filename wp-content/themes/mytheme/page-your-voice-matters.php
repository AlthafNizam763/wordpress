<?php
/* Template Name: Your Voice Matters */
get_header(); ?>

<section class="page-header animate-on-scroll"
    style="background: url('<?php echo get_template_directory_uri(); ?>/images/contactus.gif') no-repeat center center; background-size: cover; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase; color: #000000ff;">Your Voice
            Matters
        </h1>
    </div>
</section>

<main class="container" style="padding: 60px 20px;">
    <div class="contact-layout">

        <!-- COLUMN 1: LEFT (Registration + Form) -->
        <div style="display: flex; flex-direction: column; gap: 30px;">

            <!-- Registration Type Selection -->
            <div class="registration-section animate-on-scroll"
                style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: center;">
                <h3 style="margin-bottom: 20px; font-size: 22px; font-weight: 600; color: #11823b;">Registration</h3>
                <div style="position: relative; display: inline-block; width: 100%;">
                    <select id="registration-type" onchange="switchRegistrationForm(this.value)"
                        style="width: 100%; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; font-size: 16px; color: #555; outline: none;">
                        <option value="">Select an option to Register</option>
                        <option value="partner">Partner with our mission</option>
                        <option value="volunteership">Volunteership</option>
                        <option value="participant">Participant</option>
                        <option value="internship">Internship</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Registration Forms -->
            <div id="registration-form-container" class="contact-form-wrapper animate-on-scroll"
                style="background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); display: none;">
                
                <form id="active-registration-form" onsubmit="handleFormSubmit(event)">
                    <div id="form-fields">
                        <!-- Fields will be injected here via JS -->
                    </div>
                    
                    <p style="font-size: 12px; color: #777; margin: 20px 0; line-height: 1.4;">
                        "Your data is safe with us and will only be used for communication related to [RACE] activities."
                    </p>
                    
                    <button type="submit" class="btn" style="width: 100%;">Submit Registration</button>
                </form>

                <div id="success-message" style="display: none; text-align: center; padding: 40px 0;">
                    <i class="fas fa-check-circle" style="font-size: 60px; color: #11823b; margin-bottom: 20px;"></i>
                    <h3 style="color: #11823b;">Thank you for your interest!</h3>
                    <p>Our team will get back to you within 2-3 working days.</p>
                    <button onclick="resetRegistration()" class="btn" style="margin-top: 20px;">Fill Another Form</button>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper animate-on-scroll"
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
                    <button type="submit" class="btn" style="width: 100%;">Send Message</button>
                </form>
            </div>
        </div>

        <!-- COLUMN 2: RIGHT (Contact Info + Map) -->
        <div class="contact-info animate-on-scroll">
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

            <!-- Map Section -->
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
    const formFields = {
        partner: `
            <h4 style="color: #11823b; margin-bottom: 20px; text-align: center;">Partner with our mission</h4>
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label>Full Name</label><input type="text" required></div>
                <div class="form-group"><label>Email Address</label><input type="email" required></div>
                <div class="form-group"><label>Mobile Number (WhatsApp)</label><input type="text" required></div>
                <div class="form-group"><label>Location/Address (City/State)</label><input type="text" required></div>
                <div class="form-group"><label>Current Designation</label><input type="text" required></div>
                <div class="form-group">
                    <label>Type of Partner</label>
                    <select required>
                        <option value="Corporate/CSR">Corporate/CSR</option>
                        <option value="Educational Institution">Educational Institution</option>
                        <option value="NGO">NGO</option>
                        <option value="Government Body">Government Body</option>
                        <option value="Individual">Individual</option>
                    </select>
                </div>
                <div class="form-group"><label>Organization Name</label><input type="text"></div>
                <div class="form-group"><label>Website/Profile Link</label><input type="url"></div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Nature of Partnership</label>
                    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 5px;">
                        <label style="font-weight: 400;"><input type="checkbox"> Financial Support</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Resource Sharing</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Joint Projects</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Advocacy/Awareness</label>
                    </div>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Briefly: Why do you want to join our mission?</label>
                    <textarea rows="3"></textarea>
                </div>
            </div>
        `,
        volunteership: `
            <h4 style="color: #11823b; margin-bottom: 20px; text-align: center;">Volunteership</h4>
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label>Full Name</label><input type="text" required></div>
                <div class="form-group"><label>Email Address</label><input type="email" required></div>
                <div class="form-group"><label>Mobile Number (WhatsApp)</label><input type="text" required></div>
                <div class="form-group"><label>Location/Address (City/State)</label><input type="text" required></div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Current Position</label>
                    <div style="display: flex; gap: 15px; margin-top: 5px;">
                        <label style="font-weight: 400;"><input type="checkbox"> Working</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Studying</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Self employed</label>
                    </div>
                </div>
                <div class="form-group" style="grid-column: span 2;"><label>Designation/Education/Entrepreneurship</label><input type="text" required></div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Area of Interest</label>
                    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 5px;">
                        <label style="font-weight: 400;"><input type="checkbox"> Teaching/Training</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Counseling</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Marketing/Social Media</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Field Work</label>
                        <label style="font-weight: 400;"><input type="checkbox"> Admin Support</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Availability</label>
                    <select required>
                        <option value="Weekends">Weekends</option>
                        <option value="Weekdays">Weekdays</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Virtual/Remote">Virtual/Remote</option>
                    </select>
                </div>
                <div class="form-group"><label>Specific Skills</label><input type="text"></div>
                <div class="form-group" style="grid-column: span 2;"><label>Previous Volunteering Experience</label><textarea rows="2"></textarea></div>
            </div>
        `,
        participant: `
            <h4 style="color: #11823b; margin-bottom: 20px; text-align: center;">Participant</h4>
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label>Full Name</label><input type="text" required></div>
                <div class="form-group"><label>Email Address</label><input type="email" required></div>
                <div class="form-group"><label>Mobile Number (WhatsApp)</label><input type="text" required></div>
                <div class="form-group"><label>Location/Address (City/State)</label><input type="text" required></div>
                <div class="form-group">
                    <label>Target Group</label>
                    <select required>
                        <option value="Student">Student</option>
                        <option value="Professional">Professional</option>
                        <option value="Entrepreneur">Entrepreneur</option>
                        <option value="Parent">Parent</option>
                        <option value="Educator">Educator</option>
                    </select>
                </div>
                <div class="form-group"><label>Education/Current status</label><input type="text" required></div>
                <div class="form-group">
                    <label>Program of Interest</label>
                    <select required>
                        <option value="Gurukulam 2026">Gurukulam 2026</option>
                    </select>
                </div>
                <div class="form-group" style="grid-column: span 2;"><label>Expectations: What do you hope to gain?</label><textarea rows="3"></textarea></div>
            </div>
        `,
        internship: `
            <h4 style="color: #11823b; margin-bottom: 20px; text-align: center;">Internship</h4>
            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group"><label>Full Name</label><input type="text" required></div>
                <div class="form-group"><label>Email Address</label><input type="email" required></div>
                <div class="form-group"><label>Mobile Number (WhatsApp)</label><input type="text" required></div>
                <div class="form-group"><label>Location/Address (City/State)</label><input type="text" required></div>
                <div class="form-group" style="grid-column: span 2;"><label>Educational Qualification (Course & Year)</label><input type="text" required></div>
                <div class="form-group" style="grid-column: span 2;"><label>Institute/University Name</label><input type="text" required></div>
                <div class="form-group">
                    <label>Duration Required</label>
                    <select required>
                        <option value="1 Month">1 Month</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                    </select>
                </div>
                <div class="form-group"><label>Resume/CV (PDF/Word)</label><input type="file" accept=".pdf,.doc,.docx" required></div>
                <div class="form-group" style="grid-column: span 2;"><label>Letter of Recommendation/NOC (Optional)</label><input type="file" accept=".pdf,.doc,.docx"></div>
            </div>
        `
    };

    function switchRegistrationForm(type) {
        const container = document.getElementById('registration-form-container');
        const formDiv = document.getElementById('form-fields');
        const activeForm = document.getElementById('active-registration-form');
        const successMsg = document.getElementById('success-message');

        if (type && formFields[type]) {
            formDiv.innerHTML = formFields[type];
            container.style.display = 'block';
            activeForm.style.display = 'block';
            successMsg.style.display = 'none';
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            container.style.display = 'none';
        }
    }

    function handleFormSubmit(event) {
        event.preventDefault();
        const activeForm = document.getElementById('active-registration-form');
        const successMsg = document.getElementById('success-message');

        // Mocking submission
        activeForm.style.display = 'none';
        successMsg.style.display = 'block';
    }

    function resetRegistration() {
        document.getElementById('registration-type').value = '';
        document.getElementById('registration-form-container').style.display = 'none';
    }
</script>

<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #444; }
    .form-group input[type="text"], 
    .form-group input[type="email"], 
    .form-group input[type="url"],
    .form-group select, 
    .form-group textarea {
        width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9; outline: none; font-size: 14px;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #11823b; }
    
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr !important; }
        .form-group { grid-column: span 1 !important; }
    }
</style>

<?php get_footer(); ?>