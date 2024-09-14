<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gis_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    // Return a JSON response indicating failure to connect to the database
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Check if form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $student_photo = $_FILES['student_photo']['name'];
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);

    // Photo Upload Handling
    $target_dir = "uploads/"; // Directory to store uploaded photos
    $target_file = $target_dir . basename($student_photo);

    // Check if the file has been uploaded successfully
    if (move_uploaded_file($_FILES["student_photo"]["tmp_name"], $target_file)) {

        // SQL query to insert the data into the database
        $query = "INSERT INTO students (student_photo, student_id, first_name, last_name, gender, phone, email, year_level, course)
                  VALUES ('$target_file', '$student_id', '$first_name', '$last_name', '$gender', '$phone', '$email', '$year_level', '$course')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            // Success response
            echo json_encode(['status' => 'success', 'message' => 'Student has been successfully registered']);
        } else {
            // Error response for SQL failure
            echo json_encode(['status' => 'error', 'message' => 'Failed to register student in the database']);
        }

    } else {
        // Error response for file upload failure
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload student photo']);
    }

} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
