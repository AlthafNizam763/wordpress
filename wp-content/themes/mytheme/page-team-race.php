<?php
/* Template Name: Team Race */
get_header();

race_render_page_hero(array(
    'title' => 'Team RACE',
    'description' => 'The leadership, coordination, and volunteer energy that gives RACE its direction and character.',
    'image' => get_template_directory_uri() ,
));
?>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Leadership Team</span>
                <h2>A stronger, more premium presentation of the people behind the organisation.</h2>
            </div>
        </div>
        <div class="leaders-grid" id="leaders-container">
            <p class="empty-state">Loading leadership team...</p>
        </div>
    </div>
</section>

<section class="section-shell section-shell--compact">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <div>
                <span class="eyebrow">Our IT & Media Cell Team</span>
            </div>
        </div>
        <div class="grid-3" id="it-team-container">
            <p class="empty-state">Loading IT & Media cell team...</p>
        </div>
    </div>
</section>

<script type="module">
    import { subscribeToAllCollections } from '<?php echo get_template_directory_uri(); ?>/js/firebase-fetch.js';

    const leadersContainer = document.getElementById('leaders-container');
    const itContainer = document.getElementById('it-team-container');

    const getImageUrl = (img) => {
        if (!img) return '<?php echo get_template_directory_uri(); ?>/images/bg.jpg';
        if (img.startsWith('http://') || img.startsWith('https://')) return img;
        return `http://localhost:3000${img}`;
    };

    subscribeToAllCollections((data) => {
        const team = data.team_members || [];

        const leaders = team.filter(member => member.type === 'leader');
        const itTeam = team.filter(member => member.type === 'it');

        // Render Leaders
        if (leaders.length === 0) {
            leadersContainer.innerHTML = '<p class="empty-state">No leadership members listed.</p>';
        } else {
            leadersContainer.innerHTML = leaders.map(leader => {
                const bioLines = leader.description ? leader.description.split('\n').filter(l => l.trim()) : [];
                const bioHtml = bioLines.length > 0 
                    ? `<ul>${bioLines.map(line => `<li>${line}</li>`).join('')}</ul>`
                    : '';

                return `
                    <article class="leader-card animate-on-scroll">
                        <img class="leader-card__image" src="${getImageUrl(leader.image)}" alt="${leader.name || 'Leader Image'}">
                        <div>
                            <span class="leader-card__role">${leader.role || 'Leader'}</span>
                            <h3>${leader.name || 'Untitled Leader'}</h3>
                            ${bioHtml}
                        </div>
                    </article>
                `;
            }).join('');
        }

        // Render IT / Media Team
        if (itTeam.length === 0) {
            itContainer.innerHTML = '<p class="empty-state">No IT & Media cell members listed.</p>';
        } else {
            itContainer.innerHTML = itTeam.map(member => `
                <article class="circle-member animate-on-scroll" style="text-align: center;">
                    <img class="circle-member__image" src="${getImageUrl(member.image)}" alt="${member.name || 'Member Image'}" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; margin: 0 auto 12px;">
                    <h3 class="member-card__name">${member.name || 'Untitled Member'}</h3>
                    <p style="font-size: 0.85rem; color: var(--muted);">${member.role || ''}</p>
                </article>
            `).join('');
        }

        // Trigger animations for newly added items
        if (window.raceObserveElements) {
            window.raceObserveElements();
        }
    });
</script>

<?php get_footer(); ?>
