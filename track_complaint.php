<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: lo.php"); 
    exit;
}

// Initialize variables
$trackingId = "";
$complaint = "";
$successMsg = $errorMsg = "";

// Connect to the database
$host = "localhost"; // Database host
$user = "root"; // Database username
$pass = ""; // Database password
$dbname = "register"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trackingId = trim($_POST['trackingId']);
    
    if (empty($trackingId)) {
        $errorMsg = "Tracking ID is required.";
    } else {
        // Prepare and execute the query to find the complaint
        $sql = "SELECT c.*, t.status FROM complaints c 
                LEFT JOIN complaint_tracking t ON c.id = t.complaint_id 
                WHERE c.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $trackingId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $complaint = $result->fetch_assoc();
            $successMsg = "Complaint details retrieved successfully.";
        } else {
            $errorMsg = "No complaint found with the given ID.";
        }
    }
    
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Complaint</title>
    <link rel="stylesheet" href="track_complaint.css"> 
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Company Logo" class="logo">
            <h1>Track Your Complaint</h1>
        </div>
    </header>

    <main class="container">
        <div class="form-box">
            <h1 class="form-heading">Track Complaint</h1>

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

            <form id="trackForm" method="POST" action="">
                <div class="input-group">
                    <div class="input-field">
                        <label for="trackingId">Tracking ID:</label>
                        <input type="text" name="trackingId" id="trackingId" placeholder="Enter Tracking ID" value="<?php echo htmlspecialchars($trackingId); ?>" required>
                    </div>
                </div>
                <div class="btn-field">
                    <button type="submit" id="trackBtn">Track</button>
                </div>
            </form>

            <!-- Display Complaint Details -->
            <?php if (!empty($complaint)) : ?>
                <div class="complaint-details">
                    <h2>Complaint Details</h2>
                    <p><strong>Product:</strong> <?php echo htmlspecialchars($complaint['product']); ?></p>
                    <p><strong>Title:</strong> <?php echo htmlspecialchars($complaint['title']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($complaint['description']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($complaint['date']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($complaint['status']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
