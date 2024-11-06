<?php
// Include database connection
require 'connection.php';

// Start session to retrieve encoder info
session_start();

// Check if the user is logged in and has a valid session
if (!isset($_SESSION['encoder_id'])) {
    // If not logged in, redirect to login page or show an error message
    header("Location: login.php");
    exit;
}

// Get the encoder's user ID from the session
$encoder_id = $_SESSION['encoder_id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student ID from the form
    $student_id = $_POST['student_id'];

    // Get subject IDs, grades, and remarks from the form
    $subject_ids = $_POST['subject_ids'];
    $grades = $_POST['grades'];
    $remarks = $_POST['remarks'];

    // Prepare SQL to insert grades into the database
    $insert_query = "INSERT INTO encoded_grades_table (student_id, subject_id, grade, remarks, encoder_id) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($insert_query);

    // Loop through the subjects and insert each student's grade and remarks
    for ($i = 0; $i < count($subject_ids); $i++) {
        $subject_id = $subject_ids[$i];
        $grade = $grades[$i];
        $remark = $remarks[$i];

        // Format the grade to ensure it has exactly 2 decimal places
        $formatted_grade = number_format($grade, 2, '.', ''); // Ensures 2 decimal places (e.g., 3 -> 3.00)

        // Bind parameters and execute the statement
        $stmt->bind_param("iiisi", $student_id, $subject_id, $formatted_grade, $remark, $encoder_id);
        $stmt->execute();
    }

    // Check if the query was successful
    if ($stmt->affected_rows > 0) {
        // Grades saved successfully, show alert and redirect
        echo "<script>
                alert('Grades saved successfully!');
                window.location.href = 'encoding_grade.php?student_id=$student_id';  // Redirect to the same page with student_id
              </script>";
    } else {
        // Error saving grades, show alert and stay on the page
        echo "<script>
                alert('Error saving grades.');
                window.history.back();
              </script>";
    }

    // Close the prepared statement
    $stmt->close();
}
?>
