<?php
session_start(); // Start a new session

// Include database connection
require 'dbcon.php';

// Check if the username and password cookies are set
if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
    // Redirect to contact.php if session variables are set
    header("Location: Contact/contact.php");
    exit();
}

// Define variables to store error message
$error = "";

// Handle form submission
if (isset($_POST["Login"])) {
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        // Sanitize user inputs to prevent XSS
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        // Query to check if the username and password match in the admin table
        $query = "SELECT * FROM admin WHERE username=? AND password=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            // Set session variables
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;

            // Check if the "Remember Me" checkbox is checked
            if(isset($_POST['remember'])) {
                // Set cookies for username and password with a validity of 30 days
                setcookie("username", $username, time() + (86400 * 30), "/");
                setcookie("password", $password, time() + (86400 * 30), "/");
            }

            // Redirect to the dashboard
            header("Location: Contact/contact.php");
            exit();
        } else {
            // Display error message for wrong password
            $error = "Invalid Username/Password";
        }
    } else {
        // Display error message if username or password is empty
        $error = "Username and Password are required";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Animated Login Form</title>
    <link rel="stylesheet" type="text/css" href="Login-form/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <img class="wave" src="Login-form/img/wave.png">
    <div class="container">
        <div class="img">
            <img src="Login-form/img/bg.svg">
        </div>
        <div class="login-content">
            <form method="POST">
                <img src="Login-form/img/avatar.svg">
                <h3 class="title">Welcome Admin</h3>
                <div class="input-div one">
                   <div class="i">
                        <i class="fas fa-user"></i>
                   </div>
                   <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="username">
                   </div>
                </div>
                <div class="input-div pass">
                   <div class="i"> 
                        <i class="fas fa-lock"></i>
                   </div>
                   <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password">
                   </div>
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <input type="submit" class="btn" name="Login" value="Login">
                <?php if($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="Login-form/js/main.js"></script>
</body>
</html>