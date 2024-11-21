<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $studentId = mysqli_real_escape_string($conn, $_POST['id']);

    // Update the encoder's status to 'archived'
    $query = "UPDATE students SET status = 'archive' WHERE student_id = '$studentId'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => "Encoder archived successfully."]);
    } else {
        echo json_encode(["error" => "Failed to archive encoder."]);
    }
} else {
    echo json_encode(["error" => "Invalid request."]);
}
?>
