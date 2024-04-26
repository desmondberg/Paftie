<?php

?>
<header>
    <div class="container">
        <nav>
            <div class="title">
                <form action="./index.php">
                    <img src="../assets/paft_logo.png" height=50 alt="">
                </form>
                <div class="login">
                <form action="./SignIn.php" method="post">
                    <input type="submit" value="Login">
                </form>
                <form action="./SignUp.php" method="post">
                    <input type="submit" value="Sign up">
                </form>
            </div>
            </div>
            <hr>
        </nav>
        <?php
        //test displaying session data
        if (isset($_SESSION["username"])) {
            echo '<p style="margin:0;">Welcome, ' . $_SESSION["permission"] . " - " . $_SESSION["username"] . '</p>';
        }
        ?>
        <?php 
            include("./search_bar.php");
        ?>
       
    </div>
</header>