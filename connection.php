<?php
$servername = "localhost";
$username = "root";
$password = "";
$redirectPage = "404.php"; // Specify the page to redirect to if no connection

try {
    $conn = new PDO("mysql:host=$servername;dbname=gis_database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    // Redirect to the error page if connection fails
    header("Location: $redirectPage");
    exit(); // Stop the script after redirection
}
?>
