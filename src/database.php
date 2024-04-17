 <!DOCTYPE html>
<html>
   <head>
    <title>Database Connection</title>
      <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>

<?php

// initiate connection, open database connection 

require ("../../../../mysql_connect.php");

$query = "SELECT first_name, last_name, postcode FROM customers";
$result = mysqli_query($db_connection, $query);

if ($result !== false) {
    echo "<table>";
    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Postcode</th></tr></thead>";
    echo "<tbody>";
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($rows as $row) {
        echo "<tr>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["postcode"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo mysqli_error($db_connection);
}

mysqli_free_result($result);
mysqli_close($db_connection);


?>

</body>
</html>