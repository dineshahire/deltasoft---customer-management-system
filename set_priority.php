<?php
// set_priority.php

// Start the session
session_start();

// Include database connection
include 'db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Retrieve the complaint ID and priority
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $priority = isset($_POST['priority']) ? intval($_POST['priority']) : 0;

    // Validate priority value
    $valid_priorities = [0, 1, 2]; // 0: Normal, 1: High, 2: Critical
    if (!in_array($priority, $valid_priorities)) {
        // Redirect back with an error message
        header("Location: admin_dashboard.php?msg=Invalid priority value for Complaint ID $id");
        exit();
    }

    // Update the priority in the database using prepared statements
    $stmt = $connection->prepare("UPDATE complaints SET priority = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $priority, $id);

        if ($stmt->execute()) {
            // Redirect back to the dashboard with a success message
            header("Location: admin_dashboard.php?msg=Priority for Complaint ID $id updated successfully");
            exit();
        } else {
            // Redirect back with an error message
            header("Location: admin_dashboard.php?msg=Error updating priority for Complaint ID $id");
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect back with an error message if statement preparation failed
        header("Location: admin_dashboard.php?msg=Database error while updating priority");
        exit();
    }

    // Close the connection
    $connection->close();
} else {
    // If not a POST request, redirect back
    header("Location: admin_dashboard.php");
    exit();
}
?>
