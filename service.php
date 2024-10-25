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
    <title>Service Page</title>
    <link rel="stylesheet" href="service.css">
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
        <div class="navigation">
            <a href="customer_dashboard.php">Home</a>
        </div>
    </div>

    <div class="container">
        <h1>We Are Here to Help You</h1>
        <div class="services">
            <div class="service-box" data-service="feedback">
                <a href="feedback.php"><h2>Feedback</h2></a>
                <p>Share your feedback with us.</p>
            </div>
            <div class="service-box" data-service="contactus">
                <a href="contact_us.php"><h2>Contact Us</h2></a>
                <p>Get in touch with our support team.</p>
            </div>
            <div class="service-box" data-service="trackcomplaint">
                <a href="track_complaint.php"><h2>Track Complaint</h2></a>
                <p>Track the status of your complaints.</p>
            </div>
        </div>
    </div>

    <script src="service.js"></script>
</body>
</html>
