
<?php
//we dont actually need this script as we've already got an admin user
require_once ("../../../../mysql_connect.php");

//admin details
$name = "Paft";
$email = "paftadmin.ie";
$password = "Paft-Control-2024";
$permission = "admin";

// hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);
// prepare and execute the SQL statement to insert the user

$stmt = $db_connection->prepare("INSERT INTO users (name, email, password, permission)
VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password_hash, $permission);
$result = $stmt->execute();
if ($result) {
    echo "Admin user added
successfully.";
} else {
    echo "Error adding admin user: " . $stmt->error;
}
$stmt->close();
$db_connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
