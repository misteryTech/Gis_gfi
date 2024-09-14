<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get student ID
    $student_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Fetch student details
    $query = "SELECT * FROM students WHERE id = '$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
        echo json_encode($student);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Student not found']);
    }

    mysqli_close($conn);
}
?>
