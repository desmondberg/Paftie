<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require '../functions.php';
require_once("../../../../../mysql_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
    // select the row with matching address
    //if update button is pressed
    if (isset($_POST["update"]) && !empty($_POST["update"])) {
        $sql = "SELECT photo_path, address, landlord FROM property WHERE address = '" . $_POST['update'] . "'";

        $result = mysqli_query($db_connection, $sql);
        if ($result !== false) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            //get the first result
            $row = array_pop($rows);
            $photo_path = $row["photo_path"];
            $address = $row["address"];
            $landlord_email = $row["landlord"];
        } else {
            echo mysqli_error($db_connection);
        }

        mysqli_free_result($result);


        $form_bedrooms = mysqli_real_escape_string($db_connection, $_POST['bedrooms']);
        $form_description = mysqli_real_escape_string($db_connection, $_POST['description']);
        $form_address = mysqli_real_escape_string($db_connection, $_POST['address']);
        $form_type = mysqli_real_escape_string($db_connection, $_POST['type']);
        //calculate total days of tenancy based on if Days, Months or Years was picked

        $tenancy_length_type  = $_POST['tenancy_length_type'];
        $form_tenancy_length = 0;
        if ($tenancy_length_type == "Days") {
            $form_tenancy_length = $_POST['tenancy_length_number'];
        }
        if ($tenancy_length_type == "Months") {
            $form_tenancy_length = $_POST['tenancy_length_number'] * 30;
        }
        if ($tenancy_length_type == "Years") {
            $form_tenancy_length = $_POST['tenancy_length_number'] * 365;
        }

        $form_rent_price = mysqli_real_escape_string($db_connection, $_POST['rent_price']);
        $form_buy_price = mysqli_real_escape_string($db_connection, $_POST['buy_price']);
        $form_availability;
        if(mysqli_real_escape_string($db_connection, $_POST['availability']) == "on"){
            $form_availability=1;
        }else{
            $form_availability=0;
        }


        //bedrooms, description, photo_path, address, type, tenancy_length, rent_price, buy_price, landlord, availability
        $sql = "UPDATE property SET 
        bedrooms = '$form_bedrooms', 
        description = '$form_description', 
        photo_path = '$photo_path', 
        address = '$form_address', 
        type = '$form_type', 
        tenancy_length = '$form_tenancy_length', 
        rent_price = '$form_rent_price', 
        buy_price = '$form_buy_price', 
        landlord = '$landlord_email',
        availablity = '$form_availability' WHERE address = '$address'";

        echo $sql;
        
        if ($db_connection->query($sql)) {
            mysqli_close($db_connection);
            header("location: ../edit_properties.php");
        }

    } else {
        $id = $_POST["id"];
        //escape to prevent injection
        $id = mysqli_real_escape_string($db_connection, $_POST['id']);
        $sql = "SELECT * FROM property WHERE address = '$id'";
        $result = mysqli_query($db_connection, $sql);

        if ($result !== false) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            //get the first result
            $row = array_pop($rows);

            //var_dump($row);

            $bedrooms = $row["bedrooms"];
            $description = $row["description"];
            $photo_path = $row["photo_path"];
            $address = $row["address"];
            $type = $row["type"];
            $tenancy_length = $row["tenancy_length"];
            $rent_price = $row["rent_price"];
            $buy_price = $row["buy_price"];
            $landlord_email = $row["landlord"];
            $availability = $row["availablity"];
        } else {
            echo mysqli_error($db_connection);
        }

        mysqli_free_result($result);
        mysqli_close($db_connection);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="title">
                <img src="../../assets/paft_logo.png" height=50 alt="">
            </div>
        </nav>
    </header>
    <div class="container">
        <form action="../edit_properties.php">
            <button type="submit" class="btn btn-primary">Back</button>
        </form>
        <div class="add-property">
            <h3>Update property</h3>
            <form class="add-properties-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>

                <!-- Address -->
                <div class="mb-3">
                    <label for="username" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
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
                    <input type="number" name="bedrooms" class="form-control" value="<?php echo $bedrooms; ?>">
                </div>
                <!-- Tenancy length-->
                <div class="mb-3">
                    <label for="tenancy_length_type" class="form-label">Tenancy Length</label>
                    <div class="form-group multiple-inputs">
                        <input type="number" name="tenancy_length_number" class="form-control" value="<?php echo $tenancy_length; ?>">
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
                    <input type="number" name="rent_price" class="form-control" value="<?php echo $rent_price; ?>">
                </div>

                <!-- Buy price (if applicable) -->
                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_buyable" id="" <?php
                                                                                                    if ($buy_price !== false) {
                                                                                                        echo "checked";
                                                                                                    }
                                                                                                    ?>>
                            Property can be bought
                        </label>
                    </div>
                    <label for="buy_price" class="form-label">Buy Price</label>
                    <input type="number" name="buy_price" class="form-control" value="<?php echo $buy_price; ?>">
                </div>

                <!-- description-->
                <div class="mb-3">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="" rows="3" placeholder="<?php echo $description; ?>"></textarea>
                    </div>
                </div>

                <!-- Availability -->
                <div class="mb-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="availability" id="" <?php
                                                                                                        if ($availability !== false) {
                                                                                                            echo "checked";
                                                                                                        }
                                                                                                        ?>>
                            Property is available for rent/purchase
                        </label>
                    </div>
                </div>


                <!-- Image upload-->
                <div class="mb-3">
                    <div class="form-group">
                        <button>Upload Image</button>
                    </div>
                </div>

                <button type="submit" name="update" value="<?php echo $_POST["id"];?>" class="btn btn-warning">Update</button>
            </form>
        </div>
    </div>


</body>

</html>