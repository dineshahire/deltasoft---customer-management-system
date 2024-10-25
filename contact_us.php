<?php
// Initialize variables
$name = $email = $phone = $message = "";
$successMsg = $errorMsg = "";
$nameErr = $emailErr = $phoneErr = $messageErr = "";

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
    // Validate inputs
    $name = trim($_POST['userName']);
    $email = trim($_POST['userEmail']);
    $phone = trim($_POST['userPhone']);
    $message = trim($_POST['userMessage']);
    $valid = true;

    if (empty($name)) {
        $nameErr = "Name is required.";
        $valid = false;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Valid email is required.";
        $valid = false;
    }

    if (empty($phone)) {
        $phoneErr = "Phone number is required.";
        $valid = false;
    }

    if (empty($message)) {
        $messageErr = "Message is required.";
        $valid = false;
    }

    // If all inputs are valid, insert data into the database
    if ($valid) {
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $phone = $conn->real_escape_string($phone);
        $message = $conn->real_escape_string($message);

        $sql = "INSERT INTO contact_us (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

        if ($conn->query($sql) === TRUE) {
            $successMsg = "Message sent successfully!";
            // Clear form fields after successful submission
            $name = $email = $phone = $message = "";
        } else {
            $errorMsg = "Error: " . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="contact_us.css">
    <!-- Include Font Awesome icons -->
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1 id="title">Contact Us</h1>

            <!-- Success Message -->
            <?php if (!empty($successMsg)) : ?>
                <div class="success-message" id="successMessage">
                    <p><?php echo $successMsg; ?></p>
                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if (!empty($errorMsg)) : ?>
                <div class="error-message">
                    <p><?php echo $errorMsg; ?></p>
                </div>
            <?php endif; ?>

            <form id="contactForm" method="POST" action="">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="userName" id="userName" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <?php if (!empty($nameErr)) : ?>
                        <p class="error"><?php echo $nameErr; ?></p>
                    <?php endif; ?>

                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="userEmail" id="userEmail" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <?php if (!empty($emailErr)) : ?>
                        <p class="error"><?php echo $emailErr; ?></p>
                    <?php endif; ?>

                    <div class="input-field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="userPhone" id="userPhone" placeholder="Phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <?php if (!empty($phoneErr)) : ?>
                        <p class="error"><?php echo $phoneErr; ?></p>
                    <?php endif; ?>

                    <div class="input-field">
                        <i class="fa-solid fa-comment"></i>
                        <textarea name="userMessage" id="userMessage" placeholder="Your Message" rows="4" required><?php echo htmlspecialchars($message); ?></textarea>
                    </div>
                    <?php if (!empty($messageErr)) : ?>
                        <p class="error"><?php echo $messageErr; ?></p>
                    <?php endif; ?>
                </div>
                <div class="btn-field">
                    <button type="submit" id="contactBtn">Send Message</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            <?php if (!empty($successMsg)) : ?>
                $('#successMessage').fadeIn().delay(3000).fadeOut();
            <?php endif; ?>
        });
    </script>
</body>
</html>
