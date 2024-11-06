<?php
// Include your database connection file
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['submit_course'])) {
    // Get the form data
    $course_name = $_POST['course_name'];
    $department = $_POST['department'];

    // Prepare the SQL query
    $sql = "INSERT INTO course_table (course_name, department) VALUES (?, ?)";

    // Prepare and bind parameters to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $course_name, $department);

 // Execute the query and check if it was successful
if ($stmt->execute()) {
    echo "<script>
            alert('Course registered successfully!');
            window.location.href = 'manage-subject.php'; // Replace 'manage-subject.php' with the actual page you want to redirect to
          </script>";
} else {
    echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'manage-subject.php'; // Replace 'manage-subject.php' with the actual page you want to redirect to
          </script>";
}


        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
