<?php
include ("connection.php");

// Check if form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $encoder_photo = $_FILES['encoder_photo']['name'];
    $encoder_id = mysqli_real_escape_string($conn, $_POST['encoder_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $status = "unarchive"; // Hash the password

    // Photo Upload Handling
    $target_dir = "upload_encoder/"; // Directory to store uploaded photos
    $target_file = $target_dir . basename($encoder_photo);

    // Check if the file has been uploaded successfully
    if (move_uploaded_file($_FILES["encoder_photo"]["tmp_name"], $target_file)) {

        // SQL query to insert the data into the database
        $query = "INSERT INTO encoder (encoder_photo, encoder_id, first_name, last_name, gender, phone, email, year_level, course, username, password, status)
                  VALUES ('$target_file', '$encoder_id', '$first_name', '$last_name', '$gender', '$phone', '$email', '$year_level', '$course', '$username', '$password', '$status')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'success', 'message' => 'encoder has been successfully registered']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to register encoder in the database']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload encoder photo']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
