<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);

    //start the session
    session_start();


    require './functions.php';
    $error = '';

    //if the user got onto login.php through a form, then proceed. else redirect them back to index.php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

        $user = sanitiseForm(trim($_POST["user"]))['username'];
        $password = sanitiseForm(trim($_POST['password']))['password'];
        $password_confirm = sanitiseForm(trim($_POST['password_confirm']))['password_confirm'];
    
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
            $sql = "SELECT username, password FROM users WHERE username = ?";
        }
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
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
        $mysqli->close();

    } else{
        header("Location: ./index.php");
    }

?>