<?php
// Errors directive
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

print_r($_SESSION);

require("../../../../mysql_connect.php");

?>

<style>
    .property-box {
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        padding: 10px;
        display: flex;
        align-items: center;
    }

    .property-thumbnail {
        flex: 0 0 30%;
        margin-right: 20px;
    }

    .thumbnail {
        width: 100%;
        border-radius: 5px;
    }

    .property-description {
        flex: 1;
    }

    .address {
        font-weight: bold;
    }

    .landlord-email {
        margin-top: 5px;
        color: #666;
    }

    .description {
        margin-top: 10px;
        color: #333;
    }

    .rent-price {
        margin-top: 10px;
        font-weight: bold;
        color: #009688;
    }

    .infobtn {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .infobtn:hover {
        background-color: #2980b9;
    }
</style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['location'])) {
    $query = $_GET['location'];
    $query = htmlspecialchars($query);
    $query = trim($query); // Remove empty spaces
    $query = strip_tags($query); // HTML and PHP tags removed
    $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); // Convert anything bad to HTML characters
    
    $sql = "SELECT * FROM property WHERE address LIKE '%$query%' OR landlord LIKE '%$query%'";

    $result = mysqli_query($db_connection, $sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="property-box featured-property">';
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
    } else {
        echo "No results :(";
    }
}
?>
