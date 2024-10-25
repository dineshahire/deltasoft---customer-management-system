<?php
session_start();
include("db.php"); // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['email']) && isset($_POST['pass'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['pass']);

        // Admin credentials
        $admin_email = 'admin123@gmail.com';
        $admin_password = 'admin1234';

        // Handling admin login
        if ($email == $admin_email && $password == $admin_password) {
            $_SESSION['admin'] = true; // Setting a session variable for admin
            header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
            exit;
        } 
        // Handling user login
        else {
            if (!empty($email) && !empty($password)) {
                $query = "SELECT * FROM form WHERE Email = '$email' LIMIT 1";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);

                    if ($user_data['Password'] == $password) {
                        $_SESSION['user_id'] = $user_data['id'];
                        $_SESSION['email'] = $user_data['Email'];
                        header("Location: customer_dashboard.php"); // Redirect to the user dashboard
                        exit;
                    } else {
                        echo "<script>alert('Wrong password. Please try again.');</script>";
                    }
                } else {
                    echo "<script>alert('Email not found. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Please enter both email and password.');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="lo.css">
    <script src="login.js" defer></script>
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1 id="title">Login</h1>
            <form method="POST" action="lo.php">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="pass" placeholder="Password" required>
                    </div>
                    <p>Forgot Password? <a href="" id="forgotPasswordLink">Click Here</a></p>
                </div>
                <div class="btn-field">
                    <button type="submit" id="loginBtn">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
