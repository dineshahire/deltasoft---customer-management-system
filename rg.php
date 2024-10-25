<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $confirmPassword = $_POST['ConformPassword'];

    // Ensure that email is not numeric and all fields are filled
    if (!empty($email) && !empty($password) && !empty($confirmPassword) && !is_numeric($email)) {

        // Check if password contains at least one uppercase and one lowercase letter
        if (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
            
            // Check if password and confirm password match
            if ($password === $confirmPassword) {
                // Insert into the database
                $query = "INSERT INTO form (Name, Email, Password, `Conform Password`) VALUES ('$name', '$email', '$password', '$confirmPassword')";
                mysqli_query($con, $query);
                echo "<script type='text/javascript'>alert('Successfully Registered');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Passwords do not match. Please try again.');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Password must contain at least one uppercase and one lowercase letter.');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please enter valid information.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="rg.css">
    <script src="registration.js" defer></script>
    <script src="https://kit.fontawesome.com/c26da57a21.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1 id="title">Register</h1>
           
            <form method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="userName" name="Name" placeholder="Name" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="userEmail" name="Email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="userPassword" name="Password" placeholder="Password" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="conformPassword" name="ConformPassword" placeholder="Confirm Password" required>
                    </div>
                    <div class="btn-field">
                        <button type="submit" id="registerBtn">Register</button>
                    </div>
                    <p class="login-text">Already have an account? <a href="lo.php">Log In</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
