// Function to show the selected section and highlight the active link
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(function (section) {
        section.style.display = 'none';
    });

    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(function (link) {
        link.classList.remove('active');
    });

    // Show the selected section
    document.getElementById(sectionId).style.display = 'block';

    // Highlight the active link
    document.querySelector(`[onclick="showSection('${sectionId}')"]`).classList.add('active');
}

// Function to simulate logout
function logout() {
    alert('Logging out...');
    window.location.href = '/login'; // Redirect to the login page
}

// Function to toggle card visibility within a section
function toggleCard(cardId) {
    let card = document.getElementById(cardId);
    if (card.style.display === 'none' || card.style.display === '') {
        card.style.display = 'block';
    } else {
        card.style.display = 'none';
    }
}

// Function to display a confirmation dialog before performing an action
function confirmAction(action) {
    if (confirm(`Are you sure you want to ${action}?`)) {
        alert(`${action.charAt(0).toUpperCase() + action.slice(1)} confirmed.`);
    } else {
        alert(`${action.charAt(0).toUpperCase() + action.slice(1)} cancelled.`);
    }
}

// Function to dynamically add rows to tables (example for issue-details)
function addIssueRow(issue, status) {
    let table = document.querySelector('#issue-details table tbody');
    let row = table.insertRow();
    row.innerHTML = `<td>${table.rows.length}</td><td>${issue}</td><td>${status}</td>`;
}

// Example: Adding a new issue after 3 seconds (you can replace this with a form submission)
setTimeout(() => addIssueRow('Payment Issue', 'Pending'), 3000);

// Initialize the dashboard on page load
document.addEventListener('DOMContentLoaded', function () {
    showSection('dashboard'); // Default section to show
});
