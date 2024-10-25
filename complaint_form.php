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
    <title>Complaint Form</title>
    <link rel="stylesheet" href="complaint_form.css"> 
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
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
            <a href="lo.php">Home</a> 
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="form-box">
            <h1 class="form-heading">Customer Complaint Form</h1>
            <form id="complaintForm" method="POST" action="submit_complaint.php">
                <div class="input-group">
                    <div class="input-field">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" readonly>
                    </div>
                    <div class="input-field">
                        <label for="product">Product:</label>
                        <select id="product" name="product" required>
                            <option value="website-design">Website Design</option>
                            <option value="website-development">Website Development</option>
                            <option value="app-development">App Development</option>
                            <option value="mobile-apps">Mobile Apps</option>
                            <option value="digital-marketing">Digital Marketing</option>
                            <option value="maintenance-support">Maintenance and Support</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" placeholder="Complaint Title" required>
                    </div>
                    <div class="input-field">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" placeholder="Describe your complaint" rows="5" required></textarea>
                    </div>
                </div>
                <div class="btn-field">
                    <button type="submit" id="submitComplaintBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        });
    </script>
</body>
</html>
