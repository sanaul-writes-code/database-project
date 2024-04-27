<?php
// Set session cookie parameters
$sessionLifetime = 0; // expire when the browser is closed
$sessionPath = '/';
$sessionDomain = ''; // optional, specify your domain
$sessionSecure = true; // if using HTTPS
$sessionHttpOnly = true; // prevent JavaScript access to the session cookie

session_set_cookie_params($sessionLifetime, $sessionPath, $sessionDomain, $sessionSecure, $sessionHttpOnly);

session_start();

// Check if the user is already logged in
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // If the user is already authenticated, redirect to the index page
    header('Location: index.php');
    exit; // Ensure that script execution stops after redirection
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="alternate-style.css" rel="stylesheet" >
</head>
<body>
<!-- Navigation bar -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="cart.php">Shopping Cart</a>
    <a href="faq.php">FAQ</a>
</div>

<!-- Second Navigation Bar -->
<div class="navbar-second">
    <div class="nav-right">
        <a href="my-profile.php">My Profile</a>
        <a href="signup.php">Signup</a>
        <?php
        // Check if user is authenticated
        if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
            // User is authenticated, hide login button and show logout button
            $logout = 'logout.php';
            //echo "<button id='logoutBtn'><a href='logout.php'>Logout</a></button>";
            echo "<div class='dropdown' id='logoutBtn'>
                <button class='dropbtn'>{$_SESSION['uname']}
                    <i class='fa fa-caret-down'></i>
                </button>
                <div class='dropdown-content'>
                    <a href='my-profile.php'>My Profile</a>
                    <a href='logout.php'>Logout</a>
                </div>
                </div>";
        } else {
            // User is not authenticated, show login button and hide logout button
            $login = 'login.php';
            echo "<div class='dropdown'>";
            echo "<a id='loginBtn' href='login.php'>Login</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<h2>Login</h2>

<?php
// Check if an error message is passed in the URL
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    echo '<p style="color: red;">' . htmlspecialchars($error_message) . '</p>';
    echo "<a href='login.php'>Click here to log in</a><br><br>";
    echo "<a href='signup.php'>Click here to sign up</a><br><br>";
}
?>

<form method="post" action="authenticate.php">
    <label for="username">Username:</label><br>
    <input type="text" name="username" required><br><br>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" required><br><br>
    <input type="checkbox" id="show-password">
    <label for="show-password">Show Password</label><br><br>
    <input type="submit" value="Login">
</form>
<br>

<p> Don't have an account? <a href="signup.php"> Sign up here </a> </p>

<a href="index.php">Go back to homepage</a>

<script>
document.getElementById('show-password').addEventListener('change', function() {
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

