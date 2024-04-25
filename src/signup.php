<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

//start the session
session_start();


require './functions.php';
require_once("../../../../mysql_connect.php");
$error = '';

//if the user got onto signup.php through a form, then proceed. else redirect them back to index.php
if (isset($_POST["submit"])) {
} else {
    header("Location: ./index.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paft Sign Up</title>
</head>

<body>
    <h2>Sign Up</h2>
    <form action="signup.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Sign Up">
    </form>
</body>

</html>