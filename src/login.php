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
							
							setcookie("user",$user)

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
    <title>Login</title>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div>
                <label>Username</label>
                <input type="text" name="user" class="form-control" value="<?php echo $user; ?>">
            </div>    
            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="password_confirm" class="form-control">
                
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <span class="help-block"><?php echo $error; ?></span>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>  
    
</body>
</html>
