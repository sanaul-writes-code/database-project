<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['action'])) {
    $productId = $_POST['productId'];
    $action = $_POST['action'];

    if ($action === 'reduce') {
        // Handle reducing quantity
        if (isset($_SESSION['cart'][$productId])) {
            if ($_SESSION['cart'][$productId] > 1) {
                $_SESSION['cart'][$productId]--;
            } else {
                // If quantity becomes 0, remove the item from the cart
                unset($_SESSION['cart'][$productId]);
            }
        }
    } elseif ($action === 'increase') {
        // Handle increasing quantity
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        }
    } elseif ($action === 'remove') {
        // Handle removing item
        unset($_SESSION['cart'][$productId]);
    }

    // Return a success response
    echo "success";
} else {
    // Return an error response if the request is invalid
    http_response_code(400);
    echo "Bad Request";
}
?>