<?php
include ("connection.php");

// Check if form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password

    // Photo Upload Handling
    $target_dir = "uploads/";
    $default_photo = $target_dir . "profile.jpg"; // Default photo path

    // Check if a photo is uploaded
    if (!empty($_FILES['student_photo']['name'])) {
        $student_photo = $_FILES['student_photo']['name'];
        $target_file = $target_dir . basename($student_photo);

        // Try to move the uploaded file
        if (move_uploaded_file($_FILES["student_photo"]["tmp_name"], $target_file)) {
            $photo_path = $target_file;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload student photo']);
            exit;
        }
    } else {
        // If no photo is uploaded, use the default photo
        $photo_path = $default_photo;
    }

    // SQL query to insert the data into the database
    $query = "INSERT INTO students (student_photo, student_id, first_name, last_name, gender, phone, email, year_level, course, username, password)
              VALUES ('$photo_path', '$student_id', '$first_name', '$last_name', '$gender', '$phone', '$email', '$year_level', '$course', '$username', '$password')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Student has been successfully registered']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to register student in the database']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
