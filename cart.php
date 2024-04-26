<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="alternate-style.css" rel="stylesheet" >
    <style>
        /* Main content container */
        .main-content {
            margin-top: 10px; /* Adjust according to the height of the navigation bar */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Cart item styles */
        .cart-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px; /* Fixed width for the cart item */
            margin-bottom: 10px;
            padding: 10px;
        }
        .cart-item img {
            width: 100%; /* Make the image fill the width of the cart item */
            height: auto; /* Allow the image to adjust its height */
            max-height: 150px;
            object-fit: cover; /* Ensure the image maintains aspect ratio and covers the entire space */
        }
        .cart-item-content {
            margin-top: 10px;
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
    <h1>Shopping Cart</h1> <!-- Heading for shopping cart -->
    <div class="cart-container">
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Cart is not empty, display cart items
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                // Fetch product details from the database using $productId
                // Display product details along with quantity in the cart
                // Example:
                echo "<div class='cart-item'>";
                echo "<img src='product_image.jpg' alt='Product Image' />";
                echo "<div class='cart-item-content'>";
                echo "<h3>Product Name</h3>";
                echo "<p>Quantity: " . $quantity . "</p>";
                // Add more product details as needed
                echo "</div>"; // Close cart-item-content
                echo "</div>"; // Close cart-item
            }
        } else {
            // Cart is empty
            echo "<p>Your shopping cart is empty.</p>";
        }
        ?>
    </div> <!-- Close cart-container -->
</div> <!-- Close main-content -->

</body>
</html>