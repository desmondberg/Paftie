<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

//start the session
session_start();


require './functions.php';
require_once("../../../../mysql_connect.php");
$error = '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paft - Edit properties</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("./header.php");
    ?>
    <div class="properties">
        <h3>Your properties</h3>
        <div class="property_list">
            <?php
            $landlord = $_SESSION["username"];
            $landlord_email;

            $landlord_email_sql = "SELECT email FROM users WHERE username = ?";

            if ($stmt = $db_connection->prepare($landlord_email_sql)) {
                $stmt->bind_param("s", $landlord);
            }


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                // Check if email exists
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($landlord_email);
                    $stmt->fetch();
                } else {
                    echo "You have no properties to manage.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }


            // Close statement
            $stmt->close();


            $query = "SELECT * FROM property JOIN users ON property.landlord = users.email";
            $result = mysqli_query($db_connection, $query);

            if ($result !== false) {
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    if ($row["landlord"] == $landlord_email) {
                        echo '<div class="property-box normal-property">';
                        echo '<div class="property-thumbnail"><img class="thumbnail" src=../assets/' . $row["photo_path"] . '></div>';
                        echo "<div class='property-description'>";
                        echo "<span class='address bold'>" . $row["address"] . "</span>";
                        echo "<span class='landlord-email '>Posted by <span class='bold'> " . $row["landlord"] . "</span> </span>";
                        echo "<span class='description'>" . $row["description"] . "</span>";
                        echo "<span class='rent-price bold'>€" . $row["rent_price"] . "/month</span>";
                        echo "</div>";
                        echo "<button class='infobtn btn btn-primary' btn-lg btn-block >More Info</button>";
                        echo "</div>";
                    }
                }
            } else {
                echo mysqli_error($db_connection);
            }

            mysqli_free_result($result);



            ?>

        </div>
    </div>
    <form action="./index.php">
        <button type="submit" class="btn btn-primary">Back to main page</button>
    </form>
    <?php
    include("./footer.php")
    ?>
</body>

</html>