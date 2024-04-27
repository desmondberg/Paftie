<?php

//errors directive
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

print_r($_SESSION);

require("../../../../mysql_connect.php");


if (isset($_COOKIE['user'])) {
	echo "<!DOCTYPE html>
				<html>
				<head>
				<style>
				textarea {
				  resize: none;
				}
				</style>
				</head>
					<body>
					
					<form method='post' class='mt-5' novalidate>
						<p><label for='submit'>Testimonial to submit</label></p>
						<textarea id='submit'  name='submit' rows='10' cols='50' placeholder='Enter text here...'></textarea>
						
						<button type='submit' class='btn btn-primary'>Submit</button>
					</form>
					
					</body>
				</html>";
} else {
	echo "please sign in to submit a testimonial";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['submit'])) {
		$row = "";

		$input = trim($_POST['submit']); // remove empty spaces
		$input = strip_tags($input); // html and php tags removed
		$input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // convert anything bad to html characters

		$sql = "SELECT email FROM users WHERE username = ?";

		if ($stmt = $db_connection->prepare($sql)) {
			$stmt->bind_param("s", $_COOKIE['user']);
			// Attempt to execute the prepared statement
			if ($stmt->execute()) {

				// Store result
				$stmt->store_result();

				// Check if email exists
				if ($stmt->num_rows == 1) {
					// Bind result variables
					$stmt->bind_result($row);
					if ($stmt->fetch()) {
						echo $row;

						$sql = $db_connection->prepare("INSERT INTO testimonials(user_email, text) VALUES(?, ?);");
						$sql->bind_param("ss", $row, $input);
						$sql->execute();

						echo "<h4>submitted!<h4>
								<form action='index.php'>
								<button type='submit' class='btn btn-primary'>Return</button>
								</form>";
					}
				} 
				else {

				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
		}

		var_dump($query);
		// Attempt to execute the prepared statement
		if ($result = $query->execute()) {
			// Store result
			$result->store_result();
			$result->bind_result($row);
		}
		$row = $result->fetch_assoc();
	} else {
		echo "no testimonial??";
	}
}
