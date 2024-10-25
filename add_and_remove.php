<?php
// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "register";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Insert the customer into the staff table
    $insert_sql = "INSERT INTO staff (id, name, email) VALUES ('$id', '$name', '$email')";
    $delete_sql = "DELETE FROM form WHERE id='$id'";

    // Execute both queries in a transaction
    $connection->begin_transaction();
    try {
        $connection->query($insert_sql);
        $connection->query($delete_sql);
        $connection->commit();
        // Redirect back to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } catch (Exception $e) {
        $connection->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$connection->close();
?>
