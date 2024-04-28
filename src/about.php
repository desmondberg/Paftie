<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us - Paft Property Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" type="text/css" rel="stylesheet">
<style>
.container {
    width: 80%;
    margin: 0 auto;
}

header h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

header p {
    font-size: 18px;
    line-height: 1.6;
}


.footer-columns {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.footer-column {
    flex: 1;
    padding: 0 10px;
}

.footer-links ul {
    list-style-type: none;
    padding: 0;
}

.footer-links ul li {
    display: inline;
}

.footer-links ul li:not(:last-child) {
    margin-right: 15px;
}

.footer-links ul li a {
    color: #fff; 
    text-decoration: none;
}

.site-footer {
    background-color: #2c3e50; 
    padding: 20px 0;
}

.social-icons {
    list-style-type: none;
    padding: 0;
}

.social-icons li {
    display: inline;
}

.social-icons li:not(:last-child) {
    margin-right: 10px;
}

.social-icons li a {
    color: #fff; 
    text-decoration: none;
}

.social-icons li a i {
    font-size: 20px;
    vertical-align: middle;
}
</style>
</head>
<body>

<?php include("./header.php")?>
<div class="container">
        <h1>About Us</h1>
        <p>Welcome to Paft Properties, your premier destination for finding your perfect home. We understand that searching for the ideal property can be overwhelming, which is why we've created a seamless platform to simplify the process. Whether you're in pursuit of a cozy apartment, a charming family house, or a luxurious estate, our comprehensive database caters to all preferences and budgets. Backed by cutting-edge technology and a dedicated team, we strive to provide unparalleled assistance in your quest for the perfect abode. At Paft Properties, we're not just about listings; we're about helping you find your place to call home.</p>
</div>
<?php include("./footer.php")?>
</body>
</html>
