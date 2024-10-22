<?php
// submit_grade_request.php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "gis_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

$student_id = $_SESSION['student_id'];
$year = $_POST['year'];
$id = $_POST['id'];

// Prepared statement to insert the grade request into the database
$stmt = $conn->prepare("INSERT INTO grade_access_requests_db (student_id, year, status, user_id) VALUES (?, ?, ?, ?)");
$status = 'pending';
$stmt->bind_param("issi", $student_id, $year, $status, $id);

if ($stmt->execute()) {
    // If the insertion is successful, redirect to the 'encode-grades.php' page
    header('Location: ../request_grade_form.php');
    exit();
} else {
    // Output error message as JSON
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
