<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $delete_sql = "DELETE FROM subjects WHERE id=$id";

    if (mysqli_query($conn, $delete_sql)) {
        echo "Subject deleted successfully";
    } else {
        echo "Error deleting subject: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
