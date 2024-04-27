<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);

//start the session
session_start();


require './functions.php';
require_once("../../../../mysql_connect.php");
$error = '';

//if the user got onto signup.php through a form, then proceed. else redirect them back to index.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sanitised = sanitiseForm($_POST);

    //var_dump($sanitised);

    $user = trim($sanitised['username']);
    $email = trim($sanitised['email']);
    $password = trim($sanitised['password']);
    $password_confirm =  trim($sanitised['password_confirm']);
    $permission = $_POST["permission"];

    // validate if email is empty
    if (empty($user)) {
        $error .= '<p class="error">Please enter your username.</p>';
    }

    if (empty($password)) {
        $error .= '<p class="error">Please enter password.</p>';
    }

    if ($password !== $password_confirm) {
        $error .= '<p class="error">The password and the password confirmation don\'t match.</p>';
    }

    if (empty($error)) {
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        //check if the username or email already exists in the database
        $check = "SELECT * FROM users WHERE username = '$user' OR email = '$email'";
        $result = $db_connection->query($check);
        if ($result->num_rows > 0) {
            echo "this username or email already exists!";
        } else {
            // Insert user data into the database
            $insert_query = "INSERT INTO users (username, email, password, permission) VALUES ('$user', '$email', '$hashed_pass','$permission')";
            if ($db_connection->query($insert_query)) {
                echo "Sign up successful";
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $user;
                $_SESSION["permission"] = $permission;


                header("Location: ./index.php");
            } else {
                echo "error: " . $insert_query . "<br>" . $db_connection->$error;
            }
        }
       
    } else {

        
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            position: relative;
            min-height: 100%;
        }

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
            position: absolute;
            bottom: 0;
            width: 100%;
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
        <nav>
            <div class="title">
                <img src="../assets/paft_logo.png" height=50 alt="">
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Sign Up</h2>
            <form action="signup.php" method="post">
                <div class="mb-3">
                    <label for="user" class="form-label">Username</label>
                    <input type="text" name="user" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                </div>
                <div class="form-group">
                  <label for="permission">Account Type</label>
                  <select class="form-control" name="permission" id="">
                    <option>tenant</option>
                    <option>landlord</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
            <p>Already have an account? <a href="Signin.php">Sign in</a></p>
        </div>
    </main>
    <?php
    include("./footer.php")
    ?>
    <script src="./scripts/show_password.js"></script>  

    <!-- <footer>
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
</footer> -->

</body>

</html>