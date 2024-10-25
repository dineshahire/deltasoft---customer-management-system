<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: lo.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $product_satisfaction = $_POST['product_satisfaction'];
    $service_satisfaction = $_POST['service_satisfaction'];
    $team_satisfaction = $_POST['team_satisfaction'];
    
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'register');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, product_satisfaction, service_satisfaction, team_satisfaction) VALUES (?, ?, ?, ?)");
    
    // Bind the parameters
    $stmt->bind_param("isss", $_SESSION['user_id'], $product_satisfaction, $service_satisfaction, $team_satisfaction);

    if ($stmt->execute()) {
        // Show JavaScript alert and redirect
        echo "<script>
                alert('Feedback submitted successfully!');
                window.location.href = 'customer_dashboard.php';
              </script>";
        exit(); // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
