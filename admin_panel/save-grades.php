<?php
include("header.php");
include ("connection.php");

// Get posted data
$student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;
$subject_ids = isset($_POST['subject_ids']) ? $_POST['subject_ids'] : [];
$grades = isset($_POST['grades']) ? $_POST['grades'] : [];
$status = "Encoded";

// Check if there are any subjects and grades to process
if ($student_id && !empty($subject_ids) && !empty($grades)) {
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO grades (student_id, subject_id, grade, status) VALUES (?, ?, ?, ?)");

    // Bind parameters and execute statement for each subject-grade pair
    foreach ($subject_ids as $index => $subject_id) {
        $grade = isset($grades[$index]) ? floatval($grades[$index]) : 0;
        $stmt->bind_param("iids", $student_id, $subject_id, $grade, $status);
        $stmt->execute();
    }

    // Close the prepared statement
    $stmt->close();

    // Success message and redirect
    echo "<script>
        alert('Successfully Encoded Grades');
        window.location.href = 'encode-grades.php?student_id=" . htmlspecialchars($student_id, ENT_QUOTES) . "';
    </script>";
} else {
    // Handle error when no data is provided
    echo "<script>
        alert('No subjects or grades were provided.');
        window.location.href = 'encode-grades.php';
    </script>";
}

// Close the database connection
mysqli_close($conn);
exit();
?>
