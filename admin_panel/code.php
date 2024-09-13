<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gis_database";
$redirectPage = "404.php"; // Specify the page to redirect to if no connection

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    header("Location: $redirectPage");
    exit(); // Ensure script stops after redirection
}



// Check if form is submitted
if (isset($_POST['student_registration'])) {

    // Get form data
    $student_photo = $_FILES['student_photo']['name']; // Assuming the form is uploading a photo
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
    move_uploaded_file($_FILES["student_photo"]["tmp_name"], $target_file);

    // SQL query to insert the data into the database
    $query = "INSERT INTO students (student_photo, student_id, first_name, last_name, gender, phone, email, year_level, course)
              VALUES ('$target_file', '$student_id', '$first_name', '$last_name', '$gender', '$phone', '$email', '$year_level', '$course')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "<script>
                swal('Registration Successful!', 'Student has been successfully registered.', 'success')
                .then(() => window.location = 'dashboard.php');
              </script>";
    } else {
        echo "<script>
                swal('Registration Failed!', 'There was an error registering the student.', 'error')
                .then(() => window.location = 'register_student.php');
              </script>";
    }
}





?>