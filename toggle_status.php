<?php
// Start the session
session_start();

// Include database connection
include 'db.php'; // Ensure this is the correct path

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Retrieve the complaint ID
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Determine the new status
    $active = isset($_POST['active']) ? 1 : 0;

    // Update the status in the database using prepared statements
    $stmt = $connection->prepare("UPDATE complaints SET active = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $active, $id);

        if ($stmt->execute()) {
            // Redirect back to the dashboard with a success message
            header("Location: admin_dashboard.php?msg=Status for Complaint ID $id updated successfully");
            exit();
        } else {
            // Redirect back with an error message
            header("Location: admin_dashboard.php?msg=Error updating status for Complaint ID $id");
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect back with an error message if statement preparation failed
        header("Location: admin_dashboard.php?msg=Database error while updating status");
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

<!-- HTML form for toggling status -->
<form action='toggle_status.php' method='post' style='display:inline;'>
    <input type='hidden' name='id' value="<?php echo htmlspecialchars($row['id']); ?>">
    <input type='hidden' name='csrf_token' value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    <label class='switch'>
        <input type='checkbox' name='active' value='1' <?php echo $isActive ? 'checked' : ''; ?> onchange='this.form.submit()'>
        <span class='slider'></span>
    </label>
</form>
