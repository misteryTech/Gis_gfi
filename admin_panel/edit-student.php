<?php
include ("connection.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form data
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $year_level = $_POST['year_level'];
    $course = $_POST['course'];

    // Handle photo upload if provided
    $student_photo = $_FILES['student_photo']['name'];
    if ($student_photo) {
        $target_dir = "uploads/"; // Ensure this folder exists with write permissions
        $target_file = $target_dir . basename($student_photo);

        // Upload the file
        if (move_uploaded_file($_FILES["student_photo"]["tmp_name"], $target_file)) {
            // Update with new photo
            $query = "UPDATE students SET
                first_name = ?,
                last_name = ?,
                gender = ?,
                phone = ?,
                email = ?,
                year_level = ?,
                course = ?,
                student_photo = ?
                WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssssi", $first_name, $last_name, $gender, $phone, $email, $year_level, $course, $target_file, $student_id);
        }
    } else {
        // Update without changing the photo
        $query = "UPDATE students SET
            first_name = ?,
            last_name = ?,
            gender = ?,
            phone = ?,
            email = ?,
            year_level = ?,
            course = ?
            WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $first_name, $last_name, $gender, $phone, $email, $year_level, $course, $student_id);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Redirect after successful update
        header("Location: student-profile.php?student_id=" . $student_id);
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>
