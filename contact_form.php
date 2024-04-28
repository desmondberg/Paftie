<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["subject"]) && isset($_POST["message"]) && isset($_POST["name"]) && isset($_POST["mobile"]) && isset($_POST["email"]) &&
        !empty($_POST["subject"]) && !empty($_POST["message"]) && !empty($_POST["name"]) && !empty($_POST["mobile"]) && !empty($_POST["email"])) {
        
        $subject = htmlspecialchars($_POST["subject"]);
        $message = htmlspecialchars($_POST["message"]);
        $name = htmlspecialchars($_POST["name"]);
        $mobile = htmlspecialchars($_POST["mobile"]);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        
        $servername = "localhost"; 
        $username = "your_username"; 
        $password = "your_password";
        $dbname = "your_database"; 

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO contacts (user, text) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $message);

        if ($stmt->execute()) {
            echo "Message submitted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all required fields.";
    }
}
?>
