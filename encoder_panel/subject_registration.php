<?php
include 'connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_subject'])) {
    // Fetch form data
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $subject_unit = mysqli_real_escape_string($conn, $_POST['subject_unit']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $curriculum = mysqli_real_escape_string($conn, $_POST['curriculum']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);

    // Insert into database
    $sql = "INSERT INTO subjects (subject_code, subject_name, unit, year, semester, curriculum, course, archive) 
            VALUES ('$subject_code', '$subject_name', '$subject_unit', '$year', '$semester', '$curriculum', '$course', '0')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Subject registered successfully!'); window.location.href = 'manage-subject.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
