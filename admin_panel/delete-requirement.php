<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if ID is set for deletion
if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $delete_sql = "DELETE FROM requirements WHERE id='$id'";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Requirement deleted successfully";
    } else {
        echo "Error deleting requirement: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
