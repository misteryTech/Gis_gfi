<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Basic validation
    if (empty($student_id)) {
        echo json_encode(['error' => 'Student ID is required.']);
        exit;
    }

    // Update query
    $update_query = "UPDATE students SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        gender = '$gender', 
        phone = '$phone', 
        email = '$email', 
        student_status = '$status',
        course = '$course'";

    // Add password to the query if provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $update_query .= ", password = '$hashed_password'";
    }

    $update_query .= " WHERE student_id = '$student_id'";

    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['success' => 'Student details updated successfully.']);
    } else {
        echo json_encode(['error' => 'Error updating student details.']);
    }
}
?>
