<?php
session_start();

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowers";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the first name form was submitted
    if (isset($_POST["firstnameupdate"])) {
        $firstname = mysqli_real_escape_string($conn, $_POST["firstnameupdate"]);
        $sql = "UPDATE users SET first_name = '$firstname' WHERE username = '{$_SESSION["uname"]}'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>First name updated successfully!</p>";
        } else {
            echo "<p>Error updating first name: " . mysqli_error($conn) . "</p>";
        }
    }

    // Check if the last name form was submitted
    if (isset($_POST["lastnameupdate"])) {
        $lastname = mysqli_real_escape_string($conn, $_POST["lastnameupdate"]);
        $sql = "UPDATE users SET last_name = '$lastname' WHERE username = '{$_SESSION["uname"]}'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Last name updated successfully!</p>";
        } else {
            echo "<p>Error updating last name: " . mysqli_error($conn) . "</p>";
        }
    }

    // Check if the email form was submitted
    if (isset($_POST["emailupdate"])) {
        $email = mysqli_real_escape_string($conn, $_POST["emailupdate"]);
        $sql = "UPDATE users SET email = '$email' WHERE username = '{$_SESSION["uname"]}'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Email updated successfully!</p>";
        } else {
            echo "<p>Error updating email: " . mysqli_error($conn) . "</p>";
        }
    }

    // Check if the address form was submitted
    if (isset($_POST["addressupdate"])) {
        $address = mysqli_real_escape_string($conn, $_POST["addressupdate"]);
        $sql = "UPDATE users SET address = '$address' WHERE username = '{$_SESSION["uname"]}'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Address updated successfully!</p>";
        } else {
            echo "<p>Error updating address: " . mysqli_error($conn) . "</p>";
        }
    }

    // Check if the phone form was submitted
    if (isset($_POST["phoneupdate"])) {
        $phone = mysqli_real_escape_string($conn, $_POST["phoneupdate"]);
        $sql = "UPDATE users SET phone_number = '$phone' WHERE username = '{$_SESSION["uname"]}'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Phone number updated successfully!</p>";
        } else {
            echo "<p>Error updating phone number: " . mysqli_error($conn) . "</p>";
        }
    }

    // Check if the password form was submitted
    if (isset($_POST["newpwd"])) {
        $oldpwd = mysqli_real_escape_string($conn, $_POST["oldpwd"]);
        $oldpwd = md5($oldpwd);
        $newpwd = mysqli_real_escape_string($conn, $_POST["newpwd"]);
        $newpwd = md5($newpwd);

        // Validate old password
        $check_pwd_sql = "SELECT * FROM users WHERE username='{$_SESSION["uname"]}' AND password='$oldpwd'";
        $pwd_validation = mysqli_query($conn, $check_pwd_sql);

        if (mysqli_num_rows($pwd_validation) > 0) {
            $update_pwd_sql = "UPDATE users SET password = '$newpwd' WHERE username = '{$_SESSION["uname"]}'";
            if (mysqli_query($conn, $update_pwd_sql)) {
                echo "<p>Password changed successfully!</p>";
            } else {
                echo "<p>Error updating password: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p>Wrong password! Try entering the correct old password again.</p>";
        }
    }
}

mysqli_close($conn);

echo "<a href='my-profile.php'>Go To My Profile</a>";
?>
