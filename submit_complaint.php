<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: lo.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'register'); // Update with your DB details

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $product = $_POST['product'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Insert data into the complaints table
    $stmt = $conn->prepare("INSERT INTO complaints (product, title, description, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $product, $title, $description, $date);

    if ($stmt->execute()) {
        // Redirect to the customer dashboard with success status
        header("Location: customer_dashboard.php?status=success");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
