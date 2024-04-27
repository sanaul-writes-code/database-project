<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="alternate-style.css" rel="stylesheet">
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

        /* Cart controls */
        .cart-controls {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            width: 300px;
        }

        .cart-controls button {
            padding: 5px 10px;
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

<!-- Main content -->
<div class="main-content">
    <h1>Shopping Cart</h1> <!-- Heading for shopping cart -->
    <div class="cart-container">
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
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

            // Fetch product details for each product in the cart
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                // Retrieve product details from the database
                $sql = "SELECT * FROM Flower WHERE flower_id = $productId";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    // Display the product details including the image
                    echo "<div class='cart-item'>";
                    echo "<img src='" . $row["image_url"] . "' alt='" . $row["regular_name"] . "' />";
                    echo "<div class='cart-item-content'>";
                    echo "<h3>" . $row["regular_name"] . "</h3>";
                    echo "<p>Quantity: " . $quantity . "</p>";
                    // Add more product details as needed
                    echo "</div>"; // Close cart-item-content
                    echo "<div class='cart-controls'>";
                    echo "<button onclick='reduceQuantity($productId)'>-</button>";
                    echo "<button onclick='increaseQuantity($productId)'>+</button>";
                    echo "<button onclick='removeItem($productId)'>Remove Item</button>";
                    echo "</div>"; // Close cart-controls
                    echo "</div>"; // Close cart-item
                }
            }

            // Close database connection
            mysqli_close($conn);
        } else {
            // Cart is empty
            echo "<p>Your shopping cart is empty.</p>";
        }
        ?>
    </div> <!-- Close cart-container -->

    <div class="cart-controls">
        <button onclick="emptyCart()">Delete My Cart</button>
    </div> <!-- Close cart-controls -->
</div> <!-- Close main-content -->

<script>
    function reduceQuantity(productId) {
        // Send an AJAX request to update the quantity of the product in the cart
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    // Update the cart display or perform any other necessary actions
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    // Handle error
                    console.error("Error: " + xhr.status);
                }
            }
        };
        xhr.open("POST", "updateQuantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("productId=" + productId + "&action=reduce");
    }

    function increaseQuantity(productId) {
        // Send an AJAX request to update the quantity of the product in the cart
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    // Update the cart display or perform any other necessary actions
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    // Handle error
                    console.error("Error: " + xhr.status);
                }
            }
        };
        xhr.open("POST", "updateQuantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("productId=" + productId + "&action=increase");
    }

    function removeItem(productId) {
        // Send an AJAX request to remove the product from the cart
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    // Update the cart display or perform any other necessary actions
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    // Handle error
                    console.error("Error: " + xhr.status);
                }
            }
        };
        xhr.open("POST", "updateQuantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("productId=" + productId + "&action=remove");
    }

    function emptyCart() {
        // Send an AJAX request to empty the entire cart
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    // Update the cart display or perform any other necessary actions
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    // Handle error
                    console.error("Error: " + xhr.status);
                }
            }
        };
        xhr.open("GET", "emptyCart.php", true);
        xhr.send();
    }
</script>

</body>
</html>