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
        }
        nav{
            display:flex;
            align-items: center;
            justify-content:space-between;
        }
        h3{
            text-align: center;
            font-size:48px;
        }
        .section{
            margin:1rem;
            padding:0.5rem;
            border-bottom:1px dotted black;
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

        .testimonial{
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        .testimonial_description{
            width:30rem;
            height:4rem;
            word-wrap:break-word;
        }

        .thumbnail{
            height:125px;
            width:125px;
        }
        .profile{
            height:125px;
            width:125px;
        }

        header{
            padding:1rem;
            background-color:#c6e7ef;
        }
        footer{
            height:10rem;
            background-color:#c6e7ef;
            padding:1rem;
        }
        .menu{
            display:flex;
            
            flex-direction:column;

        }

    </style>
</head>
<body>
    <?php 
        include("./header.php");
    ?>    
    <main>
        

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
                    echo '<div class="property-box featured-property">';
                        echo '<div class="property-thumbnail"><img class="thumbnail" src=../assets/'. $row["photo_path"].'></div>';
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
        <div class="section all-properties">
            <h3>All Properties</h3>
            <div class="property_list">
                <?php 
                

                $query = "SELECT * FROM property";
                $result = mysqli_query($db_connection, $query);
                
                if ($result !== false) {
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($rows as $row) {
                        echo '<div class="property-box normal-property">';
                            echo '<div class="property-thumbnail"><img class="thumbnail" src=../assets/'. $row["photo_path"].'></div>';
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
        <div class="section testimonials">
            <h3>Testimonials</h3>
            <?php 
                

                $query = "SELECT * FROM testimonials";
                $result = mysqli_query($db_connection, $query);
                
                if ($result !== false) {
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $profilePath ="";
                    if(is_null(@$row["profile_path"])){
                        $profilePath = "profiles/default.png";
                    }else{
                        $profilePath = $row["profile_path"];
                    }
    
                    foreach ($rows as $row) {
                        echo '<div class="testimonial">';
                            echo '<div class="testimonial-profile">
                                    <img class="profile" src="../assets/'.$profilePath. '">
                                </div>';
                                echo "<span class='testimonial-email '><span class='bold'> " . $row["user_email"] . "</span> </span>";
                                echo "<span class='testimonial_description'>" . $row["text"] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo mysqli_error($db_connection);
                }
                
                mysqli_free_result($result);
               
                
                
                ?>
        </div>

    </main>
    <?php 
        include("./footer.php")
    ?>
</body>
<?php 
    mysqli_close($db_connection);
?>
</html>