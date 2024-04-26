<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="alternate-style.css" rel="stylesheet" >
    <style>
        /* Main content container */
        .main-content {
            margin-top: 10px; /* Adjust according to the height of the navigation bar */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Card styles */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px; /* Fixed width for the card */
            height: auto; /* Let the height adjust based on content */
            overflow: hidden; /* Hide overflowing content */
            display: flex;
            flex-direction: column;
        }
        .image-container {
            height: 300px; /* Fixed height for the image */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .card img {
            width: 100%; /* Make the image fill the width of the card */
            height: auto; /* Allow the image to adjust its height */
            max-height: 300px;
            object-fit: cover; /* Ensure the image maintains aspect ratio and covers the entire space */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .card-content {
            padding: 10px;
            overflow: auto; /* Enable scrolling for overflow content */
        }
    </style>
</head>
<body>
<!-- Navigation bar -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <!--<a href="readers-choice.php">Readers' Choice</a>
    <a href="index.php#about">About</a>
    <a href="index.php#contact">Contact Us</a>-->
</div>

<!-- Second Navigation Bar -->
<div class="navbar-second">
    <div class="nav-right">
        <a href="my-profile.php">My Profile</a>
        <!--<a href="my-list.php">My List</a>-->
        <!--<a href="login.php">Login</a>-->
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

<!-- Main content -->
<div class="main-content">
    <h1>Products</h1> <!-- Heading for products -->
    <div class="card-container">
        <?php
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

        $sql = "SELECT * FROM flower ORDER BY regular_name";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card'>";
                echo "<div class='image-container'>";
                echo "<img src='" . $row["image_url"] . "' alt='" . $row["regular_name"] . "' />";
                echo "</div>"; // Close image-container
                echo "<div class='card-content'>";
                echo "<h3>" . $row["regular_name"] . "</h3>";
                echo "<p><strong>Color:</strong> " . $row["color"] . "</p>";
                echo "<p><strong>Edibility:</strong> " . $row["edibility"] . "</p>";
                echo "<p><strong>Survivability out of water:</strong> " . $row["survivability_out_of_water"] . "</p>";
                echo "<p><strong>Region:</strong> " . $row["region"] . "</p>";
                echo "<p><strong>Amount of pollen:</strong> " . $row["amount_of_pollen"] . "</p>";
                echo "<p style='font-size: 22px'><strong>Price:</strong> \$" . $row["price"] . "</p>";
                echo "</div>"; // Close card-content
                echo "</div>"; // Close card
            }
        } else {
            echo "0 results";
        }

        mysqli_close($conn);
        ?>
    </div> <!-- Close card-container -->
</div> <!-- Close main-content -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loginBtn = document.getElementById('loginBtn');
        var logoutBtn = document.getElementById('logoutBtn');

        // Add event listener for login button click
        /*loginBtn.addEventListener('click', function() {
            // Redirect to login page
            window.location.href = 'login.php';
        });

        // Add event listener for logout button click
        logoutBtn.addEventListener('click', function() {
            // Perform logout operation, e.g., redirect to logout script
            window.location.href = 'logout.php';
        });*/

        // Check if user is logged in and toggle button visibility
        /*?php
        if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
            echo 'loginBtn.style.display = "none";';
            echo 'logoutBtn.style.display = "block";';
        } else {
            echo 'loginBtn.style.display = "block";';
            echo 'logoutBtn.style.display = "none";';
        }
        ?>*/
    });
</script>

</body>
</html>