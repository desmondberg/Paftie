<?php
//function for sanitising form inputs
function sanitiseForm($data)
{
    $sanitisedData = [];
    // sanitise username
    if (isset($data['user'])) {
        $sanitisedData['username'] = htmlspecialchars(trim($data['user']));
    }
    // sanitise email
    if (isset($data['email'])) {
        $sanitisedData['email'] = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
    }
    // sanitise password and password confirmation
    if (isset($data['password']) && isset($data['password_confirm'])) {
        $sanitisedData['password'] = htmlspecialchars(trim($data['password']));
        $sanitisedData['password_confirm'] = htmlspecialchars(trim($data['password_confirm']));
    }
    if (isset($data["address"])) {
        $sanitisedData['address'] = htmlspecialchars(trim($data['address']));
    }
    return $sanitisedData;
}

//function to retrieve hashed password from database
function getHashedPassword($username)
{
    $hash = 0;
    require("../../../../mysql_connect.php");
    $query = "SELECT password FROM users WHERE username = '$username'";
    $stmt = $db_connection->prepare($query);
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($hash);
        if ($stmt->fetch()) {
            return $hash;
        }
    }
}
//function to get the leased address of a tenant user
function getTenantAddress($username)
{
    $address = "";
    require("../../../../mysql_connect.php");
    $query = "SELECT lease FROM users WHERE username = '$username'";
    $stmt = $db_connection->prepare($query);
    if ($stmt->execute()) {
        $stmt->store_result();
        $stmt->bind_result($address);
        if ($stmt->fetch()) {
            return $address;
        }
    }
}

//function to build a modal dialog with the provided row
function dialogBuilder($row)
{
    echo /*html*/ '<dialog class="property-info-modal">';
    echo /*html*/ '<img style="margin-top:auto;" class="property-info-close" src="../assets/icons/x-lg.svg" alt="Bootstrap" width="32" height="32">';
    echo /*html*/ '<hr/>';
    echo /*html*/ '<div class="modal-flex">';
    echo /*html*/ '<div class="property-info-thumbnail"><img class="modal-thumbnail" src=../assets/' . $row["photo_path"] . '></div>';
    echo /*html*/ '<div class="property-info-address">' . $row["address"] . '</div>';
    echo /*html*/ '<div class="property-info-landlord">Posted by <span class="bold">' . $row["landlord"] . '</div>';
    echo /*html*/ '<div class="property-info-description">' . $row["description"] . '</div>';
    echo /*html*/ '<div class="property-info-rent-price">€' . $row["rent_price"] . '/month</div>';
    //display buy price if available
    if (isset($row["buy_price"]) && !empty($row["buy_price"])) {
        echo /*html*/ '<div class="property-info-buy-price">To Buy: €' . $row["buy_price"] . '</div>';
    }
    if (isset($row['availablity'])) {
        //available
        if ($row['availablity'] == 1) {
            echo /*html*/ '<h3>AVAILABLE</h3>';
            //display an additional button if property is available and the user is a tenant
            if ($_SESSION["permission"] == "tenant") {
                echo/*html*/ '<button class="infobtn btn btn-warning" btn-lg btn-block >Make an enquiry</button>';
            }
        }
        //not available
        else if ($row['availablity'] == 0) {
            echo /*html*/ '<h3>SALE AGREED, NOT AVAILABLE</h3>';
        }
    }
    echo /*html*/ '</div>';

    echo /*html*/ '</dialog>';
}
