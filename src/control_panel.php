<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    include("./header.php");
    ?>
    <form action="./index.php">
        <button type="submit" class="btn btn-primary">Back to main page</button>
    </form>
    <?php
    include("./footer.php")
    ?>

</body>

</html>