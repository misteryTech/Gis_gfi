<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gis_database";
$redirectPage = "404.php"; // Specify the page to redirect to if no connection

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    header("Location: $redirectPage");
    exit(); // Ensure script stops after redirection
}

?>
