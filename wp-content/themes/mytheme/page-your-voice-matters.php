<?php
/* Template Name: Your Voice Matters */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_voice_form') {
    $to = 'raceindianow@gmail.com';
    $form_type = sanitize_text_field($_POST['form_type']);
    $subject = 'New Submission: ' . ucwords(str_replace('_', ' ', $form_type)) . ' - RACE';

    $message_body = "You have a new submission from the Your Voice Matters page.\n\n";
    $message_body .= 'Form Type: ' . ucwords(str_replace('_', ' ', $form_type)) . "\n";
    $message_body .= "------------------------------------------\n";

    foreach ($_POST as $key => $value) {
        if (!in_array($key, array('action', 'form_type'), true)) {
            $label = ucwords(str_replace('_', ' ', $key));
            $val = is_array($value) ? implode(', ', array_map('sanitize_text_field', $value)) : sanitize_text_field($value);
            $message_body .= $label . ': ' . $val . "\n";
        }
    }

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: RACE Website <raceindianow@gmail.com>',
    );

    $sent = wp_mail($to, $subject, $message_body, $headers);
    if ($sent) {
        wp_send_json_success('Thank you. Your submission has been received.');
    }

    wp_send_json_error('Sorry, there was an error sending your message. On local WAMP setups, email delivery may require SMTP configuration.');
    exit;
}

get_header();

race_render_page_hero(array(
    'title' => 'Your Voice Matters',
    'description' => 'A redesigned contact and registration experience that feels calmer, clearer, and much easier to use across devices.',
    'image' => get_template_directory_uri() . '/images/contactus.gif',
));
?>

<section class="section-shell">
    <div class="container">
        <div class="contact-grid">
            <div style="display: grid; gap: 22px;">
                <div class="form-shell animate-on-scroll">
                    <span class="eyebrow">Registration</span>
                    <h2 style="font-size: 2.8rem;">Choose how you want to engage.</h2>
                    <div class="form-group">
                        <label for="registration-type">Registration Type</label>
                        <select id="registration-type">
                            <option value="">Select an option</option>
                            <option value="partner">Partner with our mission</option>
                            <option value="volunteership">Volunteership</option>
                            <option value="participant">Participant</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>
                </div>

                <div class="form-shell animate-on-scroll" id="registration-shell" style="display: none;">
                    <form id="registration-form" onsubmit="handleFormSubmit(event, 'registration')">
                        <div id="registration-fields"></div>
                        <p style="margin-top: 18px; font-size: 0.9rem;">Your information is used only for communication related to RACE activities.</p>
                        <button type="submit" class="btn" style="margin-top: 18px; width: 100%;">Submit Registration</button>
                    </form>
                    <div id="registration-success" style="display:none; text-align:center; padding: 24px 0;">
                        <h3 style="font-size: 2.2rem;">Thank you for your interest.</h3>
                        <p id="registration-success-text">Our team will get back to you soon.</p>
                        <button type="button" class="btn btn--ghost" onclick="resetRegistration()">Fill another form</button>
                    </div>
                </div>

                <div class="form-shell animate-on-scroll">
                    <span class="eyebrow">Message RACE</span>
                    <h2 style="font-size: 2.6rem;">Send us a message.</h2>
                    <form id="contact-message-form" onsubmit="handleFormSubmit(event, 'contact')">
                        <div class="field-grid">
                            <div class="form-group"><label>Your Name</label><input type="text" name="name" required></div>
                            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
                            <div class="form-group field-span-2"><label>Subject</label><input type="text" name="subject" required></div>
                            <div class="form-group field-span-2"><label>Message</label><textarea name="message" rows="5" required></textarea></div>
                        </div>
                        <button type="submit" class="btn" style="margin-top: 18px; width: 100%;">Send Message</button>
                        <div id="contact-status" style="display:none; margin-top: 16px;"></div>
                    </form>
                </div>
            </div>

            <div class="contact-panel animate-on-scroll">
                <span class="eyebrow">Get In Touch</span>
                <h2 style="font-size: 3rem;">Designed to feel welcoming, not overwhelming.</h2>
                <p>Whether you have a question about our programs, want to collaborate, or simply want to begin a conversation, the team is ready to help.</p>

                <div class="contact-info-list">
                    <div class="contact-item">
                        <div class="contact-item__icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div><h3 style="font-size: 1.6rem;">Visit Us</h3><p>262 Bhavana Nagar Town Adhirthi, Kadappakada, Kollam, 691008</p></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item__icon"><i class="fas fa-envelope"></i></div>
                        <div><h3 style="font-size: 1.6rem;">Email Us</h3><p>raceindianow@gmail.com</p></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-item__icon"><i class="fas fa-phone-alt"></i></div>
                        <div><h3 style="font-size: 1.6rem;">Call Us</h3><p>+91 9645567295<br>+91 94474 27471</p></div>
                    </div>
                </div>

                <div class="contact-map" style="margin-top: 22px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.8823356505336!2d76.60000576924826!3d8.890530571639964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05fcfa8c3c9bdf%3A0x63a590fa58af6e1d!2sKappalandimukku-Kadappakkada%20Rd%2C%20Bavana%20Nagar%2C%20Kollam%2C%20Kerala%20691008!5e0!3m2!1sen!2sin!4v1770022882020!5m2!1sen!2sin" loading="lazy" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const formFields = {
    partner: `
        <div class="field-grid">
            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" required></div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Mobile Number</label><input type="text" name="whatsapp_number" required></div>
            <div class="form-group"><label>Location / Address</label><input type="text" name="location" required></div>
            <div class="form-group"><label>Current Designation</label><input type="text" name="designation" required></div>
            <div class="form-group"><label>Type of Partner</label><select name="partner_type" required><option value="Corporate/CSR">Corporate/CSR</option><option value="Educational Institution">Educational Institution</option><option value="NGO">NGO</option><option value="Government Body">Government Body</option><option value="Individual">Individual</option></select></div>
            <div class="form-group"><label>Organization Name</label><input type="text" name="organization_name"></div>
            <div class="form-group"><label>Website / Profile Link</label><input type="url" name="website_link"></div>
            <div class="form-group field-span-2"><label>Nature of Partnership</label><div class="choice-group"><label class="choice-chip"><input type="radio" name="partnership_nature" value="Financial Support" required> Financial Support</label><label class="choice-chip"><input type="radio" name="partnership_nature" value="Resource Sharing"> Resource Sharing</label><label class="choice-chip"><input type="radio" name="partnership_nature" value="Joint Projects"> Joint Projects</label><label class="choice-chip"><input type="radio" name="partnership_nature" value="Advocacy/Awareness"> Advocacy/Awareness</label></div></div>
            <div class="form-group field-span-2"><label>Why do you want to join our mission?</label><textarea name="reason" rows="3"></textarea></div>
        </div>`,
    volunteership: `
        <div class="field-grid">
            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" required></div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Mobile Number</label><input type="text" name="whatsapp_number" required></div>
            <div class="form-group"><label>Location / Address</label><input type="text" name="location" required></div>
            <div class="form-group field-span-2"><label>Current Position</label><div class="choice-group"><label class="choice-chip"><input type="radio" name="current_position" value="Working" required> Working</label><label class="choice-chip"><input type="radio" name="current_position" value="Studying"> Studying</label><label class="choice-chip"><input type="radio" name="current_position" value="Self employed"> Self employed</label></div></div>
            <div class="form-group field-span-2"><label>Designation / Education / Entrepreneurship</label><input type="text" name="background" required></div>
            <div class="form-group field-span-2"><label>Area of Interest</label><div class="choice-group"><label class="choice-chip"><input type="radio" name="interest_areas" value="Teaching/Training" required> Teaching/Training</label><label class="choice-chip"><input type="radio" name="interest_areas" value="Counseling"> Counseling</label><label class="choice-chip"><input type="radio" name="interest_areas" value="Marketing/Social Media"> Marketing/Social Media</label><label class="choice-chip"><input type="radio" name="interest_areas" value="Field Work"> Field Work</label><label class="choice-chip"><input type="radio" name="interest_areas" value="Admin Support"> Admin Support</label></div></div>
            <div class="form-group"><label>Availability</label><select name="availability" required><option value="Weekends">Weekends</option><option value="Weekdays">Weekdays</option><option value="Full-time">Full-time</option><option value="Virtual/Remote">Virtual/Remote</option></select></div>
            <div class="form-group"><label>Specific Skills</label><input type="text" name="skills"></div>
            <div class="form-group field-span-2"><label>Previous Volunteering Experience</label><textarea name="experience" rows="3"></textarea></div>
        </div>`,
    participant: `
        <div class="field-grid">
            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" required></div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Mobile Number</label><input type="text" name="whatsapp_number" required></div>
            <div class="form-group"><label>Location / Address</label><input type="text" name="location" required></div>
            <div class="form-group"><label>Target Group</label><select name="target_group" required><option value="Student">Student</option><option value="Professional">Professional</option><option value="Entrepreneur">Entrepreneur</option><option value="Parent">Parent</option><option value="Educator">Educator</option></select></div>
            <div class="form-group"><label>Education / Current Status</label><input type="text" name="status" required></div>
            <div class="form-group"><label>Program of Interest</label><select name="program_interest" required><option value="Gurukulam 2026">Gurukulam 2026</option></select></div>
            <div class="form-group field-span-2"><label>What do you hope to gain?</label><textarea name="expectations" rows="3"></textarea></div>
        </div>`,
    internship: `
        <div class="field-grid">
            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" required></div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Mobile Number</label><input type="text" name="whatsapp_number" required></div>
            <div class="form-group"><label>Location / Address</label><input type="text" name="location" required></div>
            <div class="form-group field-span-2"><label>Educational Qualification</label><input type="text" name="qualification" required></div>
            <div class="form-group field-span-2"><label>Institute / University Name</label><input type="text" name="institute" required></div>
            <div class="form-group"><label>Duration Required</label><select name="duration" required><option value="1 Month">1 Month</option><option value="3 Months">3 Months</option><option value="6 Months">6 Months</option></select></div>
            <div class="form-group"><label>Resume / CV Link</label><input type="url" name="resume_link" required></div>
            <div class="form-group field-span-2"><label>Letter of Recommendation / NOC Link</label><input type="url" name="noc_link"></div>
        </div>`,
};

const registrationType = document.getElementById('registration-type');
const registrationShell = document.getElementById('registration-shell');
const registrationFields = document.getElementById('registration-fields');

registrationType?.addEventListener('change', () => {
    const type = registrationType.value;
    if (!type || !formFields[type]) {
        registrationShell.style.display = 'none';
        return;
    }
    registrationFields.innerHTML = formFields[type];
    registrationShell.style.display = 'block';
    document.getElementById('registration-form').style.display = 'block';
    document.getElementById('registration-success').style.display = 'none';
});

const WHATSAPP_NUMBER = '9061517298';
const buildWhatsAppText = (formType, formData) => {
    let text = 'Your Voice Matters Submission:\n';
    text += '------------------------------------------\n';
    if (formType === 'registration') {
        text += 'Form: Registration (' + (registrationType.value || 'unspecified') + ')\n';
    } else {
        text += 'Form: Contact Message\n';
    }
    for (const [key, value] of formData.entries()) {
        if (key === 'action' || key === 'form_type') continue;
        text += key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) + ': ' + value + '\n';
    }
    return text;
};

const sendToWhatsApp = (formType, formData) => {
    const message = encodeURIComponent(buildWhatsAppText(formType, formData));
    window.open(`https://wa.me/91${WHATSAPP_NUMBER}?text=${message}`, '_blank');
};

async function handleFormSubmit(event, formType) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    formData.append('action', 'submit_voice_form');
    formData.append('form_type', formType === 'registration' ? 'registration_' + registrationType.value : 'contact_message');

    sendToWhatsApp(formType, formData);

    const button = form.querySelector('button[type="submit"]');
    const originalText = button.innerText;
    button.innerText = 'Sending...';
    button.disabled = true;

    try {
        const response = await fetch(window.location.href, { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            if (formType === 'registration') {
                document.getElementById('registration-form').style.display = 'none';
                document.getElementById('registration-success').style.display = 'block';
                document.getElementById('registration-success-text').innerText = result.data;
            } else {
                const status = document.getElementById('contact-status');
                status.style.display = 'block';
                status.style.color = 'var(--primary)';
                status.innerText = result.data;
                form.reset();
            }
        } else {
            alert(result.data || 'Submission failed. Please try again.');
        }
    } catch (error) {
        alert('Something went wrong. Please check your connection.');
    } finally {
        button.innerText = originalText;
        button.disabled = false;
    }
}

function resetRegistration() {
    registrationType.value = '';
    registrationShell.style.display = 'none';
}
</script>

<?php get_footer(); ?>
