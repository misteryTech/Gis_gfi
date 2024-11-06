<?php
include("connection.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_code = $_POST['subject_code'];

    // Prepare the SQL statement to check for existing subject code
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM subjects WHERE subject_code = ? ");
    $stmt->bind_param("s", $subject_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Return JSON response
    echo json_encode(['exists' => $row['count'] > 0]);
}
?>
