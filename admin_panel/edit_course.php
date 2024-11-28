<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $department = $_POST['department'];

    // Validate inputs
    if (!empty($course_id) && !empty($course_name) && !empty($department)) {
        // Update query
        $sql = "UPDATE course_table SET course_name = ?, department = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $course_name, $department, $course_id);

        if ($stmt->execute()) {
            // Redirect back with success message
            header("Location: manage-course.php?success=Course updated successfully");
        } else {
            // Redirect back with error message
            header("Location: manage-course.php?error=Error updating course");
        }
    } else {
        // Redirect back with validation error
        header("Location: manage-course.php?error=All fields are required");
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: manage-course.php");
    exit();
}
?>
