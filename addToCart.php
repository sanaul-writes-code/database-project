<?php
session_start();

// Check if productId is provided and is a valid integer
if (isset($_POST['productId']) && filter_var($_POST['productId'], FILTER_VALIDATE_INT)) {
    $productId = $_POST['productId'];

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

    // Prepare and execute SQL query to check if the product exists
    $stmt = mysqli_prepare($conn, "SELECT flower_id FROM Flower WHERE flower_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if the product exists in the database
    $productExists = mysqli_stmt_num_rows($stmt) > 0;

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    if ($productExists) {
        // Product exists in the database, add it to the cart or update its quantity

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$productId])) {
            // Product is already in the cart, increment its quantity
            $_SESSION['cart'][$productId]++;
        } else {
            // Product is not in the cart, add it with a quantity of 1
            $_SESSION['cart'][$productId] = 1;
        }

        // Return a success message
        echo "Product added to cart successfully!";
    } else {
        // Product does not exist in the database
        echo "Product does not exist!";
    }
} else {
    // productId is missing or invalid
    echo "Invalid product ID!";
}
?>
