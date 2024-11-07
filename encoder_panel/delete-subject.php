<?php
// Database connection
include ("connection.php");

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
