<?php

?>
<header>
    <div class="container">
        <nav>
            <div class="title">
                <img src="../assets/paft_logo.png" height=50 alt="">
                <?php
                //test displaying session data
                if (isset($_SESSION["username"])) {
                    echo '<p style="font-size:24px; margin:0;">Welcome, ' . $_SESSION["username"] . '</p>';
                }
                ?>
                <div class="login">
                    <form action="./SignIn.php" method="post">
                        <input type="submit" value="Login">
                    </form>
                    <form action="./SignUp.php" method="post">
                        <input type="submit" value="Sign up">
                    </form>
                </div>
            </div>

        </nav>
        <hr>
        <div class="features">
            <?php
            include("./search_bar.php");
            ?>
            <div class="border"></div>
            <!-- buttons for admins and landlords -->
            <form action="./index.php">
                <button type="submit" class="btn btn-primary">Main Page</button>
            </form>
            <section class='edit-properties'>
                <?php
                if ($_SESSION["permission"] == "admin") {
                    echo '<form action="./control_panel.php">
                <button class="btn btn-primary btn-danger" type="submit">Control Panel</button>
            </form>';
                }
                if ($_SESSION["permission"] == "landlord") {
                    echo '<form action="./edit_properties.php">
                <button class="btn btn-primary" type="submit">Your properties</button>
            </form>';
                }
                ?>

            </section>
        </div>



    </div>
</header>