<?php
include("connection.php");

// Check connection
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle-name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $student_status = mysqli_real_escape_string($conn, $_POST['student_status']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['student_id']), PASSWORD_DEFAULT); // Hash the password


    // Optional: You can set a default status and created_at timestamp
    $status = 'unarchived'; // Default status (could be 'active' or 'inactive')
    $created_at = date("Y-m-d H:i:s");  // Timestamp for record creation

    // SQL query to insert data into the students table
    $query = "INSERT INTO students (student_id, first_name,middle_name,last_name, year_level, course, student_status, status, date_registered, password)
              VALUES ('$student_id', '$first_name', '$middle_name', '$last_name', '$year_level', '$course', '$student_status', '$status', '$created_at', '$password')";

    // Execute the query
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
                alert('Student registered successfully!');
                window.location.href = 'manage-students.php'; // Redirect to a success page
              </script>";
    } else {
        echo "<script>
                alert('Failed to register student.');
                window.history.back();
              </script>";
    }
}
?>
