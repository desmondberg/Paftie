<?php
//errors directive
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
    <title>Property Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet">
</head>

<body>

    <?php
    include("./header.php");
    ?>
    <div class="container">
        <div class="ad-container">
            <div class="ad">
                <p>AD GOES HERE</p>
            </div>
            <div class="ad">
                <p>AD GOES HERE</p>
            </div>
        </div>
    </div>

    <div class="container">
        <h2>Property Listings</h2>
        <section class="property-listings">
            <div class="section featured">
                <h3>Featured Properties</h3>
                <div class="featured-grid">

                    <?php
                    $query = "SELECT * FROM property";
                    $result = mysqli_query($db_connection, $query);

                    if ($result !== false) {
                        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        //the featured array won't be the entire property array
                        array_pop($rows);
                        foreach ($rows as $row) {
                            //the html comment enables syntax highlighting through a VS Code plugin called "PHP html in string" by NiceYannick
                            echo /*html*/ '<div class="property-box featured-property">';
                            echo /*html*/ '<div class="property-thumbnail"><img class="thumbnail" src=../assets/' . $row["photo_path"] . '></div>';
                            echo /*html*/ "<div class='property-description'>";
                            echo /*html*/ "<span class='address bold'>" . $row["address"] . "</span>";
                            echo /*html*/ "<span class='landlord-email '>Posted by <span class='bold'> " . $row["landlord"] . "</span> </span>";
                            echo /*html*/ "<span class='description'>" . $row["description"] . "</span>";
                            echo /*html*/ "<span class='rent-price bold'>€" . $row["rent_price"] . "/month</span>";
                            echo /*html*/ "</div>";
                            echo /*html*/ "<button class='more-info open infobtn btn btn-primary' btn-lg btn-block >More Info</button>";


                            //modal info view

                            dialogBuilder($row);



                            //display an additional button if the user is a tenant
                            if ($_SESSION["permission"] == 'tenant') {
                                echo/*html*/ "
                                <button class='infobtn btn btn-warning' btn-lg btn-block >Make an enquiry</button>
                                ";
                            }
                            echo/*html*/ "</div>";
                        }
                    } else {
                        echo mysqli_error($db_connection);
                    }

                    mysqli_free_result($result);



                    ?>
                </div>
            </div>

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
                            echo/*html*/  "<button class='more-info open infobtn btn btn-primary' btn-lg btn-block >More Info</button>";



                            dialogBuilder($row);


                            //display an additional button if the user is a tenant
                            if ($_SESSION["permission"] == 'tenant') {
                                echo/*html*/  "<button class='infobtn btn btn-warning' btn-lg btn-block >Make an enquiry</button>";
                            }
                            echo/*html*/  "</div>";
                        }
                    } else {
                        echo mysqli_error($db_connection);
                    }

                    mysqli_free_result($result);



                    ?>

                </div>
            </div>
        </section>

        <!-- output testimonials here -->
        <div class="section testimonials">
            <div class="container">
                <h3>Testimonials</h3>
                <?php

                //create query statement
                $query = "SELECT * FROM testimonials";
                //execute query on Paft database
                $result = mysqli_query($db_connection, $query);


                //if there is a result:
                if ($result !== false) {
                    //get the result as rows
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    $profilePath = "";


                    foreach ($rows as $row) {
                        //if a profile pic is available for the testimonial, use it. otherwise use the default profile pic
                        if (is_null($row["profile_path"])) {
                            $profilePath = "profiles/default.png";
                        } else {
                            $profilePath = $row["profile_path"];
                        }
                        echo /*html*/ '<div class="testimonial">';
                        echo /*html*/ '<div class="testimonial-profile">
                                    <img class="profile" src="../assets/' . $profilePath . '">
                                </div>';
                        echo/*html*/  "<span class='testimonial-email '><span class='bold'> " . $row["user_email"] . "</span> </span>";
                        echo /*html*/ "<span class='testimonial_description'>" . $row["text"] . "</span>";
                        echo /*html*/ "</div>";
                        echo /*html*/ "</div>";
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

<script src="./scripts/modal.js"></script>
</body>

</html>