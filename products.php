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
        .add-to-cart-btn {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<!-- Navigation bar -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="cart.php">Shopping Cart</a>
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
                echo "<button class='add-to-cart-btn' onclick='addToCart(" . $row["flower_id"] . ")'>Add to Cart</button>";
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
    function addToCart(productId) {
        // Send AJAX request to addToCart.php with productId
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "addToCart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText); // Display response from addToCart.php
            }
        };
        xhr.send("productId=" + productId);
    }
</script>

</body>
</html>
