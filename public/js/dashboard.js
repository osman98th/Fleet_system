// Sidebar Toggle for Mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('menu-toggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
});
