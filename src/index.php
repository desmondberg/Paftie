<?php
    //errors directive
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav>
            <div class="title">
                <h1>Paft.ie</h1>
            </div>
            <div class="search">
                <div class="form-group">
                <label for=""></label>
                <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                <small id="helpId" class="form-text text-muted">Search for a property</small>
                </div>
            </div>
        </nav>

        <div class="login">
            <button type="button" name="" id="" class="btn btn-primary" btn-lg btn-block">Tenant Login</button>
            <button type="button" name="" id="" class="btn btn-primary" btn-lg btn-block">Landlord Login</button>
            <button type="button" name="" id="" class="btn btn-primary" btn-lg btn-block">Admin Login</button>
        </div>
    </header>
    <main>
        

        <div class="featured">
            <h3>Featured Properties</h3>
            <?php 
            require ("../../../../mysql_connect.php");

            $query = "SELECT first_name, last_name, postcode FROM properties JOIN users";
            $result = mysqli_query($db_connection, $query);
            
            if ($result !== false) {
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    echo '<div class="property-box">';
                        echo '<div class="property-thumbnail"></div>';
                        echo "<span class='address'>" . $row["first_name"] . "</span>";
                        echo "<span class='landlord-email'>" . $row["last_name"] . "</span>";
                        echo "<span class='rent-price'>" . $row["postcode"] . "</span>";
                    echo "</div>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo mysqli_error($db_connection);
            }
            
            mysqli_free_result($result);
            mysqli_close($db_connection);
            
            
            ?>
        </div>
        <div class="all-properties">
            <h3>All Properties</h3>
        </div>
        <div class="testimonials">
            <h3>Testimonials</h3>
        </div>

    </main>
    <footer>
        <div class="menu">
            <a href="">FAQ</a>
            <a href="">Instructions for Landlords</a>
        </div>
    </footer>
</body>
</html>