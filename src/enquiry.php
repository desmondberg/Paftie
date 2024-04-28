<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <?php include("./header.php")?>
    <h2>Lease this property</h2>
    <div class="container">


        <form action="post">
            <button type="submit" class="btn btn-primary">Lease</button>
        </form>
    </div>
    <?php include("./footer.php")?>
</body>
</html>