<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $studentId = intval($_POST['id']); // Sanitize input to prevent SQL injection

    // Update student status to "archived"
    $query = "UPDATE students SET status='archived' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $studentId);

    if ($stmt->execute()) {
        echo "success"; // Send success response
    } else {
        echo "error"; // Send error response
    }

    $stmt->close();
    $conn->close();
} else {
    echo "invalid"; // Invalid request
}
?>
