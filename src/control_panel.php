<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require('./functions.php');
require("../../../../mysql_connect.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    include("./header.php");
    ?>
    <div class="container">
        <h2>Control Panel</h2>
        <!-- ALL PROPERTIES -->
        <div class="section all-properties">
            <h3>All Properties</h3>
            <div class="property_list">
                <?php


                $query = "SELECT * FROM property";
                $result = mysqli_query($db_connection, $query);

                if ($result !== false) {
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($rows as $row) {
                        echo /*html*/ '<div class="property-box normal-property">';
                        echo /*html*/ '<div class="property-thumbnail"><img class="thumbnail" src=../assets/' . $row["photo_path"] . '></div>';
                        echo /*html*/ "<div class='property-description'>";
                        echo /*html*/ "<span class='address bold'>" . $row["address"] . "</span>";
                        echo/*html*/  "<span class='landlord-email '>Posted by <span class='bold'> " . $row["landlord"] . "</span> </span>";
                        echo /*html*/ "<span class='description'>" . $row["description"] . "</span>";
                        echo/*html*/  "<span class='rent-price bold'>€" . $row["rent_price"] . "/month</span>";
                        echo/*html*/  "</div>";
                        echo/*html*/ "<form method='post' action='./CRUD/update.php'><input type='hidden' name='id' value='" . $row["address"] . "'><button class='btn btn-warning' btn-lg btn-block  type='submit'>Update</button></form>";
                        echo/*html*/ "<form method='post' action='./CRUD/delete.php'><input type='hidden' name='id' value='" . $row["address"] . "'><button class='btn btn-danger' btn-lg btn-block  type='submit'>Delete</button></form>";
                        echo/*html*/  "</div>";
                    }
                } else {
                    echo mysqli_error($db_connection);
                }

                mysqli_free_result($result);



                ?>

            </div>
        </div>
    </div>

    <?php
    include("./footer.php")
    ?>

</body>

</html>