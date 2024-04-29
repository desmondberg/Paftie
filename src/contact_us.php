<?php
//errors directive
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

//print_r($_SESSION);

require('./functions.php');
require("../../../../mysql_connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["subject"]) && isset($_POST["message"]) && isset($_POST["name"]) && isset($_POST["mobile"]) && isset($_POST["email"]) &&
        !empty($_POST["subject"]) && !empty($_POST["message"]) && !empty($_POST["name"]) && !empty($_POST["mobile"]) && !empty($_POST["email"])) {
        
        $subject = htmlspecialchars($_POST["subject"]);
        $message = htmlspecialchars($_POST["message"]);
        $name = htmlspecialchars($_POST["name"]);
        $mobile = htmlspecialchars($_POST["mobile"]);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        $sql = "INSERT INTO contacts (user, text) VALUES (?, ?)";

        $stmt = $db_connection->prepare($sql);
        $stmt->bind_param("ss", $email, $message);

        if ($stmt->execute()) {
            echo "Message submitted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $db_connection->error;
        }

        $stmt->close();
        $db_connection->close();
    } else {
        echo "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7f6; 
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
    }

    p {
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
    }

    select,
    textarea,
    input[type="text"],
    input[type="tel"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #3498db; 
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2980b9; 
    }
</style>
</head>
<body>

<div class="container">
    <h1>How can we help you?</h1>
    <p>Need assistance, have an enquiry, a request, or simply want to submit an idea?<br>We'd love to hear from you.</p>
    <form method="post" action="contact_us.php" id="contactForm">
        <div class="form-group">
            <label for="subject">Subject:</label>
            <select id="subject" name="subject">
                <option value="General Enquiry">General Enquiry</option>
                <option value="Assistance">Assistance</option>
                <option value="Enquiry">Enquiry</option>
                <option value="Request">Request</option>
                <option value="Idea Submission">Idea Submission</option>
            </select>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile Number:</label>
            <input type="tel" id="mobile" name="mobile" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

<!-- <script>
    document.getElementById("contact_form.php").addEventListener("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);
    
        console.log("Form Data:", formData);
        
        alert("Your message has been submitted!");
    });
</script> -->

</body>
</html>
