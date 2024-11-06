<?php
// Database connection
include("connection.php");
// Fetch all courses
$query = "SELECT id, course_name FROM course_table"; // Adjust table and column names as needed
$result = $conn->query($query);

$courses = array();
while($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($courses);

$conn->close();
?>
