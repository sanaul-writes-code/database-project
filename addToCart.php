<?php
session_start();

// Check if productId is provided and is a valid integer
if (isset($_POST['productId']) && filter_var($_POST['productId'], FILTER_VALIDATE_INT)) {
    $productId = $_POST['productId'];

    // Check if the product exists in the database (you may need to adjust this based on your database structure)
    $productExists = true; // Placeholder value, you should query your database to check if the product exists

    if ($productExists) {
        // Add the product to the cart or update its quantity

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