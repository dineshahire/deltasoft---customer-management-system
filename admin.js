function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(function (section) {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
    hideSidebarOnMobile();
}

function logout() {
    // Simulate a logout process
    alert('Logging out...');
    // Redirect to a login page or perform logout
    window.location.href = '/login';
}

function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}

function hideSidebarOnMobile() {
    var sidebar = document.getElementById('sidebar');
    if (window.innerWidth < 768) { // Check if screen size is less than 768px (mobile)
        sidebar.classList.remove('show'); // Hide the sidebar after clicking
    }
}
