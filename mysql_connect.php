<?php
//put in the root folder above anything else

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Xampp Database Connection
//change to your own credentials
//YOU NEED TO CREATE YOUR OWN COPY OF THE PAFT DATABASE!
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', ''); // enter your password
define('DB_NAME', 'Paft'); //enter your DB_Name (same as student login)

//Knuth Database Connection

//define('DB_HOST', 'localhost');
//define('DB_USER', 's3091317'); //enter your username
//define('DB_PASSWORD', 'rectrali'); // enter your password
//define('DB_NAME', 's3091317'); //enter your DB_Name (same as student login)

// create connection


$db_connection = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Could not connect to MySQL! " . mysqli_connect_error());
if (!mysqli_select_db($db_connection, DB_NAME)) die("Unable to select database: " . mysqli_error($db_connection));


