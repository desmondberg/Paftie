<?php

?>
<header>
    <div class="container">
        <nav>
            <div class="title">
                <h1>Paft.ie</h1>
            </div>
            <div class="login">
                <form action="./SignIn.php" method="post">
                    <input type="submit" value="Login">
                </form>
                <form action="./SignUp.php" method="post">
                    <input type="submit" value="Sign up">
                </form>
                
            </div>
        </nav>
        <?php
        //test displaying session data
        if (isset($_SESSION["username"])) {
            echo '<p>Welcome, ' . $_SESSION["username"] . '</p>';
        }
        ?>
        <form action="#" method="get" class="search-form">
            <input type="text" name="location" placeholder="Enter location">
            <input type="number" name="min-price" placeholder="Min Price" min="500" step="100">
            <input type="number" name="max-price" placeholder="Max Price" min="600" step="100">
            <select name="property-type">
                <option value="">Property Type</option>
                <option value="house">House</option>
                <option value="apartment">Apartment</option>
                <option value="land">Land</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>
</header>