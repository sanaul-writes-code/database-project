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
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    // User is not authenticated, redirect to login page
    header('Location: login.php');
    exit();
}

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowers";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE username ='{$_SESSION["uname"]}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>My Profile</h2>";
    echo "<table>";
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><th>First Name: </th><td>".$row["first_name"]."</td></tr>";
        echo "<tr><th>Last Name: </th><td>".$row["last_name"]."</td></tr>";
        echo "<tr><th>Email: </th><td>".$row["email"]."</td></tr>";
        echo "<tr><th>Address: </th><td>".$row["address"]."</td></tr>";
        echo "<tr><th>Phone Number: </th><td>".$row["phone_number"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$get_data_sql = "SELECT * FROM users WHERE username ='{$_SESSION['uname']}'";
$data_result = mysqli_query($conn, $get_data_sql);

if (mysqli_num_rows($data_result) > 0) {
    while($row = mysqli_fetch_assoc($data_result)) {
        //var_dump($result);
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone_number'];
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile</title>
</head>
<body>
<!--<p>
    <a href="update.php">Update My Info</a>
</p>-->
<button id="changeInfoBtn">Update My Info</button>
<div id="updateForm" style="display: none;">
<form method="post" action="update.php">
    <label for="firstnameupdate">First Name:</label><br>
    <input type="text" id="firstnameupdate" name="firstnameupdate" value="<?php echo $fname; ?>"><br><br>

    <label for="lastnameupdate">Last Name:</label><br>
    <input type="text" id="lastnameupdate" name="lastnameupdate" value="<?php echo $lname; ?>"><br><br>

    <label for="emailupdate">Email:</label><br>
    <input type="text" id="emailupdate" name="emailupdate" value="<?php echo $email; ?>"><br><br>

    <label for="addressupdate">Address:</label><br>
    <input type="text" id="addressupdate" name="addressupdate" value="<?php echo $address; ?>"><br><br>

    <label for="phoneupdate">Phone:</label><br>
    <input type="text" id="phoneupdate" name="phoneupdate" value="<?php echo $phone; ?>"><br><br>

    <button type="submit">Update</button>
</form>

<form id="change-password" method="post" action="update.php">
    <label for="oldpwd">Old Password:</label><br>
    <input type="password" id="oldpwd" name="oldpwd"><br><br>
    <label for="newpwd">New Password:</label><br>
    <input type="password" id="newpwd" name="newpwd"><br><br>
    <label for="confnewpwd">Confirm New Password:</label><br>
    <input type="password" id="confnewpwd" name="confnewpwd"><br><br>
    <button type="submit">Update</button>
</form>
</div>

<br><a href="index.php">Go back to homepage</a>

<script>
    document.getElementById('changeInfoBtn').addEventListener('click', function() {
        document.getElementById('updateForm').style.display = 'block';
    });
    document.getElementById('change-password').addEventListener('submit', function(event) {
        var newPassword = document.getElementById('newpwd').value;
        var confirmNewPassword = document.getElementById('confnewpwd').value;

        // Check if the passwords match
        if (newPassword !== confirmNewPassword) {
            // Prevent form submission
            event.preventDefault();
            alert('New password and confirm new password do not match');
        }
    });
</script>
</body>
</html>
