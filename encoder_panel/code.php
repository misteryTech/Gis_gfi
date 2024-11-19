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
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $student_status = mysqli_real_escape_string($conn, $_POST['student_status']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $status = "unarchived";

    // Initialize photo path
    $student_photo = "";

    // Photo Upload Handling
    if (isset($_FILES['student_photo']) && $_FILES['student_photo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Directory to store uploaded photos
        $student_photo = basename($_FILES['student_photo']['name']);
        $target_file = $target_dir . $student_photo;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate the image
        $check = getimagesize($_FILES['student_photo']['tmp_name']);
        if ($check === false) {
            echo "<script>
                    alert('File is not an image.');
                    window.history.back();
                  </script>";
            exit();
        }

        // Check if file size exceeds 2MB
        if ($_FILES['student_photo']['size'] > 2000000) {
            echo "<script>
                    alert('Sorry, your file is too large.');
                    window.history.back();
                  </script>";
            exit();
        }

        // Allow specific file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<script>
                    alert('Sorry, only JPG, JPEG, PNG, and GIF files are allowed.');
                    window.history.back();
                  </script>";
            exit();
        }

        // Move uploaded file
        if (!move_uploaded_file($_FILES['student_photo']['tmp_name'], $target_file)) {
            echo "<script>
                    alert('Sorry, there was an error uploading your file.');
                    window.history.back();
                  </script>";
            exit();
        }

        // Set the stored file path
        $student_photo = $target_file;
    }

    // SQL query to insert data into the database
    $query = "INSERT INTO students (student_photo, student_id, first_name, last_name, gender, phone, email, year_level, course, username, password, student_status, status)
              VALUES ('$student_photo', '$student_id', '$first_name', '$last_name', '$gender', '$phone', '$email', '$year_level', '$course', '$username', '$password', '$student_status', '$status')";
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
