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
    <title>Feedback</title>
    <link rel="stylesheet" href="feedback.css">
</head>
<body>
    <!-- Fixed Top Section -->
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
            <a href="../customer_dashboard.php">Home</a>
        </div>
    </div>

    <div class="container">
        <div class="form-box">
            <h1>Feedback</h1>
            <p class="feedback-note">We value your feedback.</p>
            <p class="feedback-instruction">Please complete the following form and help us improve our customer experience.</p>
            <form action="submit_feedback.php" method="POST">
                <div class="question">
                    <label>How satisfied are you with our product?</label>
                    <div class="options">
                        <label><input type="radio" name="product_satisfaction" value="very-satisfied" required> Very satisfied</label>
                        <label><input type="radio" name="product_satisfaction" value="neutral"> Neutral</label>
                        <label><input type="radio" name="product_satisfaction" value="not-satisfied"> Not satisfied</label>
                    </div>
                </div>
                <div class="question">
                    <label>How satisfied are you with our service?</label>
                    <div class="options">
                        <label><input type="radio" name="service_satisfaction" value="very-satisfied" required> Very satisfied</label>
                        <label><input type="radio" name="service_satisfaction" value="neutral"> Neutral</label>
                        <label><input type="radio" name="service_satisfaction" value="not-satisfied"> Not satisfied</label>
                    </div>
                </div>
                <div class="question">
                    <label>How satisfied are you with our team?</label>
                    <div class="options">
                        <label><input type="radio" name="team_satisfaction" value="very-satisfied" required> Very satisfied</label>
                        <label><input type="radio" name="team_satisfaction" value="neutral"> Neutral</label>
                        <label><input type="radio" name="team_satisfaction" value="not-satisfied"> Not satisfied</label>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
