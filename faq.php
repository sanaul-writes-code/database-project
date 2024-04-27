<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
</head>
<body>
<h1>Frequently Asked Questions (FAQ)</h1>

<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowers";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query 1: Information about flowers and their suppliers
$query1 = "SELECT Flower.*, Supplier.name AS supplier_name
               FROM Flower
               INNER JOIN Supplies ON Flower.flower_id = Supplies.flower_id
               INNER JOIN Supplier ON Supplies.supplier_id = Supplier.supplier_id";

$result1 = $conn->query($query1);

if ($result1->num_rows > 0) {
    echo "<h2>Q: Can you provide information about flowers and their suppliers?</h2>";
    echo "<p>A: Here is the information about flowers and their suppliers:</p>";
    echo "<ul>";
    while($row = $result1->fetch_assoc()) {
        echo "<li>" . $row["regular_name"] . " (Color: " . $row["color"] . ") - Supplier: " . $row["supplier_name"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No information available.</p>";
}

// Query 2: Average price of flowers
$query2 = "SELECT AVG(price) AS average_price FROM Flower";
$result2 = $conn->query($query2);

if ($result2->num_rows > 0) {
    $row = $result2->fetch_assoc();
    echo "<h2>Q: What is the average price of flowers?</h2>";
    echo "<p>A: The average price of flowers is $" . round($row["average_price"], 2) . "</p>";
} else {
    echo "<p>No information available.</p>";
}

// Query 3: Flowers with a price higher than the average price
$query3 = "SELECT *
               FROM Flower
               WHERE price > (SELECT AVG(price) FROM Flower)";

$result3 = $conn->query($query3);

if ($result3->num_rows > 0) {
    echo "<h2>Q: Can you provide information about flowers with a price higher than the average price?</h2>";
    echo "<p>A: Here are the flowers with a price higher than the average price:</p>";
    echo "<ul>";
    while($row = $result3->fetch_assoc()) {
        echo "<li>" . $row["regular_name"] . " (Price: $" . $row["price"] . ")</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No flowers found with a price higher than the average price.</p>";
}

// Query 4: Flowers that are edible and have survivability out of water greater than 3
$query4 = "SELECT *
               FROM Flower
               WHERE edibility = 'edible' AND survivability_out_of_water > 3";

$result4 = $conn->query($query4);

if ($result4->num_rows > 0) {
    echo "<h2>Q: Can you provide information about flowers that are edible and have survivability out of water greater than 3?</h2>";
    echo "<p>A: Here are the flowers that meet the criteria:</p>";
    echo "<ul>";
    while($row = $result4->fetch_assoc()) {
        echo "<li>" . $row["regular_name"] . " (Edibility: " . $row["edibility"] . ", Survivability: " . $row["survivability_out_of_water"] . " days)</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No flowers found that are edible and have survivability out of water greater than 3.</p>";
}

// Query 5: Top 5 most expensive flowers
$query5 = "SELECT *
               FROM Flower
               ORDER BY price DESC
               LIMIT 5";

$result5 = $conn->query($query5);

if ($result5->num_rows > 0) {
    echo "<h2>Q: What are the top 5 most expensive flowers?</h2>";
    echo "<p>A: Here are the top 5 most expensive flowers:</p>";
    echo "<ul>";
    while($row = $result5->fetch_assoc()) {
        echo "<li>" . $row["regular_name"] . " (Price: $" . $row["price"] . ")</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No information available.</p>";
}

// Query 6: Number of flowers available in each region
$query6 = "SELECT region, COUNT(*) AS flower_count
               FROM Flower
               GROUP BY region";

$result6 = $conn->query($query6);

if ($result6->num_rows > 0) {
    echo "<h2>Q: How many flowers are available in each region?</h2>";
    echo "<p>A: Here is the count of flowers available in each region:</p>";
    echo "<ul>";
    while($row = $result6->fetch_assoc()) {
        echo "<li>" . $row["region"] . ": " . $row["flower_count"] . " flowers</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No information available.</p>";
}

// Close the database connection
$conn->close();
?>

</body>
</html>