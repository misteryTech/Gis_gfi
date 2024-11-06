<?php


// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>