<?php
require_once ("../../../../mysql_connect.php");
require_once ("session.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // validate if email is empty
    if (empty($email)) {
        $error .= '<p class="error">Please enter email.</p>';
    }

    // validate if password is empty
    if (empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }

    if (empty($error)) {
        // prepare and execute the SELECT query
        $stmt = $db_connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // get the user data from the database
            $row = $result->fetch_assoc();

            // verify the password
            if (password_verify($password, $row['password'])) {
                $_SESSION["userid"] = $row['id'];
                $_SESSION["user"] = $row;
                $_SESSION["name"] = $row['name'];

                // Redirect the user to welcome page
                header("location: welcome.php");
                exit;
            } else {
                $error .= '<p class="error">The password is not valid.</p>';
            }
        } else {
            $error .= '<p class="error">No User exist with that email address.</p>';
        }

        $stmt->close();
    }
    // Close connection
    mysqli_close($db_connection);

    // display errors (if any)
    if (!empty($error)) {
        display_error($error);
    }
}

function display_error($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Login</h2>
                    <p>Please fill in your email and password.</p>
                      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>    
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </div>
                        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>