<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: lo.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="customer_dashboard.css">
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
    <style>
        /* CSS code as before */
    </style>
</head>
<body>
    <div class="fixed-top">
        <div class="company-info">
            <div class="company-logo">
                <img src="logo.png" alt="Company Logo">
            </div>
        </div>
        <div class="project-name">
            Customer Representative System
        </div>
        <div class="profile-section">
            <i class="fa-solid fa-user-circle profile-icon"></i>
            <p class="profile-name" id="profileName">
                <?php echo $_SESSION['email']; ?>
            </p>
            <a href="rg.php" class="logout-link">Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <main class="dashboard-main" id="complaintBtn">
            <button class="dashboard-button">
                <a href="complaint_form.php" class="button-link">Complaint Form</a>
            </button>
            <button class="dashboard-button">
                <a href="service.php" class="button-link">Support</a>
            </button>
            <button class="dashboard-button">
                <a href="track_issue.php" class="button-link">Track Issue</a>
            </button>
        </main>
    </div>

    <script>
        // Check for the success flag in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        // If the status is success, show a success message and redirect
        if (status === 'success') {
            alert('Complaint submitted successfully!');
            window.location.href = "customer_dashboard.php"; // Redirect back to the dashboard without status flag
        }
    </script>
</body>
</html>
