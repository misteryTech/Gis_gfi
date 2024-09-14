<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);

    // Split the name into first and last name (if applicable)
    $name_parts = explode(' ', $student_name);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

    // Update query
    $query = "UPDATE students SET
                first_name = '$first_name',
                last_name = '$last_name',
                gender = '$gender',
                phone = '$phone',
                email = '$email',
                course = '$course'
              WHERE id = '$student_id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
