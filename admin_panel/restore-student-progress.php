<?php
// Database connection
include ("connection.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get student ID
    $student_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Delete query
    $query = "UPDATE students SET status='unarchived'
  
    WHERE id = $student_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>