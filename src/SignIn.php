<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);

    //start the session
    session_start();


    require './functions.php';
    require_once ("../../../../mysql_connect.php");
    $error = '';

    //if the user got onto login.php through a form, then proceed. else redirect them back to index.php
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $sanitised = sanitiseForm($_POST);

        var_dump($sanitised);

        $user = trim($sanitised['username']);
        $password = trim($sanitised['password']);
        $password_confirm =  trim($sanitised['password_confirm']);
    
        // validate if email is empty
        if (empty($user)) {
            $error .= '<p class="error">Please enter your username.</p>';
        }
    
        if(empty($password)){
            $error .= '<p class="error">Please enter password.</p>';
        }

        if($password!==$password_confirm){
            $error .= '<p class="error">The password and the password confirmation don\'t match.</p>';
        }

        if(empty($error)){
            $sql = "SELECT username, password FROM users WHERE username = ? AND password = ?";
            if($stmt = $db_connection->prepare($sql)){
                //hashing (not needed until the signup script is created)
                //$hashedPass = password_hash($password, PASSWORD_DEFAULT);

                // Set parameters
                $param_user = $user;
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("ss", $param_user, $password);
                
        
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    
                    // Store result
                    $stmt->store_result();
                    
                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1){                    
                        // Bind result variables
                        $stmt->bind_result($user, $password);
                        if($stmt->fetch()){
                            session_start();
                                
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $user;    

                            header("location: welcome.php");
                        }
                    } else{
                        // Display an error message if username doesn't exist
                        $username_err = "No account found with that username.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                
    
                // Close statement
                $stmt->close();
            }
            // Close connection
            $db_connection->close();
        }
        

    } else{
        header("Location: ./index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        form input {
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        form button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            display: inline;
            margin-right: 10px;
        }

        .footer-columns {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-column {
            flex: 1;
            padding: 0 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Paft Property Portal</h1>
</header>

<main>
    <div class="container">
        <h2>Sign In</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
                <label for="user" class="form-label">Username</label>
                <input type="user" class="form-control" id="user" name="user">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
        <p>Don't have an account? <a href="signup.html">Sign up</a></p>
    </div>
</main>

<footer>
    <div class="container footer-columns">
        <div class="footer-column">
            <div class="footer-links">
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="https://www.maps.ie/site-map.htm">Sitemap</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-column">
            <div class="footer-links">
                <ul>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">Join Our Team</a></li>
                    <li><a href="#">Agent Zone</a></li>
                    <li><a href="Testimonial.html">Reviews</a></li>
                    <li><a href="#">Agency Products</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <p>&copy; 2024 Paft Properties. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>
