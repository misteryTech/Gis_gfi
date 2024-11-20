<?php
// Include your database connection file
include 'connection.php';

// Check if the form is submitted
if (isset($_POST['submit_course'])) {
    // Get the form data
    $course_name = trim($_POST['course_name']);
    $department = trim($_POST['department']);
    $status = "unarchived"; // Default status

    // Validate form inputs (e.g., ensure non-empty values)
    if (empty($course_name) || empty($department)) {
        echo "<script>
                alert('All fields are required.');
                window.location.href = 'manage-course.php';
              </script>";
        exit();
    }

    // Prepare the SQL query
    $sql = "INSERT INTO course_table (course_name, department, status) VALUES (?, ?, ?)";

    // Prepare and bind parameters to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $course_name, $department, $status);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "<script>
                    alert('Course registered successfully!');
                    window.location.href = 'manage-course.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . htmlspecialchars($stmt->error) . "');
                    window.location.href = 'manage-course.php';
                  </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>
                alert('Error preparing statement: " . htmlspecialchars($conn->error) . "');
                window.location.href = 'manage-course.php';
              </script>";
    }

    // Close the database connection
    $conn->close();
}
?>
