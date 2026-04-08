<!-- admin/components/sidebar.php -->
<aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-40 sm:translate-x-0 -translate-x-full border-r border-slate-800 transition-transform duration-300">
    <div class="h-16 flex items-center justify-between border-b border-slate-800 px-4 bg-slate-950">
        <h1 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
            <i class="ph-fill ph-student text-secondary"></i> Unilink
        </h1>
        <button onclick="toggleSidebar()" class="sm:hidden text-slate-400 hover:text-white transition">
            <i class="ph ph-x text-2xl"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Main</p>
        
        <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'dashboard.php' ? 'bg-secondary text-white shadow-lg shadow-orange-500/20' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-squares-four text-lg"></i> Dashboard
        </a>

        <?php if(has_permission('manage_profile') || has_permission('manage_admins')): ?>
        <p class="px-3 mt-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Administration</p>
        <?php endif; ?>

        <?php if(has_permission('manage_profile')): ?>
        <a href="profile.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'profile.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-user-gear text-lg"></i> Manage Profile
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_admins')): ?>
        <a href="admins.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'admins.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-users-three text-lg"></i> Manage Admins
        </a>
        <?php endif; ?>

        <p class="px-3 mt-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Content Modules</p>

        <?php if(has_permission('manage_hero')): ?>
        <a href="hero.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'hero.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-image text-lg"></i> Hero Section
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_about')): ?>
        <a href="about.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'about.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-info text-lg"></i> About Info
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_services')): ?>
        <a href="services.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'services.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-briefcase text-lg"></i> Services
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_working_process')): ?>
        <a href="working_process.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'working_process.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-chart-line-up text-lg"></i> Working Process
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_countries')): ?>
        <a href="countries.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'countries.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-globe-hemisphere-west text-lg"></i> Countries
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_universities')): ?>
        <a href="universities.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'universities.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-buildings text-lg"></i> Universities
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_team')): ?>
        <a href="team.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'team.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-users text-lg"></i> Team
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_partners')): ?>
        <a href="partners.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'partners.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-handshake text-lg"></i> Industry Partners
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_gallery')): ?>
        <a href="gallery.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'gallery.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-images text-lg"></i> Gallery
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_blogs')): ?>
        <a href="blogs.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'blogs.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-article text-lg"></i> Blogs
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_events')): ?>
        <a href="events.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'events.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-calendar-event text-lg"></i> Events
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_achievements')): ?>
        <a href="achievements.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'achievements.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-trophy text-lg"></i> Achievements
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_testimonials')): ?>
        <a href="testimonials.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'testimonials.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-quotes text-lg"></i> Testimonials
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_social_media')): ?>
        <a href="social_media.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'social_media.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-share-network text-lg"></i> Social Media
        </a>
        <?php endif; ?>

        <p class="px-3 mt-4 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Leads & Contacts</p>

        <?php if(has_permission('manage_appointments')): ?>
        <a href="appointments.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'appointments.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-notebook text-lg"></i> Appointments
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_chatbot')): ?>
        <a href="chatbot.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'chatbot.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-robot text-lg"></i> Chatbot Leads
        </a>
        <?php endif; ?>

        <?php if(has_permission('manage_subscribers')): ?>
        <a href="subscribers.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors <?php echo $current_page == 'subscribers.php' ? 'bg-secondary text-white' : 'hover:bg-slate-800 hover:text-white'; ?>">
            <i class="ph ph-envelope-simple text-lg"></i> Subscribers
        </a>
        <?php endif; ?>

    </div>
</aside>
<style>
/* Sidebar Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #334155;
  border-radius: 20px;
}
</style>
