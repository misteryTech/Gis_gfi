<?php
// Include database connection
require 'connection.php';

// Start session to retrieve encoder info
session_start();

// Get the encoder's user ID from the session
$encoder_id = $_SESSION['id'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student ID from the form
    $student_id = $_POST['student_id'];

    // Get subject IDs, grades, and remarks from the form
    $subject_ids = $_POST['subject_ids'];
    $grades = $_POST['grades'];  // Grades are stored as strings
    $remarks = $_POST['remarks'];
    $remarks = $_POST['unit'];

    // Log the data for debugging purposes
    $logData = "Logging grades before insert:\n";
    for ($i = 0; $i < count($grades); $i++) {
        $logData .= "Subject ID: " . htmlspecialchars($subject_ids[$i]) . ", Grade: " . htmlspecialchars($grades[$i]) . ", Remarks: " . htmlspecialchars($remarks[$i]) . "\n";
    }
    file_put_contents('grades_log.txt', $logData, FILE_APPEND);  // Write to a log file

    // Prepare SQL to insert grades into the database
    $insert_query = "INSERT INTO encoded_grades_table (student_id, subject_id, grade, remarks, encoder_id) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($insert_query);

    // Loop through the subjects and insert each student's grade and remarks
    for ($i = 0; $i < count($subject_ids); $i++) {
        $subject_id = $subject_ids[$i];
        $grade = $grades[$i];  // Get grade as string from the form
        $remark = $remarks[$i];

        // Bind parameters:
        // 'i' for integer (student_id, subject_id), 's' for string (grade and remarks), 'i' for encoder_id, 'd' for decimal (grade)
        $stmt->bind_param("iidsi", $student_id, $subject_id, $grade, $remark, $encoder_id);

        // Debugging: Log formatted grade before insertion
        error_log("Formatted Grade: " . var_export($grade, true));
        $logData = "Logging formatted grade before insert:\n";
        $logData .= "Formatted Grade: " . $grade . "\n";
        file_put_contents('grades_log.txt', $logData, FILE_APPEND);  // Log to file

        // Execute the statement
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
