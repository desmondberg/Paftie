<?php
    //errors directive
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require ("../../../../mysql_connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html,body{
            margin:0.5rem;
        }
        nav{
            display:flex;
            align-items: center;
            justify-content:space-between;
        }
        .search{
            width:50rem;
        }
        .featured{
           
        }
        .featured-grid{
            display:grid;
            grid-template-columns: 1fr 1fr;
        }
        .property-box{
            margin:0.5rem;
            display:flex;
            
            
            border-radius:0.5rem;
            justify-content:space-between;
            align-items:center;
        }
        .normal-property{
            height:8rem;
            background-color:antiquewhite;
        }
        .featured-property{
            height:10rem;
            background-color:lightblue;
        }
        .property-thumbnail{
            width:8rem;
            height:8rem;
            margin:0.3rem;
            border-radius:0.5rem;
            background-color:#c6e7ef;
        }
        .property-description{
            margin-right: auto;
            display:flex;
            flex-direction: column;
        }
        .normal-property .property-description{
            max-width:80rem;
        }
        .featured-property .property-description{
            max-width:40rem;
        }

        .address{
            font-size:32px;
            
        }
        .bold{
            font-weight:bold;
        }
        .rent-price{
            font-size:24px;
        }
        .description{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .infobtn{
            height:5rem;
            width:8rem;
            margin:0.5rem;
            background-color:#c6e7ef;
            color:black;
        }
    </style>
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
            <div class="login">
                <button type="button" name="tenant_login" id="" class="btn btn-primary" btn-lg btn-block">Tenant Login</button>
                <button type="button" name="landlord_login" id="" class="btn btn-primary" btn-lg btn-block">Landlord Login</button>
                <button type="button" name="admin_login" id="" class="btn btn-primary" btn-lg btn-block">Admin Login</button>
            </div>
        </nav>

        
    </header>
    <main>
        

        <div class="featured">
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
                    echo '<div class="property-box featured-property">';
                        echo '<div class="property-thumbnail">image</div>';
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
                echo mysqli_error($db_connection);
            }
            
            mysqli_free_result($result);
            
            
            
            ?>
            </div>
        </div>
        <div class="all-properties">
            <h3>All Properties</h3>
            <div class="property_list">
                <?php 
                

                $query = "SELECT * FROM property";
                $result = mysqli_query($db_connection, $query);
                
                if ($result !== false) {
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($rows as $row) {
                        echo '<div class="property-box normal-property">';
                            echo '<div class="property-thumbnail">image</div>';
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
                    echo mysqli_error($db_connection);
                }
                
                mysqli_free_result($result);
               
                
                
                ?>

            </div>
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
<?php 
    mysqli_close($db_connection);
?>
</html>