<?php
// archive_subject.php
include 'connection.php'; // Include your database connection

if (isset($_POST['id'])) {
    $subjectId = $_POST['id'];

    // Single query to update the archive status
    $sql = "UPDATE subjects SET archive = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subjectId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to archive"]);
    }

    $stmt->close();
    $conn->close();
}
?>
