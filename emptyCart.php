<?php
session_start();

// Empty the cart session variable
$_SESSION['cart'] = [];

// Return a success response
echo "success";
?>