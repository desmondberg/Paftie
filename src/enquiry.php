<?php 
//errors directive
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require('./functions.php');
require("../../../../mysql_connect.php");

if($_SERVER['REQUEST_METHOD']=="POST"){
    $user = $_SESSION["username"];
    $address = $_GET['address'];

    
    $userQuery = "UPDATE users SET lease = ? WHERE username = ?";
    $propertyQuery = "UPDATE property SET availablity = 0 WHERE address = ?";

    if ($stmt = $db_connection->prepare($userQuery)) {
        $stmt->bind_param("ss", $address, $user);
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt = $db_connection->prepare($propertyQuery)) {
                $stmt->bind_param("s", $address);
                if ($stmt->execute()) {
                    header("location: ./leases.php");
                }
            }
        }
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <?php include("./header.php")?>
    
    <div class="container">
    <h2>Lease this property</h2>
    <?php
        $query = $_GET['address'];
        $query = htmlspecialchars($query);
        $query = trim($query); // remove empty spaces
        $query = strip_tags($query); // html and php tags removed
        $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); // convert anything bad to html characters

        $sql = "SELECT * FROM property WHERE address = '$query' ";

        $result = mysqli_query($db_connection, $sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="property-box normal-property">';
                echo '<div class="property-thumbnail"><img class="thumbnail" src=../assets/' . $row["photo_path"] . '></div>';
                echo "<div class='property-description'>";
                echo "<span class='address bold'>" . $row["address"] . "</span>";
                echo "<span class='landlord-email '>Posted by <span class='bold'> " . $row["landlord"] . "</span> </span>";
                echo "<span class='description'>" . $row["description"] . "</span>";
                echo "<span class='rent-price bold'>€" . $row["rent_price"] . "/month</span>";
                echo "</div>";
                echo '<form method="post" action="">
                        <button style="margin:1rem;" type="submit" class="btn btn-primary">Lease</button>
                    </form>';
                echo "</div>";
            }
        } else {
            echo "no results :(";
        }
    ?>


        
    </div>
    <?php include("./footer.php")?>
</body>
</html>