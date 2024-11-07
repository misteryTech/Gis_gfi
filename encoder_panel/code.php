<?php
include ("connection.php");

// Check connection
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Check if form is submitted via POST
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
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $student_status = mysqli_real_escape_string($conn, $_POST['student_status']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password

    // Photo Upload Handling
    $target_dir = "uploads/"; // Directory to store uploaded photos
    $target_file = $target_dir . basename($student_photo);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a real image
    if(isset($_FILES["student_photo"])) {
        $check = getimagesize($_FILES["student_photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
            exit();
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, file already exists.']);
        exit();
    }

    // Check file size (limit to 2MB)
    if ($_FILES["student_photo"]["size"] > 2000000) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, your file is too large.']);
        exit();
    }

    // Allow only certain file formats (jpg, jpeg, png, gif)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
        exit();
    }

    // Try to upload file
    if ($uploadOk == 0) {
        echo "<script>
                alert('Sorry, your file was not uploaded.');
                window.history.back();
              </script>";
    } else {
        if (move_uploaded_file($_FILES["student_photo"]["tmp_name"], $target_file)) {
            // SQL query to insert the data into the database
            $query = "INSERT INTO students (student_photo, student_id, first_name, last_name, gender, phone, email, year_level, course, username, password, student_status)
                      VALUES ('$target_file', '$student_id', '$first_name', '$last_name', '$gender', '$phone', '$email', '$year_level', '$course', '$username', '$password', '$student_status')";
            $result = mysqli_query($conn, $query);
    
            if ($result) {
                echo "<script>
                        alert('Student registered successfully!');
                        window.history.back();
                      </script>";
            } else {
                echo "<script>
                        alert('Failed to register student.');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Sorry, there was an error uploading your file.');
                    window.history.back();
                  </script>";
        }
    }
?>
