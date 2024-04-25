<?php

// Set session cookie parameters
$sessionLifetime = 0; // expire when the browser is closed
$sessionPath = '/';
$sessionDomain = ''; // optional, specify your domain
$sessionSecure = true; // if using HTTPS
$sessionHttpOnly = true; // prevent JavaScript access to the session cookie

session_set_cookie_params($sessionLifetime, $sessionPath, $sessionDomain, $sessionSecure, $sessionHttpOnly);
session_start();
// Check if user is authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    // User is not authenticated, redirect to login page
    header('Location: login.php');
    exit();
}
?>

<?php
// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowers";
$failed = false;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
$flag = !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($flag) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phonenumber']);

        $sql = "INSERT INTO users (username, email, password, first_name, last_name, address, phone_number) VALUES ('$username', '$email', MD5('$password'), '$fname', '$lname', '$address', '$phone')";

        try {
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                header('Location: login.php');
                exit; // Terminate the current script
            } else {
                //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                header('Location: signup.php');
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // MySQL error code for duplicate key
                // Handle the duplicate key error
                echo "Duplicate key error: " . $e->getMessage();
            } else {
                // Handle other database errors
                echo "Database error: " . $e->getMessage();
            }
        }

    } else {
        $failed = true;
        echo $failed == true ? "Please enter all the values in the form!" : "";
        $failed = false;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        .required {
            color: red;
        }

    </style>
</head>
<body>

<h2>Signup</h2>

<?php
// Check if an error message is passed in the URL
if (isset($_GET['error'])) {
$error_message = $_GET['error'];
echo '<p style="color: red;">' . htmlspecialchars($error_message) . '</p>';
}
?>

<form method="post" action="signup.php">
    <label for="username">Username<span class="required">*</span>:</label><br>
    <input type="text" name="username" required><br><br>
    <label for="email">Email<span class="required">*</span>:</label><br>
    <input type="text" name="email" required><br><br>
    <label for="password">Password<span class="required">*</span>:</label><br>
    <input type="password" name="password" id="password" required><br><br>
    <input type="checkbox" id="show-password">
    <label for="show-password">Show Password</label><br><br>
    <label for="fname">First Name<span class="required">*</span>:</label><br>
    <input type="text" name="fname" id="fname"><br><br>
    <label for="lname">Last Name<span class="required">*</span>:</label><br>
    <input type="text" name="lname" id="lname"><br><br>
    <label for="address">Address<span class="required">*</span>:</label><br>
    <input type="text" name="address" id="address"><br><br>
    <label for="phonenumber">Phone Number<span class="required">*</span>:</label><br>
    <input type="text" name="phonenumber" id="phonenumber"><br><br>

    <input type="submit" value="Signup">
</form>

<p> Already have an account? <a href="login.php"> Log in here instead </a> </p>

<script>
    document.getElementById('show-password').addEventListener('change', function () {
        var passwordField = document.getElementById('password');
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });
</script>

</body>
</html>
