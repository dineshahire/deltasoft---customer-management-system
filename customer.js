// Function to get current date in YYYY-MM-DD format
function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Function to get current time in HH:MM:SS format
function getCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
}

// Fill in the current date and time when the page loads
window.onload = function() {
    document.getElementById('complaintDate').value = getCurrentDate();
    document.getElementById('complaintTime').value = getCurrentTime();
};

// Event listener for complaint form submission
document.getElementById('complaintForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Complaint Submitted!');
    // Add your form submission logic here
});

document.getElementById('trackIssueForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Tracking Issue...');
    // Add your issue tracking logic here
});

document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Feedback Submitted!');
    // Add your feedback submission logic here
});
