<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

//start the session
session_start();


require './functions.php';
require_once("../../../../mysql_connect.php");
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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


    $address = $_POST['address'];
    $bedrooms  = $_POST['bedrooms'];
    $photo_path = NULL;
    $type = $_POST['type'];

    //calculate total days of tenancy based on if Days, Months or Years was picked

    $tenancy_length_type  = $_POST['tenancy_length_type'];
    $tenancy_length = 0;
    if ($tenancy_length_type == "Days") {
        $tenancy_length = $_POST['tenancy_length_number'];
    }
    if ($tenancy_length_type == "Months") {
        $tenancy_length = $_POST['tenancy_length_number'] * 30;
    }
    if ($tenancy_length_type == "Years") {
        $tenancy_length = $_POST['tenancy_length_number'] * 365;
    }


    $rent_price  = $_POST['rent_price'];
    $buy_price  = $_POST['buy_price'];
    $description = $_POST['description'];
    $availability = 1;


    //bedrooms, description, photo_path, address, type, tenancy_length, rent_price, buy_price, landlord, availability
    $insert_sql = "INSERT INTO property VALUES(?,?,?,?,?,?,?,?,?,?)";
    $stmt = $db_connection->prepare($insert_sql);
    $stmt->bind_param("ssssssssss", $bedrooms, $description, $photo_path, $address, $type, $tenancy_length, $rent_price, $buy_price, $landlord_email, $availability);
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paft - Edit properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    include("./header.php");
    ?>
    <div class="main">
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
                            echo "<form method='post' action='./CRUD/update.php'><input type='hidden' name='id' value='" . $row["address"] . "'><button class='btn btn-warning' btn-lg btn-block  type='submit'>Update</button></form>";
                            echo "<form method='post' action='./CRUD/delete.php'><input type='hidden' name='id' value='" . $row["address"] . "'><button class='btn btn-danger' btn-lg btn-block  type='submit'>Delete</button></form>";
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
        <div class="border"></div>
        <div class="add-property">
            <h3>Add a new property</h3>
            <form class="add-properties-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>

                <!-- Address -->
                <div class="mb-3">
                    <label for="username" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <!-- Property Type -->
                <div class="mb-3">

                    <div class="form-group">
                        <label for="type" class="form-label">Property type</label>
                        <select class="form-control" name="type" id="type">
                            <option>Apartment</option>
                            <option>Detached House</option>
                            <option>Terraced House</option>
                            <option>Bungalow</option>
                            <option>Villa</option>
                            <option>Land</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>
                <!-- No. of bedrooms -->
                <div class="mb-3">
                    <label for="bedrooms" class="form-label">Number of bedrooms</label>
                    <input type="number" name="bedrooms" class="form-control">
                </div>
                <!-- Tenancy length-->
                <div class="mb-3">
                    <label for="tenancy_length_type" class="form-label">Tenancy Length</label>
                    <div class="form-group multiple-inputs">
                        <input type="number" name="tenancy_length_number" class="form-control">
                        <select class="form-control" name="tenancy_length_type">
                            <option>Days</option>
                            <option>Months</option>
                            <option>Years</option>
                        </select>
                    </div>
                </div>
                <!-- Rent price -->
                <div class="mb-3">
                    <label for="rent_price" class="form-label">Rent Price (per month)</label>
                    <input type="number" name="rent_price" class="form-control" value=0>
                </div>

                <!-- Buy price (if applicable) -->
                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_buyable" id="">
                            Property can be bought
                        </label>
                    </div>
                    <label for="buy_price" class="form-label">Buy Price</label>
                    <input type="number" name="buy_price" class="form-control" value=0>
                </div>

                <!-- description-->
                <div class="mb-3">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="" rows="3"></textarea>
                    </div>
                </div>


                <!-- Image upload-->
                <div class="mb-3">
                    <div class="form-group">
                        <button>Upload Image</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning">Add</button>
            </form>
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