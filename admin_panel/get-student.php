<?php
include("connection.php");

if (isset($_POST['id'])) {
    $student_id = $_POST['id'];
    $query = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $encoder = $result->fetch_assoc();
        echo json_encode($encoder);
    } else {
        echo json_encode(['error' => 'Encoder not found']);
    }
}
?>
