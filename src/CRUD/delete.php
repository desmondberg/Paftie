<?php
session_start();
require("../../../../../mysql_connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST["id"]);
}
$id = $_POST["id"];
//escape to prevent injection
$id = mysqli_real_escape_string($db_connection, $_POST['id']);
// delete the row from the database
$sql = "DELETE FROM property WHERE address = '$id'";
mysqli_query($db_connection, $sql);
mysqli_close($db_connection);
if($_SESSION['permission']=='admin'){
    header("location: ../control_panel.php");
}else{
    header("location: ../edit_properties.php");
}
