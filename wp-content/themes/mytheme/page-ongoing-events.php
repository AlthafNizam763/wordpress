<?php
/* Template Name: Ongoing & Past Events */
get_header(); ?>

<style>
    /* Integrated Styles for Events Page */
    :root {
        --primary-green: #11823b;
        --secondary-bg: #f9f9f9;
        --text-dark: #333;
        --text-muted: #666;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* Section Headers */
    .section-title {
        font-size: 32px;
        color: var(--primary-green);
        margin-bottom: 40px;
        text-transform: uppercase;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background-color: var(--primary-green);
        border-radius: 2px;
    }

    /* Ongoing Events - Featured Grid */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 80px;
    }

    .event-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #eee;
        display: flex;
        flex-direction: column;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .event-image {
        height: 220px;
        background-color: #e0e0e0;
        position: relative;
    }

    .event-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: #e74c3c; /* Red for 'Live' */
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .event-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .event-date {
        color: var(--primary-green);
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .event-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .event-desc {
        color: var(--text-muted);
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
    }

    .event-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: var(--primary-green);
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        align-self: flex-start;
        transition: background 0.3s ease;
    }

    .event-btn:hover {
        background-color: #0e6b30;
        color: white;
    }

    /* Past Events - Timeline Style */
    .timeline-section {
        position: relative;
        padding: 20px 0;
    }

    /* The vertical line */
    .timeline-section::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 2px;
        background-color: #e0e0e0;
        transform: translateX(-50%);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 60px;
        width: 100%;
    }

    .timeline-item::after {
        content: '';
        display: table;
        clear: both;
    }

    /* Content box */
    .timeline-content {
        position: relative;
        width: 45%;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        border: 1px solid #eee;
        transition: transform 0.3s ease;
    }

    .timeline-content:hover {
        transform: scale(1.02);
    }

    /* Timeline Dot */
    .timeline-dot {
        position: absolute;
        top: 25px;
        left: 50%;
        width: 16px;
        height: 16px;
        background-color: var(--primary-green);
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px rgba(17, 130, 59, 0.2);
        transform: translateX(-50%);
        z-index: 10;
    }

    /* Left and Right positioning */
    .timeline-item:nth-child(odd) .timeline-content {
        float: left;
        text-align: right;
    }

    .timeline-item:nth-child(even) .timeline-content {
        float: right;
        text-align: left;
    }

    .timeline-item:nth-child(odd) .event-date {
        justify-content: flex-end;
    }

    /* Responsive Timeline */
    @media (max-width: 768px) {
        .timeline-section::before {
            left: 20px;
        }

        .timeline-item {
            margin-bottom: 40px;
        }

        .timeline-dot {
            left: 20px;
        }

        .timeline-content {
            width: calc(100% - 60px);
            float: right !important;
            margin-left: 60px;
            text-align: left !important;
        }

        .timeline-item:nth-child(odd) .event-date {
            justify-content: flex-start;
        }
        
        .section-title {
            font-size: 26px;
        }
    }
</style>

<section class="page-header" style="background-color: #f4f4f4; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase; color: #000000ff">Ongoing & Past
            Events</h1>
        <p style="font-size: 18px; color: #666; max-width: 600px; margin: 0 auto;">Stay connected with our latest initiatives and explore our journey through past milestones.</p>
    </div>
</section>

<div class="container" style="padding: 80px 20px;">
    
    <!-- Ongoing Events -->
    <div class="ongoing-section">
        <h2 class="section-title">Happening Now</h2>
        
        <div class="events-grid">
            <!-- Event 1 (Placeholder) -->
            <article class="event-card">
                <div class="event-image">
                    <span class="event-badge">Ongoing</span>
                    <!-- Placeholder color block or image -->
                    <div style="width:100%; height:100%; background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%); display:flex; align-items:center; justify-content:center; color:#999;">
                        No Image Available
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-date"><i class="far fa-calendar-alt"></i> Current Initiative</div>
                    <h3 class="event-title">Community Outreach Program 2026</h3>
                    <p class="event-desc">We are currently actively engaging with local communities to provide support and resources. Join our volunteers in making a difference today.</p>
                    <a href="#" class="event-btn">View Details</a>
                </div>
            </article>

            <!-- Event 2 (Placeholder) -->
            <article class="event-card">
                <div class="event-image">
                    <span class="event-badge" style="background-color: #f39c12;">Upcoming</span>
                    <div style="width:100%; height:100%; background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%); display:flex; align-items:center; justify-content:center; color:#999;">
                        No Image Available
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-date"><i class="far fa-calendar-alt"></i> Starting Next Week</div>
                    <h3 class="event-title">Green Earth Workshop</h3>
                    <p class="event-desc">An interactive workshop focused on sustainable living practices and environmental conservation techniques for the youth.</p>
                    <a href="#" class="event-btn">Register Now</a>
                </div>
            </article>
        </div>
    </div>

    <!-- Past Events Timeline -->
    <div class="past-section">
        <h2 class="section-title">Past Events Archive</h2>
        
        <div class="timeline-section">
            
            <!-- Timeline Item 1 -->
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="event-date"><i class="far fa-calendar-check"></i> December 2025</div>
                    <h3 class="event-title">Annual Charity Gala</h3>
                    <p class="event-desc">A successful evening of fundraising and celebration, bringing together donors and beneficiaries to reflect on a year of impact.</p>
                </div>
            </div>

            <!-- Timeline Item 2 -->
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="event-date"><i class="far fa-calendar-check"></i> October 2025</div>
                    <h3 class="event-title">Youth Leadership Summit</h3>
                    <p class="event-desc">Over 200 student leaders gathered to discuss future challenges and opportunities in the sector. Keynote speakers inspired the next generation.</p>
                </div>
            </div>

            <!-- Timeline Item 3 -->
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="event-date"><i class="far fa-calendar-check"></i> August 2025</div>
                    <h3 class="event-title">Tech for Good Hackathon</h3>
                    <p class="event-desc">Innovators and developers came together to build solutions for social problems. The winning team developed an app for food distribution.</p>
                </div>
            </div>
            
             <!-- Timeline Item 4 -->
             <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="event-date"><i class="far fa-calendar-check"></i> June 2025</div>
                    <h3 class="event-title">Environmental Cleanup Drive</h3>
                    <p class="event-desc">Volunteers collected over 500kg of waste from the local beaches and parks, contributing to a cleaner and improved environment.</p>
                </div>
            </div>

        </div>
    </div>
    
</div>

<?php get_footer(); ?>