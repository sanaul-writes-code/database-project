<!DOCTYPE html>
<html lang="en">
<head>
    <title>Display</title>
    <style>
        .wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .image {
            display: flex;
            max-width: 80%;
            overflow: hidden;
            margin: auto;
        }
        img {
            max-width: 400px;
        }
        .resultDiv {
            max-width: 80%;
            display: flex;
            margin: auto;
        }
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
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

$searchParameter = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["searchInput"])) {
    $searchParameter = "%". $_POST["searchInput"] . "%";
}
$sql = "SELECT * FROM flower WHERE scientific_name LIKE '{$searchParameter}' OR regular_name LIKE '{$searchParameter}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Search Result</h2>";
    while($row = mysqli_fetch_assoc($result)) {
        echo '<div class="wrapper">'. "<div class='image'><img src='{$row['image_url']}'></div>" . "<div class='resultDiv'>" .
            "<table>
	    <tr>
    	    <td>Flower ID: </td>
            <td>{$row['flower_id']}</td>
        </tr>
        <tr>
    	    <td>Scientific Name: </td>
            <td>{$row['scientific_name']}</td>
        </tr>
        <tr>
    	    <td>Regular Name: </td>
            <td>{$row['regular_name']}</td>
        </tr>
        <tr>
    	    <td>Color: </td>
            <td>{$row['color']}</td>
        </tr>
        <tr>
    	    <td>Edibility: </td>
            <td>{$row['edibility']}</td>
        </tr>
        <tr>
    	    <td>Survivability out of water: </td>
            <td>{$row['survivability_out_of_water']}</td>
        </tr>
        <tr>
    	    <td>Region: </td>
            <td>{$row['region']}</td>
        </tr>
        <tr>
    	    <td>Amount of Pollen: </td>
            <td>{$row['amount_of_pollen']}</td>
        </tr>
        <tr>
    	    <td>Price: </td>
            <td>{$row['price']}</td>
        </tr>
        </table>
        </div>
        </div>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
<p>
    <a href="index.php">Search for another flower</a>
</p>
</body>
</html>
