<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: lo.php");
    exit;
}

// Initialize variables
$trackId = "";
$issue = null;
$successMsg = "";
$errorMsg = "";

// Connect to the database
$host = "localhost"; // Database host
$user = "root"; // Database username
$pass = ""; // Database password (leave empty for default setup)
$dbname = "register"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trackId = trim($_POST['trackId']);

    if (empty($trackId)) {
        $errorMsg = "Please enter an issue ID.";
    } else {
        $trackId = $conn->real_escape_string($trackId);

        $sql = "SELECT * FROM issues WHERE id='$trackId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $issue = $result->fetch_assoc();
        } else {
            $errorMsg = "No issue found with this ID.";
        }
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Issue</title>
    <link rel="stylesheet" href="track_issue.css"> 
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="header">
        <img src="logo.png" alt="Company Logo" class="logo">
        <h1>Track Your Issue</h1>
    </div>

    <div class="container">
        <div class="form-box">
            <h2>Track Your Issue</h2>
            
            <!-- Success Message -->
            <?php if (!empty($successMsg)) : ?>
                <div class="success-message">
                    <p><?php echo $successMsg; ?></p>
                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if (!empty($errorMsg)) : ?>
                <div class="error-message">
                    <p><?php echo $errorMsg; ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <div class="input-field">
                        <label for="trackId">Issue ID:</label>
                        <input type="text" name="trackId" id="trackId" placeholder="Enter your issue ID" value="<?php echo htmlspecialchars($trackId); ?>" required>
                    </div>
                </div>
                <div class="btn-field">
                    <button type="submit">Track Issue</button>
                </div>
            </form>

            <?php if ($issue) : ?>
                <div class="issue-details">
                    <h3>Issue Details</h3>
                    <p><strong>Product:</strong> <?php echo htmlspecialchars($issue['product']); ?></p>
                    <p><strong>Title:</strong> <?php echo htmlspecialchars($issue['title']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($issue['description']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($issue['date']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($issue['status']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
